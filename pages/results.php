<style>
/* متغیرهای رنگی */
:root {
    --color-success: #16a34a;
    --color-success-light: #22c55e;
    --color-warning: #d97706;
    --color-warning-light: #f59e0b;
    --color-danger: #dc2626;
    --color-danger-light: #ef4444;
    --color-muted: #94a3b8;
    --color-muted-light: #6b7280;
}

/* تنظیمات پایه – کوچک‌تر شدن فونت کلی */
body {
    font-size: 14px;
}

/* استایل‌های کارت‌های آماری */
.stat-card-modern {
    background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.85));
    border-radius: 16px;
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}
.stat-card-modern:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}
.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.stat-icon svg {
    width: 24px;
    height: 24px;
}
.stat-blue .stat-icon {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
}
.stat-accent .stat-icon {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #166534;
}
.stat-danger .stat-icon {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
}
.stat-warning .stat-icon {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
}
.stat-info {
    flex: 1;
}
.stat-value {
    font-size: 20px;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
}
.stat-label {
    font-size: 12px;
    color: #64748b;
    font-weight: 600;
    margin-top: 2px;
}

/* کارت نمودار */
.chart-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.85));
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
}
.chart-card-title {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.chart-card-title svg {
    width: 20px;
    height: 20px;
}

/* ─── Bar Chart ─────────────────────────────── */
.bar-chart {
    display: flex;
    align-items: flex-end;
    justify-content: center;
    gap: 8px;
    height: 230px;
    padding: 10px 8px 0;
    border-bottom: 2px solid #e2e8f0;
    overflow-x: auto;
}
.bar-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    /* gap: 4px; */
    flex: 1;
    max-width: 70px;
    min-width: 40px;
    height: 100%;
    justify-content: flex-end;
}
.bar {
    width: 100%;
    border-radius: 8px 8px 0 0;
    position: relative;
    transition: transform 0.2s ease, filter 0.2s ease;
    animation: barGrow 0.6s ease both;
    min-height: 6px;
    cursor: pointer;
}
.bar.success {
    background: linear-gradient(to top, var(--color-success), var(--color-success-light));
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.35);
}
.bar.warning {
    background: linear-gradient(to top, var(--color-warning), var(--color-warning-light));
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35);
}
.bar.danger {
    background: linear-gradient(to top, var(--color-danger), var(--color-danger-light));
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
}
.bar:hover {
    transform: scaleY(1.04) translateY(-3px);
    filter: brightness(1.1);
}
.bar-value {
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 10px;
    font-weight: 700;
    color: #1e293b;
    white-space: nowrap;
}
.bar-label {
    font-size: 10px;
    color: #64748b;
    font-weight: 600;
    text-align: center;
    max-width: 70px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding-top: 4px;
}
@keyframes barGrow {
    from { transform: scaleY(0); transform-origin: bottom; }
    to { transform: scaleY(1); transform-origin: bottom; }
}
.bar-item:nth-child(1)  .bar { animation-delay: 0.05s; }
.bar-item:nth-child(2)  .bar { animation-delay: 0.10s; }
.bar-item:nth-child(3)  .bar { animation-delay: 0.15s; }
.bar-item:nth-child(4)  .bar { animation-delay: 0.20s; }
.bar-item:nth-child(5)  .bar { animation-delay: 0.25s; }
.bar-item:nth-child(6)  .bar { animation-delay: 0.30s; }
.bar-item:nth-child(7)  .bar { animation-delay: 0.35s; }
.bar-item:nth-child(8)  .bar { animation-delay: 0.40s; }
.bar-item:nth-child(9)  .bar { animation-delay: 0.45s; }
.bar-item:nth-child(10) .bar { animation-delay: 0.50s; }

/* نمودار دایره‌ای */
.pie-chart-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 30px;
    height: 250px;
    flex-wrap: wrap;
}
.pie-chart {
    width: 160px;
    height: 160px;
    border-radius: 50%;
    position: relative;
    flex-shrink: 0;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}
.pie-center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #fff, #f8fafc);
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-shadow: inset 0 2px 8px rgba(0,0,0,0.1);
}
.pie-center-label {
    font-size: 10px;
    color: #64748b;
    font-weight: 600;
}
.pie-center-value {
    font-size: 20px;
    font-weight: 800;
    color: #1e293b;
}
.pie-legend {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
}
.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.legend-label {
    color: #64748b;
    font-size: 12px;
    font-weight: 600;
    min-width: 40px;
}
.legend-value {
    color: #1e293b;
    font-weight: 700;
    font-size: 12px;
}

