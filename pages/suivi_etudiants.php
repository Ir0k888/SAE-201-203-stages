<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['type_compte'] !== 'enseignant') {
    header('Location: ../index.php');
    exit();
}

$id_enseignant = $_SESSION['user_id'];
$role = $_SESSION['role'];
$type_compte = $_SESSION['type_compte'];

$query = "SELECT E.id_etudiant, E.nom, E.prenom, S.id_soutenance, S.date_soutenance, S.horaire, S.lieu, S.statut_soutenance 
          FROM Etudiant E
          JOIN Prise_en_charge P ON E.id_etudiant = P.id_etudiant
          LEFT JOIN Soutenance S ON E.id_etudiant = S.id_etudiant
          WHERE P.id_enseignant = :id_prof";
$stmt = $pdo->prepare($query);
$stmt->execute(['id_prof' => $id_enseignant]);
$etudiants = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Étudiants - Stages MMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <?php include '../includes/navbar.php'; ?>

    <main class="flex-grow p-8">
        <div class="max-w-5xl mx-auto flex flex-col gap-6">
            <div class="flex justify-between items-center bg-white p-6 rounded-xl border-2 border-slate-200 shadow-sm">
                <div>
                    <h1 class="text-xl font-bold">Mes Étudiants Affiliés</h1>
                    <p class="text-xs text-slate-400">Proposez et gérez les dates de soutenances de vos élèves.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php if (empty($etudiants)): ?>
                    <p class="col-span-2 text-center text-slate-500 py-10 bg-white rounded-xl border-2 border-slate-200">Aucun étudiant ne vous est affilié pour le moment.</p>
                <?php else: foreach ($etudiants as $etu): ?>
                    <div class="bg-white p-6 rounded-xl border-2 border-slate-200 shadow-sm">
                        <h3 class="font-bold text-lg text-slate-800 mb-4"><?= htmlspecialchars($etu['prenom'] . ' ' . $etu['nom']) ?></h3>
                        
                        <?php if (!$etu['id_soutenance']): ?>
                            <form action="../actions/proposer_soutenance_action.php" method="POST" class="bg-slate-50 p-4 rounded-lg border-2 border-slate-200 text-sm">
                                <p class="font-semibold text-slate-600 mb-3">Planifier la soutenance :</p>
                                <input type="hidden" name="id_etudiant" value="<?= $etu['id_etudiant'] ?>">
                                <div class="grid grid-cols-2 gap-3 mb-3">
                                    <div><label class="text-xs text-slate-400">Date</label><input type="date" name="date" required class="w-full px-3 py-2 border rounded-md"></div>
                                    <div><label class="text-xs text-slate-400">Heure</label><input type="time" name="heure" required class="w-full px-3 py-2 border rounded-md"></div>
                                </div>
                                <div class="mb-4">
                                    <label class="text-xs text-slate-400">Lieu / Salle</label>
                                    <input type="text" name="lieu" placeholder="Ex: Salle B104" required class="w-full px-3 py-2 border rounded-md">
                                </div>
                                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 rounded-md hover:bg-indigo-700">Soumettre au Responsable</button>
                            </form>
                        <?php else: ?>
                            <div class="bg-slate-50 p-4 rounded-lg border-2 border-slate-200">
                                <p class="text-sm"><span class="font-semibold">Date :</span> <?= date('d/m/Y', strtotime($etu['date_soutenance'])) ?> à <?= date('H:i', strtotime($etu['horaire'])) ?></p>
                                <p class="text-sm mb-3"><span class="font-semibold">Lieu :</span> <?= htmlspecialchars($etu['lieu']) ?></p>
                                
                                <?php if ($etu['statut_soutenance'] === 'en_attente'): ?>
                                    <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-xs font-bold">En attente de validation</span>
                                <?php else: ?>
                                    <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-xs font-bold">Soutenance Validée</span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </main>
    <?php include ($is_root ? '' : '../') . 'includes/footer.php'; ?>
</body>
</html>