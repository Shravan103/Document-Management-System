<?php
    session_start();
    if(!isset($_SESSION['loggedin']))
    {
        header("location: /dms/index.php");
        exit();
    }


// Prevent page caching
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Section</title>
    <!-- ICONS FOR STATISTICAL DATA -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/dms/admin/admin.css">

</head>

<body>

    <?php
    //HEADER IMPORTED
    include '/xampp/htdocs/dms/admin/adminExtra/_Aheader.php';
    //DISSMISABLE ALERT FOR SUCCESS LOGIN
    if (!$_SESSION['alert_shown1']) {
        echo '<div class="alert alert-success alert-dismissible fade show alert-top mb-0" role="alert"><strong>Success! </strong>
            Hey ' . $_SESSION['username'] . ', you are successfully Logged-In.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        $_SESSION['alert_shown1'] = true;
    }
    ?>
    <!-- STAICTICAL DATA -->
    <?php
        include '/xampp/htdocs/dms/partials/_dbconnect.php';
        //FOR TOATAL USERS
        $query1 = "select count(*) as totalU from `users`";
        $result1 = mysqli_query($conn, $query1);
        $array1 = mysqli_fetch_assoc($result1);
        //FOR ACTIVE USERS
        $query2 = "select count(*) as activeU from `users` where status = 'active'";
        $result2 = mysqli_query($conn, $query2);
        $array2 = mysqli_fetch_assoc($result2);
        //FOR OFFICERS
        $query3 = "select count(*) as officerU from `users` where type = 'officer'";
        $result3 = mysqli_query($conn, $query3);
        $array3 = mysqli_fetch_assoc($result3);
        //FOR EMPLOYEES
        $query4 = "select count(*) as employeeU from `users` where type = 'employee'";
        $result4 = mysqli_query($conn, $query4);
        $array4 = mysqli_fetch_assoc($result4);

    ?>
    <h3 class="text-center text-secondary mb-0 mt-5">DocStream Statistics</h3>
    <section id="content">
        <main>
            <ul class="box-info px-2">
                <li class="list1 shadow">
                    <i class='bx bxs-hot'></i>
                    <span class="text">
                        <h3><?php echo $array1['totalU']; ?></h3>
                        <p>Total Users</p>
                    </span>
                </li>
                <li class="list1 shadow">
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3><?php echo $array2['activeU']; ?></h3>
                        <p>Active Users</p>
                    </span>
                </li>
                <li class="list1 shadow">
                    <i class='bx bx-user'></i>
                    <span class="text">
                        <h3><?php echo $array3['officerU']; ?></h3>
                        <p>Officers</p>
                    </span>
                </li>
                <li class="list1 shadow">
                    <i class='bx bx-user'></i>
                    <span class="text">
                        <h3><?php echo $array4['employeeU']; ?></h3>
                        <p>Employees</p>
                    </span>
                </li>
            </ul>
            <!-- <hr class="mt-5 mb-0" style="border: 1px grey solid;"> -->
        </main>
        
    </section>

    

    <div class="both container">

        <!-- TODO List -->
        
        <div class="container item itemSc shadow">
        <h3 class="text-center text-secondary mb-0 mt-3 pb-0 pt-2 container non-flex">TODO LIST</h2>
            <?php
            include '/xampp/htdocs/dms/admin/adminFun/todoList/todo.php';
            ?>
        </div>


        <!-- CALENDAR -->

        <div class="mt-5 mb-0 item itemCal">
            
                <div class="light">
                    <div class="calendar">
                    <h3 class="text-center text-secondary mt-2 mb-3">MY CALENDAR</h2>
                        <div class="calendar-header">
                            <span class="month-picker" id="month-picker">February</span>
                            <div class="year-picker">
                                <span class="year-change" id="prev-year">
                                    <pre><</pre>
                                </span>
                                <span id="year">2021</span>
                                <span class="year-change" id="next-year">
                                    <pre>></pre>
                                </span>
                            </div>
                        </div>
                        <div class="calendar-body">
                            <div class="calendar-week-day">
                                <div>Sun</div>
                                <div>Mon</div>
                                <div>Tue</div>
                                <div>Wed</div>
                                <div>Thu</div>
                                <div>Fri</div>
                                <div>Sat</div>
                            </div>
                            <div class="calendar-days"></div>
                        </div>
                        <div class="month-list"></div>
                    </div>
                </div>
        </div>
    </div>



    <!-- FOOTER IMPORTED -->
    <?php
    require '/xampp/htdocs/dms/partials/_footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/dms/admin/admin.js"></script>


</body>

</html>