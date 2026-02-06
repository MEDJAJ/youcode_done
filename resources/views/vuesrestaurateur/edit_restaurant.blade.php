<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOODHUB - Modifier {{ $restaurant->nom }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f172a;
        }

        .hero-section {
            background: linear-gradient(to bottom, rgba(15, 23, 42, 0.6), #0f172a), 
                        url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&q=80&w=1974');
            background-size: cover;
            background-position: center;
        }

        .btn-update {
            background: linear-gradient(135deg, #ff6b6b 0%, #f0932b 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(240, 147, 43, 0.5);
            filter: brightness(1.1);
        }

        .input-field {
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            border-color: #f0932b;
            background: rgba(30, 41, 59, 0.8);
            outline: none;
            box-shadow: 0 0 0 3px rgba(240, 147, 43, 0.2);
        }

        /* Correctif affichage AOS */
        [data-aos] { opacity: 1 !important; transform: none !important; }
        .aos-init[data-aos] { opacity: 0 !important; }
        .aos-animate[data-aos] { opacity: 1 !important; }
    </style>
</head>
<body class="antialiased">

    <nav class="border-b border-white/5 bg-slate-900/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-white leading-tight tracking-tighter">
                FOOD<span class="text-orange-500">HUB.</span>
            </h2>
            <a href="" class="text-slate-400 hover:text-white transition-colors text-xs font-bold uppercase tracking-widest">
                ← Retour
            </a>
        </div>
    </nav>

    <div class="min-h-screen pb-20">
        <header class="relative h-[45vh] flex items-center justify-center text-center px-6 hero-section">
            <div class="relative z-10" data-aos="zoom-out" data-aos-duration="1000">
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-2">
                    Modifier votre <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-red-500">Établissement</span>
                </h1>
                <p class="text-slate-400 font-light">Mettez à jour les informations de {{ $restaurant->nom }}</p>
            </div>
        </header>

        <main class="max-w-4xl mx-auto -mt-24 relative z-20 px-6">
            <div class="bg-slate-900/80 backdrop-blur-2xl border border-white/10 p-8 md:p-12 rounded-[2.5rem] shadow-2xl">
                
                <form action="{{ route('restaurants.update', $restaurant->id) }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="space-y-10">
                    
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-orange-500 ml-1">Nom du Restaurant</label>
                            <input type="text" name="name" value="{{ $restaurant->nom }}" class="input-field w-full px-6 py-4 rounded-2xl text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-orange-500 ml-1">Localisation</label>
                            <input type="text" name="location" value="{{ $restaurant->location }}" class="input-field w-full px-6 py-4 rounded-2xl text-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-orange-500 ml-1">Type de Cuisine</label>
                            <input type="text" name="type" value="{{ $restaurant->type_de_cuisin }}" class="input-field w-full px-6 py-4 rounded-2xl text-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-orange-500 ml-1">Capacité (Places)</label>
                            <input type="number" name="capacity" value="{{ $restaurant->capacity }}" class="input-field w-full px-6 py-4 rounded-2xl text-sm">
                        </div>
                        <div class="space-y-2">
    <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-orange-500 ml-1">
        Status
    </label>

    <select name="status" class="input-field w-full px-6 py-4 rounded-2xl text-sm">

        <option value="1" {{ $restaurant->status ? 'selected' : '' }}>
            Actif
        </option>

        <option value="0" {{ !$restaurant->status ? 'selected' : '' }}>
            Non actif
        </option>

    </select>
</div>

                    </div>

                    <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-white flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-orange-500 text-white flex items-center justify-center text-xs shadow-lg shadow-orange-500/20">01</span>
                            Photos actuelles
                        </h3>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            @foreach($restaurant->photos as $photo)
                                <div class="group relative aspect-square rounded-2xl overflow-hidden border border-white/5 bg-slate-800">
                                    <img src="{{ asset('storage/'.$photo->path) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-slate-900/80 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <label class="flex flex-col items-center cursor-pointer p-2">
                                            <input type="checkbox" name="delete_images[]" value="{{ $photo->id }}" class="w-5 h-5 rounded border-none bg-red-500 text-red-600 focus:ring-0">
                                            <span class="text-red-500 text-[10px] font-bold uppercase mt-2">Supprimer</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-white flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-orange-500 text-white flex items-center justify-center text-xs shadow-lg shadow-orange-500/20">02</span>
                            Ajouter des visuels
                        </h3>
                        
                        <div class="relative group">
                            <input type="file" name="images[]" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="input-field border-dashed border-2 rounded-[2rem] p-12 text-center group-hover:border-orange-500/50 group-hover:bg-slate-800/50 transition-all">
                                <div class="w-16 h-16 bg-orange-500/10 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </div>
                                <p class="text-slate-300 font-semibold">Cliquez pour ajouter des fichiers</p>
                                <p class="text-slate-500 text-xs mt-2 italic">Format supportés : JPG, PNG (Max 5MB)</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn-update w-full text-white py-6 rounded-2xl font-extrabold uppercase tracking-[0.3em] text-sm shadow-2xl">
                            Mettre à jour maintenant
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ duration: 1000, once: true });
        });
    </script>
</body>
</html>