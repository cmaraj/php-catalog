<?php 
    include("../logincheck.php");
    include("../mysql_connect.php");
    $editID = $_GET['id'];

    if(!isset($editID)){
        $newID = mysqli_query($con,"SELECT * FROM camera LIMIT 1") or die (mysql_error());
      
        while($row = mysqli_fetch_array($newID)){
          $editID = $row['cm_id'];
        }
    }
?>

<?php

    if(isset($_POST['delete'])){
        $id = $_GET['id'];
        $deleted = mysqli_query($con,"DELETE FROM camera WHERE cm_id = '$id'"); 
        header('Location: ../display.php');
    }

  if (isset($_POST['submit'])) {

    $valid = 1;

    $newTitle = trim($_POST['title']);
    $newBrand = trim($_POST['brand']);
    $newDescription = trim($_POST['description']);
    $newYear = trim($_POST['year']);
    $newPrice = trim($_POST['price']);
    $newWeather = trim($_POST['weather']);
    $newSensor = trim($_POST['sensor']);
    $newIso = trim($_POST['iso']);
    $newResolution = trim($_POST['resolution']);

    $msgPreError = "\n<div class=\"errorMsg alert alert-danger\" role=\"alert\">";
    $msgPreSuccess = "\n<div class=\"successMsg alert alert-primary\" role=\"alert\">";
    $msgPost = "</div>\n";

        if(strlen($newTitle) < 3){
            $valid = 0;
            $newTitleMsg = "Must insert a camera name longer than 3 characters";
            // echo $msgPreError.$titleValMessage.$msgPost; 
        }
        
        if(strlen($newDescription) < 5 || strlen($newDescription) > 1000){
            $valid = 0;
            $newDescriptionMsg = "Must insert a description between 5 and 1000 characters";
            // echo $msgPreError.$descrValMessage.$msgPost;
        }

        if($newTitle == ""){
          $valid = 0;
          $newTitleMsg = "Must insert a camera name";
        }

        if($newDescription ==""){
          $valid = 0;
          $newDescriptionMsg = "Must insert a description";
        }

        if($newWeather != 1){
          $newWeather = 0;
        }

        if($newBrand == ""){
          $valid = 0;
          $newBrandMsg = "Must select a brand";
        }

        if($newYear == ""){
          $valid = 0;
          $newYearMsg = "Must select a year";
        }

        if($newSensor == ""){
          $valid = 0;
          $newSensorMsg = "Must chose a sensor size";
        }

        if($newPrice == ""){
          $valid = 0;
          $newPriceMsg = "Must enter a price";
        }

        if($newIso == ""){
          $valid = 0;
          $newIsoMsg = "Must enter an iso";
        }

        if($newResolution == ""){
          $valid = 0;
          $newResolutionMsg = "Must chose a resolution";
        }

      
      if ($valid == 1){

            mysqli_query($con, "UPDATE camera SET 
            cm_name = '$newTitle', 
            cm_brand = '$newBrand', 
            cm_description = '$newDescription', 
            cm_year = '$newYear',
            cm_price = '$newPrice',
            cm_weather = '$newWeather',
            cm_sensor = '$newSensor', 
            cm_iso = '$newIso', 
            cm_resolution = '$newResolution' 
            WHERE cm_id = $editID");

        $msgSuccess = "Camera successfully edited";
        // mysqli_query($con,"INSERT INTO camera (cm_image, cm_name, cm_description, cm_brand, cm_year, cm_price, cm_weather, cm_sensor, cm_iso, cm_resolution) VALUES ('$name', '$title', '$description', '$brand', '$year', '$price', '$weather', '$sensor', '$iso', '$resolution')");
      }
    }

    $edit = mysqli_query($con, "SELECT * FROM camera ORDER BY cm_name");

    while ($row = mysqli_fetch_array($edit)){
        $editCm_id = ($row['cm_id']);
        $editImage = ($row['cm_image']);
        $editName = ($row['cm_name']);
        $editDescription = ($row['cm_description']);
        $editBrand = ($row['cm_brand']);
        $editYear = ($row['cm_year']);
        $editPrice = ($row['cm_price']);
        $editWeather = ($row['cm_weather']);
        $editSensor = ($row['cm_sensor']);
        $editIso = ($row['cm_iso']);
        $editResolution = ($row['cm_resolution']);

        // $editImages .= "<a href=\"edit.php?id=$editCm_id\"><img src=\"../thumbs/$editImage\" /></a><br />";
        $editlinks .= "\n<a href=\"edit.php?id=$editCm_id\"><p>". $editName. "</p><img src=\"../thumbs/$editImage\" /></a><br />";

    }

    $edit = mysqli_query($con, "SELECT * FROM camera WHERE cm_id=$editID");

    while ($row = mysqli_fetch_array($edit)){
        $image = ($row['cm_image']);
        $cm_id = ($row['cm_id']);
        $name = ($row['cm_name']);
        $description = ($row['cm_description']);
        $brand = ($row['cm_brand']);
        $year = ($row['cm_year']);
        $price = ($row['cm_price']);
        $weather = ($row['cm_weather']);
        $sensor = ($row['cm_sensor']);
        $iso = ($row['cm_iso']);
        $resolution = ($row['cm_resolution']);

        if($weather > 0){
            $selected = "checked";
          }else{
            $selected = "";
          }
    
    }

?> 

<head>
<title>Camera Catalog - Edit Cameras</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<div class="edit-all-container">
    <div class="insert-form">
      <h1>Edit Camera Info</h1>
          <form  method="POST" onSubmit="return confirm('Are you sure you want to make these changes?')" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['edit.php?id=$editID']); ?>">

          <div class="form-row">
            <div class="form-group col-md-6">
                <label for="brand">Select Camera Brand</label>
                <select class="form-control" id="brand" name="brand">
                <option value="" disabled selected>- select brand -</option>
                  <option value="Canon" <?php if(isset($brand) && $brand == "Canon"){echo "selected";} ?> >Canon</option>
                  <option value="Fujifilm" <?php if(isset($brand) && $brand == "Fujifilm"){echo "selected";} ?>>Fujifilm</option>
                  <option value="Nikon" <?php if(isset($brand) && $brand == "Nikon"){echo "selected";} ?>>Nikon</option>
                  <option value="Panasonic" <?php if(isset($brand) && $brand == "Panasonic"){echo "selected";} ?>>Panasonic</option>
                  <option value="Sony" <?php if(isset($brand) && $brand == "Sony"){echo "selected";} ?>>Sony</option>
                </select>
                <?php if($newBrandMsg){echo $msgPreError.$newBrandMsg.$msgPost;} ?>
              </div>

              <div class="form-group col-md-6">
                  <label for="title">Camera Name</label>
                  <input value="<?php if($name){echo $name;} ?>" type="text" class="form-control" id="title" name="title" placeholder="Camera Name">
                  <?php if($newNameMsg){echo $msgPreError.$newNameMsg.$msgPost;} ?>
                </div>
          </div>
            
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php if($description){echo $description;} ?></textarea>
            <?php if($newDescriptionMsg){echo $msgPreError.$newDescriptionMsg.$msgPost;} ?>
          </div>

        <div class="form-row">
            <div class="weather-padding">
                <div class="form-group form-check col-md-6">
                  <input <?php print ($selected) ?>  class="form-check-input weather-label" value="1" type="checkbox" id="weather" name="weather">
                  <label class="form-check-label" for="weather">
                    Weather Sealed
                  </label>
                </div>
            </div> 

          <div class="form-group col-md-6">
              <label for="year">Select the Model Year</label>
              <select class="form-control" id="year" name="year">
              <option value="" disabled selected>- year camera was made -</option>
              <option value="2021" <?php if(isset($year) && $year == "2021"){echo "selected";} ?>>2021</option>
              <option value="2020" <?php if(isset($year) && $year == "2020"){echo "selected";} ?>>2020</option>
              <option value="2019" <?php if(isset($year) && $year == "2019"){echo "selected";} ?>>2019</option>
              <option value="2018" <?php if(isset($year) && $year == "2018"){echo "selected";} ?>>2018</option>
              <option value="2017" <?php if(isset($year) && $year == "2017"){echo "selected";} ?>>2017</option>
              <option value="2016" <?php if(isset($year) && $year == "2016"){echo "selected";} ?>>2016</option>
              <option value="2015" <?php if(isset($year) && $year == "2015"){echo "selected";} ?>>2015</option>
              <option value="2014" <?php if(isset($year) && $year == "2014"){echo "selected";} ?>>2014</option>
              <option value="2013" <?php if(isset($year) && $year == "2013"){echo "selected";} ?>>2013</option>
              <option value="2012" <?php if(isset($year) && $year == "2012"){echo "selected";} ?>>2012</option>
              <option value="2011" <?php if(isset($year) && $year == "2011"){echo "selected";} ?>>2011</option>
              <option value="2010" <?php if(isset($year) && $year == "2010"){echo "selected";} ?>>2010</option>
              <option value="2009" <?php if(isset($year) && $year == "2009"){echo "selected";} ?>>2009</option>
              <option value="2008" <?php if(isset($year) && $year == "2008"){echo "selected";} ?>>2008</option>
              <option value="2007" <?php if(isset($year) && $year == "2007"){echo "selected";} ?>>2007</option>
              <option value="2006" <?php if(isset($year) && $year == "2006"){echo "selected";} ?>>2006</option>
              <option value="2005" <?php if(isset($year) && $year == "2005"){echo "selected";} ?>>2005</option>
              <option value="2004" <?php if(isset($year) && $year == "2004"){echo "selected";} ?>>2004</option>
              <option value="2003" <?php if(isset($year) && $year == "2003"){echo "selected";} ?>>2003</option>
              <option value="2002" <?php if(isset($year) && $year == "2002"){echo "selected";} ?>>2002</option>
              <option value="2001" <?php if(isset($year) && $year == "2001"){echo "selected";} ?>>2001</option>
              <option value="2000" <?php if(isset($year) && $year == "2000"){echo "selected";} ?>>2000</option>
              <option value="1999" <?php if(isset($year) && $year == "1999"){echo "selected";} ?>>1999</option>
              <option value="1998" <?php if(isset($year) && $year == "1998"){echo "selected";} ?>>1998</option>
              <option value="1997" <?php if(isset($year) && $year == "1997"){echo "selected";} ?>>1997</option>
              <option value="1996" <?php if(isset($year) && $year == "1996"){echo "selected";} ?>>1996</option>
              <option value="1995" <?php if(isset($year) && $year == "1995"){echo "selected";} ?>>1995</option>
              <option value="1994" <?php if(isset($year) && $year == "1994"){echo "selected";} ?>>1994</option>
              <option value="1993" <?php if(isset($year) && $year == "1993"){echo "selected";} ?>>1993</option>
              <option value="1992" <?php if(isset($year) && $year == "1992"){echo "selected";} ?>>1992</option>
              <option value="1991" <?php if(isset($year) && $year == "1991"){echo "selected";} ?>>1991</option>
              <option value="1990" <?php if(isset($year) && $year == "1990"){echo "selected";} ?>>1990</option>
              <option value="1989" <?php if(isset($year) && $year == "1989"){echo "selected";} ?>>1989</option>
              <option value="1988" <?php if(isset($year) && $year == "1988"){echo "selected";} ?>>1988</option>
              <option value="1987" <?php if(isset($year) && $year == "1987"){echo "selected";} ?>>1987</option>
              <option value="1986" <?php if(isset($year) && $year == "1986"){echo "selected";} ?>>1986</option>
              <option value="1985" <?php if(isset($year) && $year == "1985"){echo "selected";} ?>>1985</option>
              </select>
              <?php if($newYearMsg){echo $msgPreError.$newYearMsg.$msgPost;} ?>
            </div>

        </div>
         

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="price">Camera Price</label>
                <input value="<?php if($price){echo $price;} ?>" type="number" min="1" step="any" class="form-control" id="price" name="price" placeholder="ex. 999.99">
                <?php if($newPriceMsg){echo $msgPreError.$newPriceMsg.$msgPost;} ?>
            </div>

              <div class="form-group col-md-6">
              <label for="sensor">Select Sensor Size</label>
              <select class="form-control" id="sensor" name="sensor">
              <option value="" disabled selected>- select sensor size -</option>
                <option value="Full Frame" <?php if(isset($sensor) && $sensor == "Full Frame"){echo "selected";} ?>>Full Frame</option>
                <option value="Crop Sensor" <?php if(isset($sensor) && $sensor == "Crop Sensor"){echo "selected";} ?>>Crop Sensor</option>
                <option value="Micro Four Thirds" <?php if(isset($sensor) && $sensor == "Micro Four Thirds"){echo "selected";} ?>>Micro Four Thirds</option>
              </select>
              <?php if($newSensorMsg){echo $msgPreError.$newSensorMsg.$msgPost;} ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="iso">Cameras Max ISO</label>
                <input value="<?php if($iso){echo $iso;} ?>" type="number" min="0" class="form-control" step="0" id="iso" name="iso" placeholder="ex. 12800">
                <?php if($newIsoMsg){echo $msgPreError.$newIsoMsg.$msgPost;} ?>
            </div>

            <div class="form-group col-md-6">
              <label for="resolution">Camera Max Video Resolution</label>
              <select class="form-control" id="resolution" name="resolution">
              <option value="" disabled selected>- select resolution -</option>
                <option value="720p" <?php if(isset($resolution) && $resolution == "720p"){echo "selected";} ?>>720p</option>
                <option value="1080p" <?php if(isset($resolution) && $resolution == "1080p"){echo "selected";} ?>>1080p</option>
                <option value="4k" <?php if(isset($resolution) && $resolution == "4k"){echo "selected";} ?>>4k</option>
                <option value="6k" <?php if(isset($resolution) && $resolution == "6k"){echo "selected";} ?>>6k</option>
              </select>
              <?php if($newResolutionMsg){echo $msgPreError.$newResolutionMsg.$msgPost;} ?>
            </div>
        </div>

            <button type="submit" class="btn btn-primary" name="submit">
              Edit <?php echo $name ?>
            </button>
            <button type="submit" class="btn btn-danger" name="delete">
              Delete <?php echo $name ?>
            </button>
  
          </form>

          <?php if($msgSuccess){
            echo $msgPreSuccess.$msgSuccess.$msgPost;
          } 
          
          ?>
    </div>
    <div class="edit-container">
        <h3>Select Camera to Edit</h3>
            <div class="edit-links">
                <?php
                echo $editlinks;
                // echo $editImages;
                ?>
            </div>
    </div>
    
          
</div>


    <div class="side-menu">
			<h2>Menu</h2>

			<a href="../display.php">All Cameras</a><br />
			<a href="insert.php">Insert Camera</a><br />
		</div>

