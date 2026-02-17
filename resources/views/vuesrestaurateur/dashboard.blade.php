<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodHub - Élite</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        .hero-section {
            background: linear-gradient(to bottom, rgba(15, 23, 42, 0.4), #0f172a), 
                        url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&q=80&w=1974');
            background-size: cover;
            background-position: center;
        }

        .btn-publish {
            background: linear-gradient(135deg, #ff6b6b 0%, #f0932b 100%);
            transition: all 0.3s ease;
        }

        .btn-publish:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        .resto-card:hover .resto-img {
            transform: scale(1.1);
        }
          
        .card-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);
        }
    </style>
</head>
<body class="bg-[#0f172a] text-white">

    <nav class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center relative z-20">
        <h2 class="font-extrabold text-2xl leading-tight tracking-tighter">
            FOOD<span class="text-orange-500">HUB.</span>
        </h2>
        <a href="/create">
            <button class="btn-publish text-white px-6 py-2 rounded-xl font-bold uppercase text-[10px] tracking-widest shadow-lg">
                Publier mon restaurant
            </button>
        </a>
    </nav>

    <div class="min-h-screen">
        <header class="relative h-[60vh] flex items-center justify-center text-center px-6 hero-section">
            <div class="relative z-10" data-aos="zoom-out" data-aos-duration="1200">
                <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-4">
                    Rejoignez l'<span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-red-500">Élite</span>
                </h1>
                <p class="text-lg text-slate-300 max-w-xl mx-auto font-light">
                    Exposez votre savoir-faire et attirez de nouveaux gourmets. 
                </p>
                <p class="text-[30px] text-orange-500 mt-4 font-light italic">Bienvenue {{auth()->user()->name ?? 'Invité'}} !</p>
            </div>
        </header>

        <section class="max-w-7xl mx-auto py-16 px-6">
            <div class="mb-12" data-aos="fade-right">
                <h2 class="text-3xl font-bold text-white tracking-tight">Restaurants à la une</h2>
                <div class="h-1 w-12 bg-orange-500 mt-2"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                
                @foreach($restaurants as $restaurant)
                 @if(!$restaurant->is_delete)
                <div class="resto-card group relative h-[450px] rounded-[2rem] overflow-hidden cursor-pointer shadow-2xl border border-white/5" data-aos="fade-up">
                    
                    <div class="absolute top-6 left-6 z-20">
                        @if($restaurant->status)
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

                    @if(auth()->check() && $restaurant->user_id == auth()->user()->id)
                    <div class="absolute top-6 right-6 z-20 flex gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <a href="{{ route('restaurants.edit', $restaurant->id) }}"
                           class="bg-white/10 backdrop-blur-md hover:bg-orange-500 p-2.5 rounded-xl shadow-lg transition duration-300">
                           <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1-1v2m-7 7l9-9 4 4-9 9H5v-4z"/>
                           </svg>
                        </a>

                        <form action="{{ route('restaurants.destroy', $restaurant->id) }}" method="POST" onsubmit="return confirm('Supprimer ce restaurant ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500/20 backdrop-blur-md hover:bg-red-600 p-2.5 rounded-xl shadow-lg transition duration-300 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M9 7v10m6-10v10M4 7l1 14h14l1-14M10 3h4l1 4H9l1-4z"/>
                                </svg>
                            </button>
                        </form>

                         <form action="{{ route('restaurant.schedule',$restaurant->id)}}" method="GET">
                            @csrf
                            <button type="submit" class="bg-green-500/20 backdrop-blur-md hover:bg-green-600 p-2.5 rounded-xl shadow-lg transition duration-300 text-white">
                              gérer disponibiliter
                            </button>
                        </form>
                    </div>
                    @endif
                    
                    @if($restaurant->photos->first())
                        <img src="{{ asset('storage/'.$restaurant->photos->first()->path) }}" 
                             class="resto-img absolute inset-0 w-full h-full object-cover transition-transform duration-700" alt="Restaurant">
                    @else
                        <div class="absolute inset-0 bg-slate-800 flex items-center justify-center">📷</div>
                    @endif
                   
                    <div class="card-overlay absolute inset-0 flex flex-col justify-end p-8">
                        <span class="bg-orange-500/90 backdrop-blur-sm text-white text-[9px] font-bold px-3 py-1 rounded-lg w-fit mb-3 uppercase tracking-[0.2em] shadow-lg">
                            {{$restaurant->type_de_cuisin}}
                        </span>
                        
                        <h3 class="text-2xl font-black text-white mb-2 tracking-tight group-hover:text-orange-400 transition-colors">
                            {{$restaurant->nom}}
                        </h3>
                        
                        <div class="flex items-center gap-4 text-slate-300 text-xs font-medium">
                            <span class="flex items-center gap-1.5"><span class="text-orange-500">📍</span> {{$restaurant->location}}</span>
                            <span class="flex items-center gap-1.5"><span class="text-orange-500">👥</span> {{$restaurant->capacity}} Places</span>
                        </div>

                        <div class="h-px w-full bg-white/10 my-4 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
                        
                        <p class="text-[11px] text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity duration-500 line-clamp-2 leading-relaxed italic">
                            {{ $restaurant->description ?? 'Découvrez une expérience culinaire d\'exception au cœur de votre ville.' }}
                        </p>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </section>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ duration: 800, once: true, offset: 50 });
        });
    </script>   
</body>
</html>