document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleBtn = document.getElementById('toggleSidebar');
    
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isCollapsed) collapseSidebar();

    function toggleSidebar() {
        if (sidebar.classList.contains('nav-collapsed')) {
            expandSidebar();
        } else {
            collapseSidebar();
        }
    }

    function collapseSidebar() {
        sidebar.classList.add('nav-collapsed');
        if (mainContent) {
            mainContent.classList.remove('md:ml-48');
            mainContent.classList.add('md:ml-16');
        }
        localStorage.setItem('sidebarCollapsed', 'true');
    }

    function expandSidebar() {
        sidebar.classList.remove('nav-collapsed');
        if (mainContent) {
            mainContent.classList.remove('md:ml-16');
            mainContent.classList.add('md:ml-48');
        }
        localStorage.setItem('sidebarCollapsed', 'false');
    }

    toggleBtn.addEventListener('click', toggleSidebar);

    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
            e.preventDefault();
            toggleSidebar();
        }
    });

    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth < 768) {
                sidebar.classList.remove('nav-collapsed');
                if (mainContent) {
                    mainContent.classList.remove('md:ml-16');
                    mainContent.classList.add('md:ml-48');
                }
            }
        }, 250);
    });

    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        const text = item.querySelector('.nav-text')?.textContent;
        if (text) item.setAttribute('title', text);
    });

    const navLinks = document.querySelectorAll('a[href*="/"]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            this.style.opacity = '0.7';
            setTimeout(() => {
                this.style.opacity = '1';
            }, 200);
        });
    });
});