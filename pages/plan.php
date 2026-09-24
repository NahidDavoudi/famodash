<style>
/* استایل‌های برنامه هفتگی */
.schedule-container {
    overflow-x: auto;
    padding: 10px;
}

.schedule-table {
    width: 100%;
    min-width: 900px;
    border-collapse: separate;
    border-spacing: 8px;
}

.schedule-table th {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    padding: 16px 12px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 14px;
    color: #475569;
    text-align: center;
    border: 1px solid #e2e8f0;
}

.schedule-table th.day-header {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
    font-size: 15px;
}

.time-cell {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    padding: 12px 8px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 12px;
    color: #64748b;
    text-align: center;
    min-width: 90px;
    border: 1px solid #e2e8f0;
    white-space: nowrap;
}

.schedule-cell {
    min-height: 80px;
    padding: 8px;
    border-radius: 12px;
    background: #fff;
    border: 1px solid #f1f5f9;
    transition: all 0.2s ease;
}

.schedule-cell:hover {
    border-color: #cbd5e1;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.schedule-cell.empty {
    background: #fafafa;
    border: 1px dashed #e2e8f0;
}

/* کارت برنامه */
.plan-card {
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 6px;
    border-right: 4px solid;
    transition: all 0.2s ease;
}

.plan-card:hover {
    transform: translateX(2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.plan-card:last-child {
    margin-bottom: 0;
}

.plan-subject {
    font-weight: 700;
    font-size: 13px;
    margin-bottom: 4px;
}

.plan-topic {
    font-size: 11px;
    color: #64748b;
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.plan-title {
    display: inline-block;
    font-size: 10px;
    padding: 2px 8px;
    border-radius: 10px;
    background: rgba(255,255,255,0.7);
    font-weight: 600;
}

/* رنگ‌های برنامه */
.plan-mint { background: #d1fae5; border-color: #10b981; }
.plan-mint .plan-subject { color: #065f46; }

.plan-blue { background: #dbeafe; border-color: #3b82f6; }
.plan-blue .plan-subject { color: #1e40af; }

.plan-navy { background: #e0e7ff; border-color: #4f46e5; }
.plan-navy .plan-subject { color: #312e81; }

.plan-green { background: #dcfce7; border-color: #22c55e; }
.plan-green .plan-subject { color: #166534; }

.plan-indigo { background: #e0e7ff; border-color: #6366f1; }
.plan-indigo .plan-subject { color: #3730a3; }

.plan-lavender { background: #f3e8ff; border-color: #a855f7; }
.plan-lavender .plan-subject { color: #6b21a8; }

.plan-default { background: #f3f4f6; border-color: #6b7280; }
.plan-default .plan-subject { color: #374151; }

/* هدر صفحه */
.schedule-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 15px;
}

.student-info-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.85));
    border-radius: 16px;
    padding: 16px 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    gap: 16px;
}

.student-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 700;
    color: #1e40af;
}

.student-details h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.student-details p {
    font-size: 13px;
    color: #64748b;
    margin: 4px 0 0 0;
}

/* لیست روزانه */
.daily-schedule {
    display: none;
}

@media (max-width: 768px) {
    .schedule-table {
        display: none;
    }
    
    .daily-schedule {
        display: block;
    }
    
    .day-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .day-card-header {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 12px;
        font-weight: 700;
        color: #1e40af;
        font-size: 15px;
    }
    
    .day-plan-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 8px;
        border-right: 4px solid;
    }
    
    .day-plan-item:last-child {
        margin-bottom: 0;
    }
    
    .day-plan-time {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        min-width: 80px;
    }
    
    .day-plan-content {
        flex: 1;
    }
    
    .day-plan-subject {
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 4px;
    }
    
    .day-plan-topic {
        font-size: 12px;
        color: #64748b;
    }
    
    .day-plan-title {
        display: inline-block;
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 10px;
        background: rgba(255,255,255,0.7);
        margin-top: 6px;
    }
}

/* Empty state */
.empty-schedule {
    text-align: center;
    padding: 60px 20px;
    color: #64748b;
}

.empty-schedule svg {
    width: 80px;
    height: 80px;
    margin-bottom: 20px;
    color: #cbd5e1;
}

.empty-schedule h3 {
    font-size: 18px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 8px;
}

.empty-schedule p {
    font-size: 14px;
}
</style>

<!-- SCHEDULE PAGE -->
<div id="page-schedule" class="page-content">
    <div class="schedule-header">
        <h1 class="text-2xl md:text-3xl font-bold text-primary">برنامه هفتگی</h1>
        
        <?php if ($studentInfo): ?>
        <div class="student-info-card">
            <div class="student-avatar">
                <?= mb_substr($studentInfo['name'], 0, 1) ?>
            </div>
            <div class="student-details">
                <h3><?= htmlspecialchars($studentInfo['name']) ?></h3>
                <p>پایه <?= htmlspecialchars($studentInfo['grade']) ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <?php if (empty($weeklyPlan)): ?>
        <!-- حالت خالی -->
        <div class="chart-card">
            <div class="empty-schedule">
                <svg aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3>برنامه‌ای یافت نشد</h3>
                <p>در حال حاضر برنامه هفتگی برای شما تنظیم نشده است.</p>
            </div>
        </div>
    <?php else: ?>
    
        <!-- نمایش جدولی (دسکتاپ) -->
        <div class="chart-card schedule-container daily-schedule">
            <?php foreach ($dayNames as $dayIndex => $dayName): ?>
                <?php if (isset($scheduleByDay[$dayIndex]) && !empty($scheduleByDay[$dayIndex])): ?>
                    <div class="day-card">
                        <div class="day-card-header">
                            <?= $dayName ?>
                        </div>
                        <?php 
                        ksort($scheduleByDay[$dayIndex]);
                        foreach ($scheduleByDay[$dayIndex] as $timeIndex => $plan): 
                            $colorClass = 'plan-' . ($plan['color'] ?? 'default');
                        ?>
                            <div class="day-plan-item <?= $colorClass ?>">
                                <div class="day-plan-time">
                                    <?= htmlspecialchars($plan['time_label']) ?>
                                </div>
                                <div class="day-plan-content">
                                    <div class="day-plan-subject">
                                        <?= htmlspecialchars($plan['subject_name']) ?>
                                    </div>
                                    <?php if (!empty($plan['topic_label'])): ?>
                                        <div class="day-plan-topic">
                                            <?= htmlspecialchars($plan['topic_label']) ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($plan['title'])): ?>
                                        <span class="day-plan-title">
                                            <?= htmlspecialchars($plan['title']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        
        <!-- نمایش جدولی (موبایل) -->
        <div class="chart-card schedule-container">
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>زمان</th>
                        <?php foreach ($dayNames as $dayName): ?>
                            <th class="day-header"><?= $dayName ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($timeSlots as $timeIndex => $timeLabel): ?>
                        <tr>
                            <td class="time-cell"><?= htmlspecialchars($timeLabel) ?></td>
                            <?php foreach ($dayNames as $dayIndex => $dayName): ?>
                                <td class="schedule-cell <?= !isset($scheduleByDay[$dayIndex][$timeIndex]) ? 'empty' : '' ?>">
                                    <?php if (isset($scheduleByDay[$dayIndex][$timeIndex])): ?>
                                        <?php 
                                        $plan = $scheduleByDay[$dayIndex][$timeIndex];
                                        $colorClass = 'plan-' . ($plan['color'] ?? 'default');
                                        ?>
                                        <div class="plan-card <?= $colorClass ?>">
                                            <div class="plan-subject">
                                                <?= htmlspecialchars($plan['subject_name']) ?>
                                            </div>
                                            <?php if (!empty($plan['topic_label'])): ?>
                                                <div class="plan-topic" title="<?= htmlspecialchars($plan['topic_label']) ?>">
                                                    <?= htmlspecialchars($plan['topic_label']) ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($plan['title'])): ?>
                                                <span class="plan-title">
                                                    <?= htmlspecialchars($plan['title']) ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
    <?php endif; ?>
</div>