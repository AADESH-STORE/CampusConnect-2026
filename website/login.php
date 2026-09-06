<?php

session_start();

include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $login = trim($_POST["login"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM students
            WHERE email = ? OR student_id = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $login, $login);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $student = $result->fetch_assoc();

        if (password_verify($password, $student["password"])) {

            $_SESSION["student_id"] = $student["id"];
            $_SESSION["student_name"] = $student["full_name"];

            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Invalid username or password.";
        }

    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Student Login | CampusConnect</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav class="navbar">

    <div class="logo">
        CampusConnect
    </div>

    <div>
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
    </div>

</nav>

<div class="container">

    <div class="card">

        <h2>STUDENT LOGIN</h2>

        <p class="subtitle">
            Login with your registered credentials.
        </p>

        <?php if ($error): ?>

            <div class="message error">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <div class="form-group">

                <label>
                    Email / Student ID
                </label>

                <input
                    type="text"
                    name="login"
                    placeholder="Email or Student ID"
                    required
                >

            </div>

            <div class="form-group">

                <label>
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                >

            </div>

            <button
                class="btn primary full-btn"
                type="submit"
            >
                LOGIN
            </button>

        </form>

    </div>

</div>

</body>
</html>
