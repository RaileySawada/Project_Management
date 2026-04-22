<?php
$attemptCount = isset($loginAttempts) ? (int) $loginAttempts : 0;
$attemptLimit = isset($maxAttempts) ? (int) $maxAttempts : 5;
?>

<section class="ndt-landing">
  <div class="ndt-container mx-auto flex max-w-[1280px] flex-col gap-[var(--ndt-section-gap)] px-4 pb-4 sm:px-6 sm:pb-6 lg:px-8">
    <section class="ndt-first-view flex min-h-[var(--ndt-screen-h)] flex-col pt-6 lg:pt-7">
      <header class="ndt-nav mb-3 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
        <div class="ndt-brand">
          <span class="ndt-brand-mark">NDT</span>
          <span>Project Management System</span>
        </div>
        <nav class="ndt-nav-links flex flex-wrap items-center gap-3 sm:gap-4" aria-label="Landing quick links">
          <a href="#about-us">About Us</a>
          <a href="#capabilities">Capabilities</a>
          <a href="#workflow">Workflow</a>
        </nav>
      </header>

      <section class="ndt-hero grid flex-1 items-stretch gap-5 lg:grid-cols-12">
        <div class="ndt-hero-copy lg:col-span-7">
          <p class="ndt-kicker">Built for high-accountability teams</p>
          <h1 class="ndt-title">Lead every NDT project with speed, clarity, and control.</h1>
          <p class="ndt-copy">
            From scheduling and inspection records to approvals and final release, everything stays in one
            operational workspace. The result is faster handoffs, tighter compliance, and no blind spots.
          </p>
          <div class="ndt-actions mt-6 flex flex-wrap items-center gap-3">
            <a href="#about-us" class="ndt-btn ndt-btn-primary ndt-desktop-only w-full sm:w-auto">About Us</a>
            <a href="#workflow" class="ndt-btn ndt-btn-ghost ndt-desktop-only w-full sm:w-auto">How It Works</a>
            <a href="#secure-access" class="ndt-btn ndt-btn-primary ndt-mobile-open w-full sm:w-auto">
              Sign In
            </a>
            <a href="<?= BASE_URL ?>/Forgot_Password#forgot-form" class="ndt-btn ndt-btn-ghost ndt-mobile-open w-full sm:w-auto">
              Forgot Password
            </a>
          </div>
          <p class="ndt-inline-note">On large screens the sign-in panel stays on the right. On mobile, tap Sign In to open the form.</p>
          <ul class="ndt-bullets mt-6 grid w-full max-w-4xl grid-cols-1 gap-2 sm:grid-cols-2 xl:grid-cols-3">
            <li>Live project status for field and office teams.</li>
            <li>Audit-ready document history and approval trails.</li>
            <li>Role-based access to protect operational data.</li>
          </ul>
        </div>

        <aside class="ndt-signin w-full max-w-[560px] lg:col-span-5 lg:max-w-none" id="secure-access" aria-label="Sign in panel" aria-modal="true" aria-hidden="false">
          <div class="ndt-signin-head">
            <p class="ndt-signin-system">NDT Project Management System</p>
            <p class="ndt-signin-kicker">Account Sign In</p>
            <h2>Welcome back.</h2>
            <button type="button" class="ndt-modal-close" data-close-auth aria-label="Close sign in form">X</button>
          </div>
          <p class="ndt-signin-copy">Access your workspace, approvals, and active project deliverables.</p>

          <form method="POST" action="<?= BASE_URL ?>/" class="ndt-form" id="sign-in">
            <label for="idNumber" class="ndt-visually-hidden">ID Number</label>
            <input
              type="text"
              name="idNumber"
              id="idNumber"
              class="ndt-field"
              placeholder="ID number"
              autocomplete="username"
              required
            >

            <label for="password" class="ndt-visually-hidden">Password</label>
            <input
              type="password"
              name="password"
              id="password"
              class="ndt-field"
              placeholder="Password"
              autocomplete="current-password"
              required
            >

            <?php if ($attemptCount > 0): ?>
            <p class="ndt-attempts">
              Login attempts used: <?= $attemptCount ?> / <?= $attemptLimit ?>
            </p>
            <?php endif; ?>

            <button type="submit" class="ndt-submit">Sign In</button>
          </form>

          <footer class="ndt-signin-foot">
            <a href="<?= BASE_URL ?>/Forgot_Password#forgot-form" class="ndt-desktop-auth">Forgot password?</a>
            <small>Authorized users only</small>
          </footer>
        </aside>

        <div class="ndt-auth-overlay" id="ndt-auth-overlay" data-close-auth aria-hidden="true"></div>
      </section>
    </section>

    <section class="ndt-section flex min-h-[calc(var(--ndt-screen-h)-2.4rem)] flex-col justify-start gap-1" id="about-us">
      <h3>About Us</h3>
      <p>
        We built this platform for NDT operations where every update matters. Our goal is simple: help teams
        deliver safer, compliant projects faster without sacrificing traceability.
      </p>
      <p class="ndt-about-extended">
        Our team combines operations, inspection, and software experience to remove day-to-day friction from
        project execution. That means clearer visibility for leaders and faster, more confident decisions for
        everyone involved.
      </p>
      <div class="ndt-about-grid grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <article class="ndt-about-panel">
          <h4>Mission</h4>
          <p>Give engineering and inspection teams a single trusted place to run high-stakes projects.</p>
        </article>
        <article class="ndt-about-panel">
          <h4>Focus</h4>
          <p>Keep planning, execution, documentation, and approvals connected from start to release.</p>
        </article>
        <article class="ndt-about-panel">
          <h4>Promise</h4>
          <p>Operational clarity, less rework, and a stronger audit trail for every critical deliverable.</p>
        </article>
        <article class="ndt-about-panel">
          <h4>Approach</h4>
          <p>Design workflows around real site operations so teams can execute with speed and consistency.</p>
        </article>
      </div>
      <div class="ndt-about-stats grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4" aria-label="About us highlights">
        <div class="ndt-about-stat">
          <strong>One</strong>
          <span>Unified workspace from planning through closeout</span>
        </div>
        <div class="ndt-about-stat">
          <strong>Real-time</strong>
          <span>Status updates that support quick project decisions</span>
        </div>
        <div class="ndt-about-stat">
          <strong>Audit-ready</strong>
          <span>Structured activity history and approval records</span>
        </div>
        <div class="ndt-about-stat">
          <strong>Field-first</strong>
          <span>Built to match how NDT teams work onsite and in-office</span>
        </div>
      </div>
      <ul class="ndt-about-values mt-4 flex flex-wrap gap-2" aria-label="About us principles">
        <li>Operational transparency</li>
        <li>Compliance-first delivery</li>
        <li>Fast issue resolution</li>
        <li>Role-based accountability</li>
        <li>Standardized reporting</li>
        <li>Continuous improvement</li>
      </ul>
    </section>

    <section class="ndt-section flex min-h-[calc(var(--ndt-screen-h)-2.4rem)] flex-col justify-start gap-1" id="capabilities">
      <h3>Everything your team needs after kickoff is here.</h3>
      <p>
        We combine planning, execution, and evidence management in one flow so your team does not lose time
        jumping between tools or chasing updates from multiple channels.
      </p>
      <div class="ndt-cards grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        <article class="ndt-card">
          <h4>Project Command Center</h4>
          <p>Track each milestone, deadline, and dependency without separate spreadsheets.</p>
        </article>
        <article class="ndt-card">
          <h4>Compliance Visibility</h4>
          <p>Keep reports, approvals, and revisions structured for faster audits and signoffs.</p>
        </article>
        <article class="ndt-card">
          <h4>Role Driven Collaboration</h4>
          <p>Give technicians, managers, and reviewers exactly the access they need.</p>
        </article>
        <article class="ndt-card">
          <h4>Risk and Issue Tracking</h4>
          <p>Capture blockers early, assign ownership, and move risks to resolution faster.</p>
        </article>
        <article class="ndt-card">
          <h4>Approval Routing</h4>
          <p>Route deliverables through required signatories with status visibility at every stage.</p>
        </article>
        <article class="ndt-card">
          <h4>Executive Snapshot</h4>
          <p>Get a clear top-level view of project progress, readiness, and delayed work items.</p>
        </article>
      </div>
      <div class="ndt-metrics grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3" aria-label="Operational highlights">
        <div class="ndt-metric">
          <strong>24/7</strong>
          <span>Project visibility across teams</span>
        </div>
        <div class="ndt-metric">
          <strong>100%</strong>
          <span>Traceable action history</span>
        </div>
        <div class="ndt-metric">
          <strong>1 Hub</strong>
          <span>Centralized documents and approvals</span>
        </div>
        <div class="ndt-metric">
          <strong>Faster</strong>
          <span>Handoffs from inspection to release</span>
        </div>
        <div class="ndt-metric">
          <strong>Lower</strong>
          <span>Rework through connected workflows</span>
        </div>
        <div class="ndt-metric">
          <strong>Higher</strong>
          <span>Project confidence at each review gate</span>
        </div>
      </div>
    </section>

    <section class="ndt-section flex min-h-[calc(var(--ndt-screen-h)-2.4rem)] flex-col justify-start gap-1" id="workflow">
      <h3>Simple workflow. Strong execution.</h3>
      <p>
        Designed for real operations: plan scope, execute inspections, review and approve, then deliver with
        confidence.
      </p>
      <div class="ndt-steps grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        <article class="ndt-step">
          <small>Step 01</small>
          <h4>Plan and assign</h4>
          <p>Set schedule, define scope, and align teams before field work begins.</p>
        </article>
        <article class="ndt-step">
          <small>Step 02</small>
          <h4>Execute and monitor</h4>
          <p>Capture status, files, and project notes in one timeline while work is ongoing.</p>
        </article>
        <article class="ndt-step">
          <small>Step 03</small>
          <h4>Review and release</h4>
          <p>Finalize approvals and publish deliverables with a complete activity record.</p>
        </article>
        <article class="ndt-step">
          <small>Step 04</small>
          <h4>Flag and resolve issues</h4>
          <p>Track critical findings, assign action owners, and close issues with documented evidence.</p>
        </article>
        <article class="ndt-step">
          <small>Step 05</small>
          <h4>Validate quality gates</h4>
          <p>Confirm readiness criteria before moving to final approvals or client-facing handover.</p>
        </article>
        <article class="ndt-step">
          <small>Step 06</small>
          <h4>Archive and improve</h4>
          <p>Store a complete project record and feed lessons learned back into the next project cycle.</p>
        </article>
      </div>
    </section>

    <section class="ndt-bottom-cta flex min-h-[calc(var(--ndt-screen-h)-2.4rem)] flex-col items-start justify-center gap-4" aria-label="Final call to action">
      <h3>Ready to keep your next NDT project ahead of schedule?</h3>
      <p class="ndt-bottom-copy">
        Access your live workspace now and keep your teams aligned from planning through release. If you are
        still exploring, review our sections above and see how the platform supports every stage of delivery.
      </p>
      <div class="ndt-bottom-actions flex flex-wrap gap-3">
        <a href="#secure-access" class="ndt-btn ndt-btn-primary w-full sm:w-auto">Sign In to Continue</a>
        <a href="#about-us" class="ndt-btn ndt-btn-ghost w-full sm:w-auto">Back to About Us</a>
      </div>
    </section>
  </div>
</section>
