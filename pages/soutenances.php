<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Soutenance - Stages MMI</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../assets/js/tailwind.config.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-slate-100 text-slate-800 font-sans flex flex-col min-h-screen">

    <nav class="fixed top-0 w-full flex justify-between items-center py-4 px-8 bg-white border-b border-slate-200 z-50">
        <div class="font-bold text-xl text-transparent bg-clip-text bg-gradient-to-r from-brandStart to-brandEnd">MMI Stages</div>
        <ul id="nav-links" class="hidden md:flex gap-8 items-center">
            <li><a href="../index.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Accueil</a></li>
            <li><a href="offres.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Offres</a></li>
            <li><a href="suivi-recherches.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Recherches</a></li>
            <li><a href="soutenances.php" class="nav-link active font-medium text-slate-700 hover:text-brandStart transition-colors">Soutenance</a></li>
            <li><a href="profil.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Profil</a></li>
            <li><a href="../login.php" class="ml-4 bg-red-50 text-red-600 px-5 py-2 rounded-full text-sm font-bold hover:bg-red-100 transition-colors">Déconnexion</a></li>
        </ul>
    </nav>

    <main class="flex-grow pt-32 pb-16 px-6 max-w-5xl mx-auto w-full">
        <section class="reveal opacity-0 translate-y-7 transition-all duration-700 ease-out mb-8">
            <h2 class="text-3xl font-bold text-slate-800">Soutenance & Évaluation</h2>
            <p class="text-slate-500 mt-2">Détails de votre convocation et notes finales.</p>
        </section>
        
        <section class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="reveal opacity-0 translate-y-7 transition-all duration-700 delay-100 ease-out bg-white p-10 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="text-xl font-bold text-slate-800 mb-8 border-b border-slate-100 pb-4">Convocation Officielle</h3>
                
                <div class="space-y-6">
                    <div>
                        <span class="block text-sm text-slate-400 mb-1 uppercase tracking-wider font-semibold">Date & Heure</span>
                        <span class="text-lg text-slate-800 font-medium">Mardi 15 Juin 2026 — 14h00</span>
                    </div>
                    <div>
                        <span class="block text-sm text-slate-400 mb-1 uppercase tracking-wider font-semibold">Lieu de passage</span>
                        <span class="text-lg text-slate-800 font-medium">Amphithéâtre B104</span>
                    </div>
                    <div>
                        <span class="block text-sm text-slate-400 mb-1 uppercase tracking-wider font-semibold">Jury Évaluateur</span>
                        <span class="text-lg text-slate-800 font-medium">M. Martin & Mme. Durand</span>
                    </div>
                </div>
            </div>

            <div class="reveal opacity-0 translate-y-7 transition-all duration-700 delay-200 ease-out bg-white p-10 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-800 mb-8 border-b border-slate-100 pb-4">Relevé de notes</h3>
                    
                    <div class="flex justify-between items-center py-3">
                        <span class="text-slate-600 font-medium">Note du rapport écrit</span>
                        <span class="bg-slate-50 border border-slate-200 text-slate-500 py-1.5 px-3 rounded-lg font-bold text-sm">En attente</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-slate-600 font-medium">Note de l'oral</span>
                        <span class="bg-slate-50 border border-slate-200 text-slate-500 py-1.5 px-3 rounded-lg font-bold text-sm">En attente</span>
                    </div>
                </div>
                
                <div class="flex justify-between items-center pt-6 mt-6 border-t border-slate-100">
                    <span class="text-lg font-bold text-slate-800">Moyenne Globale</span>
                    <span class="text-4xl font-black text-slate-200">-- <span class="text-2xl text-slate-300">/ 20</span></span>
                </div>
            </div>
        </section>
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
                            <li><a href="../index.php" class="hover:text-brandStart transition-colors">Accueil</a></li>
                            <li><a href="offres.php" class="hover:text-brandStart transition-colors">Offres de stages</a></li>
                            <li><a href="suivi-recherches.php" class="hover:text-brandStart transition-colors">Mes recherches</a></li>
                            <li><a href="soutenances.php" class="hover:text-brandStart transition-colors">Soutenance</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-xs">Ressources</h4>
                        <ul class="space-y-3 text-sm text-slate-400">
                            <li><a href="profil.php" class="hover:text-brandStart transition-colors">Mon Profil</a></li>
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

    <script src="../assets/js/script.js"></script>
</body>
</html>