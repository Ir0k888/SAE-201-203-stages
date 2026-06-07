<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$role = $_SESSION['role'];
$type_compte = $_SESSION['type_compte'];

// Si c'est un étudiant, on récupère 3 offres pour la preview
$offres_preview = [];
if ($role === 'Etudiant') {
    $offres_preview = $pdo->query("SELECT * FROM Offre_de_stage ORDER BY id_offre_de_stage DESC LIMIT 3")->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - MMI Stages</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8f9fa] text-slate-900 min-h-screen flex flex-col">
    
    <?php include 'includes/navbar.php'; ?>

    <main class="flex-grow p-8">
        <div class="max-w-6xl mx-auto space-y-10">
            
            <!-- EN-TÊTE NOTION STYLE -->
            <div class="bg-white p-10 rounded-xl border border-slate-200 shadow-sm">
                <h1 class="text-4xl font-black tracking-tight mb-2">Bonjour, <?= htmlspecialchars($prenom) ?> 👋</h1>
                <p class="text-slate-500 mb-8">Bienvenue sur votre espace de gestion des stages de l'IUT.</p>
                
                <div class="flex gap-4 border-t border-slate-100 pt-6">
                    <?php if ($role === 'Administrateur'): ?>
                        <a href="pages/validation_comptes.php" class="bg-slate-900 text-white font-semibold text-sm px-6 py-3 rounded-lg hover:bg-slate-800 transition-colors">Modérer les comptes</a>
                        <a href="pages/offres.php" class="border border-slate-300 text-slate-700 font-semibold text-sm px-6 py-3 rounded-lg hover:bg-slate-50 transition-colors">Gérer les offres</a>
                    <?php elseif ($role === 'Etudiant'): ?>
                        <a href="pages/suivi-recherches.php" class="bg-slate-900 text-white font-semibold text-sm px-6 py-3 rounded-lg hover:bg-slate-800 transition-colors">Gérer mes candidatures</a>
                        <a href="pages/profil.php" class="border border-slate-300 text-slate-700 font-semibold text-sm px-6 py-3 rounded-lg hover:bg-slate-50 transition-colors">Mettre à jour mon profil</a>
                    <?php else: ?>
                        <?php if (str_contains($role, 'Responsable de stage')): ?>
                            <a href="pages/gestion_stages.php" class="bg-slate-900 text-white font-semibold text-sm px-6 py-3 rounded-lg hover:bg-slate-800 transition-colors">Gérer le pipeline des stages</a>
                        <?php endif; ?>
                        <a href="pages/suivi_etudiants.php" class="border border-slate-300 text-slate-700 font-semibold text-sm px-6 py-3 rounded-lg hover:bg-slate-50 transition-colors">Voir mes élèves affiliés</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- APERÇU DES OFFRES (ÉTUDIANTS UNIQUEMENT) -->
            <?php if ($role === 'Etudiant'): ?>
                <div>
                    <div class="flex justify-between items-end mb-6">
                        <h2 class="text-2xl font-bold tracking-tight">Dernières offres de stage</h2>
                        <a href="pages/offres.php" class="text-sm font-semibold text-blue-600 hover:text-blue-800 hover:underline">Voir toutes les offres &rarr;</a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php if(empty($offres_preview)): ?>
                            <p class="text-sm text-slate-500 italic col-span-3">Aucune offre disponible.</p>
                        <?php else: foreach($offres_preview as $o): ?>
                            <!-- CARTE ÉPURÉE (Désactivée) -->
                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col relative">
                                <div class="h-20 bg-slate-900"></div>
                                <div class="absolute top-12 left-6 w-14 h-14 bg-white rounded-lg shadow-sm border border-slate-100 flex items-center justify-center font-black text-2xl text-slate-900">
                                    <?= strtoupper(substr($o['entreprise'], 0, 1)) ?>
                                </div>
                                <div class="p-6 pt-10">
                                    <h3 class="font-bold text-lg text-slate-900 mb-1 line-clamp-1"><?= htmlspecialchars($o['titre_offre']) ?></h3>
                                    <p class="text-sm font-medium text-slate-500 mb-4"><?= htmlspecialchars($o['entreprise']) ?></p>
                                    <a href="pages/offres.php" class="block w-full text-center bg-slate-50 border border-slate-200 text-slate-700 font-semibold py-2 rounded-lg text-sm hover:bg-slate-100 transition-colors">Consulter l'offre</a>
                                </div>
                            </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- INFORMATIONS GÉNÉRALES -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-sm">
                    <h3 class="font-bold text-lg mb-4">Informations IUT</h3>
                    <p class="text-sm text-slate-600 leading-relaxed mb-4">Le service des stages vous accompagne tout au long de votre démarche. N'oubliez pas de mettre à jour votre profil pour faciliter l'édition de vos conventions de stage.</p>
                    <a href="#" class="text-sm font-semibold text-blue-600 hover:underline">Lire le règlement des stages</a>
                </div>
                <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-sm">
                    <h3 class="font-bold text-lg mb-4">Besoin d'aide ?</h3>
                    <p class="text-sm text-slate-600 leading-relaxed mb-4">Si vous rencontrez un problème technique ou si vous avez besoin d'aide pour utiliser la plateforme, consultez notre base de connaissances.</p>
                    <a href="#" class="text-sm font-semibold text-blue-600 hover:underline">Consulter la FAQ</a>
                </div>
            </div>

        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>