function initSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const btn = document.getElementById('mobileMenuBtn');

  if (!sidebar || !overlay || !btn) return;

  // جلوگیری از duplicate listener
  btn.replaceWith(btn.cloneNode(true));
  const newBtn = document.getElementById('mobileMenuBtn');

  const toggleSidebar = () => {
    sidebar.classList.toggle('sidebar-open');
    overlay.classList.toggle('active');
  };

  newBtn.addEventListener('click', toggleSidebar);
  overlay.addEventListener('click', toggleSidebar);
}

document.addEventListener('DOMContentLoaded', initSidebar);