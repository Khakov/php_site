<html>
<head>
    <meta charset="utf-8">
    <title>MVC PHP</title>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
    <link rel="stylesheet" href="/css/main.css">
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