<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion & Inscription - Stages MMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .login-container.right-panel-active .sign-in-container { transform: translateX(100%); opacity: 0; z-index: 1; }
        .login-container.right-panel-active .sign-up-container { transform: translateX(100%); opacity: 1; z-index: 5; }
        .login-container.right-panel-active .overlay-container { transform: translateX(-100%); }
        .login-container.right-panel-active .overlay { transform: translateX(50%); }
    </style>
</head>
<body class="bg-slate-100 flex flex-col justify-center items-center min-h-screen p-4">
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-slate-800">Stages MMI Meaux</h2>
        <?php if(isset($_GET['msg'])): ?>
            <p class="mt-2 text-sm font-semibold text-green-600">Compte créé avec succès ! Connectez-vous.</p>
        <?php endif; ?>
    </div>
    
    <div class="login-container bg-white rounded-2xl shadow-xl relative overflow-hidden w-[768px] max-w-full min-h-[500px]" id="login-container">
        <div class="form-container sign-up-container absolute top-0 h-full w-1/2 left-0 opacity-0 z-10 transition-all duration-500">
            <form action="actions/register_action.php" method="POST" class="flex flex-col items-center justify-center h-full px-10 text-center bg-white">
                <h1 class="font-bold text-2xl mb-4 text-slate-800">S'inscrire</h1>
                <div class="flex gap-2 w-full">
                    <input type="text" name="nom" placeholder="Nom" required class="w-1/2 bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm outline-none">
                    <input type="text" name="prenom" placeholder="Prénom" required class="w-1/2 bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm outline-none">
                </div>
                <input type="email" name="email" placeholder="Email (ex: @etudiant.univ.fr)" required class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm outline-none">
                <input type="password" name="password" placeholder="Mot de passe" required class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm outline-none">
                <button type="submit" class="mt-4 rounded-full bg-slate-800 text-white font-bold py-2.5 px-8 text-xs uppercase tracking-wider hover:scale-105 transition-transform shadow-md">S'inscrire</button>
            </form>
        </div>

        <div class="form-container sign-in-container absolute top-0 h-full w-1/2 left-0 z-20 transition-all duration-500">
            <form action="actions/login_action.php" method="POST" class="flex flex-col items-center justify-center h-full px-10 text-center bg-white">
                <h1 class="font-bold text-2xl mb-4 text-slate-800">Se connecter</h1>
                <select name="type_compte" class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm font-semibold outline-none">
                    <option value="etudiant">Espace Étudiant</option>
                    <option value="enseignant">Espace Staff / Profs / Admin</option>
                </select>
                <input type="email" name="email" placeholder="Email" required class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm outline-none">
                <input type="password" name="password" placeholder="Mot de passe" required class="w-full bg-slate-50 border border-slate-200 px-4 py-2.5 my-1.5 rounded-xl text-sm outline-none">
                <button type="submit" class="mt-4 rounded-full bg-slate-800 text-white font-bold py-2.5 px-8 text-xs uppercase tracking-wider hover:scale-105 transition-transform shadow-md">Connexion</button>
            </form>
        </div>

        <div class="overlay-container absolute top-0 left-1/2 w-1/2 h-full overflow-hidden z-50 transition-transform duration-500">
            <div class="overlay bg-slate-800 text-white relative -left-full h-full w-[200%] transition-transform duration-500">
                <div class="overlay-panel overlay-left absolute flex flex-col items-center justify-center px-8 text-center top-0 h-full w-1/2 -translate-x-full transition-transform duration-500">
                    <h1 class="font-bold text-xl mb-2">Déjà un compte ?</h1>
                    <p class="text-xs text-slate-300 mb-4">Connectez-vous directement à votre espace de travail.</p>
                    <button class="border border-white rounded-full py-2 px-6 uppercase font-bold text-[10px] hover:bg-white hover:text-slate-800 transition-all" id="signIn">Se connecter</button>
                </div>
                <div class="overlay-panel overlay-right absolute right-0 flex flex-col items-center justify-center px-8 text-center top-0 h-full w-1/2 transition-transform duration-500">
                    <h1 class="font-bold text-xl mb-2">Nouveau ici ?</h1>
                    <p class="text-xs text-slate-300 mb-4">Créez votre profil pour suivre vos stages d'IUT.</p>
                    <button class="border border-white rounded-full py-2 px-6 uppercase font-bold text-[10px] hover:bg-white hover:text-slate-800 transition-all" id="signUp">S'inscrire</button>
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