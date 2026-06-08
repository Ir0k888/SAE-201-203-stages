<?php
session_start();
require_once '../config/database.php';

// Protection Administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrateur') { 
    header('Location: ../index.php'); 
    exit(); 
}

// Requête SQL avec JOINTURES pour récupérer les noms de l'étudiant et de l'enseignant (Jury)
$stmt = $pdo->query("
    SELECT s.*, 
           e.nom AS etudiant_nom, e.prenom AS etudiant_prenom,
           p.nom AS prof_nom, p.prenom AS prof_prenom
    FROM Soutenance s
    JOIN Etudiant e ON s.id_etudiant = e.id_etudiant
    JOIN Enseignant p ON s.id_enseignant = p.id_enseignant
    WHERE s.statut_soutenance = 'en_attente'
    ORDER BY s.id_soutenance DESC
");
$soutenances_attente = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Validation des Soutenances - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex flex-col">

    <?php include '../includes/navbar.php'; ?>

    <main class="flex-grow p-8 max-w-5xl mx-auto w-full">
        <h1 class="text-4xl font-black mb-2 text-slate-900">Validation des dates</h1>
        <p class="text-slate-500 font-medium mb-10">Validez les plannings de soutenance proposés par les professeurs responsables.</p>

        <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm">
            <?php if (empty($soutenances_attente)): ?>
                <div class="text-center py-12 text-slate-500 font-medium">
                    Aucune date de soutenance en attente de validation.
                </div>
            <?php else: ?>
                <div class="space-y-6">
                    <?php foreach ($soutenances_attente as $s): ?>
                        <div class="flex items-center justify-between p-6 bg-slate-50 border-2 border-slate-200 rounded-xl">
                            <div>
                                <h3 class="font-black text-xl text-slate-900 mb-2">Soutenance #<?= htmlspecialchars($s['id_soutenance']) ?></h3>
                                
                                <!-- AFFICHAGE DE L'ÉTUDIANT ET DU JURY -->
                                <p class="text-sm text-slate-600 font-medium">Étudiant évalué : <span class="font-bold text-slate-900"><?= htmlspecialchars($s['etudiant_prenom'] . ' ' . $s['etudiant_nom']) ?></span></p>
                                <p class="text-sm text-slate-600 font-medium mb-3">Membre du Jury : <span class="font-bold text-slate-900">Prof. <?= htmlspecialchars($s['prof_prenom'] . ' ' . $s['prof_nom']) ?></span></p>
                                
                                <p class="text-sm text-slate-600 font-medium">Date proposée : <span class="font-bold text-rose-600"><?= date('d/m/Y', strtotime($s['date_soutenance'])) ?> à <?= date('H:i', strtotime($s['horaire'])) ?></span></p>
                                <?php if($s['lieu']): ?>
                                    <p class="text-xs text-slate-500 mt-1">Lieu : <?= htmlspecialchars($s['lieu']) ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <form action="../actions/valider_soutenance_action.php" method="POST">
                                <input type="hidden" name="id_soutenance" value="<?= htmlspecialchars($s['id_soutenance']) ?>">
                                <input type="hidden" name="action" value="valider">
                                <button type="submit" style="background-color: #FD3956;" class="text-white font-bold py-3 px-8 rounded-lg text-sm hover:bg-[#651617] transition-colors shadow-sm">
                                    Valider cette soutenance
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html>