<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/dd061e632d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title><?= $templateTitle ?></title>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a href="#" class="navbar-brand">My Blog</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#myNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="myNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <?php if (!empty($user)): ?>
                    <a href="#" class="nav-link">
                        <i class="fas fa-user-circle"></i>
                        <?= $user->getNickName() ?>
                    </a>
                <li class="nav-item">
                    <a href="users/logout" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>Logout
                    </a>
                </li>
                <?php else: ?>
                    <a href="users/login" class="nav-link">
                        <i class="fas fa-user-circle"></i>
                        Login
                    </a>
                <?php endif ?>

                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">About</a>
                </li>
            </ul>
        </div>
    </div>
</nav>