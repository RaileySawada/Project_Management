<?php
function modalComponent(string $headTitle, string $body, string $id, string $actionPath = '', bool $viewing = false, string $enctype = '') {
  $enctypeAttr = $enctype ? "enctype=\"{$enctype}\"" : '';
  $overlayClass = 'app-modal qa-modal fixed inset-0 z-[90] items-end justify-center bg-slate-900/45 backdrop-blur-[2px] p-0 md:items-center md:px-4 md:py-5';
  $panelClass = 'app-modal__panel qa-modal-panel w-full max-h-[88dvh] overflow-hidden rounded-t-[24px] border border-slate-200 bg-white shadow-2xl sm:max-w-2xl sm:rounded-2xl flex flex-col';
  $headerClass = 'modal-header qa-modal-header flex items-center justify-between gap-3 border-b border-slate-200 bg-white px-4 py-3 sm:px-6';
  $bodyClass = 'modal-body qa-modal-body flex-1 overflow-y-auto bg-slate-50/50 px-4 py-4 sm:px-6';
  $footerClass = 'modal-footer qa-modal-footer flex flex-col-reverse gap-2 border-t border-slate-200 bg-white px-4 py-3 sm:flex-row sm:justify-end sm:gap-3 sm:px-6';

  $formContent = <<<HTML
    <form action="{$actionPath}" method="POST" {$enctypeAttr} class="{$panelClass} qa-modal-form">
      <div class="{$headerClass}">
        <h2 class="text-base font-semibold tracking-wide text-slate-900 sm:text-lg">$headTitle</h2>
        <button type="button" class="close-modal inline-flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition-colors hover:bg-slate-100 hover:text-slate-900">
          <i class="fa-solid fa-xmark text-lg"></i>
        </button>
      </div>

      <div class="{$bodyClass} space-y-4">
        $body
      </div>

      <div class="{$footerClass}">
        <button type="button" class="close-modal inline-flex w-full items-center justify-center rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 transition duration-300 hover:bg-slate-100 sm:w-auto">
          Close
        </button>
        <button type="submit" class="submit-btn inline-flex w-full items-center justify-center rounded-xl bg-[#0b2075] px-5 py-2.5 text-sm font-semibold text-white transition duration-300 hover:bg-[#1438a6] sm:w-auto">
          Save Changes
        </button>
      </div>
    </form>
  HTML;

  $modalContent = <<<HTML
    <div class="{$panelClass}">
      <div class="{$headerClass}">
        <h2 class="text-base font-semibold tracking-wide text-slate-900 sm:text-lg">$headTitle</h2>
        <button type="button" class="close-modal inline-flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition-colors hover:bg-slate-100 hover:text-slate-900">
          <i class="fa-solid fa-xmark text-lg"></i>
        </button>
      </div>

      <div class="{$bodyClass} space-y-4">
        $body
      </div>

      <div class="{$footerClass}">
        <button type="button" class="close-modal inline-flex w-full items-center justify-center rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 transition duration-300 hover:bg-slate-100 sm:w-auto">
          Close
        </button>
      </div>
    </div>
  HTML;

  $component = !$viewing ? $formContent : $modalContent;
  
  return <<<HTML
    <div id="{$id}" class="{$overlayClass}" style="display: none;">
      $component
    </div>
  HTML;
}
