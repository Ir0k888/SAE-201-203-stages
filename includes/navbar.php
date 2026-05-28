<?php
// On détecte si on est à la racine (index.php) ou dans le dossier /pages/ pour ajuster les chemins des liens
$is_root = (basename($_SERVER['PHP_SELF']) == 'index.php');
$root_path = $is_root ? '' : '../';
$pages_path = $is_root ? 'pages/' : '';
?>
<nav class="bg-white border-b border-slate-200 py-4 px-8 flex justify-between items-center sticky top-0 z-50 shadow-sm">
    <div class="font-bold text-xl text-slate-800">MMI Stages</div>
    <ul class="flex items-center gap-6 text-sm font-medium">
        <li><a href="<?= $root_path ?>index.php" class="text-blue-600">Accueil</a></li>
        
        <?php if ($role === 'Etudiant'): ?>
            <li><a href="<?= $pages_path ?>suivi-recherches.php" class="text-slate-600 hover:text-blue-600">Mes Recherches & Offres</a></li>
            <li><a href="<?= $pages_path ?>soutenances.php" class="text-slate-600 hover:text-blue-600">Ma Soutenance</a></li>
        
        <?php elseif ($role === 'Administrateur'): ?>
            <li><a href="<?= $pages_path ?>validation_comptes.php" class="text-slate-600 hover:text-blue-600">Comptes & Rôles</a></li>
        
        <?php elseif ($type_compte === 'enseignant'): ?>
            <?php if (str_contains($role, 'Responsable de stage')): ?>
                <li><a href="<?= $pages_path ?>gestion_stages.php" class="text-slate-600 hover:text-blue-600">Gestion Stages</a></li>
                <li><a href="<?= $pages_path ?>gestion_soutenances.php" class="text-slate-600 hover:text-blue-600">Valid. Soutenances</a></li>
            <?php endif; ?>
            <li><a href="<?= $pages_path ?>suivi_etudiants.php" class="text-slate-600 hover:text-blue-600">Mes Étudiants (Tuteur)</a></li>
        <?php endif; ?>
        
        <li><a href="<?= $pages_path ?>profil.php" class="text-slate-600 hover:text-blue-600">Profil</a></li>
        <li><a href="<?= $root_path ?>actions/logout_action.php" class="bg-red-50 text-red-600 px-4 py-2 rounded-full text-xs font-bold hover:bg-red-100 transition-colors">Déconnexion</a></li>
    </ul>
</nav>