<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion & Inscription - Stages MMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .login-container { position: relative; overflow: hidden; }
        .form-container { position: absolute; top: 0; height: 100%; transition: all 0.6s ease-in-out; }
        .sign-in-container { left: 0; width: 50%; z-index: 2; }
        .sign-up-container { left: 0; width: 50%; opacity: 0; z-index: 1; }
        .login-container.right-panel-active .sign-in-container { transform: translateX(100%); }
        .login-container.right-panel-active .sign-up-container { transform: translateX(100%); opacity: 1; z-index: 5; animation: show 0.6s; }
        @keyframes show { 0%, 49.99% { opacity: 0; z-index: 1; } 50%, 100% { opacity: 1; z-index: 5; } }
        .overlay-container { position: absolute; top: 0; left: 50%; width: 50%; height: 100%; overflow: hidden; transition: transform 0.6s ease-in-out; z-index: 100; }
        .login-container.right-panel-active .overlay-container { transform: translateX(-100%); }
        .overlay { background: linear-gradient(135deg, #0f172a, #1e3a8a); color: #ffffff; position: relative; left: -100%; height: 100%; width: 200%; transform: translateX(0); transition: transform 0.6s ease-in-out; }
        .login-container.right-panel-active .overlay { transform: translateX(50%); }
        .overlay-panel { position: absolute; display: flex; align-items: center; justify-content: center; flex-direction: column; padding: 0 40px; text-align: center; top: 0; height: 100%; width: 50%; transform: translateX(0); transition: transform 0.6s ease-in-out; }
        .overlay-left { transform: translateX(-20%); }
        .login-container.right-panel-active .overlay-left { transform: translateX(0); }
        .overlay-right { right: 0; transform: translateX(0); }
        .login-container.right-panel-active .overlay-right { transform: translateX(20%); }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-[#0a1128] to-slate-900 flex flex-col justify-center items-center min-h-screen p-4">
    
    <div class="mb-8 text-center">
        <h2 class="text-4xl font-black text-white tracking-tight">Stages <span class="text-rose-500">MMI</span></h2>
        <p class="text-slate-400 mt-2">La plateforme de gestion de vos expériences pro</p>
        
        <?php if(isset($_GET['msg'])): ?>
            <?php if($_GET['msg'] === 'success'): ?>
                <p class="mt-4 text-sm font-semibold text-emerald-400 bg-emerald-900/50 px-4 py-2 rounded-full inline-block border border-emerald-800">Compte créé avec succès ! Connectez-vous.</p>
            <?php elseif($_GET['msg'] === 'refus_politique'): ?>
                <p class="mt-4 text-sm font-semibold text-red-400 bg-red-900/50 px-4 py-2 rounded-full inline-block border border-red-800">Vous avez refusé la politique. Déconnexion effectuée.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    
    <div class="login-container bg-white rounded-2xl shadow-2xl w-[850px] max-w-full min-h-[550px]" id="login-container">
        
        <!-- FORMULAIRE D'INSCRIPTION -->
        <div class="form-container sign-up-container bg-white">
            <form action="actions/register_action.php" method="POST" class="flex flex-col items-center justify-center h-full px-10 text-center">
                <h1 class="font-black text-2xl mb-2 text-slate-800">Créer un compte</h1>
                <p class="text-xs text-slate-500 mb-4">Utilisez @etudiant.univ.fr ou @univ.fr</p>
                
                <div class="flex gap-2 w-full">
                    <input type="text" name="nom" placeholder="Nom" required class="w-1/2 bg-slate-50 border border-slate-200 px-4 py-2.5 my-1 rounded-xl text-sm outline-none focus:border-rose-400 transition-colors">
                    <input type="text" name="prenom" placeholder="Prénom" required class="w-1/2 bg-slate-50 border border-slate-200 px-4 py-2.5 my-1 rounded-xl text-sm outline-none focus:border-rose-400 transition-colors">
                </div>
                <input type="email" name="email" placeholder="Email institutionnel" required class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1 rounded-xl text-sm outline-none focus:border-rose-400 transition-colors">
                
                <p class="text-[10px] text-slate-400 mt-2 mb-1">Le mot de passe doit contenir 1 majuscule, 1 chiffre et 1 caractère spécial.</p>
                
                <div class="relative w-full">
                    <input type="password" id="reg-pwd" name="password" placeholder="Mot de passe" required class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1 rounded-xl text-sm outline-none pr-10 focus:border-rose-400 transition-colors">
                    <button type="button" onclick="togglePwd('reg-pwd')" class="absolute right-3 top-3.5 text-slate-500">👁️</button>
                </div>
                
                <div class="relative w-full">
                    <input type="password" id="reg-pwd-conf" name="password_confirm" placeholder="Confirmer mot de passe" required class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1 rounded-xl text-sm outline-none pr-10 focus:border-rose-400 transition-colors">
                    <button type="button" onclick="togglePwd('reg-pwd-conf')" class="absolute right-3 top-3.5 text-slate-500">👁️</button>
                </div>
                
                <button type="submit" class="mt-4 rounded-full bg-slate-900 text-white font-bold py-3 px-10 text-xs uppercase tracking-wider hover:bg-rose-600 transition-colors shadow-lg">S'inscrire</button>
            </form>
        </div>

        <!-- FORMULAIRE DE CONNEXION -->
        <div class="form-container sign-in-container bg-white">
            <form action="actions/login_action.php" method="POST" class="flex flex-col items-center justify-center h-full px-10 text-center">
                <h1 class="font-black text-2xl mb-4 text-slate-800">Se connecter</h1>
                <select name="type_compte" class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm font-semibold outline-none focus:border-rose-400 transition-colors">
                    <option value="etudiant">Espace Étudiant</option>
                    <option value="enseignant">Espace Staff / Profs / Admin</option>
                </select>
                <input type="email" name="email" placeholder="Email institutionnel" required class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm outline-none focus:border-rose-400 transition-colors">
                
                <div class="relative w-full">
                    <input type="password" id="log-pwd" name="password" placeholder="Mot de passe" required class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm outline-none pr-10 focus:border-rose-400 transition-colors">
                    <button type="button" onclick="togglePwd('log-pwd')" class="absolute right-3 top-4 text-slate-500">👁️</button>
                </div>

                <button type="submit" class="mt-4 rounded-full bg-slate-900 text-white font-bold py-3 px-10 text-xs uppercase tracking-wider hover:bg-rose-600 transition-colors shadow-lg">Connexion</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 class="font-black text-3xl mb-2">Déjà inscrit ?</h1>
                    <p class="text-sm text-slate-200 mb-6">Connectez-vous pour accéder à votre espace de gestion.</p>
                    <button class="border border-white/50 bg-white/10 backdrop-blur-sm rounded-full py-2.5 px-8 uppercase font-bold text-xs hover:bg-white hover:text-slate-900 transition-colors" id="signIn">Se connecter</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1 class="font-black text-3xl mb-2">Nouveau compte ?</h1>
                    <p class="text-sm text-slate-200 mb-6">Créez un compte pour rejoindre la plateforme de l'IUT.</p>
                    <button class="border border-white/50 bg-white/10 backdrop-blur-sm rounded-full py-2.5 px-8 uppercase font-bold text-xs hover:bg-white hover:text-slate-900 transition-colors" id="signUp">S'inscrire</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('login-container');
        document.getElementById('signUp').addEventListener('click', () => container.classList.add('right-panel-active'));
        document.getElementById('signIn').addEventListener('click', () => container.classList.remove('right-panel-active'));

        function togglePwd(id) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>
</html>