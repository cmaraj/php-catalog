<?php
include("mysql_connect.php");
  
    $search = trim($_POST['search']);

    $searchTerm = mysqli_query($con, "SELECT * FROM camera WHERE 
    cm_image LIKE '%$search%' 
    OR cm_name LIKE '%$search%' 
    OR cm_description LIKE '%$search%' 
    OR cm_brand LIKE '%$search%' 
    OR cm_year LIKE '%$search%' 
    OR cm_price LIKE '%$search%' 
    OR cm_weather LIKE '%$search%' 
    OR cm_sensor LIKE '%$search%'
	OR cm_iso LIKE '%$search%'
	OR cm_resolution LIKE '%$search%' ");

?>

<!DOCTYPE html>

<html>
<head>
<title>Camera Catalog</title>
<style type="text/css">


</style>

</head>
	<body>
		<nav>
			<div class="brands">
				<a href="display.php?displayby=cm_brand&displayvalue=Canon">Canon</a>
				<a href="display.php?displayby=cm_brand&displayvalue=Fujifilm">Fujifilm</a>
				<a href="display.php?displayby=cm_brand&displayvalue=Nikon">Nikon</a>
				<a href="display.php?displayby=cm_brand&displayvalue=Panasonic">Panasonic</a>
				<a href="display.php?displayby=cm_brand&displayvalue=Sony">Sony</a>
			</div>
			

		</nav>

		<div class="search">
			<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
					<div class="search-bar">
						<label for="search"></label>
						<input
						type="text"
						class="search-input"
						name="search"
						id="search"
						placeholder="Search..."
						value="<?php if($search){echo $search;} ?>">  
						<button type="submit" class="btn-search" name="submit">search</button>
							<?php //if($searchMsg){echo $msgPreError.$searchMsg.$msgPost;} ?>
					</div>
					
            </form>
		</div>
		

		<div id="main">

		<?php

			require("mysql_connect.php");

			// $displayby = $_GET['displayby'];
			// $displayvalue = $_GET['displayvalue'];

			// $result = mysqli_query($con,"SELECT * FROM camera ORDER BY RAND()") or die (mysql_error());
			
			// if(isset($displayby) && isset($displayvalue)) {
			// 	$result = mysqli_query($con,"SELECT * FROM camera WHERE $displayby  LIKE '$displayvalue' ") or die (mysql_error());
            // }
            
            if(isset($_POST['submit'])){

                if($search !=""){
                        while ($row = mysqli_fetch_array($searchTerm)) {
                            $cm_id = ($row['cm_id']);
                            $name = ($row['cm_name']);
                            $brand = ($row['cm_brand']);
                            $year = ($row['cm_year']);
                            $price = ($row['cm_price']);
                            $description = ($row['cm_description']);
                            $image = ($row['cm_image']);
            
                        echo "<div class=\"camera-content\">\n";
                        echo "<div class=\"camera-image\">";
                        echo "<a href=\"details.php?id=$cm_id\"><img src=\"thumbs/$image\" /></a><br />";
                        echo "</div>";
                        // echo "<img src=\"artwork/thumbs100/$artwork\" class=\"cdImage\" />";
                        // echo "<a href=\"details.php?id=$id\"><img src=\"details/$filename\" /></a><br />";
                        echo "<div class=\"camera-right\">";
			echo "<span class=\"displayInfo $brand\">". $brand ."</span><br />\n";
			echo "<a href=\"details.php?id=$cm_id\" class=\"displayName\">". $name ."</a><br />\n";
			echo "</br>";
			echo "<span class=\"displayInfo\">". $year ."</span><br />\n";
			echo '<div class="addDesc">'.substr($description,0,100).'</div>';
			echo "</div>";

			echo "<div class=\"camera-bottom\">";
				echo "<div class=\"displayPrice\">$$price</div><br />\n";
				echo "<div class=\"btn-more\"><a href=\"details.php?id=$cm_id\">More info</a></div><br />";
			echo "</div>";
                        
                        
                    echo "\n</div>\n";
                    }
                }else{
                    echo "<div class=\"warning\">No Results</div>";
                }

                if(mysqli_num_rows($searchTerm) <= 0){
                    echo "<div class=\"warning\">No Results</div>";
                }

                
            }

			

		?>
		</div>
		<div class="side-menu">
			<h2>Menu</h2>

			<a href="display.php">All Cameras</a><br />
			<a href="admin/insert.php">Insert Camera</a><br />

			<div class="hide">
				<h3>Sensor Type</h3>
					<a href="display.php?displayby=cm_sensor&displayvalue=Full Frame">Full Frame</a>
					<a href="display.php?displayby=cm_sensor&displayvalue=Crop Sensor">Crop Sensor</a>
					<a href="display.php?displayby=cm_sensor&displayvalue=Micro Four Thirds">Micro Four Thirds</a>
			</div>

			<h3>Newest Cameras</h3>
				<a href="display.php?displayby=cm_year&displayvalue=2020">2020</a><br />
				<a href="display.php?displayby=cm_year&displayvalue=2019">2019</a><br />

			<div class="hide">
				<h3>Prices Ranges</h3>
					<a href="price1.php">Beginner</a>
					<a href="price2.php">Intermediate</a>
					<a href="price3.php">Professional</a>
			</div>
				

		</div>

	</body>
</html>

