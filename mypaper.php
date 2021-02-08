<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>journal article</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="./css/style.css">
    
  </head>
	
  <body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="index.php">Journal Article</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="submit.php">Submit article</a>
              </li>
              <li class="nav-item active">
        			<a class="nav-link" href="mypaper.php">My paper</a>
      		  </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <a href="logout.php" class="btn btn-secondary my-2 my-sm-0" role="button" aria-pressed="true">log out</a>
    		</form>
          </div>
      </nav>
	   <div class="container">
           <div class="row mt-4" style="background-color:#ceadad; padding:20px;">
               <div class="col">Tiltle</div>
               <div class="col">Abustruct</div>
               <div class="col">Publisher</div>
               <div class="col">File</div>
               <div class="col">Edit</div>
               <div class="col">Delete</div>
           </div>
           <?php
            require_once "config.php";
            $sql = "call all_submited_paper()";
                if($result = mysqli_query($link, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){?>
                            <div class="row mt-4" style="background-color:#ceadad; padding:20px;">
                                <div class="col"><?php echo $row["papname"]; ?></div>
                                <div class="col"><?php echo $row["papabustruct"]; ?></div>
                                <div class="col"><?php echo $row["pappublisher"]; ?></div>
                                <div class="col"><?php echo $row["uplodedfile"]; ?></div>
                                <div class="col">Edit</div>
                                <div class="col">Delete</div>
                            </div>
                        <?php }
                        // Free result set
                    mysqli_free_result($result);
                    }
                    else {
                    echo "No records matching your query were found.";
                }
                }else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }
               mysqli_close($link);
           ?>
      </div>
  </body>
</html>