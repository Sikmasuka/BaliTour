<!-- ==================== MODAL & LANDING PAGE SCRIPTS ==================== -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Modal Elements
    const modal = document.getElementById('accessModal');
    const modalBox = modal ? modal.querySelector('.modal-box') : null;
    const openModalBtns = document.querySelectorAll('.open-modal');
    const closeButton = modal ? modal.querySelector('.modal-close') : null;
    const tabButtons = modal ? modal.querySelectorAll('.tab-button') : [];
    const panels = modal ? modal.querySelectorAll('.tab-panel') : [];
    const switchLinks = modal ? modal.querySelectorAll('.modal-switch') : [];
    const togglePasswordBtns = modal ? modal.querySelectorAll('.toggle-password') : [];

    // Open Modal
    function openModal(defaultTab = 'loginTab') {
      if (!modal) return;
      modal.classList.remove('opacity-0', 'invisible', 'pointer-events-none');
      modal.classList.add('opacity-100', 'visible', 'pointer-events-auto');
      if (modalBox) {
        modalBox.classList.remove('scale-95', 'opacity-0');
        modalBox.classList.add('scale-100', 'opacity-100');
      }
      modal.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      if (defaultTab) {
        activateTab(defaultTab);
      }
    }

    // Close Modal
    function closeModal() {
      if (!modal) return;
      modal.classList.add('opacity-0', 'invisible', 'pointer-events-none');
      modal.classList.remove('opacity-100', 'visible', 'pointer-events-auto');
      if (modalBox) {
        modalBox.classList.add('scale-95', 'opacity-0');
        modalBox.classList.remove('scale-100', 'opacity-100');
      }
      modal.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }

    // Tab Switching (Sign In vs Register)
    function activateTab(targetId) {
      tabButtons.forEach(btn => {
        const isActive = btn.dataset.target === targetId;
        btn.classList.toggle('active', isActive);
        btn.classList.toggle('bg-emerald-800', isActive);
        btn.classList.toggle('text-white', isActive);
        btn.classList.toggle('shadow', isActive);
        btn.classList.toggle('font-bold', isActive);
        btn.classList.toggle('text-slate-700', !isActive);
        btn.classList.toggle('font-semibold', !isActive);
        btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
      });

      if (modalBox) {
        if (targetId === 'registerTab') {
          modalBox.classList.remove('max-w-[440px]', 'max-w-[460px]');
          modalBox.classList.add('max-w-[480px]', 'sm:max-w-[580px]', 'md:max-w-[660px]');
        } else {
          modalBox.classList.remove('max-w-[480px]', 'sm:max-w-[580px]', 'md:max-w-[660px]', 'max-w-[560px]');
          modalBox.classList.add('max-w-[440px]');
        }
      }

      panels.forEach(panel => {
        if (panel.id === targetId) {
          panel.classList.remove('hidden', 'absolute', 'inset-x-0', 'top-0', 'h-0', 'overflow-hidden', 'opacity-0', 'pointer-events-none');
          panel.classList.add('block', 'relative', 'opacity-100');
        } else {
          panel.classList.remove('block', 'relative', 'opacity-100');
          panel.classList.add('hidden', 'absolute', 'inset-x-0', 'top-0', 'h-0', 'overflow-hidden', 'opacity-0', 'pointer-events-none');
        }
      });
    }

    // Event Listeners for Open Modal
    openModalBtns.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const targetTab = btn.textContent.trim().toLowerCase().includes('plan') ? 'registerTab' : 'loginTab';
        openModal(targetTab);
      });
    });

    // Automatically keep modal open if there are server-side validation or credential errors
    @if($errors->any() || session('error'))
      const hasRegErr = {{ ($errors->has('first_name') || $errors->has('last_name') || $errors->has('email') || $errors->has('mobile_number') || $errors->has('city_municipality') || $errors->has('barangay') || ($errors->has('username') && old('first_name') !== null)) ? 'true' : 'false' }};
      openModal(hasRegErr ? 'registerTab' : 'loginTab');
    @endif

    // Close Button
    if (closeButton) {
      closeButton.addEventListener('click', closeModal);
    }

    // Click Outside Modal Box
    if (modal) {
      modal.addEventListener('click', (e) => {
        if (e.target === modal) {
          closeModal();
        }
      });
    }

    // Escape Key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modal && modal.classList.contains('pointer-events-auto')) {
        closeModal();
      }
    });

    // Tab Buttons Click
    tabButtons.forEach(button => {
      button.addEventListener('click', () => activateTab(button.dataset.target));
    });

    // Switch Links ("Create account" / "Sign in instead")
    switchLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        activateTab(link.dataset.switch);
      });
    });

    // Password Visibility Toggle
    togglePasswordBtns.forEach(button => {
      button.addEventListener('click', () => {
        const input = button.previousElementSibling;
        if (input && (input.type === 'password' || input.type === 'text')) {
          const isPassword = input.type === 'password';
          input.type = isPassword ? 'text' : 'password';
          button.innerHTML = isPassword 
            ? `<svg class="eye-icon w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>`
            : `<svg class="eye-icon w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="10" r="3"></circle></svg>`;
        }
      });
    });

    // Register Stepper (Step 1 -> Step 2)
    const registerTab = document.getElementById('registerTab');
    const initialStep = registerTab ? parseInt(registerTab.dataset.initialStep || '1', 10) : 1;
    let currentStep = initialStep;

    function updateStepper(step) {
      currentStep = step;
      for (let i = 1; i <= 2; i++) {
        const content = document.getElementById(`stepContent${i}`);
        if (content) {
          if (i === step) {
            content.classList.remove('hidden');
          } else {
            content.classList.add('hidden');
          }
        }

        const node = modal ? modal.querySelector(`.stepper-node[data-step="${i}"]`) : null;
        if (node) {
          const bubble = node.querySelector('.step-bubble');
          const label = node.querySelector('.step-label');
          if (i < step) {
            bubble.className = 'step-bubble w-6 h-6 rounded-full bg-emerald-800 text-white font-semibold text-[11px] flex items-center justify-center ring-4 ring-slate-50 transition-all shadow-xs';
            bubble.innerHTML = '✓';
            label.className = 'step-label text-[10px] font-medium text-slate-700 mt-0.5';
          } else if (i === step) {
            bubble.className = 'step-bubble w-6 h-6 rounded-full bg-emerald-800 text-white font-semibold text-[11px] flex items-center justify-center ring-4 ring-slate-50 transition-all shadow-xs';
            bubble.innerHTML = i;
            label.className = 'step-label text-[10px] font-medium text-slate-700 mt-0.5';
          } else {
            bubble.className = 'step-bubble w-6 h-6 rounded-full bg-slate-200 text-slate-600 font-semibold text-[11px] flex items-center justify-center ring-4 ring-slate-50 transition-all';
            bubble.innerHTML = i;
            label.className = 'step-label text-[10px] font-medium text-slate-400 mt-0.5';
          }
        }
      }

      const progressBar = document.getElementById('stepperProgressBar');
      if (progressBar) {
        const percentage = ((step - 1) / 1) * 100;
        progressBar.style.width = `${percentage}%`;
      }
    }

    if (registerTab) {
      updateStepper(initialStep);
    }

    if (modal) {
      modal.querySelectorAll('.btn-next-step').forEach(btn => {
        btn.addEventListener('click', () => {
          const currentContent = document.getElementById(`stepContent${currentStep}`);
          if (currentContent) {
            const inputs = currentContent.querySelectorAll('input, select');
            let isValid = true;
            for (const input of inputs) {
              if (!input.checkValidity()) {
                input.reportValidity();
                isValid = false;
                break;
              }
            }
            if (isValid) {
              const nextStep = parseInt(btn.dataset.next, 10);
              updateStepper(nextStep);
            }
          }
        });
      });

      modal.querySelectorAll('.btn-prev-step').forEach(btn => {
        btn.addEventListener('click', () => {
          const prevStep = parseInt(btn.dataset.prev, 10);
          updateStepper(prevStep);
        });
      });

      // Form Submit Loading State & Success Modal Interception
      modal.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', async function(e) {
          e.preventDefault();

          const submitBtn = form.querySelector('.modal-submit-btn');
          const textSpan = submitBtn ? submitBtn.querySelector('.btn-text') : null;
          const spinnerSpan = submitBtn ? submitBtn.querySelector('.btn-spinner') : null;

          function setBtnLoading(isLoading) {
            if (!submitBtn) return;
            if (isLoading) {
              if (textSpan) { textSpan.classList.add('hidden'); textSpan.classList.remove('flex'); }
              if (spinnerSpan) { spinnerSpan.classList.remove('hidden'); spinnerSpan.classList.add('flex'); }
              submitBtn.classList.add('pointer-events-none', 'opacity-80');
            } else {
              if (textSpan) { textSpan.classList.remove('hidden'); textSpan.classList.add('flex'); }
              if (spinnerSpan) { spinnerSpan.classList.add('hidden'); spinnerSpan.classList.remove('flex'); }
              submitBtn.classList.remove('pointer-events-none', 'opacity-80');
            }
          }

          setBtnLoading(true);

          try {
            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
              || form.querySelector('input[name="_token"]')?.value;

            const response = await fetch(form.action, {
              method: 'POST',
              headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
              },
              body: formData
            });

            const result = await response.json().catch(() => null);

            if (response.ok && result && result.success) {
              // Close login/register modal immediately
              closeModal();

              // Show professional Success Modal before redirecting
              if (typeof window.showAuthSuccessModal === 'function') {
                window.showAuthSuccessModal({
                  title: result.title,
                  message: result.message,
                  user: result.user,
                  redirect: result.redirect
                });
              } else {
                window.location.href = result.redirect || '/user/dashboard';
              }
              return;
            }

            // Handle validation or lockout failures without closing the modal
            setBtnLoading(false);

            if (result) {
              if (result.locked) {
                // Re-render or reload to activate live lockout timer state
                form.submit();
                return;
              }
              
              // Show clean "Credentials incorrect." alert
              let errorBox = document.getElementById('modalLoginErrorAlert');
              if (!errorBox) {
                errorBox = document.createElement('div');
                errorBox.id = 'modalLoginErrorAlert';
                errorBox.className = 'p-2.5 text-xs font-medium rounded-xl bg-rose-50 border border-rose-200 flex items-center gap-2 text-rose-700 animate-shake';
                errorBox.innerHTML = `
                  <svg class="w-4 h-4 text-rose-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                  </svg>
                  <span>${result.message || 'Credentials incorrect.'}</span>
                `;
                form.insertBefore(errorBox, form.querySelector('.space-y-0.5') || form.firstChild);
              } else {
                errorBox.classList.remove('hidden', 'animate-shake');
                void errorBox.offsetWidth; // trigger reflow for animation
                errorBox.classList.add('animate-shake');
                const msgSpan = errorBox.querySelector('span');
                if (msgSpan) msgSpan.textContent = result.message || 'Credentials incorrect.';
              }

              // Highlight username and password inputs
              const usernameInput = document.getElementById('modalLoginUsername');
              const passwordInput = document.getElementById('modalPassword');
              if (usernameInput) {
                usernameInput.classList.add('border-rose-300', 'focus:border-rose-500', 'focus:ring-rose-500/20', 'bg-rose-50/10');
              }
              if (passwordInput) {
                passwordInput.classList.add('border-rose-300', 'focus:border-rose-500', 'focus:ring-rose-500/20', 'bg-rose-50/10');
              }
            } else {
              // Fallback to standard submission
              form.submit();
            }
          } catch (err) {
            // Network fallback: native form submission
            form.submit();
          }
        });
      });

      // Live Lockout Countdown Timer
      const timerContainer = document.getElementById('lockoutTimerContainer');
      const countdownText = document.getElementById('lockoutCountdownText');
      const loginSubmitBtn = document.getElementById('loginSubmitBtn');
      const loginSubmitBtnText = document.getElementById('loginSubmitBtnText');
      const modalUsernameInput = document.getElementById('modalLoginUsername');
      const modalPasswordInput = document.getElementById('modalPassword');
      const lockoutAlertBox = document.getElementById('lockoutAlertBox');

      if (timerContainer && countdownText) {
        let totalSeconds = parseInt(timerContainer.dataset.seconds || '0', 10);

        function formatTime(sec) {
          const m = Math.floor(sec / 60);
          const s = sec % 60;
          return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
        }

        countdownText.textContent = formatTime(totalSeconds);

        const timerInterval = setInterval(() => {
          totalSeconds--;
          if (totalSeconds <= 0) {
            clearInterval(timerInterval);
            countdownText.textContent = '00:00';

            if (lockoutAlertBox) {
              lockoutAlertBox.className = 'p-2.5 text-xs rounded-xl bg-emerald-50 border border-emerald-200/90 flex items-center gap-2 text-emerald-800 font-medium transition-all duration-300';
              lockoutAlertBox.innerHTML = `
                <svg class="w-4 h-4 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                  <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span>Lockout ended. You may now sign in.</span>
              `;
            }

            if (loginSubmitBtn) {
              loginSubmitBtn.disabled = false;
              loginSubmitBtn.classList.remove('bg-slate-400', 'cursor-not-allowed', 'opacity-75');
              loginSubmitBtn.classList.add('bg-emerald-800', 'hover:bg-emerald-900', 'cursor-pointer');
              if (loginSubmitBtnText) loginSubmitBtnText.textContent = 'Sign In';
            }

            if (modalUsernameInput) {
              modalUsernameInput.disabled = false;
              modalUsernameInput.classList.remove('opacity-65', 'cursor-not-allowed', 'bg-slate-50');
            }
            if (modalPasswordInput) {
              modalPasswordInput.disabled = false;
              modalPasswordInput.classList.remove('opacity-65', 'cursor-not-allowed', 'bg-slate-50');
            }
          } else {
            countdownText.textContent = formatTime(totalSeconds);
          }
        }, 1000);
      }
    }

    // Modern Sticky Header & Bottom Glow Line on Scroll
    const siteNav = document.getElementById('siteNav');
    const navScrollLine = document.getElementById('navScrollLine');
    const navProgressBar = document.getElementById('navProgressBar');

    if (siteNav) {
      window.addEventListener('scroll', () => {
        const scrollY = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrollPercent = docHeight > 0 ? (scrollY / docHeight) * 100 : 0;

        if (scrollY > 20) {
          siteNav.classList.add('shadow-md', 'border-transparent');
          siteNav.classList.remove('border-[#D4D9CB]/80');
          if (navScrollLine) navScrollLine.classList.remove('opacity-0');
          if (navScrollLine) navScrollLine.classList.add('opacity-100');
          if (navProgressBar) {
            navProgressBar.classList.remove('opacity-0');
            navProgressBar.classList.add('opacity-100');
            navProgressBar.style.width = `${Math.min(scrollPercent, 100)}%`;
          }
        } else {
          siteNav.classList.remove('shadow-md', 'border-transparent');
          siteNav.classList.add('border-[#D4D9CB]/80');
          if (navScrollLine) {
            navScrollLine.classList.remove('opacity-100');
            navScrollLine.classList.add('opacity-0');
          }
          if (navProgressBar) {
            navProgressBar.classList.remove('opacity-100');
            navProgressBar.classList.add('opacity-0');
            navProgressBar.style.width = '0%';
          }
        }
      }, { passive: true });
    }

    // Smooth Modern Scroll Reveal Animations
    const revealElements = document.querySelectorAll('.reveal-on-scroll');
    if ('IntersectionObserver' in window && revealElements.length > 0) {
      const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      }, {
        root: null,
        rootMargin: '0px 0px -40px 0px',
        threshold: 0.08
      });

      revealElements.forEach(el => revealObserver.observe(el));
    } else {
      // Fallback for older browsers
      revealElements.forEach(el => el.classList.add('is-visible'));
    }

    // ==================== HERITAGE PHOTO STACK CONTROLLER ====================
    const heritageCards = Array.from(document.querySelectorAll('.heritage-stack-card'));
    const heritageDeck = document.getElementById('heritageCardDeck');
    const heritageNextBtn = document.getElementById('heritageNextBtn');
    const heritagePrevBtn = document.getElementById('heritagePrevBtn');
    const heritageDots = document.querySelectorAll('.heritage-dot');
    const heritageCurrentIndexBadge = document.getElementById('heritageCurrentIndex');

    if (heritageCards.length > 0 && heritageDeck) {
      let currentStackIndex = 0;
      const totalStackCards = heritageCards.length;

      // Visual offset configurations for realistic 3D stacked deck
      const stackTransforms = [
        // Active (top card)
        { transform: 'translate3d(0px, 0px, 0px) rotate(0deg) scale(1)', zIndex: 30, opacity: 1, filter: 'brightness(1)', shadow: '0 20px 25px -5px rgba(0, 0, 0, 0.25), 0 8px 10px -6px rgba(0, 0, 0, 0.2)' },
        // 2nd card (behind, slight right tilt)
        { transform: 'translate3d(12px, 8px, -20px) rotate(3deg) scale(0.96)', zIndex: 20, opacity: 0.94, filter: 'brightness(0.95)', shadow: '0 10px 15px -3px rgba(0, 0, 0, 0.15)' },
        // 3rd card (behind, slight left tilt)
        { transform: 'translate3d(-12px, 16px, -40px) rotate(-3.5deg) scale(0.92)', zIndex: 15, opacity: 0.82, filter: 'brightness(0.90)', shadow: '0 4px 6px -2px rgba(0, 0, 0, 0.1)' },
        // 4th card (behind)
        { transform: 'translate3d(8px, 22px, -60px) rotate(2deg) scale(0.88)', zIndex: 10, opacity: 0.65, filter: 'brightness(0.85)', shadow: 'none' },
        // 5th card (deepest)
        { transform: 'translate3d(-4px, 26px, -80px) rotate(-1.5deg) scale(0.84)', zIndex: 5, opacity: 0.40, filter: 'brightness(0.80)', shadow: 'none' }
      ];

      function applyStackLayout() {
        heritageCards.forEach((card, i) => {
          const offset = (i - currentStackIndex + totalStackCards) % totalStackCards;
          const config = stackTransforms[offset] || stackTransforms[stackTransforms.length - 1];

          card.style.transform = config.transform;
          card.style.zIndex = config.zIndex;
          card.style.opacity = config.opacity;
          card.style.filter = config.filter;
          card.style.boxShadow = config.shadow;
          card.style.pointerEvents = offset === 0 ? 'auto' : 'none';
        });

        // Update counter badge
        if (heritageCurrentIndexBadge) {
          heritageCurrentIndexBadge.textContent = `${currentStackIndex + 1} / ${totalStackCards}`;
        }

        // Update navigation dots
        heritageDots.forEach((dot, idx) => {
          if (idx === currentStackIndex) {
            dot.classList.remove('w-2', 'bg-[#D4D9CB]', 'hover:bg-[#8F9F8B]');
            dot.classList.add('w-6', 'bg-[#0E4E31]');
          } else {
            dot.classList.remove('w-6', 'bg-[#0E4E31]');
            dot.classList.add('w-2', 'bg-[#D4D9CB]', 'hover:bg-[#8F9F8B]');
          }
        });
      }

      function nextStackCard() {
        const topCard = heritageCards[currentStackIndex];
        if (topCard) {
          topCard.style.transform = 'translate3d(100px, -20px, 40px) rotate(14deg) scale(0.95)';
          topCard.style.opacity = '0';
        }
        currentStackIndex = (currentStackIndex + 1) % totalStackCards;
        setTimeout(() => {
          applyStackLayout();
        }, 150);
      }

      function prevStackCard() {
        currentStackIndex = (currentStackIndex - 1 + totalStackCards) % totalStackCards;
        const topCard = heritageCards[currentStackIndex];
        if (topCard) {
          topCard.style.transform = 'translate3d(-90px, -15px, 30px) rotate(-12deg) scale(0.95)';
          topCard.style.opacity = '0';
        }
        setTimeout(() => {
          applyStackLayout();
        }, 40);
      }

      function goToStackCard(index) {
        currentStackIndex = (index + totalStackCards) % totalStackCards;
        applyStackLayout();
      }

      // Initialize layout on load
      applyStackLayout();

      // Click on the deck directly to shuffle to the next image
      heritageDeck.addEventListener('click', () => {
        nextStackCard();
      });

      if (heritageNextBtn) {
        heritageNextBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          nextStackCard();
        });
      }

      if (heritagePrevBtn) {
        heritagePrevBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          prevStackCard();
        });
      }

      heritageDots.forEach((dot) => {
        dot.addEventListener('click', (e) => {
          e.stopPropagation();
          const targetIdx = parseInt(dot.getAttribute('data-dot'), 10);
          if (!isNaN(targetIdx)) {
            goToStackCard(targetIdx);
          }
        });
      });

      // Keyboard accessibility for card deck
      heritageDeck.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight' || e.key === ' ') {
          e.preventDefault();
          nextStackCard();
        } else if (e.key === 'ArrowLeft') {
          e.preventDefault();
          prevStackCard();
        }
      });

      // Touch Swipe gestures for mobile users
      let touchStartX = 0;
      let touchEndX = 0;
      heritageDeck.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
      }, { passive: true });

      heritageDeck.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        const diff = touchEndX - touchStartX;
        if (Math.abs(diff) > 40) {
          if (diff < 0) {
            nextStackCard();
          } else {
            prevStackCard();
          }
        }
      }, { passive: true });
    }

    // ==================== HORIZONTAL KINETIC DRIFT ENGINE ====================
    const driftContainer = document.getElementById('horizontalDriftContainer');
    const rowElements = Array.from(document.querySelectorAll('.horizontal-drift-row'));

    if (driftContainer && rowElements.length > 0) {
      const isReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

      const rowStates = rowElements.map((rowEl, idx) => {
        const track = rowEl.querySelector('.horizontal-drift-track');
        const direction = rowEl.getAttribute('data-direction') || (idx % 2 === 0 ? 'left' : 'right');
        const baseSpeed = parseFloat(rowEl.getAttribute('data-speed')) || 28;
        
        return {
          rowEl,
          track,
          direction,
          baseSpeed,
          currentVelocity: baseSpeed,
          targetVelocity: baseSpeed,
          offset: idx * 95, // Stagger initial positions
          isHovered: false
        };
      });

      // Set up clean native event listeners on each row for 100% accurate hover without glitching
      rowStates.forEach((state) => {
        state.rowEl.addEventListener('mouseenter', () => {
          state.isHovered = true;
          state.targetVelocity = 0; // Pause drift on hover
        });

        state.rowEl.addEventListener('mouseleave', () => {
          state.isHovered = false;
          state.targetVelocity = state.baseSpeed; // Resume smooth drift
        });

        state.rowEl.addEventListener('touchstart', () => {
          state.isHovered = true;
          state.targetVelocity = 0;
        }, { passive: true });

        state.rowEl.addEventListener('touchend', () => {
          state.isHovered = false;
          state.targetVelocity = state.baseSpeed;
        }, { passive: true });
      });

      let lastTs = null;

      function animateHorizontalDrift(ts) {
        if (lastTs === null) lastTs = ts;
        const dt = Math.min(0.05, Math.max(0, ts - lastTs) / 1000);
        lastTs = ts;

        if (!isReducedMotion) {
          rowStates.forEach((state) => {
            const track = state.track;
            if (!track) return;

            // Calculate single loop width
            const totalWidth = track.scrollWidth;
            const loopWidth = totalWidth / 2;

            if (loopWidth > 0) {
              // Smoothly ease velocity between running and paused
              const easeRate = 1 - Math.exp(-dt / 0.15);
              state.currentVelocity += (state.targetVelocity - state.currentVelocity) * easeRate;

              // Advance offset
              state.offset = (state.offset + state.currentVelocity * dt) % loopWidth;

              if (state.direction === 'left') {
                track.style.transform = `translate3d(${-state.offset}px, 0, 0)`;
              } else {
                track.style.transform = `translate3d(${state.offset - loopWidth}px, 0, 0)`;
              }
            }
          });
        }

        requestAnimationFrame(animateHorizontalDrift);
      }

      // Start horizontal drift loop
      requestAnimationFrame(animateHorizontalDrift);
    }
  });
</script>
