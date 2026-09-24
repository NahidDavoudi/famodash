<?php
require_once __DIR__ . '/../../shared/php/config.php';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#445D84">
    <title>پنل کاربری- آموزشگاه فامو</title>
    <?php echo famo_config_script(); ?>
    <link rel="stylesheet" href="<?php echo famo_asset('css/output.css', '../../shared/css/output.css'); ?>">
    <link rel="stylesheet" href="<?php echo famo_asset('css/fonts.css', '../../shared/css/fonts.css'); ?>">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <script src="<?php echo famo_asset('js/libs/apexcharts.min.js', '../../shared/js/libs/apexcharts.min.js'); ?>"></script>
    <script src="<?php echo famo_asset('js/libs/lucide.min.js', '../../shared/js/libs/lucide.min.js'); ?>"></script>
    <script src="<?php echo famo_asset('js/lucide-adapter.js', '../../shared/js/lucide-adapter.js'); ?>"></script>
    <script type="module" src="../assets/js/app.js"></script>
</head>
<body>
<div id="sidebarOverlay"></div>
<header id="mobileHeader">
            <button id="mobileMenuBtn" type="button" aria-label="منو">
                <svg class="icon w-6 h-6" aria-hidden="true"><use href="../assets/icons/sprite.svg#icon-menu"/></svg>
            </button>
            <h1 class="font-bold" style="font-size: 1.05rem;">پنل کاربری فامو</h1>
</header>
