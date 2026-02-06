<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400;700;800&display=swap" rel="stylesheet">
    
    <x-slot name="header">
        <div class="flex justify-between items-center px-4">
            <h2 class="font-extrabold text-2xl text-white leading-tight tracking-tighter">
                FOOD<span class="text-orange-500">HUB.</span> <span class="text-slate-500 font-light text-lg">| Studio</span>
            </h2>
            <div class="flex items-center gap-4">
                <button type="button" onclick="document.getElementById('main-form').submit()" class="bg-orange-500 text-white px-6 py-2 rounded-xl font-bold text-xs uppercase hover:bg-white hover:text-orange-500 transition-all shadow-lg">
                    Publier maintenant
                </button>
            </div>
        </div>
    </x-slot>

    <style>
        #create-restaurant-page {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0b1120 !important;
        }
        .glass-panel { 
            background: rgba(30, 41, 59, 0.4) !important; 
            backdrop-filter: blur(12px); 
            border: 1px solid rgba(255, 255, 255, 0.05); 
        }
        .input-field { 
            background: rgba(255, 255, 255, 0.03) !important; 
            border: 1px solid rgba(255, 255, 255, 0.1) !important; 
            color: white !important; 
        }
        .input-field:focus { 
            border-color: #f97316 !important; 
            outline: none;
            ring: 2px #f97316;
        }
        .gradient-primary { 
            background: linear-gradient(135deg, #ff6b6b 0%, #f0932b 100%); 
        }
        /* Style pour l'aperçu des images */
        .preview-image {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .preview-image:hover {
            transform: scale(1.05);
            z-index: 10;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <div id="create-restaurant-page" class="py-12 min-h-screen text-slate-200">
        <form id="main-form" method="POST" action="{{ route('res.store') }}"  enctype="multipart/form-data" class="max-w-5xl mx-auto px-6 space-y-10">
            @csrf
            <section class="glass-panel p-8 rounded-[2.5rem] shadow-2xl" data-aos="fade-up">
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-2 bg-orange-500/20 rounded-lg text-orange-500 font-bold">01</div>
                    <h3 class="text-xl font-bold uppercase tracking-wider text-white">Informations Principales</h3>
                </div>
                @if(session('error'))
    <div class="bg-red-500 text-white px-4 py-3 rounded-lg mb-6">
        {{ session('error') }}
    </div>
@endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase ml-1">Nom du Restaurant</label>
                        <input type="text" name="name" required class="w-full input-field rounded-2xl px-5 py-4" placeholder="Ex: L'Épicurien">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase ml-1">Localisation</label>
                        <input type="text" name="location" required class="w-full input-field rounded-2xl px-5 py-4" placeholder="Ex: Paris, 08ème">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase ml-1">Type de Cuisine</label>
                        <input type="text" name="type" required class="w-full input-field rounded-2xl px-5 py-4" placeholder="Ex: Gastronomique">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase ml-1">Capacité</label>
                        <input type="number" name="capacity" required class="w-full input-field rounded-2xl px-5 py-4" placeholder="Nombre de couverts">
                    </div>
                </div>
            </section>

            <section class="glass-panel p-8 rounded-[2.5rem] shadow-2xl" data-aos="fade-up">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-orange-500/20 rounded-lg text-orange-500 font-bold">02</div>
                        <h3 class="text-xl font-bold uppercase tracking-wider text-white">Galerie Photos</h3>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4" id="gallery-grid">
                    <label for="photo-upload" class="group relative flex flex-col items-center justify-center h-48 border-2 border-dashed border-white/10 rounded-[2rem] hover:border-orange-500/50 hover:bg-orange-500/5 transition-all cursor-pointer">
                        <div class="p-4 rounded-full bg-white/5 group-hover:bg-orange-500/20 group-hover:scale-110 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="mt-3 text-[10px] font-bold uppercase tracking-widest text-slate-500 group-hover:text-orange-500">Ajouter des visuels</span>
                        <input type="file" id="photo-upload" name="images[]" multiple class="hidden" onchange="previewImages(event)">
                    </label>

                    <div id="image-preview-container" class="md:col-span-3 grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="flex items-center justify-center h-48 border border-white/5 rounded-[2rem] text-slate-700 italic text-xs">
                            Aperçu des images...
                        </div>
                    </div>
                </div>
            </section>

            <div id="menus-wrapper" class="space-y-8">
                <div class="flex items-center justify-between px-4">
                    <h3 class="text-xl font-bold uppercase tracking-wider text-white font-bold">Menus & Plats</h3>
                    <button type="button" onclick="addMenu()" class="bg-orange-500/10 border border-orange-500/50 text-orange-500 px-6 py-2 rounded-xl text-xs font-bold hover:bg-orange-500 hover:text-white transition-all">
                        + CRÉER UN MENU
                    </button>
                </div>
            </div>

            <div class="pt-12 text-center">
                <button type="submit" class="gradient-primary text-white px-20 py-6 rounded-[2.5rem] font-black text-xl uppercase tracking-[0.2em] shadow-2xl hover:scale-105 transition-all">
                    Publier le Restaurant 🚀
                </button>
            </div>
        </form>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        let menuIdx = 0;
        AOS.init();

      let selectedFiles = [];

function previewImages(event) {

    const container = document.getElementById('image-preview-container');
    const files = Array.from(event.target.files);

    
    selectedFiles = selectedFiles.concat(files);

    
    const dataTransfer = new DataTransfer();

    selectedFiles.forEach(file => dataTransfer.items.add(file));

    document.getElementById('photo-upload').files = dataTransfer.files;

    container.innerHTML = '';

    selectedFiles.forEach((file, index) => {

        const reader = new FileReader();

        reader.onload = (e) => {
            container.insertAdjacentHTML('beforeend', `
                <div class="preview-image relative h-48 rounded-[2rem] overflow-hidden">
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                </div>
            `);
        };

        reader.readAsDataURL(file);
    });
}


        function addMenu() {
            menuIdx++;
            const wrapper = document.getElementById('menus-wrapper');
            const menuDiv = document.createElement('div');
            menuDiv.id = `menu-container-${menuIdx}`;
            menuDiv.className = "glass-panel p-8 rounded-[2.5rem] animate__animated animate__fadeInUp relative";
            
            menuDiv.innerHTML = `
                <button type="button" onclick="this.parentElement.remove()" class="absolute top-6 right-6 text-red-500 opacity-30 hover:opacity-100">✕</button>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <input type="text" name="menus[${menuIdx}][name]" class="input-field rounded-xl px-4 py-3 font-bold" placeholder="Nom du Menu">
                    <input type="text" name="menus[${menuIdx}][desc]" class="input-field rounded-xl px-4 py-3 text-sm" placeholder="Description du menu">
                </div>
                <div id="plats-list-${menuIdx}" class="space-y-3"></div>
                <button type="button" onclick="addPlat(${menuIdx})" class="mt-6 text-orange-500 text-xs font-bold uppercase hover:underline">+ Ajouter un plat</button>
            `;
            wrapper.appendChild(menuDiv);
            addPlat(menuIdx);
        }

        function addPlat(mId) {
            const list = document.getElementById(`plats-list-${mId}`);
            const pId = Date.now();
            const platDiv = document.createElement('div');
            platDiv.className = "grid grid-cols-12 gap-3 items-center bg-white/5 p-3 rounded-2xl animate__animated animate__fadeIn";
            platDiv.innerHTML = `
                <div class="col-span-4"><input type="text" name="menus[${mId}][plats][${pId}][n]" class="bg-transparent border-none text-white text-sm w-full focus:ring-0" placeholder="Nom du plat"></div>
                <div class="col-span-5"><input type="text" name="menus[${mId}][plats][${pId}][d]" class="bg-transparent border-none text-slate-500 text-xs w-full focus:ring-0" placeholder="Description"></div>
                <div class="col-span-2"><input type="number" name="menus[${mId}][plats][${pId}][p]" class="bg-transparent border-none text-orange-500 text-sm font-bold w-full focus:ring-0 text-right" placeholder="0.00"></div>
                <div class="col-span-1 text-right"><button type="button" onclick="this.parentElement.parentElement.remove()" class="text-slate-700 hover:text-red-500 font-bold">✕</button></div>
            `;
            list.appendChild(platDiv);
        }

        window.onload = addMenu;
    </script>
</x-app-layout>