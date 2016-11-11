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

require_once 'Database.php';
require_once 'Input.php';


class User {

	public function __construct() {
		//
	} 

	public function Register($name, $email, $password, $permissions) {
        $user_name = Input::htmlspecialcharsEx($name); // Try to sanitize the inputs
        $user_email = Input::htmlspecialcharsEx($email);
        $user_password = Input::htmlspecialcharsEx($password);
        $user_permissions = Input::htmlspecialcharsEx($permissions);

        if($user_permissions != 'Administrator' && $user_permissions != 'User') // If wrong permissions
        	return 'Error 1: Wrong user permissions. Valid permissions are: Administrator or User'; 

        // Some contraints check
        if(empty($user_name) || strlen($user_name) > 50)
        	return 'Error 2: User name is required and it must not exceed 50 characters';

        if(empty($user_password) || strlen($user_password) > 150)
        	return 'Error 2: User password is required and it must not exceed 150 characters';

        if(empty($user_email) || strlen($user_email) > 150)
        	return 'Error 2: User email is required and it must not exceed 150 characters';

        if(!filter_var($user_email, FILTER_VALIDATE_EMAIL))
        	return 'Error 2: This e-mail address is not valid';


        $data['user_name'] = $user_name; 
        $data['user_email'] = $user_email;
        $data['user_password'] = crypt($user_password, Input::getCryptoRandSecure(16)); // crypt user password
        $data['user_permissions'] = $user_permissions;

		$db = Database::getInstance(); // Get an instance of the database, with the singleton pattern
		
		try {
		    $bool = $db->transaction('user', $data); // We use transaction to registrate the user
		    return "1";  // Successfull
        } catch(Exception $e) {
        	return 'Error 0: Internal server error'; // Send back this message if any error happen in the database processing
        }

	}


    // Return user data via the user_id
	public function GetById($user_id) {
		$db = Database::getInstance();
		$result = $db->select('SELECT * FROM user WHERE user_id = :user_id', array('user_id' => $user_id));
		return $result;
	}

    // Return all registared user data
	public function GetAll() {
		$db = Database::getInstance();
		$result = $db->select('SELECT * FROM user ORDER BY user_id DESC');
		return $result;
	}


	

}
