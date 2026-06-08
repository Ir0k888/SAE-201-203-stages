<?php
$is_root = (basename($_SERVER['PHP_SELF']) == 'index.php');
$root_path = $is_root ? '' : '../';
?>
<footer class="bg-slate-900 text-white pt-16 pb-8 border-t border-slate-800 mt-auto">
    <div class="max-w-6xl mx-auto px-8 grid grid-cols-1 md:grid-cols-4 gap-12 text-sm">
        
        <div>
            <h3 class="font-bold text-lg mb-6">Navigation</h3>
            <div class="w-8 h-0.5 bg-rose-600 mb-6"></div>
            <ul class="space-y-4 text-slate-400">
                <li><a href="<?= $root_path ?>index.php" class="hover:text-rose-500 transition-colors">Accueil</a></li>
                <li><a href="<?= $root_path ?>pages/offres.php" class="hover:text-rose-500 transition-colors">Offres de stage</a></li>
                <li><a href="<?= $root_path ?>pages/profil.php" class="hover:text-rose-500 transition-colors">Mon Profil</a></li>
            </ul>
        </div>

        <div>
            <h3 class="font-bold text-lg mb-6">Aide & Support</h3>
            <div class="w-8 h-0.5 bg-rose-600 mb-6"></div>
            <ul class="space-y-4 text-slate-400">
                <li><a href="<?= $root_path ?>pages/faq.php" class="hover:text-rose-500 transition-colors">FAQ & Aide</a></li>
                <!-- LIEN MENTIONS LEGALES QUI OUVRE LA MODALE -->
                <li><button type="button" onclick="document.getElementById('modal-mentions').style.display='flex'" class="hover:text-rose-500 transition-colors text-left">Mentions légales</button></li>
            </ul>
        </div>

        <div>
            <h3 class="font-bold text-lg mb-6">Accès Rapides</h3>
            <div class="w-8 h-0.5 bg-rose-600 mb-6"></div>
            <ul class="space-y-4 text-slate-400">
                <li><a href="https://elearning.univ-eiffel.fr" target="_blank" class="hover:text-rose-500 transition-colors">Moodle MMI</a></li>
                <li><a href="https://intranet-edu.univ-eiffel.fr/accueil" target="_blank" class="hover:text-rose-500 transition-colors">Intranet Université</a></li>
                <li><a href="https://edt-consult.univ-eiffel.fr/direct/" target="_blank" class="hover:text-rose-500 transition-colors">Planning Général</a></li>
            </ul>
        </div>

        <div>
            <h3 class="font-bold text-lg mb-6">Suivez-nous</h3>
            <div class="w-8 h-0.5 bg-rose-600 mb-6"></div>
            <div class="flex gap-4">
                <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-rose-600 transition-colors text-white font-bold">f</a>
                <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-rose-600 transition-colors text-white font-bold">X</a>
                <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-rose-600 transition-colors text-white font-bold">in</a>
            </div>
        </div>

    </div>
    <div class="max-w-6xl mx-auto px-8 mt-12 pt-8 border-t border-slate-800 text-center text-slate-500 text-xs">
        &copy; <?= date('Y') ?> Département MMI Meaux. Tous droits réservés.
    </div>

    <!-- MODAL MENTIONS LÉGALES DÉTAILLÉE -->
    <div id="modal-mentions" style="display: none;" class="fixed inset-0 bg-slate-900/90 z-50 items-center justify-center p-4">
        <div class="bg-white rounded-xl p-10 w-full max-w-3xl max-h-[80vh] overflow-y-auto shadow-2xl relative text-slate-900">
            <button type="button" onclick="document.getElementById('modal-mentions').style.display='none'" class="absolute top-6 right-6 text-slate-400 hover:text-rose-500 font-black text-3xl">&times;</button>
            <h2 class="text-3xl font-black mb-6">Mentions Légales</h2>
            
            <div class="text-sm text-slate-600 leading-relaxed space-y-6 mb-8">
                <div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">1. Éditeur de la plateforme</h3>
                    <p>Ce site est édité par le département MMI (Métiers du Multimédia et de l'Internet) de l'IUT de Marne-la-Vallée, site de Meaux.<br>Adresse : 17 Rue Bossuet, 77100 Meaux, France.</p>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">2. Directeur de la publication</h3>
                    <p>L'équipe pédagogique responsable des stages MMI.</p>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">3. Hébergement</h3>
                    <p>Ce site est hébergé sur les serveurs locaux et sécurisés de l'Université Gustave Eiffel.</p>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">4. Données personnelles et RGPD</h3>
                    <p>Les informations recueillies sur cette plateforme (nom, prénom, e-mail, CV) sont enregistrées dans un fichier informatisé. Elles sont strictement utilisées dans le cadre de la recherche d'offres et du suivi pédagogique de votre stage. Ces données ne sont ni vendues, ni cédées à des tiers commerciaux. Conformément à la loi « informatique et libertés », vous pouvez exercer votre droit d'accès aux données vous concernant et les faire rectifier ou supprimer en vous rendant dans votre espace Profil ou en contactant le secrétariat MMI.</p>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">5. Cookies</h3>
                    <p>Cette plateforme utilise uniquement des cookies de session strictement nécessaires à l'authentification et au maintien de votre connexion. Aucun cookie de traçage publicitaire n'est utilisé.</p>
                </div>
            </div>

            <button type="button" onclick="document.getElementById('modal-mentions').style.display='none'" class="bg-slate-900 text-white font-bold px-8 py-3 rounded-lg hover:bg-slate-800 transition-colors">Fermer</button>
        </div>
    </div>
</footer>