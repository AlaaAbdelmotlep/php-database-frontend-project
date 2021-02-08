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
    <link rel="stylesheet" href="./css/animation-style.css">
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
      
      <div class="container" style="margin: 50px auto;">
          <h1 class="text-center">Thanks for submitting your paper</h1><br>
          <?php
                require_once "config.php";
                $sql = "SELECT * FROM reviewer";
                if($result = mysqli_query($link, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            if (empty($row['revpaper'])){
                            echo "<h1>your paper reviewd by .. " . $row['revname'] . "</h1>";
                            }
                        }
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
      <div id="background-wrap">
        <div class="bubble x1"></div>
        <div class="bubble x2"></div>
        <div class="bubble x3"></div>
        <div class="bubble x4"></div>
        <div class="bubble x5"></div>
        <div class="bubble x6"></div>
        <div class="bubble x7"></div>
        <div class="bubble x8"></div>
        <div class="bubble x9"></div>
        <div class="bubble x10"></div>
      </div>
  </body>
</html>