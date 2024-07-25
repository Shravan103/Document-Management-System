<?php
$navbarTitle = isset($navbarTitle) ? $navbarTitle : 'Dashboard';
$navbarHref = isset($navbarHref) ? $navbarHref : '../index.php';
echo '<nav class="navbar bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand myHeader" href="'. $navbarHref .'">' . $navbarTitle . '</a>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav>';
?>
