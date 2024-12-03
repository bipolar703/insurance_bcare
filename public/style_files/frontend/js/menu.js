document.addEventListener('DOMContentLoaded', function() {
    // Create backdrop element
    const backdrop = document.createElement('div');
    backdrop.className = 'navbar-backdrop';
    document.body.appendChild(backdrop);

    // Get menu elements
    const mobileMenu = document.querySelector('.navbar-collapse');
    const toggleButton = document.querySelector('.navbar-toggler');
    
    // Toggle menu and backdrop
    function toggleMenu(show) {
        mobileMenu.classList.toggle('show', show);
        backdrop.classList.toggle('show', show);
        toggleButton.setAttribute('aria-expanded', show);
        
        if (show) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }

    // Handle toggle button click
    if (toggleButton) {
        toggleButton.addEventListener('click', function(e) {
            e.preventDefault();
            const isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';
            toggleMenu(!isExpanded);
        });
    }

    // Handle backdrop click
    backdrop.addEventListener('click', function() {
        toggleMenu(false);
    });

    // Handle escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenu.classList.contains('show')) {
            toggleMenu(false);
        }
    });

    // Prevent menu from closing when clicking inside
    if (mobileMenu) {
        mobileMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    // Close menu on window resize if in desktop view
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992 && mobileMenu.classList.contains('show')) {
            toggleMenu(false);
        }
    });

    // Handle menu item clicks
    const menuItems = document.querySelectorAll('.navbar-nav .nav-link');
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                toggleMenu(false);
            }
        });
    });
});
