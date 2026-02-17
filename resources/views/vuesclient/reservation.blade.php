<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver une table | Youco'Done</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .calendar-day.selected { background-color: #f97316; color: white; border-radius: 0.75rem; }
        .calendar-day.today { border: 2px solid #f97316; color: #f97316; font-weight: bold; }
        .calendar-day.disabled { color: #d1d5db; cursor: not-allowed; }
        .calendar-day:not(.disabled):hover { background-color: #ffedd5; border-radius: 0.75rem; cursor: pointer; }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 md:p-8">

<div class="bg-white w-full max-w-5xl rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row border border-gray-100">

    <div class="md:w-1/3 relative bg-orange-600 text-white">
        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5" class="absolute inset-0 w-full h-full object-cover opacity-40">
        <div class="relative z-10 p-8 h-full flex flex-col justify-between bg-gradient-to-t from-orange-900/80 to-transparent">
            <div>
                <span class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-xs uppercase tracking-widest font-bold">Youco'Done Exclusive</span>
                <h1 class="text-4xl font-bold mt-4 uppercase italic">{{$restaurant->nom}}</h1>
                <p class="mt-2 text-orange-100 flex items-center gap-2">
                    <i class="fas fa-map-marker-alt"></i> {{$restaurant->location}} • {{$restaurant->type_de_cuisin}}
                </p>
            </div>
          
        </div>
    </div>

    <div class="md:w-2/3 p-8 lg:p-12 space-y-8">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Finalisez votre réservation</h2>
           
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div class="space-y-4">
                <label class="block text-sm font-bold text-gray-400 uppercase tracking-wider">1. Choisir la date</label>
                <div class="border rounded-2xl p-4 shadow-sm bg-white">
                    <div class="flex justify-between items-center mb-4 px-2">
                        <button id="prevMonth" class="text-gray-600 hover:text-orange-500"><i class="fas fa-chevron-left"></i></button>
                        <h3 id="currentMonthYear" class="font-bold text-gray-800">Février 2024</h3>
                        <button id="nextMonth" class="text-gray-600 hover:text-orange-500"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <div class="grid grid-cols-7 gap-1 text-center text-xs font-bold text-gray-400 mb-2">
                        <span>L</span><span>M</span><span>M</span><span>J</span><span>V</span><span>S</span><span>D</span>
                    </div>
                    <div id="calendarGrid" class="grid grid-cols-7 gap-1 text-sm text-center">
                        </div>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">2. Convives</label>
                    <div class="flex items-center gap-4 bg-gray-50 p-2 rounded-xl border">
                        <button onclick="changeGuests(-1)" class="w-10 h-10 rounded-lg bg-white border shadow-sm hover:text-orange-500 transition-colors">-</button>
                        <span id="guestCount" class="flex-1 text-center font-bold text-xl">2</span>
                        <button onclick="changeGuests(1)" class="w-10 h-10 rounded-lg bg-white border shadow-sm hover:text-orange-500 transition-colors">+</button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">3. Créneaux disponibles</label>
                    <div id="timeSlots" class="grid grid-cols-3 gap-2">
                        <p class="text-xs text-gray-400 italic col-span-3">Sélectionnez une date d'abord...</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t flex flex-col sm:flex-row justify-between items-center gap-6">
          
          <form method="POST" action="{{ route('reservations.store') }}">
    @csrf

    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
    <input type="hidden" name="date" id="formDate">
    <input type="hidden" name="time" id="formTime">
    <input type="hidden" name="guests" id="formGuests">

   <button type="submit" id="confirmBtn" disabled
                    class="w-full sm:w-auto px-10 py-4 rounded-2xl bg-gray-200 text-white font-bold transition-all transform active:scale-95 shadow-lg">
                Confirmer la réservation
            </button>
</form>

            
            
        </div>
        <p class="text-center text-[10px] text-gray-400 uppercase tracking-widest italic">Annulation gratuite jusqu'à 24h avant l'événement</p>
    </div>
</div>
<script>
let selectedDate = null;
let selectedTime = null;
let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();

const calendarGrid = document.getElementById('calendarGrid');
const monthYearLabel = document.getElementById('currentMonthYear');
const timeSlotsContainer = document.getElementById('timeSlots');
const confirmBtn = document.getElementById('confirmBtn');

// hidden inputs
const formDate = document.getElementById('formDate');
const formTime = document.getElementById('formTime');
const formGuests = document.getElementById('formGuests');

// default guests
formGuests.value = 2;

function renderCalendar() {
    calendarGrid.innerHTML = '';
    const firstDay = new Date(currentYear, currentMonth, 1).getDay();
    const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    const today = new Date();

    const monthNames = ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
    monthYearLabel.innerText = `${monthNames[currentMonth]} ${currentYear}`;

    for (let i = 0; i < firstDay; i++) {
        calendarGrid.innerHTML += `<div></div>`;
    }

    for (let day = 1; day <= daysInMonth; day++) {

        const dateStr = `${currentYear}-${(currentMonth+1).toString().padStart(2,'0')}-${day.toString().padStart(2,'0')}`;
        const isPast = new Date(currentYear, currentMonth, day) < new Date().setHours(0,0,0,0);

        const dayDiv = document.createElement('div');
        dayDiv.className = `calendar-day p-2 ${isPast ? 'disabled' : ''}`;
        dayDiv.innerText = day;

        if (!isPast) {
            dayDiv.onclick = () => selectDate(dateStr, dayDiv);
        }

        calendarGrid.appendChild(dayDiv);
    }
}

async function selectDate(date, element) {

    document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('selected'));
    element.classList.add('selected');

    selectedDate = date;
    selectedTime = null;

    formDate.value = date;
    formTime.value = "";

    timeSlotsContainer.innerHTML =
        "<p class='col-span-3 text-center py-2'><i class='fas fa-spinner fa-spin'></i></p>";

    try {
        const response = await fetch(`/restaurant/{{ $restaurant->id }}/slots?date=${date}`);

        if (!response.ok) {
            throw new Error("Erreur serveur");
        }

        const slots = await response.json();

        if (slots.length === 0) {
            timeSlotsContainer.innerHTML =
                "<p class='text-gray-400 italic col-span-3'>Restaurant fermé ce jour</p>";
        } else {
            renderSlots(slots);
        }

    } catch (error) {
        timeSlotsContainer.innerHTML =
            "<p class='text-red-500 col-span-3'>Erreur chargement créneaux</p>";
    }

    updateUI();
}

function renderSlots(slots) {

    timeSlotsContainer.innerHTML = "";

    slots.forEach(slot => {

        const btn = document.createElement('button');
        btn.type = "button";
        btn.className =
            "py-2 px-3 border rounded-xl text-sm font-medium hover:border-orange-500 hover:text-orange-500 transition-all";
        btn.innerText = slot;

        btn.onclick = () => {

            document.querySelectorAll('#timeSlots button')
                .forEach(b => b.className =
                    "py-2 px-3 border rounded-xl text-sm font-medium hover:border-orange-500 hover:text-orange-500 transition-all"
                );

            btn.className =
                "py-2 px-3 border rounded-xl text-sm font-bold bg-orange-500 text-white border-orange-500";

            selectedTime = slot;
            formTime.value = slot;

            updateUI();
        };

        timeSlotsContainer.appendChild(btn);
    });
}

function changeGuests(val) {

    const el = document.getElementById('guestCount');
    let count = parseInt(el.innerText) + val;

    if (count > 0 && count <= 12) {
        el.innerText = count;
        formGuests.value = count;
    }
}

function updateUI() {

    if (selectedDate && selectedTime) {
        confirmBtn.disabled = false;
        confirmBtn.className =
            "w-full sm:w-auto px-10 py-4 rounded-2xl bg-orange-500 text-white font-bold transition-all transform active:scale-95 shadow-orange-200 shadow-xl hover:bg-orange-600";
    } else {
        confirmBtn.disabled = true;
        confirmBtn.className =
            "w-full sm:w-auto px-10 py-4 rounded-2xl bg-gray-200 text-white font-bold";
    }
}

document.getElementById('prevMonth').onclick = () => {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    renderCalendar();
};

document.getElementById('nextMonth').onclick = () => {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    renderCalendar();
};

renderCalendar();
</script>


</body>
</html>