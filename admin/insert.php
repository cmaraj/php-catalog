<?php 
    include("../logincheck.php");
    include("../mysql_connect.php");
?>

<div class="flex-insert">
<?php
  if (isset($_POST['submit'])) {

    $originalsFolder = "../originals/";
    $thumbsFolder = "../thumbs/";
    $displayFolder = "../display/";
    $valid = 1;

    $title = trim($_POST['title']);
    $brand = trim($_POST['brand']);
    $description = trim($_POST['description']);
    $year = trim($_POST['year']);
    $price = trim($_POST['price']);
    $weather = trim($_POST['weather']);
    $sensor = trim($_POST['sensor']);
    $iso = trim($_POST['iso']);
    $resolution = trim($_POST['resolution']);

    $msgPreError = "\n<div class=\"errorMsg alert alert-danger\" role=\"alert\">";
    $msgPreSuccess = "\n<div class=\"successMsg alert alert-primary\" role=\"alert\">";
    $msgPost = "</div>\n";


    if (($_FILES["file"]["type"] == "image/gif")|| ($_FILES["file"]["type"] == "image/jpeg")||($_FILES["file"]["type"] == "image/pjpeg")|| ($_FILES["file"]["type"] == "image/png"))
    {
      
    }else{
      $fileMsg = "Not an image file";
      $valid = 0;
    }


    if(!($_FILES["file"]["size"] < 4000000)) {
      $fileMsg .= "File is too big<br />";
      $valid = 0;
    }
      if ($_FILES["file"]["error"] > 0)
        {
        //$strValidationMessage .= "An error of type " . $_FILES["file"]["error"] . " occured<br />";
      $valid = 0;
        }

        if(strlen($title) < 3){
            $valid = 0;
            $titleMsg = "Must insert a camera name longer than 3 characters";
            // echo $msgPreError.$titleValMessage.$msgPost; 
        }
        
        if(strlen($description) < 5 || strlen($description) > 1000){
            $valid = 0;
            $descriptionMsg = "Must insert a description between 5 and 1000 characters";
            // echo $msgPreError.$descrValMessage.$msgPost;
        }

        if($title ==""){
          $valid = 0;
          $titleMsg = "Must insert a camera name";
        }

        if($description ==""){
          $valid = 0;
          $descriptionMsg = "Must insert a description";
        }

        if($weather != 1){
          $weather = 0;
        }

        if($brand == ""){
          $valid = 0;
          $brandMsg = "Must select a brand";
        }

        if($year == ""){
          $valid = 0;
          $yearMsg = "Must select a year";
        }

        if($sensor == ""){
          $valid = 0;
          $sensorMsg = "Must chose a sensor size";
        }

        if($price == ""){
          $valid = 0;
          $priceMsg = "Must enter a price";
        }

        if($iso == ""){
          $valid = 0;
          $isoMsg = "Must enter an iso";
        }

        if($resolution == ""){
          $valid = 0;
          $resolutionMsg = "Must chose a resolution";
        }

      
      if ($valid == 1){
          move_uploaded_file($_FILES["file"]["tmp_name"], $originalsFolder   . $_FILES["file"]["name"]);
          
        $thisFile = $originalsFolder . basename( $_FILES['file']['name']);
        //createThumbnail( originalFile, destFolder);
        createThumbnail($thisFile, $thumbsFolder, 200 );
        createThumbnail($thisFile, $displayFolder, 500 );
        
        // as well as uploading and creating thumbs, lets put filename in a DB
        $name = basename( $_FILES['file']['name']);
          

        mysqli_query($con,"INSERT INTO camera (cm_image, cm_name, cm_description, cm_brand, cm_year, cm_price, cm_weather, cm_sensor, cm_iso, cm_resolution) VALUES ('$name', '$title', '$description', '$brand', '$year', '$price', '$weather', '$sensor', '$iso', '$resolution')");
        
        echo "<div class=\"insert-image\">";
        echo "<p><img src=\"../thumbs/$name\" />";
        echo  $_FILES["file"]["name"] . " has been uploaded";
        echo "</div>";
      }else {
        // $strValidationMessage = "Please fill in all required fields";
      // echo $msgPreError.$strValidationMessage.$msgPost;
    }
    
    }//end if submit
    
    function createThumbnail($file, $folder, $newwidth) {

      list($width, $height) = getimagesize($file);
      $newheight = $newwidth;
      
      $thumb = imagecreatetruecolor($newwidth, $newheight);
      $source = imagecreatefromstring(file_get_contents($file));
      
      imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
      $newFileName = $folder .  basename( $_FILES['file']['name']);// get original filename for dest filename

      imagejpeg($thumb,$newFileName,80);
      imagedestroy($thumb); 
      imagedestroy($source); 

      // echo "<p><img src=\"$newFileName\" />";
    }
