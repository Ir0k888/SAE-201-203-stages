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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex flex-col">
    
    <?php include 'includes/navbar.php'; ?>
    
    <main class="flex-grow p-8">
        <div class="max-w-6xl mx-auto space-y-10">
            
            <!-- BORDURE EPAISSIE ICI -->
            <div class="bg-white p-10 rounded-xl border-2 border-slate-300 shadow-sm">
                <h1 class="text-4xl font-black tracking-tight mb-2">Bonjour, <?= htmlspecialchars($prenom) ?></h1>
                <p class="text-slate-600 font-medium mb-8">Bienvenue sur votre espace. Que souhaitez-vous faire aujourd'hui ?</p>
                
                <div class="flex flex-wrap gap-4 pt-6 border-t border-slate-200">
                    <?php if ($role === 'Administrateur'): ?>
                        <a href="pages/validation_comptes.php" class="bg-slate-900 text-white font-bold text-sm px-6 py-3 rounded-lg hover:bg-slate-800 transition-colors">Modérer les comptes</a>
                    <?php elseif ($role === 'Etudiant'): ?>
                        <a href="pages/offres.php" style="background-color: #FD3956;" class="text-white font-bold text-sm px-6 py-3 rounded-lg hover:bg-[#651617] transition-colors">Voir les offres</a>
                        <a href="pages/suivi-recherches.php" class="bg-slate-900 text-white font-bold text-sm px-6 py-3 rounded-lg hover:bg-slate-800 transition-colors">Mes candidatures</a>
                    <?php else: ?>
                        <?php if (str_contains($role, 'Responsable de stage')): ?>
                            <a href="pages/offres.php" style="background-color: #FD3956;" class="text-white font-bold text-sm px-6 py-3 rounded-lg hover:bg-[#651617] transition-colors">Gérer les offres</a>
                            <a href="pages/gestion_stages.php" class="bg-slate-900 text-white font-bold text-sm px-6 py-3 rounded-lg hover:bg-slate-800 transition-colors">Valider les candidatures</a>
                        <?php endif; ?>
                        <a href="pages/suivi_etudiants.php" class="bg-white text-slate-900 font-bold text-sm px-6 py-3 rounded-lg hover:bg-slate-50 border-2 border-slate-300">Voir mes élèves (Tuteur)</a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($role === 'Etudiant'): ?>
                <div>
                    <div class="flex justify-between items-end mb-6">
                        <h2 class="text-2xl font-black tracking-tight text-slate-900">Dernières offres de stage</h2>
                        <a href="pages/offres.php" class="text-sm font-bold text-blue-600 hover:text-slate-900 transition-colors">Voir toutes les offres &rarr;</a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php if(empty($offres_preview)): ?>
                            <p class="text-sm text-slate-500 italic col-span-3">Aucune offre disponible.</p>
                        <?php else: foreach($offres_preview as $o): ?>
                            <!-- BORDURE EPAISSIE ICI -->
                            <div class="bg-white rounded-xl border-2 border-slate-300 shadow-sm overflow-hidden flex flex-col relative group">
                                <div class="h-20 bg-slate-900"></div>
                                <div class="absolute top-12 left-6 w-14 h-14 bg-white rounded-lg shadow-sm border-2 border-slate-200 flex items-center justify-center font-black text-2xl text-slate-900">
                                    <?= strtoupper(substr($o['entreprise'], 0, 1)) ?>
                                </div>
                                <div class="p-6 pt-10 flex-grow flex flex-col justify-between">
                                    <div>
                                        <h3 class="font-bold text-lg text-slate-900 mb-1 line-clamp-1 group-hover:text-blue-600 transition-colors"><?= htmlspecialchars($o['titre_offre']) ?></h3>
                                        <p class="text-sm font-semibold text-slate-500 mb-4"><?= htmlspecialchars($o['entreprise']) ?></p>
                                    </div>
                                    <a href="pages/offres.php" class="block w-full text-center bg-slate-50 border-2 border-slate-300 text-slate-700 font-bold py-2.5 rounded-lg text-sm hover:bg-slate-100 transition-colors">Consulter l'offre</a>
                                </div>
                            </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- BORDURES EPAISSIES ICI -->
                <div class="bg-white p-8 rounded-xl border-2 border-slate-300 shadow-sm">
                    <h3 class="font-black text-xl mb-4">Cadre Pédagogique</h3>
                    <button type="button" onclick="document.getElementById('modal-reglement').style.display='flex'" style="color: #FD3956;" class="text-sm font-bold hover:text-[#651617] transition-colors">Lire le règlement</button>
                </div>
                <div class="bg-white p-8 rounded-xl border-2 border-slate-300 shadow-sm">
                    <h3 class="font-black text-xl mb-4">FAQ & Aide</h3>
                    <a href="pages/faq.php" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors">Consulter la FAQ</a>
                </div>
            </div>
        </div>
    </main>

    <!-- MODAL REGLEMENT AVEC TEXTE DÉTAILLÉ -->
    <div id="modal-reglement" style="display: none;" class="fixed inset-0 bg-slate-900/80 z-50 items-center justify-center p-4">
        <div class="bg-white rounded-xl p-10 w-full max-w-3xl max-h-[80vh] overflow-y-auto shadow-2xl relative">
            <button type="button" onclick="document.getElementById('modal-reglement').style.display='none'" class="absolute top-6 right-6 text-slate-400 hover:text-rose-500 font-black text-3xl">&times;</button>
            <h2 class="text-3xl font-black mb-6 text-slate-900">Règlement des Stages</h2>
            
            <div class="text-sm text-slate-600 leading-relaxed space-y-4 mb-8">
                <p><strong class="text-slate-900">1. Objet du stage :</strong> Le stage a pour but de mettre en pratique les enseignements dispensés au sein du département MMI. Il s'inscrit dans le cadre obligatoire de la validation du diplôme.</p>
                <p><strong class="text-slate-900">2. Convention et début de mission :</strong> L'étudiant ne peut en aucun cas débuter sa mission en entreprise avant que la convention tripartite (IUT, Entreprise, Étudiant) ne soit officiellement signée par toutes les parties.</p>
                <p><strong class="text-slate-900">3. Assiduité et comportement :</strong> L'étudiant est soumis aux horaires et au règlement intérieur de l'organisme d'accueil. Il représente l'IUT et doit faire preuve de professionnalisme. Toute absence (maladie, urgence) doit être impérativement et immédiatement justifiée auprès de l'entreprise ET du secrétariat de l'IUT.</p>
                <p><strong class="text-slate-900">4. Confidentialité :</strong> L'étudiant s'engage à garder la plus stricte confidentialité sur les informations, méthodes et données internes recueillies pendant son stage. Si l'entreprise le demande, un accord de confidentialité spécifique (NDA) pourra être ajouté en annexe.</p>
                <p><strong class="text-slate-900">5. Évaluation :</strong> Le stage sera évalué sur trois critères : le comportement en entreprise (note attribuée par le tuteur professionnel), la rédaction d'un rapport de stage écrit, et une soutenance orale finale devant un jury pédagogique.</p>
            </div>

            <button type="button" onclick="document.getElementById('modal-reglement').style.display='none'" class="bg-slate-900 text-white font-bold px-8 py-3 rounded-lg hover:bg-slate-800 transition-colors">J'ai compris</button>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>