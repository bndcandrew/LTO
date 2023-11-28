<?php
session_start();

$serverName = "DESKTOP-I0HTBLL\\SQLEXPRESS";
$connectionOptions = [
    "Database" => "WEBAPP",
    "Uid" => "",
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn == false) {
    die(print_r(sqlsrv_errors(), true));
}

$appData = array();

if (isset($_GET['userid'])) {
    $userid = $_GET['userid'];
    $_SESSION['editUserID'] = $userid;



    $sql = "SELECT AD.* FROM APPLICATION_DETAILS AD JOIN USER_DATA UD ON AD.USERID = UD.USERID WHERE AD.USERID = ?";
    $params = array($userid);
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }


    $appData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    
    error_reporting(E_ALL);
ini_set('display_errors', 1);
}

function set_checked($currentValue, $array, $key) {
    if (isset($array[$key]) && $array[$key] == $currentValue) {
        echo 'checked';
    }
}
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="ltoregistration.css">

    <title>Edit Application for Driver's License</title>
    <style>
        .container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    height: auto;
    padding-bottom: 25px;
    padding-top: 25px;
  }
  
  .checkbox-container {
    flex: 0 0 20%;
    margin: 5px; 
    display: flex; 
    flex-direction: column; 
    align-items: center; 
  }

  .checkbox-container input[type="checkbox"] {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 20px;    
    height: 20px;
    background-color: #ffffff; /* Color for the checkbox */
    border: 3px solid #003366; /* Border color for the checkbox */
    border-radius: 3px;
    outline: none;
    margin-right: 5px;
  }

  .checkbox-container input[type="checkbox"]:checked {
    background-color: #ff0000; /* Background color when checked */
    border-color: #000000; /* Border color when checked */
  }
    </style>
</head>

<body>
<section class="form" style = "margin-top: 1%";>

<form action="LTOupdatedLICENSE.php" method="post">


<div>
<div class="container">

              <div class="left-column"><p><b>TYPE OF LICENSE APPLIED(TLA) FOR</b></p>

              <label for="T1">
   <input type="radio" id="T1" name="license" value="STUDENT" <?php set_checked("STUDENT", $appData, "LICENSE_TYPE"); ?>>
   1. STUDENT PERMIT
</label><br>


                <label for="T2">
                    <input type="radio" id="T2" name="license" value="NON-PROFESSIONAL"<?php set_checked("NON-PROFESSIONAL", $appData, "LICENSE_TYPE"); ?>>
                    2. NON-PROFESSIONAL
                </label><br>

        
                <label for="T3">
                    <input type="radio" id="T3" name="license" value="PROFESSIONAL" <?php set_checked("PROFESSIONAL", $appData, "LICENSE_TYPE"); ?>>
                    3. PROFESSIONAL
                </label><br>

              <label for="T4">
                    <input type="radio" id="T4" name="license" value="CONDUCTOR" <?php set_checked("CONDUCTOR", $appData, "LICENSE_TYPE"); ?>>
                    4. CONDUCTOR
                </label></div>

                <div class="checkbox-container">
                    <input type="submit" value="Update License Type">
                </div>
                </div>
</div>
</form>

</section>
</body>
</html>