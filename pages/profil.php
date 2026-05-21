<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$id_user = $_SESSION['user_id'];
$type_compte = $_SESSION['type_compte'];

if ($type_compte === 'etudiant') {
    $stmt = $pdo->prepare("SELECT * FROM Etudiant WHERE id_etudiant = :id");
    $stmt->execute(['id' => $id_user]);
    $u = $stmt->fetch();
} else {
    $stmt = $pdo->prepare("SELECT * FROM Enseignant WHERE id_enseignant = :id");
    $stmt->execute(['id' => $id_user]);
    $u = $stmt->fetch();
    $_SESSION['role'] = $u['role'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - Configuration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen p-8">
    <div class="max-w-3xl mx-auto flex flex-col gap-6">
        <div class="bg-white p-6 rounded-xl border border-slate-200 flex justify-between items-center shadow-sm">
            <div>
                <h1 class="text-xl font-bold">Fiche Profil Utilisateur</h1>
                <p class="text-xs text-slate-400">Gestion de vos paramètres de contact et demandes d'autorisations.</p>
            </div>
            <a href="../index.php" class="bg-slate-100 px-4 py-2 rounded-lg font-bold text-xs hover:bg-slate-200">Retour</a>
        </div>

        <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-sm space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div><label class="text-xs font-bold text-slate-400 block mb-1">Nom</label><input type="text" readonly value="<?=htmlspecialchars($u['nom'])?>" class="w-full bg-slate-50 px-4 py-2.5 rounded-xl text-sm border cursor-not-allowed"></div>
                <div><label class="text-xs font-bold text-slate-400 block mb-1">Prénom</label><input type="text" readonly value="<?=htmlspecialchars($u['prenom'])?>" class="w-full bg-slate-50 px-4 py-2.5 rounded-xl text-sm border cursor-not-allowed"></div>
            </div>
            <div><label class="text-xs font-bold text-slate-400 block mb-1">E-mail institutionnel</label><input type="text" readonly value="<?=htmlspecialchars($u['email'])?>" class="w-full bg-slate-50 px-4 py-2.5 rounded-xl text-sm border cursor-not-allowed"></div>

            <?php if ($type_compte === 'enseignant' && $_SESSION['role'] !== 'Administrateur'): ?>
                <div class="border-t border-slate-100 pt-6">
                    <h3 class="font-bold text-sm text-slate-900 mb-2">Statut & Évolution Hiérarchique</h3>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-xs text-slate-500">Rôle(s) actuel(s) :</span>
                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider"><?= htmlspecialchars($u['role']) ?></span>
                        <?php if(!empty($u['role_demande'])): ?>
                            <span class="text-xs text-amber-600 font-medium italic">(Demande en cours : <?= htmlspecialchars($u['role_demande']) ?>)</span>
                        <?php endif; ?>
                    </div>

                    <form action="../actions/demande_role_action.php" method="POST" class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 mb-3 uppercase tracking-wider">Solliciter des responsabilités (cumulables)</label>
                        <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="nouveaux_roles[]" value="Membre du jury" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm font-medium text-slate-700">Membre du jury</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="nouveaux_roles[]" value="Responsable de stage" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm font-medium text-slate-700">Responsable de stage</span>
                                </label>
                            </div>
                            <button type="submit" class="bg-slate-800 text-white font-bold text-xs uppercase px-5 py-2.5 rounded-lg hover:bg-slate-700">Transmettre</button>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-3 italic">*Laissez les cases vides pour formuler une demande de rétrogradation vers "Enseignant classique".</p>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>