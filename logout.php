<?php
session_start();
// DATABASE CONNECTION
include '/xampp/htdocs/dms/partials/_dbconnect.php';

if (isset($_SESSION['srno'])) {
    $srno = $_SESSION['srno'];
    
    //TO MAKE STATUS INACTIVE
    $stmt = $conn->prepare("UPDATE users SET status = 'inactive' WHERE srno = ?");
    $stmt->bind_param("i", $srno);

    if ($stmt->execute()) {
        //SUCCESSFULL
        $stmt->close();
    } else {
        //UNSUCCESSFULL, DISPLAY ERROR
        echo "Error updating status: " . $conn->error;
    }
}

//UNSET AND DESTROY SESSION VARIABLES
session_unset();
session_destroy();

//GOTO INDEX.PHP
header("location: index.php");
exit;
?>
