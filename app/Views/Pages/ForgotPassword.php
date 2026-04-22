<?php
$defaultEmail = trim((string) ($_POST['email'] ?? ''));
$safeEmail = htmlspecialchars($defaultEmail, ENT_QUOTES, 'UTF-8');
?>

<section class="fp-shell">
  <div class="fp-container mx-auto flex max-w-[1240px] flex-col px-4 sm:px-6 lg:px-8">
    <section class="fp-first-view flex min-h-[var(--fp-screen-h)] flex-col">
      <header class="fp-nav mb-3 flex flex-col items-start gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="fp-brand">
          <span class="fp-brand-mark">NDT</span>
          <span>Project Management System</span>
        </div>
        <a href="<?= BASE_URL ?>" class="fp-top-auth">Return to Sign In</a>
      </header>

      <section class="fp-hero grid flex-1 items-stretch gap-5 lg:grid-cols-12">
        <div class="fp-hero-copy lg:col-span-7">
          <p class="fp-kicker">Account Recovery</p>
          <h1 class="fp-title">Reset your password.</h1>
          <p class="fp-copy">
            Enter the email linked to your account and we will send a password reset link.
          </p>

        </div>

        <form method="POST" action="<?= BASE_URL ?>/Forgot_Password" class="fp-card fp-form-shell w-full max-w-[560px] lg:col-span-5 lg:max-w-none" id="forgot-form">
          <header class="fp-card-head">
            <p class="fp-form-system">NDT Project Management System</p>
            <p class="fp-form-kicker">Account Recovery</p>
            <h2 class="fp-form-title">Reset your password.</h2>
          </header>
          <p class="fp-card-copy">Enter the email linked to your account and we will send a password reset link.</p>

          <div class="fp-fields">
            <label for="email" class="fp-label">Email Address</label>
            <input
              type="email"
              name="email"
              id="email"
              class="fp-input"
              placeholder="name@company.com"
              value="<?= $safeEmail ?>"
              autocomplete="email"
              required
            >
          </div>

          <button type="submit" class="fp-submit">Send Reset Link</button>

          <div class="fp-foot">
            <small>Authorized users only</small>
          </div>
        </form>

      </section>
    </section>
  </div>
</section>
