<?php

//@include 'config.php';
include '../partials/_dbconnect.php';

session_start();

$email = $_SESSION["email"];

if (isset($_POST['submit'])) {

   $email = $_SESSION["email"];
   $otp_entered = $_POST["otp"];

   // Retrieve user data from the database based on the email
   $stmt = mysqli_query($conn, "SELECT * FROM `otps` WHERE email = '$email'") or die('query failed');


   //   $result = $stmt->get_result();

   if (mysqli_num_rows($stmt) > 0) {
      $row = mysqli_fetch_assoc($stmt);
      $db_otp = $row["otp"];

      if ($otp_entered == $db_otp) {
         // OTP is correct; registration is complete
         // Clear session data
         $email = $email;
         // Generate a random 6-digit OTP
         $status = "active";
         $status2 = 1;

         $query = mysqli_query($conn, "UPDATE `users` SET status = '$status', status2 = '$status2' WHERE email = '$email'") or die('query failed');


         if (!$query) {
            die("Error in SQL query: " . $mysqli->error);
         }
         $stmt->close();

         $message[] = "OTP verification successful.";
         // unset($_SESSION["email"]);
         $_SESSION["email"] = $email;
         header("Location: /DMS/index.php");
      } else {
         $message[] = "Incorrect OTP. Please try again.";
         $_SESSION["email"] = $email;
         header("Location: otp.php");
      }
   } else {
      $_SESSION["error_message"] = "Invalid email address.";
      $_SESSION["email"] = $email;
      header("Location: otp.php");
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <!-- custom css file link  -->
   <!---<link rel="stylesheet" href="style.css">---->
   <style>
      body {
         min-height: 100vh;
         background: url(back1.jpg) no-repeat;
         background-size: cover;
         background-position: center;
      }

      .heading {
         font-size: xx-large;
      }
   </style>

</head>

<body>
   <!-- As a heading -->
   <nav class="navbar bg-body-tertiary shadow">
      <div class="container-fluid">
         <a class="navbar-brand" draggable="true" style="font-size: 27px; color: navy;">
            <span style="color: rgb(13, 5, 54); font-weight: bold;">Doc</span>Stream
         </a>
      </div>
   </nav>
   <div class="alert alert-success text-center shadow" role="alert">
      OTP has been sent to your registered Email. Please enter the correct OTP in the field provided below.
   </div>

   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
      }
   }
   ?>

   <section class="form-container p-5 mt-5 rounded-5">

      <form action="" method="post">
         <input type="hidden" name="email" class="box" value="<?php echo $email; ?>" required>
         <div class="row mb-3">
            <div class="col-md-8">
               <div class="input-group">
                  <span class="input-group-text" id="inputGroup-sizing-default">Enter OTP</span>
                  <input type="text" name="otp" class="form-control shadow" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
               </div>
            </div>
            <div class="col-md-4">
               <button class="btn btn-primary w-100 shadow" type="submit" name="submit">Verify</button>
            </div>
         </div>
      </form>

   </section>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>