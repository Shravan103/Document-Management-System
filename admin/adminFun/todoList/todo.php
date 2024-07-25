<?php
// INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'But Books', 'Please buy books from Store', current_timestamp());

$insert = false;
$update = false;
$delete = false;
// Connect to the Database 
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if (!$conn) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
}

if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
    $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        // Update the record
        $sno = $_POST["snoEdit"];
        $title = $_POST["titleEdit"];
        $description = $_POST["descriptionEdit"];

        // Sql query to be executed
        $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        } else {
            echo "We could not update the record successfully";
        }
    } else {
        $title = $_POST["title"];
        $description = $_POST["description"];

        // Sql query to be executed
        $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
        $result = mysqli_query($conn, $sql);


        if ($result) {
            $insert = true;
        } else {
            echo "The record was not inserted successfully because of this error ---> " . mysqli_error($conn);
        }
    }
}
?>

<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <style>
        .myTodo {
            display: flex;
            flex-direction: column;
            flex-basis: auto;
            margin: 0;
            padding: 0;
        }
    </style>
</head>


<body>


    <!--EDIT MODAL -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="/dms/admin/admin.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="form-group">
                            <label for="title">Task Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
                        </div>

                        <div class="form-group">
                            <label for="desc">Task Description</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer d-block mr-auto">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- CREATE NOTE FORM -->
    
        <div class="container myTodo">
        
            <div class="container p-4">
                <div>
                    <form action="/dms/admin/admin.php" method="POST">
                        <div class="form-group">
                            <label for="title">Task Title</label>
                            <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                        </div>

                        <div class="form-group">
                            <label for="desc">Task Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </form>
                </div>
                <hr class="my-4">
                <!-- DATATABLE OF NOTES -->
                <div class="container">
                    <table class="table table-striped table-bordered rounded" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col" class="text-primary">S.No</th>
                                <th scope="col" class="text-primary">Title</th>
                                <th scope="col" class="text-primary">Description</th>
                                <th scope="col" class="text-primary">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `notes`";
                            $result = mysqli_query($conn, $sql);
                            $sno = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $sno = $sno + 1;
                                echo "<tr>
                            <th scope='row'>" . $sno . "</th>
                            <td>" . $row['title'] . "</td>
                            <td>" . $row['description'] . "</td>
                            <td> <button class='edit btn btn-sm btn-primary mb-2' id=" . $row['sno'] . ">Edit</button> <button class='delete btn btn-sm btn-primary mb-2' id=d" . $row['sno'] . ">Delete</button>  </td>
                        </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                    "lengthMenu": [[3, 10, 15, -1], [3, 10, 15, "All"]],
                    "pageLength": 3,
                });

            });
        </script>
        <script>
            edits = document.getElementsByClassName('edit');
            Array.from(edits).forEach((element) => {
                element.addEventListener("click", (e) => {
                    console.log("edit ");
                    tr = e.target.parentNode.parentNode;
                    title = tr.getElementsByTagName("td")[0].innerText;
                    description = tr.getElementsByTagName("td")[1].innerText;
                    console.log(title, description);
                    titleEdit.value = title;
                    descriptionEdit.value = description;
                    snoEdit.value = e.target.id;
                    console.log(e.target.id)
                    $('#editModal').modal('toggle');
                })
            })

            deletes = document.getElementsByClassName('delete');
            Array.from(deletes).forEach((element) => {
                element.addEventListener("click", (e) => {
                    console.log("edit ");
                    sno = e.target.id.substr(1);

                    if (confirm("Are you sure you want to delete this note!")) {
                        console.log("yes");
                        window.location = `/dms/admin/admin.php?delete=${sno}`;
                        // TODO: Create a form and use post request to submit a form
                    } else {
                        console.log("no");
                    }
                })
            })
        </script>

</body>