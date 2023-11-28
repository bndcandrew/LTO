<?php
$serverName = "DESKTOP-I0HTBLL\SQLEXPRESS";
$connectionOptions = [
    "Database" => "WEBAPP",
    "Uid" => "",
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    $foreignkey = 0;
    $userid = 100;
    // Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Please enter a valid email address.";
    } elseif ($password != $cpassword) {
        echo "Error: Passwords do not match. Please try again.";
    } else {
        // Passwords match, proceed with registration
        // In a real-world scenario, you should use password_hash() to securely store passwords
        $sql = "SELECT * FROM ACCOUNTS WHERE ACCOUNTID = (SELECT MAX(ACCOUNTID) FROM ACCOUNTS)";
        $results = sqlsrv_query($conn, $sql);
       

        if ($results === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($rows === false || sqlsrv_has_rows($results) === false) {
            $foreignkey = 100;
        } else {
            $row = sqlsrv_fetch_array($results);
            $foreignkey = $row['USERID'] + 1;
        }
        
        // Insert user data into the database
        $query = "INSERT INTO ACCOUNTS (EMAIL, PASSWORD, DATE_CREATED, USERID) VALUES (?, ?, GETDATE(), $foreignkey)";
        $params = array($email, $password);

        $stmt = sqlsrv_query($conn, $query, $params);

        if ($stmt === false) {
            // Handle query error
            die(print_r(sqlsrv_errors(), true));
        }

        // Redirect to success.html
        header("Location: LTOlogin.php");
        exit(); // Ensure that script execution stops after the redirect
    }

    sqlsrv_close($conn);
}
?>