<?php
session_start();
//DATABASE CONNECTION
include '/xampp/htdocs/dms/partials/_dbconnect.php';

// Retrieve document_id from URL parameter
if (isset($_GET['document_id'])) {
    $document_id = $_GET['document_id'];
} else {
    echo "Error: Document ID not specified.";
    exit();
}

// Fetch document details
$sql = "SELECT * FROM `documents` WHERE `document_id` = $document_id";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) == 0) {
    echo "Error: Document not found.";
    exit();
}
$document = mysqli_fetch_assoc($result);
$document_title = $document['title'];
$file_type = "." . $document['file_type'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $access_type = $_POST['access_type'];
    $access_granted_by = $_SESSION['srno'];

    // Check if an entry already exists
    $sql_check = "SELECT * FROM `access_control` WHERE `user_id` = $user_id AND `document_id` = $document_id";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Update existing entry
        $sql_update = "UPDATE `access_control` SET `access_type` = '$access_type', `access_granted_by` = $access_granted_by, `granted_date` = current_timestamp() WHERE `user_id` = $user_id AND `document_id` = $document_id";
        if (mysqli_query($conn, $sql_update)) {
            echo '<div class="alert alert-success alert-dismissible fade show alert-top mb-0" role="alert">
            <strong>Success! </strong>Access control updated successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show alert-top mb-0" role="alert">
            <strong>Error! </strong>Error updating access control:
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>' . mysqli_error($conn);
        }
    } else {
        // Insert new entry
        $sql_insert = "INSERT INTO `access_control` (`user_id`, `document_id`, `access_type`, `access_granted_by`)
                       VALUES ($user_id, $document_id, '$access_type', $access_granted_by)";
        if (mysqli_query($conn, $sql_insert)) {
            echo '<div class="alert alert-success alert-dismissible fade show alert-top mb-0" role="alert">
            <strong>Success! </strong>Access control updated successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show alert-top mb-0" role="alert">
            <strong>Error! </strong>Error updating access control:
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Control - <?php echo $document_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php
    include '/xampp/htdocs/dms/admin/adminExtra/_Aheader.php';
    ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Access Control for Document: <span class="text-primary"><?php echo $document_title . $file_type; ?></span></h2>
        <form method="post">
            <div class="mb-3">
                <label for="user_id" class="form-label">Select User</label>
                <select class="form-select" id="user_id" name="user_id" required>
                    <?php
                    // Fetch employees
                    $sql_users = "SELECT * FROM `users` WHERE `type` = 'Employee'";
                    $result_users = mysqli_query($conn, $sql_users);
                    while ($row_user = mysqli_fetch_assoc($result_users)) {
                        echo '<option value="' . $row_user["srno"] . '">' . $row_user["srno"] . ' - ' . $row_user["username"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="access_type" class="form-label">Access Type</label>
                <select class="form-select" id="access_type" name="access_type" required>
                    <option value="View Only">View Only</option>
                    <option value="View and Download">View and Download</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
