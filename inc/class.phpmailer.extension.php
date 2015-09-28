<?php

Class extendedPhpmailer extends PHPMailer { 
 	function sendEmail() {
 		$currentlyTesting = (string)$GLOBALS['cfg']->testing;
 		if ($currentlyTesting=='N') {
			# First send email
			$result = $this->Send();
			
			# Log email with send result
			$timestamp = date("YmdHis") . str_pad(rand(0,999), 4,'0',STR_PAD_LEFT);
			$filename = 'logs/email/'.$timestamp.'.xml';
			$xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><eml />");
			$fields = array('ErrorInfo','From','FromName','Sender','Subject','Body','AltBody','Host','Port');
			foreach ($fields as $f) $xml->addChild($f,htmlspecialchars($this->$f));
			$addr = $xml->addChild('toAddresses');
			$addresses = $this->getToAddresses();
			foreach ($addresses as $k=>$v) {
				$toAdd = $addr->addChild('address');
				if (!empty($v[0])) $toAdd->addChild('emailAddress',$v[0]);
				if (!empty($v[1])) $toAdd->addChild('name',$v[1]);
			}
			$attachments = $this->getAttachments();
			if (!empty($attachments)) {
				$attachm = $xml->addChild('attachments');
				foreach ($attachments as $a) {
					$attm = $attachm->addChild('attachment',$a[0]);
				}
			}
			$timestamp = date("YmdHis") . str_pad(rand(0,999), 4,'0',STR_PAD_LEFT);
			$filename = 'logs/email/'.$timestamp.'.xml';
			file_put_contents($filename, $xml->asXml());
			
			# insert log file entry into db
			$l = new emaillog;
			$l->elg_xml = $filename;
			$l->elg_result = $this->ErrorInfo;
			$l->elg_send_datetime = date("Y-m-d H:i:s");
			if (!empty($_SESSION['user']['id'])) $l->elg_usr_id = $_SESSION['user']['id'];
			$l->Save();
			
			# return result
			return $result;
 		} else {
 			return true;
 		}
 	}
	
}

?>