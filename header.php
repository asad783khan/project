<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration | DLMS</title>
    <link rel="stylesheet" href="../css/admin_register.css">
</head>
<body>
    <div class="container">
        <h1>Admin Registration</h1>
        <form id="register-form" action="admin_register.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="hidden" name="role" value="Admin">

            <button type="submit">Register</button>
        </form>
        <a href="index.html" class="go-back">Go Back</a>
    </div>

    <!-- Dropdown Example -->
    <div class="dropdown">
        <button class="dropbtn">Register</button>
        <div class="dropdown-content">
            <a href="/auth/admin_login.html" onclick="handleDropdown('Admin')">Admin</a>
            <a href="#" onclick="handleDropdown('Teacher')">Teacher</a>
            <a href="#" onclick="handleDropdown('Student')">Student</a>
        </div>
    </div>

    <script src="admin_register.js"></script>
</body>
</html>
