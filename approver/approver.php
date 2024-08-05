<?php
session_start();
$srno = $_SESSION['srno'];
require "/xampp/htdocs/dms/partials/_dbconnect.php";
if (!isset($_SESSION['loggedin']) || ($_SESSION['loggedin'])!=true){
    header("location: ../index.php");
}

//SET STATUS TO ACTIVE
if (isset($_SESSION['srno']))
{
    //TO MAKE STATUS ACTIVE
    $stmt = $conn->prepare("UPDATE users SET status = 'active' WHERE srno = ?");
    $stmt->bind_param("i", $srno);
    $stmt->execute();
}

elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $title = $_POST['documentTitle'];
    $description = $_POST['documentDescription'];
    $fileType = $_FILES['formFile']['type'];


    // Handle file upload
    if (isset($_FILES['formFile']) || $_FILES['formFile']['error'] == 0) {
        $file = $_FILES['formFile'];
        $fileName = mysqli_real_escape_string($conn, $file['name']);
        $fileTmpName = $file['tmp_name'];
        $uploadDir = '/xampp/htdocs/dms/filesTemp/';
        $uploadFile = $uploadDir . basename($fileName);

        if (move_uploaded_file($fileTmpName, $uploadFile)) {
            $sql = "INSERT INTO documents (title, description, file_type, file_path, uploaded_by) VALUES ('$title', '$description', '$fileType', '$uploadFile', '$srno')";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                echo "Error: " . mysqli_error($conn);
            } else {
                $document_id = mysqli_insert_id($conn);
                $sql = "insert into document_approvals (document_id) values ($document_id)";
                $result = mysqli_query($conn, $sql);
                echo '
                    <div class="modal fade" id="uploadSuccessModal" tabindex="-1" aria-labelledby="uploadSuccessModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadSuccessModalLabel">Upload Successful</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Document uploaded successfully.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "No file was uploaded or there was an upload error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/DMS/approver/approver.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <title>Approval Section</title>

    <style>
        body{
            padding-top: 57px;
        }
        .hidden {
            display: none;
        }

        .sidebar a.active {
            background-color: #1abc9c;
        }
    </style>

</head>

    <!-- NAVBAR -->
    <?php
        $navbarTitle = "Approver Dashboard";
        $navbarHref = './approver.php';
        require 'C:/xampp/htdocs/dms/partials/_header.php';
        if (!$_SESSION['alert_shown3']) {
            echo '<div class="alert alert-success alert-dismissible fade show alert-top mb-0" role="alert"><strong>Success! </strong>
                Hey ' . $_SESSION['username'] . ', you are successfully Logged-In.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            $_SESSION['alert_shown3'] = true;
        }
    ?>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <a class="active" id="addFiles" href="#addFiles">Add Files</a>
        <a id="pendingApproval" href="#pendingApproval">Pending Approvals</a>
        <a id="approvedFiles" href="#approvedFiles">Approved Files</a>
        <a id="rejectedFiles" href="#rejectedFiles">Rejected Files</a>
        <a id="logout" href="../logout.php">Log Out</a>
    </div>

    <div id="addFilesSection">
        <div class="content">
            <h3 class="mt-4">Add Files</h3>
            <br>
            <div class="buttons">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFileModal">
                    Upload New File
                </button>

                <form action="approver.php" method="POST" enctype="multipart/form-data">
                    <div class="modal fade" id="addFileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Upload file</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="documentTitle" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="documentTitle" name="documentTitle" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="documentDescription" class="form-label">Description</label>
                                        <textarea class="form-control" id="documentDescription" name="documentDescription" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <input class="form-control" type="file" id="formFile" name="formFile" required accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf,.rar,.zip,.iso,.jpeg,.jpg,.png,.mp3,.mp4,.mov,.flv,.avi,.mkv,.bmp,.gif,.ogg,.wav">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <table id="addTable" class="table">
                <thead>
                    <tr>
                        <th scope="col">File Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">File Type</th>
                        <th class="sorting" scope="col">Upload Date</th>
                        <th scope="col">Upload Time</th>
                        <th scope="col">Download File</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                        $sql = "SELECT title, description, file_type, file_path, upload_date, status FROM documents";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $date = new DateTime($row['upload_date']);
                                $dateFormatted = $date->format('Y-m-d');
                                $timeFormatted = $date->format('h:i A');
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['title']) . "</td>
                                        <td>" . htmlspecialchars($row['description']) . "</td>
                                        <td>" . htmlspecialchars($row['file_type']) . "</td>
                                        <td>" . htmlspecialchars($dateFormatted) . "</td>
                                        <td>" . htmlspecialchars($timeFormatted) . "</td>
                                        <td><a href='download.php?file=" . urlencode($row['file_path']) . "' class='btn btn-secondary btn-sm' download>Download</a></td>
                                        <td>" . htmlspecialchars($row['status']) . "</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No records found</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
            <br>
        </div>
    </div>

    <div id="pendingApprovalSection" class="hidden">
        <div class="content">
            <h3 class="mt-4">Pending Approvals</h3>
            <br>
            <table id="pendingTable" class="table">
                <thead>
                    <tr>
                        <th scope="col">File Name</th>
                        <th scope="col">File Author</th>
                        <th class="sorting" scope="col">Date Created</th>
                        <th scope="col">Time Created</th>
                        <th scope="col">File Type</th>
                        <th scope="col">Download</th>
                        <th scope="col">Approve?</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                        $sql = "SELECT 
                                    d.document_id, 
                                    d.title, 
                                    d.description, 
                                    d.file_path, 
                                    d.file_type, 
                                    d.upload_date, 
                                    d.uploaded_by, 
                                    d.status,
                                    u.username
                                FROM 
                                    document_approvals da
                                JOIN 
                                    documents d ON da.document_id = d.document_id
                                JOIN 
                                    users u ON d.uploaded_by = u.srno
                                WHERE 
                                    da.status = 'Pending';
                                ";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $date = new DateTime($row['upload_date']);
                                $dateFormatted = $date->format('Y-m-d');
                                $timeFormatted = $date->format('h:i A');
                                echo "<tr>
                                        <td id='data-document-id' hidden>" . htmlspecialchars($row['document_id']) . "</td>
                                        <td>" . htmlspecialchars($row['title']) . "</td>
                                        <td>" . htmlspecialchars($row['username']) . "</td>
                                        <td>" . htmlspecialchars($dateFormatted) . "</td>
                                        <td>" . htmlspecialchars($timeFormatted) . "</td>
                                        <td>" . htmlspecialchars($row['file_type']) . "</td>
                                        <td><a href='download.php?file=" . urlencode($row['file_path']) . "' class='btn btn-secondary btn-sm' download>Download</a></td>
                                        <td>
                                            <form action='approve_document.php' method='post'>
                                                <input type='hidden' name='document_id' id='document_id'>
                                                <button type='button' class='btn btn-outline-dark' data-bs-toggle='modal' data-bs-target='#approvalConfirmModal'>
                                                    ✔️
                                                </button>
                                                <div class='modal fade' id='approvalConfirmModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                    <div class='modal-dialog'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h1 class='modal-title fs-5' id='exampleModalLabel'>Confirm Approval</h1>
                                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <p><b>Are you sure you want to approve this document?</b></p>
                                                                <div class='mb-3'>
                                                                    <label for='approvalRemarks' class='form-label'>Remarks</label>
                                                                    <input type='text' class='form-control' id='approvalRemarks' name='approvalRemarks' placeholder='Enter remarks here...'>
                                                                </div>
                                                            </div>
                                                            <div class='modal-footer'>
                                                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                                <button type='submit' class='btn btn-primary' id='confirmApprovalButton'>Approve</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>   
                                            <form action='reject_document.php' method='post'>
                                                <input type='hidden' name='document_id' id='document_id_refuse'>
                                                <button type='button' class='btn btn-outline-dark' data-bs-toggle='modal' data-bs-target='#refuseConfirmModal'>
                                                    ✖️
                                                </button>
                                                <div class='modal fade' id='refuseConfirmModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                    <div class='modal-dialog'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h1 class='modal-title fs-5' id='exampleModalLabel'>Reject Approval</h1>
                                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <p>Are you sure you want to reject this document?</p>
                                                                <div class='mb-3'>
                                                                    <label for='rejectionRemarks' class='form-label'>Remarks</label>
                                                                    <input type='text' class='form-control' id='rejectionRemarks' name='rejectionRemarks' placeholder='Enter remarks here...' autocomplete='off'>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class='modal-footer'>
                                                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                                <button type='submit' class='btn btn-primary' id='refuseApprovalButton'>Reject</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No records found</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="approvedFilesSection" class="hidden">
        <div class="content">
        <h3 class="mt-4">Approved Files</h3>
            <table id="approvedTable" class="table">
                <thead>
                    <tr>
                        <th scope="col">File Name</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Time Created</th>
                        <th scope="col">File Type</th>
                        <th scope="col">Download File</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                        $sql = "SELECT 
                                    d.document_id, 
                                    d.title, 
                                    d.description, 
                                    d.file_path, 
                                    d.file_type, 
                                    d.upload_date, 
                                    d.uploaded_by, 
                                    d.status
                                FROM 
                                    document_approvals da
                                JOIN 
                                    documents d ON da.document_id = d.document_id
                                WHERE 
                                    da.status = 'Approved';
                                ";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $date = new DateTime($row['upload_date']);
                                $dateFormatted = $date->format('Y-m-d');
                                $timeFormatted = $date->format('h:i A');
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['title']) . "</td>
                                        <td>" . htmlspecialchars($dateFormatted) . "</td>
                                        <td>" . htmlspecialchars($timeFormatted) . "</td>
                                        <td>" . htmlspecialchars($row['file_type']) . "</td>
                                        <td><a href='download.php?file=" . urlencode($row['file_path']) . "' class='btn btn-secondary btn-sm' download>Download</a></td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No records found</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="rejectedFilesSection" class="hidden">
        <div class="content">
            <h3 class="mt-4">Rejected Files</h3> 
            <table id="rejectedTable" class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">File Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Time Created</th>
                        <th scope="col">File Type</th>
                        <th scope="col">Download</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                        $sql = "SELECT 
                                    d.document_id, 
                                    d.title, 
                                    d.description, 
                                    d.file_path, 
                                    d.file_type, 
                                    d.upload_date, 
                                    d.uploaded_by, 
                                    d.status
                                FROM 
                                    document_approvals da
                                JOIN 
                                    documents d ON da.document_id = d.document_id
                                WHERE 
                                    da.status = 'Rejected';
                                ";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $date = new DateTime($row['upload_date']);
                                $dateFormatted = $date->format('Y-m-d');
                                $timeFormatted = $date->format('h:i A');
                                $serialNumber = 1;
                                echo "<tr>
                                        <td>" . $serialNumber++ . "</td>
                                        <td>" . htmlspecialchars($row['title']) . "</td>
                                        <td>" . htmlspecialchars($row['description']) . "</td>
                                        <td>" . htmlspecialchars($dateFormatted) . "</td>
                                        <td>" . htmlspecialchars($timeFormatted) . "</td>
                                        <td>" . htmlspecialchars($row['file_type']) . "</td>
                                        <td><a href='download.php?file=" . urlencode($row['file_path']) . "' class='btn btn-secondary btn-sm' download>Download</a></td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No records found</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
        require 'C:/xampp/htdocs/dms/partials/_footer.php';
    ?>

    <script src="/DMS/approver/approver.js"></script>
    <script>
        
        $(document).ready(function() {
            $('#addTable').DataTable({
                "order": [[3, "desc"]]
            });
        });
        $(document).ready(function() {
            $('#pendingTable').DataTable({
                "order": [[2, "desc"]]
            });
        });
        $(document).ready(function() {
            $('#approvedTable').DataTable({
                "order": [[2, "desc"]]
            });
        });
        $(document).ready(function() {
            $('#rejectedTable').DataTable({
                "order": [[3, "desc"]]
            });
        });
    </script>
    <script>
        document.querySelectorAll('button[data-bs-target="#approvalConfirmModal"]').forEach(function(button) {
            button.addEventListener('click', function() {
                var row = button.closest('tr');
                var documentId = row.querySelector('#data-document-id').innerText;
                document.getElementById('document_id').value = documentId;
            });
        });
    </script>
    <script>
        document.querySelectorAll('button[data-bs-target="#refuseConfirmModal"]').forEach(function(button) {
            button.addEventListener('click', function() {
                var row = button.closest('tr');
                var documentId = row.querySelector('#data-document-id').innerText;
                document.getElementById('document_id_refuse').value = documentId;
            });
        });
    </script>

</body>
</html>
