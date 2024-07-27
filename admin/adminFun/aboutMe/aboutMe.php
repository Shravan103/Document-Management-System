<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About-Me</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .adminIcon
        {
            display: inline-flex;
            margin-left: 7.4%;
            margin-top: 2%;
            width: 8rem;
            height: 8rem;
            font-size: 8rem;
            border-radius: .75rem;
        }
    </style>
</head>

<body>
    <!-- ADMIN HEADER -->
    <?php
    include '/xampp/htdocs/dms/admin/adminExtra/_Aheader.php';
    ?>
    <i class="bi bi-person-circle adminIcon"></i>
    
    <div class="container mt-4">
        <hr>
        LoggedIn:
        <input class="form-control mb-3" type="text" value="<?php echo $_SESSION['loggedin'] ?>" aria-label="Disabled input example" disabled readonly>
        Username:
        <input class="form-control mb-3" type="text" value="<?php echo $_SESSION['username'] ?>" aria-label="Disabled input example" disabled readonly>
        Email:
        <input class="form-control mb-3" type="text" value="<?php echo $_SESSION['email'] ?>" aria-label="Disabled input example" disabled readonly>
        Type:
        <input class="form-control mb-3" type="text" value="Admin" aria-label="Disabled input example" disabled readonly>
        Date of account creation:
        <input class="form-control mb-3" type="text" value="<?php echo $_SESSION['date'] ?>" aria-label="Disabled input example" disabled readonly>
        Status:
        <input class="form-control mb-3" type="text" value="<?php echo $_SESSION['status'] ?>" aria-label="Disabled input example" disabled readonly>
    </div>

    <!-- FOOTER IMPORTED -->
    <?php
    require '/xampp/htdocs/dms/partials/_footer.php';
    ?>

    <!-- simple bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>