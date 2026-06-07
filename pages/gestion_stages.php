<?php
session_start();
require_once '../config/database.php';

// VERROU STRICT : Responsable de stage uniquement
if (!isset($_SESSION['user_id']) || !str_contains($_SESSION['role'] ?? '', 'Responsable de stage')) {
    die("Accès réservé au Responsable de stage.");
}

$role = $_SESSION['role'];
$type_compte = $_SESSION['type_compte'];

$req_attente = $pdo->query("SELECT R.*, E.nom, E.prenom FROM Recherche_de_stage R JOIN Etudiant E ON R.id_etudiant = E.id_etudiant WHERE R.statut_candidature = 'attente'")->fetchAll();
$req_resumes = $pdo->query("SELECT R.*, E.nom, E.prenom FROM Recherche_de_stage R JOIN Etudiant E ON R.id_etudiant = E.id_etudiant WHERE R.statut_candidature = 'attente_validation'")->fetchAll();
$req_sans_tuteur = $pdo->query("
    SELECT R.entreprise, R.poste, E.id_etudiant, E.nom, E.prenom 
    FROM Recherche_de_stage R 
    JOIN Etudiant E ON R.id_etudiant = E.id_etudiant 
    WHERE R.statut_candidature = 'accepte' 
    AND E.id_etudiant NOT IN (SELECT id_etudiant FROM Prise_en_charge)
")->fetchAll();
$profs = $pdo->query("SELECT id_enseignant, nom, prenom FROM Enseignant WHERE statut_compte = 'valide'")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Stages - Responsable</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <?php include '../includes/navbar.php'; ?>

    <main class="flex-grow p-8">
        <div class="max-w-6xl mx-auto flex flex-col gap-8">
            <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                <div>
                    <h1 class="text-xl font-bold">Pipeline des Stages & Affiliations</h1>
                    <p class="text-xs text-slate-400">Validez les démarches des étudiants et assignez les tuteurs.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-8">
                    <!-- 1. Demandes initiales -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="bg-slate-900 px-4 py-3"><h2 class="text-white font-bold text-sm">1. Nouvelles candidatures déclarées</h2></div>
                        <div class="p-4 space-y-3">
                            <?php if(empty($req_attente)): ?><p class="text-xs text-slate-400 italic">Rien à valider.</p><?php endif; ?>
                            <?php foreach($req_attente as $r): ?>
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 text-sm flex justify-between items-center">
                                    <div>
                                         <span class="font-bold"><?= htmlspecialchars($r['prenom'].' '.$r['nom']) ?></span>
                                        <?php if($r['piece_jointe']): ?>
                                            <a href="../assets/uploads/cv/<?= htmlspecialchars($r['piece_jointe']) ?>" target="_blank" class="text-rose-600 font-bold text-xs ml-2 hover:underline">📄 Voir CV</a>
                                        <?php endif; ?>
                                        <br><span class="text-slate-500"><?= htmlspecialchars($r['entreprise']) ?> - <?= htmlspecialchars($r['poste']) ?></span>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="../actions/admin_stages_action.php?id=<?=$r['id_recherche']?>&action=valider_attente" class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold hover:bg-blue-200">OK (Entretien)</a>
                                        <a href="../actions/admin_stages_action.php?id=<?=$r['id_recherche']?>&action=refuser" class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-bold">Refuser</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- 2. Lecture des résumés d'entretiens -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="bg-blue-900 px-4 py-3"><h2 class="text-white font-bold text-sm">2. Comptes-rendus d'entretiens à lire</h2></div>
                        <div class="p-4 space-y-3">
                            <?php if(empty($req_resumes)): ?><p class="text-xs text-slate-400 italic">Aucun compte-rendu en attente.</p><?php endif; ?>
                            <?php foreach($req_resumes as $r): ?>
                                <div class="bg-blue-50 p-3 rounded-lg border border-blue-100 text-sm">
                                    <p class="font-bold text-blue-900 mb-1"><?= htmlspecialchars($r['prenom'].' '.$r['nom']) ?> <span class="text-xs text-blue-600 font-normal">chez <?= htmlspecialchars($r['entreprise']) ?></span></p>
                                    <p class="bg-white p-2 rounded border border-blue-100 text-slate-600 text-xs italic mb-2">"<?= nl2br(htmlspecialchars($r['resume_entretien'])) ?>"</p>
                                    <div class="flex gap-2">
                                        <a href="../actions/admin_stages_action.php?id=<?=$r['id_recherche']?>&action=valider_entretien" class="bg-emerald-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-emerald-700">Valider l'offre</a>
                                        <a href="../actions/admin_stages_action.php?id=<?=$r['id_recherche']?>&action=refuser" class="bg-red-100 text-red-800 px-3 py-1 rounded text-xs font-bold">Refuser</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- 3. Affiliations -->
                <div>
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden sticky top-24">
                        <div class="bg-emerald-900 px-4 py-3"><h2 class="text-white font-bold text-sm">3. Affiliation des Tuteurs (Stages validés)</h2></div>
                        <div class="p-4 space-y-3">
                            <?php if(empty($req_sans_tuteur)): ?><p class="text-xs text-slate-400 italic">Tous les étudiants ont un tuteur.</p><?php endif; ?>
                            <?php foreach($req_sans_tuteur as $etu): ?>
                                <form action="../actions/admin_stages_action.php" method="POST" class="bg-slate-50 p-3 rounded-lg border border-slate-200 text-sm">
                                    <input type="hidden" name="action" value="affilier_tuteur">
                                    <input type="hidden" name="id_etudiant" value="<?= $etu['id_etudiant'] ?>">
                                    <p class="font-bold text-slate-800 mb-2"><?= htmlspecialchars($etu['prenom'].' '.$etu['nom']) ?> <span class="text-xs font-normal text-slate-500">(<?= htmlspecialchars($etu['entreprise']) ?>)</span></p>
                                    <div class="flex gap-2">
                                        <select name="id_enseignant" required class="flex-grow bg-white border border-slate-300 rounded px-2 py-1 text-xs">
                                            <option value="" disabled selected>Choisir un tuteur...</option>
                                            <?php foreach($profs as $p): ?>
                                                <option value="<?= $p['id_enseignant'] ?>">Prof. <?= htmlspecialchars($p['nom'].' '.$p['prenom']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="bg-slate-800 text-white font-bold px-3 py-1 rounded text-xs hover:bg-slate-700">Affilier</button>
                                    </div>
                                </form>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include ($is_root ? '' : '../') . 'includes/footer.php'; ?>
</body>
</html>