<?php
session_start();
if (isset($_SESSION["admin_lost_found"]) || isset($_SESSION["user_lost_found"])) {
    return header('Location: index.php');
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
    <div class="">
        <div class="container">

            <div class="main-grids">
                <div class="row">
                <div class="col-md-2"></div>
                    <div class="col-md-6 login-form">
                        <h4>Register</h4>
                        <form action="functions/controller.php" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">ID NO.</label>
                                        <input type="text" class="form-control" name="id_no" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Full Name</label>
                                        <input type="text" class="form-control" name="fname" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" name="phone" require>
                                    </div>
                                </div>
                                <input type="hidden" name="role" value="admin">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="password" class="form-control" name="password" require>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Confirm Password</label>
                                        <input type="password" class="form-control" name="cpassword" require>
                                    </div>
                                </div>
                                <input type="submit" name="register" value="Register">
                            </div>
                        </form>
                        <p>Already have an account?<a href="login.php" class="btn btn-link">login</a></p>
                    </div>

                    <div class="col-md-4">
                        <div class="sideways">
                            <aside>
                                <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="create-lost.php">Add lost persons</a></li>
                                    <li><a href="create-found.php">Add found persons</a></li>
                                    <li><a href="found_persons.php">Found persons</a></li>
                                    <li><a href="lost_persons.php">Lost persons</a></li>
                                    <?php if (isset($_SESSION['user_lost_found']) || isset($_SESSION['admin_lost_found'])) : ?>
                                        <?php if (isset($_SESSION['admin_lost_found'])) : ?>
                                            <li><a href="manage-lost.php">Manage lost persons</a></li>
                                            <li><a href="manage-found.php">Manage found persons</a></li>
                                        <?php endif ?>
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

                <p>&copy; Lost and Found persons. </p>

            </div>

        </div>
    </div>
</body>

</html>