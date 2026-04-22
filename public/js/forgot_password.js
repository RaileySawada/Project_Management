(() => {
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const form = document.getElementById('forgot-form');
  const emailInput = document.getElementById('email');
  if (!form || !emailInput) return;

  const submitButton = form.querySelector('button[type="submit"]');
  const initialLabel = submitButton ? submitButton.textContent : '';

  const scrollToForm = (focusDelay = 280) => {
    form.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
    window.setTimeout(() => emailInput.focus(), reduceMotion ? 0 : focusDelay);
  };

  document.querySelectorAll('a[href="#forgot-form"]').forEach((link) => {
    link.addEventListener('click', (event) => {
      event.preventDefault();
      scrollToForm();
      history.replaceState(null, '', '#forgot-form');
    });
  });

  window.addEventListener('load', () => {
    if (window.location.hash !== '#forgot-form') return;
    scrollToForm(360);
  });

  form.addEventListener('submit', () => {
    emailInput.value = emailInput.value.trim();
    if (!submitButton) return;

    submitButton.disabled = true;
    submitButton.textContent = 'Sending reset link...';
  });

  window.addEventListener('pageshow', () => {
    if (!submitButton) return;
    submitButton.disabled = false;
    submitButton.textContent = initialLabel;
  });
})();
