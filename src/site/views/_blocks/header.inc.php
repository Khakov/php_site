<html>
<head>
    <meta charset="utf-8">
    <link href="/css/bootstrap.css" rel="stylesheet">
    <script src="/js/jquery.js"></script>
    <script src="/js/bootstrap.js"></script>
    <link href="/css/summernote.css" rel="stylesheet">
    <script src="/js/summernote.js"></script>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>

<!-- Top Menu -->
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/">Home</a></li>
                <?php
                if (!empty($user)) {
                    ?>
                    <li><a href="/profile">My Profile</a></li>
                    <li><a href="/logout">Exit</a></li>
                    <?php
                } else {
                    ?>
                    <li><a href="/registration">registration</a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Centered Pane -->
<div class="main-pane">