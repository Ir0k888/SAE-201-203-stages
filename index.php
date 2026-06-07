<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Informations - MMI Stages</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">
    
    <?php include 'includes/navbar.php'; ?>

    <main class="flex-grow flex items-center justify-center p-8">
        <div class="max-w-3xl bg-white p-12 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex items-center gap-4 mb-8 border-b border-slate-100 pb-6">
                <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center font-black text-2xl shadow-inner">IUT</div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Bienvenue sur MMI Stages</h1>
                    <p class="text-slate-500">Institut Universitaire de Technologie de Meaux</p>
                </div>
            </div>
            
            <div class="space-y-6 text-slate-600 text-sm leading-relaxed">
                <p>Cette plateforme centralise l'intégralité du processus de stage pour les étudiants du BUT Métiers du Multimédia et de l'Internet (MMI).</p>
                
                <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                    <h3 class="font-bold text-slate-900 text-base mb-3">Comment fonctionne la plateforme ?</h3>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Recherche :</strong> Consultez le catalogue d'offres et postulez directement en joignant votre CV.</li>
                        <li><strong>Validation :</strong> Le Responsable des stages approuve vos démarches et débloque les conventions.</li>
                        <li><strong>Suivi :</strong> Un enseignant tuteur vous est assigné pour préparer votre évaluation.</li>
                        <li><strong>Soutenance :</strong> Votre tuteur organise et planifie votre oral final directement via l'outil.</li>
                    </ul>
                </div>
                
                <p class="italic text-xs text-slate-400">Pour toute question technique, veuillez contacter l'administration via les liens situés en bas de page.</p>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>