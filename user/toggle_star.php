<?php
session_start();
include '../partials/_dbconnect.php';

// Ensure user is logged in
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['srno'])) {
    header("Location: /DMS/index.php");
    exit();
}

$user_id = $_SESSION['srno'];
$document_id = $_POST['document_id'];

// Create a new connection using mysqli
$conn = new mysqli('127.0.0.1', 'root', '', 'dms');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the document is already starred by the user
$stmt = $conn->prepare("SELECT * FROM starred_documents WHERE user_id = ? AND document_id = ?");
$stmt->bind_param('ii', $user_id, $document_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If already starred, unstar it
    $stmt = $conn->prepare("DELETE FROM starred_documents WHERE user_id = ? AND document_id = ?");
} else {
    // If not starred, star it
    $stmt = $conn->prepare("INSERT INTO starred_documents (user_id, document_id) VALUES (?, ?)");
}

$stmt->bind_param('ii', $user_id, $document_id);
$stmt->execute();

// Close the connection
$stmt->close();
$conn->close();

header("Location: /DMS/user/user.php");
exit();
?>
