# معماری کامل پنل شاگردان (`dashboard/`)

> این سند مرجع نهایی معماری فرانت‌اند `dashboard/` است. مبتنی بر پلن تأییدشده‌ی مهاجرت به `api/v1` + پلن تأییدشده‌ی بک‌اند (JWT `student_id` + `StudentScope`). این فایل برای مصرف مستقیم توسط ایجنت کدنویسی نوشته شده — هر مسیر، هر endpoint، و هر تصمیم صریح ذکر شده است.

---

## ۰. پیش‌فرض‌های تثبیت‌شده (Non-negotiable)

| مورد | تصمیم |
|---|---|
| رندر | سرور-رندر شِل فعلی (HTML/CSS دست‌نخورده) حفظ می‌شود؛ داده‌ها با JS تزریق می‌شوند |
| کلاینت API | `shared/js/api.js` (همان الگوی `admin/`, `public/`) — تغییری در آن داده نمی‌شود |
| Auth داخلی | حذف کامل؛ همه‌چیز از `login/` می‌آید |
| منبع حقیقت API | `api/openapi.yaml` (پس از تکمیل توسط پلن بک‌اند تأییدشده) |
| نمودارها | تابع‌های JS جدید (نه apexcharts، نه SVG سمت PHP) |
| برنامه‌ی هفتگی (`plan`) | **فعلاً به‌طور کامل از دامنه‌ی این فاز خارج است** — نه route، نه لینک sidebar، نه فایل JS |
| ویرایش اطلاعات شخصی | خارج از دامنه؛ فقط نمایش |
| اتصال تلگرام | حذف کامل |

برای اجرای کد پس از آماده‌شدن DOM، از `onReady()` در `api.js` استفاده کنید و مستقیماً `document.addEventListener('DOMContentLoaded', ...)` ننویسید.

---

## ۱. ساختار دایرکتوری نهایی

```
dashboard/
├── index.php                  # فقط پوسته + انتخاب view با ?page=
├── views/
│   ├── header.php             # import ماژول‌های JS + lucide-adapter
│   ├── sidebar.php            # username/logout با JS؛ لینک plan حذف/مخفی
│   ├── overview.php           # (قبلاً dashboard.php) — فقط markup + شناسه‌های DOM
│   ├── results.php            # فقط markup + شناسه‌های DOM
│   ├── files.php              # جدید — فقط markup + شناسه‌های DOM
│   └── profile.php            # جدید — فقط markup، read-only
├── assets/
│   ├── js/
│   │   ├── app.js             # auth guard + nav + logout + import API
│   │   ├── overview.js
│   │   ├── results.js
│   │   ├── files.js
│   │   └── profile.js
│   └── css/                   # دست‌نخورده
└── (import پویا از ASSET_URL تنظیم‌شده در APP_CONFIG)
```

### حذف فیزیکی (تأییدشده در پلن مهاجرت)
`views/login.php`, `views/auth.php`, `views/logout.php`, `assets/js/auth.js`, `api/auth.php` (نسخه‌ی قدیمی/session)، به‌علاوه فایل‌های مرده‌ی قبلاً لیست‌شده (`model/*`, `controller/Core.php`, `main.js`, `performance-charts.js`).

---

## ۲. جریان احراز هویت (در `app.js`، اجرا در هر بارگذاری صفحه)

```
1. import API dynamically from window.APP_CONFIG.assetUrl + '/js/api.js'
2. const me = await API.getMe()
3. if (me === null) → location.replace('../login/?return_url=/dashboard/')
4. if (me.role !== 'student') → location.replace('../admin/')
5. const studentId = me.student_id
   if (studentId === null) → نمایش پیام خطا: «حساب دانش‌آموزی یافت نشد» (توقف رندر بقیه‌ی صفحه)
6. studentId در یک module-level export (مثلاً app.js → export function getStudentId())
   قرار می‌گیرد تا بقیه‌ی ماژول‌ها (overview.js, results.js, ...) بدون فراخوانی مجدد getMe() از آن استفاده کنند
7. #desktopUsername ← me.full_name
8. #logoutBtn.onclick = async () => { await API.logout(); location.replace('../login/'); }
```

⚠️ توجه: طبق پلن بک‌اند تأییدشده، سرور خودش هم مالکیت `student_id` را enforce می‌کند (به‌جز `plans` که فعلاً استفاده نمی‌شود، پس بی‌ربط است). فرانت هرگز `student_id` کاربر دیگری را نمی‌فرستد؛ همیشه از `getStudentId()` استفاده می‌شود.

---

## ۳. نگاشت صفحه ↔ endpoint ↔ UI

