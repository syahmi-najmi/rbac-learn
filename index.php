<?php 
    session_start ();

    require_once('config.php'); //include database configuration.

    if(isset($_POST['login']))
    {
        if(!empty($_POST['email']) && !empty($_POST['password']))
        { //sanitize and trim user input
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

        // use prepared statement to prevent sql injection
        $sql = "Select * from tbl_users WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bin_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1 ) {
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
    if (isset($_GET['lmsg']) && $_GET['lsmg'] == true) {
        $errorMsg = "Login required to access the dashboard.";
    }
?>