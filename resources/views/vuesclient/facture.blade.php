<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Télécharger votre Facture - FoodHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #0f172a; 
        }
        .btn-luxury {
            background: linear-gradient(135deg, #ff6b6b 0%, #f0932b 100%);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .btn-luxury:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(240, 147, 43, 0.4);
        }
        /* Animation pour le message de succès */
        @keyframes slideInDown {
            from { transform: translate(-50%, -100%); opacity: 0; }
            to { transform: translate(-50%, 0); opacity: 1; }
        }
        .animate-success {
            animation: slideInDown 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="text-white antialiased flex items-center justify-center min-h-screen">

    @if(session('success'))
    <div class="fixed top-8 left-1/2 -translate-x-1/2 z-50 w-full max-w-sm px-4 animate-success">
        <div class="bg-emerald-500/10 border border-emerald-500/50 backdrop-blur-xl p-4 rounded-2xl flex items-center gap-4 shadow-2xl">
            <div class="bg-emerald-500 p-2 rounded-full">
                <i data-lucide="check" class="w-4 h-4 text-white"></i>
            </div>
            <div>
                <p class="text-emerald-400 font-bold text-sm">Félicitations !</p>
                <p class="text-emerald-200/80 text-xs">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="fixed top-8 left-8">
        <a href="/dashboard/client" class="group flex items-center gap-3 text-slate-400 hover:text-white transition-all">
            <div class="p-3 rounded-full border border-white/10 group-hover:border-orange-500/50 bg-white/5 transition-all">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </div>
            <span class="text-sm font-bold uppercase tracking-widest hidden sm:inline">Retour Accueil</span>
        </a>
    </div>

    <div class="text-center px-6">
        <div class="mb-8 inline-flex p-6 rounded-full bg-orange-500/10 border border-orange-500/20">
            <i data-lucide="file-text" class="w-12 h-12 text-orange-500"></i>
        </div>
        
        <h1 class="text-3xl md:text-5xl font-extrabold mb-4 tracking-tight">Votre facture est prête</h1>
        <p class="text-slate-400 mb-12 max-w-md mx-auto leading-relaxed">
            Paiement confirmé avec succès. Vous pouvez maintenant télécharger votre justificatif de réservation.
        </p>

        <a href="{{ route('facture.download', $reservation->id) }}" class="btn-luxury inline-flex items-center gap-3 px-10 py-5 rounded-2xl font-bold text-sm uppercase tracking-widest shadow-2xl">
            <i data-lucide="download" class="w-5 h-5"></i>
            Télécharger la facture (PDF)
        </a>
    </div>

    <script>
        lucide.createIcons();

        // Optionnel : Faire disparaître le message après 5 secondes
        setTimeout(() => {
            const successMsg = document.querySelector('.animate-success');
            if(successMsg) {
                successMsg.style.transition = "opacity 0.5s ease";
                successMsg.style.opacity = "0";
                setTimeout(() => successMsg.remove(), 500);
            }
        }, 5000);
    </script>
</body>
</html>