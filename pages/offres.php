<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$role = $_SESSION['role'] ?? '';
$type_compte = $_SESSION['type_compte'] ?? '';
$offres = $pdo->query("SELECT * FROM Offre_de_stage ORDER BY id_offre_de_stage DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue - MMI Stages</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8f9fa] text-slate-900 min-h-screen flex flex-col">

    <?php include '../includes/navbar.php'; ?>

    <main class="flex-grow p-8">
        <div class="max-w-6xl mx-auto flex flex-col gap-10">
            
            <div class="text-center py-6">
                <h1 class="text-4xl font-black tracking-tight mb-2">Explorez les opportunités</h1>
                <p class="text-slate-500">Postulez aux offres vérifiées par l'équipe pédagogique.</p>
            </div>

            <!-- CARTE ADMIN -->
            <?php if ($role === 'Administrateur'): ?>
                <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-sm">
                    <h2 class="font-bold text-lg mb-6">Publier une nouvelle offre</h2>
                    <form action="../actions/admin_ajouter_offre_action.php" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="text" name="titre_offre" placeholder="Titre du poste" required class="bg-white border border-slate-300 rounded-md px-4 py-2.5 text-sm focus:ring-1 focus:ring-slate-900 outline-none">
                        <input type="text" name="entreprise" placeholder="Nom de l'entreprise" required class="bg-white border border-slate-300 rounded-md px-4 py-2.5 text-sm focus:ring-1 focus:ring-slate-900 outline-none">
                        <input type="text" name="remuneration" placeholder="Rémunération" class="bg-white border border-slate-300 rounded-md px-4 py-2.5 text-sm focus:ring-1 focus:ring-slate-900 outline-none">
                        <textarea name="description" placeholder="Description du poste" required rows="2" class="bg-white border border-slate-300 rounded-md px-4 py-2.5 text-sm md:col-span-2 focus:ring-1 focus:ring-slate-900 outline-none"></textarea>
                        <button type="submit" class="bg-slate-900 text-white font-bold rounded-md hover:bg-slate-800 transition-colors">Ajouter au catalogue</button>
                    </form>
                </div>
            <?php endif; ?>

            <!-- GRILLE DES OFFRES -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php if (empty($offres)): ?>
                    <p class="text-sm text-slate-500 italic col-span-full text-center py-10">Aucune offre disponible.</p>
                <?php else: foreach($offres as $o): ?>
                    
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col relative">
                        <!-- BANNIÈRE BLEU NUIT ET LOGO SUPERPOSÉ -->
                        <div class="h-24 bg-slate-900"></div>
                        <div class="absolute top-16 left-6 w-16 h-16 bg-white rounded-xl shadow-sm border border-slate-200 flex items-center justify-center font-black text-3xl text-slate-900">
                            <?= strtoupper(substr($o['entreprise'], 0, 1)) ?>
                        </div>

                        <div class="p-6 pt-12 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-xl text-slate-900 leading-tight mb-1"><?= htmlspecialchars($o['titre_offre']) ?></h3>
                                <p class="text-sm font-semibold text-slate-500 mb-4"><?= htmlspecialchars($o['entreprise']) ?></p>
                                
                                <div class="flex gap-2 mb-6">
                                    <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-md text-xs font-semibold flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <?= htmlspecialchars($o['remuneration'] ?? 'Légale') ?>
                                    </span>
                                    <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-md text-xs font-semibold flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <?= htmlspecialchars($o['periode'] ?? 'ASAP') ?>
                                    </span>
                                </div>
                                
                                <p class="text-sm text-slate-600 mb-6 line-clamp-3 leading-relaxed"><?= htmlspecialchars($o['description']) ?></p>
                            </div>
                            
                            <?php if ($type_compte === 'etudiant'): ?>
                                <div class="flex gap-3 mt-auto">
                                    <button onclick="openModal('modal-postuler-<?= $o['id_offre_de_stage'] ?>')" class="flex-1 bg-white border border-slate-300 text-slate-900 font-semibold py-2.5 rounded-md text-sm hover:bg-slate-50 transition-colors">Postuler</button>
                                    <button onclick="openModal('modal-info-<?= $o['id_offre_de_stage'] ?>')" class="flex-1 bg-slate-900 text-white font-semibold py-2.5 rounded-md text-sm hover:bg-slate-800 transition-colors">En savoir plus</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- MODALES JS INCHANGÉES (INFO & POSTULER) -->
                    <!-- MODALE INFOS -->
                    <div id="modal-info-<?= $o['id_offre_de_stage'] ?>" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                        <div class="bg-white rounded-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-8 relative shadow-2xl">
                            <button onclick="closeModal('modal-info-<?= $o['id_offre_de_stage'] ?>')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-900 font-bold text-2xl">&times;</button>
                            <h2 class="text-3xl font-black tracking-tight mb-2"><?= htmlspecialchars($o['entreprise']) ?></h2>
                            <p class="text-lg font-medium text-slate-500 mb-8 pb-6 border-b border-slate-100">Poste : <?= htmlspecialchars($o['titre_offre']) ?></p>
                            <h3 class="font-bold text-lg mb-3">Descriptif du poste</h3>
                            <p class="text-sm text-slate-600 mb-6 leading-relaxed whitespace-pre-line"><?= htmlspecialchars($o['description']) ?></p>
                            <h3 class="font-bold text-lg mb-3">Profil recherché</h3>
                            <p class="text-sm text-slate-600 mb-8 leading-relaxed whitespace-pre-line"><?= htmlspecialchars($o['competences'] ?? 'Non précisé.') ?></p>
                            <div class="flex justify-end pt-6 border-t border-slate-100">
                                <button onclick="closeModal('modal-info-<?= $o['id_offre_de_stage'] ?>'); openModal('modal-postuler-<?= $o['id_offre_de_stage'] ?>')" class="bg-slate-900 text-white font-bold py-3 px-8 rounded-md text-sm hover:bg-slate-800">Postuler maintenant</button>
                            </div>
                        </div>
                    </div>

                    <!-- MODALE POSTULER (AVEC PJ) -->
                    <div id="modal-postuler-<?= $o['id_offre_de_stage'] ?>" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                        <div class="bg-white rounded-xl w-full max-w-md p-8 relative shadow-2xl">
                            <button onclick="closeModal('modal-postuler-<?= $o['id_offre_de_stage'] ?>')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-900 font-bold text-2xl">&times;</button>
                            <h2 class="text-2xl font-black tracking-tight mb-2">Candidature</h2>
                            <p class="text-sm font-medium text-slate-500 mb-6 pb-4 border-b border-slate-100"><?= htmlspecialchars($o['titre_offre']) ?> chez <?= htmlspecialchars($o['entreprise']) ?></p>
                            
                            <form action="../actions/etudiant_recherche_action.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="postuler_offre">
                                <input type="hidden" name="entreprise" value="<?= htmlspecialchars($o['entreprise']) ?>">
                                <input type="hidden" name="poste" value="<?= htmlspecialchars($o['titre_offre']) ?>">
                                
                                <div class="mb-8">
                                    <label class="block text-sm font-bold text-slate-900 mb-3">Joindre votre CV</label>
                                    <input type="file" name="piece_jointe" accept=".pdf,.doc,.docx" required class="w-full text-sm text-slate-500 border border-slate-300 rounded-md file:mr-4 file:py-2.5 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                                </div>
                                <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3 rounded-md text-sm hover:bg-slate-800 transition-colors">Envoyer ma candidature</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
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