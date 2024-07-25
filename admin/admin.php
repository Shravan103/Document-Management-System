<?php session_start() ?>
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
    include 'C:/xampp/htdocs/dms/admin/adminExtra/_Aheader.php';
    //DISSMISABLE ALERT FOR SUCCESS LOGIN
    if (!$_SESSION['alert_shown']) {
        echo '<div class="alert alert-success alert-dismissible fade show alert-top mb-0" role="alert"><strong>Success! </strong>
            Hey ' . $_SESSION['username'] . ', you are successfully Logged-In.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        $_SESSION['alert_shown'] = true;
    }
    ?>
    <!-- STAICTICAL DATA -->
    <h3 class="text-center text-secondary mb-0 mt-5">DocStream Statistics</h3>
    <section id="content">
        <main>
            <ul class="box-info">
                <li class="list1">
                    <i class='bx bxs-hot'></i>
                    <span class="text">
                        <h3>1020</h3>
                        <p>Total Users</p>
                    </span>
                </li>
                <li class="list1">
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3>2834</h3>
                        <p>Active Users</p>
                    </span>
                </li>
                <li class="list1">
                    <i class='bx bx-user'></i>
                    <span class="text">
                        <h3>2543</h3>
                        <p>Officers</p>
                    </span>
                </li>
                <li class="list1">
                    <i class='bx bx-user'></i>
                    <span class="text">
                        <h3>2543</h3>
                        <p>Employees</p>
                    </span>
                </li>
            </ul>
        </main>
    </section>

    <div class="both container">

        <!-- TODO List -->
        
        <div class="container item itemSc shadow">
        <h3 class="text-center text-secondary mb-0 mt-3 p-2 container non-flex">TODO LIST</h2>
            <?php
            include 'C:/xampp/htdocs/dms/admin/adminFun/todoList/todo.php';
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
    require 'C:/xampp/htdocs/dms/partials/_footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/dms/admin/admin.js"></script>


</body>

</html>