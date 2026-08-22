/**
 * BaliTour Logout Modal Handler
 * Manages modern glassmorphic confirmation modal, loading states, and keyboard accessibility.
 */
export function initLogoutModal() {
  const modal = document.getElementById('logoutConfirmationModal');
  const card = document.getElementById('logoutModalCard');
  const form = document.getElementById('logoutModalForm');
  const cancelBtn = document.getElementById('logoutCancelBtn');
  const confirmBtn = document.getElementById('logoutConfirmBtn');
  const spinner = document.getElementById('logoutSpinner');
  const btnText = document.getElementById('logoutBtnText');

  window.openLogoutModal = function(e) {
    if (e && typeof e.preventDefault === 'function') {
      e.preventDefault();
    }
    const currentModal = document.getElementById('logoutConfirmationModal');
    const currentCard = document.getElementById('logoutModalCard');
    const currentCancel = document.getElementById('logoutCancelBtn');

    if (!currentModal || !currentCard) {
      // Fallback: submit standard form if modal not in DOM
      const fallbackForm = document.querySelector('.sidebar-logout-form') || document.getElementById('logout-form');
      if (fallbackForm) fallbackForm.submit();
      return;
    }

    currentModal.classList.remove('opacity-0', 'invisible', 'pointer-events-none');
    currentModal.classList.add('opacity-100', 'visible', 'pointer-events-auto');
    currentCard.classList.remove('scale-95', 'opacity-0');
    currentCard.classList.add('scale-100', 'opacity-100');

    if (currentCancel) {
      setTimeout(() => currentCancel.focus(), 50);
    }
  };

  window.closeLogoutModal = function() {
    const currentModal = document.getElementById('logoutConfirmationModal');
    const currentCard = document.getElementById('logoutModalCard');
    if (!currentModal || !currentCard) return;

    currentCard.classList.remove('scale-100', 'opacity-100');
    currentCard.classList.add('scale-95', 'opacity-0');
    currentModal.classList.remove('opacity-100', 'visible', 'pointer-events-auto');
    currentModal.classList.add('opacity-0', 'invisible', 'pointer-events-none');
  };

  // Close on backdrop click
  if (modal) {
    modal.addEventListener('click', function(e) {
      if (e.target === modal) {
        window.closeLogoutModal();
      }
    });
  }

  // Keyboard ESC shortcut
  document.addEventListener('keydown', function(e) {
    const currentModal = document.getElementById('logoutConfirmationModal');
    if (e.key === 'Escape' && currentModal && !currentModal.classList.contains('invisible')) {
      window.closeLogoutModal();
    }
  });

  // Handle smooth async submission with loading feedback
  if (form) {
    form.addEventListener('submit', function() {
      if (confirmBtn) {
        confirmBtn.disabled = true;
        confirmBtn.classList.add('opacity-80', 'cursor-not-allowed');
      }
      if (cancelBtn) {
        cancelBtn.disabled = true;
        cancelBtn.classList.add('opacity-50', 'cursor-not-allowed');
      }
      if (spinner) spinner.classList.remove('hidden');
      if (btnText) btnText.textContent = 'Signing out...';
    });
  }
}

// Auto initialize when DOM is ready
if (typeof document !== 'undefined') {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLogoutModal);
  } else {
    initLogoutModal();
  }
}