### صفحه‌ی Overview (`?page=overview`, فایل `overview.js`)

| بخش UI | Endpoint | نگاشت فیلد |
|---|---|---|
| میانگین کل | `GET /exams/dates?student_id=<self>` | میانگین همه‌ی `avg_percentage` موجود در آرایه‌ی `dates[]` (یا از `analytics/summary` اگر فیلد معادل داشت — **نیاز به verify**) |
| قوی‌ترین/ضعیف‌ترین درس (کلی) | `GET /students/{id}/analytics/subject-stats` | ⚠️ schema هنوز verify نشده — رجوع به بخش ۵ |
| آخرین آزمون (کارت خلاصه) | `GET /exams/dates?student_id=<self>` | جدیدترین آیتم آرایه‌ی `dates[]` بر اساس `exam_date` |
| لینک‌های میان‌بر | — | به `?page=results` و `?page=files` |

### صفحه‌ی Results (`?page=results`, فایل `results.js`)

| بخش UI | Endpoint | نگاشت فیلد (تأییدشده با تست واقعی) |
|---|---|---|
| لیست تاریخ‌های آزمون | `GET /exams/dates?student_id=<self>` | `dates[] = {exam_date, student_count, subject_count, avg_percentage}` |
| جزئیات آزمون انتخاب‌شده | `GET /exams/details?exam_date=&student_id=<self>` | `{student:{id,name,grade,field}, subjects:[{subject,chapter,total_q,correct,wrong,skipped,percentage}], avg_percentage}` — **`percentage` رشته است، حتماً `parseFloat` شود** |
| قوی‌ترین/ضعیف‌ترین درس **این آزمون** | محاسبه سمت کلاینت | از روی آرایه‌ی `subjects[]` همان response — بیشترین/کمترین `percentage` |
| بیشترین/کمترین درصد **این آزمون** | محاسبه سمت کلاینت | همان، مقدار عددی |
| نمودار میله‌ای/دایره‌ای این آزمون | محاسبه سمت کلاینت از `subjects[]` | — |
| نمودار روند میانگین درصد (همه‌ی آزمون‌ها) | `GET /students/{id}/analytics/exam-trend` یا محاسبه از `dates[]` (چون `avg_percentage` آنجا هم هست) | ⚠️ نیاز به تصمیم: از `exam-trend` استفاده شود یا از `dates[]` که همین الان response واقعی و تأییدشده دارد — **توصیه: فعلاً از `dates[]` بساز، چون verify شده؛ اگر `exam-trend` فیلد اضافه‌ای (مثلاً breakdown per-subject در طول زمان) داشت، بعداً migrate کن** |
| نمودار عملکرد درس‌به‌درس (تجمیعی) | `GET /students/{id}/analytics/subject-stats` | ⚠️ نیاز به verify |

### صفحه‌ی Files (`?page=files`, فایل `files.js`)

| بخش UI | Endpoint | وضعیت |
|---|---|---|
| لیست فایل‌های آزمون | `GET /files?student_id=<self>` | موجود طبق `File` schema |
| آپلود | `POST /files/upload` (multipart) | موجود — احتمالاً شاگرد از این استفاده نمی‌کند؛ **باید تأیید کنی آیا آپلود اصلاً باید برای نقش student فعال باشد یا فقط دانلود** |
| حذف | `DELETE /files/{id}` | موجود — همین‌طور، احتمالاً باید برای student غیرفعال/مخفی باشد (این یعنی endpoint در بک‌اند هست ولی UI دکمه‌اش را نشان نمی‌دهد) |
| **دانلود فایل** | ❌ وجود ندارد | **بلاک‌کننده — بخش ۵ را ببین** |

### صفحه‌ی Profile (`?page=profile`, فایل `profile.js`)

| بخش UI | Endpoint | نگاشت |
|---|---|---|
| نام، پایه، رشته | `GET /students/{id}` | نمایش مستقیم، بدون فرم ویرایش، بدون دکمه‌ی ذخیره |

### حذف‌شده از این فاز
- صفحه‌ی `plan` — روت، لینک sidebar، و فایل JS اضافه نمی‌شود.

---

## ۴. مسئولیت هر ماژول JS

