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
                <?php else: ?>
                    <?php foreach($offres as $o): ?>
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
                                    <div class="flex gap-3 mt-4">
                                        <button onclick="openModal('modal-postuler-<?= $o['id_offre_de_stage'] ?>')" class="flex-1 bg-white border border-slate-300 text-slate-700 font-bold py-2.5 rounded-lg text-sm hover:bg-slate-50 transition-colors">Postuler</button>
                                        <button onclick="openModal('modal-info-<?= $o['id_offre_de_stage'] ?>')" class="flex-1 bg-slate-900 text-white font-bold py-2.5 rounded-lg text-sm hover:bg-slate-800 transition-colors">En savoir plus</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div id="modal-info-<?= $o['id_offre_de_stage'] ?>" class="hidden fixed inset-0 bg-slate-900/80 z-50 flex items-center justify-center p-4">
                            <div class="bg-white rounded-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto p-8 relative">
                                <button onclick="closeModal('modal-info-<?= $o['id_offre_de_stage'] ?>')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-900 font-bold text-xl">&times;</button>
                                
                                <h2 class="text-3xl font-black text-slate-900 mb-2"><?= htmlspecialchars($o['entreprise']) ?></h2>
                                <p class="text-lg text-slate-500 mb-8 pb-6 border-b border-slate-100">Poste : <?= htmlspecialchars($o['titre_offre']) ?></p>
                                
                                <h3 class="text-xl font-bold mb-4">Descriptif du poste</h3>
                                <p class="text-slate-600 mb-8 whitespace-pre-line"><?= htmlspecialchars($o['description']) ?></p>
                                
                                <h3 class="text-xl font-bold mb-4">Profil recherché</h3>
                                <p class="text-slate-600 mb-8 whitespace-pre-line"><?= htmlspecialchars($o['competences'] ?? 'Non précisé. Soyez vous-même !') ?></p>
                                
                                <h3 class="text-xl font-bold mb-4">Comment nous rejoindre ?</h3>
                                <p class="text-slate-600 mb-8">Processus de recrutement rapide en 2 étapes. Postulez directement via le bouton ci-dessous pour transmettre votre dossier à notre équipe technique.</p>
                                
                                <div class="flex justify-end pt-6 border-t border-slate-100">
                                    <button onclick="closeModal('modal-info-<?= $o['id_offre_de_stage'] ?>'); openModal('modal-postuler-<?= $o['id_offre_de_stage'] ?>')" class="bg-slate-900 text-white font-bold py-3 px-8 rounded-xl text-sm hover:bg-slate-800">Je postule !</button>
                                </div>
                            </div>
                        </div>

                        <div id="modal-postuler-<?= $o['id_offre_de_stage'] ?>" class="hidden fixed inset-0 bg-slate-900/90 z-50 flex items-center justify-center p-4">
                            <div class="bg-white rounded-2xl w-full max-w-md p-8 relative">
                                <button onclick="closeModal('modal-postuler-<?= $o['id_offre_de_stage'] ?>')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-900 font-bold text-xl">&times;</button>
                                
                                <h2 class="text-2xl font-black text-slate-900 mb-2">Candidature</h2>
                                <p class="text-sm text-slate-500 mb-6">Pour le poste de <?= htmlspecialchars($o['titre_offre']) ?> chez <?= htmlspecialchars($o['entreprise']) ?>.</p>
                                
                                <form action="../actions/etudiant_recherche_action.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="action" value="postuler_offre">
                                    <input type="hidden" name="entreprise" value="<?= htmlspecialchars($o['entreprise']) ?>">
                                    <input type="hidden" name="poste" value="<?= htmlspecialchars($o['titre_offre']) ?>">
                                    
                                    <div class="mb-6">
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Ajouter un document (CV)</label>
                                        <input type="file" name="piece_jointe" accept=".pdf,.doc,.docx" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 border border-slate-200 rounded-lg p-2">
                                        <p class="text-xs text-slate-400 mt-2">Format PDF recommandé.</p>
                                    </div>
                                    
                                    <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3 rounded-xl text-sm hover:bg-slate-800 transition-colors">Envoyer ma candidature</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>

    <script>
        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    </script>
</body>
</html>