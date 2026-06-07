<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$role = $_SESSION['role'] ?? '';
$type_compte = $_SESSION['type_compte'] ?? '';

// Lecture globale des offres déposées
$offres = $pdo->query("SELECT * FROM Offre_de_stage ORDER BY id_offre_de_stage DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Offres de Stage - MMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <?php include '../includes/navbar.php'; ?>

    <main class="flex-grow p-8">
        <div class="max-w-6xl mx-auto flex flex-col gap-8">
            <div class="flex flex-col md:flex-row justify-between items-center bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Catalogue des Offres</h1>
                    <p class="text-sm text-slate-500 mt-2">Découvrez les opportunités professionnelles validées par l'IUT et postulez en un clic.</p>
                </div>
                <div class="mt-4 md:mt-0 text-right">
                    <span class="bg-blue-50 text-blue-700 font-bold px-4 py-2 rounded-full text-sm"><?= count($offres) ?> offres disponibles</span>
                </div>
            </div>

            <?php if ($role === 'Administrateur'): ?>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="font-bold text-slate-800 mb-4">Ajouter une offre de stage (Espace Admin)</h2>
                    <form action="../actions/admin_ajouter_offre_action.php" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="text" name="titre_offre" placeholder="Titre du poste (ex: Dev Front)" required class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm">
                        <input type="text" name="entreprise" placeholder="Nom de l'entreprise" required class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm">
                        <input type="text" name="remuneration" placeholder="Rémunération (ex: 800€/mois)" class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm">
                        <textarea name="description" placeholder="Description courte" required class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm md:col-span-2"></textarea>
                        <button type="submit" class="bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800">Publier l'offre</button>
                    </form>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (empty($offres)): ?>
                    <p class="text-sm text-slate-500 italic col-span-full text-center py-10">Aucune offre n'est publiée pour le moment.</p>
                <?php else: foreach($offres as $o): ?>
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg transition-shadow duration-300 flex flex-col overflow-hidden group">
                        
                        <div class="h-24 bg-gradient-to-r from-slate-800 to-slate-900 relative">
                            <div class="absolute -bottom-6 left-6 w-12 h-12 bg-white rounded-lg shadow-sm border border-slate-100 flex items-center justify-center font-black text-xl text-slate-800">
                                <?= strtoupper(substr($o['entreprise'], 0, 1)) ?>
                            </div>
                        </div>

                        <div class="p-6 pt-10 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-lg text-slate-900 group-hover:text-blue-600 transition-colors"><?= htmlspecialchars($o['titre_offre']) ?></h3>
                                <p class="text-sm font-semibold text-slate-500 mb-4"><?= htmlspecialchars($o['entreprise']) ?></p>
                                
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">💸 <?= htmlspecialchars($o['remuneration'] ?? 'Légale') ?></span>
                                    <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">📅 <?= htmlspecialchars($o['periode'] ?? 'ASAP') ?></span>
                                </div>
                                
                                <p class="text-sm text-slate-600 mb-6 line-clamp-3"><?= htmlspecialchars($o['description']) ?></p>
                            </div>
                            
                            <?php if ($type_compte === 'etudiant'): ?>
                                <form action="../actions/etudiant_recherche_action.php" method="POST">
                                    <input type="hidden" name="action" value="postuler_offre">
                                    <input type="hidden" name="entreprise" value="<?= htmlspecialchars($o['entreprise']) ?>">
                                    <input type="hidden" name="poste" value="<?= htmlspecialchars($o['titre_offre']) ?>">
                                    <button type="submit" class="w-full bg-slate-100 text-slate-800 font-bold py-3 rounded-xl text-sm hover:bg-slate-900 hover:text-white transition-colors">Postuler en un clic</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </main>
</body>
</html>