<?php
include '/xampp/htdocs/dms/partials/_dbconnect.php';
$rootPath = '/xampp/htdocs/dms/filesTemp';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operation = $_POST['operation'];
    $path = $_POST['path'] ?? '';

    switch ($operation) {
        case 'delete':
            $result = deletePath($path);
            echo json_encode(['status' => $result ? 'success' : 'error']);
            break;
        case 'create_folder':
            $folderName = $_POST['folder_name'] ?? '';
            $result = createFolder($path, $folderName);
            echo json_encode(['status' => $result ? 'success' : 'error']);
            break;
        case 'upload_file':
            $uploadResult = uploadFile($path);
            echo json_encode(['status' => $uploadResult ? 'success' : 'error']);
            break;
    }
}

function normalizePath($path) {
    return str_replace('\\', '/', $path);
}

function deletePath($path) {
    global $conn;
    
    $path = normalizePath($path);
    
    if (is_dir($path)) {
        $files = array_diff(scandir($path), ['.', '..']);
        foreach ($files as $file) {
            $filePath = "$path/$file";
            deletePath($filePath); // Recursively delete files and folders
        }
        $deleted = rmdir($path);
        if ($deleted) {
            // Normalize path for database search
            $searchPath = $path . '%';
            $stmt = $conn->prepare("SELECT document_id FROM documents WHERE file_path LIKE ?");
            $stmt->bind_param("s", $searchPath);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $document_id = $row['document_id'];
                deleteDocumentDependencies($document_id);
            }
        }
        return $deleted;
    } elseif (is_file($path)) {
        $deleted = unlink($path);
        if ($deleted) {
            $stmt = $conn->prepare("SELECT document_id FROM documents WHERE file_path = ?");
            $stmt->bind_param("s", $path);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $document_id = $result->fetch_assoc()['document_id'];
                deleteDocumentDependencies($document_id);
            }
        }
        return $deleted;
    }
    return false;
}

function deleteDocumentDependencies($document_id) {
    global $conn;
    // Delete records from document_approvals
    $stmt = $conn->prepare("DELETE FROM document_approvals WHERE document_id = ?");
    $stmt->bind_param("i", $document_id);
    $stmt->execute();
    
    // Delete records from access_control
    $stmt = $conn->prepare("DELETE FROM access_control WHERE document_id = ?");
    $stmt->bind_param("i", $document_id);
    $stmt->execute();
    
    // Finally, delete the document record
    $stmt = $conn->prepare("DELETE FROM documents WHERE document_id = ?");
    $stmt->bind_param("i", $document_id);
    $stmt->execute();
}

function createFolder($path, $folderName) {
    $fullPath = $path . '/' . $folderName;
    if (!file_exists($fullPath)) {
        return mkdir($fullPath, 0777, true);
    }
    return false;
}

function uploadFile($path) {
    global $conn;

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $destPath = normalizePath($path . '/' . $fileName);

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $fileType = $_POST['file_type'];
            $uploadedBy = $_POST['uploaded_by'];
            $status = $_POST['status'];
            $uploadDate = date('Y-m-d H:i:s');

            // Insert into documents table
            $stmt = $conn->prepare("INSERT INTO documents (title, description, file_path, file_type, upload_date, uploaded_by, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssis", $title, $description, $destPath, $fileType, $uploadDate, $uploadedBy, $status);
            $stmt->execute();
            $document_id = $stmt->insert_id;

            // Insert into access_control table
            // $accessType = 'View and Download'; // Default access type
            // $accessEmployee = 21;   //Static assignment, will remove later
            // $stmt = $conn->prepare("INSERT INTO access_control (user_id, document_id, access_type, access_granted_by) VALUES (?, ?, ?, ?)");
            // $stmt->bind_param("iisi", $accessEmployee, $document_id, $accessType, $uploadedBy);
            // $stmt->execute();

            // Insert into document_approvals table
            $approvalStatus = 'Pending'; // Default approval status
            $stmt = $conn->prepare("INSERT INTO document_approvals (document_id, approval_date, status) VALUES (?, ?, ?)");
            $approvalDate = $uploadDate;
            $stmt->bind_param("iss", $document_id, $approvalDate, $approvalStatus);
            return $stmt->execute();
        }
    }
    return false;
}
?>
