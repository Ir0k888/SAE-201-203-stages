<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['type_compte'] !== 'etudiant') {
    header('Location: ../index.php');
    exit();
}

$role = $_SESSION['role'];
$type_compte = $_SESSION['type_compte'];

$stmt = $pdo->prepare("SELECT * FROM Soutenance WHERE id_etudiant = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$soutenance = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Soutenance - Stages MMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <?php include '../includes/navbar.php'; ?>

    <main class="flex-grow p-8">
        <div class="max-w-3xl mx-auto flex flex-col gap-6">
            <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                <div>
                    <h1 class="text-xl font-bold">Ma Soutenance</h1>
                    <p class="text-xs text-slate-400">Détails de votre convocation et évaluation.</p>
                </div>
            </div>

            <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-sm">
                <?php if (!$soutenance): ?>
                    <div class="text-center py-10">
                        <p class="text-slate-500 font-medium">Votre tuteur n'a pas encore proposé de date pour votre soutenance.</p>
                    </div>
                <?php elseif ($soutenance['statut_soutenance'] === 'en_attente'): ?>
                    <div class="text-center py-10">
                        <span class="bg-amber-100 text-amber-800 px-4 py-2 rounded-full text-sm font-bold block w-max mx-auto mb-4">Date en cours de validation</span>
                        <p class="text-slate-500">Votre tuteur a proposé une date. Elle sera affichée ici dès qu'elle sera validée par le responsable.</p>
                    </div>
                <?php else: ?>
                    <h3 class="text-xl font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">Convocation Officielle</h3>
                    <div class="space-y-6">
                        <div>
                            <span class="block text-sm text-slate-400 mb-1 uppercase tracking-wider font-semibold">Date & Heure</span>
                            <span class="text-lg text-slate-800 font-medium"><?= date('d/m/Y', strtotime($soutenance['date_soutenance'])) ?> — <?= date('H\hi', strtotime($soutenance['horaire'])) ?></span>
                        </div>
                        <div>
                            <span class="block text-sm text-slate-400 mb-1 uppercase tracking-wider font-semibold">Lieu de passage</span>
                            <span class="text-lg text-slate-800 font-medium"><?= htmlspecialchars($soutenance['lieu']) ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include ($is_root ? '' : '../') . 'includes/footer.php'; ?>
</body>
</html>