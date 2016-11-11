<?php
/*
##############################################
# oXyShop: User registration app             #
##############################################
*/

    $script_name = explode('/', $_SERVER['SCRIPT_NAME']);
    $script_file_name = end($script_name);

?>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">User registration app</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php echo $script_file_name == 'index.php' ? 'class="active"' : ''; ?>>
                <a href="index.php">Register</a>
            </li>

            <li <?php echo $script_file_name == 'registered_users.php' ? 'class="active"' : ''; ?>>
                <a href="registered_users.php">User Details</a>
            </li>
          </ul>
          
        </div><!--/.nav-collapse -->
      </div>
    </nav>