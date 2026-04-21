<?php
$initialToasts = [];

$sessionToastMap = [
  'success' => 'Success',
  'error' => 'Error',
  'info' => 'Information',
  'warning' => 'Warning'
];

foreach ($sessionToastMap as $key => $defaultTitle) {
  $message = trim((string) ($session->getVal($key) ?? ''));
  if ($message === '') continue;

  $initialToasts[] = [
    'type' => $key,
    'title' => $defaultTitle,
    'message' => $message,
  ];

  $session->dropVal($key);
}
?>

<div id="toast-root" class="pointer-events-none fixed inset-x-3 bottom-4 z-[140] flex max-h-[72vh] flex-col gap-2 sm:inset-x-auto sm:right-5 sm:bottom-5 sm:w-[395px]"></div>

<style>
  .app-toast {
    --toast-accent-1: #3b82f6;
    --toast-accent-2: #60a5fa;
    --toast-accent-soft: rgba(59, 130, 246, 0.14);
    --toast-accent-text: #1d4ed8;
    --toast-title: #0b2075;
    --toast-progress: linear-gradient(90deg, #3b82f6, #60a5fa);

    position: relative;
    overflow: hidden;
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.76);
    background: linear-gradient(
      145deg,
      rgba(255, 255, 255, 0.95),
      rgba(246, 250, 255, 0.92)
    );
    backdrop-filter: blur(18px);
    box-shadow:
      0 18px 44px rgba(11, 32, 117, 0.16),
      0 3px 9px rgba(15, 23, 42, 0.08);
    pointer-events: auto;
    opacity: 0;
    transform: translateY(16px) scale(0.986);
    transition:
      transform 0.25s cubic-bezier(0.16, 1, 0.3, 1),
      opacity 0.18s ease;
  }

  .app-toast::before {
    content: "";
    position: absolute;
    right: -24px;
    top: -24px;
    width: 84px;
    height: 84px;
    border-radius: 999px;
    background: radial-gradient(
      circle,
      color-mix(in srgb, var(--toast-accent-1) 28%, transparent),
      transparent 66%
    );
    pointer-events: none;
    z-index: 1;
  }

  .app-toast.is-visible {
    opacity: 1;
    transform: translateY(0) scale(1);
  }

  .app-toast.is-hiding {
    opacity: 0;
    transform: translateY(10px) scale(0.986);
  }

  .app-toast__body {
    position: relative;
    z-index: 3;
    display: flex;
    align-items: flex-start;
    gap: 11px;
    padding: 13px 13px 12px;
  }

  .app-toast__icon {
    display: inline-flex;
    width: 35px;
    height: 35px;
    flex-shrink: 0;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.8);
    background: var(--toast-accent-soft);
    color: var(--toast-accent-text);
    box-shadow: 0 5px 12px rgba(15, 23, 42, 0.08);
    font-size: 13px;
  }

  .app-toast__title {
    margin: 0;
    color: var(--toast-title);
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.02em;
    line-height: 1.2;
  }

  .app-toast__message {
    margin: 4px 0 0;
    color: #475569;
    font-size: 13px;
    line-height: 1.38;
  }

  .app-toast__close {
    margin-left: 4px;
    display: inline-flex;
    width: 28px;
    height: 28px;
    flex-shrink: 0;
    align-items: center;
    justify-content: center;
    border: 0;
    border-radius: 8px;
    background: transparent;
    color: #64748b;
    cursor: pointer;
    transition: background-color 0.16s ease, color 0.16s ease;
  }

  .app-toast__close:hover {
    background: rgba(148, 163, 184, 0.18);
    color: #1e293b;
  }

  .app-toast__progress-track {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 3px;
    background: rgba(148, 163, 184, 0.14);
    z-index: 4;
  }

  .app-toast__progress-bar {
    height: 100%;
    width: 100%;
    transform-origin: left center;
    background: var(--toast-progress);
    animation: toast-progress linear forwards;
  }

  .app-toast--success {
    --toast-accent-1: #10b981;
    --toast-accent-2: #34d399;
    --toast-accent-soft: rgba(16, 185, 129, 0.14);
    --toast-accent-text: #059669;
    --toast-title: #065f46;
    --toast-progress: linear-gradient(90deg, #10b981, #34d399);
  }

  .app-toast--error {
    --toast-accent-1: #ef4444;
    --toast-accent-2: #fb7185;
    --toast-accent-soft: rgba(239, 68, 68, 0.14);
    --toast-accent-text: #dc2626;
    --toast-title: #991b1b;
    --toast-progress: linear-gradient(90deg, #ef4444, #fb7185);
  }

  .app-toast--info {
    --toast-accent-1: #3b82f6;
    --toast-accent-2: #60a5fa;
    --toast-accent-soft: rgba(59, 130, 246, 0.14);
    --toast-accent-text: #1d4ed8;
    --toast-title: #1e3a8a;
    --toast-progress: linear-gradient(90deg, #3b82f6, #60a5fa);
  }

  .app-toast--warning {
    --toast-accent-1: #f59e0b;
    --toast-accent-2: #fbbf24;
    --toast-accent-soft: rgba(245, 158, 11, 0.16);
    --toast-accent-text: #b45309;
    --toast-title: #92400e;
    --toast-progress: linear-gradient(90deg, #f59e0b, #fbbf24);
  }

  @keyframes toast-progress {
    from { transform: scaleX(1); }
    to { transform: scaleX(0); }
  }

  @media (prefers-reduced-motion: reduce) {
    .app-toast,
    .app-toast__progress-bar {
      animation: none !important;
      transition: none !important;
    }
  }
</style>

<script>
(() => {
  const toastRoot = document.getElementById('toast-root');
  if (!toastRoot) return;

  const MAX_TOASTS = 5;

  const iconMap = {
    success: 'fa-check',
    error: 'fa-xmark',
    info: 'fa-circle-info',
    warning: 'fa-triangle-exclamation'
  };

  const titleMap = {
    success: 'Success',
    error: 'Error',
    info: 'Information',
    warning: 'Warning'
  };

  const allowedTypes = ['success', 'error', 'info', 'warning'];

  const normalizeType = (type) => {
    return allowedTypes.includes(type) ? type : 'info';
  };

  const escapeHtml = (value) => {
    const div = document.createElement('div');
    div.textContent = String(value ?? '');
    return div.innerHTML;
  };

  const dismissToast = (toast, removeDelay = 230) => {
    if (!toast || toast.dataset.hiding === '1') return;
    toast.dataset.hiding = '1';
    toast.classList.remove('is-visible');
    toast.classList.add('is-hiding');
    window.setTimeout(() => toast.remove(), removeDelay);
  };

  const enforceToastLimit = () => {
    while (toastRoot.children.length > MAX_TOASTS) {
      const oldest = toastRoot.firstElementChild;
      if (!oldest) return;
      dismissToast(oldest, 120);
    }
  };

  window.showAppToast = ({
    type = 'info',
    title = '',
    message = '',
    duration
  } = {}) => {
    const normalizedType = normalizeType(type);
    const safeMessage = String(message ?? '').trim();
    if (safeMessage === '') return;

    const durationByType = {
      success: 3900,
      info: 4300,
      warning: 5000,
      error: 5400
    };

    const life = Math.max(1500, Number(duration) || durationByType[normalizedType]);
    const safeTitle = String(title ?? '').trim() || titleMap[normalizedType];
    const iconClass = iconMap[normalizedType];

    const toast = document.createElement('div');
    toast.className = `app-toast app-toast--${normalizedType}`;
    toast.innerHTML = `
      <div class="app-toast__body">
        <span class="app-toast__icon">
          <i class="fa-solid ${iconClass}"></i>
        </span>
        <div class="min-w-0 flex-1">
          <p class="app-toast__title">${escapeHtml(safeTitle)}</p>
          <p class="app-toast__message">${escapeHtml(safeMessage)}</p>
        </div>
        <button type="button" class="app-toast__close" aria-label="Dismiss notification">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <div class="app-toast__progress-track">
        <div class="app-toast__progress-bar"></div>
      </div>
    `;

    const progressBar = toast.querySelector('.app-toast__progress-bar');
    if (progressBar) progressBar.style.animationDuration = `${life}ms`;

    const closeBtn = toast.querySelector('.app-toast__close');
    if (closeBtn) closeBtn.addEventListener('click', () => dismissToast(toast));

    toastRoot.appendChild(toast);
    enforceToastLimit();
    window.requestAnimationFrame(() => toast.classList.add('is-visible'));
    window.setTimeout(() => dismissToast(toast), life);

    return toast;
  };

  const initialToasts = <?= json_encode($initialToasts, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
  if (Array.isArray(initialToasts)) {
    initialToasts.forEach((item) => window.showAppToast(item));
  }
})();
</script>
