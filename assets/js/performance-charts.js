(function () {
    var API_BASE = window.PERFORMANCE_API_BASE || '../api/student-performance.php';
    var selectedSubjects = [];
    var overallChartInstance = null;
    var subjectChartInstance = null;
    var subjectsList = [];

    // ابزار تبدیل تاریخ میلادی به فارسی (جلالی)
    // برای اطمینان اگر کتابخانه‌ای مانند moment-jalaali یا روزنامه فارسی ندارید، این تابع جایگزین ساده‌ است:
    function toPersianDigits(str) {
        return (str + '').replace(/[0-9]/g, function (d) {
            return String.fromCharCode(d.charCodeAt(0) + 1728);
        });
    }
    // اگر تاریخ جلالی از سرور ارسال می‌شود نیاز به تبدیل ندارد، اما برای اطمینان رشته‌های تاریخ را فارسی می‌کنیم
    function formatPersianDate(dateStr) {
        // اگر تاریخ به صورت جلالی و رشته آماده باشد فقط اعداد را فارسی ‌می‌کنیم:
        return toPersianDigits(dateStr);
    }

    function fetchJson(url) {
        return fetch(url, { credentials: 'include' }).then(function (r) {
            if (!r.ok) throw new Error('Network error');
            return r.json();
        });
    }

    function renderOverallChart(data) {
        var el = document.getElementById('overallTrendChart');
        if (!el || typeof ApexCharts === 'undefined') return;
        // تاریخ‌های جلالی باید در آرایه categories قرار بگیرند
        var categories = data.map(function (d) { return formatPersianDate(d.date); });
        var seriesData = data.map(function (d) { return d.average; });
        if (overallChartInstance) {
            overallChartInstance.destroy();
            overallChartInstance = null;
        }
        var options = {
            chart: {
                type: 'line',
                height: 280,
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'Vazir, Tahoma, sans-serif'
            },
            series: [{ name: 'Average', data: seriesData }],
            stroke: { curve: 'smooth', width: 2.5 },
            xaxis: { categories: categories, labels: { rotate: -45 } },
            yaxis: {
                min: 0,
                max: 100,
                tickAmount: 5,
                labels: { formatter: function (v) { return v + '%'; } }
            },
            tooltip: { enabled: true, y: { formatter: function (v) { return v + '%'; } } },
            legend: { show: false },
            dataLabels: { enabled: false },
            grid: { borderColor: '#f3f4f6', xaxis: { lines: { show: false } }, yaxis: { lines: { show: true } } }
        };
        overallChartInstance = new ApexCharts(el, options);
        overallChartInstance.render();
    }

    function renderSubjectChart(series, categories) {
        var wrap = document.getElementById('subjectTrendChartWrap');
        var emptyEl = document.getElementById('subjectTrendEmpty');
        var el = document.getElementById('subjectTrendChart');
        if (!el || typeof ApexCharts === 'undefined') return;
        if (!series || series.length === 0) {
            if (wrap) wrap.classList.add('hidden');
            if (emptyEl) emptyEl.classList.remove('hidden');
            return;
        }
        if (wrap) wrap.classList.remove('hidden');
        if (emptyEl) emptyEl.classList.add('hidden');
        if (subjectChartInstance) {
            subjectChartInstance.destroy();
            subjectChartInstance = null;
        }
        // اطمینان از فارسی بودن تاریخ‌های محور x
        var persianCategories = Array.isArray(categories) ? categories.map(formatPersianDate) : categories;
        var options = {
            chart: {
                type: 'line',
                height: 280,
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'Vazir, Tahoma, sans-serif'
            },
            series: series,
            stroke: { curve: 'smooth', width: 2 },
            xaxis: { categories: persianCategories, labels: { rotate: -45 } },
            yaxis: {
                min: 0,
                max: 100,
                tickAmount: 5,
                labels: { formatter: function (v) { return v + '%'; } }
            },
            tooltip: { shared: true, y: { formatter: function (v) { return v + '%'; } } },
            legend: { show: true, position: 'top', horizontalAlign: 'center' },
            dataLabels: { enabled: false },
            grid: { borderColor: '#f3f4f6', xaxis: { lines: { show: false } }, yaxis: { lines: { show: true } } }
        };
        subjectChartInstance = new ApexCharts(el, options);
        subjectChartInstance.render();
    }

    function buildSubjectSeriesFromApi(response) {
        var allDates = [];
        var bySubject = {};
        var i, j, d, sub, dateToIndex;
        for (i = 0; i < response.length; i++) {
            sub = response[i].subject;
            bySubject[sub] = { name: sub, data: [] };
            for (j = 0; j < response[i].data.length; j++) {
                d = response[i].data[j];
                if (allDates.indexOf(d.date) === -1) allDates.push(d.date);
            }
        }
        allDates.sort();
        dateToIndex = {};
        for (i = 0; i < allDates.length; i++) dateToIndex[allDates[i]] = i;
        for (sub in bySubject) {
            var arr = response.find(function (r) { return r.subject === sub; });
            var dataByDate = {};
            if (arr && arr.data) {
                for (j = 0; j < arr.data.length; j++) {
                    dataByDate[arr.data[j].date] = arr.data[j].score;
                }
            }
            bySubject[sub].data = allDates.map(function (dt) { return dataByDate[dt] != null ? dataByDate[dt] : null; });
        }
        return {
            series: Object.keys(bySubject).map(function (k) { return { name: bySubject[k].name, data: bySubject[k].data }; }),
            categories: allDates // بعداً در renderSubjectChart فارسی خواهند شد
        };
    }

    function updateSubjectTrend() {
        if (selectedSubjects.length === 0) {
            renderSubjectChart(null, null);
            return;
        }
        var q = 'subjects=' + selectedSubjects.map(encodeURIComponent).join(',');
        fetchJson(API_BASE + '?action=subject-trend&' + q).then(function (response) {
            var built = buildSubjectSeriesFromApi(response);
            renderSubjectChart(built.series, built.categories);
        }).catch(function () {
            renderSubjectChart(null, null);
        });
    }

    function toggleSubjectTag(name, btn) {
        var idx = selectedSubjects.indexOf(name);
        if (idx === -1) {
            selectedSubjects.push(name);
            btn.classList.add('ring-2', 'ring-offset-1', 'ring-[#445D84]', 'opacity-100');
            btn.classList.remove('opacity-60');
        } else {
            selectedSubjects.splice(idx, 1);
            btn.classList.remove('ring-2', 'ring-offset-1', 'ring-[#445D84]', 'opacity-100');
            btn.classList.add('opacity-60');
        }
        updateSubjectTrend();
    }

    function renderSubjectTags() {
        var container = document.getElementById('subjectTagsContainer');
        if (!container) return;
        container.innerHTML = '';
        subjectsList.forEach(function (s) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'subject-tag-btn px-3 py-1.5 rounded-lg text-sm font-medium transition opacity-60 border-2 cursor-pointer';
            btn.style.backgroundColor = s.tag_color || '#e5e7eb';
            btn.style.color = '#fff';
            btn.style.borderColor = s.tag_color || '#d1d5db';
            btn.textContent = s.name;
            btn.addEventListener('click', function () { toggleSubjectTag(s.name, btn); });
            container.appendChild(btn);
        });
    }

    function init() {
        fetchJson(API_BASE + '?action=average-trend').then(function (data) {
            if (data && data.length > 0) {
                renderOverallChart(data);
            } else {
                var el = document.getElementById('overallTrendChart');
                if (el) el.innerHTML = '<p class="text-gray-500 text-sm py-8 text-center">No exam data yet.</p>';
            }
        }).catch(function () {
            var el = document.getElementById('overallTrendChart');
            if (el) el.innerHTML = '<p class="text-gray-500 text-sm py-8 text-center">Could not load trend data.</p>';
        });

        fetchJson(API_BASE + '?action=subjects').then(function (data) {
            subjectsList = Array.isArray(data) ? data : [];
            renderSubjectTags();
        }).catch(function () {
            subjectsList = [];
            renderSubjectTags();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
