<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        h1.top {
            text-align: center;
            font-weight: 700;
            font-size: 4rem;
        }

        .myIcon {

            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            font-size: 1.5rem;
            border-radius: .75rem;
            background-color: rgb(11, 205, 163);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 65px;
            padding: 20px 100px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 99;
            background-color: #f8f9fa;
            box-shadow: 0 0 30px rgba(0, 0, 0, .5);
            backdrop-filter: blur(5px);
            border-width: 0px 0px 1px 0px;
            font-family: 'Courier New', Courier, monospace;
        }

        .logo {
            font-size: 2em;
            color: navy;
            user-select: none;
        }

        .navigation a.one {
            position: relative;
            font-size: 1.1em;
            color: black;
            text-decoration: none;
            font-weight: 600;
            margin-left: 40px;
        }

        .navigation .btnLogin-popup {
            width: 150px;
            height: 50px;
            background-color: white;
            border: 2px solid rgb(112, 109, 109);
            outline: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1em;
            color: black;
            font-weight: bolder;
            margin-left: 40px;
        }

        .two
        {
            text-decoration: none;
            color: black;
        }

        .navigation .btnLogin-popup:hover {
            background-color: #f9f6ee;
            color: black;
            font-weight: bolder;
            border: 3px solid rgb(112, 109, 109);
        }
    </style>
</head>

<body>
    <header>
        <a href="/DMS/index.php" style="text-decoration: none;">
            <h2 class="logo"><span style="color: rgb(13, 5, 54); font-weight: bold;">Doc</span>Stream</h2>
        </a>
        <nav class="navigation">
            <a class="one" href="/DMS/partials/_about.php">About</a>
            <button class="btnLogin-popup"><a class="two" href="/DMS/index.php">Login/SignUp</a></button>
        </nav>
    </header>

    <div class="container col-xxl-8 px-4 py-5 ml-5 mr-5 mt-4 pb-1">
        <h1 class="top">About Us</h1>
        <hr>
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <div class="col-10 col-sm-8 col-lg-6">
                <img src="about1.jpg" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="800"
                    height="800" loading="lazy">
            </div>
            <div class="col-lg-6">
                <h1 class="display-5.5 fw-bold lh-1 mb-3">What is <strong>DocStream</strong>?</h1>
                <p class="lead">Welcome to DocStream, your comprehensive solution for efficient document management. Our
                    mission is to simplify the way individuals and organizations store, share, and collaborate on
                    documents. At DocStream, we understand that managing documents can be a daunting task. That's why
                    we've designed our platform to be user-friendly and intuitive, ensuring that you can focus on what
                    matters most—your work.</p>
            </div>
        </div>
    </div>

    <div class="container px-4 py-5" id="hanging-icons">
        <h2 class="pb-2 border-bottom">Features Incorporated:</h2>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            <div class="col d-flex align-items-start">
                <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
                    <i class="bi bi-key myIcon"></i>
                </div>
                <div>
                    <h2>Robust Authentication</h2>
                    <p>Secure your access to DocStream with our robust authentication system. Our platform offers a
                        straightforward and secure login and signup process, ensuring that only authorized users can
                        access your documents. With options for multi-user authentication (MUA) & password recovery.</p>
                </div>
            </div>
            <div class="col d-flex align-items-start">
                <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
                    <i class="bi bi-floppy myIcon"></i>
                </div>
                <div>
                    <h2>Secure Storage</h2>
                    <p>Keep your documents safe with our state-of-the-art encryption technology. DocStream ensures that
                        all your files are securely stored, protecting your sensitive information from unauthorized
                        access.</p>
                </div>
            </div>
            <div class="col d-flex align-items-start">
                <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
                    <i class="bi bi-people myIcon"></i>
                </div>
                <div>
                    <h2>User-Friendly Interface</h2>
                    <p> Navigate DocStream effortlessly with our user-friendly interface. Designed with simplicity and
                        efficiency in mind, our platform offers an intuitive layout that makes document management a
                        breeze.</p>

                </div>
            </div>
        </div>
    </div>

    <footer class="footer mt-auto py-3 bg-body-tertiary">
        <div class="container text-center">
            <span class="text-muted">Copyright &copy; 2024 DocStream Team. All rights reserved.</span>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>