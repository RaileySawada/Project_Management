<?php
$attemptCount = isset($loginAttempts) ? (int) $loginAttempts : 0;
$attemptLimit = isset($maxAttempts) ? (int) $maxAttempts : 5;
$appName = htmlspecialchars((string) (ENV['APP_NAME'] ?? 'NDT Project Management System'), ENT_QUOTES, 'UTF-8');

$sectionShell = "mx-[clamp(0.15rem,1.2vw,0.85rem)] flex scroll-mt-3 flex-col gap-1 rounded-[22px] border border-white/10 bg-white/[0.045] p-[clamp(1.25rem,2.4vw,2.35rem)] shadow-[0_18px_44px_rgba(0,0,0,0.24)] backdrop-blur-sm";
$panelShell = "rounded-2xl border border-white/12 bg-white/[0.07] p-[1.05rem]";
$metricShell = "rounded-[14px] border border-white/12 bg-white/[0.05] px-[0.92rem] py-[0.9rem]";
$valueChip = "rounded-full border border-white/15 bg-white/[0.08] px-3.5 py-2 text-[0.8rem] leading-[1.3] text-neutral-100";
$buttonPrimary = "inline-flex w-full items-center justify-center rounded-full border border-transparent bg-gradient-to-r from-red-500 to-red-700 px-5 py-3 text-[0.85rem] font-bold tracking-[0.02em] text-white shadow-[0_14px_32px_rgba(220,38,38,0.36)] transition duration-200 hover:-translate-y-px hover:brightness-105 sm:w-auto";
$buttonGhost = "inline-flex w-full items-center justify-center rounded-full border border-white/20 bg-white/[0.08] px-5 py-3 text-[0.85rem] font-bold tracking-[0.02em] text-neutral-100 transition duration-200 hover:-translate-y-px hover:border-white/40 sm:w-auto";
?>

