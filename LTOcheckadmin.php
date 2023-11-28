<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from form
    $username = $_POST["email"];
    $password = $_POST["password"];

    // Check if the entered credentials are for the admin (case-sensitive)
    if ($username === 'ADMIN' && $password === 'ADMIN') {
        $_SESSION['ADMIN'] = true;  // Set a session variable to identify admin login
        header('Location: LTOreportsALL.php');
        exit();
    } else {
        // If credentials are incorrect, redirect back to the login page or show an error message
        header('Location: LTOadmin_login.php?error=InvalidCredentials'); // You can customize the error handling based on your needs
        exit();
    }
} else {
    // If the form is not submitted, redirect back to the login page
    header('Location: LTOlogin.php');
    exit();
}
?>
