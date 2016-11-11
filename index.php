<?php
/*
##############################################
#     User registration app                  #
#                                            #
#	@@ -=::MATLLE::=-                        #
#	@ paso.175@gmail.com                     #
#	@ martial.babo@matlle.com                #
##############################################
*/

require_once 'includes/config.php'; 
require_once 'includes/header.php'; 
require_once 'includes/navbar.php'; 
require_once 'Input.php';
    
        // Data from the HTML form to store in the database via the SOAP webservice
        if(isset($_POST) && !empty($_POST)) {
          $user_name = Input::post('user_name');
          $user_email = Input::post('user_email');
          $user_password = Input::post('user_password');
          $password_confirmation = Input::post('password_confirmation');
          $user_permissions = Input::post('user_permissions');

          if(!$user_name || !$user_email || !$user_password || !$password_confirmation || !$user_permissions) {
              $error = 'All fields are required. Try again please.';

          } else if($password_confirmation != $user_password) {
              $error = 'The password confirmation must match the password. Try again please.';
          } else {

            // Here, the calling of the SOAP webservice wsUser
            $client = new SoapClient($base_url . "wsUser.wsdl");
            $return = $client->Register($user_name, $user_email, $user_password, $user_permissions);
            if($return == '1') {
                header('Location: registered_users.php');
            } else {
              $error = $return;
            }

          }

        } 
?>


    <div class="container">

      <form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <fieldset>
          <legend>Registration</legend>

              <?php if(isset($error) && !empty($error)) { ?>
                <div style="margin-left: 200px; margin-bottom: 5px; color: red;"><?php echo $error; ?></div>
              <?php } ?>

          <div class="form-group form-group-sm">
              <label class="col-sm-2 control-label" for="user_name">Name</label>
              <div class="col-sm-4">
                  <input class="form-control" type="text" name="user_name" id="user_name" placeholder="User name"
                   value="<?php echo (isset($user_name) && !empty($user_name)) ? $user_name : ""; ?>" />
              </div>
          </div>

          <div class="form-group form-group-sm">
              <label class="col-sm-2 control-label" for="user_email">Email</label>
              <div class="col-sm-4">
                  <input class="form-control" type="text" name="user_email" id="user_email" placeholder="example@email.com"
                   value="<?php echo (isset($user_email) && !empty($user_email)) ? $user_email : ""; ?>" />
              </div>
          </div>

          <div class="form-group form-group-sm">
              <label class="col-sm-2 control-label" for="user_password">Password</label>
              <div class="col-sm-4">
                  <input class="form-control" type="password" name="user_password" id="user_password" 
                  placeholder="***************" />
              </div>
          </div>

          <div class="form-group form-group-sm">
              <label class="col-sm-2 control-label" for="password_confirmation">Password confirmation</label>
              <div class="col-sm-4">
                  <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="***************" />
              </div>
          </div>

          <div class="form-group form-group-sm">
              <label class="col-sm-2 control-label" for="user_password">Permissions</label>
              <div class="col-sm-4">
                  <select class="form-control" name="user_permissions" id="user_password">
                      <option value="User"
                       <?php echo (isset($user_permissions) && !empty($user_permissions)) && $user_permissions == 'User'
                        ? 'selected="selected"' : ""; ?> >
                          User
                      </option>

                      <option value="Administrator"
                      <?php echo (isset($user_permissions) && !empty($user_permissions)) && $user_permissions == 'Administrator'
                        ? 'selected="selected"' : ""; ?>
                      >
                      Administrator
                      </option>
                  </select>
              </div>
          </div>

          <div class="form-group form-group-sm" style="margin-left: 180px;">
              <div class="col-sm-2">
                  <button class="form-control btn-primary" type="submit" name="submit">Register</button>
              </div>
          </div>


        </fieldset>

      </form>

    </div> <!-- /container -->



    <?php require_once 'includes/footer.php'; ?>

