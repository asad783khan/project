<?php
// Database connection
include 'db_connect.php';

// Start session
session_start();

// Check if form is submitted
if (isset($_POST['login'])) {
    // Get email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email and password
    if (!empty($email) && !empty($password)) {
        // Prepare and execute SQL query to check credentials
        $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the row
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct, set session variables and redirect to admin dashboard
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_email'] = $user['email'];
                header("Location: ../hod/hod_portal.php");
                exit();
            } else {
                // Incorrect password
                echo "<script>
                        alert('Invalid email or password.');
                        window.location.href = '../auth/admin_login.html';
                      </script>";
            }
        } else {
            // No user found with that email
            echo "<script>
                    alert('Invalid email or password.');
                    window.location.href = '../auth/admin_login.html';
                  </script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Form fields are empty
        echo "<script>
                alert('Please fill in all fields.');
                window.location.href = '../auth/admin_login.html';
              </script>";
    }
}

// Close the database connection
$conn->close();
?>
