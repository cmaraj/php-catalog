<?php
include("mysql_connect.php");

$editID = $_GET['id'];
?>

<!DOCTYPE html>

<html>
<head>
<title>Camera Catalog</title>
<style type="des$description/css">

</style>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body class="detail-page">
    <div class="flex-camera">
        <div class="flex-image">
            <?php
                $result = mysqli_query($con, "SELECT * FROM camera WHERE cm_id='$editID'") or die (mysqli_query($con));

                while ($row = mysqli_fetch_array($result)){
                    $cm_id = ($row['cm_id']);
                    $image = ($row['cm_image']);
                    $name = ($row['cm_name']);
                    $description = ($row['cm_description']);
                    $brand = ($row['cm_brand']);
                    $year = ($row['cm_year']);
                    $price = ($row['cm_price']);
                    $weather = ($row['cm_weather']);
                    $sensor = ($row['cm_sensor']);
                    $iso = ($row['cm_iso']);
                    $resolution = ($row['cm_resolution']);

                    echo "<div class=\"detail-card\">";
                        echo "<p>$brand</p>";
                        echo "<h2>$name - <span class=\"sensor-text\">$sensor</span> </h2>";
                        echo "<img class=\"detail-camera\" src=\"display/$image\" /><br />";
                        echo "</div>";
                        echo "<div class=\"detail-text\">";
                        echo "<p>$$price</p>";
                        echo "<p>$description</p>";
                        if($weather == 1){
                            echo "<p><strong>Weather Sealed</strong></p> ";
                            }else{
                            echo "<p><strong>Not Weather Sealed</strong></p> ";
                            }
                        echo "<p>Max ISO: $iso</p>";
                        echo "<p>Max Video Resolution: $resolution</p>";
                        echo "</div>";               
                    
                }

            ?>
            </div>
            <!-- /flex-images -->
        <div class="buttons">
            <div>
                <?php 
                    $previous = mysqli_query($con, "SELECT * FROM camera WHERE cm_id < '$editID' ORDER BY cm_id DESC") or die (mysqli_query($con));

                    if($row = mysqli_fetch_array($previous)){
                        echo '<a href="details.php?id='.$row['cm_id'].'"><button class="btn btn-primary" type="button">Previous</button></a>';  
                    }
                ?>
            </div>
            <div>
                <?php

                    $next = mysqli_query($con, "SELECT * FROM camera WHERE cm_id > '$editID' ORDER BY cm_id ASC") or die (mysqli_query($con));

                    if($row = mysqli_fetch_array($next)){
                        echo '<a href="details.php?id='.$row['cm_id'].'"><button class="btn nextbtn btn-primary" type="button">Next</button></a>';  
                    }
                ?>
            </div>
        </div>
        <!-- /buttons -->
    </div>
    <!-- /flex-camera -->
    <div class="side-menu">
        <h2>Menu</h2>

        <a href="display.php">All Cameras</a><br />
        <a href="admin/insert.php">Insert Camera</a><br />
        <br />
        <?php echo "\n<a href=\"admin/edit.php?id=$editID\">Edit $name</a>"?><br />
        <br />
        <a href="display.php?displayby=cm_brand&displayvalue=<?php echo $brand?>"><?php echo $brand?> Cameras</a>

    </div>
</body class="detail-page">

</html>