?> 

<head>
<title>Camera Catalog - Insert Cameras</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
    
    <div class="insert-form">
      <h1>Insert New Camera</h1>
          <form  method="POST"  enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

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
                <?php if($brandMsg){echo $msgPreError.$brandMsg.$msgPost;} ?>
              </div>

              <div class="form-group col-md-6">
                  <label for="title">Camera Name</label>
                  <input value="<?php if($title){echo $title;} ?>" type="text" class="form-control" id="title" name="title" placeholder="Camera Name">
                  <?php if($titleMsg){echo $msgPreError.$titleMsg.$msgPost;} ?>
                </div>
          </div>
            
          <div class="form-row">
              <div class="form-group col-md-6">
                <label for="file">Insert Image</label>
                <input type="file" class="form-control-file" id="file" name="file">
                <?php if($fileMsg){echo $msgPreError.$fileMsg.$msgPost;} ?>
              </div>
            
              <div class="weather-padding">
                <div class="form-group form-check col-md-6">
                  <input class="form-check-input weather-label" value="1" type="checkbox" id="weather" name="weather">
                  <label class="form-check-label" for="weather">
                    Weather Sealed
                  </label>
                </div>
              </div> 

          </div>
            
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php if($description){echo $description;} ?></textarea>
            <?php if($descriptionMsg){echo $msgPreError.$descriptionMsg.$msgPost;} ?>
          </div>


          <div class="form-group">
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
              <?php if($yearMsg){echo $msgPreError.$yearMsg.$msgPost;} ?>
            </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="price">Camera Price</label>
                <input value="<?php if($price){echo $price;} ?>" type="number" min="1" step="any" class="form-control" id="price" name="price" placeholder="ex. 999.99">
                <?php if($priceMsg){echo $msgPreError.$priceMsg.$msgPost;} ?>
            </div>

              <div class="form-group col-md-6">
              <label for="sensor">Select Sensor Size</label>
              <select class="form-control" id="sensor" name="sensor">
              <option value="" disabled selected>- select sensor size -</option>
                <option value="Full Frame" <?php if(isset($sensor) && $sensor == "Full Frame"){echo "selected";} ?>>Full Frame</option>
                <option value="Crop Sensor" <?php if(isset($sensor) && $sensor == "Crop Sensor"){echo "selected";} ?>>Crop Sensor</option>
                <option value="Micro Four Thirds" <?php if(isset($sensor) && $sensor == "Micro Four Thirds"){echo "selected";} ?>>Micro Four Thirds</option>
              </select>
              <?php if($sensorMsg){echo $msgPreError.$sensorMsg.$msgPost;} ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="iso">Cameras Max ISO</label>
                <input value="<?php if($iso){echo $iso;} ?>" type="number" min="0" class="form-control" step="0" id="iso" name="iso" placeholder="ex. 12800">
                <?php if($isoMsg){echo $msgPreError.$isoMsg.$msgPost;} ?>
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
              <?php if($resolutionMsg){echo $msgPreError.$resolutionMsg.$msgPost;} ?>
            </div>
        </div>

            <button type="submit" class="btn btn-primary" name="submit">
              Submit
            </button>
  
          </form>
    </div>
</div>

    <div class="side-menu">
			<h2>Menu</h2>

			<a href="../display.php">All Cameras</a><br />
			<a href="insert.php">Insert Camera</a><br />

		</div>
