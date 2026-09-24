/**
 * Jalali (Shamsi) date helpers for the student dashboard.
 *
 * Parses API date strings ("YYYY-MM-DD" or "YYYY-MM-DD HH:MM[:SS]") as a
 * local date and formats them with the Persian calendar. Uses the browser's
 * built-in Intl Persian calendar — no external dependency.
 */

function parseDate(str) {
    if (!str) return null;
    const m = String(str).match(/(\d{4})-(\d{2})-(\d{2})(?:[ T](\d{2}):(\d{2}))?/);
    if (!m) return null;
    return new Date(+m[1], +m[2] - 1, +m[3], +(m[4] || 0), +(m[5] || 0));
}

export function jalaliParts(str) {
    const d = parseDate(str);
    if (!d) return null;
    const parts = new Intl.DateTimeFormat('fa-IR-u-ca-persian-nu-latn', {
        year: 'numeric', month: 'numeric', day: 'numeric',
    }).formatToParts(d);
    const get = (t) => +(parts.find((p) => p.type === t)?.value ?? 0);
    return { jy: get('year'), jm: get('month'), jd: get('day') };
}

/** Short numeric: ۱۴۰۵/۰۲/۰۳ */
export function toJalali(str) {
    const d = parseDate(str);
    if (!d) return str || '-';
    return new Intl.DateTimeFormat('fa-IR-u-ca-persian', {
        year: 'numeric', month: '2-digit', day: '2-digit',
    }).format(d);
}

/** Long: ۳ اردیبهشت ۱۴۰۵ */
export function toJalaliLong(str) {
    const d = parseDate(str);
    if (!d) return str || '-';
    return new Intl.DateTimeFormat('fa-IR-u-ca-persian', {
        year: 'numeric', month: 'long', day: 'numeric',
    }).format(d);
}

/** Date + time: ۱۴۰۵/۰۲/۰۳ - ۱۴:۳۰ */
export function toJalaliDateTime(str) {
    const d = parseDate(str);
    if (!d) return str || '-';
    const date = new Intl.DateTimeFormat('fa-IR-u-ca-persian', {
        year: 'numeric', month: '2-digit', day: '2-digit',
    }).format(d);
    if (!/\d{2}:\d{2}/.test(String(str))) return date;
    const time = new Intl.DateTimeFormat('fa-IR-u-ca-persian', {
        hour: '2-digit', minute: '2-digit', hour12: false,
    }).format(d);
    return `${date} - ${time}`;
}

const JALALI_MONTHS = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];

/** Stable key for grouping/filtering, e.g. "1405-02". */
export function jalaliMonthKey(str) {
    const p = jalaliParts(str);
    return p ? `${p.jy}-${String(p.jm).padStart(2, '0')}` : '';
}

/** Human label for a key, e.g. "اردیبهشت ۱۴۰۵". */
export function jalaliMonthLabel(str) {
    const p = jalaliParts(str);
    if (!p) return str || '-';
    const year = new Intl.NumberFormat('fa-IR-u-ca-persian', { useGrouping: false }).format(p.jy);
    return `${JALALI_MONTHS[p.jm - 1]} ${year}`;
}