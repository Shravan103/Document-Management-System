<?php
$currentPage = basename($_SERVER['PHP_SELF']);
echo '
<nav class="navbar navbar-expand-lg bg-body-tertiary shadow container-fluid sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" draggable="true">ADMIN Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">';

$homeDisabled = ($currentPage === 'accessControl.php') ? ' disabled' : '';
$logoutDisabled = ($currentPage === 'accessControl.php') ? ' disabled' : '';
$functionsDisabled = ($currentPage === 'accessControl.php') ? ' disabled' : '';

echo '
                <li class="nav-item">
                    <a class="nav-link active' . $homeDisabled . '" aria-current="page" href="/dms/admin/admin.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle' . $functionsDisabled . '" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Functions
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item' . $functionsDisabled . '" href="/dms/admin/adminFun/viewAllUsers/viewAllUsers.php">View All Users</a></li>
                        <li><a class="dropdown-item' . $functionsDisabled . '" href="/dms/admin/adminFun/userManagement/userManagement.php">User Management</a></li>
                        <li><a class="dropdown-item' . $functionsDisabled . '" href="/dms/admin/adminFun/userLogin/userLogin.php">User Dashboard Login</a></li>
                        <li><a class="dropdown-item' . $functionsDisabled . '" href="/dms/admin/adminFun/fileStorageStructure/myFile.php">File Structure</a></li>
                        <li><a class="dropdown-item' . $functionsDisabled . '" href="/dms/admin/adminFun/fileManagement/fileManagement.php">Document Details</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item' . $functionsDisabled . '" href="/dms/admin/adminFun/aboutMe/aboutMe.php">About-Me</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a id="logout" class="nav-link' . $logoutDisabled . '" href="/dms/logout.php">Logout</a>
                </li>
            </ul>
            <a class="navbar-brand" draggable="true" style="font-size: 27px; color: navy;">
                <span style="color: rgb(13, 5, 54); font-weight: bold;">Doc</span>Stream
            </a>
        </div>
    </div>
</nav>
';
?>

<style>
    .nav-link.disabled,
    .dropdown-item.disabled {
        pointer-events: none;
        color: #6c757d; /* Bootstrap's default disabled text color */
    }
</style>
