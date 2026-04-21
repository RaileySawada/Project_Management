<?php
$sidebarLinks = is_array($sidebarLinks ?? null) ? $sidebarLinks : [];
$currentPath = str_replace('/eDocs', '', strtok($_SERVER['REQUEST_URI'] ?? '/', '?'));
if ($currentPath === '') $currentPath = '/';

$navMeta = [
  '/Research' => ['icon' => 'fa-microscope', 'tone' => 'from-blue-500/20 to-sky-500/10'],
  '/Extension' => ['icon' => 'fa-hands-helping', 'tone' => 'from-emerald-500/20 to-teal-500/10'],
  '/Planning' => ['icon' => 'fa-clipboard-list', 'tone' => 'from-amber-500/20 to-yellow-500/10'],
  '/Quality_Assurance' => ['icon' => 'fa-shield-halved', 'tone' => 'from-indigo-500/20 to-violet-500/10'],
  '/Analytics' => ['icon' => 'fa-chart-line', 'tone' => 'from-cyan-500/20 to-blue-500/10'],
  '/Settings' => ['icon' => 'fa-gear', 'tone' => 'from-slate-500/20 to-slate-300/10'],
  '/User_Management' => ['icon' => 'fa-users-gear', 'tone' => 'from-purple-500/20 to-indigo-500/10']
];
?>

