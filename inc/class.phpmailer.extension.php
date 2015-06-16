<?php

Class extendedPhpmailer extends PHPMailer { 
 	function sendEmail() {
 		$currentlyTesting = (string)$GLOBALS['cfg']->testing;
 		if ($currentlyTesting=='N') {
 			$this->Send();
 		} else {
 			return true;
 		}
 	}
}

?>