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
} else {
    $stmt = $pdo->prepare("SELECT * FROM Enseignant WHERE id_enseignant = :id");
}
$stmt->execute(['id' => $id_user]);
$u = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - MMI Stages</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8f9fa] text-slate-900 min-h-screen flex flex-col">
    
    <?php include '../includes/navbar.php'; ?>

    <main class="flex-grow p-8">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- COLONNE GAUCHE : FORMULAIRE (2/3 de l'espace) -->
            <div class="lg:col-span-2 bg-white p-10 rounded-2xl border-2 border-slate-200 shadow-sm">
                <h1 class="text-3xl font-black tracking-tight mb-2">Mon profil</h1>
                <p class="text-sm font-semibold text-slate-900 mb-8">Mettez à jour vos informations personnelles</p>

                <form action="../actions/edit_profil_action.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php if ($type_compte === 'etudiant'): ?>
                        <div>
                            <label class="block text-xs font-bold text-slate-900 mb-2">Numéro étudiant (Matricule)</label>
                            <input type="text" name="numero_etudiant" value="<?= htmlspecialchars($u['numero_etudiant'] ?? '') ?>" class="w-full bg-white border border-slate-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-shadow">
                        </div>
                        <?php endif; ?>
                        <div class="<?= $type_compte !== 'etudiant' ? 'col-span-2' : '' ?>">
                            <label class="block text-xs font-bold text-slate-900 mb-2">Adresse E-mail universitaire</label>
                            <input type="email" value="<?= htmlspecialchars($u['email']) ?>" readonly class="w-full bg-slate-50 border-2 border-slate-200 rounded-md px-3 py-2.5 text-sm text-slate-500 cursor-not-allowed">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-900 mb-2">Nom</label>
                            <input type="text" value="<?= htmlspecialchars($u['nom']) ?>" readonly class="w-full bg-slate-50 border-2 border-slate-200 rounded-md px-3 py-2.5 text-sm text-slate-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-900 mb-2">Prénom</label>
                            <input type="text" value="<?= htmlspecialchars($u['prenom']) ?>" readonly class="w-full bg-slate-50 border-2 border-slate-200 rounded-md px-3 py-2.5 text-sm text-slate-500 cursor-not-allowed">
                        </div>
                    </div>

                    <?php if ($type_compte === 'etudiant'): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-900 mb-2">Date de naissance</label>
                            <input type="date" name="date_naissance" value="<?= htmlspecialchars($u['date_naissance'] ?? '') ?>" class="w-full bg-white border border-slate-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-shadow">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-900 mb-2">Lieu de naissance</label>
                            <input type="text" name="lieu_naissance" value="<?= htmlspecialchars($u['lieu_naissance'] ?? '') ?>" class="w-full bg-white border border-slate-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-shadow">
                        </div>
                    </div>
                    <?php endif; ?>

                    <div>
                        <label class="block text-xs font-bold text-slate-900 mb-2">Numéro de téléphone</label>
                        <input type="text" name="numero_telephone" value="<?= htmlspecialchars($u['numero_telephone'] ?? '') ?>" class="w-full bg-white border border-slate-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-shadow">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-900 mb-2">Biographie</label>
                        <textarea name="bio" rows="4" class="w-full bg-white border border-slate-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-shadow"><?= htmlspecialchars($u['bio'] ?? '') ?></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-900 mb-2">Photo de profil</label>
                        <input type="file" name="photo" accept="image/png, image/jpeg" class="w-full text-sm text-slate-500 border border-slate-300 rounded-md file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-slate-900 text-white font-bold py-3 px-8 rounded-md text-sm hover:bg-slate-800 transition-colors shadow-sm">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>

            <!-- COLONNE DROITE : VISUALISATION (1/3 de l'espace) -->
            <div class="lg:col-span-1 bg-white p-10 rounded-2xl border-2 border-slate-200 shadow-sm flex flex-col items-center text-center">
                
                <div class="w-32 h-32 rounded-full overflow-hidden bg-slate-200 mb-6">
                    <img src="../assets/uploads/<?= htmlspecialchars($u['photo_profil'] ?? 'default.png') ?>" alt="Photo Profil" class="w-full h-full object-cover">
                </div>
                
                <h2 class="text-xl font-bold text-slate-900 mb-2"><?= htmlspecialchars($u['nom'] . ' ' . $u['prenom']) ?></h2>
                <p class="text-sm text-slate-500 italic mb-12">"<?= htmlspecialchars($u['bio'] ?? 'Aucune biographie renseignée.') ?>"</p>

                <div class="w-full border-t border-slate-100 pt-8 mt-auto">
                    <h3 class="font-bold text-slate-900 mb-2">Notification</h3>
                    <p class="text-sm text-slate-500 italic">"Aucune notification reçue"</p>
                </div>
            </div>

        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html>