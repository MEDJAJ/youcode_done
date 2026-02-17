<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications Réservations | Youco'Done Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #0f172a; color: #f8fafc; font-family: 'Inter', sans-serif; }
        .glass-card { background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.05); }
        .notification-item { transition: all 0.3s ease; border-left: 4px solid transparent; }
        .notification-item.new { border-left-color: #f97316; background: rgba(249, 115, 22, 0.05); }
        .notification-item:hover { background: rgba(255, 255, 255, 0.03); }
    </style>
</head>
<body class="p-6">

    <div class="max-w-4xl mx-auto space-y-6">
        
        <div class="flex justify-between items-end border-b border-slate-800 pb-6">
            <div>
                <div class="flex items-center gap-2 text-orange-500 mb-1">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                    </span>
                    <span class="text-[10px] font-black uppercase tracking-widest">Live Feed</span>
                </div>
                <h1 class="text-3xl font-bold italic tracking-tighter">NOTIFICATIONS</h1>
            </div>
            <div class="flex gap-4">
                <button class="text-slate-500 text-xs hover:text-white transition">Tout marquer comme lu</button>
                <div class="h-6 w-px bg-slate-800"></div>
                <button class="text-slate-500 text-xs hover:text-white transition"><i class="fas fa-cog"></i></button>
            </div>
        </div>

        <div class="flex gap-2">
            <button class="px-4 py-1.5 rounded-full bg-orange-500 text-white text-xs font-bold">Toutes</button>
           
        </div>

      <div class="glass-card rounded-[2rem] overflow-hidden">

@forelse($notifications as $notification)

    <div class="notification-item {{ $notification->read_at ? '' : 'new' }} p-6 flex flex-col md:flex-row justify-between items-center gap-4 border-b border-white/5">
        <div class="flex gap-4 w-full">
            <div class="w-12 h-12 rounded-2xl bg-orange-500/20 flex items-center justify-center text-orange-500 shrink-0">
                <i class="fas fa-calendar-plus text-xl"></i>
            </div>

            <div>
                <div class="flex items-center gap-2 mb-1">
                    <h3 class="font-bold text-white text-sm">
                        Nouvelle réservation : {{ $notification->data['client_name'] }}
                    </h3>

                    @if($notification->data['payment_status'] == 'paid')
                        <span class="bg-green-500/10 text-green-500 text-[8px] font-black px-2 py-0.5 rounded uppercase tracking-widest border border-green-500/20">
                            Acompte Payé
                        </span>
                    @else
                        <span class="bg-red-500/10 text-red-500 text-[8px] font-black px-2 py-0.5 rounded uppercase tracking-widest border border-red-500/20">
                            Non Payé
                        </span>
                    @endif
                </div>

                <p class="text-slate-400 text-xs leading-relaxed">
                    <span class="text-white font-medium">
                        {{ $notification->data['guests'] }} personnes
                    </span>
                    pour le
                    <span class="text-white font-medium">
                        {{ \Carbon\Carbon::parse($notification->data['date'])->translatedFormat('l d F') }}
                        à {{ $notification->data['time'] }}
                    </span>.
                    <br>
                    <span class="text-slate-500 text-[11px]">
                        Restaurant : {{ $notification->data['restaurant_name'] }}
                    </span>
                </p>
            </div>
        </div>
    </div>

@empty

    <div class="p-10 text-center text-slate-500">
        Aucune notification pour le moment.
    </div>

@endforelse

</div>


        <div class="bg-slate-900/50 p-4 rounded-2xl text-center">
            <p class="text-[10px] text-slate-500 uppercase tracking-[0.2em]">Vous recevez également ces alertes par mail sur <span class="text-slate-300">contact@gourmetpalace.fr</span></p>
        </div>

    </div>

</body>
</html>