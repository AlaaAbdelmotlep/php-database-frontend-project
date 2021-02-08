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
      			<a href="login.php" class="btn btn-secondary my-2 my-sm-0" style="margin-right: 5px;" role="button" aria-pressed="true">login</a>
				<a href="singup.php" class="btn btn-secondary my-2 my-sm-0" style="margin-right: 5px;" role="button" aria-pressed="true">sign up</a>
    		</form>
          </div>
      </nav>
	 <div class="container">
		 <section class="showarea">
			 <div id="bg">
				 <img alt="book" src="img/book.jpg">
			 </div>
		 </section>
		 
		 <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 search-btn' style="top: -150px; margin: 0 auto;">
			<form class="navbar-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
			  <div class="input-group">
				<input class="form-control" type="text" name="search" placeholder="Search">
				<span class="input-group-btn">
				  <button type="submit" value="Submit" class="btn btn-default">
					<span class='glyphicon glyphicon-search'></span>
				  </button>
				</span>
			  </div>
			</form>
      	</div>
         <?php
        require_once "config.php";
        if (!empty($_REQUEST['search'])) {

        $search = mysqli_real_escape_string($link ,$_REQUEST['search']);     

        $sql = "SELECT * FROM paper WHERE papname LIKE '%".$search."%'"; 
        $r_query = mysqli_query($link , $sql); 

        while ($row = mysqli_fetch_array($r_query)){  ?>
        <div class="row mt-2" style="background-color:#ceadad; padding:10px;">
            <div class="col"><p>Title</p></div>
            <div class="col"><p>Abustruct</p></div>
            <div class="col"><p>Publisher</p></div>
            <div class="col"><p>uploadfile</p></div>
        </div>
        <div class="row mt-2" style="background-color:#ceadad; padding:10px;">
            <div class="col"><?php echo $row["papname"]; ?></div>
            <div class="col"><?php echo $row["papabustruct"]; ?></div>
            <div class="col"><?php echo $row["pappublisher"]; ?></div>
            <div class="col"><?php echo $row["uplodedfile"]; ?></div>
        </div> 
        <?php
  
        }  
        }
        mysqli_close($link);
        ?>
      </div>
  </body>
</html>
