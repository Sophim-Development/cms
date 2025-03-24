    <script>
        const ctx = document.getElementById('analyticsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jun 28', 'Jun 29', 'Jun 30', 'Jul 1', 'Jul 2', 'Jul 3', 'Jul 4'],
                datasets: [
                    {
                        label: 'Dataset 1',
                        data: [300, 310, 290, 320, 310, 300, 310],
                        borderColor: '#4A90E2',
                        fill: false,
                    },
                    {
                        label: 'Dataset 2',
                        data: [280, 290, 270, 300, 290, 280, 290],
                        borderColor: '#F5A623',
                        fill: false,
                    },
                    {
                        label: 'Dataset 3',
                        data: [260, 270, 250, 280, 270, 260, 270],
                        borderColor: '#50E3C2',
                        fill: false,
                    },
                ],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });

        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                menuItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');

                // Toggle submenu
                const submenu = item.nextElementSibling;
                if (submenu && submenu.classList.contains('submenu')) {
                    const isOpen = submenu.classList.contains('open');
                    // Close all submenus
                    document.querySelectorAll('.submenu').forEach(sub => {
                        sub.classList.remove('open');
                    });
                    if (!isOpen) {
                        submenu.classList.add('open');
                    }
                }
            });
        });

        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target) && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });
    </script>
</body>
</html>