/* نمودار خطی */
.line-chart-container {
    height: 240px;
    padding: 10px;
    overflow-x: auto;
}
.line-chart-svg {
    min-width: 600px;
    height: 100%;
}
.grid-line {
    stroke: rgba(0,0,0,0.08);
    stroke-width: 1;
}
.data-line {
    fill: none;
    stroke: #3b82f6;
    stroke-width: 3;
    stroke-linecap: round;
    stroke-linejoin: round;
}
.area-fill {
    fill: url(#areaGradient);
}

/* لیست آزمون‌ها */
.exam-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
    max-height: 350px;
    overflow-y: auto;
}
.exam-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 12px;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    transition: all 0.2s ease;
    cursor: pointer;
    text-decoration: none;
    color: inherit;
}
.exam-item:hover {
    background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
    transform: translateX(4px);
}
.exam-item.active {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    border-color: #3b82f6;
}
.exam-date {
    font-weight: 700;
    color: #1e293b;
    font-size: 13px;
}
.exam-subjects {
    font-size: 11px;
    color: #64748b;
    margin-top: 2px;
}
.exam-percent {
    font-size: 15px;
    font-weight: 800;
}
.exam-percent.high { color: #16a34a; }
.exam-percent.medium { color: #ca8a04; }
.exam-percent.low { color: #dc2626; }

/* جدول جزئیات */
.details-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.details-table th {
    background: #f8fafc;
    color: #64748b;
    font-weight: 700;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    padding: 10px 6px;
    text-align: right;
    border-bottom: 2px solid #e2e8f0;
}
.details-table td {
    padding: 10px 6px;
    border-bottom: 1px solid #f1f5f9;
    color: #1e293b;
    font-size: 13px;
    vertical-align: middle;
}
.details-table tr:hover td {
    background: #f8fafc;
}
.percent-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 12px;
}
.percent-badge.high { background: #dcfce7; color: #16a34a; }
.percent-badge.medium { background: #fef9c3; color: #ca8a04; }
.percent-badge.low { background: #fee2e2; color: #dc2626; }

/* استایل فصل زیر نام درس */
.subject-chapter {
    display: block;
    font-size: 10px;
    color: #94a3b8;
    font-weight: 400;
    margin-top: 2px;
}

/* Responsive */
@media (max-width: 768px) {
    .pie-chart-container {
        flex-direction: column;
        gap: 15px;
    }
   
    .bar-chart {
        justify-content: flex-start;
        padding-bottom: 8px;
    }
    .bar-item {
        min-width: 60px;
    }
    .line-chart-container {
        height: 200px;
    }
    .chart-card {
        padding: 16px;
    }
    .stat-value {
        font-size: 18px;
    }
    .details-table th,
    .details-table td {
        padding: 8px 4px;
        font-size: 12px;
    }
}
</style>


<!-- RESULTS PAGE -->
<div id="page-results" class="page-content">
    <h1 class="text-2xl md:text-3xl font-bold text-primary mb-6">نتایج آزمون‌ها</h1>
    
    <!-- کارت‌های آماری -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat-card-modern stat-blue">
            <div class="stat-info">
                <div class="stat-value"><?= $stats['total_exams'] ?? 0 ?></div>
                <div class="stat-label">تعداد آزمون</div>
            </div>
        </div>
        
        <div class="stat-card-modern stat-accent">
            <div class="stat-info">
                <div class="stat-value"><?= $stats['avg_percentage'] ?? 0 ?>%</div>
                <div class="stat-label">میانگین درصد</div>
            </div>
        </div>
        
        <div class="stat-card-modern stat-danger">
            <div class="stat-info">
                <div class="stat-value"><?= $weakSub['percentage'] ?>%</div>
                <div class="stat-label"><?= $weakSub['subject'] ?></div>
            </div>
        </div>
        
        <div class="stat-card-modern stat-warning">
            <div class="stat-info">
                <div class="stat-value"><?= $strongSub['percentage'] ?>%</div>
                <div class="stat-label"><?= $strongSub['subject'] ?></div>
            </div>
        </div>
    </div>
    
    <!-- نمودارها -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- نمودار میله‌ای -->
        <div class="chart-card">
            <h2 class="chart-card-title">
                <svg class="text-primary" aria-hidden="true"><use href="icons/sprite.svg#icon-chart-bar"/></svg>
                درصد دروس
            </h2>
            <div class="bar-chart">
                <?php if (!empty($examResults)): ?>
                    <?php foreach ($examResults as $index => $result): ?>
                        <?php
                        $pct = isset($result['percentage']) ? floatval($result['percentage']) : 0;
                        if ($pct == 0 && isset($result['correct']) && isset($result['total_q']) && $result['total_q'] > 0) {
                            $pct = round(($result['correct'] / $result['total_q']) * 100, 1);
                        }
                        $colorClass = $pct >= 50 ? 'success' 
                                    : ($pct >= 30 ? 'warning' : 'danger');
                        $heightPercent = max($pct, 4);
                        ?>
                        <div class="bar-item" style="animation-delay: <?= $index * 0.05 ?>s">
                            <div class="bar <?= $colorClass ?>" style="height: <?= $heightPercent ?>%;">
                                <span class="bar-value"><?= round($pct) ?>%</span>
                            </div>
                            <span class="bar-label" title="<?= htmlspecialchars($result['subject'] ?? '-') ?>">
                                <?= htmlspecialchars($result['subject'] ?? '-') ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: #64748b; width: 100%;">داده‌ای موجود نیست</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- نمودار دایره‌ای -->
        <div class="chart-card">
            <h2 class="chart-card-title">
                <svg class="text-primary" aria-hidden="true"><use href="icons/sprite.svg#icon-pie-chart"/></svg>
                نسبت پاسخ‌ها
            </h2>
            <div class="pie-chart-container">
                <?php 
                $correctPct = $totalQuestions > 0 ? round(($totalCorrect / $totalQuestions) * 100) : 0;
                $wrongPct = $totalQuestions > 0 ? round(($totalWrong / $totalQuestions) * 100) : 0;
                $skippedPct = $totalQuestions > 0 ? round(($totalSkipped / $totalQuestions) * 100) : 0;
                ?>
                <div class="pie-chart" style="background: conic-gradient(
                    var(--color-success) 0% <?= $correctPct ?>%,
                    var(--color-danger) <?= $correctPct ?>% <?= $correctPct + $wrongPct ?>%,
                    var(--color-muted) <?= $correctPct + $wrongPct ?>% 100%
                )";>
                    <div class="pie-center">
                        <span class="pie-center-label">کل</span>
                        <span class="pie-center-value"><?= $totalQuestions ?></span>
                    </div>
                </div>
                <div class="pie-legend">
                    <div class="legend-item">
                        <div class="legend-color" style="background: var(--color-success);"></div>
                        <span class="legend-label">صحیح</span>
                        <span class="legend-value"><?= $totalCorrect ?> (<?= $correctPct ?>%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background: var(--color-danger);"></div>
                        <span class="legend-label">غلط</span>
                        <span class="legend-value"><?= $totalWrong ?> (<?= $wrongPct ?>%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background: var(--color-muted);"></div>
                        <span class="legend-label">خالی</span>
                        <span class="legend-value"><?= $totalSkipped ?> (<?= $skippedPct ?>%)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- نمودار خطی -->
    <div class="chart-card mb-6">
        <h2 class="chart-card-title">
            <svg class="text-primary" aria-hidden="true"><use href="icons/sprite.svg#icon-trending-up"/></svg>
            روند پیشرفت
        </h2>
        <div class="line-chart-container">
            <svg class="line-chart-svg" viewBox="0 0 <?= $svgWidth ?> <?= $svgHeight ?>" preserveAspectRatio="xMidYMid meet">
                <defs>
                    <linearGradient id="areaGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:0.3" />
                        <stop offset="100%" style="stop-color:#3b82f6;stop-opacity:0" />
                    </linearGradient>
                </defs>
                
                <!-- Grid lines -->
                <?php for ($i = 0; $i <= 4; $i++): ?>
                    <?php $y = $padding + ($i * $chartHeight / 4); ?>
                    <line x1="<?= $padding ?>" y1="<?= $y ?>" x2="<?= $svgWidth - $padding ?>" y2="<?= $y ?>" class="grid-line"/>
                    <text x="<?= $padding - 8 ?>" y="<?= $y + 4 ?>" fill="#94a3b8" font-size="10" text-anchor="end"><?= 100 - ($i * 25) ?>%</text>
                <?php endfor; ?>
                
                <!-- Area fill -->
                <?php if (count($historyData) > 0): ?>
                    <polygon points="<?= $padding ?>,<?= $svgHeight - $padding ?> <?= $polylinePoints ?> <?= $padding + (count($historyData) - 1) * $stepX ?>,<?= $svgHeight - $padding ?>" class="area-fill"/>
                    <polyline points="<?= $polylinePoints ?>" class="data-line"/>
                    <?= $points ?>
                <?php else: ?>
                    <text x="<?= $svgWidth / 2 ?>" y="<?= $svgHeight / 2 ?>" fill="#94a3b8" font-size="14" text-anchor="middle">داده‌ای موجود نیست</text>
                <?php endif; ?>
            </svg>
        </div>
    </div>
    
    <!-- لیست آزمون‌ها و جدول جزئیات -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- لیست آزمون‌ها -->
        <div class="chart-card">
            <h2 class="chart-card-title">
                <svg class="text-primary" aria-hidden="true"><use href="icons/sprite.svg#icon-calendar"/></svg>
                آزمون‌ها
            </h2>
            <div class="exam-list">
                <?php if (!empty($examDates)): ?>
                    <?php foreach ($examDates as $date): ?>
                        <?php 
                        $examForDate = Students::getExamByDate($id, $date['exam_date']);
                        $totalPct = 0;
                        $count = 0;
                        foreach ($examForDate as $r) {
                            $pct = isset($r['percentage']) ? floatval($r['percentage']) : 0;
                            if ($pct == 0 && isset($r['correct']) && isset($r['total_q']) && $r['total_q'] > 0) {
                                $pct = round(($r['correct'] / $r['total_q']) * 100, 1);
                            }
                            $totalPct += $pct;
                            $count++;
                        }
                        $avg = $count > 0 ? round($totalPct / $count) : 0;
                        $avgClass = $avg >= 70 ? 'high' : ($avg >= 50 ? 'medium' : 'low');
                        ?>
                        <a href="?page=results&date=<?= $date['exam_date'] ?>" 
                           class="exam-item <?= $selectedDate == $date['exam_date'] ? 'active' : '' ?>">
                            <div>
                                <div class="exam-date"><?= $date['exam_date'] ?></div>
                                <div class="exam-subjects"><?= count($examForDate) ?> درس</div>
                            </div>
                            <span class="exam-percent <?= $avgClass ?>"><?= $avg ?>%</span>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: #64748b; padding: 20px;">آزمونی یافت نشد</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- جدول جزئیات – ترکیب درس و فصل -->
        <div class="chart-card lg:col-span-3">
            <h2 class="chart-card-title">
                <svg class="text-primary" aria-hidden="true"><use href="icons/sprite.svg#icon-list"/></svg>
                جزئیات آزمون
            </h2>
            <div class="overflow-x-auto">
                <?php if (!empty($examResults)): ?>
                    <table class="details-table">
                        <thead>
                            <tr>
                                <th>درس</th>
                                <th>کل</th>
                                <th>صحیح</th>
                                <th>غلط</th>
                                <th>خالی</th>
                                <th>درصد</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($examResults as $result): ?>
                                <?php 
                                $pct = isset($result['percentage']) ? floatval($result['percentage']) : 0;
                                if ($pct == 0 && isset($result['correct']) && isset($result['total_q']) && $result['total_q'] > 0) {
                                    $pct = round(($result['correct'] / $result['total_q']) * 100, 1);
                                }
                                $pctClass = $pct >= 70 ? 'high' : ($pct >= 50 ? 'medium' : 'low');
                                ?>
                                <tr>
                                    <td>
                                        <span class="font-semibold"><?= htmlspecialchars($result['subject'] ?? '-') ?></span>
                                        <?php if (!empty($result['chapter'])): ?>
                                            <span class="subject-chapter"><?= htmlspecialchars($result['chapter'] ?? '-') ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $result['total_q'] ?? 0 ?></td>
                                    <td class="text-green-600 font-semibold"><?= $result['correct'] ?? 0 ?></td>
                                    <td class="text-red-500"><?= $result['wrong'] ?? 0 ?></td>
                                    <td class="text-gray-400"><?= $result['skipped'] ?? 0 ?></td>
                                    <td>
                                        <span class="percent-badge <?= $pctClass ?>">
                                            <?= $pct ?>%
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center; color: #64748b; padding: 40px;">داده‌ای برای این آزمون یافت نشد</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>