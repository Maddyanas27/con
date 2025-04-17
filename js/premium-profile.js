document.addEventListener('DOMContentLoaded', function() {
    // Add animation delays to form groups
    document.querySelectorAll('.form-group').forEach((group, index) => {
        group.style.animationDelay = `${(index + 1) * 0.1}s`;
    });

    // Add hover effect to form controls
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('mouseover', function() {
            if (!this.disabled) {
                this.style.transform = 'translateX(5px)';
            }
        });

        input.addEventListener('mouseout', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Add ripple effect to buttons
    document.querySelectorAll('.premium-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('div');
            ripple.classList.add('ripple');
            this.appendChild(ripple);
            
            const rect = this.getBoundingClientRect();
            ripple.style.left = `${e.clientX - rect.left}px`;
            ripple.style.top = `${e.clientY - rect.top}px`;
            
            setTimeout(() => ripple.remove(), 1000);
        });
    });
});