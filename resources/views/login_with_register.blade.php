<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Balingasag</title>
    <link rel="icon" type="image/png" href="/Logo/BTLogo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-950 via-emerald-900 to-emerald-950 text-slate-900 font-['Plus_Jakarta_Sans',sans-serif] flex items-center justify-center p-4 sm:p-8 relative overflow-x-hidden">

    <!-- Ambient Glow Effects -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-teal-400/20 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Login Card -->
    <div class="relative z-10 w-full max-w-md bg-white/95 backdrop-blur-xl border border-white/30 rounded-3xl p-6 sm:p-10 shadow-2xl shadow-emerald-950/50">
        
        <!-- Header Navigation -->
        <div class="flex items-center justify-between mb-8">
            <a href="/" class="flex items-center group" aria-label="BaliTour Home">
                <img src="/Logo/BTLogo.png" alt="BaliTour Logo" class="h-11 w-auto object-contain">
            </a>
            
            <a href="/" class="flex items-center gap-1.5 text-sm font-semibold text-emerald-800 hover:text-emerald-950 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Home
            </a>
        </div>

        <!-- Title & Description -->
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-emerald-950 mb-2 tracking-tight">Login</h1>
            <p class="text-sm text-emerald-800/80 leading-relaxed">Sign in using your account credentials stored in the users table.</p>
        </div>

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Username or Email Input -->
            <div>
                <label for="login" class="block text-xs font-bold uppercase tracking-wider text-emerald-900 mb-1.5">Email or Username</label>
                <div class="relative flex items-center">
                    <svg class="w-5 h-5 absolute left-3.5 text-emerald-600/70 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <input type="text" id="login" name="login" value="{{ old('login') }}" required placeholder="Enter email or username"
                        class="w-full pl-11 pr-4 py-3 bg-emerald-50/50 border border-emerald-200/80 rounded-xl text-emerald-950 placeholder-emerald-800/40 text-sm font-medium focus:bg-white focus:border-emerald-700 focus:ring-4 focus:ring-emerald-700/10 outline-none transition-all">
                </div>
                @error('login')
                    <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Input -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-emerald-900">Password</label>
                    <a href="#" class="text-xs font-semibold text-emerald-700 hover:underline">Forgot password?</a>
                </div>
                <div class="relative flex items-center">
                    <svg class="w-5 h-5 absolute left-3.5 text-emerald-600/70 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <input type="password" id="password" name="password" required placeholder="Enter your password"
                        class="w-full pl-11 pr-10 py-3 bg-emerald-50/50 border border-emerald-200/80 rounded-xl text-emerald-950 placeholder-emerald-800/40 text-sm font-medium focus:bg-white focus:border-emerald-700 focus:ring-4 focus:ring-emerald-700/10 outline-none transition-all">
                    <button type="button" onclick="togglePass()" class="absolute right-3 text-emerald-600/70 hover:text-emerald-900 transition-colors p-1" title="Toggle password visibility">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-3.5 px-6 bg-gradient-to-r from-emerald-900 via-emerald-800 to-emerald-900 hover:from-emerald-800 hover:to-emerald-800 text-white font-bold text-base rounded-xl shadow-lg shadow-emerald-900/30 hover:shadow-xl hover:shadow-emerald-900/40 hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center justify-center gap-2 cursor-pointer">
                <span>Login</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </form>

        <!-- Account Register Prompt -->
        <div class="mt-8 pt-6 border-t border-emerald-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-emerald-800/80">
            <span class="font-medium">Need an account?</span>
            <a href="{{ route('register') }}" class="w-full sm:w-auto text-center px-4 py-2 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/80 text-emerald-950 font-bold rounded-xl transition-all">
                Create Account
            </a>
        </div>

    </div>

    <!-- JavaScript Interactivity -->
    <script>
        function togglePass() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
