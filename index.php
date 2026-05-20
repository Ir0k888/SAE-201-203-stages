<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Stages MMI</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="assets/js/tailwind.config.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-slate-100 text-slate-800 font-sans flex flex-col min-h-screen">

    <nav class="fixed top-0 w-full flex justify-between items-center py-4 px-8 bg-white border-b border-slate-200 z-50">
        <div class="font-bold text-xl text-transparent bg-clip-text bg-gradient-to-r from-brandStart to-brandEnd">MMI Stages</div>
        <div class="burger hidden flex-col justify-center gap-1.5 w-7 h-5 cursor-pointer z-[1100] md:hidden" id="burger">
            <span class="block h-0.5 w-full bg-slate-800 rounded transition-transform duration-300"></span>
            <span class="block h-0.5 w-full bg-slate-800 rounded transition-opacity duration-300"></span>
            <span class="block h-0.5 w-full bg-slate-800 rounded transition-transform duration-300"></span>
        </div>
        <ul id="nav-links" class="hidden absolute top-full left-0 w-full bg-white shadow-lg flex-col py-6 md:static md:flex md:flex-row md:w-auto md:bg-transparent md:shadow-none md:py-0 gap-8 items-center">
            <li><a href="index.php" class="nav-link active font-medium text-slate-700 hover:text-brandStart transition-colors">Accueil</a></li>
            <li><a href="pages/offres.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Offres</a></li>
            <li><a href="pages/suivi-recherches.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Recherches</a></li>
            <li><a href="pages/soutenances.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Soutenance</a></li>
            <li><a href="pages/profil.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Profil</a></li>
            <li><a href="login.php" class="md:ml-4 bg-red-50 text-red-600 px-5 py-2 rounded-full text-sm font-bold hover:bg-red-100 transition-colors">Déconnexion</a></li>
        </ul>
    </nav>

    <main class="flex-grow flex flex-col items-center justify-center pt-28 pb-16 px-8 text-center w-full">
        <div class="reveal opacity-0 translate-y-7 transition-all duration-700 ease-out max-w-3xl bg-white p-10 md:p-16 rounded-2xl border border-slate-100 shadow-sm">
            <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-6">Bonjour, Jean</h1>
            <p class="text-lg text-slate-500 mb-10 leading-relaxed">Bienvenue sur votre espace de gestion des stages. Utilisez le menu de navigation pour consulter les offres du département ou déclarer vos recherches personnelles.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="pages/offres.php" class="rounded-full bg-gradient-to-r from-brandStart to-brandEnd text-white font-bold py-3 px-8 hover:scale-105 transition-transform shadow-md">Voir les offres</a>
                <a href="pages/profil.php" class="rounded-full bg-slate-50 border border-slate-200 text-slate-700 font-bold py-3 px-8 hover:border-brandStart hover:text-brandStart transition-colors">Mon profil</a>
            </div>
        </div>
    </main>

    <footer class="bg-slate-900 pt-16 pb-8 mt-auto border-t-4 border-brandStart">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full">
            <div class="flex flex-col md:flex-row justify-between items-start gap-12 mb-16">
                
                <div class="md:w-1/3">
                    <h2 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-brandStart to-brandEnd mb-4">MMI Stages</h2>
                    <p class="text-slate-400 text-sm leading-relaxed">Plateforme officielle de gestion des stages du département Métiers du Multimédia et de l'Internet de l'IUT de Meaux. Conçue pour l'excellence.</p>
                </div>
                
                <div class="flex flex-wrap gap-12 md:gap-24">
                    <div>
                        <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-xs">Navigation</h4>
                        <ul class="space-y-3 text-sm text-slate-400">
                            <li><a href="index.php" class="hover:text-brandStart transition-colors">Accueil</a></li>
                            <li><a href="pages/offres.php" class="hover:text-brandStart transition-colors">Offres de stages</a></li>
                            <li><a href="pages/suivi-recherches.php" class="hover:text-brandStart transition-colors">Mes recherches</a></li>
                            <li><a href="pages/soutenances.php" class="hover:text-brandStart transition-colors">Soutenance</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-xs">Ressources</h4>
                        <ul class="space-y-3 text-sm text-slate-400">
                            <li><a href="pages/profil.php" class="hover:text-brandStart transition-colors">Mon Profil</a></li>
                            <li><a href="#" class="hover:text-brandStart transition-colors">Conventions (ESUP)</a></li>
                            <li><a href="#" class="hover:text-brandStart transition-colors">Mentions légales</a></li>
                            <li><a href="#" class="hover:text-brandStart transition-colors">Contact IUT</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-500 text-sm">© 2026 MMI Meaux. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>
</body>
</html>