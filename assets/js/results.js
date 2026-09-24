/**
 * Results page — exam dates list + in-page detail drill-down with charts.
 */
import API from '../../../shared/js/api.js';
import { getStudentId } from './app.js';
import { toJalaliLong, jalaliMonthKey, jalaliMonthLabel } from './date.js';

let _allDates = [];
let _monthFilter = '';
let _barChart = null;
let _donutChart = null;

export async function load() {
    const el = (id) => document.getElementById(id);
    const show = (id) => el(id)?.classList.remove('hidden');
    const hide = (id) => el(id)?.classList.add('hidden');

    /* always start on the list view */
    show('resultsListView');
    hide('resultsDetailView');
    const backBtn = el('resultsBackBtn');
    if (backBtn) backBtn.onclick = backToList;

    hide('resultsContent');
    hide('resultsEmpty');
    hide('resultsError');
    show('resultsLoading');

    const sid = getStudentId();

    try {
        const res = await API.get(`/exams/dates?student_id=${sid}`);
        _allDates = res.data?.dates ?? [];

        hide('resultsLoading');

        if (_allDates.length === 0) {
            show('resultsEmpty');
            return;
        }

        renderDateCards(_allDates);
        populateMonthFilter(_allDates);
        show('resultsContent');

        /* month filter (Jalali) */
        const filter = el('resultsMonthFilter');
        if (filter) {
            filter.onchange = () => {
                _monthFilter = filter.value;
                const filtered = _monthFilter
                    ? _allDates.filter(d => jalaliMonthKey(d.exam_date) === _monthFilter)
                    : _allDates;
                renderDateCards(filtered);
            };
            el('resultsClearFilter').onclick = () => {
                filter.value = '';
                _monthFilter = '';
                renderDateCards(_allDates);
            };
        }

    } catch (err) {
        console.error('results error', err);
        hide('resultsLoading');
        show('resultsError');
        if (el('resultsRetryBtn')) el('resultsRetryBtn').onclick = load;
    }
}

function renderDateCards(dates) {
    const container = document.getElementById('resultsCards');
    if (!container) return;

    if (dates.length === 0) {
        container.innerHTML = `<div class="col-span-full text-center py-10 text-muted-foreground">هیچ آزمونی در این بازه یافت نشد.</div>`;
        return;
    }

    container.innerHTML = dates.map(d => `
        <div class="card card-sm cursor-pointer result-card" data-date="${d.exam_date}">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-bold text-primary">${toJalaliLong(d.exam_date)}</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-muted-foreground">میانگین:</span>
                <span class="text-lg font-bold ${parseFloat(d.avg_percentage) < 30 ? 'text-danger' : 'text-success'}">${d.avg_percentage}%</span>
            </div>
            <div class="text-xs text-muted-foreground mt-1">${d.subject_count} درس</div>
        </div>
    `).join('');

    container.querySelectorAll('.result-card').forEach(card => {
        card.addEventListener('click', () => loadDetails(card.dataset.date));
    });
}

function populateMonthFilter(dates) {
    const select = document.getElementById('resultsMonthFilter');
    if (!select) return;
    const seen = new Map();
    dates.forEach(d => {
        const key = jalaliMonthKey(d.exam_date);
        if (key && !seen.has(key)) seen.set(key, jalaliMonthLabel(d.exam_date));
    });
    const keys = [...seen.keys()].sort().reverse();
    select.innerHTML = '<option value="">همه ماه‌ها</option>' +
        keys.map(k => `<option value="${k}">${seen.get(k)}</option>`).join('');
}

