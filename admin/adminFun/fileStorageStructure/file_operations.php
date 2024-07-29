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
            $stmt = $conn->prepare("DELETE FROM documents WHERE file_path LIKE ?");
            $searchPath = $path . '%';
            $stmt->bind_param("s", $searchPath);
            $stmt->execute();
        }
        return $deleted;
    } elseif (is_file($path)) {
        $deleted = unlink($path);
        if ($deleted) {
            $stmt = $conn->prepare("DELETE FROM documents WHERE file_path = ?");
            $stmt->bind_param("s", $path);
            $stmt->execute();
        }
        return $deleted;
    }
    return false;
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

            $stmt = $conn->prepare("INSERT INTO documents (title, description, file_path, file_type, upload_date, uploaded_by, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssis", $title, $description, $destPath, $fileType, $uploadDate, $uploadedBy, $status);
            return $stmt->execute();
        }
    }
    return false;
}
?>
