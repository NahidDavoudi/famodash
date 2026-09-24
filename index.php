<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#445D84">
    <title>پنل کاربری - آموزشگاه فامو</title>
    <link rel="stylesheet" href="../shared/css/output.css">
    <link rel="stylesheet" href="../shared/css/fonts.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script src="../shared/js/libs/apexcharts.min.js"></script>
    <script src="../shared/js/libs/lucide.min.js"></script>
    <script src="../shared/js/lucide-adapter.js"></script>
    <script type="module" src="assets/js/app.js"></script>
</head>

<body>

<div id="sidebarOverlay" class="sidebar-overlay"></div>

<div id="mainPanel" class="hidden min-h-screen">
    <!-- Mobile Header -->
    <header id="mobileHeader">
        <button id="mobileMenuBtn" type="button" aria-label="فهرست">
            <i data-lucide="menu" class="icon w-6 h-6" aria-hidden="true"></i>
        </button>
        <h1 class="font-bold text-sm">پنل کاربری فامو</h1>
    </header>

    <!-- Sidebar -->
    <aside id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo-wrapper">
                <span class="sidebar-logo-text">ف</span>
            </div>
            <div>
                <h2 class="sidebar-title">پنل کاربری</h2>
                <p id="desktopUsername" class="sidebar-username"></p>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="#" data-page="overview" class="sidebar-link active">
                <i data-lucide="layout-dashboard" class="icon w-5" aria-hidden="true"></i>
                <span>داشبورد</span>
            </a>

            <a href="#" data-page="results" class="sidebar-link">
                <i data-lucide="clipboard-list" class="icon w-5" aria-hidden="true"></i>
                <span>نتایج آزمون</span>
            </a>

            <a href="#" data-page="files" class="sidebar-link">
                <i data-lucide="upload" class="icon w-5" aria-hidden="true"></i>
                <span>فایل‌های آزمون</span>
            </a>

            <a href="#" data-page="profile" class="sidebar-link">
                <i data-lucide="user-round" class="icon w-5" aria-hidden="true"></i>
                <span>پروفایل من</span>
            </a>
        </nav>

        <div class="sidebar-foot">
            <a href="#" id="logoutBtn" class="sidebar-link sidebar-link--danger">
                <i data-lucide="log-out" class="icon w-5" aria-hidden="true"></i>
                <span>خروج</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="main-inner">

            <div id="alertBox" class="alert-box hidden"></div>

            <!-- OVERVIEW PAGE -->
            <div id="page-overview" class="page-content">
                <div class="page-header">
                    <h1 class="page-title">
                        <i data-lucide="layout-dashboard" class="icon" aria-hidden="true"></i>
                        داشبورد
                    </h1>
                </div>

                <div id="overviewLoading" class="loading-state hidden">
                    <div class="loading-spinner"></div>
                    <p class="text-gray-500">در حال بارگذاری...</p>
                </div>

                <div id="overviewContent" class="hidden">

                    <!-- Stat Cards -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="stat-card-modern stat-blue">
                            <div class="stat-icon"><i data-lucide="clipboard-list" class="icon" aria-hidden="true"></i></div>
                            <div class="stat-info">
                                <div id="ovExamCount" class="stat-value">-</div>
                                <div class="stat-label">تعداد آزمون‌ها</div>
                            </div>
                        </div>
                        <div class="stat-card-modern stat-green">
                            <div class="stat-icon"><i data-lucide="trending-up" class="icon" aria-hidden="true"></i></div>
                            <div class="stat-info">
                                <div id="ovAvgPercentage" class="stat-value">-%</div>
                                <div class="stat-label">میانگین درصد</div>
                            </div>
                        </div>
                        <div class="stat-card-modern stat-warning">
                            <div class="stat-icon"><i data-lucide="zap" class="icon" aria-hidden="true"></i></div>
                            <div class="stat-info">
                                <div id="ovStrongest" class="stat-value">-</div>
                                <div class="stat-label">قوی‌ترین درس</div>
                            </div>
                        </div>
                        <div class="stat-card-modern stat-danger">
                            <div class="stat-icon"><i data-lucide="triangle-alert" class="icon" aria-hidden="true"></i></div>
                            <div class="stat-info">
                                <div id="ovWeakest" class="stat-value">-</div>
                                <div class="stat-label">ضعیف‌ترین درس</div>
                            </div>
                        </div>
                    </div>

                    <!-- Trend Chart -->
                    <div class="card">
                        <h3 class="chart-card-title">
                            <i data-lucide="chart-line" class="icon text-primary" aria-hidden="true"></i>
                            روند میانگین درصد
                        </h3>
                        <div id="overviewTrendChart" style="min-height:250px;width:100%"></div>
                        <div id="overviewTrendEmpty" class="hidden text-center py-10 text-muted-foreground">هنوز داده‌ای برای نمودار وجود ندارد.</div>
                    </div>
                </div>

                <div id="overviewError" class="error-state hidden">
                    <p class="text-danger">خطا در بارگذاری اطلاعات. <button id="ovRetryBtn" class="btn btn-sm btn-primary mt-2">تلاش مجدد</button></p>
                </div>
            </div>

            <!-- RESULTS PAGE -->
            <div id="page-results" class="page-content hidden">

                <!-- List view -->
                <div id="resultsListView">
                    <div class="page-header flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <h1 class="page-title">
                            <i data-lucide="clipboard-list" class="icon" aria-hidden="true"></i>
                            نتایج آزمون
                        </h1>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <select id="resultsMonthFilter" class="input input-sm"><option value="">همه ماه‌ها</option></select>
                            <button id="resultsClearFilter" class="btn btn-secondary btn-sm">پاک کردن فیلتر</button>
                        </div>
                    </div>

                    <div id="resultsLoading" class="loading-state hidden">
                        <div class="loading-spinner"></div>
                        <p class="text-gray-500">در حال بارگذاری آزمون‌ها...</p>
                    </div>

                    <div id="resultsContent" class="hidden">
                        <div id="resultsCards" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"></div>
                    </div>

                    <div id="resultsEmpty" class="error-state hidden">
                        <div class="text-center py-16">
                            <div class="w-20 h-20 rounded-full bg-surface-muted flex items-center justify-center mx-auto mb-4">
                                <i data-lucide="clipboard-list" class="icon text-3xl text-muted-foreground" aria-hidden="true"></i>
                            </div>
                            <h3 class="text-xl font-bold text-foreground mb-2">هنوز آزمونی ثبت نشده</h3>
                            <p class="text-muted-foreground">پس از برگزاری آزمون، نتایج در این بخش نمایش داده خواهد شد.</p>
                        </div>
                    </div>

                    <div id="resultsError" class="error-state hidden">
                        <p class="text-danger">خطا در بارگذاری نتایج. <button id="resultsRetryBtn" class="btn btn-sm btn-primary mt-2">تلاش مجدد</button></p>
                    </div>
                </div>

                <!-- Detail view (in-page drill-down) -->
                <div id="resultsDetailView" class="hidden">
                    <div class="page-header flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                        <h1 class="page-title">
                            <i data-lucide="clipboard-list" class="icon" aria-hidden="true"></i>
                            <span id="examDetailsTitle">جزئیات آزمون</span>
                        </h1>
                        <button id="resultsBackBtn" class="btn btn-secondary btn-sm flex items-center gap-2">
                            <i data-lucide="arrow-right" class="icon" aria-hidden="true"></i>
                            <span>بازگشت به لیست</span>
                        </button>
                    </div>
                    <p id="examDetailsSubtitle" class="text-sm text-muted-foreground mb-6"></p>
                    <div id="examDetailsContent" class="space-y-6"></div>
                </div>
            </div>

            <!-- FILES PAGE -->
            <div id="page-files" class="page-content hidden">
                <div class="page-header">
                    <h1 class="page-title">
                        <i data-lucide="upload" class="icon" aria-hidden="true"></i>
                        فایل‌های آزمون
                    </h1>
                </div>

                <div id="filesLoading" class="loading-state hidden">
                    <div class="loading-spinner"></div>
                    <p class="text-gray-500">در حال بارگذاری فایل‌ها...</p>
                </div>

                <div id="filesContent" class="hidden">
                    <div class="table-wrap">
                        <table class="w-full responsive-table">
                            <thead>
                                <tr>
                                    <th>نام فایل</th>
                                    <th>نوع</th>
                                    <th>حجم</th>
                                    <th>تاریخ آپلود</th>
                                    <th>توضیحات</th>
                                </tr>
                            </thead>
                            <tbody id="filesTbody"></tbody>
                        </table>
                    </div>
                </div>

                <div id="filesEmpty" class="error-state hidden">
                    <div class="text-center py-16">
                        <div class="w-20 h-20 rounded-full bg-surface-muted flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="upload" class="icon text-3xl text-muted-foreground" aria-hidden="true"></i>
                        </div>
                        <h3 class="text-xl font-bold text-foreground mb-2">فایلی یافت نشد</h3>
                        <p class="text-muted-foreground">در صورت آپلود فایل توسط تیم فامو، در این بخش قابل مشاهده خواهد بود.</p>
                    </div>
                </div>

                <div id="filesError" class="error-state hidden">
                    <p class="text-danger">خطا در بارگذاری فایل‌ها. <button id="filesRetryBtn" class="btn btn-sm btn-primary mt-2">تلاش مجدد</button></p>
                </div>
            </div>

            <!-- PROFILE PAGE -->
            <div id="page-profile" class="page-content hidden">
                <div class="page-header">
                    <h1 class="page-title">
                        <i data-lucide="user-round" class="icon" aria-hidden="true"></i>
                        پروفایل من
                    </h1>
                </div>

                <div id="profileLoading" class="loading-state hidden">
                    <div class="loading-spinner"></div>
                    <p class="text-gray-500">در حال بارگذاری...</p>
                </div>

                <div id="profileContent" class="hidden">
                    <div class="card card-lg mb-6">
                        <div class="flex items-center gap-6 mb-6">
                            <div class="profile-avatar"><span id="profileAvatarLetter">ف</span></div>
                            <div>
                                <h2 id="profileName" class="text-2xl font-bold text-primary">-</h2>
                                <p id="profileRole" class="text-sm text-muted-foreground">دانش‌آموز</p>
                            </div>
                        </div>
                        <hr class="mb-6">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="profile-field">
                                <dt>پایه تحصیلی</dt>
                                <dd id="profileGrade">-</dd>
                            </div>
                            <div class="profile-field">
                                <dt>رشته تحصیلی</dt>
                                <dd id="profileField">-</dd>
                            </div>
                            <div class="profile-field">
                                <dt>شماره تماس</dt>
                                <dd id="profilePhone">-</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div id="profileError" class="error-state hidden">
                    <p class="text-danger">خطا در بارگذاری پروفایل. <button id="profileRetryBtn" class="btn btn-sm btn-primary mt-2">تلاش مجدد</button></p>
                </div>
            </div>

        </div>
    </main>
</div>

</body>
</html>
