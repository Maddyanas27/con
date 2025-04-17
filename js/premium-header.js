document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.premium-header');
    let lastScroll = 0;

    // Header scroll effect
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 50) {
            header.style.transform = `translateY(-${document.querySelector('.top-bar').offsetHeight}px)`;
            header.style.backgroundColor = 'rgba(255, 255, 255, 0.98)';
            header.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.1)';
        } else {
            header.style.transform = 'translateY(0)';
            header.style.backgroundColor = 'rgba(255, 255, 255, 0.98)';
            header.style.boxShadow = 'none';
        }
        
        lastScroll = currentScroll;
    });

    // Active link highlighting
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPath.split('/').pop()) {
            link.classList.add('active');
        }
    });

    // Cart count animation
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        cartCount.addEventListener('animationend', () => {
            cartCount.style.animation = 'none';
            void cartCount.offsetWidth;
            cartCount.style.animation = 'pulse 2s infinite';
        });
    }
});