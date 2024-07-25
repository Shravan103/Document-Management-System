<?php
//DATABASE CONNECTION
include 'C:/xampp/htdocs/dms/partials/_dbconnect.php';

//DELETE THE USER
$update = false;
$aAccountExists = false;
$aAccountCreated = false;
if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `users` WHERE `srno` = $sno";
    $result = mysqli_query($conn, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //UPDATE THE USER
    if (isset($_POST['snoEdit'])) {
        $sno = $_POST["snoEdit"];
        $username = $_POST["Username"];
        $email = $_POST["Email"];
        $type = $_POST["Type"];
        $password = $_POST["Password"];
        if (empty($password)) {
            $sql = "UPDATE `users` SET `username` = '$username' , `email` = '$email' , `type` = '$type' WHERE `srno` = $sno";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $update = true;
            } else {
                echo "We could not update the user";
            }
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE `users` SET `username` = '$username' , `email` = '$email' , `type` = '$type' , `password` = '$hash' WHERE `srno` = $sno";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $update = true;
            } else {
                echo "We could not update the user";
            }
        }
    }
    //ADD THE USER
    if (isset($_POST['addUsername']) && isset($_POST['addEmail']) && isset($_POST['addType']) && isset($_POST['addPassword'])) {
        $aUsername = $_POST["addUsername"];
        $aEmail = $_POST["addEmail"];
        $aType = $_POST["addType"];
        $aPassword = $_POST["addPassword"];

        $query = "select * from `users` where username = '$aUsername' and email = '$aEmail'";
        $result = mysqli_query($conn, $query);
        $numExistRows = mysqli_num_rows($result);
        if ($numExistRows >= 1) {
            $aAccountExists = true;
        } else {
            $hash = password_hash($aPassword, PASSWORD_DEFAULT);
            $reg = "INSERT INTO `users` (`username`, `email`, `type`, `password`, `date`) VALUES ('$aUsername', '$aEmail', '$aType', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $reg);
            if ($result) {
                $aAccountCreated = true;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <!-- simple bootstrap css -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    </style>
</head>

<body>
    <!-- MODAL FOR USER EDIT -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="userManagement.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="form-group">
                            <label for="title">Username</label>
                            <input type="text" class="form-control" id="Username" name="Username" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="title">Email</label>
                            <input type="email" class="form-control" id="Email" name="Email" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="title">Type</label>
                            <input type="text" class="form-control" id="Type" name="Type" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="title">Password (Keep Empty if no change required)</label>
                            <input type="password" class="form-control" id="Password" name="Password" aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="modal-footer d-block mr-auto">
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL FOR ADD USER -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="userManagement.php" method="POST">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Username:</label>
                            <input type="text" name="addUsername" class="form-control" id="recipient-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Email:</label>
                            <input type="email" name="addEmail" class="form-control" id="recipient-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Type:</label>
                            <input type="text" name="addType" class="form-control" id="recipient-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Password:</label>
                            <input type="password" name="addPassword" class="form-control" id="recipient-name" required>
                        </div>
                        <div class="modal-footer d-block mr-auto">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--NAVBAR-->
    <?php
    include 'C:/xampp/htdocs/dms/admin/adminExtra/_Aheader.php';
    ?>

    <!-- DISSMISABLE ALERT -->
    <?php
    if ($update) {
        echo '<div class="alert alert-success alert-dismissible fade show alert-top mb-0" role="alert">
        <strong>Success! </strong>User Information has been successfully updated
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if ($aAccountExists) {
        echo '<div class="alert alert-danger alert-dismissible fade show alert-top mb-0" role="alert">
        <strong>Error! </strong>The account you are tyring to ADD already exists. Try different Username or Email.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        // $aAccountExists = false;
    }
    if ($aAccountCreated) {
        echo '<div class="alert alert-success alert-dismissible fade show alert-top mb-0" role="alert">
        <strong>Success! </strong>User account has been Added.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        $aAccountCreated = false;
    }
    ?>

    <!-- DATATABLE -->
    <div class="card-body container mt-5 mb-2 pt-2 pb-2 pl-5 pr-5">
        <table id="myTable" class="table table-striped table-bordered ">
            <thead>
                <tr>
                    <th class="text-primary">SrNo</th>
                    <th class="text-primary">Username</th>
                    <th class="text-primary">Email</th>
                    <th class="text-primary">Type</th>
                    <th class="text-primary">Date</th>
                    <th class="text-primary">Status</th>
                    <th class="text-success">Edit</th>
                    <th class="text-success">Delete</th>
                    <th class="text-success">Access Controls</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $mySr = 0;
                $sql = "select * from `users` where `type` = 'officer' or `type` = 'employee'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $mySr++;
                    echo '<tr>
                            <td>' . $mySr . '</td>
                            <td>' . $row["username"] . '</td>
                            <td>' . $row["email"] . '</td>
                            <td>' . $row["type"] . '</td>
                            <td>' . $row["date"] . '</td>
                            <td>' . $row["status"] . '</td>
                            <td><button class="myEdit btn btn-success mt-1 pb-0 pt-0" id="' . $row["srno"] . '">Edit</button></td>
                            <td><button class="myDelete btn btn-success mt-1 pb-0 pt-0" id="' . $row["srno"] . '">Delete</button></td>
                            <td><button class="myAccess btn btn-success mt-1 pb-0 pt-0">Access Controls</button></td>
                        </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- ADD USER MODAL BUTTON -->
    <div class="container px-0 pb-5">
        <p class="text-success" style="display: inline-block;">Want to add users?</p><button type="button" class="btn btn-success m-2 px-5" data-bs-toggle="modal" data-bs-target="#exampleModal">Add User</button>
    </div>

    <!-- JAVASCRIPT: JQUERY, DATABALES, BOOTSTRAP -->
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/2.1.0/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script>
        edits = document.getElementsByClassName('myEdit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ");
                tr = e.target.parentNode.parentNode;
                usernameCpy = tr.getElementsByTagName("td")[1].innerText;
                emailCpy = tr.getElementsByTagName("td")[2].innerText;
                typeCpy = tr.getElementsByTagName("td")[3].innerText;
                // console.log(usernameCpy,emailCpy,typeCpy);
                Username.value = usernameCpy;
                Email.value = emailCpy;
                Type.value = typeCpy;
                snoEdit.value = e.target.id;
                // console.log(e.target.id)
                $('#editModal').modal('toggle');
            })
        })

        deletes = document.getElementsByClassName('myDelete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ");
                sno = e.target.id;

                if (confirm("Are you sure you want to delete this note!")) {
                    console.log("yes");
                    window.location = `/dms/admin/adminFun/userManagement/userManagement.php?delete=${sno}`;
                } else {
                    console.log("no");
                }
            })
        })
    </script>

    <?php
    require 'C:/xampp/htdocs/dms/partials/_footer.php';
    ?>
</body>

</html>