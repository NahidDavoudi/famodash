/**
 * Files page — read-only file list.
 */
const { default: API } = await import(`${window.APP_CONFIG.assetUrl}/js/api.js`);
import { getStudentId } from './app.js';
import { toJalaliDateTime } from './date.js';

export async function load() {
    const el = (id) => document.getElementById(id);
    const show = (id) => el(id)?.classList.remove('hidden');
    const hide = (id) => el(id)?.classList.add('hidden');

    hide('filesContent');
    hide('filesEmpty');
    hide('filesError');
    show('filesLoading');

    const sid = getStudentId();

    try {
        const res = await API.get(`/files?student_id=${sid}`);
        const files = /** @type {Array} */ (res.data ?? []);

        hide('filesLoading');

        if (files.length === 0) {
            show('filesEmpty');
            return;
        }

        const tbody = document.getElementById('filesTbody');
        if (tbody) {
            tbody.innerHTML = files.map(f => {
                const filePath = f.file_path ?? f.path ?? '';
                const originalName = f.original_name ?? f.original_filename ?? f.name
                    ?? filePath.split(/[\\/]/).pop() ?? '-';
                const fileSize = Number(f.size ?? f.file_size ?? 0);
                const fileType = f.mime_type ?? f.file_type ?? '';
                const uploadedAt = f.uploaded_at ?? f.created_at;
                const size = fileSize
                    ? fileSize < 1024
                        ? `${fileSize} B`
                        : fileSize < 1048576
                            ? `${(fileSize / 1024).toFixed(1)} KB`
                            : `${(fileSize / 1048576).toFixed(1)} MB`
                    : '-';
                const type = fileType.includes('/')
                    ? fileType.split('/').pop()
                    : fileType.toUpperCase() || '-';
                const text = (value) => String(value ?? '-').replace(/[&<>"']/g, char => ({
                    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
                }[char]));
                return `<tr>
                    <td data-label="نام فایل" class="font-medium">${text(originalName)}</td>
                    <td data-label="نوع">${text(type)}</td>
                    <td data-label="حجم">${text(size)}</td>
                    <td data-label="تاریخ آپلود">${text(uploadedAt ? toJalaliDateTime(uploadedAt) : '-')}</td>
                    <td data-label="توضیحات" class="text-muted-foreground">${text(f.description)}</td>
                </tr>`;
            }).join('');
        }

        show('filesContent');

    } catch (err) {
        console.error('files error', err);
        hide('filesLoading');
        show('filesError');
        if (el('filesRetryBtn')) el('filesRetryBtn').onclick = load;
    }
}
