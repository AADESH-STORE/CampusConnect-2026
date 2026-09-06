<?php
include "db.php";

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"]);
    $student_id = trim($_POST["student_id"]);
    $email = trim($_POST["email"]);
    $college_name = trim($_POST["college_name"]);
    $location = trim($_POST["location"]);
    $event_name = trim($_POST["event_name"]);
    $password = $_POST["password"];

    if (
        empty($full_name) ||
        empty($student_id) ||
        empty($email) ||
        empty($college_name) ||
        empty($location) ||
        empty($event_name) ||
        empty($password)
    ) {
        $error = "Please fill in all required fields.";
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO students
                (full_name, student_id, email, college_name,
                 location, event_name, password)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sssssss",
            $full_name,
            $student_id,
            $email,
            $college_name,
            $location,
            $event_name,
            $hashed_password
        );

        if ($stmt->execute()) {
            $message = "Registration successful! You can now log in.";
        } else {
            $error = "Student ID or email may already be registered.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Registration | CampusConnect</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav class="navbar">
    <div class="logo">CampusConnect</div>

    <div>
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
    </div>
</nav>

<div class="container">

    <div class="card">

        <h2>Student Registration</h2>

        <p class="subtitle">
            Register for CampusConnect 2026
        </p>

        <?php if ($message): ?>
            <div class="message">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="message error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <label>Full Name</label>
                <input
                    type="text"
                    name="full_name"
                    placeholder="Enter your full name"
                    required
                >
            </div>

            <div class="form-group">
                <label>Student ID</label>
                <input
                    type="text"
                    name="student_id"
                    placeholder="Enter student ID"
                    required
                >
            </div>

            <div class="form-group">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    placeholder="student@example.com"
                    required
                >
            </div>

            <div class="form-group">
                <label>College Name</label>
                <input
                    type="text"
                    name="college_name"
                    placeholder="Enter college name"
                    required
                >
            </div>

            <div class="form-group">
                <label>Location</label>
                <input
                    type="text"
                    name="location"
                    placeholder="Enter your location"
                    required
                >
            </div>

            <div class="form-group">
                <label>Event</label>

                <select name="event_name" required>
                    <option value="">Select Event</option>
                    <option value="Tech Fest 2026">Tech Fest 2026</option>
                    <option value="Cultural Fest 2026">Cultural Fest 2026</option>
                    <option value="Sports Meet 2026">Sports Meet 2026</option>
                    <option value="Coding Hackathon 2026">
                        Coding Hackathon 2026
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Create a password"
                    required
                >
            </div>

            <button class="btn primary full-btn" type="submit">
                Create Registration
            </button>

        </form>

    </div>

</div>

</body>
</html>
