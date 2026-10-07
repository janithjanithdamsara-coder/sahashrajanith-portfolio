  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const toggleBtn = document.getElementById('mobileNavToggle');
      const sidebar = document.getElementById('adminSidebar');
      const overlay = document.getElementById('sidebarOverlay');

      if (toggleBtn && sidebar && overlay) {
        toggleBtn.addEventListener('click', function() {
          sidebar.classList.toggle('active');
          overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', function() {
          sidebar.classList.remove('active');
          overlay.classList.remove('active');
        });
      }
    });
  </script>
</body>
</html>
