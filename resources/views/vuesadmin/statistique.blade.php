<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytiques - FoodHub Executive</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0f172a; color: white; }
        
        .glass-nav {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .hero-corporate {
            position: relative;
            height: 45vh;
            min-height: 400px;
            display: flex;
            align-items: center;
            overflow: hidden;
            background-color: #000;
        }

        .hero-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.5;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, #0f172a 45%, transparent 100%);
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(249, 115, 22, 0.3);
            transform: translateY(-5px);
        }

        .nav-link { position: relative; transition: color 0.3s; }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #f97316;
            border-radius: 2px;
        }
    </style>
</head>
<body class="antialiased">

    <nav class="glass-nav fixed w-full z-50 px-8 py-5">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-500 text-white rounded-xl flex items-center justify-center font-black text-xl shadow-lg">F</div>
                <span class="text-xl font-extrabold tracking-tighter uppercase italic">FoodHub <span class="text-slate-500 font-light">Admin</span></span>
            </div>

            <div class="hidden md:flex items-center gap-10">
                <a href="/dashboard/admin" class="nav-link text-[10px] font-bold uppercase tracking-[0.3em] text-slate-500 hover:text-white transition-colors">Restaurants</a>
                <a href="#" class="nav-link active text-[10px] font-bold uppercase tracking-[0.3em] text-white">Analytiques</a>
            </div>

            <div class="flex items-center gap-4 border-l border-white/10 pl-8">
                <div class="text-right">
                    <p class="text-[9px] text-orange-500 font-bold uppercase tracking-widest">Contrôle</p>
                    <p class="text-xs font-bold text-slate-200 uppercase tracking-tighter">Administrateur</p>
                </div>
            </div>
        </div>
    </nav>

    <header class="hero-corporate">
        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=2026" 
             class="hero-image shadow-inner" alt="Data Analytics Professional">
        <div class="hero-overlay"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-8 w-full">
            <div class="max-w-2xl">
                <span class="inline-block text-orange-500 font-bold tracking-[0.4em] uppercase text-[10px] mb-6">Business Intelligence</span>
                <h1 class="text-6xl font-black mb-6 tracking-tight leading-tight">
                    Performances <br> <span class="text-orange-500">Globales.</span>
                </h1>
                <p class="text-slate-200 text-xl font-light leading-relaxed opacity-90">
                    Consultez l'état de santé de votre plateforme. Suivez la croissance des utilisateurs et l'activité des établissements en temps réel.
                </p>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-8 py-24">
        
        <div class="flex items-center justify-between mb-16">
            <h2 class="text-xl font-bold tracking-widest uppercase text-slate-400">Indicateurs de Croissance</h2>
            <div class="h-[1px] flex-1 bg-white/5 mx-8"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <div class="stat-card p-10 rounded-[2.5rem] relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em] mb-4">Clients</p>
                <h3 class="text-5xl font-black text-white mb-2">{{$clients}}</h3>
                <p class="text-green-500 text-xs font-bold">+12% ce mois</p>
            </div>

            <div class="stat-card p-10 rounded-[2.5rem] relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em] mb-4">Restaurateurs</p>
                <h3 class="text-5xl font-black text-white mb-2">{{$restaurateurs}}</h3>
                <p class="text-orange-500 text-xs font-bold">Inscriptions actives</p>
            </div>

            <div class="stat-card p-10 rounded-[2.5rem] relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em] mb-4">Restaurants</p>
                <h3 class="text-5xl font-black text-white mb-2">{{$restaurants}}</h3>
                <p class="text-slate-400 text-xs font-bold italic">Base de données totale</p>
            </div>

            <div class="stat-card p-10 rounded-[2.5rem] bg-orange-500/5 border-orange-500/20 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-6 opacity-20 group-hover:opacity-30 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-orange-500 text-[10px] font-bold uppercase tracking-[0.2em] mb-4">Restaurants Actifs</p>
                <h3 class="text-5xl font-black text-white mb-2">{{$restaurantsActifs}}</h3>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <p class="text-white text-xs font-bold uppercase tracking-tighter">En ligne</p>
                </div>
            </div>

        </div>

      
    </main>

</body>
</html>