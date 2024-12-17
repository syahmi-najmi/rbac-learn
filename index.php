<?php
session_start();

require_once('config.php'); //include database configuration.

if (isset($_POST['login'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) { //sanitize and trim user input
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // use prepared statement to prevent sql injection
        $sql = "Select * from tbl_users WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bin_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                //verify the password using password_verify()
                if (password_verify($password, $user['password'])) {
                    unset($user['password']);
                    $_SESSION = $user;

                    //redirect to dashboard
                    header('location:dashboad.php');
                    exit;
                } else {
                    $errorMsg = "Wrong email or password";
                }
            } else {
                $errorMsg = "Wrong email or password";
            }

            $stmt->close();
        } else {
            $errorMsg = "Database query failed";
        }
    } else {
        $errorMsg = "Please fill in the both email and password";
    }
}

// handle logout
if (isset($_GET['logout']) && $_GET['logout'] == true) {
    session_destroy();
    header("location:index.php");
    exit;
}

//handle access errors
if (isset($_GET['Imsg']) && $_GET['Ismg'] == true) {
    $errorMsg = "Login required to access the dashboard.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Simple role based access control example using php and mysqli</title>
    <!-- Bootstrap core CSS-->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Login</div>
            <div class="card-body">
                <?php
                if (isset($errorMsg)) {
                    echo '<div class="alert alert-danger">';
                    echo $errorMsg;
                    echo '</div>';
                    unset($errorMsg);
                }
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input class="form-control" id="exampleInputEmail1" name="email" type="email"
                            placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input class="form-control" id="exampleInputPassword1" name="password" type="password"
                            placeholder="Password" required>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit" name="login">Login</button>
                </form>

            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>