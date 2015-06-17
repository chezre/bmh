<?php

Class pet { 

var $pet_id;
var $pet_rfid;
var $pet_usr_id;
var $pet_name;
var $pet_sex;
var $pet_sterilized;
var $pet_breed;
var $pet_species;
var $pet_birthdate;
var $pet_distinguishing_features;
var $pet_breeder_society;
var $pet_photo_1;
var $pet_photo_2;
var $pet_photo_3;
var $pet_photo_4;
var $pet_general_notes;
var $pet_register_date;
var $pet_weight;
var $pet_next_vaccination_date;
var $pet_invoice_no;
var $pet_status;
var $pet_next_vaccination_vet_usr_id;
var $pet_height;
var $pet_assigned_by_usr_id;
var $pet_certificate_emailed;
var $pet_colour;

function Load($id) {
	if (empty($id)) return false;
    $sql = "SELECT * FROM `pet` where `pet_id` = $id";
    $result = $GLOBALS['db']->select($sql);
    if (!$result) {
    	return false;
    } else {
    	foreach ($result[0] as $k => $v) {
    		$this->$k = stripslashes($v);
    	}
    	return true;
    }
}

function Save() {
	
	if (isset($this->pet_id) && !empty($this->pet_id)) {
	$sql = "
            UPDATE `pet` SET
              `pet_rfid` = '$this->pet_rfid',
              `pet_usr_id` = '$this->pet_usr_id',
              `pet_name` = '$this->pet_name',
              `pet_sex` = '$this->pet_sex',
              `pet_sterilized` = '$this->pet_sterilized',
              `pet_breed` = '$this->pet_breed',
              `pet_species` = '$this->pet_species',
              `pet_birthdate` = '$this->pet_birthdate',
              `pet_distinguishing_features` = '$this->pet_distinguishing_features',
              `pet_breeder_society` = '$this->pet_breeder_society',
              `pet_photo_1` = '$this->pet_photo_1',
              `pet_photo_2` = '$this->pet_photo_2',
              `pet_photo_3` = '$this->pet_photo_3',
              `pet_photo_4` = '$this->pet_photo_4',
              `pet_general_notes` = '$this->pet_general_notes',
              `pet_register_date` = '$this->pet_register_date',
              `pet_weight` = '$this->pet_weight',
              `pet_next_vaccination_date` = '$this->pet_next_vaccination_date',
              `pet_invoice_no` = '$this->pet_invoice_no',
              `pet_status` = '$this->pet_status',
              `pet_next_vaccination_vet_usr_id` = '$this->pet_next_vaccination_vet_usr_id',
              `pet_height` = '$this->pet_height',
              `pet_assigned_by_usr_id` = '$this->pet_assigned_by_usr_id',
			  `pet_certificate_emailed` = '$this->pet_certificate_emailed',
			  `pet_colour` = '$this->pet_colour'
            WHERE
                `pet_id` = '$this->pet_id';";
    } ELSE {
    $sql = "
            INSERT INTO `pet` (
              `pet_rfid`,
              `pet_usr_id`,
              `pet_name`,
              `pet_sex`,
              `pet_sterilized`,
              `pet_breed`,
              `pet_species`,
              `pet_birthdate`,
              `pet_distinguishing_features`,
              `pet_breeder_society`,
              `pet_photo_1`,
              `pet_photo_2`,
              `pet_photo_3`,
              `pet_photo_4`,
              `pet_general_notes`,
              `pet_register_date`,
              `pet_weight`,
              `pet_next_vaccination_date`,
              `pet_invoice_no`,
              `pet_status`,
              `pet_next_vaccination_vet_usr_id`,
              `pet_height`,
              `pet_assigned_by_usr_id`,
			  `pet_certificate_emailed`,
			  `pet_colour`
    ) VALUES (
              '$this->pet_rfid',
              '$this->pet_usr_id',
              '$this->pet_name',
              '$this->pet_sex',
              '$this->pet_sterilized',
              '$this->pet_breed',
              '$this->pet_species',
              '$this->pet_birthdate',
              '$this->pet_distinguishing_features',
              '$this->pet_breeder_society',
              '$this->pet_photo_1',
              '$this->pet_photo_2',
              '$this->pet_photo_3',
              '$this->pet_photo_4',
              '$this->pet_general_notes',
              '$this->pet_register_date',
              '$this->pet_weight',
              '$this->pet_next_vaccination_date',
              '$this->pet_invoice_no',
              '$this->pet_status',
              '$this->pet_next_vaccination_vet_usr_id',
              '$this->pet_height',
              '$this->pet_assigned_by_usr_id',
			  '$this->pet_certificate_emailed',
			  '$this->pet_colour'
    );";
    }
    $result = $GLOBALS['db']->execute($sql);
    $this->pet_id = (empty($this->pet_id)) ? $GLOBALS['db']->connection->lastInsertId() : $this->pet_id;
	
}

# end class	
}

?>