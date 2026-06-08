<?php
$is_root = (basename($_SERVER['PHP_SELF']) == 'index.php');
$root_path = $is_root ? '' : '../';
$pages_path = $is_root ? 'pages/' : '';
$role_check = $_SESSION['role'] ?? '';
$type_compte_check = $_SESSION['type_compte'] ?? '';
$photo_profil = $_SESSION['photo_profil'] ?? 'default.png';
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
    body { font-family: 'Poppins', sans-serif; }
</style>

<nav class="bg-slate-900 text-white border-b border-slate-800 py-3 px-8 flex justify-between items-center sticky top-0 z-40 shadow-sm">
    <div class="font-black text-xl tracking-tight flex items-center gap-2 w-1/4">
        <a href="<?= $root_path ?>index.php" class="flex items-center gap-2 text-white hover:text-rose-400 transition-colors">
            <span class="bg-rose-600 text-white px-2 py-0.5 rounded text-sm">MMI</span> Stages
        </a>
    </div>
    
    <ul class="flex items-center justify-center gap-8 text-sm font-medium w-2/4">
        <li><a href="<?= $root_path ?>index.php" class="text-slate-300 hover:text-white transition-colors">Accueil</a></li>
        <li><a href="<?= $pages_path ?>faq.php" class="text-slate-300 hover:text-white transition-colors">FAQ</a></li>
        
        <?php if ($role_check === 'Etudiant'): ?>
            <li><a href="<?= $pages_path ?>offres.php" class="text-slate-300 hover:text-white transition-colors">Offres</a></li>
            <li><a href="<?= $pages_path ?>suivi-recherches.php" class="text-slate-300 hover:text-white transition-colors">Candidatures</a></li>
            <li><a href="<?= $pages_path ?>soutenances.php" class="text-slate-300 hover:text-white transition-colors">Soutenance</a></li>
        
        <?php elseif ($role_check === 'Administrateur'): ?>
            <li><a href="<?= $pages_path ?>validation_comptes.php" class="text-slate-300 hover:text-white transition-colors">Comptes & Rôles</a></li>
        
        <?php elseif ($type_compte_check === 'enseignant'): ?>
            <li><a href="<?= $pages_path ?>offres.php" class="text-slate-300 hover:text-white transition-colors">Gérer les Offres</a></li>
            <?php if (str_contains($role_check, 'Responsable de stage')): ?>
                <li><a href="<?= $pages_path ?>gestion_stages.php" class="text-slate-300 hover:text-white transition-colors">Validations Stages</a></li>
            <?php endif; ?>
            <?php if (str_contains($role_check, 'Responsable de soutenance')): ?>
                <li><a href="<?= $pages_path ?>gestion_soutenances.php" class="text-slate-300 hover:text-white transition-colors">Soutenances</a></li>
            <?php endif; ?>
            <li><a href="<?= $pages_path ?>suivi_etudiants.php" class="text-slate-300 hover:text-white transition-colors">Mes Élèves</a></li>
        <?php endif; ?>
    </ul>

    <div class="flex items-center justify-end gap-6 w-1/4">
        <div class="flex items-center gap-3 border-r border-slate-700 pr-6">
            <a href="<?= $pages_path ?>profil.php" class="block w-10 h-10 rounded-full overflow-hidden border-2 border-slate-700 hover:border-rose-400 transition-colors bg-slate-800">
                <img src="<?= $root_path ?>assets/uploads/<?= htmlspecialchars($photo_profil) ?>" 
                     onerror="this.src='https://ui-avatars.com/api/?name=Profil&background=0f172a&color=fff'" 
                     alt="Profil" class="w-full h-full object-cover">
            </a>
            <a href="<?= $pages_path ?>profil.php" class="text-sm font-bold text-white hover:text-rose-400 transition-colors">Profil</a>
        </div>
        
        <a href="<?= $root_path ?>actions/logout_action.php" class="bg-rose-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-rose-700 transition-colors shadow-sm">Déconnexion</a>
    </div>
</nav>