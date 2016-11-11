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

require_once 'User.php';

$server = new SOAPServer('wsUser.wsdl', ['encoding' => 'UTF-8']);
$server->setClass('User');
$server->handle();
