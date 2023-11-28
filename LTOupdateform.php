<?php
session_start();

$serverName = "DESKTOP-I0HTBLL\SQLEXPRESS";
    $connectionOptions = [
        "Database" => "WEBAPP",
        "Uid" => "",
        "PWD" => ""
    ];

    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if($conn == false){
        die(print_r(sqlsrv_error(), true));
    }

    $userData = array();

    if (isset($_GET['userid'])) {
        $userid = $_GET['userid'];
        $_SESSION['editUserID'] = $userid; // Store user ID in session for later use
    
        // Prepare the SQL statement to prevent SQL injection
        $sql = "SELECT * FROM USER_DATA WHERE USERID = ?";
        $params = array($userid);
        $stmt = sqlsrv_query($conn, $sql, $params);
    
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    
        $userData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }
    // Function to echo value if it exists
    function value($field, $userData) {
        echo isset($userData[$field]) ? htmlspecialchars($userData[$field]) : '';
    }
    
    function set_selected($currentValue, $fieldValue) {
        if ($currentValue == $fieldValue) {
            echo 'selected';
        }
    }
    
    if (isset($userData['BIRTHDATE']) && $userData['BIRTHDATE'] instanceof DateTime) {
        $birthdate = $userData['BIRTHDATE']->format('Y-m-d');
    } else {
        echo "Birthdate is not set or not a DateTime object.";
    }
    
    ?>


?>
<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="LTOregistration.css">

    <title>Edit Application for Driver's License</title>

    <script type="text/JavaScript">

function showPlacesDropdown(provinceDropdownId, placeSelectId) {
        var provinceDropdown = document.getElementById(provinceDropdownId);
        var placeSelect = document.getElementById(placeSelectId);
        var selectedProvince = provinceDropdown.value;

        placeSelect.innerHTML = '<option value="">Select a City</option>';

        if (selectedProvince !== "") {
            var cities = cityPlaces[selectedProvince];
            for (var i = 0; i < cities.length; i++) {
                var option = document.createElement("option");
                option.value = cities[i];
                option.textContent = cities[i];
                placeSelect.appendChild(option);
            }
        }
    }


        var cityPlaces = {
                "BATANGAS": ["AGONCILLO", "ALITAGTAG", "BALAYAN", "BALETE", "BATANGAS", "BAUAN", "CALACA", "CALATAGAN", "CUENCA", "IBAAN", "LAUREL", "LEMERY", "LIAN", "LIPA", "LOBO", "MABINI", "MALVAR", "MATAASNAKAHOY", "NASUGBU", "PADRE GARCIA", "ROSARIO", "SAN JOSE", "SAN LUIS", "SAN NICOLAS", "SAN PASCUAL", "SANTA TERESITA", "SANTO TOMAS", "TAAL", "TALISAY", "TANAUAN", "TAYSAN", "TINGLOY", "TUY"],
                "CAVITE": ["ALFONSO", "AMADEO", "BACOOR", "CARMONA", "CAVITE CITY", "DASMARINAS", "GENERAL EMILIO AGUINALDO", "GENERAL MARIANO ALVAREZ", "GENERAL TRIAS", "IMUS", "INDANG", "KAWIT", "MAGALLANES", "MENDEZ", "MENDEZ", "NAIC", "NOVELETA", "ROSARIO", "TAGAYTAY CITY", "TANZA", "TERNATE", "TRECE MARTIRES CITY",],
                "LAGUNA": ["ALAMINOS", "BANILAN", "BAY", "BINAN", "CABUYAO", "CALAMBA", "CALAUAN", "CAVINTI", "DEL REMEDIO", "FAMY", "KALAYAAN", "KAY-ANLOG, CALAMBA", "LILIW", "LOS BANOS", "LUISIANA", "MABITAC", "MAGDALENA", "MAJAYJAY", "MAKILING", "MAKATI", "MARIKINA", "MUNTINLUPA", "NAGCARLAN", "PAGSANJAN", "PAETE", "PANGIL", "PARIAN", "PILA", "PUNTA", "REAL", "RIZAL", "SAN ANTONIO", "SAN FRANCISCO", "SAN JUAN", "SAN NARCISO", "SAN PABLO", "SAN PEDRO", "SANTA CRUZ", "SANTA MARIA", "SANTA ROSA", "SANTO ANGEL", "SINILOAN", "TURBINA", "VICTORIA"],
                "NCR": ["CALOOCAN NORTH", "CALOOCAN SOUTH", "LAS PINAS", "MAKATI", "MALABON", "MANDALUYONG", "MANILA", "MARIKINA", "MUNTINLUPA", "NAVOTAS", "PARANAQUE", "PASAY", "PASIG", "PATEROS", "QUEZON CITY", "SAN JUAN", "TAGUIG", "VALENZUELA"],
                "QUEZON": ["AGDANGAN", "ALABAT", "BUENAVISTA", "BURDEOS", "CALAUAG", "CANDELARIA", "CATANAUAN", "DOLORES", "GENERAL LUNA", "GENERAL NAKAR", "GUINAYANGAN", "GUMACA", "INFANTA", "JOMALIG", "LOPEZ", "LUCBAN", "MACALELON", "MAUBAN", "MULANAY", "PADRE BURGOS", "PAGBILAO", "PANUKULAN", "PATNANUNGAN", "PEREZ", "PITOGO", "PLARIDEL", "POLILO", "QUEZON", "REAL", "SAMPALOC", "SAN ANDRES", "SAN ANTONIO", "SAN FRANCISCO", "SAN NARCISO", "SARIAYA", "TAGKAWAYAN", "TIAONG", "UNISAN"],
                "RIZAL": ["ANGONO", "ANTIPOLO", "BARAS", "BINANGONAN", "CAINTA", "CARDONA", "JALA-JALA", "MARIKINA", "MORONG", "PASIG", "PILILLA", "RODRIGUEZ", "SAN MATEO", "SANTO DOMINGO", "TANAY", "TERESA"]
            };

    </script>
