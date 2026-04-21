<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="<?= $meta["author"] ?>">
    <meta name="description" content="<?= $meta["meta_desc"] ?>">
    <meta property="og:title" content="<?= $meta["meta_title"] ?>">
    <meta property="og:description" content="<?= $meta["meta_desc"] ?>">
    <meta property="og:image" content="<?= $meta["meta_img"] ?>">
    <meta property="og:url" content="<?= BASE_URL ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $meta["meta_title"] ?>">
    <meta name="twitter:description" content="<?= $meta["meta_desc"] ?>">
    <meta name="twitter:image" content="<?= $meta["meta_img"] ?>">
    <meta name="keywords" content="<?= $meta["meta_keywords"] ?>">
    <title><?= isset($page) && isset($user_id) ? ENV['APP_NAME']." - $page" : ENV['APP_NAME'] ?></title>
    <link rel="icon" href="<?= FAVICON ?>" type="image/x-icon" sizes="32x32 16x16">
    <script src="<?= FONTAWESOME ?>" crossorigin="anonymous"></script>
    <script src="<?= TAILWIND ?>"></script>
    <?php if($page == "Settings" || $page == "Quality Assurance" || $page == "User Management" || $page == "Analytics"): ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <?php endif; ?>
    <link rel="stylesheet" href="<?= STYLES_CSS . '?v=' . (string)@filemtime(__DIR__ . '/../../../public/css/styles.css') ?>">
    <?php if($page == "Settings" || $page == "Quality Assurance" || $page == "User Management" || $page == "Analytics"): ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?= DATA_TABLE_CSS . '?v=' . (string)@filemtime(__DIR__ . '/../../../public/css/data_table.css') ?>">
    <?php endif; ?>
    <?php if($page == "" || $page == "Forgot Password" || $page == "Reset"): ?>
    <link rel="stylesheet" href="<?= LOGIN_CSS ?>">
    <?php endif; ?>
  </head>
  <body>
    <section class="relative flex min-h-screen max-h-[max-content] w-full bg-gray-200">
      <?php if(!empty($user_id)) include SIDEBAR; ?>
      <main class="flex min-w-0 flex-col flex-1 bg-white <?= !empty($user_id) ? 'm-[10px] rounded-lg md:w-[calc(100%-98px)] lg:w-[calc(100%-302px)]' : 'w-full'; ?>">
        <section class="relative flex min-w-0 flex-1 flex-col <?php if(!empty($user_id)) echo 'rounded-lg overflow-hidden'; ?>">
          <?php if(!empty($user_id)) include HEADER; ?>
          <?php require TOAST ?>
          <?php if(!empty($user_id)) echo '<div class="min-w-0 p-4 pt-2">'?>
