<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Up Your Restaurant - Restora</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: { 50:'#e6f5f1',100:'#b3e0d4',200:'#80cbc0',300:'#4db5a8',400:'#1a9f8e',500:'#024938',600:'#023d30',700:'#013028',800:'#01241f',900:'#001816' },
                        gold: { 50:'#fff5e0',100:'#ffe6b3',200:'#ffd680',300:'#ffc64d',400:'#ffb71a',500:'#f9ac00',600:'#d49700',700:'#b07c00',800:'#8c6100',900:'#684600' }
                    },
                    fontFamily: { sans: ['Nunito', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Nunito', sans-serif; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(12px) } to { opacity: 1; transform: translateY(0) } }
        .step-content { animation: fadeIn 0.4s ease-out; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(20px) } to { opacity: 1; transform: translateX(0) } }
        .slide-in { animation: slideIn 0.3s ease-out; }
        .step-indicator { transition: all 0.3s ease; }
        .step-indicator.active { transform: scale(1.15); }
        .step-line { transition: all 0.4s ease; }
        input:focus, select:focus, textarea:focus { box-shadow: 0 0 0 3px rgba(2, 73, 56, 0.1); }
        .type-card { transition: all 0.25s cubic-bezier(0.4,0,0.2,1); }
        .type-card:hover { transform: translateY(-3px); }
        .type-card.selected { border-color: #024938; background: #e6f5f1; box-shadow: 0 8px 25px -5px rgba(2,73,56,0.2); }
        .type-card.selected .type-icon { background: #024938; color: white; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-50 via-gray-50 to-gold-50/30 flex items-center justify-center p-4">

<div class="w-full max-w-2xl">
    {{-- Logo --}}
    <div class="text-center mb-6">
        <img src="{{ asset('logo.png') }}?v=2" alt="Restora" class="w-14 h-14 mx-auto object-contain">
        <h1 class="text-xl font-bold text-gray-800 mt-2">Welcome to Restora, {{ auth()->user()->name }}!</h1>
        <p class="text-sm text-gray-500 mt-0.5">Let's set up your restaurant in 3 quick steps</p>
    </div>

    {{-- Progress Bar --}}
    <div class="flex items-center justify-center mb-8 px-4">
        <div class="flex items-center w-full max-w-md">
            <div class="flex flex-col items-center">
                <div id="indicator-1" class="step-indicator active w-9 h-9 rounded-full bg-emerald-600 text-white flex items-center justify-center text-sm font-bold">1</div>
                <span class="text-[10px] font-medium text-gray-500 mt-1.5">Restaurant</span>
            </div>
            <div id="line-1" class="step-line flex-1 h-0.5 bg-gray-200 mx-2 mb-5 rounded-full"></div>
            <div class="flex flex-col items-center">
                <div id="indicator-2" class="step-indicator w-9 h-9 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center text-sm font-bold">2</div>
                <span class="text-[10px] font-medium text-gray-400 mt-1.5">Contact</span>
            </div>
            <div id="line-2" class="step-line flex-1 h-0.5 bg-gray-200 mx-2 mb-5 rounded-full"></div>
            <div class="flex flex-col items-center">
                <div id="indicator-3" class="step-indicator w-9 h-9 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center text-sm font-bold">3</div>
                <span class="text-[10px] font-medium text-gray-400 mt-1.5">Financial</span>
            </div>
        </div>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">

        {{-- Step 1: Restaurant Info --}}
        <div id="step-1" class="step-content p-6 sm:p-8">
            <div class="mb-5">
                <h2 class="text-lg font-bold text-gray-800">Restaurant Information</h2>
                <p class="text-sm text-gray-500 mt-0.5">Tell us about your restaurant</p>
            </div>

            <div class="space-y-5">
                {{-- Restaurant Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Restaurant Name <span class="text-red-500">*</span></label>
                    <input type="text" id="fld_name" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm transition-all" placeholder="e.g. The Grand Restaurant">
                </div>

                {{-- Type Selection --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Restaurant Type <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="type-card cursor-pointer border-2 border-gray-200 rounded-xl p-3 text-center" data-type="restaurant" onclick="selectType(this)">
                            <div class="type-icon w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center mx-auto mb-1.5 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700">Restaurant</span>
                        </div>
                        <div class="type-card cursor-pointer border-2 border-gray-200 rounded-xl p-3 text-center" data-type="cafe" onclick="selectType(this)">
                            <div class="type-icon w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center mx-auto mb-1.5 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8h18M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8M9 12h6"/></svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700">Cafe</span>
                        </div>
                        <div class="type-card cursor-pointer border-2 border-gray-200 rounded-xl p-3 text-center" data-type="bar" onclick="selectType(this)">
                            <div class="type-icon w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center mx-auto mb-1.5 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700">Bar</span>
                        </div>
                        <div class="type-card cursor-pointer border-2 border-gray-200 rounded-xl p-3 text-center" data-type="fast_food" onclick="selectType(this)">
                            <div class="type-icon w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center mx-auto mb-1.5 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3zM9 9h6v6H9z"/></svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700">Fast Food</span>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Description <span class="text-gray-400 font-normal">(optional)</span></label>
                    <textarea id="fld_description" rows="3" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm transition-all resize-none" placeholder="A short description of your restaurant..."></textarea>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button onclick="nextStep(1)" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-700 hover:to-emerald-900 rounded-lg shadow-md transition-all inline-flex items-center gap-2">
                    Continue
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

        {{-- Step 2: Contact Info --}}
        <div id="step-2" class="step-content p-6 sm:p-8 hidden">
            <div class="mb-5">
                <h2 class="text-lg font-bold text-gray-800">Contact & Location</h2>
                <p class="text-sm text-gray-500 mt-0.5">How customers can reach you</p>
            </div>

            <div class="space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Phone <span class="text-red-500">*</span></label>
                        <input type="text" id="fld_phone" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm transition-all" placeholder="0712 345 678">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="email" id="fld_email" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm transition-all" placeholder="info@restaurant.com">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Address <span class="text-red-500">*</span></label>
                    <input type="text" id="fld_address" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm transition-all" placeholder="123 Main Street, Dar es Salaam">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Location / City <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="text" id="fld_location" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm transition-all" placeholder="Dar es Salaam">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">TIN Number <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="text" id="fld_tin" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm transition-all" placeholder="123-456-789">
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <button onclick="prevStep(2)" class="px-5 py-2.5 text-sm font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back
                </button>
                <button onclick="nextStep(2)" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-700 hover:to-emerald-900 rounded-lg shadow-md transition-all inline-flex items-center gap-2">
                    Continue
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

        {{-- Step 3: Financial --}}
        <div id="step-3" class="step-content p-6 sm:p-8 hidden">
            <div class="mb-5">
                <h2 class="text-lg font-bold text-gray-800">Financial Settings</h2>
                <p class="text-sm text-gray-500 mt-0.5">Configure tax and service charges</p>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Currency</label>
                    <input type="text" id="fld_currency" value="TZS" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm transition-all">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tax Rate (%)</label>
                        <input type="number" id="fld_tax" value="10" step="0.01" min="0" max="100" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm transition-all">
                        <p class="text-[10px] text-gray-400 mt-1">Applied to every order subtotal</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Service Charge (%)</label>
                        <input type="number" id="fld_service" value="0" step="0.01" min="0" max="100" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm transition-all">
                        <p class="text-[10px] text-gray-400 mt-1">Optional service fee</p>
                    </div>
                </div>

                {{-- Payment Methods --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Accepted Payment Methods</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="flex items-center gap-2 p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-emerald-300 transition-colors">
                            <input type="checkbox" id="pm_cash" checked class="rounded text-emerald-600">
                            <span class="text-xs font-medium text-gray-700">Cash</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-emerald-300 transition-colors">
                            <input type="checkbox" id="pm_mobile" class="rounded text-emerald-600">
                            <span class="text-xs font-medium text-gray-700">Mobile Money</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-emerald-300 transition-colors">
                            <input type="checkbox" id="pm_card" class="rounded text-emerald-600">
                            <span class="text-xs font-medium text-gray-700">Card</span>
                        </label>
                    </div>
                </div>

                {{-- Summary Preview --}}
                <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-100">
                    <p class="text-xs font-semibold text-emerald-700 mb-2">Setup Summary</p>
                    <div class="space-y-1 text-xs text-emerald-600">
                        <p>Restaurant: <span id="sum_name" class="font-medium">—</span></p>
                        <p>Type: <span id="sum_type" class="font-medium">—</span></p>
                        <p>Location: <span id="sum_location" class="font-medium">—</span></p>
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <button onclick="prevStep(3)" class="px-5 py-2.5 text-sm font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back
                </button>
                <button onclick="submitForm()" id="submitBtn" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-700 hover:to-emerald-900 rounded-lg shadow-md transition-all inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Complete Setup
                </button>
            </div>
        </div>
    </div>

    <p class="mt-6 text-center text-xs text-gray-400">Restora OS &middot; Smart Restaurant Operating System</p>
</div>

<script>
let currentStep = 1;
let selectedType = '';

function selectType(el) {
    document.querySelectorAll('.type-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    selectedType = el.dataset.type;
}

function updateIndicator(step) {
    for (let i = 1; i <= 3; i++) {
        const ind = document.getElementById('indicator-' + i);
        const line = document.getElementById('line-' + i);
        if (i < step) {
            ind.className = 'step-indicator w-9 h-9 rounded-full bg-emerald-600 text-white flex items-center justify-center text-sm font-bold';
            ind.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>';
            if (line) line.className = 'step-line flex-1 h-0.5 bg-emerald-600 mx-2 mb-5 rounded-full';
        } else if (i === step) {
            ind.className = 'step-indicator active w-9 h-9 rounded-full bg-emerald-600 text-white flex items-center justify-center text-sm font-bold';
            ind.textContent = i;
            if (line) line.className = 'step-line flex-1 h-0.5 bg-gray-200 mx-2 mb-5 rounded-full';
        } else {
            ind.className = 'step-indicator w-9 h-9 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center text-sm font-bold';
            ind.textContent = i;
            if (line) line.className = 'step-line flex-1 h-0.5 bg-gray-200 mx-2 mb-5 rounded-full';
        }
    }
}

function showStep(step) {
    for (let i = 1; i <= 3; i++) {
        document.getElementById('step-' + i).classList.add('hidden');
    }
    const el = document.getElementById('step-' + step);
    el.classList.remove('hidden');
    el.classList.remove('step-content');
    void el.offsetWidth;
    el.classList.add('step-content');
    updateIndicator(step);
}

function nextStep(step) {
    if (step === 1) {
        const name = document.getElementById('fld_name').value.trim();
        if (!name) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please enter your restaurant name', confirmButtonColor: '#024938' });
            return;
        }
        if (!selectedType) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please select your restaurant type', confirmButtonColor: '#024938' });
            return;
        }
        document.getElementById('sum_name').textContent = name;
        document.getElementById('sum_type').textContent = selectedType.replace('_', ' ');
    }
    if (step === 2) {
        const phone = document.getElementById('fld_phone').value.trim();
        const address = document.getElementById('fld_address').value.trim();
        if (!phone) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please enter a phone number', confirmButtonColor: '#024938' });
            return;
        }
        if (!address) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please enter your restaurant address', confirmButtonColor: '#024938' });
            return;
        }
        document.getElementById('sum_location').textContent = document.getElementById('fld_location').value.trim() || address;
    }
    currentStep = step + 1;
    showStep(currentStep);
}

function prevStep(step) {
    currentStep = step - 1;
    showStep(currentStep);
}

async function submitForm() {
    const phone = document.getElementById('fld_phone').value.trim();
    const address = document.getElementById('fld_address').value.trim();
    const name = document.getElementById('fld_name').value.trim();

    if (!name || !selectedType || !phone || !address) {
        Swal.fire({ icon: 'error', title: 'Missing Info', text: 'Please fill in all required fields', confirmButtonColor: '#024938' });
        return;
    }

    const paymentMethods = [];
    if (document.getElementById('pm_cash').checked) paymentMethods.push('cash');
    if (document.getElementById('pm_mobile').checked) paymentMethods.push('mobile_money');
    if (document.getElementById('pm_card').checked) paymentMethods.push('card');

    const data = {
        name: name,
        type: selectedType,
        description: document.getElementById('fld_description').value.trim(),
        phone: phone,
        email: document.getElementById('fld_email').value.trim(),
        address: address,
        location: document.getElementById('fld_location').value.trim(),
        currency: document.getElementById('fld_currency').value.trim(),
        tax_rate: parseFloat(document.getElementById('fld_tax').value) || 0,
        service_charge: parseFloat(document.getElementById('fld_service').value) || 0,
        tin_number: document.getElementById('fld_tin').value.trim(),
        payment_methods: paymentMethods,
    };

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Setting up...';

    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
        const response = await fetch('{{ route("onboarding.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();

        if (result.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Restaurant Created!',
                text: 'Your restaurant has been set up successfully. Welcome to Restora!',
                confirmButtonColor: '#024938',
                confirmButtonText: 'Go to Dashboard',
                timer: 3000,
                timerProgressBar: true,
            });
            window.location.href = result.redirect;
        } else {
            throw new Error('Something went wrong');
        }
    } catch (error) {
        btn.disabled = false;
        btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Complete Setup';
        Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please try again.', confirmButtonColor: '#024938' });
    }
}
</script>

</body>
</html>
