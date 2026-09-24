/**
 * Profile page — read-only student info.
 */
import API from '../shared/js/api.js';
import { getStudentId } from './app.js';

export async function load() {
    const el = (id) => document.getElementById(id);
    const show = (id) => el(id)?.classList.remove('hidden');
    const hide = (id) => el(id)?.classList.add('hidden');

    hide('profileContent');
    hide('profileError');
    show('profileLoading');

    const sid = getStudentId();

    try {
        const res = await API.get(`/students/${sid}`);
        const s = res.data;
        if (!s) throw new Error('empty response');

        const setText = (id, v) => { const e = el(id); if (e) e.textContent = v ?? '-'; };

        setText('profileName', s.name);
        setText('profileGrade', s.grade ? `پایه ${s.grade}` : '-');
        setText('profileField', s.field || '-');
        setText('profilePhone', s.phone || '-');
        setText('profileAvatarLetter', (s.name?.[0]) ?? 'ف');

        hide('profileLoading');
        show('profileContent');

    } catch (err) {
        console.error('profile error', err);
        hide('profileLoading');
        show('profileError');
        if (el('profileRetryBtn')) el('profileRetryBtn').onclick = load;
    }
}