<aside id="sidebar" class="fixed left-[10px] top-[10px] z-70 h-[calc(100vh-20px)] w-[286px] !flex flex-col overflow-hidden rounded-2xl border border-slate-700/50 bg-gradient-to-b from-[#010b31] via-slate-900 to-[#020920] shadow-[0_28px_60px_rgba(1,11,49,0.55)] -translate-x-[calc(100%+20px)] transition-transform duration-300 ease-in-out md:static md:my-[10px] md:ml-[10px] md:h-auto md:w-[72px] md:translate-x-0 lg:w-[286px]">
  <div class="pointer-events-none absolute inset-0">
    <div class="absolute -top-24 left-1/2 h-48 w-48 -translate-x-1/2 rounded-full bg-blue-500/20 blur-3xl"></div>
    <div class="absolute inset-0 bg-[linear-gradient(rgba(148,163,184,0.07)_1px,transparent_1px),linear-gradient(90deg,rgba(148,163,184,0.07)_1px,transparent_1px)] bg-[size:22px_22px] opacity-[0.07]"></div>
  </div>

  <div class="relative flex h-full flex-col">
    <button
      id="close_sidebar"
      type="button"
      aria-label="Close sidebar menu"
      class="absolute right-3 top-3 z-20 inline-flex h-9 w-9 items-center justify-center rounded-full border-solid border-slate-500/50 bg-slate-900/85 text-slate-200 shadow-[0_12px_22px_rgba(2,6,23,0.4)] backdrop-blur-sm transition-all duration-200 hover:scale-105 hover:border-blue-300/70 hover:bg-blue-500/25 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-300 md:hidden">
      <span class="pointer-events-none absolute inset-0 rounded-full bg-gradient-to-br from-white/10 via-transparent to-transparent"></span>
      <i class="fa-solid fa-xmark relative text-sm"></i>
    </button>

    <div class="border-b border-slate-700/50 px-4 pb-4 pt-6">
      <div class="flex items-center justify-center gap-3 rounded-2xl border border-slate-700/60 bg-slate-900/35 p-3 md:border-none lg:border-solid lg:border-slate-700/60 lg:bg-slate-900/35 md:p-0 lg:p-3 backdrop-blur-md lg:justify-start">
        <div class="relative mx-auto md:mx-0">
          <img src="<?= LOGO ?>"
              alt="Logo"
              draggable="false"
              class="h-14 block md:hidden lg:block relative drop-shadow-2xl transition-all duration-300">
          <img src="<?= LOGO ?>"
              alt="Logo"
              draggable="false"
              class="h-11 hidden md:block lg:hidden relative drop-shadow-2xl transition-all duration-300">
        </div>

        <div class="block md:hidden lg:block">
          <h1 class="bg-gradient-to-r from-white to-blue-100 bg-clip-text text-lg font-bold tracking-tight text-transparent select-none">e-Docs</h1>
          <p class="text-xs font-medium text-slate-400 select-none">Document Management</p>
        </div>
      </div>
    </div>

    <nav class="mb-auto flex-1 space-y-1.5 overflow-y-auto px-3 py-5 scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-transparent">
      <p class="px-3 pb-2 text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400 md:hidden lg:block select-none">Workspace</p>

      <?php if (empty($sidebarLinks)): ?>
        <div class="rounded-xl border border-slate-700/60 bg-slate-900/35 px-3 py-3">
          <p class="text-xs font-medium text-slate-400">No assigned modules.</p>
        </div>
      <?php endif; ?>

      <?php foreach ($sidebarLinks as $link): ?>
        <?php
          $path = (string) ($link['path'] ?? '');
          $label = (string) ($link['label'] ?? '');
          if ($path === '' || $label === '') continue;

          $isActive = strcasecmp($currentPath, $path) === 0
            || str_starts_with(strtolower($currentPath), strtolower($path) . '/');
          $meta = $navMeta[$path] ?? ['icon' => 'fa-folder-open', 'tone' => 'from-blue-500/20 to-indigo-500/10'];
          $showQATurnDot = $path === '/Quality_Assurance' && !empty($link['qa_turn_pending']);
          $qaTurnCount = (int)($link['qa_turn_count'] ?? 0);

          $linkClasses = $isActive
            ? 'border-blue-400/60 ring-1 ring-blue-300/45 bg-gradient-to-r from-blue-500/25 to-indigo-500/15 text-white shadow-[0_12px_30px_rgba(37,99,235,0.25)]'
            : 'border-slate-700/55 bg-slate-900/25 text-slate-300 hover:border-slate-500/60 hover:bg-white/[0.04] hover:text-white';
          $iconWrapClasses = $isActive
            ? 'border-blue-300/40 bg-blue-500/25 text-blue-100'
            : 'border-slate-600/60 bg-slate-800/50 text-slate-300 group-hover:text-slate-100';
        ?>
        <a
          href="<?= htmlspecialchars(BASE_URL . $path, ENT_QUOTES, 'UTF-8') ?>"
          class="group relative flex items-center justify-start gap-3 rounded-xl border px-3 py-2.5 text-sm font-medium transition-all duration-300 md:justify-center lg:justify-start <?= $linkClasses ?>">
          <?php if ($isActive): ?>
            <span class="pointer-events-none absolute left-0 top-1/2 h-8 w-1 -translate-y-1/2 rounded-r-full bg-blue-200 shadow-[0_0_16px_rgba(191,219,254,0.95)] md:hidden lg:block"></span>
          <?php endif; ?>
          <span class="pointer-events-none absolute inset-0 rounded-xl bg-gradient-to-r <?= $meta['tone'] ?> opacity-0 transition-opacity duration-300 group-hover:opacity-100"></span>
          <span class="relative flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border <?= $iconWrapClasses ?>">
            <i class="fa-solid <?= htmlspecialchars((string) $meta['icon'], ENT_QUOTES, 'UTF-8') ?> text-xs"></i>
            <?php if ($showQATurnDot): ?>
              <span
                id="sidebarQATurnDot"
                data-count="<?= $qaTurnCount ?>"
                class="absolute -right-1 -top-1 inline-flex h-2.5 w-2.5 rounded-full bg-red-500 shadow-[0_0_10px_rgba(239,68,68,0.9)]"
                title="<?= $qaTurnCount ?> pending approval<?= $qaTurnCount === 1 ? '' : 's' ?>"
              ></span>
            <?php endif; ?>
          </span>
          <span class="relative truncate md:hidden lg:block select-none"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></span>

          <?php if ($isActive): ?>
            <span class="relative ml-auto h-2.5 w-2.5 rounded-full bg-blue-200 shadow-[0_0_12px_rgba(191,219,254,0.9)] md:hidden lg:block"></span>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </nav>
  </div>
</aside>

<div id="sidebar_backdrop" class="fixed inset-0 z-60 bg-slate-950/55 backdrop-blur-[2px] md:hidden opacity-0 pointer-events-none transition-opacity duration-300"></div>
