<?php
//DATABASE CONNECTION
include '/xampp/htdocs/dms/partials/_dbconnect.php';

// Function to log in as a particular user
if (isset($_POST['loginAsUser'])) {
    $srno = $_POST['srno'];
    $sql = "SELECT * FROM `users` WHERE `srno` = '$srno'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        session_start();
        
        $_SESSION['username'] = "ADMIN";
        $_SESSION['srno'] = $row['srno'];
        $_SESSION['type'] = $row['type'];
        // Redirect to user dashboard
        if($row['type']=="employee")
        {
            $_SESSION['alert_shown2'] = false;
            header("Location: /dms/user/user.php");
            exit();
        }
        else
        {
            $_SESSION['alert_shown3'] = false;
            header("Location: /dms/approver/approver.php");
            exit();
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
        /* CSS for footer to stick at bottom */
        html,
        body {
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
    <?php
    include '/xampp/htdocs/dms/admin/adminExtra/_Aheader.php';
    ?>

    <!-- DATATABLE -->
    <div class="card-body container mt-5 mb-2 pt-2 pb-2 pl-5 pr-5">
        <h2 class="text-center text-secondary">--User Dashboard Login--</h2>
        <table id="myTable" class="table table-striped table-bordered ">
            <thead>
                <tr>
                    <th class="text-primary">SrNo</th>
                    <th class="text-primary">Username</th>
                    <th class="text-primary">Email</th>
                    <th class="text-primary">Type</th>
                    <th class="text-primary">Date</th>
                    <th class="text-primary">Status</th>
                    <th class="text-success">Login</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $mySr = 0;
                $sql = "select * from `users` where `type` = 'employee' or `type` = 'officer'";
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
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="srno" value="' . $row["srno"] . '">
                                    <button type="submit" name="loginAsUser" class="btn btn-success mt-1 pb-0 pt-0">Login</button>
                                </form>
                            </td>
                        </tr>';
                }
                ?>
            </tbody>
        </table>
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
    
    <!-- IMPORTED FOOTER -->
    <div style="margin-top: auto;">
        <?php require '/xampp/htdocs/dms/partials/_footer.php'; ?>
    </div>
</body>

</html>
