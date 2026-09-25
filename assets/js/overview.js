/**
 * Overview page — stat cards, trend chart, student info.
 */
const { default: API } = await import(`${window.APP_CONFIG.assetUrl}/js/api.js`);
import { getStudentId, getUserInfo } from './app.js';
import { toJalali } from './date.js';

export async function load() {
    const el = (id) => document.getElementById(id);
    const show = (id) => { el(id)?.classList.remove('hidden'); };
    const hide = (id) => { el(id)?.classList.add('hidden'); };
    const setText = (id, v) => { const e = el(id); if (e) e.textContent = v ?? '-'; };

    hide('overviewContent');
    hide('overviewError');
    show('overviewLoading');

    const sid = getStudentId();
    const user = getUserInfo();
    let trendChart = null;

    try {
        setText('overviewStudentName', user?.full_name ?? 'دانش‌آموز');

        const [datesRes, statsRes] = await Promise.all([
            API.get(`/exams/dates?student_id=${sid}`),
            API.get(`/students/${sid}/analytics/subject-stats`),
        ]);

        const dates = datesRes.data?.dates ?? [];
        const subjects = statsRes.data?.subjects ?? [];

        /* Total exams & avg percentage */
        const examCount = dates.length;
        const totalAvg = dates.reduce((s, d) => s + parseFloat(d.avg_percentage || 0), 0);
        const avgScore = examCount > 0 ? (totalAvg / examCount).toFixed(1) : '0.0';

        setText('ovExamCount', examCount);
        setText('ovAvgPercentage', `${avgScore}%`);

        /* Strongest / weakest from subject-stats */
        const sorted = [...subjects].sort((a, b) => (b.avg_percentage ?? 0) - (a.avg_percentage ?? 0));
        if (sorted.length > 0) {
            setText('ovStrongest', `${sorted[0].subject} (${parseFloat(sorted[0].avg_percentage).toFixed(1)}%)`);
            const last = sorted[sorted.length - 1];
            setText('ovWeakest', `${last.subject} (${parseFloat(last.avg_percentage).toFixed(1)}%)`);
        } else {
            setText('ovStrongest', '-');
            setText('ovWeakest', '-');
        }

        /* Student grade/field from stats */
        const student = statsRes.data?.student;
        if (student) {
            const grade = student.grade ? `پایه ${student.grade}` : '';
            const field = student.field ?? '';
            setText('overviewStudentGrade', [grade, field].filter(Boolean).join(' — '));
            setText('overviewAvatarLetter', student.name?.[0] ?? 'ف');
        }

        /* Trend chart — sort dates asc for chart */
        const sortedDates = [...dates].sort((a, b) => a.exam_date.localeCompare(b.exam_date));
        const labels = sortedDates.map(d => toJalali(d.exam_date));
        const values = sortedDates.map(d => parseFloat(d.avg_percentage || 0));

        const chartContainer = document.getElementById('overviewTrendChart');
        const chartEmpty = document.getElementById('overviewTrendEmpty');

        if (values.length > 0 && chartContainer) {
            chartContainer.style.display = 'block';
            if (chartEmpty) chartEmpty.classList.add('hidden');

            if (trendChart) trendChart.destroy();

            const options = {
                chart: { type: 'line', height: 250, toolbar: { show: false }, fontFamily: 'inherit' },
                series: [{ name: 'میانگین درصد', data: values }],
                xaxis: { categories: labels, labels: { show: true, rotate: -45, style: { fontSize: '11px' } } },
                yaxis: { max: 100, labels: { formatter: v => v + '%' } },
                stroke: { curve: 'smooth', width: 2, colors: ['#445D84'] },
                fill: { type: 'gradient', gradient: { shadeIntensity: 0.3, opacityFrom: 0.6, opacityTo: 0.1 } },
                markers: { size: 4, colors: ['#445D84'] },
                tooltip: { y: { formatter: v => v + '%' } },
                dataLabels: { enabled: false },
                grid: { borderColor: '#e5e7eb' },
                colors: ['#445D84'],
            };

            trendChart = new ApexCharts(chartContainer, options);
            trendChart.render();
        } else if (chartEmpty) {
            chartEmpty.classList.remove('hidden');
            if (chartContainer) chartContainer.style.display = 'none';
        }

        hide('overviewLoading');
        show('overviewContent');

    } catch (err) {
        console.error('overview error', err);
        hide('overviewLoading');
        show('overviewError');
        if (el('ovRetryBtn')) el('ovRetryBtn').onclick = load;
    }
}
