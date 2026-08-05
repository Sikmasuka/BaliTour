<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — BaliTours</title>
    <link rel="icon" type="image/png" href="/Logo/BTLogo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-950 via-emerald-900 to-emerald-950 text-slate-900 font-['Plus_Jakarta_Sans',sans-serif] flex items-center justify-center p-4 sm:p-8 relative overflow-x-hidden">

    <!-- Ambient Glowing Backdrops -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-teal-400/20 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Main Card Container -->
    <div class="relative z-10 w-full max-w-xl bg-white/95 backdrop-blur-xl border border-white/30 rounded-3xl p-6 sm:p-10 shadow-2xl shadow-emerald-950/50">
        
        <!-- Header Navigation -->
        <div class="flex items-center justify-between mb-8">
            <a href="/" class="flex items-center group" aria-label="BaliTour Home">
                <img src="/Logo/BTLogo.png" alt="BaliTour Logo" class="h-11 w-auto object-contain">
            </a>
            
            <a href="/" class="flex items-center gap-1.5 text-sm font-semibold text-emerald-800 hover:text-emerald-950 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Home
            </a>
        </div>

        <!-- Title & Description -->
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-emerald-950 mb-2 tracking-tight">Create your account</h1>
            <p class="text-sm sm:text-base text-emerald-800/80 leading-relaxed">Register a new user account into the application database.</p>
        </div>

        <!-- Registration Form -->
        <form action="{{ route('register') }}" method="POST" id="registerForm" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-xs font-bold uppercase tracking-wider text-emerald-900 mb-1.5">First Name</label>
                    <div class="relative flex items-center">
                        <svg class="w-5 h-5 absolute left-3.5 text-emerald-600/70 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required placeholder="e.g. Maria"
                            class="w-full pl-11 pr-4 py-3 bg-emerald-50/50 border border-emerald-200/80 rounded-xl text-emerald-950 placeholder-emerald-800/40 text-sm font-medium focus:bg-white focus:border-emerald-700 focus:ring-4 focus:ring-emerald-700/10 outline-none transition-all">
                    </div>
                    @error('first_name')
                        <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Middle Name (Optional) -->
                <div>
                    <label for="middle_name" class="block text-xs font-bold uppercase tracking-wider text-emerald-900 mb-1.5">Middle Name <span class="text-emerald-600/70 lowercase font-normal">(optional)</span></label>
                    <div class="relative flex items-center">
                        <svg class="w-5 h-5 absolute left-3.5 text-emerald-600/70 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}" placeholder="e.g. Cruz"
                            class="w-full pl-11 pr-4 py-3 bg-emerald-50/50 border border-emerald-200/80 rounded-xl text-emerald-950 placeholder-emerald-800/40 text-sm font-medium focus:bg-white focus:border-emerald-700 focus:ring-4 focus:ring-emerald-700/10 outline-none transition-all">
                    </div>
                    @error('middle_name')
                        <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="sm:col-span-2">
                    <label for="last_name" class="block text-xs font-bold uppercase tracking-wider text-emerald-900 mb-1.5">Last Name</label>
                    <div class="relative flex items-center">
                        <svg class="w-5 h-5 absolute left-3.5 text-emerald-600/70 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required placeholder="e.g. Santos"
                            class="w-full pl-11 pr-4 py-3 bg-emerald-50/50 border border-emerald-200/80 rounded-xl text-emerald-950 placeholder-emerald-800/40 text-sm font-medium focus:bg-white focus:border-emerald-700 focus:ring-4 focus:ring-emerald-700/10 outline-none transition-all">
                    </div>
                    @error('last_name')
                        <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="sm:col-span-2">
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-emerald-900 mb-1.5">Email Address</label>
                    <div class="relative flex items-center">
                        <svg class="w-5 h-5 absolute left-3.5 text-emerald-600/70 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com"
                            class="w-full pl-11 pr-4 py-3 bg-emerald-50/50 border border-emerald-200/80 rounded-xl text-emerald-950 placeholder-emerald-800/40 text-sm font-medium focus:bg-white focus:border-emerald-700 focus:ring-4 focus:ring-emerald-700/10 outline-none transition-all">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-emerald-900 mb-1.5">Password</label>
                    <div class="relative flex items-center">
                        <svg class="w-5 h-5 absolute left-3.5 text-emerald-600/70 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input type="password" id="password" name="password" required placeholder="••••••••" oninput="updateStrength(this.value)"
                            class="w-full pl-11 pr-10 py-3 bg-emerald-50/50 border border-emerald-200/80 rounded-xl text-emerald-950 placeholder-emerald-800/40 text-sm font-medium focus:bg-white focus:border-emerald-700 focus:ring-4 focus:ring-emerald-700/10 outline-none transition-all">
                        <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 text-emerald-600/70 hover:text-emerald-900 transition-colors p-1" title="Toggle Password">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                    <!-- Password Strength Bar -->
                    <div class="flex gap-1.5 mt-2">
                        <div id="bar1" class="h-1 flex-1 bg-emerald-100 rounded-full transition-colors duration-300"></div>
                        <div id="bar2" class="h-1 flex-1 bg-emerald-100 rounded-full transition-colors duration-300"></div>
                        <div id="bar3" class="h-1 flex-1 bg-emerald-100 rounded-full transition-colors duration-300"></div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-emerald-900 mb-1.5">Confirm Password</label>
                    <div class="relative flex items-center">
                        <svg class="w-5 h-5 absolute left-3.5 text-emerald-600/70 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••"
                            class="w-full pl-11 pr-10 py-3 bg-emerald-50/50 border border-emerald-200/80 rounded-xl text-emerald-950 placeholder-emerald-800/40 text-sm font-medium focus:bg-white focus:border-emerald-700 focus:ring-4 focus:ring-emerald-700/10 outline-none transition-all">
                        <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-3 text-emerald-600/70 hover:text-emerald-900 transition-colors p-1" title="Toggle Password">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Terms Checkbox -->
            <div class="flex items-start gap-3 pt-2">
                <input type="checkbox" id="terms" required class="w-4 h-4 mt-0.5 text-emerald-800 border-emerald-300 rounded focus:ring-emerald-700 accent-emerald-900 cursor-pointer">
                <label for="terms" class="text-xs sm:text-sm text-emerald-800/80 cursor-pointer leading-normal">
                    I agree to the <a href="#" class="font-semibold text-emerald-950 underline hover:text-emerald-700">Terms of Service</a> and <a href="#" class="font-semibold text-emerald-950 underline hover:text-emerald-700">Privacy Policy</a>.
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-3.5 px-6 bg-gradient-to-r from-emerald-900 via-emerald-800 to-emerald-900 hover:from-emerald-800 hover:to-emerald-800 text-white font-bold text-base rounded-xl shadow-lg shadow-emerald-900/30 hover:shadow-xl hover:shadow-emerald-900/40 hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center justify-center gap-2 cursor-pointer">
                <span>Complete Registration</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </form>

        <!-- Footer Link -->
        <div class="mt-8 pt-6 border-t border-emerald-100 text-center text-sm text-emerald-800/80 font-medium">
            Already have an account?
            <a href="{{ route('login') }}" class="font-bold text-emerald-950 hover:underline ml-1">Sign In</a>
        </div>

    </div>

    <!-- Interactivity JavaScript -->
    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            btn.classList.toggle('text-emerald-950', isPassword);
        }

        function updateStrength(val) {
            const b1 = document.getElementById('bar1');
            const b2 = document.getElementById('bar2');
            const b3 = document.getElementById('bar3');

            b1.className = 'h-1 flex-1 rounded-full transition-colors duration-300 bg-emerald-100';
            b2.className = 'h-1 flex-1 rounded-full transition-colors duration-300 bg-emerald-100';
            b3.className = 'h-1 flex-1 rounded-full transition-colors duration-300 bg-emerald-100';

            if (val.length >= 1) b1.classList.replace('bg-emerald-100', 'bg-rose-500');
            if (val.length >= 6) {
                b1.classList.replace('bg-rose-500', 'bg-amber-500');
                b2.classList.replace('bg-emerald-100', 'bg-amber-500');
            }
            if (val.length >= 10 && /[A-Z]/.test(val) && /[0-9]/.test(val)) {
                b1.classList.replace('bg-amber-500', 'bg-emerald-600');
                b2.classList.replace('bg-amber-500', 'bg-emerald-600');
                b3.classList.replace('bg-emerald-100', 'bg-emerald-600');
            }
        }
    </script>
</body>
</html>
