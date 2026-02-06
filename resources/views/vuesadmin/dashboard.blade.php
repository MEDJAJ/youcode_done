<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Console Admin - FoodHub Executive</title>
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
            height: 55vh;
            min-height: 450px;
            display: flex;
            align-items: center;
            overflow: hidden;
            background-color: #000;
        }

        /* L'image claire et pro demandée */
        .hero-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.7; /* Opacité ajustée pour la clarté */
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, #0f172a 45%, transparent 100%);
        }

        .soft-delete-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .soft-delete-btn:hover {
            background: #f97316;
            border-color: #f97316;
            color: white;
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(249, 115, 22, 0.3);
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
                <a href="#" class="nav-link active text-[10px] font-bold uppercase tracking-[0.3em] text-white">Restaurants</a>
                <a href="/statistique/afficher" class="nav-link text-[10px] font-bold uppercase tracking-[0.3em] text-slate-500 hover:text-white transition-colors">Analytiques</a>
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
        <img src="https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&q=80&w=2070" 
             class="hero-image shadow-inner" alt="Modern Professional Restaurant">
        <div class="hero-overlay"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-8 w-full">
            <div class="max-w-2xl">
                
                <h1 class="text-6xl font-black mb-6 tracking-tight leading-tight">
                    Gestion du <br> <span class="text-orange-500">Catalogue.</span>
                </h1>
                <p class="text-slate-200 text-xl font-light leading-relaxed opacity-90">
                    Interface de supervision dédiée à la modération des établissements. Gérez la visibilité de vos partenaires gastronomiques en toute simplicité.
                </p>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-8 py-24">
        
        <div class="flex items-center justify-between mb-16">
            <h2 class="text-xl font-bold tracking-widest uppercase text-slate-400">Unités Sous Contrôle</h2>
            <div class="h-[1px] flex-1 bg-white/5 mx-8"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">


            
        @foreach($restaurants as $restaurant)
        @if(!$restaurant->is_delete)
            <div class="group relative bg-white/[0.02] rounded-[2.5rem] overflow-hidden border border-white/5 transition-all duration-500 hover:border-orange-500/20">
                <div class="h-64 overflow-hidden relative">
                    <img src="{{asset('storage/'.$restaurant->photos->first()->path)}}" 
                         class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="Resto">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-transparent to-transparent opacity-80"></div>
                </div>

                <div class="p-8">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-[9px] font-bold text-orange-500 uppercase tracking-widest block mb-2">{{$restaurant->type_de_cuisin}}</span>
                            <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-orange-500 transition-colors tracking-tight">{{$restaurant->nom}}</h3>
                            <p class="text-slate-500 text-xs font-medium">📍 {{$restaurant->location}}</p>
                        </div>
                        <form action="{{ route('restaurants.destroysoft', $restaurant->id) }}" method="POST">
                            @csrf
                        <button title="Visibilité" class="soft-delete-btn w-12 h-12 rounded-2xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
          </form>

                    </div>
                </div>
            </div>

@endif


@endforeach


        </div>
    </main>

</body>
</html>