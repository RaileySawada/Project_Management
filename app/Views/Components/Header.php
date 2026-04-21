<header class="relative z-40 border-b border-slate-200/80 bg-white/95 px-3 py-2.5 shadow-sm backdrop-blur-md sm:px-4">
  <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(59,130,246,0.1),transparent_50%)]"></div>

  <div class="relative flex items-center justify-between gap-3">
    <div class="flex min-w-0 items-center gap-2.5 sm:gap-3">
      <button
        id="open_sidebar"
        type="button"
        class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-slate-300 bg-white text-slate-700 transition-all duration-200 hover:border-blue-300 hover:text-[#0b2075] md:hidden"
        aria-label="Open sidebar menu">
        <i class="fa-solid fa-bars text-sm"></i>
      </button>

      <div class="min-w-0">
        <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-400">Workspace</p>
        <h1 class="truncate text-base font-bold leading-tight text-[#0b2075] sm:text-lg"><?= htmlspecialchars($headerTitle, ENT_QUOTES, 'UTF-8') ?></h1>
      </div>
    </div>

    <div class="flex items-center gap-2 sm:gap-3">
      <?php if ($activeYearValue !== '' || $activeSemesterValue !== ''): ?>
      <div class="hidden items-center gap-2 rounded-xl border border-slate-200 bg-slate-50/90 px-2.5 py-1.5 text-[11px] text-slate-600 lg:flex">
        <?php if ($activeYearValue !== ''): ?>
        <span class="font-semibold text-slate-700"><?= htmlspecialchars($activeYearValue, ENT_QUOTES, 'UTF-8') ?></span>
        <?php endif; ?>
        <?php if ($activeYearValue !== '' && $activeSemesterValue !== ''): ?>
        <span class="text-slate-300">|</span>
        <?php endif; ?>
        <?php if ($activeSemesterValue !== ''): ?>
        <span><?= htmlspecialchars($activeSemesterValue, ENT_QUOTES, 'UTF-8') ?></span>
        <?php endif; ?>
      </div>
      <?php endif; ?>

      <div class="relative">
        <button
          id="profile_menu_toggle"
          type="button"
          aria-expanded="false"
          aria-controls="profile_menu"
          class="relative flex items-center gap-2 rounded-xl border border-slate-200 bg-white/95 px-2 py-1.5 text-left shadow-sm transition-all duration-200 hover:border-blue-300 hover:shadow-md">
          <span class="relative h-8 w-8 overflow-hidden rounded-lg border border-slate-200 bg-slate-100">
            <img
              src="<?= htmlspecialchars($profileImageSrc, ENT_QUOTES, 'UTF-8') ?>"
              alt="Profile"
              data-user-profile-image
              class="h-full w-full object-cover select-none"
              draggable="false"
              onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <span data-user-profile-fallback class="absolute inset-0 hidden items-center justify-center bg-gradient-to-br from-[#0b2075] to-[#1d4ed8] text-xs font-semibold text-white"><?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8') ?></span>
          </span>

          <span class="hidden min-w-0 sm:block">
            <span class="block truncate text-xs font-semibold text-slate-700"><?= htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8') ?></span>
            <span class="block truncate text-[11px] text-slate-500"><?= htmlspecialchars($displayEmail !== '' ? $displayEmail : 'Active user', ENT_QUOTES, 'UTF-8') ?></span>
          </span>

          <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200" id="profile_menu_chevron"></i>
          <?php if ($hasNotificationsBadge): ?>
          <span id="headerProfileNotifDot" class="absolute -right-1 -top-1 inline-flex h-2.5 w-2.5 rounded-full bg-red-500 shadow-[0_0_10px_rgba(239,68,68,0.9)]" title="You have unread notifications"></span>
          <?php endif; ?>
        </button>

        <div
          id="profile_menu"
          class="pointer-events-none absolute right-0 top-full z-50 mt-2 w-64 origin-top-right scale-95 overflow-hidden rounded-2xl border border-slate-300/80 bg-gradient-to-b from-white via-slate-50/95 to-slate-100/90 p-2.5 opacity-0 shadow-[0_24px_48px_rgba(15,23,42,0.2)] backdrop-blur-xl transition-all duration-200">
          <div class="pointer-events-none absolute inset-0">
            <div class="absolute -top-12 right-6 h-28 w-28 rounded-full bg-blue-400/15 blur-2xl"></div>
            <div class="absolute inset-0 bg-[linear-gradient(rgba(148,163,184,0.08)_1px,transparent_1px),linear-gradient(90deg,rgba(148,163,184,0.08)_1px,transparent_1px)] bg-[size:18px_18px] opacity-[0.3]"></div>
          </div>

          <div class="relative mb-2 rounded-xl border border-slate-200/90 bg-white/75 px-3 py-2">
            <p class="truncate text-xs font-semibold text-slate-700"><?= htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8') ?></p>
            <p class="truncate text-[11px] text-slate-500"><?= htmlspecialchars($displayEmail !== '' ? $displayEmail : 'Active user', ENT_QUOTES, 'UTF-8') ?></p>
          </div>

          <a
            href="<?= htmlspecialchars($myAccountUrl, ENT_QUOTES, 'UTF-8') ?>"
            class="group relative flex items-center gap-2 rounded-xl border px-3 py-2.5 text-sm font-medium transition-all duration-200 <?= $accountItemClasses ?>">
            <?php if ($isAccountActive): ?>
              <span class="pointer-events-none absolute left-0 top-1/2 h-7 w-1 -translate-y-1/2 rounded-r-full bg-blue-300 shadow-[0_0_14px_rgba(147,197,253,0.95)]"></span>
            <?php endif; ?>
            <span class="flex h-7 w-7 items-center justify-center rounded-lg border transition-colors duration-200 <?= $accountIconClasses ?>">
              <i class="fa-regular fa-user text-xs"></i>
            </span>
            <span>My Account</span>
            <?php if ($isAccountActive): ?>
              <span class="ml-auto h-2.5 w-2.5 rounded-full bg-blue-300 shadow-[0_0_12px_rgba(147,197,253,0.9)]"></span>
            <?php endif; ?>
          </a>

          <a
            href="<?= htmlspecialchars($notificationsUrl, ENT_QUOTES, 'UTF-8') ?>"
            class="group relative mt-1.5 flex items-center gap-2 rounded-xl border px-3 py-2.5 text-sm font-medium transition-all duration-200">
            <span class="flex h-7 w-7 items-center justify-center rounded-lg border transition-colors duration-200">
              <i class="fa-regular fa-bell text-xs"></i>
            </span>
            <span>Notifications</span>
          </a>

          <div class="relative my-2 border-t border-slate-200/90"></div>

          <a
            href="<?= htmlspecialchars($logoutUrl, ENT_QUOTES, 'UTF-8') ?>"
            class="group relative flex items-center gap-2 rounded-xl border border-rose-200/80 bg-rose-50/80 px-3 py-2.5 text-sm font-semibold text-rose-600 transition-all duration-200 hover:border-rose-300 hover:bg-rose-100/90 hover:text-rose-700">
            <span class="flex h-7 w-7 items-center justify-center rounded-lg border border-rose-200/90 bg-white text-rose-500 transition-colors duration-200 group-hover:border-rose-300 group-hover:text-rose-600">
              <i class="fa-solid fa-right-from-bracket text-xs"></i>
            </span>
            <span>Logout</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</header>

<script>
(() => {
  const hiddenSidebarClass = "-translate-x-[calc(100%+20px)]";
  const sidebar = document.getElementById("sidebar");
  const backdrop = document.getElementById("sidebar_backdrop");
  const openButton = document.getElementById("open_sidebar");
  const closeButton = document.getElementById("close_sidebar");
  const profileMenuToggle = document.getElementById("profile_menu_toggle");
  const profileMenu = document.getElementById("profile_menu");
  const profileMenuChevron = document.getElementById("profile_menu_chevron");

  if (!sidebar || !backdrop || !openButton || !closeButton) return;

  const openSidebar = () => {
    sidebar.classList.remove(hiddenSidebarClass);
    backdrop.classList.remove("opacity-0", "pointer-events-none");
  };

  const closeSidebar = () => {
    sidebar.classList.add(hiddenSidebarClass);
    backdrop.classList.add("opacity-0", "pointer-events-none");
  };

  const openProfileMenu = () => {
    if (!profileMenu || !profileMenuToggle) return;
    profileMenu.classList.remove("opacity-0", "scale-95", "pointer-events-none");
    profileMenu.classList.add("opacity-100", "scale-100", "pointer-events-auto");
    profileMenuToggle.setAttribute("aria-expanded", "true");
    if (profileMenuChevron) profileMenuChevron.classList.add("rotate-180");
  };

  const closeProfileMenu = () => {
    if (!profileMenu || !profileMenuToggle) return;
    profileMenu.classList.remove("opacity-100", "scale-100", "pointer-events-auto");
    profileMenu.classList.add("opacity-0", "scale-95", "pointer-events-none");
    profileMenuToggle.setAttribute("aria-expanded", "false");
    if (profileMenuChevron) profileMenuChevron.classList.remove("rotate-180");
  };

  const toggleProfileMenu = () => {
    if (!profileMenu) return;
    if (profileMenu.classList.contains("opacity-0")) openProfileMenu();
    else closeProfileMenu();
  };

  openButton.addEventListener("click", openSidebar);
  closeButton.addEventListener("click", closeSidebar);
  backdrop.addEventListener("click", closeSidebar);

  sidebar.querySelectorAll("a[href]").forEach((link) => {
    link.addEventListener("click", () => {
      if (window.innerWidth < 768) closeSidebar();
    });
  });

  if (profileMenuToggle && profileMenu) {
    profileMenuToggle.addEventListener("click", (event) => {
      event.stopPropagation();
      toggleProfileMenu();
    });

    profileMenu.addEventListener("click", (event) => {
      event.stopPropagation();
    });

    document.addEventListener("click", () => {
      closeProfileMenu();
    });
  }

  document.addEventListener("keydown", (event) => {
    if (event.key !== "Escape") return;
    closeSidebar();
    closeProfileMenu();
  });

  window.addEventListener("resize", () => {
    if (window.innerWidth >= 768) {
      closeSidebar();
      closeProfileMenu();
    }
  });
})();
</script>
