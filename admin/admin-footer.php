        </div>
    </main>
    <script>
        // Sidebar toggle
        const toggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('admin-sidebar');
        if (toggle) {
            toggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
            });
        }
    </script>
</body>
</html>
