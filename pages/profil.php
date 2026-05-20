<?php
// LE VIDEUR GLOBAL
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// On récupère le type de compte pour adapter l'affichage en bas
$type_compte = $_SESSION['type_compte'];
?>
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Profil - Stages MMI</title>
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
            
            <?php if ($type_compte === 'etudiant'): ?>
                <li><a href="offres.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Offres</a></li>
                <li><a href="suivi-recherches.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Recherches</a></li>
                <li><a href="soutenances.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Soutenance</a></li>
            <?php elseif ($_SESSION['role'] === 'Administrateur'): ?>
                <li><a href="validation_comptes.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Validation des comptes</a></li>
            <?php endif; ?>

            <li><a href="profil.php" class="nav-link active font-medium text-slate-700 hover:text-brandStart transition-colors">Profil</a></li>
            <li><a href="../actions/logout_action.php" class="ml-4 bg-red-50 text-red-600 px-5 py-2 rounded-full text-sm font-bold hover:bg-red-100 transition-colors">Déconnexion</a></li>
        </ul>
    </nav>

    <main class="flex-grow pt-32 pb-16 px-6 max-w-4xl mx-auto w-full">
        <section class="reveal opacity-0 translate-y-7 transition-all duration-700 ease-out mb-8">
            <h2 class="text-3xl font-bold text-slate-800">Mon Profil</h2>
            <p class="text-slate-500 mt-2">Mettez à jour vos informations personnelles.</p>
        </section>
        
        <section class="reveal opacity-0 translate-y-7 transition-all duration-700 delay-100 ease-out bg-white p-10 rounded-2xl border border-slate-100 shadow-sm">
            <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <?php if ($type_compte === 'etudiant'): ?>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Numéro étudiant (Matricule)</label>
                        <input type="text" value="20245678" readonly class="w-full bg-slate-50 text-slate-400 border border-slate-100 px-4 py-3 rounded-xl cursor-not-allowed">
                    </div>
                <?php endif; ?>

                <div class="<?= ($type_compte === 'enseignant') ? 'md:col-span-2' : '' ?>">
                    <label class="block text-sm font-medium text-slate-500 mb-1">Adresse E-mail</label>
                    <input type="email" value="<?= htmlspecialchars($_SESSION['nom'] ?? 'jean.dupont@etudiant.univ.fr') ?>" readonly class="w-full bg-slate-50 text-slate-400 border border-slate-100 px-4 py-3 rounded-xl cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nom</label>
                    <input type="text" value="<?= htmlspecialchars($_SESSION['nom'] ?? '') ?>" class="w-full bg-white border border-slate-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-brandEnd outline-none transition-shadow">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Prénom</label>
                    <input type="text" value="<?= htmlspecialchars($_SESSION['prenom'] ?? '') ?>" class="w-full bg-white border border-slate-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-brandEnd outline-none transition-shadow">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Adresse postale</label>
                    <input type="text" value="" class="w-full bg-white border border-slate-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-brandEnd outline-none transition-shadow">
                </div>
                
                <div class="<?= ($type_compte === 'enseignant') ? 'md:col-span-2' : '' ?>">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Numéro de téléphone</label>
                    <input type="tel" value="" class="w-full bg-white border border-slate-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-brandEnd outline-none transition-shadow">
                </div>

                <?php if ($type_compte === 'etudiant'): ?>
                    <div class="grid grid-cols-3 gap-4 md:col-span-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Promo</label>
                            <select class="w-full bg-white border border-slate-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-brandEnd outline-none">
                                <option>MMI 1</option>
                                <option selected>MMI 2</option>
                                <option>MMI 3</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">TD</label>
                            <select class="w-full bg-white border border-slate-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-brandEnd outline-none">
                                <option>A</option><option selected>B</option><option>C</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">TP</label>
                            <select class="w-full bg-white border border-slate-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-brandEnd outline-none">
                                <option>1</option><option>2</option><option selected>3</option><option>4</option>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="md:col-span-2 mt-6">
                    <button type="submit" class="w-full rounded-xl bg-slate-800 text-white font-bold py-4 px-6 uppercase tracking-wider hover:bg-brandStart transition-colors shadow-sm">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </section>
    </main>

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