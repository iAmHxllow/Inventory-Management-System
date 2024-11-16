<?php

function setHead($pageTitle = 'QuickBuy', $favicon = 'assets/img/logo.svg', $styles = 'assets/style.css', $scripts = 'assets/script.js') {
    echo "
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>$pageTitle - QuickBuy</title>
    <link rel='shortcut icon' href='$favicon' type='image/x-icon'>
    <link rel='stylesheet' href='$styles'>
    <script src='$scripts'></script>
    ";
}
?>
