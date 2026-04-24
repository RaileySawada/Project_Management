(() => {
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const desktopQuery = window.matchMedia('(min-width: 1024px)');
  const authPanel = document.getElementById('secure-access');
  const authOverlay = document.getElementById('ndt-auth-overlay');
  const pageHeader = document.getElementById('login-page-header');
  const idInput = document.getElementById('idNumber');
  const closeButtons = document.querySelectorAll('[data-close-auth]');

  const syncHeaderState = () => {
    if (!pageHeader) return;
    pageHeader.setAttribute('data-scrolled', window.scrollY >= 60 ? 'true' : 'false');
  };

  const focusIdInput = (delay = 0) => {
    if (!idInput) return;
    window.setTimeout(() => idInput.focus(), delay);
  };

  const openAuthModal = () => {
    if (!authPanel || !authOverlay) return;

    authPanel.classList.remove('hidden');
    authPanel.classList.add('flex');
    authOverlay.classList.remove('hidden');
    authOverlay.classList.add('block');
    authPanel.setAttribute('aria-hidden', 'false');
    document.body.classList.add('overflow-hidden');
    focusIdInput(reduceMotion ? 0 : 180);
  };

  const closeAuthModal = () => {
    if (!authPanel || !authOverlay) return;

    authPanel.classList.remove('flex');
    authPanel.classList.add('hidden');
    authOverlay.classList.remove('block');
    authOverlay.classList.add('hidden');
    authPanel.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('overflow-hidden');
  };

  const scrollToAuthPanel = () => {
    if (!authPanel) return;

    authPanel.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'center' });
    focusIdInput(reduceMotion ? 0 : 280);
  };

  closeButtons.forEach((button) => {
    button.addEventListener('click', () => closeAuthModal());
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeAuthModal();
  });

  window.addEventListener('scroll', syncHeaderState, { passive: true });

  desktopQuery.addEventListener('change', (event) => {
    if (event.matches) {
      closeAuthModal();
      if (authPanel) {
        authPanel.classList.remove('hidden');
        authPanel.setAttribute('aria-hidden', 'false');
      }
    } else if (authPanel) {
      authPanel.classList.remove('flex');
      authPanel.classList.add('hidden');
      authPanel.setAttribute('aria-hidden', 'true');
    }
  });

  document.querySelectorAll('a[href^="#"]').forEach((link) => {
    const href = link.getAttribute('href') || '';
    if (href.length < 2) return;

    const target = document.querySelector(href);
    if (!target) return;

    link.addEventListener('click', (event) => {
      event.preventDefault();

      if (href === '#secure-access') {
        if (desktopQuery.matches) {
          closeAuthModal();
          scrollToAuthPanel();
        } else {
          openAuthModal();
        }
      } else {
        target.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
        closeAuthModal();
        history.replaceState(null, '', href);
        return;
      }

      if (desktopQuery.matches) {
        history.replaceState(null, '', href);
      }
    });
  });

  closeAuthModal();
  syncHeaderState();
  if (desktopQuery.matches) {
    if (authPanel) authPanel.setAttribute('aria-hidden', 'false');
  } else if (authPanel) {
    authPanel.setAttribute('aria-hidden', 'true');
  }
})();
