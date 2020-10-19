<?php
require_once 'functions/funct.php';
if (isset($_SESSION["admin_lost_found"])) {
    $person = $_SESSION["admin_lost_found"];
} else {
    return header('Location: login.php');
}
$app = new App();
$persons = $app->getLost();
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
            <div class="main-grids">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <h2>Lost Persons</h2>
                                <table class="table table-borderedtable-responsive">
                                    <thead>
                                        <th>Name</th>
                                        <th>Added by</th>
                                        <th>Place lost</th>
                                        <th>Residence</th>
                                        <th>Contact email</th>
                                        <th>Contact phone</th>
                                        <th>Explanation</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($persons as $key => $value) : ?>
                                            <tr>
                                                <td><?php echo htmlentities($value['name']); ?></td>
                                                <td><?php echo htmlentities($value['user']) ?></td>
                                                <td><?php echo htmlentities($value['place']) ?></td>
                                                <td><?php echo htmlentities($value['residence']) ?></td>
                                                <td><?php echo htmlentities($value['email']) ?></td>
                                                <td><?php echo htmlentities($value['phone']) ?></td>
                                                <td><?php echo htmlentities($value['comment']) ?></td>
                                                <?php if ($value['status'] !== '1') : ?>
                                                <td><a href="functions/controller.php?pid=<?php echo htmlentities($value['id'].'&tab=lost') ?>" class="btn btn-primary">Approve</a></td>
                                                <?php endif ?>
                                            </tr>
                                        <?php endforeach ?>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="col-md-3">
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
            </div>
        </div>
    </div>

    <div class="copy-section">

        <p>&copy; Lost and Found persons. </p>

    </div>
</body>

</html>