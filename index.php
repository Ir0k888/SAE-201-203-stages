<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) { 
    header('Location: login.php'); 
    exit(); 
}

$id_user = $_SESSION['user_id'];
$nom = $_SESSION['nom']; 
$prenom = $_SESSION['prenom']; 
$role = $_SESSION['role'] ?? 'Enseignant';
$type_compte = $_SESSION['type_compte'];

// VÉRIFICATION DU RGPD EN TEMPS RÉEL
$table_user = ($type_compte === 'enseignant') ? 'Enseignant' : 'Etudiant';
$id_col = ($type_compte === 'enseignant') ? 'id_enseignant' : 'id_etudiant';

$stmt_rgpd = $pdo->prepare("SELECT politique_acceptee FROM $table_user WHERE $id_col = ?");
$stmt_rgpd->execute([$id_user]);
$politique_acceptee = $stmt_rgpd->fetchColumn();

// Données de l'étudiant
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
<body class="bg-slate-50 text-slate-900 min-h-screen flex flex-col <?= ($politique_acceptee == 0) ? 'overflow-hidden' : '' ?>">
    
    <?php include 'includes/navbar.php'; ?>
    
    <main class="flex-grow p-8">
        <div class="max-w-6xl mx-auto space-y-10">
            
            <div class="bg-white p-10 rounded-xl border-2 border-slate-300 shadow-sm">
                <h1 class="text-4xl font-black tracking-tight mb-2">Bonjour, <?= htmlspecialchars($prenom) ?></h1>
                <p class="text-slate-600 font-medium mb-6">Bienvenue sur votre espace. Que souhaitez-vous faire aujourd'hui ?</p>
                
                <?php if ($type_compte === 'enseignant' && $role !== 'Administrateur'): ?>
                    <div class="mb-8 p-4 bg-slate-50 border-2 border-slate-200 rounded-lg inline-block">
                        <p class="text-sm text-slate-700 font-medium">
                            <span class="font-bold text-slate-900">Vos rôles attribués :</span> 
                            <span class="text-rose-600 font-bold ml-2"><?= htmlspecialchars($role) ?></span>
                        </p>
                    </div>
                <?php endif; ?>

                <div class="flex flex-wrap gap-4 pt-6 border-t border-slate-200">
                    <?php if ($role === 'Administrateur'): ?>
                        <a href="pages/validation_comptes.php" class="bg-slate-900 text-white font-bold text-sm px-6 py-3 rounded-lg hover:bg-slate-800 transition-colors">Modérer les comptes</a>
                        <a href="pages/admin_soutenances.php" style="background-color: #FD3956;" class="text-white font-bold text-sm px-6 py-3 rounded-lg hover:bg-[#651617] transition-colors">Valider les dates de soutenance</a>
                    
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
                <!-- RÈGLES ET FONCTIONNEMENT -->
                <div class="bg-white p-8 rounded-xl border-2 border-slate-300 shadow-sm">
                    <h3 class="font-black text-xl mb-4">Fonctionnement du site</h3>
                    <button type="button" onclick="document.getElementById('modal-fonctionnement').style.display='flex'" style="color: #FD3956;" class="text-sm font-bold hover:text-[#651617] transition-colors">Découvrir les règles d'utilisation</button>
                </div>
                <div class="bg-white p-8 rounded-xl border-2 border-slate-300 shadow-sm">
                    <h3 class="font-black text-xl mb-4">FAQ & Aide</h3>
                    <a href="pages/faq.php" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors">Consulter la FAQ</a>
                </div>
            </div>
        </div>
    </main>

    <!-- MODALE OBLIGATOIRE RGPD / COOKIES -->
    <?php if ($politique_acceptee == 0): ?>
    <div class="fixed inset-0 bg-slate-900/95 z-[100] flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl p-10 w-full max-w-2xl shadow-2xl relative">
            <h2 class="text-3xl font-black mb-4 text-slate-900">Bienvenue sur la plateforme !</h2>
            <div class="text-sm text-slate-600 mb-8 leading-relaxed space-y-4">
                <p>Avant d'accéder à votre espace, vous devez impérativement accepter notre politique d'utilisation et de protection des données (RGPD).</p>
                <p><strong>Traitement des données :</strong> Vos informations (Nom, prénom, CV, adresse email institutionnelle) sont enregistrées dans notre base de données locale dans le but exclusif du suivi pédagogique de vos stages et soutenances.</p>
                <p><strong>Cookies :</strong> Le site utilise un cookie de session strictement nécessaire pour maintenir votre connexion sécurisée. Aucun suivi publicitaire n'est effectué.</p>
            </div>
            
            <div class="flex justify-end gap-4 border-t border-slate-100 pt-6">
                <a href="actions/logout_action.php?msg=refus_politique" class="bg-slate-100 text-slate-700 font-bold px-6 py-3 rounded-lg hover:bg-slate-200 transition-colors">Je refuse</a>
                <form action="actions/accepter_politique_action.php" method="POST">
                    <input type="hidden" name="type_compte" value="<?= htmlspecialchars($type_compte) ?>">
                    <button type="submit" style="background-color: #FD3956;" class="text-white font-bold px-8 py-3 rounded-lg hover:bg-[#651617] transition-colors shadow-sm">J'accepte et je continue</button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- MODAL FONCTIONNEMENT DÉTAILLÉ -->
    <div id="modal-fonctionnement" style="display: none;" class="fixed inset-0 bg-slate-900/80 z-50 items-center justify-center p-4">
        <div class="bg-white rounded-xl p-10 w-full max-w-4xl max-h-[85vh] overflow-y-auto shadow-2xl relative">
            <button type="button" onclick="document.getElementById('modal-fonctionnement').style.display='none'" class="absolute top-6 right-6 text-slate-400 hover:text-rose-500 font-black text-3xl">&times;</button>
            <h2 class="text-3xl font-black mb-2 text-slate-900">Règles et Fonctionnement</h2>
            <p class="text-slate-500 font-medium mb-8">Guide complet d'utilisation de la plateforme MMI Stages.</p>
            
            <div class="space-y-6 text-sm text-slate-700">
                
                <div class="bg-slate-50 p-6 rounded-xl border-2 border-slate-200">
                    <h3 class="font-black text-xl text-slate-900 mb-3 text-rose-600">Le rôle : Étudiant</h3>
                    <p class="mb-3 leading-relaxed">Dès votre inscription, votre première tâche est de <strong>compléter votre profil</strong> (photo, bio, informations de contact). Ces éléments sont nécessaires pour l'édition de vos conventions.</p>
                    <ul class="list-disc pl-5 space-y-2 font-medium text-slate-600">
                        <li><strong>Parcourir et Postuler :</strong> Vous avez accès à un catalogue d'offres de stage triées sur le volet. Vous pouvez postuler en un clic en joignant obligatoirement un CV au format PDF.</li>
                        <li><strong>Suivi des candidatures :</strong> Retrouvez l'état de vos demandes (En attente, Entretien, Validé) depuis l'onglet "Mes candidatures".</li>
                        <li><strong>Soutenance :</strong> Une fois votre stage validé, les informations sur votre tuteur pédagogique, la date et le lieu de votre oral final apparaîtront dans l'onglet Soutenance.</li>
                    </ul>
                </div>

                <div class="bg-slate-50 p-6 rounded-xl border-2 border-slate-200">
                    <h3 class="font-black text-xl text-slate-900 mb-3 text-rose-600">Le rôle : Professeur</h3>
                    <p class="mb-3 leading-relaxed">Les enseignants s'inscrivent sur la plateforme et doivent patienter jusqu'à ce que l'Administrateur valide leur compte et leur attribue un ou plusieurs rôles spécifiques :</p>
                    <ul class="list-disc pl-5 space-y-2 font-medium text-slate-600">
                        <li><strong>Responsable de Stage :</strong> Vous gérez la bibliothèque des offres. Vous pouvez ajouter, modifier ou supprimer des fiches de stage. C'est également vous qui recevez les CV des étudiants et qui avez le bouton final pour "Valider le stage".</li>
                        <li><strong>Responsable de Soutenance :</strong> Vous organisez la fin de l'année. Vous affiliez un étudiant à un professeur jury et vous soumettez une "proposition de date" via la plateforme.</li>
                        <li><strong>Tuteur Pédagogique :</strong> Tout professeur peut consulter la liste et l'état d'avancement des élèves dont il a la charge.</li>
                    </ul>
                </div>

                <div class="bg-slate-50 p-6 rounded-xl border-2 border-slate-200">
                    <h3 class="font-black text-xl text-slate-900 mb-3 text-rose-600">Le rôle : Administrateur</h3>
                    <p class="leading-relaxed font-medium text-slate-600">L'administrateur est le garant de la cohérence globale. Il valide les comptes enseignants fraîchement créés afin de bloquer les intrusions externes. Il a le pouvoir d'attribuer les permissions (les rôles) aux professeurs. Enfin, il vérifie le planning général en étant la seule personne capable de <strong>valider définitivement les dates de soutenance</strong> proposées par les responsables.</p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end">
                <button type="button" onclick="document.getElementById('modal-fonctionnement').style.display='none'" class="bg-slate-900 text-white font-bold px-8 py-3 rounded-lg hover:bg-slate-800 transition-colors">J'ai compris</button>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>