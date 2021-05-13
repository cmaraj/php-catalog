<?php 
    include("../mysql_connect.php");
?>

<head>
    <title>Camera Catalog - Login</title>

        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <link rel="stylesheet" href="<?php echo BASE_URL ?>style.css">


    <!-- Latest compiled and minified JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>

<?php
$userName = $_POST['username'];
$passWord = $_POST['password'];

if (($userName == "ace") && ($passWord == "catalog")){
    session_start(); 
    
    $_SESSION['cameracatalog123!'] = session_id(); 
    
	if(isset($_SESSION['ref'])){
		$ref = $_SESSION['ref'];
		header("Location:$ref");
	}else{
		header("Location:display.php"); 
	}
}else {
	
	if($userName != "" && $passWord !=""){
        $msg = "Invalid Login"; // just for testing; in a real site, we wouldn't echo something before the doctype, body, etc.
	}
}
?>
<div class="login">
    <h2>Please Login</h2>
    <form id="myform" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="submit">&nbsp;</label>
            <input type="submit" name="submit" value="Login" class="btn btn-info">
        </div>
    </form>
</div>


<?php
if($msg){
	echo "<div class=\"alert alert-warning login\">$msg</div>";
}
?>


<div class="side-menu">
			<h2>Menu</h2>

			<a href="../display.php">All Cameras</a><br />

		</div>










