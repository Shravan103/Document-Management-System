<?php
$duplicateError = false;
$samepassword =false;
$changeSuccess = false;
include '../partials/_dbconnect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["resetEmail"]) && isset($_POST["resetPassword"]) && isset($_POST["resetCPassword"])) {
        $resetEmail = $_POST["resetEmail"];
        $resetPassword = $_POST["resetPassword"];
        $resetCPassword = $_POST["resetCPassword"];
        $query = "select * from `users` where email = '$resetEmail'";
        $result = mysqli_query($conn, $query);
        $numExistRows = mysqli_num_rows($result);
        if ($numExistRows == 1)
        {
            if($resetPassword==$resetCPassword)
            {
                // $row = mysqli_fetch_assoc($result);
                $hash = password_hash($resetPassword, PASSWORD_DEFAULT);
                $sql = "UPDATE `users` SET `password` = '$hash' WHERE `users`.`email` = '$resetEmail'";
                $result = mysqli_query($conn, $sql);
                if ($result)
                {
                    $changeSuccess = true;
                }
            }
            else
            {
                $samepassword =true;
            }

        }
        else
        {
            $duplicateError = true;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocStream - Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
    if ($changeSuccess) {
        echo '<div class="alert alert-success alert-dismissible fade show alert-top mb-0" role="alert">
        <strong>Success! </strong>Password changed successfully. Please Login.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if ($samepassword) {
        echo '<div class="alert alert-danger alert-dismissible fade show alert-top mb-0 " role="alert">
        <strong>Error! </strong>See to it that the <strong>New Password</strong> must be same as <strong>Confirm Password</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if ($duplicateError) {
        echo '<div class="alert alert-danger alert-dismissible fade show alert-top mb-0 " role="alert">
        <strong>Error! </strong>Entered Email has not been registered. Please register first.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    ?>
    <div class="py-4">
        <div class="container my-5 py-5 w-50 shadow bg-light">
            <h2 class="text-center text-primary">Reset Password</h2>
            <div id="emailHelp" class="form-text text-center">Fill the below details correctly to successfully change your password.</div>
            <hr>
            <form action="resetpassword.php" method="POST">
                <div class="mb-3 mt-3">
                    <label for="exampleInputEmail1" class="form-label">Registered Email</label>
                    <input type="email" name="resetEmail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">New Password</label>
                    <input type="password" name="resetPassword" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                    <input type="password" name="resetCPassword" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                    <label class="form-check-label" for="exampleCheck1">Are you sure you want to change your password</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>