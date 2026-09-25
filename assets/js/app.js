/**
 * Famo Student Dashboard — App Entry
 *
 * Auth guard, navigation, logout, shared state.
 */
const { default: API } = await import(`${window.APP_CONFIG.assetUrl}/js/api.js`);

/* ── Shared state ── */
let _studentId = null;
let _user = null;

export function getStudentId() { return _studentId; }
export function getUserInfo() { return _user; }

/* ── Auth guard ── */
async function init() {
    _user = await API.getMe();
    if (!_user) {
        const returnUrl = `${window.location.pathname}${window.location.search}`;
        const loginBase = window.APP_CONFIG && window.APP_CONFIG.loginUrl;
        window.location.replace(`${loginBase}/?return_url=${encodeURIComponent(returnUrl)}`);
        return;
    }
    if (_user.role !== 'student') {
        const adminBase = window.APP_CONFIG && window.APP_CONFIG.adminUrl;
        window.location.replace(`${adminBase}/`);
        return;
    }
    if (!_user.student_id) {
        document.getElementById('mainPanel').classList.add('hidden');
        document.body.innerHTML = `<div class="flex items-center justify-center min-h-screen p-4 text-center"><div><h2 class="text-xl font-bold text-danger mb-2">خطا</h2><p class="text-muted-foreground">حساب کاربری به دانش‌آموزی متصل نیست.</p></div></div>`;
        return;
    }

    _studentId = _user.student_id;

    /* show shell */
    document.getElementById('mainPanel').classList.remove('hidden');

    /* username */
    const nameEl = document.getElementById('desktopUsername');
    if (nameEl && _user.full_name) nameEl.textContent = _user.full_name;

    /* navigation */
    installNav();

    /* logout */
    document.getElementById('logoutBtn')?.addEventListener('click', async (e) => {
        e.preventDefault();
        await API.logout();
        const loginBase = window.APP_CONFIG && window.APP_CONFIG.loginUrl;
        window.location.replace(`${loginBase}/`);
    });

    /* mobile sidebar toggle */
    const menuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    if (menuBtn && sidebar && overlay) {
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-open');
            overlay.classList.toggle('active');
        });
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('sidebar-open');
            overlay.classList.remove('active');
        });
    }

    /* load initial page */
    const page = new URLSearchParams(window.location.search).get('page') || 'overview';
    navigateTo(page);
}

/* ── Navigation ── */
function installNav() {
    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const page = link.dataset.page;
            if (page) navigateTo(page);
        });
    });
}

let _currentPage = null;
const _pageModules = {};  /* lazy-loaded */

export async function navigateTo(page) {
    if (page === _currentPage) return;
    if (_currentPage) {
        const prev = document.getElementById(`page-${_currentPage}`);
        if (prev) prev.classList.add('hidden');
        const prevLink = document.querySelector(`.sidebar-link[data-page="${_currentPage}"]`);
        if (prevLink) prevLink.classList.remove('active');
    }

    _currentPage = page;

    const el = document.getElementById(`page-${page}`);
    if (el) el.classList.remove('hidden');
    const link = document.querySelector(`.sidebar-link[data-page="${page}"]`);
    if (link) link.classList.add('active');

    /* import & run page module */
    try {
        switch (page) {
            case 'overview': {
                const mod = await import('./overview.js');
                await mod.load();
                break;
            }
            case 'results': {
                const mod = await import('./results.js');
                await mod.load();
                break;
            }
            case 'files': {
                const mod = await import('./files.js');
                await mod.load();
                break;
            }
            case 'profile': {
                const mod = await import('./profile.js');
                await mod.load();
                break;
            }
        }
    } catch (err) {
        console.error(`page[${page}] error`, err);
    }
}

/* ── Start ── */
window.navigateTo = navigateTo;

document.addEventListener('DOMContentLoaded', init);
