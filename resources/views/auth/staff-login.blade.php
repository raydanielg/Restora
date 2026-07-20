<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login - Restora</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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
        .code-input { letter-spacing: 0.8em; text-indent: 0.4em; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-800 via-emerald-900 to-emerald-950 flex items-center justify-center p-4">

<div class="w-full max-w-sm">
    <div class="text-center mb-6">
        <img src="{{ asset('logo.png') }}?v=2" alt="Restora" class="w-16 h-16 mx-auto object-contain">
        <h1 class="text-xl font-extrabold text-white mt-3">Staff Login</h1>
        <p class="text-sm text-emerald-300 mt-1">Enter your 6-digit staff code</p>
    </div>

    <div class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8">
        <form method="POST" action="{{ route('staff.login') }}">
            @csrf
            <div class="mb-5">
                <input type="text" name="staff_code" id="staffCode" maxlength="6" inputmode="numeric" pattern="[0-9]{6}" required autofocus autocomplete="off"
                    class="code-input w-full text-center text-3xl font-extrabold py-4 rounded-xl border-2 @error('staff_code') border-red-300 @else border-gray-200 @enderror focus:border-emerald-500 outline-none transition-all text-gray-900"
                    placeholder="______">
                @error('staff_code')
                <p class="mt-2 text-sm text-red-600 text-center">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full py-3.5 text-sm font-extrabold text-white bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-700 hover:to-emerald-900 rounded-xl shadow-lg transition-all">
                LOGIN
            </button>
        </form>

        <div class="relative my-5">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
            <div class="relative flex justify-center text-xs"><span class="px-3 bg-white text-gray-400">or</span></div>
        </div>

        <a href="{{ route('login') }}" class="block text-center text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">Owner Login with Email</a>
    </div>

    <p class="mt-6 text-center text-xs text-emerald-400/60">&copy; {{ date('Y') }} Restora OS. All rights reserved.</p>
</div>

@if(session('error'))
<script>
    Swal.fire({ icon: 'error', title: 'Login Failed', text: '{{ session('error') }}', confirmButtonColor: '#024938' });
</script>
@endif

<script>
    // Digits only
    document.getElementById('staffCode').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });
</script>

</body>
</html>
