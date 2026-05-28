<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['type_compte'] !== 'etudiant') {
    header('Location: ../index.php');
    exit();
}

$role = $_SESSION['role'];
$type_compte = $_SESSION['type_compte'];

// Lecture globale des offres déposées
$offres = $pdo->query("SELECT * FROM Offre_de_stage ORDER BY id_offre_de_stage DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Offres de Stage - MMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <?php include '../includes/navbar.php'; ?>

    <main class="flex-grow p-8">
        <div class="max-w-5xl mx-auto flex flex-col gap-6">
            <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                <div>
                    <h1 class="text-xl font-bold">Offres de Stage MMI</h1>
                    <p class="text-xs text-slate-400">Consultez les propositions validées par l'IUT.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php if (empty($offres)): ?>
                    <p class="text-sm text-slate-500 italic col-span-2 text-center py-10 bg-white rounded-xl border border-slate-200">Aucune offre disponible pour le moment.</p>
                <?php else: foreach($offres as $o): ?>
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-slate-900"><?= htmlspecialchars($o['titre_offre']) ?></h3>
                            <p class="text-sm font-semibold text-blue-600 mb-3"><?= htmlspecialchars($o['entreprise']) ?></p>
                            <p class="text-sm text-slate-600 mb-4"><?= htmlspecialchars($o['description']) ?></p>
                        </div>
                        <div class="text-xs text-slate-400 space-y-1 bg-slate-50 p-3 rounded-lg mt-4">
                            <p><span class="font-bold">Gratification :</span> <?= htmlspecialchars($o['remuneration'] ?? 'Légale') ?></p>
                            <p><span class="font-bold">Période :</span> <?= htmlspecialchars($o['periode'] ?? 'Non spécifiée') ?></p>
                            <p><span class="font-bold">Contact :</span> <?= htmlspecialchars($o['contact'] ?? 'Via la plateforme') ?></p>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </main>
</body>
</html>