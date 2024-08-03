<?php
$rshowError = false;
$rshowAlert = false;
$lshowAlert = false;
include 'partials/_dbconnect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Registration Process
    if (isset($_POST["rusername"]) && isset($_POST["remail"]) && isset($_POST["rpassword"])) {
        $rusername = $_POST["rusername"];
        $remail = $_POST["remail"];
        $rpassword = $_POST["rpassword"];

        $query = "select * from `users` where username = '$rusername' and email = '$remail'";
        $result = mysqli_query($conn, $query);
        $numExistRows = mysqli_num_rows($result);
        if ($numExistRows >= 1) {
            $rshowError = true;
        } else {
            $hash = password_hash($rpassword, PASSWORD_DEFAULT);
            $reg = "INSERT INTO `users` (`username`, `email`, `type`, `password`, `date`) VALUES ('$rusername', '$remail', 'employee', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $reg);
            if ($result) {
                $rshowAlert = true;
            }
        }
    }
    //Login Process
    elseif (isset($_POST["lpassword"]) && isset($_POST["lemail"])) {
        $lemail =  $_POST["lemail"];
        $lpassword = $_POST["lpassword"];

        $query = "select * from `users` where email = '$lemail'";
        $result = mysqli_query($conn, $query);
        $numExistRows = mysqli_num_rows($result);
        if ($numExistRows == 1) {
            $row = mysqli_fetch_assoc($result);
            $tempUsername = $row['username'];
            if (password_verify($lpassword, $row['password'])) {
                if ($row['type'] == "admin") {
                    session_start();
                    $_SESSION['alert_shown1'] = false;
                    $_SESSION['loggedin'] = true;
                    $_SESSION['srno'] = $row['srno'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['date'] = $row['date'];
                    $_SESSION['status'] = "active";
                    header("location: /DMS/admin/admin.php");
                } elseif ($row['type'] == "employee") {
                    session_start();
                    $_SESSION['alert_shown2'] = false;
                    $_SESSION['loggedin'] = true;
                    $_SESSION['srno'] = $row['srno'];
                    $_SESSION['username'] = $tempUsername;
                    $_SESSION['status'] = "active";
                    header("location: /DMS/user/user.php");
                } elseif ($row['type'] == "officer") {
                    session_start();
                    $_SESSION['alert_shown3'] = false;
                    $_SESSION['loggedin'] = true;
                    $_SESSION['srno'] = $row['srno'];
                    $_SESSION['username'] = $tempUsername;
                    $_SESSION['status'] = "active";
                    header("location: /DMS/approver/approver.php");
                } else {
                    $lshowAlert = true;
                }
            } else {
                $lshowAlert = true;
            }
        } else {
            $lshowAlert = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocStream</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/DMS/style.css">
</head>

<body>
    <header>
        <a href="index.php" style="text-decoration: none;">
            <h2 class="logo"><span style="color: rgb(13, 5, 54); font-weight: bold;">Doc</span>Stream</h2>
        </a>
        <nav class="navigation">
            <a href="/DMS/partials/_about.php">About</a>
            <button class="btnLogin-popup">Login/SignUp</button>
        </nav>
    </header>
    <?php
    if ($rshowAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show alert-top mb-0" role="alert">
        <strong>Success! </strong>You are successfully registered. Please Login.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        $rshowAlert = false;
    }
    if ($rshowError) {
        echo '<div class="alert alert-danger alert-dismissible fade show alert-top mb-0" role="alert">
        <strong>Error! </strong>The account you are tyring to register already exists. Try different Username or Email.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        $rshowError = false;
    }
    if ($lshowAlert) {
        echo '<div class="alert alert-danger alert-dismissible fade show alert-top mb-0" role="alert">
        <strong>Error! </strong>Invalid login Credentials.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        $lshowAlert = false;
    }

    ?>

    <div class="wrapper">
        <!-- Login form -->
        <div class="form-box login">
            <h2>Login</h2>
            <form action="/DMS/index.php" method="POST">
                <div class="input-box">
                    <input type="email" placeholder="Email" name="lemail" required>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Password" name="lpassword" required>
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="login-register">
                    <p>Don't have an account?<a href="#" class="register-link">Register</a></p>
                    <p class="text-center "><hr></p>
                    <p>Forgot password?<a href="#" class="register-link" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Reset password</a></p>
                </div>
            </form>
        </div>
        <!-- Registration form -->
        <div class="form-box register">
            <h2>Registration</h2>
            <form action="/DMS/index.php" method="POST">
                <div class="input-box">
                    <input type="text" placeholder="Username" name="rusername" required>
                </div>
                <div class="input-box">
                    <input type="email" placeholder="Email" name="remail" required>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Password" name="rpassword" required>
                </div>
                <button type="submit" class="btn">Register</button>
                <div class="login-register">
                    <p>Already have an account?<a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Password Reset</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="/DMS/index.php" method="POST" id="myForm">
                        <!-- <p class="container text-center success my-2 bg-success text-light px-0 w-75 mx-auto rounded d-none" name="resetMessage">A Email has been sent to your inbox.</p> -->
                        <div class="mb-2">
                            <label for="recipient-name" class="col-form-label">Registered Email</label>
                            <input type="email" name="emailCpy" class="form-control" id="recipient-name" required>
                            <button type="submit" name="resetSubmit" class="btn btn-primary mt-4">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
        include 'partials/_dbconnect.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if (isset($_POST["emailCpy"]) && isset($_POST["resetSubmit"]))
            {
                $resetEmailOne =  $_POST["emailCpy"];
                $query = "select * from `users` where email = '$resetEmailOne'";
                $result = mysqli_query($conn, $query);
                $numExistRows = mysqli_num_rows($result);
                if ($numExistRows == 1)
                {
                    include 'reset/sendEmail.php';
                    resetPasswordOnly();
                    $mailSentOrNo;
                    if ($mailSentOrNo)
                    {
                        echo '<div class="alert alert-success alert-dismissible fade show alert-top mb-0" role="alert">
                                <strong>Success! </strong>Email has been sent to your inbox.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                    } 
                    else
                    {
                        echo '<div class="alert alert-danger alert-dismissible fade show alert-top mb-0" role="alert">
                                <strong>Error! </strong>Something went wrong. Email could not be sent.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                    }
                }
                else
                {
                    echo '<div class="alert alert-danger alert-dismissible fade show alert-top mb-0" role="alert">
                            <strong>Error! </strong>Entered email is not registered. Please correct the email.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                }
                
            }
        }
    ?>


    <!-- <div class="tempo">
        <p>Demo buttons(will remove later): </p>
        <a href="/DMS/admin/admin.php"><button class="tempo-admin">Admin</button></a>
        <a href="/DMS/user/user.php"><button class="tempo-user">User</button></a>
        <a href="/DMS/approver/approver.php"><button class="tempo-approver">Approver</button></a>
    </div> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/DMS/script.js"></script>
</body>

</html>