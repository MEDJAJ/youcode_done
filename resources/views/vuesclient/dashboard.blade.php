<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodHub - L'Expérience Gastronomique</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0f172a; scroll-behavior: smooth; }
        
        .hero-bg {
            background: linear-gradient(to bottom, rgba(15, 23, 42, 0.6), #0f172a), 
                        url('https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&q=80&w=2070');
            background-size: cover;
            background-position: center;
        }

        .glass-search {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-luxury {
            background: linear-gradient(135deg, #ff6b6b 0%, #f0932b 100%);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-luxury:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(240, 147, 43, 0.4);
        }

        .card-zoom:hover .card-img { transform: scale(1.1); }
          
        .overlay-gradient {
            background: linear-gradient(to top, rgba(15, 23, 42, 1) 0%, rgba(15, 23, 42, 0.4) 60%, transparent 100%);
        }

        .fav-btn {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        .fav-btn:hover {
            background: rgba(239, 68, 68, 0.9);
            border-color: transparent;
            transform: scale(1.1);
        }

        [data-aos] { opacity: 1 !important; transform: none !important; }
        .aos-init[data-aos] { opacity: 0 !important; }
        .aos-animate[data-aos] { opacity: 1 !important; }
    </style>
</head>
<body class="text-white antialiased">

    <div class="fixed top-6 right-6 z-50">
        <a href="{{ route('restaurants.favorite') }}" class="glass-search px-6 py-3 rounded-full flex items-center gap-3 hover:bg-white/10 transition-all border border-white/20 shadow-xl group">
            <span class="text-xs font-bold uppercase tracking-widest hidden md:block">Mes Favoris</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 fill-red-500 group-hover:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3.172 5.172a4.002 4.002 0 015.657 0L10 6.343l1.172-1.171a4.002 4.002 0 115.657 5.657L10 18.343l-8.343-8.343a4.002 4.002 0 010-5.657z" clip-rule="evenodd" />
            </svg>
        </a>
    </div>

    <header class="relative min-h-[70vh] flex flex-col items-center justify-center text-center px-6 hero-bg">
        <div class="relative z-10" data-aos="fade-up">
            <span class="inline-block text-orange-500 font-bold tracking-[0.4em] uppercase text-[10px] mb-4">
                Exclusive Gastronomy
            </span>
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 tracking-tight">
                Trouvez la table <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-red-500">Parfaite.</span>
            </h1>
            <p class="text-slate-300 max-w-xl mx-auto font-light leading-relaxed mb-12">
                Une sélection rigoureuse des meilleurs restaurants pour vos moments d'exception.
            </p>
        </div>

        <div class="w-full max-w-4xl px-4" data-aos="fade-up" data-aos-delay="200">
           <form action="{{ route('restaurants.search') }}" method="GET">
                <div class="glass-search p-2 rounded-2xl md:rounded-full flex flex-col md:flex-row gap-2 shadow-2xl">
                    <div class="flex-1 flex items-center px-6 py-3">
                        <span class="mr-3 text-lg opacity-50"></span>
                        <input type="text" name="search" placeholder="Nom, cuisine, lieu..." class="bg-transparent w-full focus:outline-none text-sm placeholder-slate-400">
                    </div>
                    <button type="submit" class="btn-luxury px-10 py-4 rounded-xl md:rounded-full font-bold text-xs uppercase tracking-widest">
                        Rechercher
                    </button>
                </div>
            </form>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-20 px-6">
        <div class="flex items-center justify-between mb-12" data-aos="fade-right">
            <h2 class="text-3xl font-bold tracking-tight">Etablissements à la une</h2>
            <div class="h-[1px] flex-1 bg-white/10 mx-8 hidden md:block"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            @foreach($restaurants as $restairant)
            <div class="card-zoom group relative h-[480px] rounded-[2.5rem] overflow-hidden border border-white/5 bg-slate-900" data-aos="fade-up">
                <form action="{{ route('favorite.toggle', $restairant->id) }}" method="POST">
                    @csrf
                    <button class="fav-btn absolute top-6 right-6 z-30 w-12 h-12 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-6 w-6 {{ $restairant->isFavorited() ? 'text-red-500 fill-red-500' : 'text-white' }}"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </form>

                <img src="{{asset('storage/'.$restairant->photos->first()->path)}}" 
                     class="card-img absolute inset-0 w-full h-full object-cover transition-transform duration-1000 brightness-75" alt="Resto">
                
                <div class="overlay-gradient absolute inset-0 flex flex-col justify-end p-8 transition-all duration-500 group-hover:pb-10">
                    <div class="mb-4">
                        <div class="absolute top-6 left-6 z-20">
                        @if($restairant->status)
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-green-500/30">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                <span class="text-[9px] font-bold uppercase tracking-widest text-green-400">Actif</span>
                            </div>
                        @else
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-red-500/30">
                                <span class="relative flex h-2 w-2">
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                </span>
                                <span class="text-[9px] font-bold uppercase tracking-widest text-red-400">Inactif</span>
                            </div>
                        @endif
                    </div>
                        <span class="text-[10px] font-bold text-orange-500 uppercase tracking-widest bg-orange-500/10 px-3 py-1 rounded-full border border-orange-500/20">
                            {{$restairant->type_de_cuisin}}
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">{{$restairant->nom}}</h3>
                    <p class="text-slate-400 text-sm mb-6 flex items-center">
                        <span class="mr-2"></span> {{$restairant->location}}
                    </p>
                    
                    <div class="translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                       <form action="{{route('restaurant.detail',$restairant->id)}}">
                         <button type="submit" class="w-full bg-white text-black py-4 rounded-xl font-bold text-[11px] uppercase tracking-tighter hover:bg-orange-500 hover:text-white transition-colors">
                            Voir les détails du restaurant
                        </button>
                       </form>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ duration: 800, once: true, easing: 'ease-out' });
        });
    </script>
</body>
</html>