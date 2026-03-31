document.addEventListener('DOMContentLoaded', () => {
    // 1. Toggle Login/Inscription
    const signUpBtn = document.getElementById('signUp');
    const signInBtn = document.getElementById('signIn');
    const container = document.getElementById('login-container');

    if (signUpBtn && signInBtn && container) {
        signUpBtn.addEventListener('click', () => container.classList.add("right-panel-active"));
        signInBtn.addEventListener('click', () => container.classList.remove("right-panel-active"));
    }

    // 2. Burger Menu Mobile (Fixé)
    const burger = document.getElementById('burger');
    const navLinks = document.getElementById('nav-links');
    
    if (burger && navLinks) {
        burger.addEventListener('click', () => {
            burger.classList.toggle('active'); // Anime la croix
            navLinks.classList.toggle('hidden'); // Alterne entre display: none et display: flex
            navLinks.classList.toggle('flex');
        });

        // Ferme le menu quand on clique sur un lien (sur mobile)
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                burger.classList.remove('active');
                navLinks.classList.add('hidden');
                navLinks.classList.remove('flex');
            });
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