function backToList() {
    document.getElementById('resultsDetailView')?.classList.add('hidden');
    document.getElementById('resultsListView')?.classList.remove('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

async function loadDetails(date) {
    const sid = getStudentId();
    const el = (id) => document.getElementById(id);

    try {
        const res = await API.get(`/exams/details?exam_date=${date}&student_id=${sid}`);
        const data = res.data;
        if (!data || !data.subjects) return;

        const subjects = data.subjects;
        const avg = data.avg_percentage;
        const student = data.student;

        el('examDetailsTitle').textContent = `جزئیات آزمون — ${toJalaliLong(date)}`;
        el('examDetailsSubtitle').textContent = student
            ? `${student.name} | پایه ${student.grade} ${student.field} | میانگین این آزمون: ${avg}%`
            : `میانگین این آزمون: ${avg}%`;

        /* subjects table */
        const sorted = [...subjects].sort((a, b) => (b.percentage ?? 0) - (a.percentage ?? 0));
        let tableRows = sorted.map(s => {
            const pct = parseFloat(s.percentage || 0);
            const cls = pct >= 50 ? 'text-success' : pct >= 30 ? 'text-warning' : 'text-danger';
            return `<tr class="exam-detail-row">
                <td data-label="درس" class="exam-detail-subject">${s.subject}</td>
                <td data-label="فصل" class="text-muted-foreground exam-detail-chapter">${s.chapter ?? '-'}</td>
                <td data-label="تعداد سوال" class="font-medium">${s.total_q}</td>
                <td data-label="درست" class="text-success font-medium">${s.correct}</td>
                <td data-label="غلط" class="text-danger">${s.wrong}</td>
                <td data-label="نزده" class="text-muted-foreground">${s.skipped}</td>
                <td data-label="درصد" class="font-bold ${cls} exam-detail-percent">${pct.toFixed(1)}%</td>
            </tr>`;
        }).join('');

        let html = `
        <div class="table-wrap exam-details-table-wrap mb-6">
            <table class="w-full responsive-table exam-details-table">
                <thead>
                    <tr>
                        <th>درس</th>
                        <th>فصل</th>
                        <th>تعداد سوال</th>
                        <th>درست</th>
                        <th>غلط</th>
                        <th>نزده</th>
                        <th>درصد</th>
                    </tr>
                </thead>
                <tbody>${tableRows}</tbody>
            </table>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="exam-chart-panel"><h4 class="exam-chart-title">درصد هر درس</h4>
                <div id="chartBar" class="exam-chart exam-bar-chart"></div></div>
            <div class="exam-chart-panel"><h4 class="exam-chart-title">ترکیب پاسخ‌ها</h4>
                <div class="flex items-center justify-center">
                    <div id="chartDonut" class="exam-chart exam-donut-chart"></div>
                </div>
            </div>
        </div>`;

        el('examDetailsContent').innerHTML = html;

        /* bar chart */
        const barOpts = {
            chart: {
                type: 'bar',
                height: Math.max(220, sorted.length * 42),
                toolbar: { show: false },
                fontFamily: 'Vazirmatn, sans-serif',
                parentHeightOffset: 0,
                background: 'transparent',
            },
            series: [{ name: 'درصد', data: sorted.map(s => parseFloat(s.percentage || 0)) }],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '42%',
                    borderRadius: 4,
                    borderRadiusApplication: 'end',
                },
            },
            dataLabels: {
                enabled: true,
                offsetY: -5,
                formatter: value => `${Number(value).toFixed(0)}%`,
                style: { colors: ['#2a3a52'], fontSize: '10px', fontWeight: 600 },
                background: { enabled: false },
            },
            colors: ['#445d84'],
            fill: { opacity: 0.92 },
            xaxis: {
                categories: sorted.map(s => s.subject),
                labels: {
                    show: true,
                    rotate: -35,
                    rotateAlways: false,
                    hideOverlappingLabels: false,
                    trim: true,
                    maxHeight: 64,
                    style: { colors: '#404040', fontSize: '10px', fontWeight: 500 },
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: {
                min: 0,
                max: 100,
                tickAmount: 4,
                labels: { formatter: value => `${value}%`, style: { colors: '#737373', fontSize: '10px' } },
            },
            grid: { show: false, padding: { top: 14, right: 4, bottom: 8, left: 4 } },
            tooltip: { theme: 'light', y: { formatter: v => `${Number(v).toFixed(1)}%` } },
        };
        if (_barChart) { _barChart.destroy(); _barChart = null; }
        _barChart = new ApexCharts(document.getElementById('chartBar'), barOpts);
        _barChart.render();

        /* donut chart */
        const totals = subjects.reduce((acc, s) => {
            acc.correct += +(s.correct || 0);
            acc.wrong += +(s.wrong || 0);
            acc.skipped += +(s.skipped || 0);
            return acc;
        }, { correct: 0, wrong: 0, skipped: 0 });

        const donutOpts = {
            chart: { type: 'donut', height: 220, fontFamily: 'Vazirmatn, sans-serif', background: 'transparent' },
            series: [totals.correct, totals.wrong, totals.skipped],
            labels: ['درست', 'غلط', 'نزده'],
            colors: ['#059669', '#dc2626', '#a3a3a3'],
            stroke: { width: 3, colors: ['#fff'] },
            dataLabels: { enabled: false },
            plotOptions: {
                pie: {
                    donut: {
                        size: '72%',
                        labels: {
                            show: true,
                            name: { show: true, offsetY: 19, color: '#737373', fontSize: '11px' },
                            value: { show: true, offsetY: -8, color: '#2a3a52', fontSize: '24px', fontWeight: 700, formatter: v => v },
                            total: { show: true, showAlways: true, label: 'کل سوالات', color: '#737373', fontSize: '11px', formatter: w => w.globals.seriesTotals.reduce((a, b) => a + b, 0) },
                        },
                    },
                },
            },
            tooltip: { theme: 'light', y: { formatter: v => `${v} سوال` } },
            legend: { position: 'bottom', horizontalAlign: 'center', fontSize: '11px', markers: { width: 8, height: 8, radius: 8 }, itemMargin: { horizontal: 8, vertical: 0 } },
        };
        if (_donutChart) { _donutChart.destroy(); _donutChart = null; }
        _donutChart = new ApexCharts(document.getElementById('chartDonut'), donutOpts);
        _donutChart.render();

        document.getElementById('resultsListView').classList.add('hidden');
        document.getElementById('resultsDetailView').classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });

    } catch (err) {
        console.error('details error', err);
        alert('خطا در بارگذاری جزئیات آزمون');
    }
}
