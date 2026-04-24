document.addEventListener('DOMContentLoaded', () => {
    // Standard JS just to handle UI things like dismissing toast automatically.
    // The entire application relies on classical PHP routing now, with no APIs.

    const toast = document.getElementById('toast');
    if (toast && toast.classList.contains('show')) {
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }
});