</head>
<body>
    <section class="form" style = "margin-top: 1%";>
    <form action="LTOupdated.php" method="post">
        <h1 align="center">APPLICATION FOR DRIVER'S LICENSE</h1>
        


        <div class="container2">
                <p class="title">NAME
                    <span class="italic"><i>(Family name, First name, Middle name)</i></span>
                    
                </p>
              </div>
              <br>
                
                
              <div class="container">
                <div class="row">
                    
                        <label for="lastname">LASTNAME</label>
                        <input type="text" id="lastname" name="lastname">
                    
                        <label for="firstname">FIRSTNAME</label>
                        <input type="text" id="firstname" name="firstname">
                    
                        <label for="middlename">MIDDLENAME</label>
                        <input type="text" id="middlename" name="middlename">
                    
                </div>
            </div>
            <br>
                <br><hr><br>
        
     <div class="container">
        <div class="address">
            <p class="title">PRESENT ADDRESS
                <span class="italic"><i>(No., Street, City/Municipality, Province)</i></span>
            </p><br>

          <div class="center-column">
            <label for="street">Street</label>
            <input type="text" id="street" name="street">
        </div>
        </div>
    </div>
    
    <div class="container">
      <div class="dropdown-container">
          <div class="province-dropdown">
              <span>SELECT A PROVINCE</span>
              <select name='province-dropdown' id="province-dropdown" onchange="showPlacesDropdown('province-dropdown', 'place-select1')">
                  <option value="">Select a Region</option>
                  <option value="NCR">METRO-MANILA</option>
                  <option value="CAVITE">CAVITE</option>
                  <option value="LAGUNA">LAGUNA</option>
                  <option value="BATANGAS">BATANGAS</option>
                  <option value="RIZAL">RIZAL</option>
                  <option value="QUEZON">QUEZON</option>
              </select>
          </div>
          
          <div class="city-dropdown">
              <span>SELECT A CITY/MUNICIPALITY</span>
              <select name="city-dropdown" id="place-select1">
                  <option value="">Select a City/Municipality</option>
              </select>
          </div>
      </div>
  </div>
                    <br><br>

                    <br><hr><br><br>
                  <div class="container">
                    <div class="left-column">
                     <label for="Cont"><b>Tel.NO. / CP NO.:</b></label> <br>
                      <input type="tel" id="Cont" name="Cont" placeholder="Enter Contact"><br>
                      <p></p>
                      </div>

                      <div class="center-column">
                      <label for="Tin"><b>TIN:</b></label> <br><input type="tin" id="Tin" name="Tin" placeholder="xxx-xxx-xxx-xxx"><br>
                      <p></p>
                      </div>

                      <div class="right-column">
                      <label for="Nationality"><b>NATIONALITY:</b></label> <br><input type="text" id="Nationality" name="Nationality"><br>
                      <p></p>
                      </div>
                  </div>
                  
                  
                    
                  <br><hr><br>
                  <div class="container">
                    <div class="left-column">                      
                      <span><b>GENDER</b></span><br>
                      <label for="male">
                        <input type="radio" id="male" name="gender" value="male">
                        Male
                    </label><br>

                       <label for="female">
                    <input type="radio" id="female" name="gender" value="female">
                        Female
                    </label><br>
              
                      <p></p>
                        </div>

                        <div class="center-column">
                      <label for="bday"><b>BIRTH DATE</b><br></label><input type="date" id="bday" name="bday"><br>
                      <p></p>
                      </div>
                    
                    <div class="right-column">
                      <label for="height"><b>HEIGHT(cm)</b></label><br> <input type="text" id="height" name="height">
                      <p></p>
                      <label for="weight"><b>WEIGHT(kg)</b></label><br> <input type="text" id="weight" name="weight">
                      <p></p>
                
                    </div>
                   

                </div>      
                </div>
                </div>
             <div class=submit><input type="submit" value="Submit">
             </div>

    <script>
        window.onload = function() {
            var provinceDropdown = document.getElementById('province-dropdown');

        if (provinceDropdown.value) {
            showPlacesDropdown('province-dropdown', 'place-select1');
        }

        var cityDropdown = document.getElementById('place-select1');
        var selectedCity = "<?php echo isset($userData['CITY']) ? htmlspecialchars($userData['CITY']) : ''; ?>";

        
        for (var i = 0; i < cityDropdown.options.length; i++) {
            if (cityDropdown.options[i].value === selectedCity) {
                cityDropdown.selectedIndex = i;
                break;
            }
        }
    };
        
    </script>


</body>
</html>