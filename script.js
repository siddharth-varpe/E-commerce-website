document.addEventListener('DOMContentLoaded', () => {
    // 1. Toast Notification Dismissal
    const toast = document.getElementById('toast');
    if (toast && toast.classList.contains('show')) {
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3500);
    }

    // 2. Interactive Scrolling Navbar
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 30) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // 3. Dynamic Ripple Effect for Buttons
    const buttons = document.querySelectorAll('.btn, .btn-secondary');
    buttons.forEach(btn => {
        // Handle CSS positioning for ripple constraint
        if(window.getComputedStyle(btn).position === 'static') {
            btn.style.position = 'relative';
        }
        
        btn.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size/2;
            const y = e.clientY - rect.top - size/2;

            const ripple = document.createElement('span');
            ripple.style.position = 'absolute';
            ripple.style.width = size + 'px';
            ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.style.background = 'rgba(0, 0, 0, 0.1)';
            
            // Adjust ripple color based on button type
            if(this.classList.contains('btn') && !this.classList.contains('btn-secondary')){
                ripple.style.background = 'rgba(255, 255, 255, 0.2)';
            }
            
            ripple.style.borderRadius = '50%';
            ripple.style.transform = 'scale(0)';
            ripple.style.animation = 'ripple-effect 0.6s ease-out';
            ripple.style.pointerEvents = 'none';

            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});
