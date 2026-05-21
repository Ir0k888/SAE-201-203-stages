<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrateur') {
    die("Accès réservé à l'administration.");
}

$query = "SELECT S.id_soutenance, S.date_soutenance, S.horaire, S.lieu, E.nom AS nom_etu, E.prenom AS prenom_etu, Prof.nom AS nom_prof 
          FROM Soutenance S
          JOIN Etudiant E ON S.id_etudiant = E.id_etudiant
          JOIN Enseignant Prof ON S.id_enseignant = Prof.id_enseignant
          WHERE S.statut_soutenance = 'en_attente'";
$soutenances = $pdo->query($query)->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Validation Soutenances - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen p-8">
    <div class="max-w-5xl mx-auto flex flex-col gap-8">
        <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div>
                <h1 class="text-xl font-bold">Validation des dates de Soutenance</h1>
                <p class="text-xs text-slate-400">Approuvez les horaires proposés par les tuteurs.</p>
            </div>
            <a href="../index.php" class="bg-slate-100 px-4 py-2 rounded-lg font-bold text-xs hover:bg-slate-200">Retour</a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 font-bold uppercase tracking-wider">
                    <tr><th class="p-4">Étudiant</th><th class="p-4">Proposé par</th><th class="p-4">Date & Lieu</th><th class="p-4 text-right">Actions</th></tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    <?php if(empty($soutenances)): ?>
                        <tr><td colspan="4" class="p-4 text-center text-slate-400 italic">Aucune date en attente de validation.</td></tr>
                    <?php else: foreach($soutenances as $s): ?>
                        <tr>
                            <td class="p-4 font-semibold"><?= htmlspecialchars($s['prenom_etu'] . ' ' . $s['nom_etu']) ?></td>
                            <td class="p-4 text-slate-500">Prof. <?= htmlspecialchars($s['nom_prof']) ?></td>
                            <td class="p-4">
                                <?= date('d/m/Y', strtotime($s['date_soutenance'])) ?> à <?= date('H:i', strtotime($s['horaire'])) ?><br>
                                <span class="text-xs text-slate-400"><?= htmlspecialchars($s['lieu']) ?></span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="../actions/valider_soutenance_action.php?id=<?=$s['id_soutenance']?>&action=valider" class="bg-emerald-100 text-emerald-800 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-emerald-200">Valider</a>
                                <a href="../actions/valider_soutenance_action.php?id=<?=$s['id_soutenance']?>&action=refuser" class="bg-red-100 text-red-800 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-200" onclick="return confirm('Refuser cette date ?');">Refuser</a>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>