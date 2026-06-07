<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['type_compte'] !== 'etudiant') {
    header('Location: ../index.php');
    exit();
}

$id_etudiant = $_SESSION['user_id'];
$role = $_SESSION['role'] ?? '';
$type_compte = $_SESSION['type_compte'];

$stmt = $pdo->prepare("SELECT * FROM Recherche_de_stage WHERE id_etudiant = :id ORDER BY date_recherche DESC");
$stmt->execute(['id' => $id_etudiant]);
$recherches = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Candidatures - Stages MMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <?php include '../includes/navbar.php'; ?>

    <main class="flex-grow p-8">
        <div class="max-w-5xl mx-auto flex flex-col gap-6">
            <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                <div>
                    <h1 class="text-xl font-bold">Suivi de mes candidatures</h1>
                    <p class="text-xs text-slate-400">Gérez vos entretiens et validez vos offres de stage.</p>
                </div>
                <a href="offres.php" class="bg-slate-800 text-white px-6 py-2 rounded-lg font-bold text-xs hover:bg-slate-700">Parcourir le catalogue</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php if(empty($recherches)): ?>
                    <p class="text-slate-500 italic p-6 text-center col-span-2">Vous n'avez postulé à aucune offre pour le moment.</p>
                <?php endif; ?>
                
                <?php foreach ($recherches as $r): ?>
                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-lg"><?= htmlspecialchars($r['entreprise']) ?></h3>
                            <p class="text-sm text-slate-500 mb-3"><?= htmlspecialchars($r['poste']) ?></p>

                            <?php if ($r['statut_candidature'] === 'attente'): ?>
                                <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-bold">Demande en attente (Resp. Stage)</span>
                            
                            <?php elseif ($r['statut_candidature'] === 'entretien'): ?>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold mb-3 inline-block">Entretien Prévu !</span>
                                <form action="../actions/etudiant_recherche_action.php" method="POST" class="mt-2">
                                    <input type="hidden" name="action" value="soumettre_resume">
                                    <input type="hidden" name="id_recherche" value="<?= $r['id_recherche'] ?>">
                                    <textarea name="resume" required placeholder="Comment s'est passé l'entretien ? Avez-vous été retenu ?" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm mb-2" rows="3"></textarea>
                                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg text-xs hover:bg-blue-700">Envoyer le compte-rendu</button>
                                </form>
                            
                            <?php elseif ($r['statut_candidature'] === 'attente_validation'): ?>
                                <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-xs font-bold">Résumé envoyé (En attente de validation)</span>
                            
                            <?php elseif ($r['statut_candidature'] === 'entretien_effectue'): ?>
                                <div class="bg-emerald-50 border border-emerald-200 p-3 rounded-lg mb-2">
                                    <p class="text-emerald-800 font-bold text-sm mb-2">Offre débloquée !</p>
                                    <p class="text-xs text-emerald-600 mb-3">L'administration a validé votre entretien. Souhaitez-vous accepter ce stage ?</p>
                                    <div class="flex gap-2">
                                        <form action="../actions/etudiant_recherche_action.php" method="POST" class="flex-1">
                                            <input type="hidden" name="action" value="accepter_offre">
                                            <input type="hidden" name="id_recherche" value="<?= $r['id_recherche'] ?>">
                                            <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-2 rounded-md text-xs hover:bg-emerald-700">Accepter</button>
                                        </form>
                                        <form action="../actions/etudiant_recherche_action.php" method="POST" class="flex-1">
                                            <input type="hidden" name="action" value="refuser_offre">
                                            <input type="hidden" name="id_recherche" value="<?= $r['id_recherche'] ?>">
                                            <button type="submit" class="w-full bg-red-100 text-red-600 font-bold py-2 rounded-md text-xs hover:bg-red-200">Refuser</button>
                                        </form>
                                    </div>
                                </div>
                            
                            <?php elseif ($r['statut_candidature'] === 'accepte'): ?>
                                <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-xs font-bold inline-block mb-2">Stage Officiel Validé !</span>
                                <p class="text-xs text-slate-500">Le responsable va bientôt vous affilier un tuteur.</p>
                            
                            <?php elseif ($r['statut_candidature'] === 'refus'): ?>
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">Piste refusée / Annulée</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <?php include ($is_root ? '' : '../') . 'includes/footer.php'; ?>
</body>
</html>