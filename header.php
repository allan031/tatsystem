<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Auto logout after 5 hours -->
    <meta http-equiv="refresh" content="18000;url=/tatsystem/logout.php">

    <title>Turn Around Time System</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <!-- ✅ Use your compiled Tailwind + custom CSS -->
    <link href="/tatsystem/assets/css/style.css" rel="stylesheet"> <!-- includes Tailwind build output -->
    <link href="/tatsystem/assets/css/custom.css" rel="stylesheet">
    <link href="/tatsystem/assets/css/loader.css" rel="stylesheet">
    <link href="/tatsystem/assets/css/toastify.min.css" rel="stylesheet">
    <link href="/tatsystem/assets/DataTable/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- ✅ Font Awesome -->
    <link rel="stylesheet" href="/tatsystem/assets/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- ✅ JS libraries -->
    <script src="/tatsystem/assets/js/jquery-3.6.4.js"></script>
    <script src="/tatsystem/assets/js/loader.js" defer></script>
    <script src="/tatsystem/assets/js/sweetalert2.all.min.js"></script>
    <script src="/tatsystem/assets/js/toastify.js"></script>
    <script src="/tatsystem/assets/DataTable/js/jquery.dataTables.min.js"></script>

    <!-- ✅ Prevent back navigation -->
    <script>
    function preventBack() {
        window.history.forward();
    }
    setTimeout(preventBack, 0);
    window.onunload = function() {
        null
    };
    </script>
</head>

<body class="bg-blue-300 min-h-screen flex flex-col m-0 p-0">
    <header>
        <?php
        if (basename($_SERVER['PHP_SELF'], '.php') != 'login') {
            // include header/navigation if needed
        }
        ?>
    </header>