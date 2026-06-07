<?php
$is_root = (basename($_SERVER['PHP_SELF']) == 'index.php');
$root_path = $is_root ? '' : '../';
$pages_path = $is_root ? 'pages/' : '';
$role_check = $_SESSION['role'] ?? '';
$type_compte_check = $_SESSION['type_compte'] ?? '';
?>
<nav class="bg-slate-900 text-white border-b border-slate-800 py-4 px-8 flex justify-between items-center sticky top-0 z-40 shadow-md">
    <div class="font-black text-xl tracking-tight text-white flex items-center gap-2">
        <span class="bg-rose-600 text-white px-2 py-0.5 rounded text-sm">MMI</span> Stages
    </div>
    <ul class="flex items-center gap-6 text-sm font-medium">
        <li><a href="<?= $root_path ?>index.php" class="text-slate-300 hover:text-white transition-colors">Accueil</a></li>
        
        <?php if ($role_check === 'Etudiant'): ?>
            <li><a href="<?= $pages_path ?>offres.php" class="text-slate-300 hover:text-white transition-colors">Catalogue des offres</a></li>
            <li><a href="<?= $pages_path ?>suivi-recherches.php" class="text-slate-300 hover:text-white transition-colors">Mes Candidatures</a></li>
            <li><a href="<?= $pages_path ?>soutenances.php" class="text-slate-300 hover:text-white transition-colors">Ma Soutenance</a></li>
        
        <?php elseif ($role_check === 'Administrateur'): ?>
            <li><a href="<?= $pages_path ?>validation_comptes.php" class="text-slate-300 hover:text-white transition-colors">Comptes & Rôles</a></li>
            <li><a href="<?= $pages_path ?>offres.php" class="text-slate-300 hover:text-white transition-colors">Gérer les offres</a></li>
        
        <?php elseif ($type_compte_check === 'enseignant'): ?>
            <?php if (str_contains($role_check, 'Responsable de stage')): ?>
                <li><a href="<?= $pages_path ?>gestion_stages.php" class="text-slate-300 hover:text-white transition-colors">Gestion Stages</a></li>
            <?php endif; ?>
            <?php if (str_contains($role_check, 'Responsable de soutenance')): ?>
                <li><a href="<?= $pages_path ?>gestion_soutenances.php" class="text-slate-300 hover:text-white transition-colors">Valid. Soutenances</a></li>
            <?php endif; ?>
            <li><a href="<?= $pages_path ?>suivi_etudiants.php" class="text-slate-300 hover:text-white transition-colors">Mes Étudiants (Tuteur)</a></li>
        <?php endif; ?>
        
        <li><a href="<?= $pages_path ?>profil.php" class="text-slate-300 hover:text-white transition-colors">Profil</a></li>
        <li><a href="<?= $root_path ?>actions/logout_action.php" class="bg-rose-600 text-white px-4 py-2 rounded-full text-xs font-bold hover:bg-rose-700 transition-colors shadow-lg">Déconnexion</a></li>
    </ul>
</nav>