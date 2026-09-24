<?php

include '../layouts/header.php';
include '../layouts/sidebar.php';

?>
<div id="page-overview" class="page-content">
    <h1 class="text-2xl md:text-3xl font-bold text-primary mb-6">داشبورد</h1>

    <!-- بخش تایمر مطالعه -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <!-- کارت زمان کل هفته -->
        <div class="chart-card bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-blue-700">
                    <svg class="icon inline-block ml-1" aria-hidden="true"><use href="icons/sprite.svg#icon-clock"/></svg>
                    زمان کل برنامه این هفته
                </h3>
                <span class="text-3xl font-black text-blue-600"></span>
            </div>
            <div class="flex gap-4 text-sm">
                <div class="bg-white px-4 py-2 rounded-lg shadow-sm">
                    <span class="font-bold text-blue-600"></span>
                    <span class="text-gray-500">جلسه</span>
                </div>
                <div class="bg-white px-4 py-2 rounded-lg shadow-sm">
                    <span class="font-bold text-green-600"></span>
                    <span class="text-gray-500">روز</span>
                </div>
            </div>
        </div>

        <!-- کارت درس فعلی -->
        <div class="chart-card 'bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-100' : 'bg-gray-50 border-2 border-gray-100' ?>">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-green-700">
                            <svg class="icon inline-block ml-1" aria-hidden="true"><use href="icons/sprite.svg#icon-book"/></svg>
                            درس فعلی (همین الان)
                        </h3>
                        <p class="text-gray-500 text-sm mt-1"></p>
                    </div>
                    <span class="text-2xl">📚</span>
                </div>
                
                <div class="mb-4">
                    <div class="text-2xl font-bold text-gray-800 mb-1"></div>
                        <div class="text-sm text-gray-600"></div>
                        <span class="inline-block mt-2 px-3 py-1 bg-white rounded-full text-xs font-bold text-gray-600 border">
                        </span>
                </div>

                <!-- دکمه شروع مطالعه -->
                <button id="startStudyBtn" 
                        data-subject=""
                        data-time="45"
                        class="w-full py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
                <div class="text-center py-6">
                    <h3 class="text-lg font-bold text-gray-600">الان وقت مطالعه نیست</h3>
                    <p class="text-gray-500 text-sm mt-2">برنامه بعدی شما فردا یا بعد از این زمان است</p>
                </div>
        </div>
    </div>

    <!-- تایمر در حال اجرا -->
    <div id="studyTimerSection" class="hidden chart-card bg-gradient-to-r from-indigo-500 to-purple-600 text-white mb-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-sm opacity-80">در حال مطالعه:</div>
                    <div id="currentSubject" class="text-xl font-bold">-</div>
                </div>
            </div>
            
            <div class="text-center">
                <div id="timerDisplay" class="text-5xl font-black tracking-wider">45:00</div>
                <div class="text-sm opacity-80 mt-1">زمان باقیمانده</div>
            </div>
            
            <div class="flex gap-2">
                <button id="pauseTimerBtn" class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg font-bold transition">
                    ⏸️ توقف
                </button>
                <button id="stopTimerBtn" class="px-4 py-2 bg-red-500 hover:bg-red-600 rounded-lg font-bold transition">
                    🛑 پایان
                </button>
            </div>
        </div>
        
        <!-- پروگرس بار -->
        <div class="mt-4 bg-white/20 rounded-full h-2 overflow-hidden">
            <div id="progressBar" class="bg-white h-full rounded-full transition-all duration-1000" style="width: 0%"></div>
        </div>
    </div>

    <!-- آمار کلی -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat-card-modern stat-blue">
            <!-- <div class="stat-icon">
                <svg class="icon" aria-hidden="true"><use href="icons/sprite.svg#icon-users"/></svg>
            </div> -->
            <div class="stat-info">
                <div id="stat-students" class="stat-value"><?= $exam_count ?></div>
                <div class="stat-label">آزمون ها</div>
            </div>
        </div>
        <div class="stat-card-modern stat-accent">
            <!-- <div class="stat-icon">
                <svg class="icon" aria-hidden="true"><use href="icons/sprite.svg#icon-clipboard"/></svg>
            </div> -->
            <div class="stat-info">
                <div id="stat-exams" class="stat-value"><?= $avg_percentage ?>%</div>
                <div class="stat-label">میانگین درصد</div>
            </div>
        </div>
        <div class="stat-card-modern stat-danger">
            <!-- <div class="stat-icon">
                <svg class="icon" aria-hidden="true"><use href="icons/sprite.svg#icon-x"/></svg>
            </div> -->
            <div class="stat-info">
                <div id="stat-noexam" class="stat-value"><?= $weakest_sub[0]['percentage'] ?? 0 ?>%</div>
                <div class="stat-label"><?= $weakest_sub[0]['subject'] ?? '-' ?></div>
            </div>
        </div>
        <div class="stat-card-modern stat-warning">
            <!-- <div class="stat-icon">
                <svg class="icon" aria-hidden="true"><use href="icons/sprite.svg#icon-chart-bar"/></svg>
            </div> -->
            <div class="stat-info">
                <div id="stat-pending" class="stat-value"><?= $strong_sub[0]['percentage'] ?? 0 ?>%</div>
                <div class="stat-label"><?= $strong_sub[0]['subject'] ?? '-' ?></div>
            </div>
        </div>
    </div>

     <!-- <div class="chart-card mb-6">
        <h3 class="text-lg font-bold text-gray-700 mb-4">
            <svg class="icon inline-block ml-1" aria-hidden="true"><use href="icons/sprite.svg#icon-check"/></svg>
            مطالعه امروز
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-xl p-4 text-white">
                <div id="todayStudyTime" class="text-2xl font-bold">0:00</div>
                <div class="text-sm opacity-80">زمان مطالعه</div>
            </div>
            <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl p-4 text-white">
                <div id="todaySessions" class="text-2xl font-bold">0</div>
                <div class="text-sm opacity-80">جلسات تکمیل شده</div>
            </div>
            <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl p-4 text-white">
                <div id="todaySubjects" class="text-2xl font-bold">0</div>
                <div class="text-sm opacity-80">درس مطالعه شده</div>
            </div>
            <div class="bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl p-4 text-white">
                <div id="weeklyProgress" class="text-2xl font-bold">0%</div>
                <div class="text-sm opacity-80">پیشرفت هفتگی</div>
            </div>
        </div>
    </div> 

     <div class="chart-card">
        <h2 class="chart-card-title">
            <svg class="icon text-primary" aria-hidden="true"><use href="../icons/sprite.svg#icon-chart-bar"/></svg>
            برنامه هفتگی
        </h2>
        <div id="avgChart" class="flex flex-wrap" style="min-height: 280px;">
        </div>
    </div>  -->
