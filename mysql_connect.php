<?php

$con = mysqli_connect("localhost", "cmaraj1","E2wIEugReU5GE7V","cmaraj1_catalog_project");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// //This stops SQL Injection in POST vars 
//   foreach ($_POST as $key => $value) { 
//     $_POST[$key] = mysql_real_escape_string($value); 
//   } 

//   //This stops SQL Injection in GET vars 
//   foreach ($_GET as $key => $value) { 
//     $_GET[$key] = mysql_real_escape_string($value); 
//   }

define("BASE_URL", "http://cmaraj1.dmitstudent.ca/DMIT2025/week1/camera-week1/");


?>
<head>
<link rel="stylesheet" href="<?php echo BASE_URL ?>style.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>