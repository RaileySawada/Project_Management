<?php
$defaultEmail = trim((string) ($_POST['email'] ?? ''));
$safeEmail = htmlspecialchars($defaultEmail, ENT_QUOTES, 'UTF-8');
?>

<section class="fp-shell relative isolate min-h-[var(--fp-screen-h)] w-full overflow-hidden text-neutral-100">
  <div class="relative mx-auto flex max-w-[1240px] flex-col px-4 sm:px-6 lg:px-8">
    <section class="flex min-h-[var(--fp-screen-h)] flex-col pt-4 pb-3 sm:py-4">
      <header class="mb-4 flex flex-col items-start gap-3 sm:mb-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="inline-flex items-center gap-[0.68rem] text-[0.82rem] font-extrabold uppercase tracking-[0.08em]">
          <span class="inline-flex h-11 w-11 items-center justify-center rounded-[14px] bg-gradient-to-br from-red-500 to-red-800 text-[0.8rem] shadow-[0_14px_32px_rgba(220,38,38,0.42)]">NDT</span>
          <span>Project Management System</span>
        </div>
      </header>

      <section class="flex flex-col items-start gap-0 lg:grid lg:flex-1 lg:grid-cols-12 lg:items-center lg:gap-5">
        <div class="flex w-full max-w-[680px] flex-col justify-start lg:col-span-7 lg:justify-center">
          <p class="m-0 text-[0.78rem] font-extrabold uppercase tracking-[0.13em] text-red-300">Account Recovery</p>
          <h1 class="mt-2 max-w-[10ch] [font-family:'Bebas_Neue','Impact',sans-serif] text-[clamp(2.3rem,6.6vw,5rem)] leading-[0.97] tracking-[0.02em] text-white">
            Reset your password.
          </h1>
          <p class="mt-4 max-w-[50ch] text-[0.98rem] leading-7 text-neutral-300">
            Enter the email linked to your account and we will send a password reset link.
          </p>
        </div>

        <form method="POST" action="<?= BASE_URL ?>/Forgot_Password" class="relative mt-3 w-full max-w-[560px] sm:mt-4 lg:mt-0 lg:col-span-5 lg:max-w-none lg:self-center lg:pl-[clamp(0.5rem,2vw,2rem)]" id="forgot-form">
          <span class="absolute left-0 top-1/2 hidden h-[clamp(320px,54vh,560px)] w-px -translate-y-1/2 bg-gradient-to-b from-red-200/75 to-red-200/5 lg:block"></span>

          <div class="w-full lg:max-w-[460px]">
            <div class="flex flex-col gap-3">
              <div class="flex flex-col gap-2">
                <label for="email" class="text-[0.82rem] font-bold tracking-[0.02em] text-neutral-100">Email Address</label>
                <input
                  type="email"
                  name="email"
                  id="email"
                  class="w-full rounded-xl border border-white/20 bg-white/[0.08] px-4 py-3 text-[0.92rem] text-neutral-50 outline-none transition placeholder:text-neutral-300 focus:border-red-500 focus:ring-4 focus:ring-red-500/20"
                  placeholder="name@company.com"
                  value="<?= $safeEmail ?>"
                  autocomplete="email"
                  required
                >
              </div>

              <button
                type="submit"
                class="mt-1 min-h-[46px] rounded-xl border border-white/20 bg-gradient-to-r from-red-500 to-red-700 px-4 py-3 text-[0.9rem] font-bold text-white transition duration-200 hover:-translate-y-px hover:brightness-105 disabled:cursor-wait disabled:opacity-80"
              >
                Send Reset Link
              </button>

              <div class="mt-2 flex flex-col items-start gap-2 text-[0.76rem] text-neutral-300 sm:flex-row sm:items-center sm:justify-between lg:justify-start lg:gap-4 lg:border-t lg:border-white/10 lg:pt-4">
                <a href="<?= BASE_URL ?>" class="auth-inline-link auth-inline-link--back inline-flex items-center gap-2 font-bold text-red-100 transition hover:text-red-50">
                  <span class="auth-inline-link-icon text-red-300" aria-hidden="true">&lt;</span>
                  <span class="auth-inline-link-text">Return to Sign In</span>
                </a>
              </div>
            </div>
          </div>
        </form>
      </section>
    </section>
  </div>
</section>