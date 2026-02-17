<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Sécurisé | Youco'Done</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .step-active { color: #f97316; border-bottom: 2px solid #f97316; }
        .card-input:focus { border-color: #f97316; ring: 2px; ring-color: #f97316; outline: none; }
        /* Animation pour le chargement */
        @keyframes pulse-soft { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
        .loading-pulse { animation: pulse-soft 2s infinite; }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 md:p-8 font-sans">

<div class="bg-white w-full max-w-5xl rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row border border-gray-100 min-h-[600px]">

    <div class="md:w-1/3 bg-slate-900 text-white p-8 flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-2 mb-8">
                <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-utensils text-xs"></i>
                </div>
                <span class="font-bold tracking-tighter text-xl">Youco'Done</span>
            </div>

            <h2 class="text-orange-500 font-bold uppercase tracking-widest text-[10px] mb-6">Détails de la réservation</h2>
            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5" class="w-16 h-16 rounded-xl object-cover shadow-2xl shadow-black/50">
                    <div>
                        <h3 class="font-bold text-lg">Le Gourmet Palace</h3>
                        <p class="text-xs text-slate-400 italic">Paris, FR</p>
                    </div>
                </div>
                
                <div class="space-y-4 pt-6 border-t border-slate-800/50">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Date</span>
                        <span id="summary-date" class="font-medium text-orange-400">Samedi 22 Mars 2026</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Heure</span>
                        <span id="summary-time" class="font-medium">20:30</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Table pour</span>
                        <span id="summary-guests" class="font-medium">2 personnes</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-slate-800">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm text-slate-400">Acompte Stripe</span>
                <span class="text-2xl font-black text-white">20.00 €</span>
            </div>
            <p class="text-[10px] text-slate-500 leading-tight flex items-center gap-2">
                <i class="fas fa-info-circle text-orange-500"></i>
                Déduit de l'addition finale au restaurant.
            </p>
        </div>
    </div>

    <div class="md:w-2/3 p-8 lg:p-12 bg-white">
        
        <div class="flex items-center justify-between mb-10">
            <div class="flex gap-6 text-xs font-bold uppercase tracking-widest">
                <span class="text-green-500 flex items-center gap-2"><i class="fas fa-check"></i> Infos</span>
                <span class="step-active pb-1">Paiement</span>
            </div>
            <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" class="h-6 opacity-40">
        </div>

        <div class="space-y-8">
            <div>
                <h1 class="text-3xl font-black text-slate-800 mb-2 italic uppercase">Paiement par Carte</h1>
                <p class="text-sm text-slate-500">Propulsé par Stripe. Vos données bancaires sont cryptées et jamais stockées.</p>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Nom sur la carte</label>
                    <input type="text" placeholder="JEAN DUPONT" class="card-input w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-sm font-bold placeholder:text-slate-300">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Numéro de carte</label>
                    <div class="relative">
                        <input type="text" placeholder="xxxx xxxx xxxx xxxx" class="card-input w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-sm font-bold tracking-[0.2em] placeholder:text-slate-300">
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 flex gap-2">
                            <i class="fab fa-cc-visa text-2xl text-slate-300"></i>
                            <i class="fab fa-cc-mastercard text-2xl text-slate-300"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Expiration</label>
                        <input type="text" placeholder="MM / YY" class="card-input w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-sm font-bold text-center placeholder:text-slate-300">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">CVC / CVV</label>
                        <input type="text" placeholder="123" class="card-input w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-sm font-bold text-center placeholder:text-slate-300">
                    </div>
                </div>
            </div>

            <div class="pt-4">
               <form action="{{ route('stripe.checkout', $reservation->id) }}" method="POST">
    @csrf
    <button class="group w-full bg-orange-500 hover:bg-orange-600 text-white py-5 rounded-[1.5rem] font-black text-lg transition-all flex items-center justify-center gap-4 shadow-2xl shadow-orange-200">
        CONFIRMER & PAYER {{ number_format($reservation->amount, 2) }} €
    </button>
</form>

             
            </div>
        </div>
    </div>
</div>

<div id="success-modal" class="hidden fixed inset-0 bg-slate-900/95 backdrop-blur-md z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-[3.5rem] p-12 max-w-sm w-full text-center space-y-8 shadow-2xl">
        <div class="w-24 h-24 bg-green-50 text-green-500 rounded-full flex items-center justify-center text-4xl mx-auto border-4 border-green-100 animate-bounce">
            <i class="fas fa-check"></i>
        </div>
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tighter">C'EST TOUT BON !</h2>
            <p class="text-slate-500 text-sm mt-3 leading-relaxed">Votre table est réservée. Nous avons envoyé le reçu Stripe à votre email.</p>
        </div>
        <button onclick="window.location.href='/reservations'" class="w-full bg-slate-900 hover:bg-black text-white font-bold py-5 rounded-2xl transition-all uppercase tracking-widest text-xs">
            Accéder à mes réservations
        </button>
    </div>
</div>

<script>
  
</script>

</body>
</html>