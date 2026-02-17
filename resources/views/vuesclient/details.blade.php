<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Restaurant - {{$restaurants->nom}}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0f172a; color: #f8fafc; font-family: sans-serif; }
        .section-divider { border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 2rem; margin-bottom: 2rem; }
        .comment-input { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); }
        .comment-input:focus { border-color: #f97316; outline: none; }
    </style>
</head>
<body class="p-8 md:p-16">

    <div class="max-w-4xl mx-auto">
        
        <section class="section-divider">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <h1 class="text-4xl font-bold text-orange-500">{{$restaurants->nom}}</h1>
                
                <a href="{{ route('restaurant.show', $restaurants->id) }}" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-xl transition shadow-lg text-center uppercase tracking-wider text-sm">
                    Réservation
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-lg">
                <p><span class="text-slate-500 font-semibold">📍 Emplacement :</span> {{$restaurants->location}}</p>
                <p><span class="text-slate-500 font-semibold">🍽️ Cuisine :</span> {{$restaurants->type_de_cuisin}}</p>
                <p><span class="text-slate-500 font-semibold">👥 Capacité :</span> {{$restaurants->capacity}} Personnes</p>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mt-8">
                @foreach($restaurants->photos as $photos)
                    <img src="{{asset('storage/'.$photos->path)}}" class="rounded-xl h-40 w-full object-cover shadow-lg" alt="Photo restaurant">
                @endforeach
            </div>
        </section>

        <section class="section-divider">
            <h2 class="text-2xl font-bold mb-8 uppercase tracking-widest text-slate-400">Menus & Carte</h2>

            @foreach($restaurants->menus as $menu)
                <div class="mb-12 bg-white/5 p-8 rounded-2xl border border-white/10">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-white">{{$menu->nom}}</h3>
                        <p class="text-slate-400 italic text-sm">{{$menu->description}}</p>
                    </div>

                    <div class="space-y-6">
                        @foreach($menu->plats as $plat)
                            <div class="flex justify-between items-start border-b border-white/5 pb-4 last:border-0">
                                <div>
                                    <h4 class="font-bold text-lg text-slate-200">{{$plat->nom}}</h4>
                                    <p class="text-sm text-slate-500">{{$plat->description}}</p>
                                </div>
                                <span class="text-orange-500 font-bold text-xl">{{$plat->prix}}€</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </section>

        <section class="mt-12">
            <h2 class="text-2xl font-bold mb-8 text-slate-400 uppercase tracking-widest">Avis Clients</h2>

            <div class="mb-12 bg-white/5 p-6 rounded-2xl border border-white/10">
                <form action="{{route('restaurants.publier')}}" method="POST">
                    @csrf
                    <input type="hidden" name="restaurant_id" value="{{$restaurants->id}}">
                    <textarea 
                        name="contenu" 
                        rows="3" 
                        class="comment-input w-full rounded-xl p-4 text-sm text-white placeholder-slate-500 mb-4" 
                        placeholder="Partagez votre avis sur ce restaurant..."></textarea>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded-lg transition text-sm uppercase tracking-wider shadow-lg">
                            Publier l'avis
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-4">
             @foreach($commentaires->commentaires as $comm)
                    <div class="p-6 rounded-2xl bg-white/5 border border-white/5 shadow-sm">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-full bg-orange-500/20 flex items-center justify-center text-orange-500 font-bold text-xs">
                             {{ substr($comm->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white">{{$comm->user->name}}</p>
                                <p class="text-[10px] text-slate-500">{{ $comm->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <p class="text-slate-300 text-sm leading-relaxed">
                          {{ $comm->contenu}}
                        </p>
                    </div>
             @endforeach
            </div>
        </section>
    </div>

</body>
</html>