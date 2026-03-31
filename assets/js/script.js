document.addEventListener('DOMContentLoaded', () => {
    // 1. Toggle Login/Inscription
    const signUpBtn = document.getElementById('signUp');
    const signInBtn = document.getElementById('signIn');
    const container = document.getElementById('login-container');

    if (signUpBtn && signInBtn) {
        signUpBtn.addEventListener('click', () => container.classList.add("right-panel-active"));
        signInBtn.addEventListener('click', () => container.classList.remove("right-panel-active"));
    }

    // 2. Burger Menu Mobile
    const burger = document.getElementById('burger');
    const navLinks = document.getElementById('nav-links');
    if (burger) {
        burger.addEventListener('click', () => {
            burger.classList.toggle('active');
            navLinks.classList.toggle('hidden');
            navLinks.classList.toggle('flex');
        });
    }

    // 3. Reveal au scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.remove('opacity-0', 'translate-y-7');
                entry.target.classList.add('opacity-100', 'translate-y-0');
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
});