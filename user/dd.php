<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/DMS/user/user.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">



    <title>User Section</title>

</head>

<body style="padding-top: 55px;">
    <?php
    // session_start();
    include '../partials/_dbconnect.php';
    $servername = "127.0.0.1";
    $username = "root";
    // $password = "password";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=dms", $username);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //   echo "Connected successfully";
    } catch (PDOException $e) {
        //   echo "Connection failed: " . $e->getMessage();
    }

    // $result = [];
    // $starred_result = [];

    // // Check if user is logged in and srno is set
    // if (isset($_SESSION['loggedin']) && isset($_SESSION['srno'])) {
    //     $srno = $_SESSION['srno'];

    //     // Prepared statement to fetch documents the user has access to
    //     $stmt = $conn->prepare("SELECT document_id, access_type FROM access_control WHERE user_id = :srno");
    //     $stmt->bindParam(':srno', $srno, PDO::PARAM_INT);
    //     $stmt->execute();
    //     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     // Fetch all starred documents
    //     $starred_stmt = $conn->prepare("SELECT document_id, title, description, file_path, upload_date, uploaded_by, is_starred FROM documents");
    //     $starred_stmt->execute();
    //     $starred_result = $starred_stmt->fetchAll(PDO::FETCH_ASSOC);
    // } else {
    //     header("Location: /DMS/index.php");
    //     exit();
    // }






    //Check if user is logged in
    // if (!isset($_SESSION['loggedin']) || !isset($_SESSION['srno'])) {
    //     header("Location: /DMS/index.php");
    //     exit();
    // }
    
    
    // $srno = $_SESSION['srno'];
    // $user = $_SESSION['srno'];
    // $sql = "SELECT document_id, access_type FROM access_control WHERE user_id=$user";
    // $result = $conn->query($sql);

    $sql = "SELECT document_id, access_type FROM access_control WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);



    //Fetch starred documents
    // $starred_sql = "SELECT document_id, title, description, file_path, upload_date, uploaded_by, is_starred FROM documents";
    // $starred_result = $conn->query($starred_sql);
    $starred_sql = "SELECT d.document_id, d.title, d.description, d.file_path, d.upload_date, d.uploaded_by 
                FROM documents d
                INNER JOIN starred_documents sd ON d.document_id = sd.document_id
                WHERE sd.user_id = :user_id";
                $starred_stmt = $conn->prepare($starred_sql);
                $starred_stmt->bindParam(':user_id', $user, PDO::PARAM_INT);
                $starred_stmt->execute();
                $starred_result = $starred_stmt->fetchAll(PDO::FETCH_ASSOC);


    ?>
    <?php
    $navbarTitle = "User Dashboard";
    $navbarHref = './user.php';
    require '/xampp/htdocs/dms/partials/_header.php';
    //DISSMISABLE ALERT FOR SUCCESS LOGIN
    if (!$_SESSION['alert_shown2']) {
        echo '<div class="alert alert-success alert-dismissible fade show alert-top mb-0" role="alert"><strong>Success! </strong>
            Hey ' . $_SESSION['username'] . ', you are successfully Logged-In.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        $_SESSION['alert_shown2'] = true;
    }
    ?>


    <!-- The sidebar -->
    <div class="sidebar">
        <a class="active" id="fileManagement" href="#fileManagement">File Management</a>
        <a id="Starred" href="#Starred">Starred</a>
        <a id="logout" href="../index.php">Log Out</a>
    </div>

    <!-- MAIN PAGE CONTENT -->
    <div id="fileManagementSection">
        <div class="content">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">File Name</th>
                        <th scope="col">Author</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Approval</th>
                        <th scope="col">Star/Unstar</th>
                        <th scope="col">View</th>
                        <th scope="col">Download</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    if ($result->rowCount() > 0) {
                        $no = 0;
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            $sql1 = "SELECT title, description, file_path, upload_date, uploaded_by, is_starred FROM documents WHERE document_id= $row[document_id]";
                            $result1 = $conn->query($sql1);
                            $row1 = $result1->fetch(PDO::FETCH_ASSOC);
                            $no++;
                            echo "<tr>
                            <th scope='row'>$no</th>
                            <td>{$row1['title']}</td>
                            <td>{$row1['description']}</td>
                            <td>{$row1['upload_date']}</td>
                            <td>";
                            $sql2 = "SELECT status FROM document_approvals WHERE document_id= $row[document_id]";
                            $result2 = $conn->query($sql2);
                            $row2 = $result2->fetch(PDO::FETCH_ASSOC);
                            echo $row2['status'];
                            echo "</td>
                            <td>
                                <form action='toggle_star.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='document_id' value='{$row['document_id']}'>
                                    <button type='submit'>";
                            echo $row1['is_starred'] ? 'Unstar' : 'Star';
                            echo "</button>
                                </form>
                            </td>
                            <td>
                                <form action='view_file.php' method='GET' style='display:inline;'>
                                    <input type='hidden' name='id' value='{$row1['file_path']}'>
                                    <button type='submit'>View</button>
                                </form>
                            </td>
                            <td>
                                <form action='download_file.php' method='GET' style='display:inline;'>
                                    <input type='hidden' name='new' value='{$row1['file_path']}'>
                                    <button type='submit'>Download</button>
                                </form>
                            </td>
                        </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- STARRED MESSAGES -->
    <div id="StarredSection" class="hidden">
        <div class="content">
            <table class="table" id="starredTable">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">File Name</th>
                        <th scope="col">Author</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Approval</th>
                        <th scope="col">Unstar</th>
                        <th scope="col">Download</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    if ($starred_result->rowCount() > 0) {
                        $no = 0;
                        while ($starred_row = $starred_result->fetch(PDO::FETCH_ASSOC)) {
                            if ($starred_row['is_starred']) {
                                $no++;
                                echo "<tr>
                                    <th scope='row'>$no</th>
                                    <td>{$starred_row['title']}</td>
                                    <td>{$starred_row['description']}</td>
                                    <td>{$starred_row['upload_date']}</td>
                                    <td>";
                                $sql_approval = "SELECT status FROM document_approvals WHERE document_id= {$starred_row['document_id']}";
                                $result_approval = $conn->query($sql_approval);
                                $row_approval = $result_approval->fetch(PDO::FETCH_ASSOC);
                                echo $row_approval['status'];
                                echo "</td>
                                    <td>
                                        <form action='toggle_star.php' method='POST' style='display:inline;'>
                                            <input type='hidden' name='document_id' value='{$starred_row['document_id']}'>
                                            <button type='submit'>Unstar</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action='download_file.php' method='GET' style='display:inline;'>
                                            <input type='hidden' name='new' value='{$starred_row['file_path']}'>
                                            <button type='submit'>Download</button>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="/DMS/user/user.js"></script>
    <?php
    require '/xampp/htdocs/dms/partials/_footer.php';
    ?>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
            $('#starredTable').DataTable();
        });
    </script>
</body>

</html>