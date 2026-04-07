<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Offres - Stages MMI</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../assets/js/tailwind.config.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
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
            <li><a href="../index.html" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Accueil</a></li>
            <li><a href="offres.html" class="nav-link active font-medium text-slate-700 hover:text-brandStart transition-colors">Offres</a></li>
            <li><a href="suivi-recherches.html" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Recherches</a></li>
            <li><a href="soutenances.html" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Soutenance</a></li>
            <li><a href="profil.html" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Profil</a></li>
            <li><a href="../login.html" class="md:ml-4 bg-red-50 text-red-600 px-5 py-2 rounded-full text-sm font-bold hover:bg-red-100 transition-colors">Déconnexion</a></li>
        </ul>
    </nav>

    <main class="flex-grow pt-32 pb-16 px-6 max-w-7xl mx-auto w-full">
        <section class="mb-10 flex flex-col md:flex-row md:justify-between md:items-end gap-4">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">Offres de stages</h2>
                <p class="text-slate-500 mt-2">Consultez et postulez aux offres validées par le département.</p>
            </div>
            <div class="w-full md:w-80">
                <input type="text" id="search-input" placeholder="Rechercher par mot-clé, ville..." class="w-full bg-white border border-slate-200 px-5 py-3 rounded-xl focus:ring-2 focus:ring-brandEnd outline-none shadow-sm transition-shadow">
            </div>
        </section>
        
        <div id="loading-status" class="hidden text-center py-10">
            <p class="text-slate-500 font-medium animate-pulse">Recherche des offres en cours...</p>
        </div>

        <section id="offres-grid" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            </section>
    </main>

    <div id="modal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-[100] transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto flex flex-col">
            <div class="flex justify-between items-start p-6 border-b border-slate-100 sticky top-0 bg-white/95 backdrop-blur z-10">
                <div>
                    <h2 id="modal-title" class="text-2xl font-bold text-slate-800 pr-4">Chargement...</h2>
                    <p id="modal-company" class="font-medium text-brandStart mt-1"></p>
                </div>
                <button id="modal-close" class="text-slate-400 hover:text-slate-800 transition-colors bg-slate-100 hover:bg-slate-200 rounded-full p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6">
                <div id="modal-loader" class="text-center py-8">
                    <p class="text-slate-500 text-sm italic">Récupération des données...</p>
                </div>
                <div id="modal-content" class="hidden">
                    <div class="flex flex-wrap gap-2 mb-6" id="modal-tags"></div>
                    <h4 class="font-bold text-slate-800 mb-2">Description du poste</h4>
                    <p id="modal-desc" class="text-slate-600 text-sm leading-relaxed mb-6"></p>
                    <div class="grid grid-cols-2 gap-4 text-sm mb-6 bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <div><span class="text-slate-400 block text-xs mb-1">Période</span><span id="modal-period" class="font-medium text-slate-700"></span></div>
                        <div><span class="text-slate-400 block text-xs mb-1">Rémunération</span><span id="modal-remun" class="font-medium text-slate-700"></span></div>
                        <div><span class="text-slate-400 block text-xs mb-1">Contact</span><span id="modal-contact" class="font-medium text-slate-700"></span></div>
                    </div>
                    <h4 class="font-bold text-slate-800 mb-3">Compétences requises</h4>
                    <div id="modal-skills" class="flex flex-wrap gap-2 mb-2"></div>
                </div>
            </div>
            <div class="p-6 border-t border-slate-100 bg-slate-50 rounded-b-2xl flex justify-end">
                <button id="modal-postuler" class="rounded-xl bg-slate-800 text-white font-bold py-3 px-8 hover:bg-brandStart transition-colors shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
                    Postuler à cette offre
                </button>
            </div>
        </div>
    </div>

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
                            <li><a href="../index.html" class="hover:text-brandStart transition-colors">Accueil</a></li>
                            <li><a href="offres.html" class="hover:text-brandStart transition-colors">Offres de stages</a></li>
                            <li><a href="suivi-recherches.html" class="hover:text-brandStart transition-colors">Mes recherches</a></li>
                            <li><a href="soutenances.html" class="hover:text-brandStart transition-colors">Soutenance</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-xs">Ressources</h4>
                        <ul class="space-y-3 text-sm text-slate-400">
                            <li><a href="profil.html" class="hover:text-brandStart transition-colors">Mon Profil</a></li>
                            <li><a href="#" class="hover:text-brandStart transition-colors">Conventions (ESUP)</a></li>
                            <li><a href="#" class="hover:text-brandStart transition-colors">Mentions légales</a></li>
                            <li><a href="#" class="hover:text-brandStart transition-colors">Contact IUT</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-500 text-sm">© 2026 MMI Meaux. Tous droits réservés.</p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-brandStart hover:text-white transition-all"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-brandStart hover:text-white transition-all"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="../assets/js/script.js"></script>
</body>
</html>