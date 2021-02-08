<?php
// Initialize the session

session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";
$papid = $_GET['papid'];
    
$sql = mysqli_query($link,"select * from pap_view where papid='$papid'"); 

$data = mysqli_fetch_array($sql); // fetch data

if(isset($_POST['update'])) // when click on Update button
{
    $papname = $_POST['papname'];
    $papabustruct = $_POST['papabustruct'];
    $pappublisher = $_POST['pappublisher'];
    $uplodedfile = $_POST['uplodedfile'];
	
    $edit = mysqli_query($link,"update pap_view set papname='$papname', papabustruct='$papabustruct' , pappublisher='$pappublisher' , uplodedfile='$uplodedfile' where papid='$papid'");
	
    if($edit)
    {
        header("location:mypaper.php"); 
        exit;
    }  
    mysqli_close($link);
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="./css/style.css">
    <title>journal article</title>
</head>
	
<body>
    <div class="container">
        <form method="POST">
          <input type="text" name="papname" value="<?php echo $data['papname'] ?>" placeholder="Title">
          <input type="text" name="papabustruct" value="<?php echo $data['papabustruct'] ?>" placeholder="Abustruct">
          <input type="text" name="pappublisher" value="<?php echo $data['pappublisher'] ?>" placeholder="publisher">
          <input type="file" name="uplodedfile" value="<?php echo $data['uplodedfile'] ?>" >
          <input type="submit" name="update" value="Update">
        </form>
    </div>
</body>
</html>