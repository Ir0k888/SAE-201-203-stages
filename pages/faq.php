<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['user_id'])) { header('Location: ../index.php'); exit(); }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>FAQ - MMI Stages</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex flex-col">

    <?php include '../includes/navbar.php'; ?>

    <main class="flex-grow p-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-black mb-8 text-slate-900">Foire Aux Questions</h1>
            
            <div class="space-y-4">
                <details class="bg-white p-6 rounded-xl border-2 border-slate-200 shadow-sm group cursor-pointer">
                    <summary class="font-bold text-lg text-slate-900 group-hover:text-rose-600 outline-none">Comment postuler à une offre de stage ?</summary>
                    <p class="mt-4 text-sm font-medium text-slate-600">Rendez-vous dans la section "Offres", cliquez sur le bouton "Postuler" de l'offre qui vous intéresse, joignez votre CV au format PDF et validez. Votre candidature apparaîtra ensuite dans vos suivis.</p>
                </details>
                
                <details class="bg-white p-6 rounded-xl border-2 border-slate-200 shadow-sm group cursor-pointer">
                    <summary class="font-bold text-lg text-slate-900 group-hover:text-rose-600 outline-none">Qui valide mon entretien de stage ?</summary>
                    <p class="mt-4 text-sm font-medium text-slate-600">Les professeurs responsables de stage de la plateforme examinent les détails de votre offre et valident votre candidature. Vous recevrez une notification dans votre espace de suivi.</p>
                </details>
                
                <details class="bg-white p-6 rounded-xl border-2 border-slate-200 shadow-sm group cursor-pointer">
                    <summary class="font-bold text-lg text-slate-900 group-hover:text-rose-600 outline-none">Où puis-je télécharger ma convention de stage ?</summary>
                    <p class="mt-4 text-sm font-medium text-slate-600">Une fois votre offre formellement acceptée par le responsable, les documents administratifs seront générés par le secrétariat et accessibles dans votre profil ou envoyés par e-mail.</p>
                </details>

                <details class="bg-white p-6 rounded-xl border-2 border-slate-200 shadow-sm group cursor-pointer">
                    <summary class="font-bold text-lg text-slate-900 group-hover:text-rose-600 outline-none">Comment contacter mon tuteur pédagogique ?</summary>
                    <p class="mt-4 text-sm font-medium text-slate-600">Dès qu'un professeur vous sera affilié, vous retrouverez ses coordonnées directement dans votre onglet "Ma Soutenance" afin de préparer votre rapport.</p>
                </details>

                <details class="bg-white p-6 rounded-xl border-2 border-slate-200 shadow-sm group cursor-pointer">
                    <summary class="font-bold text-lg text-slate-900 group-hover:text-rose-600 outline-none">Puis-je modifier mon CV après l'avoir soumis ?</summary>
                    <p class="mt-4 text-sm font-medium text-slate-600">Non, toute candidature envoyée est définitive. Si vous avez fait une erreur majeure, veuillez contacter directement le secrétariat ou votre responsable de stage.</p>
                </details>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html>