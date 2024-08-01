<?php
require "/xampp/htdocs/dms/partials/_dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $document_id = isset($_POST['document_id']) ? $_POST['document_id'] : '';

    if ($document_id) {
        $checkSql = "SELECT * FROM documents WHERE document_id = '$document_id'";
        $checkResult = mysqli_query($conn, $checkSql);

        if (mysqli_num_rows($checkResult) > 0) {
            $insertSql = "insert into document_approvals (document_id, approval_date, status) VALUES ('$document_id', NOW(), 'Rejected')";

            $result = mysqli_query($conn, $insertSql);
            $updateSql = "update documents set status = 'Rejected' where document_id = $document_id";
            $result2 = mysqli_query($conn, $updateSql);

            if ($result and $result2) {
                echo json_encode(['success' => true]);
                header("location: approver.php");
                exit();
            } else {
                echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Document ID does not exist']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No Document ID provided']);
    }
}