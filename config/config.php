<?php
$ENV = parse_ini_file(__DIR__ . '/../.env', true, INI_SCANNER_TYPED);

ini_set('date.timezone', 'Asia/Manila');
date_default_timezone_set('Asia/Manila');

// App Environment
define("ENV", $ENV);
define("VER", ENV["APP_VERSION"]);
define("ENVIRONMENT", ENV["APP_ENV"]);
define("DEBUG", ENV["APP_DEBUG"]);

// Path and Url
define('BASE_URL', strpos($_SERVER['REQUEST_URI'], 'Project_Management') !== false ? 'http://localhost/Project_Management' : ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' . $_SERVER['HTTP_HOST'] : 'http://' . $_SERVER['HTTP_HOST']));
define("BASE_PATH",dirname(__DIR__)."/");

if (DEBUG) {
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  ini_set('log_errors', 1);
  ini_set('error_log', BASE_PATH.'/php-error.log');
}

// Config Files
define("CONFIG_PATH",BASE_PATH."config/");
define("SESSION_CONFIG",CONFIG_PATH."session.php");
define("AUTOLOAD_CONFIG", CONFIG_PATH."autoload.php");
define("META_CONFIG", CONFIG_PATH."meta.php");

// CSS Files
define("CSS_URL",BASE_URL."/public/css/");
define("STYLES_CSS",CSS_URL."styles.css?v=".VER);
define("LOGIN_CSS",CSS_URL."login.css?v=".VER);
define("FORGOT_PASSWORD_CSS",CSS_URL."forgot_password.css?v=".VER);
define("ACCOUNT_CSS",CSS_URL."account.css?v=".VER);
define("SETTINGS_CSS",CSS_URL."settings.css?v=".VER);
define("DATA_TABLE_CSS", CSS_URL."data_table.css?v=".VER);
define("RESEARCH_CSS", CSS_URL."research.css?v=".VER);
define("NOTIFICATIONS_CSS",CSS_URL."notifications.css?v=".VER);
define("ANALYTICS_CSS", CSS_URL."analytics.css?v=".VER);

// JS Files
define("JS_URL",BASE_URL."/public/js/");
define("LOGIN_JS",JS_URL."login.js?v=".VER);
define("FORGOT_PASSWORD_JS",JS_URL."forgot_password.js?v=".VER);

// Framework / Libraries
define("FONTAWESOME", "https://kit.fontawesome.com/828a48be28.js");
define("TAILWIND", "https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4");

// Icon & Images
define("IMAGES_URL",BASE_URL."/public/images/");
define("FAVICON", IMAGES_URL."favicon.ico");
define("OG_LOGO", IMAGES_URL."og_logo.png");
define("LOGO", IMAGES_URL."logo.webp");

// Uploads
define("UPLOADS", BASE_URL."/public/uploads/");
define("PROFILE_PICS", UPLOADS."profile_pictures/");

// Components
define("COMPONENTS_PATH", BASE_PATH."app/Views/Components/");
define("TOAST", COMPONENTS_PATH."ToastMessage.php");
define("MAILER_BODY", COMPONENTS_PATH."MailBody.php");
define("MODAL", COMPONENTS_PATH."Modal.php");
define("SPINNER", COMPONENTS_PATH."Spinner.php");
define("SIDEBAR", COMPONENTS_PATH."Sidebar.php");
define("HEADER", COMPONENTS_PATH."Header.php");
define("FOOTER", COMPONENTS_PATH."Footer.php");

// Layouts
define("LAYOUTS_PATH", BASE_PATH."app/Views/Layouts/");
define("HEAD", LAYOUTS_PATH."Head.php");
define("FOOT", LAYOUTS_PATH."Foot.php");

// Pages
define("PAGE_PATH",BASE_PATH."/app/Views/Pages/");
define("LOGIN",PAGE_PATH."Login.php");
define("FORGOT_PASSWORD",PAGE_PATH."ForgotPassword.php");
define("RESET",PAGE_PATH."Reset.php");
