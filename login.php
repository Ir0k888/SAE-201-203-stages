<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion & Inscription - Stages MMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* FIX DU DESIGN FIDDLER OFFICIEL */
        .login-container { position: relative; overflow: hidden; }
        .form-container { position: absolute; top: 0; height: 100%; transition: all 0.6s ease-in-out; }
        .sign-in-container { left: 0; width: 50%; z-index: 2; }
        .sign-up-container { left: 0; width: 50%; opacity: 0; z-index: 1; }
        
        .login-container.right-panel-active .sign-in-container { transform: translateX(100%); }
        .login-container.right-panel-active .sign-up-container { transform: translateX(100%); opacity: 1; z-index: 5; animation: show 0.6s; }
        
        @keyframes show {
            0%, 49.99% { opacity: 0; z-index: 1; }
            50%, 100% { opacity: 1; z-index: 5; }
        }
        
        .overlay-container { position: absolute; top: 0; left: 50%; width: 50%; height: 100%; overflow: hidden; transition: transform 0.6s ease-in-out; z-index: 100; }
        .login-container.right-panel-active .overlay-container { transform: translateX(-100%); }
        
        .overlay { background: #0f172a; color: #ffffff; position: relative; left: -100%; height: 100%; width: 200%; transform: translateX(0); transition: transform 0.6s ease-in-out; }
        .login-container.right-panel-active .overlay { transform: translateX(50%); }
        
        .overlay-panel { position: absolute; display: flex; align-items: center; justify-content: center; flex-direction: column; padding: 0 40px; text-align: center; top: 0; height: 100%; width: 50%; transform: translateX(0); transition: transform 0.6s ease-in-out; }
        
        .overlay-left { transform: translateX(-20%); }
        .login-container.right-panel-active .overlay-left { transform: translateX(0); }
        
        .overlay-right { right: 0; transform: translateX(0); }
        .login-container.right-panel-active .overlay-right { transform: translateX(20%); }
    </style>
</head>
<body class="bg-slate-100 flex flex-col justify-center items-center min-h-screen p-4">
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-slate-800">Stages MMI Meaux</h2>
        <?php if(isset($_GET['msg']) && $_GET['msg'] === 'success'): ?>
            <p class="mt-2 text-sm font-semibold text-green-600 bg-green-100 px-4 py-2 rounded-full inline-block">Compte créé avec succès ! Connectez-vous.</p>
        <?php endif; ?>
    </div>
    
    <div class="login-container bg-white rounded-2xl shadow-xl w-[768px] max-w-full min-h-[500px]" id="login-container">
        
        <div class="form-container sign-up-container bg-white">
            <form action="actions/register_action.php" method="POST" class="flex flex-col items-center justify-center h-full px-10 text-center">
                <h1 class="font-bold text-2xl mb-4 text-slate-800">S'inscrire</h1>
                <p class="text-xs text-slate-500 mb-4">Utilisez votre adresse @etudiant.univ.fr ou @univ.fr</p>
                
                <div class="flex gap-2 w-full">
                    <input type="text" name="nom" placeholder="Nom" required class="w-1/2 bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm outline-none">
                    <input type="text" name="prenom" placeholder="Prénom" required class="w-1/2 bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm outline-none">
                </div>
                <input type="email" name="email" placeholder="Email institutionnel" required class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm outline-none">
                <input type="password" name="password" placeholder="Mot de passe" required class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm outline-none">
                <button type="submit" class="mt-4 rounded-full bg-slate-800 text-white font-bold py-3 px-10 text-xs uppercase tracking-wider hover:scale-105 transition-transform shadow-md">S'inscrire</button>
            </form>
        </div>

        <div class="form-container sign-in-container bg-white">
            <form action="actions/login_action.php" method="POST" class="flex flex-col items-center justify-center h-full px-10 text-center">
                <h1 class="font-bold text-2xl mb-4 text-slate-800">Se connecter</h1>
                <select name="type_compte" class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm font-semibold outline-none">
                    <option value="etudiant">Espace Étudiant</option>
                    <option value="enseignant">Espace Staff / Profs / Admin</option>
                </select>
                <input type="email" name="email" placeholder="Email institutionnel" required class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm outline-none">
                <input type="password" name="password" placeholder="Mot de passe" required class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm outline-none">
                <button type="submit" class="mt-4 rounded-full bg-slate-800 text-white font-bold py-3 px-10 text-xs uppercase tracking-wider hover:scale-105 transition-transform shadow-md">Connexion</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 class="font-bold text-2xl mb-2">Déjà inscrit ?</h1>
                    <p class="text-sm text-slate-300 mb-6">Connectez-vous pour accéder à votre espace de gestion.</p>
                    <button class="border border-white rounded-full py-2.5 px-8 uppercase font-bold text-xs hover:bg-white hover:text-slate-900 transition-all" id="signIn">Se connecter</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1 class="font-bold text-2xl mb-2">Nouveau ici ?</h1>
                    <p class="text-sm text-slate-300 mb-6">Créez un compte pour rejoindre la plateforme de l'IUT.</p>
                    <button class="border border-white rounded-full py-2.5 px-8 uppercase font-bold text-xs hover:bg-white hover:text-slate-900 transition-all" id="signUp">S'inscrire</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('login-container');
        document.getElementById('signUp').addEventListener('click', () => container.classList.add('right-panel-active'));
        document.getElementById('signIn').addEventListener('click', () => container.classList.remove('right-panel-active'));
    </script>
</body>
</html>