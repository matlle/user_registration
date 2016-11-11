<?php 
/*
##############################################
#     User registration app                  #
#                                            #
#	@@ -=::MATLLE::=-                    #
#	@ paso.175@gmail.com                 #
#	@ martial.babo@matlle.com            #
##############################################
*/



require_once 'includes/config.php';
require_once 'includes/header.php';
require_once 'includes/navbar.php';
require_once 'Input.php';

// Data from the REST webservice userapi.php
$data = json_decode(file_get_contents(BASE_URL . "rest/userapi.php?fetch=all")); 

?>

  <div class="container">

	<div class="panel panel-default">
	  <div class="panel-heading">Registered Users</div>
	  <div class="panel-body">
        <p>REST api: <strong>/rest/userapi.php?fetch=all</strong> provide data of all registered users and theirs details</p>
        <p>REST api: <strong>/rest/userapi.php?fetch=user_id(integer)</strong> provide data of one registered user via his unique user_id</p>
      </div>
	  
	  <table class="table">
	      <thead>
	          <tr>
	              <th>User Id</th>
	              <th>User Name</th>
	              <th>Email</th>
	              <th>Password</th>
	              <th>Permissions</th>
	          </tr>
	      </thead>
	      <tbody>
	          <?php foreach($data as $d) { ?>
	              <?php foreach($d as $user) { ?>
	              <tr>
	                  <td><?php echo Input::htmlspecialcharsEx($user->user_id); ?></td>
	                  <td><?php echo Input::htmlspecialcharsEx($user->user_name); ?></td>
	                  <td><?php echo Input::htmlspecialcharsEx($user->user_email); ?></td>
	                  <td><?php echo Input::htmlspecialcharsEx($user->user_password); ?></td>
	                  <td><?php echo Input::htmlspecialcharsEx($user->user_permissions); ?></td>
	              </tr>
	              <?php } ?>
	         <?php } ?>
	     </tbody>
	  </table>
	</div>

  </div>


<?php require_once 'includes/footer.php'; ?>
