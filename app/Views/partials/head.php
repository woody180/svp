<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="baseurl" content="<?= baseUrl() ?>">
    <meta name="description" content="<?= $description ?? '' ?>">
    
    <?= $this->section('og_meta') ?>

    <link rel="stylesheet" href="<?= assetsUrl('css/uikit.min.css') ?>">
    <link rel="stylesheet" href="<?= assetsUrl('css/main.min.css') ?>">
    
    <?php if (checkAuth([1])): ?>
        <link rel="stylesheet" href="<?= assetsUrl('tinyeditor/plugins/jqueryui/css/jquery-ui.css') ?>">
        <link rel="stylesheet" href="<?= assetsUrl('tinyeditor/filemanager/filemanager.css') ?>">
        <link rel="stylesheet" href="<?= assetsUrl('tinyeditor/filemanager/css/elfinder.min.css') ?>">
        <link rel="stylesheet" href="<?= assetsUrl('tinyeditor/filemanager/css/theme.css') ?>">
        
        <script src="<?= assetsUrl('tinyeditor/plugins/jqueryui/js/jquery-3.6.0.min.js') ?>"></script>
        <script src="<?= assetsUrl('tinyeditor/plugins/jqueryui/js/jquery-ui.js') ?>"></script>
    <?php endif; ?>

    <script src="<?= assetsUrl('js/uikit.min.js') ?>"></script>
    <script src="<?= assetsUrl('js/uikit-icons.min.js') ?>"></script>
    
    <title><?= $title ?? APPNAME; ?></title>
</head>
<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v15.0&appId=924579455025809&autoLogAppEvents=1" nonce="50ClvvFV"></script>

    <?php $this->insert('partials/header') ?>