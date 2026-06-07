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
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - MMI Stages</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">
    
    <?php include '../includes/navbar.php'; ?>

    <main class="flex-grow p-8">
        <div class="max-w-4xl mx-auto bg-white p-10 rounded-2xl border border-slate-200 shadow-sm">
            
            <div class="flex items-end justify-between mb-8 border-b border-slate-100 pb-6">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Mon Profil</h1>
                    <p class="text-sm text-slate-500 mt-1">Mettez à jour vos informations personnelles et académiques.</p>
                </div>
            </div>

            <form action="../actions/edit_profil_action.php" method="POST" enctype="multipart/form-data" class="space-y-8">
                
                <!-- IDENTIFIANT & EMAIL -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php if ($type_compte === 'etudiant'): ?>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Numéro étudiant (Matricule)</label>
                        <input type="text" name="numero_etudiant" value="<?= htmlspecialchars($u['numero_etudiant'] ?? '') ?>" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-rose-400">
                    </div>
                    <?php endif; ?>
                    <div class="<?= $type_compte !== 'etudiant' ? 'col-span-2' : '' ?>">
                        <label class="block text-xs font-bold text-slate-500 mb-2">Adresse E-mail universitaire</label>
                        <input type="email" value="<?= htmlspecialchars($u['email']) ?>" readonly class="w-full bg-slate-100 border border-slate-200 rounded-lg px-4 py-3 text-sm text-slate-400 cursor-not-allowed">
                    </div>
                </div>

                <!-- NOM & PRENOM -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Nom</label>
                        <input type="text" value="<?= htmlspecialchars($u['nom']) ?>" readonly class="w-full bg-slate-100 border border-slate-200 rounded-lg px-4 py-3 text-sm text-slate-400 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Prénom</label>
                        <input type="text" value="<?= htmlspecialchars($u['prenom']) ?>" readonly class="w-full bg-slate-100 border border-slate-200 rounded-lg px-4 py-3 text-sm text-slate-400 cursor-not-allowed">
                    </div>
                </div>

                <!-- NAISSANCE -->
                <?php if ($type_compte === 'etudiant'): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Date de naissance</label>
                        <input type="date" name="date_naissance" value="<?= htmlspecialchars($u['date_naissance'] ?? '') ?>" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-rose-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Lieu de naissance</label>
                        <input type="text" name="lieu_naissance" value="<?= htmlspecialchars($u['lieu_naissance'] ?? '') ?>" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-rose-400">
                    </div>
                </div>
                <?php endif; ?>

                <!-- ADRESSE -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-2">Adresse postale</label>
                    <input type="text" name="adresse_postale" value="<?= htmlspecialchars($u['adresse_postale'] ?? '') ?>" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-rose-400">
                </div>

                <!-- TELEPHONE & SCOLARITE -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-slate-500 mb-2">Numéro de téléphone</label>
                        <input type="text" name="numero_telephone" value="<?= htmlspecialchars($u['numero_telephone'] ?? '') ?>" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-rose-400">
                    </div>
                    
                    <?php if ($type_compte === 'etudiant'): ?>
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-slate-500 mb-2">Promo</label>
                        <select name="promotion" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-rose-400">
                            <option value="">--</option>
                            <option value="MMI 1" <?= ($u['promotion'] ?? '') == 'MMI 1' ? 'selected' : '' ?>>MMI 1</option>
                            <option value="MMI 2" <?= ($u['promotion'] ?? '') == 'MMI 2' ? 'selected' : '' ?>>MMI 2</option>
                            <option value="MMI 3" <?= ($u['promotion'] ?? '') == 'MMI 3' ? 'selected' : '' ?>>MMI 3</option>
                        </select>
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-slate-500 mb-2">TD</label>
                        <select name="groupe_td" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-rose-400">
                            <option value="">--</option>
                            <option value="A" <?= ($u['groupe_td'] ?? '') == 'A' ? 'selected' : '' ?>>A</option>
                            <option value="B" <?= ($u['groupe_td'] ?? '') == 'B' ? 'selected' : '' ?>>B</option>
                            <option value="C" <?= ($u['groupe_td'] ?? '') == 'C' ? 'selected' : '' ?>>C</option>
                        </select>
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-slate-500 mb-2">TP</label>
                        <select name="groupe_tp" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-rose-400">
                            <option value="">--</option>
                            <option value="1" <?= ($u['groupe_tp'] ?? '') == '1' ? 'selected' : '' ?>>1</option>
                            <option value="2" <?= ($u['groupe_tp'] ?? '') == '2' ? 'selected' : '' ?>>2</option>
                            <option value="3" <?= ($u['groupe_tp'] ?? '') == '3' ? 'selected' : '' ?>>3</option>
                            <option value="4" <?= ($u['groupe_tp'] ?? '') == '4' ? 'selected' : '' ?>>4</option>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- EXTRAS : BIO ET PHOTO -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Photo de profil</label>
                        <input type="file" name="photo" accept="image/png, image/jpeg" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Courte biographie</label>
                        <textarea name="bio" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-rose-400"><?= htmlspecialchars($u['bio'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-xl text-sm uppercase tracking-wider hover:bg-slate-800 transition-colors shadow-lg">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html>