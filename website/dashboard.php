<?php

session_start();

if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit;
}

$name = $_SESSION["student_name"];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Welcome | CampusConnect</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<nav class="navbar">

    <div class="logo">
        CampusConnect
    </div>

    <div>
        <a href="logout.php">
            Logout
        </a>
    </div>

</nav>

<div class="container">

    <div class="card center">

        <div class="badge">
            🎉 Login Successful
        </div>

        <h1 style="font-size:45px;">
            Welcome to CampusConnect!
        </h1>

        <p class="subtitle">
            Welcome, <?= htmlspecialchars($name) ?>.
        </p>

        <a
            href="logout.php"
            class="btn primary"
        >
            Logout
        </a>

    </div>

</div>

</body>
</html>
