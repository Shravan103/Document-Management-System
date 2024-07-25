<?php
    echo '
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow container-fluid sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" draggable="true" >ADMIN Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/dms/admin/admin.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Functions
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/dms/admin/adminFun/viewAllUsers/viewAllUsers.php">View All Users</a></li>
                            <li><a class="dropdown-item" href="/dms/admin/adminFun/userManagement/userManagement.php">User Management</a></li>
                            <li><a class="dropdown-item" href="#">File Management</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/dms/admin/adminFun/aboutMe/aboutMe.php">About-Me</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a id="logout" class="nav-link" href="/dms/index.php">Logout</a>
                    </li>
                </ul>
                    <a class="navbar-brand" draggable="true" style="font-size: 27px; color: navy;"><span style="color: rgb(13, 5, 54); font-weight: bold;">Doc</span>Stream</a>
                
            </div>
        </div>
    </nav>
    ';
?>
    