<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$id_user = $_SESSION['user_id'];
$type_compte = $_SESSION['type_compte'];
$role = $_SESSION['role'];

if ($type_compte === 'etudiant') {
    $stmt = $pdo->prepare("SELECT * FROM Etudiant WHERE id_etudiant = :id");
    $stmt->execute(['id' => $id_user]);
    $u = $stmt->fetch();
    
    // Récupération des stages acceptés (Expériences)
    $stmt_stages = $pdo->prepare("SELECT entreprise, poste FROM Recherche_de_stage WHERE id_etudiant = :id AND statut_candidature = 'accepte'");
    $stmt_stages->execute(['id' => $id_user]);
    $experiences = $stmt_stages->fetchAll();
} else {
    $stmt = $pdo->prepare("SELECT * FROM Enseignant WHERE id_enseignant = :id");
    $stmt->execute(['id' => $id_user]);
    $u = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - Configuration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">
    
    <!-- INCORPORATION DE LA NAVBAR -->
    <?php include '../includes/navbar.php'; ?>

    <main class="flex-grow p-8">
        <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- COLONNE GAUCHE : IDENTITÉ VISUELLE -->
            <div class="col-span-1 bg-white p-8 rounded-xl border border-slate-200 shadow-sm flex flex-col items-center text-center">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-slate-100 mb-4 bg-slate-200">
                    <img src="../assets/uploads/<?= htmlspecialchars($u['photo_profil'] ?? 'default.png') ?>" alt="Photo Profil" class="w-full h-full object-cover">
                </div>
                <h2 class="text-xl font-bold"><?= htmlspecialchars($u['prenom'] . ' ' . $u['nom']) ?></h2>
                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full uppercase mt-2"><?= htmlspecialchars($role) ?></span>
                
                <?php if ($type_compte === 'etudiant' && $u['annee_mmi']): ?>
                    <p class="text-sm font-semibold text-slate-500 mt-2">Année : MMI <?= htmlspecialchars($u['annee_mmi']) ?></p>
                <?php endif; ?>

                <p class="text-sm text-slate-500 mt-4 italic">"<?= nl2br(htmlspecialchars($u['bio'] ?? 'Aucune biographie renseignée.')) ?>"</p>
            </div>

            <!-- COLONNE DROITE : FORMULAIRE D'ÉDITION & EXPÉRIENCES -->
            <div class="col-span-2 space-y-6">
                
                <!-- Formulaire de modification -->
                <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-sm">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 border-slate-100">Modifier mon profil</h3>
                    <form action="../actions/edit_profil_action.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Changer la photo (Optionnel)</label>
                            <input type="file" name="photo" accept="image/png, image/jpeg" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <?php if ($type_compte === 'etudiant'): ?>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Année d'étude MMI</label>
                            <select name="annee_mmi" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm">
                                <option value="" <?= !$u['annee_mmi'] ? 'selected' : '' ?>>Non spécifiée</option>
                                <option value="1" <?= $u['annee_mmi'] == '1' ? 'selected' : '' ?>>1ère Année (BUT 1)</option>
                                <option value="2" <?= $u['annee_mmi'] == '2' ? 'selected' : '' ?>>2ème Année (BUT 2)</option>
                                <option value="3" <?= $u['annee_mmi'] == '3' ? 'selected' : '' ?>>3ème Année (BUT 3)</option>
                            </select>
                        </div>
                        <?php endif; ?>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Biographie</label>
                            <textarea name="bio" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-sm"><?= htmlspecialchars($u['bio'] ?? '') ?></textarea>
                        </div>

                        <button type="submit" class="bg-slate-800 text-white font-bold text-xs uppercase px-6 py-3 rounded-lg hover:bg-slate-700">Enregistrer les modifications</button>
                    </form>
                </div>

                <!-- Section Expériences (Pour les étudiants) -->
                <?php if ($type_compte === 'etudiant'): ?>
                    <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-sm">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2 border-slate-100">Mes expériences de Stage</h3>
                        <?php if (empty($experiences)): ?>
                            <p class="text-sm text-slate-500 italic">Aucun stage validé pour le moment.</p>
                        <?php else: ?>
                            <ul class="space-y-3">
                                <?php foreach($experiences as $exp): ?>
                                    <li class="bg-blue-50 border border-blue-100 p-3 rounded-lg">
                                        <p class="font-bold text-slate-800"><?= htmlspecialchars($exp['poste']) ?></p>
                                        <p class="text-sm text-slate-500">chez <?= htmlspecialchars($exp['entreprise']) ?></p>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include ($is_root ? '' : '../') . 'includes/footer.php'; ?>
</body>
</html>