<section class="ndt-landing relative isolate min-h-[var(--ndt-screen-h)] w-full text-neutral-100">
  <header
    id="login-page-header"
    data-scrolled="false"
    class="sticky top-0 z-[180] w-full border-b border-transparent bg-transparent transition duration-300"
  >
    <div class="mx-auto flex max-w-[1280px] flex-col items-start justify-between gap-3 px-4 py-4 sm:flex-row sm:items-center sm:px-6 lg:px-8">
      <div class="inline-flex items-center gap-[0.68rem] text-[0.82rem] font-extrabold uppercase tracking-[0.08em]">
        <span class="inline-flex h-11 w-11 items-center justify-center rounded-[14px] bg-gradient-to-br from-red-500 to-red-800 text-[0.8rem] shadow-[0_14px_32px_rgba(220,38,38,0.42)]">NDT</span>
        <span>Project Management System</span>
      </div>
      <nav class="hidden flex-wrap items-center gap-4 lg:flex" aria-label="Landing quick links">
        <a href="#about-us" class="text-[0.85rem] font-semibold text-neutral-300 transition hover:text-white">About Us</a>
        <a href="#capabilities" class="text-[0.85rem] font-semibold text-neutral-300 transition hover:text-white">Capabilities</a>
        <a href="#workflow" class="text-[0.85rem] font-semibold text-neutral-300 transition hover:text-white">Workflow</a>
      </nav>
    </div>
  </header>

  <div class="relative mx-auto flex max-w-[1280px] flex-col gap-4 px-4 pb-4 sm:px-6 sm:pb-6 lg:px-8">
    <section class="flex min-h-[calc(var(--ndt-screen-h)-5rem)] flex-col pt-4 lg:pt-5" id="login-top">
      <section class="grid flex-1 items-center gap-5 lg:grid-cols-12">
        <div class="flex max-w-[680px] flex-col justify-center lg:col-span-7">
          <p class="m-0 text-[0.78rem] font-extrabold uppercase tracking-[0.13em] text-red-300">Built for high-accountability teams</p>
          <h1 class="mt-1 max-w-[11.5ch] text-balance [font-family:'Bebas_Neue','Impact',sans-serif] text-[clamp(2.8rem,8vw,6rem)] leading-[0.95] tracking-[0.02em] text-white">
            Lead every NDT project with speed, clarity, and control.
          </h1>
          <p class="mt-4 max-w-[55ch] text-base leading-7 text-neutral-300">
            From scheduling and inspection records to approvals and final release, everything stays in one
            operational workspace. The result is faster handoffs, tighter compliance, and no blind spots.
          </p>
          <div class="mt-6 flex flex-wrap items-center gap-3 lg:hidden">
            <a href="#secure-access" class="<?= $buttonPrimary ?>">Sign In</a>
            <a href="<?= BASE_URL ?>/Forgot_Password#forgot-form" class="<?= $buttonGhost ?>">Forgot Password</a>
          </div>
          <p class="mt-3 text-[0.82rem] leading-6 text-red-100">
            On large screens the sign-in panel stays on the right. On mobile, tap Sign In to open the form.
          </p>
          <ul class="mt-6 grid w-full max-w-4xl list-none grid-cols-1 gap-2 p-0 sm:grid-cols-2 xl:grid-cols-3">
            <li class="rounded-[13px] border border-white/15 bg-white/[0.08] px-4 py-3 text-[0.8rem] leading-[1.4] text-neutral-100">
              Live project status for field and office teams.
            </li>
            <li class="rounded-[13px] border border-white/15 bg-white/[0.08] px-4 py-3 text-[0.8rem] leading-[1.4] text-neutral-100">
              Audit-ready document history and approval trails.
            </li>
            <li class="rounded-[13px] border border-white/15 bg-white/[0.08] px-4 py-3 text-[0.8rem] leading-[1.4] text-neutral-100">
              Role-based access to protect operational data.
            </li>
          </ul>
        </div>

        <aside
          class="ndt-signin fixed left-1/2 top-1/2 z-[220] hidden w-[min(560px,calc(100vw-1.5rem))] max-h-[calc(var(--ndt-screen-h)-1.5rem)] -translate-x-1/2 -translate-y-1/2 flex-col items-start overflow-x-hidden overflow-y-auto rounded-[24px] border border-white/[0.15] bg-neutral-950/85 p-6 shadow-[0_28px_60px_rgba(0,0,0,0.42)] backdrop-blur-xl lg:static lg:z-auto lg:flex lg:w-auto lg:max-h-none lg:translate-x-0 lg:translate-y-0 lg:self-center lg:overflow-visible lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:pl-[clamp(0.4rem,2vw,1.7rem)] lg:shadow-none lg:backdrop-blur-none lg:col-span-5"
          id="secure-access"
          aria-label="Sign in panel"
          aria-modal="true"
          aria-hidden="true"
        >
          <span class="absolute left-0 top-1/2 hidden h-[clamp(320px,54vh,560px)] w-px -translate-y-1/2 bg-gradient-to-b from-red-200/75 to-red-200/5 lg:block"></span>

          <div class="w-full lg:max-w-[460px]">
            <div class="relative flex flex-col items-start gap-1">
              <p class="mb-1 text-[0.74rem] font-bold uppercase tracking-[0.08em] text-red-100 lg:hidden">NDT Project Management System</p>
              <p class="m-0 text-[0.75rem] font-extrabold uppercase tracking-[0.14em] text-red-300">Account Sign In</p>
              <h2 class="m-0 text-[1.42rem] font-extrabold text-white lg:text-[1.58rem]">Sign in to your account.</h2>
              <button
                type="button"
                class="absolute right-0 top-0 inline-flex h-9 w-9 items-center justify-center rounded-[10px] border border-white/25 bg-white/10 text-neutral-100 transition hover:border-white/40 lg:hidden"
                data-close-auth
                aria-label="Close sign in form"
              >
                X
              </button>
            </div>

            <p class="mt-2 max-w-[34ch] text-[0.9rem] leading-6 text-neutral-300">
              Access your workspace, approvals, and active project deliverables.
            </p>

            <form method="POST" action="<?= BASE_URL ?>/" class="mt-4 flex flex-col gap-3" id="sign-in">
              <label for="idNumber" class="sr-only">ID Number</label>
              <input
                type="text"
                name="idNumber"
                id="idNumber"
                class="w-full rounded-xl border border-white/20 bg-white/[0.08] px-4 py-3 text-[0.9rem] text-neutral-50 outline-none transition placeholder:text-neutral-300 focus:border-red-500 focus:bg-white/[0.11] focus:ring-4 focus:ring-red-500/20"
                placeholder="ID number"
                autocomplete="username"
                required
              >

              <label for="password" class="sr-only">Password</label>
              <input
                type="password"
                name="password"
                id="password"
                class="w-full rounded-xl border border-white/20 bg-white/[0.08] px-4 py-3 text-[0.9rem] text-neutral-50 outline-none transition placeholder:text-neutral-300 focus:border-red-500 focus:bg-white/[0.11] focus:ring-4 focus:ring-red-500/20"
                placeholder="Password"
                autocomplete="current-password"
                required
              >

              <?php if ($attemptCount > 0): ?>
              <p class="rounded-[10px] border border-amber-300/35 bg-amber-300/10 px-3 py-2 text-[0.75rem] text-amber-200">
                Login attempts used: <?= $attemptCount ?> / <?= $attemptLimit ?>
              </p>
              <?php endif; ?>

              <button
                type="submit"
                class="mt-1 w-full rounded-xl border border-white/20 bg-gradient-to-r from-red-500 to-red-700 px-4 py-3 text-[0.9rem] font-bold text-white transition duration-200 hover:-translate-y-px hover:brightness-105"
              >
                Sign In
              </button>
            </form>

            <footer class="mt-4 flex flex-col items-start gap-2 border-t border-white/10 pt-4 text-[0.73rem] text-neutral-300 sm:flex-row sm:items-center sm:justify-between lg:justify-start lg:gap-4">
              <a href="<?= BASE_URL ?>/Forgot_Password" class="auth-inline-link hidden font-bold text-red-100 transition hover:text-red-50 lg:inline-flex">
                <span class="auth-inline-link-text">Forgot password?</span>
              </a>
            </footer>
          </div>
        </aside>

        <div id="ndt-auth-overlay" class="fixed inset-0 z-[210] hidden bg-[#050505]/72 backdrop-blur-sm lg:hidden" data-close-auth aria-hidden="true"></div>
      </section>
    </section>

    <section class="<?= $sectionShell ?>" id="about-us">
      <h3 class="text-[clamp(1.65rem,2.6vw,2.35rem)] font-semibold leading-tight text-white">About Us</h3>
      <p class="max-w-[100ch] text-base leading-[1.72] text-neutral-300">
        We built this platform for NDT operations where every update matters. Our goal is simple: help teams
        deliver safer, compliant projects faster without sacrificing traceability.
      </p>
      <p class="mt-1 max-w-[76ch] text-[1.02rem] leading-[1.75] text-neutral-200">
        Our team combines operations, inspection, and software experience to remove day-to-day friction from
        project execution. That means clearer visibility for leaders and faster, more confident decisions for
        everyone involved.
      </p>
      <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <article class="<?= $panelShell ?>">
          <h4 class="text-[1.05rem] font-semibold text-white">Mission</h4>
          <p class="mt-2 text-[0.88rem] leading-[1.58] text-neutral-300">Give engineering and inspection teams a single trusted place to run high-stakes projects.</p>
        </article>
        <article class="<?= $panelShell ?>">
          <h4 class="text-[1.05rem] font-semibold text-white">Focus</h4>
          <p class="mt-2 text-[0.88rem] leading-[1.58] text-neutral-300">Keep planning, execution, documentation, and approvals connected from start to release.</p>
        </article>
        <article class="<?= $panelShell ?>">
          <h4 class="text-[1.05rem] font-semibold text-white">Promise</h4>
          <p class="mt-2 text-[0.88rem] leading-[1.58] text-neutral-300">Operational clarity, less rework, and a stronger audit trail for every critical deliverable.</p>
        </article>
        <article class="<?= $panelShell ?>">
          <h4 class="text-[1.05rem] font-semibold text-white">Approach</h4>
          <p class="mt-2 text-[0.88rem] leading-[1.58] text-neutral-300">Design workflows around real site operations so teams can execute with speed and consistency.</p>
        </article>
      </div>
      <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4" aria-label="About us highlights">
        <div class="<?= $metricShell ?>">
          <strong class="block text-[1.48rem] leading-none text-white">One</strong>
          <span class="mt-1 block text-[0.79rem] leading-[1.4] text-neutral-300">Unified workspace from planning through closeout</span>
        </div>
        <div class="<?= $metricShell ?>">
          <strong class="block text-[1.48rem] leading-none text-white">Real-time</strong>
          <span class="mt-1 block text-[0.79rem] leading-[1.4] text-neutral-300">Status updates that support quick project decisions</span>
        </div>
        <div class="<?= $metricShell ?>">
          <strong class="block text-[1.48rem] leading-none text-white">Audit-ready</strong>
          <span class="mt-1 block text-[0.79rem] leading-[1.4] text-neutral-300">Structured activity history and approval records</span>
        </div>
        <div class="<?= $metricShell ?>">
          <strong class="block text-[1.48rem] leading-none text-white">Field-first</strong>
          <span class="mt-1 block text-[0.79rem] leading-[1.4] text-neutral-300">Built to match how NDT teams work onsite and in-office</span>
        </div>
      </div>
      <ul class="mt-4 flex flex-wrap gap-2" aria-label="About us principles">
        <li class="<?= $valueChip ?>">Operational transparency</li>
        <li class="<?= $valueChip ?>">Compliance-first delivery</li>
        <li class="<?= $valueChip ?>">Fast issue resolution</li>
        <li class="<?= $valueChip ?>">Role-based accountability</li>
        <li class="<?= $valueChip ?>">Standardized reporting</li>
        <li class="<?= $valueChip ?>">Continuous improvement</li>
      </ul>
    </section>

    <section class="<?= $sectionShell ?>" id="capabilities">
      <h3 class="text-[clamp(1.65rem,2.6vw,2.35rem)] font-semibold leading-tight text-white">Everything your team needs after kickoff is here.</h3>
      <p class="max-w-[100ch] text-base leading-[1.72] text-neutral-300">
        We combine planning, execution, and evidence management in one flow so your team does not lose time
        jumping between tools or chasing updates from multiple channels.
      </p>
      <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        <article class="<?= $panelShell ?>">
          <h4 class="text-[1.05rem] font-semibold text-white">Project Command Center</h4>
          <p class="mt-2 text-[0.89rem] leading-[1.58] text-neutral-300">Track each milestone, deadline, and dependency without separate spreadsheets.</p>
        </article>
        <article class="<?= $panelShell ?>">
          <h4 class="text-[1.05rem] font-semibold text-white">Compliance Visibility</h4>
          <p class="mt-2 text-[0.89rem] leading-[1.58] text-neutral-300">Keep reports, approvals, and revisions structured for faster audits and signoffs.</p>
        </article>
        <article class="<?= $panelShell ?>">
          <h4 class="text-[1.05rem] font-semibold text-white">Role Driven Collaboration</h4>
          <p class="mt-2 text-[0.89rem] leading-[1.58] text-neutral-300">Give technicians, managers, and reviewers exactly the access they need.</p>
        </article>
        <article class="<?= $panelShell ?>">
          <h4 class="text-[1.05rem] font-semibold text-white">Risk and Issue Tracking</h4>
          <p class="mt-2 text-[0.89rem] leading-[1.58] text-neutral-300">Capture blockers early, assign ownership, and move risks to resolution faster.</p>
        </article>
        <article class="<?= $panelShell ?>">
          <h4 class="text-[1.05rem] font-semibold text-white">Approval Routing</h4>
          <p class="mt-2 text-[0.89rem] leading-[1.58] text-neutral-300">Route deliverables through required signatories with status visibility at every stage.</p>
        </article>
        <article class="<?= $panelShell ?>">
          <h4 class="text-[1.05rem] font-semibold text-white">Executive Snapshot</h4>
          <p class="mt-2 text-[0.89rem] leading-[1.58] text-neutral-300">Get a clear top-level view of project progress, readiness, and delayed work items.</p>
        </article>
      </div>
      <div class="mt-4 grid grid-cols-1 gap-4 border-t border-white/15 pt-4 md:grid-cols-2 xl:grid-cols-3" aria-label="Operational highlights">
        <div>
          <strong class="block text-[1.6rem] font-extrabold leading-none text-white">24/7</strong>
          <span class="mt-1 block text-[0.77rem] text-neutral-300">Project visibility across teams</span>
        </div>
        <div>
          <strong class="block text-[1.6rem] font-extrabold leading-none text-white">100%</strong>
          <span class="mt-1 block text-[0.77rem] text-neutral-300">Traceable action history</span>
        </div>
        <div>
          <strong class="block text-[1.6rem] font-extrabold leading-none text-white">1 Hub</strong>
          <span class="mt-1 block text-[0.77rem] text-neutral-300">Centralized documents and approvals</span>
        </div>
        <div>
          <strong class="block text-[1.6rem] font-extrabold leading-none text-white">Faster</strong>
          <span class="mt-1 block text-[0.77rem] text-neutral-300">Handoffs from inspection to release</span>
        </div>
        <div>
          <strong class="block text-[1.6rem] font-extrabold leading-none text-white">Lower</strong>
          <span class="mt-1 block text-[0.77rem] text-neutral-300">Rework through connected workflows</span>
        </div>
        <div>
          <strong class="block text-[1.6rem] font-extrabold leading-none text-white">Higher</strong>
          <span class="mt-1 block text-[0.77rem] text-neutral-300">Project confidence at each review gate</span>
        </div>
      </div>
    </section>

    <section class="<?= $sectionShell ?>" id="workflow">
      <h3 class="text-[clamp(1.65rem,2.6vw,2.35rem)] font-semibold leading-tight text-white">Simple workflow. Strong execution.</h3>
      <p class="max-w-[100ch] text-base leading-[1.72] text-neutral-300">
        Designed for real operations: plan scope, execute inspections, review and approve, then deliver with
        confidence.
      </p>
      <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        <article class="<?= $panelShell ?> min-h-[178px]">
          <small class="inline-flex rounded-full border border-red-200/35 bg-red-200/15 px-2 py-1 text-[0.68rem] font-bold uppercase tracking-[0.04em] text-red-100">Step 01</small>
          <h4 class="mt-3 text-[1.04rem] font-semibold text-white">Plan and assign</h4>
          <p class="mt-2 text-[0.86rem] leading-[1.58] text-neutral-300">Set schedule, define scope, and align teams before field work begins.</p>
        </article>
        <article class="<?= $panelShell ?> min-h-[178px]">
          <small class="inline-flex rounded-full border border-red-200/35 bg-red-200/15 px-2 py-1 text-[0.68rem] font-bold uppercase tracking-[0.04em] text-red-100">Step 02</small>
          <h4 class="mt-3 text-[1.04rem] font-semibold text-white">Execute and monitor</h4>
          <p class="mt-2 text-[0.86rem] leading-[1.58] text-neutral-300">Capture status, files, and project notes in one timeline while work is ongoing.</p>
        </article>
        <article class="<?= $panelShell ?> min-h-[178px]">
          <small class="inline-flex rounded-full border border-red-200/35 bg-red-200/15 px-2 py-1 text-[0.68rem] font-bold uppercase tracking-[0.04em] text-red-100">Step 03</small>
          <h4 class="mt-3 text-[1.04rem] font-semibold text-white">Review and release</h4>
          <p class="mt-2 text-[0.86rem] leading-[1.58] text-neutral-300">Finalize approvals and publish deliverables with a complete activity record.</p>
        </article>
        <article class="<?= $panelShell ?> min-h-[178px]">
          <small class="inline-flex rounded-full border border-red-200/35 bg-red-200/15 px-2 py-1 text-[0.68rem] font-bold uppercase tracking-[0.04em] text-red-100">Step 04</small>
          <h4 class="mt-3 text-[1.04rem] font-semibold text-white">Flag and resolve issues</h4>
          <p class="mt-2 text-[0.86rem] leading-[1.58] text-neutral-300">Track critical findings, assign action owners, and close issues with documented evidence.</p>
        </article>
        <article class="<?= $panelShell ?> min-h-[178px]">
          <small class="inline-flex rounded-full border border-red-200/35 bg-red-200/15 px-2 py-1 text-[0.68rem] font-bold uppercase tracking-[0.04em] text-red-100">Step 05</small>
          <h4 class="mt-3 text-[1.04rem] font-semibold text-white">Validate quality gates</h4>
          <p class="mt-2 text-[0.86rem] leading-[1.58] text-neutral-300">Confirm readiness criteria before moving to final approvals or client-facing handover.</p>
        </article>
        <article class="<?= $panelShell ?> min-h-[178px]">
          <small class="inline-flex rounded-full border border-red-200/35 bg-red-200/15 px-2 py-1 text-[0.68rem] font-bold uppercase tracking-[0.04em] text-red-100">Step 06</small>
          <h4 class="mt-3 text-[1.04rem] font-semibold text-white">Archive and improve</h4>
          <p class="mt-2 text-[0.86rem] leading-[1.58] text-neutral-300">Store a complete project record and feed lessons learned back into the next project cycle.</p>
        </article>
      </div>
    </section>

  </div>

  <footer class="w-full border-t border-white/10 bg-black/35">
    <div class="mx-auto max-w-[1280px] px-4 py-10 sm:px-6 lg:px-8">
      <div class="grid gap-8 lg:grid-cols-[minmax(0,1.35fr)_minmax(0,0.9fr)_minmax(0,0.95fr)]">
        <div class="space-y-4">
          <div class="inline-flex items-center gap-[0.68rem] text-[0.82rem] font-extrabold uppercase tracking-[0.08em]">
            <span class="inline-flex h-11 w-11 items-center justify-center rounded-[14px] bg-gradient-to-br from-red-500 to-red-800 text-[0.8rem] shadow-[0_14px_32px_rgba(220,38,38,0.42)]">NDT</span>
            <span><?= $appName ?></span>
          </div>
          <p class="max-w-[54ch] text-sm leading-7 text-neutral-300">
            Secure operational workspace for project planning, approvals, inspection tracking, and delivery coordination.
            Built for internal teams that need clear accountability and audit-ready records.
          </p>
          <div class="flex flex-wrap gap-2 text-[0.72rem] font-semibold uppercase tracking-[0.08em] text-neutral-200">
            <span class="rounded-full border border-white/12 bg-white/[0.08] px-3 py-1.5">Internal Platform</span>
            <span class="rounded-full border border-white/12 bg-white/[0.08] px-3 py-1.5">Role-Based Access</span>
            <span class="rounded-full border border-white/12 bg-white/[0.08] px-3 py-1.5">Traceable Activity</span>
          </div>
        </div>

        <div>
          <p class="text-sm font-semibold uppercase tracking-[0.08em] text-white">Quick Links</p>
          <nav class="mt-4 flex flex-col items-start gap-3 text-sm text-neutral-300" aria-label="Login footer links">
            <a href="#about-us" class="transition hover:text-white">About Us</a>
            <a href="#capabilities" class="transition hover:text-white">Capabilities</a>
            <a href="#workflow" class="transition hover:text-white">Workflow</a>
            <a href="<?= BASE_URL ?>/Forgot_Password#forgot-form" class="transition hover:text-white">Forgot Password</a>
          </nav>
        </div>

        <div>
          <p class="text-sm font-semibold uppercase tracking-[0.08em] text-white">Access & Support</p>
          <div class="mt-4 space-y-3 text-sm leading-6 text-neutral-300">
            <p>Authorized users only. Sign in with your assigned account credentials.</p>
            <p>For password recovery, use the forgot-password page to request a reset link.</p>
            <p>For account provisioning or access issues, contact your system administrator.</p>
          </div>
        </div>
      </div>

      <div class="mt-8 flex flex-col gap-4 border-t border-white/10 pt-5 sm:flex-row sm:items-center sm:justify-between">
        <div class="space-y-1 text-sm text-neutral-400">
          <p>&copy; <?= date('Y') ?> <?= $appName ?>. All rights reserved.</p>
          <p>Use of this system may be monitored to protect operational data and maintain service integrity.</p>
        </div>
        <a href="#login-top" class="<?= $buttonGhost ?>">Back to Top</a>
      </div>
    </div>
  </footer>
</section>
