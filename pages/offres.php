<?php
// LE VIDEUR
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['type_compte'] !== 'etudiant') {
    header('Location: ../index.php');
    exit();
}
?>
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
            <li><a href="../index.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Accueil</a></li>
            <li><a href="offres.php" class="nav-link active font-medium text-slate-700 hover:text-brandStart transition-colors">Offres</a></li>
            <li><a href="suivi-recherches.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Recherches</a></li>
            <li><a href="soutenances.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Soutenance</a></li>
            <li><a href="profil.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Profil</a></li>
            <li><a href="../actions/logout_action.php" class="md:ml-4 bg-red-50 text-red-600 px-5 py-2 rounded-full text-sm font-bold hover:bg-red-100 transition-colors">Déconnexion</a></li>
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
            <div class="border-t border-slate-800 pt-8 flex justify-center items-center">
                <p class="text-slate-500 text-sm">© 2026 MMI Meaux. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="../assets/js/script.js"></script>
</body>
</html>