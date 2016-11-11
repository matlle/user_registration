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


require_once '../User.php';
require_once '../Input.php';

set_exception_handler(function ($e) {
	$code = $e->getCode() ?: 400;
	header("Content-Type: application/json", NULL, $code);
	echo json_encode(["error" => $e->getMessage()]);
	exit;
});


$request_method = $_SERVER['REQUEST_METHOD'];

$data = [];

switch($request_method) {
    case 'GET':
        $user = new User();
        if(isset($_GET['fetch'])) {
        	$fetch = (string) Input::get('fetch');
        	if(!empty($fetch)) {
        		if($fetch == 'all') {
        		    $data['data'] = $user->GetAll();
        		} else {
        			$user_id = (int) $fetch;
		            try {
		                if($user->GetById($user_id))
		                	$data['data'] = $user->GetById($user_id);
		            } catch (UnexpectedValueException $e) {
		                throw new Exception("No data found", 404);
		            }
		        }
		    }

		} 
    break;

    default:
        throw new Exception('Method Not Supported', 405);
}

if(empty($data))
	throw new Exception("No data found", 404);

// Send back the data in JSON format
header("Content-Type: application/json");
echo json_encode($data);

