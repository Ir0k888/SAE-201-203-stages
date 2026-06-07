<?php
$is_root = (basename($_SERVER['PHP_SELF']) == 'index.php');
$root_path = $is_root ? '' : '../';
?>

<!-- MODALE POLITIQUE DE CONFIDENTIALITÉ (RGPD) -->
<?php if (isset($_SESSION['user_id']) && isset($_SESSION['politique_acceptee']) && $_SESSION['politique_acceptee'] == 0): ?>
<div class="fixed inset-0 bg-slate-900/90 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl p-8 max-w-2xl w-full shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-rose-500 to-blue-600"></div>
        <h2 class="text-2xl font-black text-slate-900 mb-4">Mise à jour de nos conditions</h2>
        <p class="text-slate-600 mb-4">Pour continuer à utiliser MMI Stages, vous devez accepter notre politique de confidentialité concernant le traitement de vos données scolaires et personnelles.</p>
        
        <details class="mb-6 bg-slate-50 border border-slate-200 rounded-lg">
            <summary class="font-bold text-sm text-slate-700 cursor-pointer p-4 hover:bg-slate-100 transition-colors">Lire en détail la politique</summary>
            <div class="p-4 text-xs text-slate-500 border-t border-slate-200 h-32 overflow-y-auto">
                <p class="mb-2"><strong>1. Collecte des données</strong><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel risus mauris. Nulla facilisi. Sed malesuada, nisi eu accumsan consequat, turpis nisl interdum sem, vitae tempus odio erat quis est.</p>
                <p class="mb-2"><strong>2. Utilisation</strong><br>Suspendisse potenti. Fusce consequat bibendum enim ac ultricies. Etiam sed laoreet lorem. Nullam eu ex sit amet arcu ullamcorper efficitur.</p>
                <p><strong>3. Droits des utilisateurs</strong><br>Proin vitae lectus nec lacus lacinia bibendum. Morbi tristique, metus quis aliquet dapibus, arcu leo sodales elit, vel tristique ligula tellus eget elit.</p>
            </div>
        </details>

        <form action="<?= $root_path ?>actions/accepter_politique_action.php" method="POST" class="flex gap-4 justify-end">
            <button type="submit" name="action" value="refuser" class="px-6 py-2.5 rounded-xl font-bold text-sm text-slate-500 hover:bg-slate-100 transition-colors">Refuser et se déconnecter</button>
            <button type="submit" name="action" value="accepter" class="px-6 py-2.5 rounded-xl font-bold text-sm bg-slate-900 text-white hover:bg-slate-800 transition-colors shadow-lg">J'accepte les conditions</button>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- LE FOOTER DESIGN -->
<footer class="bg-slate-900 text-white pt-16 pb-8 border-t border-slate-800 mt-auto">
    <div class="max-w-6xl mx-auto px-8 grid grid-cols-1 md:grid-cols-4 gap-12 text-sm">
        
        <div>
            <h3 class="font-bold text-lg mb-6">Navigation</h3>
            <div class="w-8 h-0.5 bg-rose-600 mb-6"></div>
            <ul class="space-y-4 text-slate-400">
                <li><a href="#" class="hover:text-rose-500 transition-colors">À propos de l'IUT</a></li>
                <li><a href="#" class="hover:text-rose-500 transition-colors">Nos Services</a></li>
                <li><a href="#" class="hover:text-rose-500 transition-colors">Politique de Confidentialité</a></li>
                <li><a href="#" class="hover:text-rose-500 transition-colors">Programme d'affiliation</a></li>
            </ul>
        </div>

        <div>
            <h3 class="font-bold text-lg mb-6">Aide & Support</h3>
            <div class="w-8 h-0.5 bg-rose-600 mb-6"></div>
            <ul class="space-y-4 text-slate-400">
                <li><a href="#" class="hover:text-rose-500 transition-colors">FAQ Étudiants</a></li>
                <li><a href="#" class="hover:text-rose-500 transition-colors">Contact Secrétariat</a></li>
                <li><a href="#" class="hover:text-rose-500 transition-colors">Règlement des stages</a></li>
                <li><a href="#" class="hover:text-rose-500 transition-colors">Statut des conventions</a></li>
            </ul>
        </div>

        <div>
            <h3 class="font-bold text-lg mb-6">Accès Rapides</h3>
            <div class="w-8 h-0.5 bg-rose-600 mb-6"></div>
            <ul class="space-y-4 text-slate-400">
                <li><a href="#" class="hover:text-rose-500 transition-colors">Moodle MMI</a></li>
                <li><a href="#" class="hover:text-rose-500 transition-colors">Intranet Université</a></li>
                <li><a href="#" class="hover:text-rose-500 transition-colors">Ressources Pédagogiques</a></li>
                <li><a href="#" class="hover:text-rose-500 transition-colors">Planning Général</a></li>
            </ul>
        </div>

        <div>
            <h3 class="font-bold text-lg mb-6">Suivez-nous</h3>
            <div class="w-8 h-0.5 bg-rose-600 mb-6"></div>
            <div class="flex gap-4">
                <a href="#" class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center hover:bg-rose-600 transition-colors text-white font-bold">f</a>
                <a href="#" class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center hover:bg-rose-600 transition-colors text-white font-bold">X</a>
                <a href="#" class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center hover:bg-rose-600 transition-colors text-white font-bold">in</a>
            </div>
        </div>

    </div>
    <div class="max-w-6xl mx-auto px-8 mt-12 pt-8 border-t border-slate-700 text-center text-slate-500 text-xs">
        &copy; <?= date('Y') ?> Département MMI Meaux. Tous droits réservés.
    </div>
</footer>