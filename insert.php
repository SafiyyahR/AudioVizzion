<!DOCTYPE html>
<html>

<head>

  <title>Saving....</title>
  <!--linking the 2 stylesheets-->
  <link href="main.css" rel="stylesheet" type="text/css">
  <link href="addDeviceStyleSheet.css" rel="stylesheet" type="text/css">
</head>

<body>

  <!-- the details of the device entered in the form-->
  <div id="details">
    <!--the php code below-->
    <?php
    //make the connection
    $host = "localhost";
    $username = "root";
    $password = "";
    $conn = new mysqli($host, $username, $password);
    $validFlag = false;
    //check the connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
      //inform the user tht that connection failed
      echo "<script>alert('The connection failed please try again')</script>";
    } else {
      //sql query used to check if the device catalog id has been entered before
      $uniqueIdQuery = "SELECT * FROM  w1714855_audiovizzion.w1714855_device WHERE w1714855_deviceCatalogID='" .$_POST['dCID'] . "'";
      //get the result of the above sql query
      $result = mysqli_query($conn, $uniqueIdQuery);
      //if there is no record with the id another query is made to insert the details into the device table
      if (!$record = mysqli_fetch_array($result)) {
        if (isset($_POST['vdLensSerialNo'])) {
          //checks if the lensSerialNo has been entered previously
          $uniqueSerialQuery = "SELECT * FROM  w1714855_audiovizzion.w1714855_visual_device WHERE w1714855_vdLensSerialNo='" . $_POST['vdLensSerialNo'] . "'";
          //executing the above query
          $resultLens = mysqli_query($conn, $uniqueSerialQuery);
          //if there is no record with the lensSerialNo another query is made to insert the details into the device table
          if (!$record = mysqli_fetch_array($resultLens)) {
            $validFlag = true;
          } else {
            $validFlag = false;
            echo "<script>alert('The Lens Serial Number has already been entered')</script>";
            echo "<h1 id='insertHeading' >AudioVizzion</h1>";
            echo "<h2>Lens Serial Number has already been entered.</h2>";
            echo "<h3>Click the go back button to direct to the form.</h3>";
          }
        } else {
          $validFlag = true;
        }
      } else {
        //alerts the user that the device catalog id has been entered before
        echo "<script>alert('The Device Catalog Id has already been entered')</script>";
        echo "<h1 id='insertHeading' >AudioVizzion</h1>";
        echo "<h2>Device Catalog ID has already been entered.</h2>";
        echo "<h3>Click the go back button to direct to the form.</h3>";
      }
      if ($validFlag) {
        $sql = "INSERT INTO w1714855_audiovizzion.w1714855_device(w1714855_deviceCatalogID, w1714855_deviceCatalogName,w1714855_deviceDescrip,w1714855_deviceAvailabilityStatus)
         VALUES ('" . $_POST['dCID'] . "','" . $_POST['dCName'] . "','" . $_POST['dDescript'] . "','" . $_POST['availabilityStatus'] . "')";
        //exceuting the sql query above
        mysqli_query($conn, $sql);
        //display the entered details of the form
        echo "<h2>Details Entered</h2>";
        echo "<h3>Device Catalog ID: </h3>" . $_POST['dCID'] . "<br>";
        echo "<h3>Device Catalog Name: </h3>" . $_POST['dCName'] . "<br>";
        echo "<h3>Device Catalog Description: </h3>" . $_POST['dDescript'] . "<br>";
        echo "<h3>Device Availability: </h3>" . $_POST['availabilityStatus'] . "<br>";
        //check if the value of typeDevice has been set
        if (isset($_POST['typeDevice'])) {
          //checks if typeDevice is equal to hearing
          if ($_POST['typeDevice'] == "hearing") {
            //if so then the insert query is made for the hearingDevice table
            $hSqlInsert = "INSERT INTO w1714855_audiovizzion.w1714855_hearing_device (w1714855_hdDeviceID, w1714855_hdMake, w1714855_hdModel)
            VALUES ((SELECT w1714855_deviceCatalogID FROM w1714855_AudioVizzion.w1714855_Device WHERE w1714855_deviceCatalogID='" . $_POST['dCID'] . "'),'" . $_POST['hdMake'] . "','" . $_POST['hdModel'] . "');";
            //executes the above query
            mysqli_multi_query($conn, $hSqlInsert);
            //displays to the user the hearing device details
            echo "<h3>Hearing Device Make: </h3>" . $_POST['hdMake'] . "<br>";
            echo "<h3>Hearing Device Model: </h3>" . $_POST['hdModel'] . "<br>";
            //checks if vTypeDevice is equal to frame
          } else if ($_POST['vTypeDevice'] == "frame") {
            //if so then the insert query is made for the visualDevice table
            $fSqlInsert = "INSERT INTO w1714855_audiovizzion.w1714855_visual_device(w1714855_vdDeviceID, w1714855_vdFrFlag, w1714855_vdLensFlag,w1714855_vdFrBrand,w1714855_vdFrModel)
            VALUES ((SELECT w1714855_deviceCatalogID FROM w1714855_AudioVizzion.w1714855_Device WHERE w1714855_deviceCatalogID='" . $_POST['dCID'] . "'), true, false,'" . $_POST['frBrand'] . "','" . $_POST['frModel'] . "');";
            //executes the above queries
            mysqli_multi_query($conn, $fSqlInsert);
            //displays to the user the visual device details
            echo "<h3>Frame Make: </h3>" . $_POST['frBrand'] . "<br>";
            echo "<h3>Frame Model: </h3>" . $_POST['frModel'] . "<br>";
            //else if the user selects both or lens in the form then this section would execute
          } else {
            //checks if the lensSerialNo has been entered previously
            $uniqueSerialQuery = "SELECT * FROM  w1714855_audiovizzion.w1714855_visual_device WHERE w1714855_vdLensSerialNo='" . $_POST['vdLensSerialNo'] . "'";
            //executing the above query
            $resultLens = mysqli_query($conn, $uniqueSerialQuery);
            //if there is no record with the lensSerialNo another query is made to insert the details into the device table
            if (!$record = mysqli_fetch_array($resultLens)) {
              //then if the vTypeDevice is equal to lens
              if ($_POST['vTypeDevice'] == "lens") {
                //if so then the insert query is made for the visualDevice table
                $lSqlInsert = "INSERT INTO w1714855_audiovizzion.w1714855_visual_device(w1714855_vdDeviceID, w1714855_vdFrFlag, w1714855_vdLensFlag, w1714855_vdLensSerialNo, w1714855_vdLensVisionType, w1714855_vdLensTint, w1714855_vdLensThinnessLevel)
                VALUES ((SELECT w1714855_deviceCatalogID FROM w1714855_AudioVizzion.w1714855_Device WHERE w1714855_deviceCatalogID='" . $_POST['dCID'] . "'), false, true,'" . $_POST['vdLensSerialNo'] . "','" . $_POST['vdLensVisionType'] . "','" . $_POST['vdLensTint'] . "','" . $_POST['vdLensThinnessLevel'] . "');";
                //executes the sql query above 
                mysqli_multi_query($conn, $lSqlInsert);

                //displays the details entered
                echo "<h3>Lens Serial Number: </h3>" . $_POST['vdLensSerialNo'] . "<br>";
                echo "<h3>Lens Vision Type: </h3>" . $_POST['vdLensVisionType'] . "<br>";
                echo "<h3>Lens Tint: </h3>" . $_POST['vdLensTint'] . "<br>";
                echo "<h3>Lens Thinness Level: </h3>" . $_POST['vdLensThinnessLevel'] . "<br>";

                //if the vTypeDevice equal to both
              } else if ($_POST['vTypeDevice'] == "both") {

                //if so then the insert query is made for the visualDevice table
                $sSqlInsert = "INSERT INTO w1714855_audiovizzion.w1714855_visual_device(w1714855_vdDeviceID, w1714855_vdFrFlag, w1714855_vdLensFlag,w1714855_vdFrBrand,w1714855_vdFrModel, w1714855_vdLensSerialNo, w1714855_vdLensVisionType, w1714855_vdLensTint, w1714855_vdLensThinnessLevel)
                VALUES ((SELECT w1714855_deviceCatalogID FROM w1714855_AudioVizzion.w1714855_Device WHERE w1714855_deviceCatalogID='" . $_POST['dCID'] . "'), true, true,'" . $_POST['frBrand'] . "','" . $_POST['frModel'] . "','" . $_POST['vdLensSerialNo'] . "','" . $_POST['vdLensVisionType'] . "','" . $_POST['vdLensTint'] . "','" . $_POST['vdLensThinnessLevel'] . "');";

                //executes the sql query above
                mysqli_multi_query($conn, $sSqlInsert);

                //displays the details entered
                echo "<h3>Frame Make: </h3>" . $_POST['frBrand'] . "<br>";
                echo "<h3>Frame Model: </h3>" . $_POST['frModel'] . "<br>";
                echo "<h3>Lens Serial Number: </h3>" . $_POST['vdLensSerialNo'] . "<br>";
                echo "<h3>Lens Vision Type: </h3>" . $_POST['vdLensVisionType'] . "<br>";
                echo "<h3>Lens Tint: </h3>" . $_POST['vdLensTint'] . "<br>";
                echo "<h3>Lens Thinness Level: </h3>" . $_POST['vdLensThinnessLevel'] . "<br><br>";
              }
              //if the serialNo has been entered before the user gets an alert message
            } else {
              echo "<script>alert('The Lens Serial Number has already been entered')</script>";
              echo "<h1 id='insertHeading' >AudioVizzion</h1>";
              echo "<h2>Lens Serial Number has already been entered.</h2>";
              echo "<h3>Click the go back button to direct to the form.</h3>";
            }
          }
        }
        //a successful alert to the user is given if all the details have been entered correctly
        echo "<script>alert('The new device details have been added')</script>";
      }
    }
    //close the connection
    mysqli_close($conn);
    ?>
    <!--once the user clicks the button it takes them to the addDevice.html-->
    <button class="goBackButton" onclick='window.location.assign("addDevice.html")'>GO BACK</button>
  </div>
  <footer>
    <!--to get the copyright sypmbol-->
    &copy; w1714855_AudioVizzion | All rights Reserved
  </footer>
</body>

</html>