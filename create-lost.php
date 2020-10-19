<?php
session_start();
if (isset($_SESSION["admin_lost_found"])) {
    $person = $_SESSION["admin_lost_found"];
} elseif (isset($_SESSION["user_lost_found"])) {
    $person = $_SESSION["user_lost_found"];
} else {
    header('Location: login.php');
}

?>
<!DOCTYPE HTML>
<html>

<head>
    <title>LOST | FOUND</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <link href='//fonts.googleapis.com/css?family=Quattrocento+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
</head>

<body>
    <div class="header-section">
        <div class="container">
            <div class="logo">
                <a href="index.html" class="logo-content">
                    <h1>LOST AND FOUND PERSONS</h1>
                </a>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="">
                            <div class="login-form">
                                <h4>Add lost person</h4>
                                <form action="functions/controller.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Name</label>
                                                <input type="text" class="form-control" name="fname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Place lost</label>
                                                <input type="text" class="form-control" name="place" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Place of residence</label>
                                                <input type="text" class="form-control" name="rplace" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Contact email</label>
                                                <input type="email" class="form-control" name="email" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Contact Phone</label>
                                                <input type="text" class="form-control" name="phone" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="comment">More Information</label>
                                                <textarea class="form-control" name="comment" required></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Date Lost</label>
                                                <input type="date" class="form-control" name="date" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Photos</label>
                                                <input type="file" name="image[]" id="" multiple required>
                                            </div>
                                        </div>
                                        <input type="submit" value="submit" name="create_lost">
                                    </div>
                                </form>
                                <p>Already have an account?<a href="login.php" class="btn btn-link">login</a></p>
                            </div>
                        </div>
                    </div>
                <div class="col-md-4">
                    <aside>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="create-lost.php">Add lost persons</a></li>
                            <li><a href="create-found.php">Add found persons</a></li>
                            <li><a href="found_persons.php">Found persons</a></li>
                            <li><a href="lost_persons.php">Lost persons</a></li>
                            <?php if (isset($_SESSION['user_lost_found']) || isset($_SESSION['admin_lost_found'])) : ?>
                                <li><a href="functions/logout.php">Logout</a></li>
                            <?php else : ?>
                                <li><a href="register.php">Register</a></li>
                                <li><a href="login.php">Login</a></li>
                            <?php endif ?>
                        </ul>
                    </aside>
                </div>
            </div>


        </div>
    </div>
    <div class="copy-section">
        <p>&copy; Lost And Found persons. </p>
    </div>
</body>

</html>