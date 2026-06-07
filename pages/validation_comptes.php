<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrateur') {
    die("Accès formellement restreint à la gouvernance. <a href='../index.php'>Retour</a>");
}

$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$role = $_SESSION['role'];
$type_compte = $_SESSION['type_compte'];

// 1. Enseignants n'ayant pas encore d'accès actif
$profs_en_attente = $pdo->query("SELECT * FROM Enseignant WHERE statut_compte = 'en_attente'")->fetchAll();

// 2. Tous les Enseignants validés (pour modifier leurs rôles)
$profs_valides = $pdo->query("SELECT * FROM Enseignant WHERE statut_compte = 'valide' AND role != 'Administrateur'")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Validation & Permissions — Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">
    
    <?php include '../includes/navbar.php'; ?>

    <main class="flex-grow p-8">
        <div class="max-w-6xl mx-auto flex flex-col gap-8">
            <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Centre de Modération et Attribution des Rôles</h1>
                    <p class="text-xs text-slate-400">Gérez les inscriptions et affectez les pouvoirs pédagogiques.</p>
                </div>
            </div>

            <!-- TABLEAU 1 : NOUVELLES INSCRIPTIONS -->
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
                                    <a href="../actions/valider_compte_action.php?id=<?=$p['id_enseignant']?>&action=valider" class="bg-emerald-100 text-emerald-800 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-emerald-200">Approuver</a>
                                    <a href="../actions/valider_compte_action.php?id=<?=$p['id_enseignant']?>&action=refuser" class="bg-red-100 text-red-800 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-200">Refuser</a>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- TABLEAU 2 : ATTRIBUTION DES RÔLES -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-blue-900 px-6 py-4"><h2 class="text-white font-bold text-sm">2. Attribution des Rôles (Enseignants Actifs)</h2></div>
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 font-bold uppercase tracking-wider">
                        <tr><th class="p-4">Identité</th><th class="p-4 w-1/2">Affectation des droits</th><th class="p-4 text-right">Action</th></tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-100">
                        <?php foreach($profs_valides as $p): ?>
                            <tr>
                                <td class="p-4 font-semibold"><?= htmlspecialchars($p['nom'] . ' ' . $p['prenom']) ?></td>
                                <td class="p-4">
                                    <form action="../actions/admin_roles_action.php" method="POST" class="flex gap-4 items-center" id="form-role-<?= $p['id_enseignant'] ?>">
                                        <input type="hidden" name="id_enseignant" value="<?= $p['id_enseignant'] ?>">
                                        
                                        <label class="flex items-center gap-1 cursor-pointer">
                                            <input type="checkbox" name="roles[]" value="Responsable de stage" <?= str_contains($p['role'], 'Responsable de stage') ? 'checked' : '' ?> class="rounded text-blue-600">
                                            <span class="text-xs font-medium">Responsable de stage</span>
                                        </label>
                                        
                                        <label class="flex items-center gap-1 cursor-pointer">
                                            <input type="checkbox" name="roles[]" value="Membre du jury" <?= str_contains($p['role'], 'Membre du jury') ? 'checked' : '' ?> class="rounded text-blue-600">
                                            <span class="text-xs font-medium">Jury</span>
                                        </label>
                                    </form>
                                </td>
                                <td class="p-4 text-right">
                                    <button type="submit" form="form-role-<?= $p['id_enseignant'] ?>" class="bg-slate-800 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-slate-700">Sauvegarder</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <?php include ($is_root ? '' : '../') . 'includes/footer.php'; ?>
</body>
</html>