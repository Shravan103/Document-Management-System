<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/DMS/user/user.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <title>User Section</title>

</head>

<body style="padding-top: 55px;">

    <?php
        $navbarTitle = "User Dashboard";
        $navbarHref = './user.php';
        require 'C:/xampp/htdocs/dms/partials/_header.php';
        // Success login alert here 
        echo '<div class="alert alert-success alert-dismissible fade show alert-top mb-0" role="alert"><strong>Success! </strong>You are successfully Logged-In<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    ?>

    <!-- The sidebar -->
    <div class="sidebar">
        <a class="active" id="fileManagement" href="#fileManagement">File Management</a>
        <a id="Starred" href="#Starred">Starred</a>
        <a id="logout" href="../index.html">Log Out</a>
    </div>

    <!-- Page content -->
    <div id="fileManagementSection">
        <div class="content">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">File Name</th>
                        <th scope="col">Author</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Approval</th>
                        <th scope="col">Delete</th>
                        <th scope="col">Download</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr>
                        <th scope="row">1</th>
                        <td>XYZ</td>
                        <td>ABC</td>
                        <td>02-06-2024</td>
                        <td>yes</td>
                        <td><button>Delete</button></td>
                        <td><button>Download</button></td>

                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>PQR</td>
                        <td>LMN</td>
                        <td>11-05-2024</td>
                        <td>no</td>
                        <td><button>Delete</button></td>
                        <td><button>Download</button></td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>TDM</td>
                        <td>LOQ</td>
                        <td>03-06-2024</td>
                        <td>no</td>
                        <td><button>Delete</button></td>
                        <td><button>Download</button></td>
                    </tr>
                </tbody>
            </table>

            <button type="button" class="btn btn-outline-primary">Upload File</button>
            <button type="button" class="btn btn-primary">Done</button>
        </div>
    </div>

    <div id="StarredSection" class="hidden">
        <div class="content">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">File Name</th>
                        <th scope="col">Author</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Approval</th>
                        <th scope="col">Delete</th>
                        <th scope="col">Download</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr>
                        <th scope="row">1</th>
                        <td>XYZ</td>
                        <td>ABC</td>
                        <td>02-06-2024</td>
                        <td>yes</td>
                        <td><button>Delete</button></td>
                        <td><button>Download</button></td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="/DMS/user/user.js"></script>

    <?php 
        require 'C:/xampp/htdocs/dms/partials/_footer.php';
    ?>

</body>

</html>