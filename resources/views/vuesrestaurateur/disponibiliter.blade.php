<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disponibilités | Youco'Done Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #0f172a; color: #f8fafc; font-family: 'Inter', sans-serif; }
        .glass-card { background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.05); }
        .input-field { background: #0f172a; border: 1px solid #334155; color: white; padding: 0.6rem; border-radius: 0.75rem; font-size: 0.875rem; outline: none; width: 100%; transition: border-color 0.2s; }
        .input-field:focus { border-color: #f97316; }
        .modal-overlay { background: rgba(0, 0, 0, 0.8); backdrop-filter: blur(4px); }
        .alert-fade { animation: slideIn 0.5s ease-out; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="p-6">

    <div class="max-w-4xl mx-auto space-y-8">
        
        <div class="flex justify-between items-center border-b border-slate-800 pb-6">
            <div>
                <h1 class="text-2xl font-bold italic tracking-tight uppercase">Planning du Restaurant</h1>
                <p class="text-slate-500 text-sm italic">Gérez vos horaires et dates de fermeture</p>
            </div>
        </div>

        <div class="space-y-4">
            @if(session('success'))
                <div class="alert-fade flex items-center gap-3 bg-green-500/10 border border-green-500/50 text-green-400 p-4 rounded-2xl shadow-lg">
                    <i class="fas fa-check-circle"></i>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('success_closure'))
                <div class="alert-fade flex items-center gap-3 bg-blue-500/10 border border-blue-500/50 text-blue-400 p-4 rounded-2xl shadow-lg">
                    <i class="fas fa-calendar-check"></i>
                    <span class="font-bold text-sm">{{ session('success_closure') }}</span>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert-fade bg-red-500/10 border border-red-500/50 text-red-400 p-4 rounded-2xl">
                    <ul class="text-xs font-bold uppercase tracking-tight">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-triangle mr-2"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <section class="glass-card rounded-3xl p-6 md:p-8">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-3">
                    <i class="fas fa-clock text-orange-500 text-xl"></i>
                    <h2 class="text-lg font-black uppercase tracking-widest">Services Actifs</h2>
                </div>
                <button onclick="toggleModal('modal-service')" class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition">
                    + AJOUTER UN JOUR
                </button>
            </div>

            <div class="space-y-3">
                <div class="hidden md:flex text-[10px] font-bold text-slate-500 uppercase px-4 mb-2">
                    <div class="w-40">Jour de la semaine</div>
                    <div class="flex-1 text-center italic">Heure d'ouverture</div>
                    <div class="flex-1 text-center italic">Heure de fermeture</div>
                </div>

                <div id="schedule-list" class="space-y-2 text-sm font-medium">
                    @forelse($hours as $hour)
                        <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-800/30 border border-white/5 hover:bg-slate-800/50 transition-all">
                            <div class="w-40 font-bold text-slate-200">{{ $hour->day }}</div>
                            <div class="flex-1 text-center font-mono text-orange-500 text-base">{{ $hour->opening_time }}</div>
                            <div class="flex-1 text-center font-mono text-orange-500 text-base">{{ $hour->closing_time }}</div>
                            
                            <form action="{{ route('restaurant-hours.delete', $hour->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-700 hover:text-red-400 ml-4 transition-colors">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="text-center py-8 border-2 border-dashed border-slate-800 rounded-2xl">
                            <p class="text-slate-500 italic text-sm">Aucun horaire de service configuré pour le moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="glass-card rounded-3xl p-6 md:p-8">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-3">
                    <i class="fas fa-calendar-times text-red-500 text-xl"></i>
                    <h2 class="text-lg font-black uppercase tracking-widest">Fermetures Spécifiques</h2>
                </div>
                <button onclick="toggleModal('modal-date')" class="text-orange-500 text-xs font-bold hover:underline uppercase tracking-tighter">+ AJOUTER UNE DATE</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="closed-list">
                @forelse($closures as $close)
                    <div class="flex items-center justify-between p-4 bg-red-500/5 border border-red-500/20 rounded-2xl group">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-ban text-red-500 text-sm"></i>
                            <div>
                                <p class="font-bold text-sm text-white italic tracking-wide tracking-tighter">{{ $close->reason }}</p>
                                <p class="text-[10px] text-slate-500 uppercase font-mono tracking-tight">{{ $close->date }}</p>
                            </div>
                        </div>
                        <form action="{{ route('closure-exceptions.delete', $close->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-600 hover:text-red-500 transition-colors">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 border-2 border-dashed border-slate-800 rounded-2xl">
                        <p class="text-slate-500 italic text-sm">Aucune date de fermeture exceptionnelle n'a été ajoutée.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <div id="modal-date" class="hidden fixed inset-0 modal-overlay z-50 flex items-center justify-center p-4">
        <div class="bg-slate-900 border border-slate-800 w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl alert-fade">
            <h3 class="text-xl font-black italic mb-6 text-white uppercase tracking-tighter text-red-500">Bloquer une Date</h3>
            <form method="POST" action="{{ route('closure-exceptions.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="restaurant_id" value="{{$id}}">
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2 ml-1 text-left">Date d'exception</label>
                    <input name="date" type="date" class="input-field text-slate-400" required>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2 ml-1 text-left">Raison de fermeture</label>
                    <input name="reason" type="text" placeholder="Ex: Travaux, Privatisation..." class="input-field" required>
                </div>
                <div class="flex gap-3 mt-8">
                    <button type="button" onclick="toggleModal('modal-date')" class="flex-1 bg-slate-800 text-slate-400 py-3 rounded-2xl font-bold text-xs uppercase hover:bg-slate-700 transition">Fermer</button>
                    <button type="submit" class="flex-1 bg-red-600 text-white py-3 rounded-2xl font-bold text-xs uppercase hover:bg-red-700 transition">Bloquer la date</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-service" class="hidden fixed inset-0 modal-overlay z-50 flex items-center justify-center p-4">
        <div class="bg-slate-900 border border-slate-800 w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl alert-fade">
            <h3 class="text-xl font-black italic mb-6 text-white uppercase tracking-tighter">Nouveau Jour de Service</h3>
            <form method="POST" action="{{ route('restaurant-hours.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="restaurant_id" value="{{$id}}">
                <input type="hidden" name="interval_minutes" value="30">
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2 text-left">Choisir le jour</label>
                    <select name="day" class="input-field">
                        <option>Monday</option><option>Tuesday</option><option>Wednesday</option>
                        <option>Thursday</option><option>Friday</option><option>Saturday</option><option>Sunday</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2 text-left">Ouverture</label>
                        <input type="time" name="opening_time" class="input-field" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2 text-left">Fermeture</label>
                        <input type="time" name="closing_time" class="input-field" required>
                    </div>
                </div>
                <div class="flex gap-3 mt-8">
                    <button type="button" onclick="toggleModal('modal-service')" class="flex-1 bg-slate-800 text-slate-400 py-3 rounded-2xl font-bold text-xs uppercase hover:bg-slate-700 transition">Annuler</button>
                    <button type="submit" class="flex-1 bg-orange-500 text-white py-3 rounded-2xl font-bold text-xs uppercase hover:bg-orange-600 transition shadow-lg">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
        }
    </script>
</body>
</html>