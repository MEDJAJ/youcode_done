<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Favoris - FoodHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0f172a; color: white; }
        
        .fav-card {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fav-card:hover {
            transform: translateY(-8px);
            background: rgba(30, 41, 59, 0.7);
            border-color: rgba(240, 147, 43, 0.3);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
        }

        .remove-btn {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .fav-card:hover .remove-btn {
            opacity: 1;
        }
    </style>
</head>
<body class="antialiased p-6 md:p-12">

    <div class="max-w-7xl mx-auto">
        <header class="mb-16">
            <h1 class="text-4xl font-extrabold tracking-tight mb-2">Mes <span class="text-orange-500">Favoris</span></h1>
            <p class="text-slate-400">Retrouvez ici vos adresses gastronomiques préférées.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
        @foreach($restaurants as $restaurant)

 @if(!$restaurant->is_delete)
            <div class="fav-card relative rounded-[2rem] overflow-hidden group">
                <button class="remove-btn absolute top-5 right-5 z-20 bg-red-500 text-white p-3 rounded-full shadow-lg hover:scale-110 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3.172 5.172a4.002 4.002 0 015.657 0L10 6.343l1.172-1.171a4.002 4.002 0 115.657 5.657L10 18.343l-8.343-8.343a4.002 4.002 0 010-5.657z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div class="h-56 overflow-hidden">
                    <img src="{{ asset('storage/'.$restaurant->photos->first()->path) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="Resto">
                </div>

                <div class="p-8">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-xl font-bold group-hover:text-orange-400 transition">{{$restaurant->name}}</h2>
                        <span class="text-[10px] font-black bg-orange-500/10 text-orange-500 px-3 py-1 rounded-md uppercase">{{$restaurant->type_de_cuisin}}</span>
                    </div>

                    <div class="space-y-3 text-sm text-slate-400">
                        <div class="flex items-center gap-2">
                            <span></span> {{$restaurant->location}}
                        </div>
                        <div class="flex items-center gap-2">
                            <span></span> Capacité : {{$restaurant->capacity}} places
                        </div>
                    </div>

                    <button class="w-full mt-8 py-4 border border-white/10 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-white hover:text-black transition">
                        Voir la fiche
                    </button>
                </div>
            </div>
            @endif

@endforeach


          

        </div>
    </div>

</body>
</html>