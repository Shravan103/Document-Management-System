<?php
$navbarTitle = isset($navbarTitle) ? $navbarTitle : 'Dashboard';
$navbarHref = isset($navbarHref) ? $navbarHref : '../index.php';
echo '<nav class="navbar bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand myHeader" href="'. $navbarHref .'">' . $navbarTitle . '</a>
            <form class="d-flex" role="search">
                <a class="navbar-brand" draggable="true" style="font-size: 27px; color: navy;">
                <span style="color: rgb(13, 5, 54); font-weight: bold;">Doc</span>Stream
                </a>
            </form>
        </div>
    </nav>';
?>
