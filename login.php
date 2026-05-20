<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Stages MMI</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="assets/js/tailwind.config.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-slate-100 flex flex-col justify-center items-center min-h-screen font-sans p-4">
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-slate-800">Stages MMI Meaux</h2>
    </div>
    
    <div class="login-container bg-white rounded-2xl shadow-xl relative overflow-hidden w-[768px] max-w-full min-h-[580px]" id="login-container">
        
        <div class="form-container sign-up-container absolute top-0 h-full w-1/2 left-0 opacity-0 z-10 transition-all duration-500 overflow-y-auto">
            <form action="actions/register_action.php" method="POST" class="flex flex-col items-center justify-center min-h-full py-8 px-12 text-center bg-white">
                <h1 class="font-bold text-2xl mb-4 text-slate-800">Créer un compte</h1>
                
                <select id="reg-account-type" name="type_compte" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 my-2 rounded-xl text-sm font-semibold" onchange="toggleTeacherFields()">
                    <option value="etudiant">Je suis Étudiant</option>
                    <option value="enseignant">Je suis Enseignant / Personnel</option>
                </select>

                <div id="teacher-role-fields" class="w-full hidden mt-1 mb-2 p-3 bg-blue-50 border border-blue-100 rounded-xl">
                    <p class="text-xs text-blue-600 mb-2 font-medium">Votre compte devra être validé par un Administrateur.</p>
                    <select name="role_souhaite" class="w-full bg-white border border-blue-200 px-3 py-2 rounded-lg text-sm outline-none">
                        <option value="Enseignant">Enseignant standard</option>
                        <option value="Responsable de stage">Responsable de stage</option>
                        <option value="Chef de departement">Chef de département</option>
                        <option value="Maitre de stage">Maître de stage (Tuteur entreprise)</option>
                    </select>
                </div>

                <div class="flex gap-2 w-full">
                    <input type="text" name="nom" placeholder="Nom" class="w-1/2 bg-slate-50 border border-slate-200 px-4 py-3 my-2 rounded-xl outline-none">
                    <input type="text" name="prenom" placeholder="Prénom" class="w-1/2 bg-slate-50 border border-slate-200 px-4 py-3 my-2 rounded-xl outline-none">
                </div>
                <input type="email" name="email" placeholder="Email institutionnel" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 my-2 rounded-xl outline-none">
                <input type="password" name="password" placeholder="Mot de passe" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 my-2 rounded-xl outline-none">
                
                <button type="submit" class="mt-4 rounded-full bg-gradient-to-r from-brandStart to-brandEnd text-white font-bold py-3 px-10 uppercase tracking-wider hover:scale-105 transition-transform shadow-md">S'inscrire</button>
            </form>
        </div>

        <div class="form-container sign-in-container absolute top-0 h-full w-1/2 left-0 z-20 transition-all duration-500">
            <form action="actions/login_action.php" method="POST" class="flex flex-col items-center justify-center h-full px-12 text-center bg-white">
                <h1 class="font-bold text-2xl mb-4 text-slate-800">Se connecter</h1>
                
                <select name="type_compte" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 my-2 rounded-xl text-sm font-semibold">
                    <option value="etudiant">Espace Étudiant</option>
                    <option value="enseignant">Espace Staff (Admin, Profs...)</option>
                </select>

                <input type="email" name="email" placeholder="Email" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 my-2 rounded-xl outline-none">
                <input type="password" name="password" placeholder="Mot de passe" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 my-2 rounded-xl outline-none">
                
                <button type="submit" class="mt-6 rounded-full bg-gradient-to-r from-brandStart to-brandEnd text-white font-bold py-3 px-10 uppercase tracking-wider hover:scale-105 transition-transform shadow-md">Connexion</button>
            </form>
        </div>

        <div class="overlay-container absolute top-0 left-1/2 w-1/2 h-full overflow-hidden z-[100] transition-transform duration-500">
            <div class="overlay bg-gradient-to-r from-brandStart to-brandEnd text-white relative -left-full h-full w-[200%] transition-transform duration-500">
                <div class="overlay-panel overlay-left absolute flex flex-col items-center justify-center px-10 text-center top-0 h-full w-1/2 transition-transform duration-500">
                    <h1 class="font-bold text-2xl mb-4">Déjà inscrit ?</h1>
                    <p class="text-sm text-blue-100 mb-6">Connectez-vous pour accéder à votre espace de gestion des stages.</p>
                    <button class="border border-white rounded-full py-2 px-8 uppercase font-bold text-xs hover:bg-white hover:text-brandStart transition-all" id="signIn">Se connecter</button>
                </div>
                <div class="overlay-panel overlay-right absolute right-0 flex flex-col items-center justify-center px-10 text-center top-0 h-full w-1/2 transition-transform duration-500">
                    <h1 class="font-bold text-2xl mb-4">Nouveau ?</h1>
                    <p class="text-sm text-blue-100 mb-6">Créez un compte pour rejoindre la plateforme de l'IUT de Meaux.</p>
                    <button class="border border-white rounded-full py-2 px-8 uppercase font-bold text-xs hover:bg-white hover:text-brandStart transition-all" id="signUp">S'inscrire</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        // Logique spécifique pour afficher/cacher le rôle dans le formulaire d'inscription
        function toggleTeacherFields() {
            const accType = document.getElementById('reg-account-type').value;
            const teacherFields = document.getElementById('teacher-role-fields');
            if(accType === 'enseignant') {
                teacherFields.classList.remove('hidden');
            } else {
                teacherFields.classList.add('hidden');
            }
        }
    </script>
</body>
</html>