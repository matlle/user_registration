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

class Input {
	
	public static function get($name) {
		return isset($_GET[$name]) ? self::htmlspecialcharsEx($_GET[$name]) : NULL;
	}

	public static function post($name) {
		return isset($_POST[$name]) ? self::htmlspecialcharsEx($_POST[$name]) : NULL;
	}

	public static function htmlspecialcharsEx($string) {
		return trim(htmlspecialchars($string, ENT_QUOTES, 'UTF-8'));
	}
	
	public static function cryptoRandSecure($min, $max) {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public static function getCryptoRandSecure($length) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[self::cryptoRandSecure(0, $max)];
        }
        return $token;
    }


	

}
