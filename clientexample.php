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

$client = new SoapClient(BASE_URL . "wsUser.wsdl"); 

try {
	// Call the 'Register' method on the webservice. This is a method of User class
    $return = $client->Register('matlle', 'exampel@email.com', 'mysupersecretpassword', 'User');
    var_dump($return);
} catch (Exception $e) {
    echo '<pre>';
    print_r($e);
    echo '</pre>';
}
