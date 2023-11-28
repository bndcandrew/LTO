<?php
$enteredEmail = $_GET['email'] ?? null;

if ($enteredEmail === null) {
    echo "Email not provided.";
    exit();
}

$serverName = "DESKTOP-I0HTBLL\SQLEXPRESS";
$connectionOptions = [
    "Database" => "WEBAPP",
    "Uid" => "",
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn == false) {
    die(print_r(sqlsrv_errors(), true));
}

// Assuming you have a column named 'USERID' in your 'ACCOUNTS' table
$sql = "SELECT USERID, LAST_NAME, FIRST_NAME FROM USER_DATA WHERE USERID = (SELECT USERID FROM ACCOUNTS WHERE email = ?)";
$params = array($enteredEmail);
$result = sqlsrv_query($conn, $sql, $params);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

$userDetails = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml"> 
  <head>
    <meta charset="utf-8">
    <meta name="viewport" 
    content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="form.css">
    <title>LTO Form</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #eceff1; /* Change the background color as per your preference */
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .card {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 300px; /* Adjust width as needed */
            margin-top: 50px; /* Adjust margin as needed */
        }

        h2 {
            color: #444;
            margin-bottom: 20px;
        }

        button {
            background-color: #45a049; /* Adjust button color as needed */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px; /* Rounded corners for the button */
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%; /* Button width is the same as the card width */
        }

        button:hover {
            background-color: #37803b;
        }

        a {
            color: white;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
  </head>
  <body>
  <div class="card">
        <h2>Welcome, <?php echo $userDetails['FIRST_NAME']; ?> <?php echo $userDetails['LAST_NAME']; ?></h2>
        <button><a href="LTOrecords.php?email=<?php echo urlencode($enteredEmail); ?>">View my records</a></button>
        <button><a href="LTOlogin.php" class="edit-btn">Log Out</a></button>

    </div>
</body>
  </body>