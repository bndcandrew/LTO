<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted username and password
    $enteredEmail = $_POST["email"];
    $enteredPassword = $_POST["password"];

    $serverName = "DESKTOP-I0HTBLL\SQLEXPRESS";
    $connectionOptions = array(
        "Database" => "WEBAPP",
        "Uid" => "",
        "PWD" => ""
    );

    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn == false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Check if form is submitted
    $sql = "SELECT * FROM ACCOUNTS WHERE email = ? AND password = ?";
    $params = array($enteredEmail, $enteredPassword);
    $result = sqlsrv_query($conn, $sql, $params);

    // Check if a row is returned, indicating a successful login
   // During the login process, after verifying the user's credentials
if ($result !== false && sqlsrv_has_rows($result)) {
    // Set user email in the session
    $_SESSION['userEmail'] = $enteredEmail;

    // Set the user ID in the session (assuming this is done somewhere in your code)
    $_SESSION['editUserID'] = $row['USERID'];

    // Redirect to LTOsuccess.php if login is correct
    header("Location: LTOsuccess.php?email=" . urlencode($enteredEmail));
    exit();
}
 else {
        // Display error message if incorrect login
        echo "Incorrect username or password. Please try again.";
    }

    // Close the database connection
    sqlsrv_close($conn);
}
?>
