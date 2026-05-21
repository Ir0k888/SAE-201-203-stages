<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrateur') {
    die("Accès formellement restreint à la gouvernance. <a href='../index.php'>Retour</a>");
}

// 1. Enseignants n'ayant pas encore d'accès actif
$stmt1 = $pdo->query("SELECT * FROM Enseignant WHERE statut_compte = 'en_attente'");
$profs_en_attente = $stmt1->fetchAll();

// 2. Enseignants demandant une promotion hiérarchique
$stmt2 = $pdo->query("SELECT * FROM Enseignant WHERE role_demande IS NOT NULL AND statut_compte = 'valide'");
$demandes_roles = $stmt2->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Validation & Permissions — Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen p-8">
    <div class="max-w-5xl mx-auto flex flex-col gap-8">
        <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Centre de Modération des Comptes</h1>
                <p class="text-xs text-slate-400">Droits d'attribution et validation des accès applicatifs.</p>
            </div>
            <a href="../index.php" class="bg-slate-100 px-4 py-2 rounded-lg font-bold text-xs hover:bg-slate-200">Retour Accueil</a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="bg-slate-900 px-6 py-4"><h2 class="text-white font-bold text-sm">1. Nouvelles Demandes d'Inscriptions Enseignants</h2></div>
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 font-bold uppercase tracking-wider">
                    <tr><th class="p-4">Identité</th><th class="p-4">E-mail</th><th class="p-4 text-right">Actions</th></tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    <?php if(empty($profs_en_attente)): ?>
                        <tr><td colspan="3" class="p-4 text-center text-slate-400 italic">Aucune inscription en attente.</td></tr>
                    <?php else: foreach($profs_en_attente as $p): ?>
                        <tr>
                            <td class="p-4 font-semibold"><?= htmlspecialchars($p['nom'] . ' ' . $p['prenom']) ?></td>
                            <td class="p-4 text-slate-500"><?= htmlspecialchars($p['email']) ?></td>
                            <td class="p-4 text-right space-x-2">
                                <a href="../actions/valider_compte.php?id=<?=$p['id_enseignant']?>&action=valider&target=compte" class="bg-emerald-100 text-emerald-800 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-emerald-200">Approuver</a>
                                <a href="../actions/valider_compte.php?id=<?=$p['id_enseignant']?>&action=refuser&target=compte" class="bg-red-100 text-red-800 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-200" onclick="return confirm('Supprimer définitivement la demande ?');">Refuser</a>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="bg-slate-900 px-6 py-4"><h2 class="text-white font-bold text-sm">2. Demandes d'Évolutions de Rôles Internes</h2></div>
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 font-bold uppercase tracking-wider">
                    <tr><th class="p-4">Identité</th><th class="p-4">Rôle Actuel</th><th class="p-4">Privilège Demandé</th><th class="p-4 text-right">Actions</th></tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    <?php if(empty($demandes_roles)): ?>
                        <tr><td colspan="4" class="p-4 text-center text-slate-400 italic">Aucune requête d'évolution de grade en attente.</td></tr>
                    <?php else: foreach($demandes_roles as $dr): ?>
                        <tr>
                            <td class="p-4 font-semibold"><?= htmlspecialchars($dr['nom'] . ' ' . $dr['prenom']) ?></td>
                            <td class="p-4"><span class="bg-slate-100 px-2 py-1 rounded text-xs"><?= htmlspecialchars($dr['role']) ?></span></td>
                            <td class="p-4"><span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-bold"><?= htmlspecialchars($dr['role_demande']) ?></span></td>
                            <td class="p-4 text-right space-x-2">
                                <a href="../actions/valider_compte.php?id=<?=$dr['id_enseignant']?>&action=valider&target=role" class="bg-emerald-100 text-emerald-800 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-emerald-200">Accorder</a>
                                <a href="../actions/valider_compte.php?id=<?=$dr['id_enseignant']?>&action=refuser&target=role" class="bg-red-100 text-red-800 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-200">Rejeter</a>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>