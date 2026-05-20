<?php
session_start();
require_once '../config/database.php';

// SÉCURITÉ : Seul l'Administrateur peut voir cette page !
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrateur') {
    die("Accès refusé. Vous n'avez pas les droits d'administration. <a href='../index.php'>Retour</a>");
}

// Récupération des comptes en attente
$query = "SELECT * FROM Enseignant WHERE statut_compte = 'en_attente'";
$stmt = $pdo->query($query);
$comptes_en_attente = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Validation des comptes - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../assets/js/tailwind.config.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-slate-100 text-slate-800 font-sans flex flex-col min-h-screen">

    <nav class="fixed top-0 w-full flex justify-between items-center py-4 px-8 bg-white border-b border-slate-200 z-50">
        <div class="font-bold text-xl text-transparent bg-clip-text bg-gradient-to-r from-brandStart to-brandEnd">MMI Stages | Admin</div>
        <ul class="hidden md:flex gap-8 items-center">
            <li><a href="../index.php" class="nav-link font-medium text-slate-600 hover:text-brandStart transition-colors">Accueil</a></li>
            <li><a href="validation_comptes.php" class="nav-link active font-medium text-slate-700 hover:text-brandStart transition-colors">Validation des comptes</a></li>
            <li><a href="../actions/logout_action.php" class="ml-4 bg-red-50 text-red-600 px-5 py-2 rounded-full text-sm font-bold hover:bg-red-100 transition-colors">Déconnexion</a></li>
        </ul>
    </nav>

    <main class="flex-grow pt-32 pb-16 px-6 max-w-5xl mx-auto w-full">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-800">Validation des Enseignants</h2>
            <p class="text-slate-500 mt-2">Gérez les demandes d'inscription du personnel pédagogique.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-sm uppercase tracking-wider">
                        <th class="py-4 px-6 font-bold">Nom / Prénom</th>
                        <th class="py-4 px-6 font-bold">Email</th>
                        <th class="py-4 px-6 font-bold">Rôle demandé</th>
                        <th class="py-4 px-6 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    <?php if (empty($comptes_en_attente)): ?>
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-500 italic">Aucun compte en attente de validation.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($comptes_en_attente as $compte): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-4 px-6 font-bold text-slate-800">
                                    <?= htmlspecialchars($compte['nom'] . ' ' . $compte['prenom']) ?>
                                </td>
                                <td class="py-4 px-6 text-slate-600">
                                    <?= htmlspecialchars($compte['email']) ?>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="bg-blue-50 border border-blue-200 text-blue-700 py-1.5 px-3 rounded-lg font-bold text-xs">
                                        <?= htmlspecialchars($compte['role']) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right space-x-2">
                                    <a href="../actions/valider_compte.php?id=<?= $compte['id_enseignant'] ?>&action=valider" 
                                       class="bg-green-100 text-green-700 hover:bg-green-200 font-bold py-2 px-4 rounded-lg transition-colors">
                                        Valider
                                    </a>
                                    <a href="../actions/valider_compte.php?id=<?= $compte['id_enseignant'] ?>&action=refuser" 
                                       class="bg-red-100 text-red-700 hover:bg-red-200 font-bold py-2 px-4 rounded-lg transition-colors"
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?');">
                                        Refuser
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>