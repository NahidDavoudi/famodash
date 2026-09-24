/**
 * Files page — read-only file list.
 */
import API from '../../../shared/js/api.js';
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
                const size = f.size
                    ? f.size < 1024
                        ? `${f.size} B`
                        : f.size < 1048576
                            ? `${(f.size / 1024).toFixed(1)} KB`
                            : `${(f.size / 1048576).toFixed(1)} MB`
                    : '-';
                return `<tr>
                    <td class="font-medium">${f.original_name ?? '-'}</td>
                    <td>${(f.mime_type ?? '').split('/').pop() || '-'}</td>
                    <td>${size}</td>
                    <td>${toJalaliDateTime(f.uploaded_at)}</td>
                    <td class="text-muted-foreground">${f.description ?? '-'}</td>
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