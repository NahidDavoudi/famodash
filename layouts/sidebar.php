<?php
?>
<!-- Sidebar -->
<aside id="sidebar" class="flex flex-col w-64 h-screen bg-gray-900 text-white">
    <!-- Header -->
    <div class="p-6 border-b border-white/10 flex items-center gap-3">
        <div class="bg-white/10 w-12 h-12 rounded-xl flex items-center justify-center shadow-md">
                <img src="../assets/logo.png" alt="لوگو" class="w-8 h-8 object-contain">
        </div>
        <div>
            <h2 class="font-bold text-lg">پنل کاربری</h2>
            <p id="desktopUsername" class="text-sm text-white/70"><?php echo($name) ?></p>
        </div>
    </div>

    <!-- Nav -->
    <nav class="p-3 flex-1 overflow-y-auto space-y-1">
        <a href="?page=dashboard" data-page="dashboard" class="flex items-center gap-2 px-3 py-2 rounded-lg <?= $current_page == 'dashboard' ? 'bg-gray-800 text-white' : 'text-white/70 hover:bg-gray-800 hover:text-white' ?>">
            <svg class="icon w-5" aria-hidden="true"><use href="../assets/icons/sprite.svg#icon-chart-bar"/></svg>
            <span>داشبورد</span>
        </a>
        <a href="?page=results" data-page="results" class="flex items-center gap-2 px-3 py-2 rounded-lg <?= $current_page == 'results' ? 'bg-gray-800 text-white' : 'text-white/70 hover:bg-gray-800 hover:text-white' ?>">
            <svg class="icon w-5" aria-hidden="true"><use href="../assets/icons/sprite.svg#icon-clipboard"/></svg>
            <span>نتایج آزمون</span>
        </a>
        <a href="?page=plan" data-page="plan" class="flex items-center gap-2 px-3 py-2 rounded-lg <?= $current_page == 'plan' ? 'bg-gray-800 text-white' : 'text-white/70 hover:bg-gray-800 hover:text-white' ?>">
            <svg class="icon w-5" aria-hidden="true"><use href="../assets/icons/calendar.svg"/></svg>
            <span>برنامه هفتگی</span>
        </a>
        <!--<a href="?page=files" data-page="files" class="flex items-center gap-2 px-3 py-2 rounded-lg <?= $current_page == 'files' ? 'bg-gray-800 text-white' : 'text-white/70 hover:bg-gray-800 hover:text-white' ?>">-->
        <!--    <svg class="icon w-5" aria-hidden="true"><use href="../icons/sprite.svg#icon-clipboard"/></svg>-->
        <!--    <span>فایل آزمون ها</span>-->
        <!--</a>-->
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-white/10">
        <a href="logout.php" id="logoutBtn" class="flex items-center gap-2 px-3 py-2 rounded-lg text-red-400 hover:text-white hover:bg-red-500/20">
            <svg class="icon w-5" aria-hidden="true"><use href="../assets/icons/sprite.svg#icon-logout"/></svg>
            <span>خروج</span>
        </a>
    </div>
</aside>