</div>

<!-- جاوااسکریپت تایمر -->
<script>
    // متغیرهای تایمر
    let studyTimer = null;
    let totalSeconds = 45 * 60; // 45 دقیقه
    let remainingSeconds = totalSeconds;
    let isPaused = false;
    let todayStudySeconds = 0;
    let completedSessions = 0;
    let studiedSubjects = new Set();

    // المان‌های DOM
    const startBtn = document.getElementById('startStudyBtn');
    const timerSection = document.getElementById('studyTimerSection');
    const timerDisplay = document.getElementById('timerDisplay');
    const currentSubject = document.getElementById('currentSubject');
    const progressBar = document.getElementById('progressBar');
    const pauseBtn = document.getElementById('pauseTimerBtn');
    const stopBtn = document.getElementById('stopTimerBtn');

    // شروع تایمر
    if (startBtn) {
        startBtn.addEventListener('click', function() {
            const subject = this.dataset.subject;
            const time = parseInt(this.dataset.time);
            
            totalSeconds = time * 60;
            remainingSeconds = totalSeconds;
            isPaused = false;
            
            currentSubject.textContent = subject;
            timerSection.classList.remove('hidden');
            
            startTimer();
        });
    }

    // تابع تایمر
    function startTimer() {
        studyTimer = setInterval(function() {
            if (!isPaused) {
                remainingSeconds--;
                todayStudySeconds++;
                
                // آپدیت نمایش
                const mins = Math.floor(remainingSeconds / 60);
                const secs = remainingSeconds % 60;
                timerDisplay.textContent = `${mins}:${secs.toString().padStart(2, '0')}`;
                
                // آپدیت پروگرس بار
                const progress = ((totalSeconds - remainingSeconds) / totalSeconds) * 100;
                progressBar.style.width = progress + '%';
                
                // ذخیره در localStorage
                localStorage.setItem('todayStudySeconds', todayStudySeconds);
                
                // آپدیت آمار امروز
                updateTodayStats();
                
                // پایان تایمر
                if (remainingSeconds <= 0) {
                    clearInterval(studyTimer);
                    completedSessions++;
                    studiedSubjects.add(currentSubject.textContent);
                    
                    // صدای آلارم
                    playAlarm();
                    
                    // ذخیره جلسه تکمیل شده
                    saveCompletedSession();
                    
                    alert('🎉 تبریک! جلسه مطالعه به پایان رسید!');
                    hideTimer();
                }
            }
        }, 1000);
    }

    // توقف موقت
    if (pauseBtn) {
        pauseBtn.addEventListener('click', function() {
            isPaused = !isPaused;
            this.textContent = isPaused ? '▶️ ادامه' : '⏸️ توقف';
        });
    }

    // پایان تایمر
    if (stopBtn) {
        stopBtn.addEventListener('click', function() {
            if (confirm('آیا می‌خواهید مطالعه را متوقف کنید؟')) {
                clearInterval(studyTimer);
                
                // ذخیره بخشی از جلسه
                if (todayStudySeconds > 60) {
                    savePartialSession();
                }
                
                hideTimer();
            }
        });
    }

    // مخفی کردن تایمر
    function hideTimer() {
        timerSection.classList.add('hidden');
        remainingSeconds = totalSeconds;
        todayStudySeconds = 0;
        localStorage.setItem('todayStudySeconds', 0);
        updateTodayStats();
    }

    // آپدیت آمار امروز
    function updateTodayStats() {
        const storedSeconds = parseInt(localStorage.getItem('todayStudySeconds') || '0');
        const totalSec = storedSeconds + todayStudySeconds;
        
        const hours = Math.floor(totalSec / 3600);
        const mins = Math.floor((totalSec % 3600) / 60);
        
        document.getElementById('todayStudyTime').textContent = 
            hours > 0 ? `${hours}:${mins.toString().padStart(2, '0')}` : `${mins}:${(totalSec % 60).toString().padStart(2, '0')}`;
        
        document.getElementById('todaySessions').textContent = 
            completedSessions + parseInt(localStorage.getItem('completedSessions') || '0');
        
        document.getElementById('todaySubjects').textContent = studiedSubjects.size;
        
        // پیشرفت هفتگی (کل جلسات هفته)
        const weeklyTotal = <?= $sessionCount ?>;
        const completed = completedSessions + parseInt(localStorage.getItem('completedSessions') || '0');
        const progress = weeklyTotal > 0 ? Math.round((completed / weeklyTotal) * 100) : 0;
        document.getElementById('weeklyProgress').textContent = progress + '%';
    }

    // پخش صدای آلارم
    // پخش صدای آلارم - نسخه نهایی
function playAlarm() {
    // ۱. پخش صدای بیپ
    try {
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        
        // سه بار بیپ
        const beep = (freq, delay) => {
            setTimeout(() => {
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                
                osc.frequency.value = freq;
                osc.type = 'square';
                
                gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
                
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.3);
            }, delay);
        };
        
        beep(880, 0);    // اولین بیپ
        beep(880, 400);  // دومین بیپ
        beep(1100, 800); // سومین بیپ (فرکانس بالاتر)
        
    } catch (e) {
        console.log('خطا در پخش صدا:', e);
    }
    
    // ۲. ویبره موبایل
    if (navigator.vibrate) {
        navigator.vibrate([500, 200, 500, 200, 500]);
    }
    
    // ۳. نوتیفیکیشن (در صورت مجوز)
    if (Notification.permission === 'granted') {
        new Notification('🎉 جلسه مطالعه به پایان رسید!', {
            body: 'تبریک! ۴۵ دقیقه مطالعه کردید 💪',
            icon: '/icons/celebration.png',
            tag: 'study-complete'
        });
    }
}