```
app.js
  - auth guard (بخش ۲)
  - export getStudentId(), getUserInfo()
  - نصب nav/logout handlers
  - import و init کردن ماژول صفحه‌ی فعال بر اساس ?page=

overview.js
  - فراخوانی /exams/dates
  - محاسبه‌ی میانگین کل + آخرین آزمون سمت کلاینت
  - فراخوانی /analytics/subject-stats برای قوی/ضعیف‌ترین کلی
  - رندر کارت‌ها، مدیریت empty state (اگر هیچ آزمونی ثبت نشده)

results.js
  - فراخوانی /exams/dates → رندر لیست تاریخ‌ها
  - onClick هر تاریخ → فراخوانی /exams/details → رندر جدول + نمودار میله‌ای/دایره‌ای
  - محاسبه‌ی قوی/ضعیف‌ترین این آزمون از روی response
  - رندر نمودار روند (از dates[] یا exam-trend — طبق تصمیم بخش ۳)
  - رندر نمودار عملکرد درس‌به‌درس (از subject-stats)
  - مدیریت loading/error/empty state هر بخش مستقل از بقیه

files.js
  - فراخوانی /files?student_id=
  - رندر لیست با دکمه‌ی دانلود (وابسته به endpoint جدید — بخش ۵)
  - اگر تصمیم شد آپلود/حذف برای student فعال نباشد، فقط UI نمایشی (بدون دکمه)

profile.js
  - فراخوانی /students/{id}
  - رندر ساده، بدون فرم
```

---

## ۵. وابستگی‌های بک‌اند — بلاک‌کننده‌های این فاز

این‌ها باید **قبل از تکمیل نهایی** `results.js` و `files.js` حل شوند:

1. **اندپوینت دانلود فایل وجود ندارد.**
   نیاز: `GET /files/{id}/download` — با enforce مالکیت (همان الگوی `StudentScope`)، پاسخ به‌صورت stream (نه `url`/`download_url` مستقیم، چون آن‌وقت فایل بدون auth قابل دسترسی می‌شود).

2. **باگ محاسبه‌ی `percentage` در `ExamResult`** (پیدا شده در تست واقعی — مثال: زیست با `correct:3, total_q:20` باید `15.00` بدهد، نه `0.00`). باید در بک‌اند فیکس شود، مستقل از این مهاجرت فرانت، وگرنه داده‌ی اشتباه به همین شکل در UI جدید هم نمایش داده می‌شود.

3. **schema سه endpoint هنوز با تست واقعی verify نشده:**
   - `GET /students/{id}/analytics/summary`
   - `GET /students/{id}/analytics/subject-stats`
   - `GET /students/{id}/analytics/exam-trend`
   قبل از نوشتن `overview.js` و بخش نمودارهای `results.js`، این سه باید مثل `/exams/details` واقعاً صدا زده شوند (Postman/DevTools با توکن یک شاگرد) و response واقعی بررسی شود.

4. **تصمیم باز درباره‌ی آپلود/حذف فایل توسط شاگرد** — آیا اصلاً باید در UI این نقش وجود داشته باشد؟ (بخش ۳، جدول Files)

5. **بدهی امنیتی شناخته‌شده و یادداشت‌شده:** `/plans` هنوز بدون ownership enforcement است. چون `plan` از این فاز کاملاً خارج شده، فعلاً بی‌اثر است — ولی باید قبل از فعال‌سازی مجدد `plan` در فازهای بعدی فیکس شود.

---

## ۶. تصمیمات معماری که باید صریحاً تأیید/رد کنی

- [ ] محتوای صفحه‌ی Overview همان چیزی است که در بخش ۳ نوشته شد (بدون هیچ ارجاعی به `plan`)؟
- [ ] نمودار روند از `dates[]` ساخته شود یا منتظر verify شدن `exam-trend` بمانیم؟
- [ ] دکمه‌ی آپلود/حذف فایل در UI شاگرد باشد یا نه؟

---

## ۷. معیارهای پذیرش (برای تست پس از پیاده‌سازی)

- بدون session/DB در PHP این پنل — `php -l` هیچ خطا؛ گرفتن هیچ داده‌ای مستقیم از DB در view ها.
- DevTools → Network: تمام درخواست‌ها به `/api/v1/*`؛ هیچ درخواستی به مسیرهای حذف‌شده‌ی auth.
- کاربر مهمان → ریدایرکت به `login/`.
- شاگرد الف نمی‌تواند با دستکاری URL/query به `student_id` شاگرد ب دسترسی پیدا کند (باید ۴۰۳ بگیرد) — تست مستقیم روی `/exams/details`, `/exams/dates`, `analytics/*`, `/files`.
- هر صفحه (overview/results/files/profile): حالت خالی (بدون داده) و حالت خطا (قطعی API) به‌طور جداگانه تست و رندر شود.
- بدون تغییر بصری نسبت به نسخه‌ی فعلی (فقط منبع داده عوض شده).
- لینک/روت `plan` در هیچ‌جای UI ظاهر نمی‌شود.
