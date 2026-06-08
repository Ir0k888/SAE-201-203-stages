<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) { header('Location: ../index.php'); exit(); }

$type_compte = $_SESSION['type_compte'] ?? '';

$check = $pdo->query("SELECT COUNT(*) FROM Offre_de_stage")->fetchColumn();
if ($check == 0) {
    $pdo->exec("INSERT INTO Offre_de_stage (titre_offre, entreprise, description, remuneration, periode) VALUES 
    ('Développeur Front-End', 'TechVision', 'Stage d\'intégration et développement web. Maintien et évolution des interfaces.', 'Gratuit', 'Juin'),
    ('Assistant Webmarketing', 'DigitalBoost', 'Aide au référencement et à l\'animation des réseaux sociaux. Créativité requise.', 'Gratuit', 'Juin'),
    ('UI/UX Designer', 'CreativeStudio', 'Participation à la refonte de nos applications mobiles. Prototypage sur Figma.', '800€', 'Avril'),
    ('Intégrateur Web', 'WebAgency Paris', 'Intégration de maquettes sous WordPress et PrestaShop. Bon niveau HTML/CSS exigé.', '800€', 'Avril'),
    ('Développeur Full-Stack', 'AnimPix', 'Participation active à la création d\'un SaaS complet. Autonomie requise sur PHP.', '1000€', 'Mai'),
    ('Chef de Projet Digital', 'InnovGroup', 'Assistance au pilotage de projets web, relation client, et spécifications fonctionnelles.', '1000€', 'Mai')");
}

$offres = $pdo->query("SELECT * FROM Offre_de_stage ORDER BY id_offre_de_stage DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue - MMI Stages</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex flex-col">

    <?php include '../includes/navbar.php'; ?>

    <main class="flex-grow p-8">
        <div class="max-w-6xl mx-auto flex flex-col gap-10">
            
            <div class="text-center py-6">
                <h1 class="text-4xl font-black tracking-tight mb-2 text-slate-900">Catalogue des Offres</h1>
                <p class="text-slate-500 font-medium">Postulez aux offres vérifiées par l'équipe pédagogique de l'IUT.</p>
            </div>

            <?php if ($type_compte === 'enseignant'): ?>
                <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-sm">
                    <h2 class="font-black text-xl mb-6 text-slate-900">Publier une nouvelle offre</h2>
                    <form action="../actions/prof_offres_action.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 font-medium">
                        <input type="hidden" name="action" value="ajouter">
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2">Titre du poste</label>
                            <input type="text" name="titre_offre" required class="w-full bg-white border border-slate-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-rose-400">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2">Entreprise</label>
                            <input type="text" name="entreprise" required class="w-full bg-white border border-slate-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-rose-400">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 mb-2">Description</label>
                            <textarea name="description" required rows="2" class="w-full bg-white border border-slate-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-rose-400"></textarea>
                        </div>
                        
                        <div class="md:col-span-2 text-right border-t border-slate-100 pt-4">
                            <button type="submit" style="background-color: #FD3956;" class="text-white font-bold px-8 py-3 rounded-lg hover:bg-[#651617] shadow-sm transition-colors">Publier l'offre</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php if (empty($offres)): ?>
                    <p class="text-sm font-bold text-slate-500 col-span-full text-center py-10 bg-white rounded-xl border border-slate-200">Aucune offre disponible.</p>
                <?php else: foreach($offres as $o): ?>
                    
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-lg transition-all flex flex-col relative overflow-hidden group">
                        
                        <?php if ($type_compte === 'enseignant'): ?>
                            <form action="../actions/prof_offres_action.php" method="POST" class="absolute top-4 right-4 z-20">
                                <input type="hidden" name="action" value="supprimer">
                                <input type="hidden" name="id_offre" value="<?= $o['id_offre_de_stage'] ?>">
                                <button type="submit" onclick="return confirm('Supprimer définitivement cette offre ?')" class="bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shadow-md hover:bg-red-700 hover:scale-110 transition-all">&times;</button>
                            </form>
                        <?php endif; ?>

                        <!-- BANNIÈRE BLEUE MARINE UNIE (Plus d'erreur PHP) -->
                        <div class="h-32 bg-slate-900 relative z-0"></div>
                        
                        <div class="absolute top-20 left-6 w-20 h-20 bg-white rounded-xl shadow-md border-2 border-slate-100 flex items-center justify-center font-black text-4xl text-slate-900 z-10">
                            <?= strtoupper(substr($o['entreprise'], 0, 1)) ?>
                        </div>

                        <div class="p-8 pt-14 flex-grow flex flex-col justify-between bg-white relative z-0">
                            <div>
                                <h3 class="font-black text-2xl text-slate-900 mb-1 leading-tight group-hover:text-blue-600 transition-colors"><?= htmlspecialchars($o['titre_offre']) ?></h3>
                                <p style="color: #FD3956;" class="text-base font-bold mb-6"><?= htmlspecialchars($o['entreprise']) ?></p>
                                <p class="text-sm font-medium text-slate-500 mb-8 line-clamp-3 leading-relaxed"><?= htmlspecialchars($o['description']) ?></p>
                            </div>
                            
                            <?php if ($type_compte === 'etudiant'): ?>
                                <div class="flex gap-4 mt-auto">
                                    <button type="button" onclick="openModal('modal-postuler-<?= $o['id_offre_de_stage'] ?>')" class="flex-1 bg-white border border-slate-300 text-slate-900 font-bold py-3 rounded-lg text-sm hover:bg-slate-50 transition-colors">Postuler</button>
                                    <button type="button" onclick="openModal('modal-info-<?= $o['id_offre_de_stage'] ?>')" class="flex-1 bg-slate-900 text-white font-bold py-3 rounded-lg text-sm hover:bg-slate-800 transition-colors shadow-sm">En savoir plus</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- MODALES REPARÉES AVEC JS PUR -->
                    <div id="modal-info-<?= $o['id_offre_de_stage'] ?>" style="display: none;" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-50 items-center justify-center p-4">
                        <div class="bg-white rounded-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto p-10 relative shadow-2xl">
                            <button type="button" onclick="closeModal('modal-info-<?= $o['id_offre_de_stage'] ?>')" class="absolute top-6 right-6 text-slate-400 hover:text-rose-500 font-black text-3xl">&times;</button>
                            <h2 class="text-4xl font-black tracking-tight mb-2 text-slate-900"><?= htmlspecialchars($o['entreprise']) ?></h2>
                            <p style="color: #FD3956;" class="text-lg font-bold mb-8 pb-6 border-b border-slate-100">Poste : <?= htmlspecialchars($o['titre_offre']) ?></p>
                            <h3 class="font-black text-xl mb-4 text-slate-900">Descriptif du poste</h3>
                            <p class="text-sm font-medium text-slate-600 mb-8 leading-relaxed whitespace-pre-line"><?= htmlspecialchars($o['description']) ?></p>
                            <div class="flex justify-end pt-6 border-t border-slate-100">
                                <button type="button" onclick="closeModal('modal-info-<?= $o['id_offre_de_stage'] ?>'); openModal('modal-postuler-<?= $o['id_offre_de_stage'] ?>')" class="bg-slate-900 text-white font-bold py-3 px-8 rounded-lg text-sm hover:bg-slate-800">Postuler</button>
                            </div>
                        </div>
                    </div>

                    <div id="modal-postuler-<?= $o['id_offre_de_stage'] ?>" style="display: none;" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-50 items-center justify-center p-4">
                        <div class="bg-white rounded-2xl w-full max-w-md p-10 relative shadow-2xl">
                            <button type="button" onclick="closeModal('modal-postuler-<?= $o['id_offre_de_stage'] ?>')" class="absolute top-6 right-6 text-slate-400 hover:text-rose-500 font-black text-3xl">&times;</button>
                            <h2 class="text-2xl font-black tracking-tight mb-2 text-slate-900">Candidature</h2>
                            <p style="color: #FD3956;" class="text-sm font-bold mb-6 pb-4 border-b border-slate-100"><?= htmlspecialchars($o['titre_offre']) ?></p>
                            <form action="../actions/etudiant_recherche_action.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="postuler_offre">
                                <input type="hidden" name="entreprise" value="<?= htmlspecialchars($o['entreprise']) ?>">
                                <input type="hidden" name="poste" value="<?= htmlspecialchars($o['titre_offre']) ?>">
                                <div class="mb-8">
                                    <label class="block text-sm font-bold text-slate-900 mb-3">Joindre votre CV (PDF)</label>
                                    <input type="file" name="piece_jointe" accept=".pdf,.doc,.docx" required class="w-full text-sm font-medium text-slate-500 border border-slate-300 rounded-lg file:mr-4 file:py-2.5 file:px-4 file:border-0 file:bg-slate-100 file:text-slate-700">
                                </div>
                                <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3 rounded-lg text-sm hover:bg-slate-800">Envoyer ma candidature</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>

    <script>
        function openModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
    </script>
</body>
</html>