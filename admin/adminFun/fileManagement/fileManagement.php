<?php
include '/xampp/htdocs/dms/partials/_dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Management</title>
    <!-- simple bootstrap css -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* CSS for footer to stick at bottom */
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <!--NAVBAR-->
    <?php include '/xampp/htdocs/dms/admin/adminExtra/_Aheader.php'; ?>
							 
    <!-- DATATABLE -->
    <div class="card-body container mt-5 mb-2 pt-2 pb-2 pl-5 pr-5">
        <h2 class="text-center text-secondary">File Management</h2>
        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-primary">Document ID</th>
                    <th class="text-primary">Title</th>
                    <th class="text-primary">Description</th>
                    <th class="text-primary">File Path</th>
                    <th class="text-primary">File Type</th>
                    <th class="text-primary">Upload Date</th>
                    <th class="text-primary">Uploaded By</th>
                    
                    <th class="text-success">Access Control</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `documents`";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                            <td>' . $row["document_id"] . '</td>
                            <td>' . $row["title"] . '</td>
                            <td>' . $row["description"] . '</td>
                            <td>' . $row["file_path"] . '</td>
                            <td>' . $row["file_type"] . '</td>
                            <td>' . $row["upload_date"] . '</td>
                            <td>' . $row["uploaded_by"] . '</td>
                            
                            <td><a href="accessControl.php?document_id=' . $row["document_id"] . '" class="btn btn-success mt-1 pb-0 pt-0">Access Control</a></td>
                        </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- JAVASCRIPT: JQUERY, DATATABLES, BOOTSTRAP -->
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/2.1.0/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    
    <!-- IMPORTED FOOTER -->
    <div style="margin-top: auto;">
        <?php require '/xampp/htdocs/dms/partials/_footer.php'; ?>
    </div>
</body>

</html>
