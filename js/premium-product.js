document.addEventListener('DOMContentLoaded', function() {
    // Animate items on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.isotope-item').forEach(item => {
        observer.observe(item);
    });

    // Smooth filter transitions
    const filterButtons = document.querySelectorAll('.filter-tope-group button, .filter-tope-group a');
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('how-active1'));
            this.classList.add('how-active1');
        });
    });

    // Hover effect for product cards
    document.querySelectorAll('.block2').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.querySelector('img').style.transform = 'scale(1.05)';
        });

        card.addEventListener('mouseleave', function() {
            this.querySelector('img').style.transform = 'scale(1)';
        });
    });
});