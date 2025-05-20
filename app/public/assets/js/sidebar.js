function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');
  sidebar.classList.toggle('collapsed');
  mainContent.classList.toggle('collapsed');
}