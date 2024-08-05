<?php
session_start();
require "/xampp/htdocs/dms/partials/_dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $remarks = $_POST['approvalRemarks'];
    $approved_by = $_SESSION['srno'];
    $document_id = isset($_POST['document_id']) ? $_POST['document_id'] : '';

    if ($document_id) {
        $checkSql = "SELECT * FROM documents WHERE document_id = '$document_id'";
        $checkResult = mysqli_query($conn, $checkSql);

        if (mysqli_num_rows($checkResult) > 0) {
            $updateSql = "update document_approvals set status = 'Approved' , approved_by = $approved_by where document_id = $document_id";
            $result = mysqli_query($conn, $updateSql);

            $auditSql = "insert into audit_logs (user_id, action, details) values ('$approved_by', 'Approved', '$remarks')";
            $auditResult = mysqli_query($conn, $auditSql);

            if ($result and $auditResult) {
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
