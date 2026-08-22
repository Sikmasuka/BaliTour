@php
  $authSuccess = session('auth_success');
  $successMsg = session('success');
  $hasServerSuccess = !empty($authSuccess) || !empty($successMsg);
  
  $initTitle = is_array($authSuccess) ? ($authSuccess['title'] ?? 'Authentication Successful') : 'Welcome Back!';
  $initMessage = is_array($authSuccess) 
      ? ($authSuccess['message'] ?? 'Redirecting to your dashboard...') 
      : (is_string($authSuccess) ? $authSuccess : ($successMsg ?? 'Redirecting to your dashboard...'));
  $initRole = is_array($authSuccess) ? ($authSuccess['role'] ?? 'Verified Account') : 'Tourist';
  $initName = is_array($authSuccess) ? ($authSuccess['name'] ?? null) : null;
@endphp

<!-- Professional Success & Redirect Modal -->
<div id="authSuccessModal" 
     class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm transition-all duration-300 ease-out {{ $hasServerSuccess ? 'opacity-100 visible pointer-events-auto' : 'opacity-0 invisible pointer-events-none' }}"
     role="dialog" 
     aria-modal="true" 
     aria-labelledby="authSuccessTitle">

  <!-- Modal Card -->
  <div class="relative w-full max-w-[390px] bg-white text-slate-900 rounded-2xl border border-slate-200/90 shadow-2xl p-6 sm:p-7 flex flex-col items-center text-center transition-all duration-300 ease-out transform {{ $hasServerSuccess ? 'scale-100 opacity-100' : 'scale-95 opacity-0' }}" id="authSuccessCard">
    
    <!-- Top Emerald Brand Accent -->
    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-500 rounded-t-2xl"></div>

    <!-- Highlighted Brand Logo Emblem with Verification Badge -->
    <div class="relative my-2 flex items-center justify-center">
      <!-- Ambient Glow Ring -->
      <div class="absolute -inset-1.5 rounded-2xl bg-emerald-500/15 blur-xs pointer-events-none"></div>
      
      <!-- Highlighted Logo Box -->
      <div class="relative p-2.5 rounded-2xl bg-white border border-emerald-200/90 shadow-sm ring-4 ring-emerald-50/90 flex items-center justify-center">
        <img src="/Logo/BTLogo.png" alt="BaliTour Logo" class="h-11 w-11 object-contain drop-shadow-xs" onerror="this.src='/Logo/BaliTourLogo.png'">
        <!-- Micro Verified Checkmark Pill at Corner -->
        <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-emerald-700 text-white flex items-center justify-center ring-2 ring-white shadow-xs">
          <svg class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
      </div>
    </div>

    <!-- User Identity & Role Pill -->
    <div class="mt-3 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 border border-slate-200/70 text-[11px] font-medium" id="authSuccessBadge">
      <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
      <span id="authSuccessRoleText">{{ $initRole }}</span>
      @if ($initName)
        <span class="text-slate-400">•</span>
        <span class="text-slate-900 font-semibold" id="authSuccessUserText">{{ $initName }}</span>
      @else
        <span class="text-slate-400 hidden" id="authSuccessUserDot">•</span>
        <span class="text-slate-900 font-semibold hidden" id="authSuccessUserText"></span>
      @endif
    </div>

    <!-- Title -->
    <h3 id="authSuccessTitle" class="mt-2.5 text-lg font-bold text-slate-900 tracking-tight leading-snug">
      {{ $initTitle }}
    </h3>

    <!-- Message / Subtitle -->
    <p id="authSuccessMessage" class="mt-1 text-xs text-slate-500 font-normal leading-relaxed max-w-[280px]">
      {{ $initMessage }}
    </p>

    <!-- Progress Meter & Countdown Track -->
    <div class="mt-5 w-full space-y-3">
      <!-- Auto Redirect Bar -->
      <div class="w-full bg-slate-100 rounded-full h-1 overflow-hidden border border-slate-200/40">
        <div id="authSuccessProgress" class="bg-emerald-700 h-full rounded-full w-0 transition-all duration-[1800ms] ease-out"></div>
      </div>
    </div>

  </div>
</div>

<style>
  @keyframes checkStroke {
    0% { stroke-dashoffset: 24; stroke-dasharray: 24; }
    100% { stroke-dashoffset: 0; stroke-dasharray: 24; }
  }
  .animate-success-check {
    animation: checkStroke 0.4s ease-out 0.1s both;
  }
</style>

<script>
  (function() {
    let redirectTimeout = null;

    window.showAuthSuccessModal = function(options = {}) {
      const modal = document.getElementById('authSuccessModal');
      const card = document.getElementById('authSuccessCard');
      const titleEl = document.getElementById('authSuccessTitle');
      const msgEl = document.getElementById('authSuccessMessage');
      const roleTextEl = document.getElementById('authSuccessRoleText');
      const userTextEl = document.getElementById('authSuccessUserText');
      const userDotEl = document.getElementById('authSuccessUserDot');
      const progressEl = document.getElementById('authSuccessProgress');
      const actionBtn = document.getElementById('authSuccessActionBtn');

      if (!modal || !card) return;

      const title = options.title || 'Authenticated Successfully';
      const message = options.message || 'Redirecting to your dashboard...';
      const role = (options.user && options.user.role) || options.role || 'Member';
      const name = (options.user && options.user.name) || options.name || '';
      const redirectUrl = options.redirect || '/user/dashboard';

      if (titleEl) titleEl.textContent = title;
      if (msgEl) msgEl.textContent = message;
      if (roleTextEl) roleTextEl.textContent = role;

      if (userTextEl) {
        if (name) {
          userTextEl.textContent = name;
          userTextEl.classList.remove('hidden');
          if (userDotEl) userDotEl.classList.remove('hidden');
        } else {
          userTextEl.classList.add('hidden');
          if (userDotEl) userDotEl.classList.add('hidden');
        }
      }

      // Show Modal
      modal.classList.remove('opacity-0', 'invisible', 'pointer-events-none');
      modal.classList.add('opacity-100', 'visible', 'pointer-events-auto');
      card.classList.remove('scale-95', 'opacity-0');
      card.classList.add('scale-100', 'opacity-100');

      // Animate progress bar
      if (progressEl) {
        progressEl.style.width = '0%';
        requestAnimationFrame(() => {
          setTimeout(() => {
            progressEl.style.width = '100%';
          }, 50);
        });
      }

      function executeRedirect() {
        if (redirectTimeout) clearTimeout(redirectTimeout);
        window.location.href = redirectUrl;
      }

      if (actionBtn) {
        actionBtn.onclick = executeRedirect;
      }

      // Auto redirect after 1.8 seconds
      redirectTimeout = setTimeout(executeRedirect, 1800);
    };

    // Auto-trigger if rendered from server-side flash session
    document.addEventListener('DOMContentLoaded', () => {
      @if ($hasServerSuccess)
        const progressEl = document.getElementById('authSuccessProgress');
        const actionBtn = document.getElementById('authSuccessActionBtn');
        const redirectUrl = '{{ is_array($authSuccess) && isset($authSuccess["role"]) && $authSuccess["role"] === "Administrator" ? "/admin/dashboard" : "/user/dashboard" }}';

        if (progressEl) {
          requestAnimationFrame(() => {
            setTimeout(() => {
              progressEl.style.width = '100%';
            }, 50);
          });
        }

        if (actionBtn) {
          actionBtn.onclick = () => { window.location.href = redirectUrl; };
        }

        setTimeout(() => {
          window.location.href = redirectUrl;
        }, 1800);
      @endif
    });
  })();
</script>
