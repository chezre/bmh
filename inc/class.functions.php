<?php

class functions {
	function test() {
	 	$sql = "SHOW TABLES;";
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return false;
	    } else {
		 	return $result;
		}
	}
	
	function getTotalMicrochips() {
		$sql = "SELECT count(*) `total` FROM `pet`;";
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return 0;
	    } else {
		 	return $result[0]['total'];
		}
	}
	
	function getAllMicrochips($offset=null,$count=null) {
		if (!is_null($count)) $limit = "LIMIT $count";
		if (!is_null($offset)) $limit = "LIMIT $offset,$count";
		$sql = "SELECT 
	pet_id,
	pow_id,
	usr_id,
    pet_register_date `Registered Date`,
	CONCAT(pow_first_name,' ',pow_last_name) `Owner Name`,
	usr_email `Email`,
	pet_rfid `Chip`,
	pet_name `Pet Name`,
	CASE 
		WHEN vet_usr_id IS NOT NULL THEN `vet_name` 
		WHEN `pet_assigned_by_usr_id` = pet_usr_id THEN CONCAT(pow_first_name,' ',pow_last_name) 
		WHEN wel_usr_id IS NOT NULL THEN `wel_name` 
		WHEN adm_usr_id IS NOT NULL THEN 'Admin' 
		ELSE 'Unknown'
	END `Injector Name`,
	CASE 
		WHEN vet_usr_id IS NOT NULL THEN 'Vet' 
		WHEN `pet_assigned_by_usr_id` = pet_usr_id THEN 'DIY' 
		WHEN wel_usr_id IS NOT NULL THEN 'Welfare' 
		WHEN adm_usr_id IS NOT NULL THEN 'Admin' 
		ELSE 'Unknown'
	END `Injector User Type`
 FROM `pet`
 LEFT JOIN `user` ON pet_usr_id = usr_id
 LEFT JOIN `petOwner` ON pet_usr_id = pow_usr_id
 LEFT JOIN `vet` ON vet_usr_id = `pet_assigned_by_usr_id`	
 LEFT JOIN `welfareOrganisation` ON wel_usr_id = `pet_assigned_by_usr_id`	
 LEFT JOIN `adminStaff` ON adm_usr_id = `pet_assigned_by_usr_id`
 	/*WHERE `pet_assigned_by_usr_id` IS NOT NULL*/
 ORDER BY `pet_id` $limit;";
	/*echo $sql;
	exit();*/
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return false;
	    } else {
		 	return $result;
		}
	}
	
	function getTotalRegistrations() {
		$sql = "SELECT count(*) `total` FROM `pet` where `pet_usr_id` is not null;";
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return 0;
	    } else {
		 	return $result[0]['total'];
		}
	}
	
	function getAllRegistrations($offset=null,$count=null) {
		if (!is_null($count)) $limit = "LIMIT $count";
		if (!is_null($offset)) $limit = "LIMIT $offset,$count";
		$sql = "SELECT 
	pet_id,
	pow_id,
	usr_id,
	pet_register_date `Registered Date`,
	CONCAT(pow_first_name,' ',pow_last_name) `Owner Name`,
	usr_email `Email`,
	pet_rfid `Chip`,
	pet_name `Pet Name`,
	CASE 
		WHEN vet_usr_id IS NOT NULL THEN `vet_name` 
		WHEN `pet_assigned_by_usr_id` = pet_usr_id THEN CONCAT(pow_first_name,' ',pow_last_name) 
		WHEN wel_usr_id IS NOT NULL THEN `wel_name` 
		WHEN adm_usr_id IS NOT NULL THEN 'Admin' 
		ELSE 'Unknown'
	END `Injector Name`,
	CASE 
		WHEN vet_usr_id IS NOT NULL THEN 'Vet' 
		WHEN `pet_assigned_by_usr_id` = pet_usr_id THEN 'DIY' 
		WHEN wel_usr_id IS NOT NULL THEN 'Welfare' 
		WHEN adm_usr_id IS NOT NULL THEN 'Admin' 
		ELSE 'Unknown'
	END `Injector User Type`
 FROM `pet`
 LEFT JOIN `user` ON pet_usr_id = usr_id
 LEFT JOIN `petOwner` ON pet_usr_id = pow_usr_id
 LEFT JOIN `vet` ON vet_usr_id = `pet_assigned_by_usr_id`	
 LEFT JOIN `welfareOrganisation` ON wel_usr_id = `pet_assigned_by_usr_id`	
 LEFT JOIN `adminStaff` ON adm_usr_id = `pet_assigned_by_usr_id`
 	where `pet_usr_id` is not null
 ORDER BY `pet_register_date` DESC $limit;";
	/*echo $sql;
	exit();*/
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return false;
	    } else {
		 	return $result;
		}
	}
	
	function getTotalCompletedRegistrations() {
		$sql = "SELECT count(*) `total` FROM `pet` where `pet_usr_id` is not null and `pet_certificate_emailed` IS NOT NULL;";
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return 0;
	    } else {
		 	return $result[0]['total'];
		}
	}
	
	function getAllCompletedRegistrations($offset=null,$count=null) {
		if (!is_null($count)) $limit = "LIMIT $count";
		if (!is_null($offset)) $limit = "LIMIT $offset,$count";
		$sql = "SELECT 
	pet_id,
	pow_id,
	usr_id,
	pet_register_date `Registered Date`,
	CONCAT(pow_first_name,' ',pow_last_name) `Owner Name`,
	usr_email `Email`,
	pet_rfid `Chip`,
	pet_name `Pet Name`,
	CASE 
		WHEN vet_usr_id IS NOT NULL THEN `vet_name` 
		WHEN `pet_assigned_by_usr_id` = pet_usr_id THEN CONCAT(pow_first_name,' ',pow_last_name) 
		WHEN wel_usr_id IS NOT NULL THEN `wel_name` 
		WHEN adm_usr_id IS NOT NULL THEN 'Admin' 
		ELSE 'Unknown'
	END `Injector Name`,
	CASE 
		WHEN vet_usr_id IS NOT NULL THEN 'Vet' 
		WHEN `pet_assigned_by_usr_id` = pet_usr_id THEN 'DIY' 
		WHEN wel_usr_id IS NOT NULL THEN 'Welfare' 
		WHEN adm_usr_id IS NOT NULL THEN 'Admin' 
		ELSE 'Unknown'
	END `Injector User Type`
 FROM `pet`
 LEFT JOIN `user` ON pet_usr_id = usr_id
 LEFT JOIN `petOwner` ON pet_usr_id = pow_usr_id
 LEFT JOIN `vet` ON vet_usr_id = `pet_assigned_by_usr_id`	
 LEFT JOIN `welfareOrganisation` ON wel_usr_id = `pet_assigned_by_usr_id`	
 LEFT JOIN `adminStaff` ON adm_usr_id = `pet_assigned_by_usr_id`
 WHERE `pet_certificate_emailed` IS NOT NULL
 ORDER BY `pet_register_date` DESC $limit;";
	/*echo $sql;
	exit();*/
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return false;
	    } else {
		 	return $result;
		}
	}
	
	function getTotalIncompleteRegistrations() {
		$sql = "SELECT count(*) `total` FROM `pet` where `pet_usr_id` is not null and (`pet_usr_id` is null or `pet_certificate_emailed` IS NULL);";
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return 0;
	    } else {
		 	return $result[0]['total'];
		}
	}
	
	function getAllIncompleteRegistrations($offset=null,$count=null) {
		if (!is_null($count)) $limit = "LIMIT $count";
		if (!is_null($offset)) $limit = "LIMIT $offset,$count";
		$sql = "SELECT 
	pet_id,
	pow_id,
	usr_id,
	pet_register_date `Registered Date`,
	CONCAT(pow_first_name,' ',pow_last_name) `Owner Name`,
	usr_email `Email`,
	pet_rfid `Chip`,
	pet_name `Pet Name`,
	CASE 
		WHEN vet_usr_id IS NOT NULL THEN `vet_name` 
		WHEN `pet_assigned_by_usr_id` = pet_usr_id THEN CONCAT(pow_first_name,' ',pow_last_name) 
		WHEN wel_usr_id IS NOT NULL THEN `wel_name` 
		WHEN adm_usr_id IS NOT NULL THEN 'Admin' 
		ELSE 'Unknown'
	END `Injector Name`,
	CASE 
		WHEN vet_usr_id IS NOT NULL THEN 'Vet' 
		WHEN `pet_assigned_by_usr_id` = pet_usr_id THEN 'DIY' 
		WHEN wel_usr_id IS NOT NULL THEN 'Welfare' 
		WHEN adm_usr_id IS NOT NULL THEN 'Admin' 
		ELSE 'Unknown'
	END `Injector User Type`
 FROM `pet`
 LEFT JOIN `user` ON pet_usr_id = usr_id
 LEFT JOIN `petOwner` ON pet_usr_id = pow_usr_id
 LEFT JOIN `vet` ON vet_usr_id = `pet_assigned_by_usr_id`	
 LEFT JOIN `welfareOrganisation` ON wel_usr_id = `pet_assigned_by_usr_id`	
 LEFT JOIN `adminStaff` ON adm_usr_id = `pet_assigned_by_usr_id`
where `pet_usr_id` is not null and (`pet_usr_id` is null or `pet_certificate_emailed` IS NULL)
 ORDER BY `pet_register_date` DESC $limit;";
	/*echo $sql;
	exit();*/
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return false;
	    } else {
		 	return $result;
		}
	}
	
	function getTotalSearchedChips($rfid,$email) {
		
		$where = '';
		if (!empty($rfid)&&!empty($email)) {
			$where = "pet_rfid like '%$rfid%' and usr_email like '%$email%'";
		} else {
			if (!empty($rfid)) $where = "pet_rfid like '%$rfid%'";
			if (!empty($email)) $where = "usr_email like '%$email%'";
		}

		$usrJoin = (!empty($email)) ? ' LEFT JOIN `user` ON pet_usr_id = usr_id':'';
		$sql = "SELECT count(*) `total` FROM `pet` $usrJoin where $where;";
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return 0;
	    } else {
		 	return $result[0]['total'];
		}
	}
	
	function getAllSearchedChips($offset=null,$count=null,$rfid,$email) {
		$where = '';
		if (!empty($rfid)&&!empty($email)) {
			$where = "pet_rfid like '%$rfid%' and usr_email like '%$email%'";
		} else {
			if (!empty($rfid)) $where = "pet_rfid like '%$rfid%'";
			if (!empty($email)) $where = "usr_email like '%$email%'";
		}
		if (!is_null($count)) $limit = "LIMIT $count";
		if (!is_null($offset)) $limit = "LIMIT $offset,$count";
		$sql = "SELECT 
	pet_id,
	pow_id,
	usr_id,
	pet_register_date `Registered Date`,
	CONCAT(pow_first_name,' ',pow_last_name) `Owner Name`,
	usr_email `Email`,
	pet_rfid `Chip`,
	pet_name `Pet Name`,
	CASE 
		WHEN vet_usr_id IS NOT NULL THEN `vet_name` 
		WHEN `pet_assigned_by_usr_id` = pet_usr_id THEN CONCAT(pow_first_name,' ',pow_last_name) 
		WHEN wel_usr_id IS NOT NULL THEN `wel_name` 
		WHEN adm_usr_id IS NOT NULL THEN 'Admin' 
		ELSE 'Unknown'
	END `Injector Name`,
	CASE 
		WHEN vet_usr_id IS NOT NULL THEN 'Vet' 
		WHEN `pet_assigned_by_usr_id` = pet_usr_id THEN 'DIY' 
		WHEN wel_usr_id IS NOT NULL THEN 'Welfare' 
		WHEN adm_usr_id IS NOT NULL THEN 'Admin' 
		ELSE 'Unknown'
	END `Injector User Type`
 FROM `pet`
 LEFT JOIN `user` ON pet_usr_id = usr_id
 LEFT JOIN `petOwner` ON pet_usr_id = pow_usr_id
 LEFT JOIN `vet` ON vet_usr_id = `pet_assigned_by_usr_id`	
 LEFT JOIN `welfareOrganisation` ON wel_usr_id = `pet_assigned_by_usr_id`	
 LEFT JOIN `adminStaff` ON adm_usr_id = `pet_assigned_by_usr_id`
where $where
 ORDER BY `pet_register_date` DESC $limit;";
	/*echo $sql;
	exit();*/
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return false;
	    } else {
		 	return $result;
		}
	}
	
	function getAllSearchedVets($offset=null,$count=null,$srchValue) {
		$where = "usr_email like '%$srchValue%' or vet_name like '%$srchValue%'";
		if (!is_null($count)) $limit = "LIMIT $count";
		if (!is_null($offset)) $limit = "LIMIT $offset,$count";
		$sql = "SELECT 
	vet_id,
	usr_id,
	vet_name `VET Name`,
	usr_email `Email`,
	vet_practice_name `Practice Name`
 FROM `vet`
 LEFT JOIN `user` ON vet_usr_id = usr_id
 where $where
 ORDER BY `vet_name` DESC $limit;";
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return false;
	    } else {
		 	return $result;
		}
	}
	
	function getChartData() {
		$date = date("Y-m-01",strtotime('5 months ago'));
		$sql ="select monthname(pet_register_date) `month`,sum(case when `pet_usr_id` is not null and (`pet_usr_id` is null or `pet_certificate_emailed` IS NULL) then 1 else 0 end) `incomplete`, sum(case when `pet_usr_id` is not null and `pet_certificate_emailed` IS NOT NULL then 1 else 0 end) `complete` from pet
where pet_register_date >= '$date'
group by 1
			order by pet_register_date";
		
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return false;
	    } else {
		 	return $result;
		}
	}
	
	function getAllPetsForUser($userId) {
		$sql = "SELECT * FROM `pet` WHERE pet_usr_id = $userId and pet_status != 'deceased';";
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return false;
	    } else {
		 	return $result;
		}		
	}
	
	function getAllOwnersToBeReminded() {
		$sql = "SELECT `pet_id`,`pet_rfid`,`pet_name`,`pet_next_vaccination_date`,`pet_next_vaccination_vet_usr_id`,concat(pow_first_name, ' ',pow_last_name) `name`,usr_id,usr_email FROM `pet` inner join `petOwner` on pow_usr_id = pet_usr_id inner join `user` on usr_id = pet_usr_id WHERE `pet_next_vaccination_date` = date(DATE_ADD(now(), INTERVAL 7 DAY))";
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return false;
	    } else {
		 	return $result;
		}		
	}
	
	function petSearch($rfid=null,$ownerName=null,$ownerEmail=null) {
	 	$where = (!empty($rfid)) ? "pet_rfid = $rfid":'';
	 	if (!empty($ownerName)) {
			$where .= (!empty($where)) ? " AND ":'';
			$where .= "(pow_first_name LIKE '%$ownerName%' OR pow_last_name LIKE '%$ownerName%')";
		}
		if (!empty($ownerEmail)) {
			$where .= (!empty($where)) ? " AND ":'';	
			$where .= "usr_email LIKE '%$ownerEmail%'";
		}
		$where .= (!empty($where)) ? " AND ":'';
		$where .= 'pet_status != "deceased"';
	 	
		$sql = "select pet_id,pet_photo_1,pet_usr_id,pet_rfid,pet_name,CONCAT(pow_first_name,' ',pow_last_name) `Owner Name`,pow_cellphone_no, usr_email,pet_register_date from `pet`
					left join `user` on usr_id = pet_usr_id
					left join `petOwner` on usr_id = pow_usr_id 
					WHERE $where 
					ORDER BY pet_rfid;";
		$result = $GLOBALS['db']->select($sql);
		if (empty($result)) {
	    	return false;
	    } else {
		 	return $result;
		}
	}
	
	function getVaccinationHistory($petId) {
		$sql = "SELECT * FROM `vaccinationHistory` WHERE `vhi_pet_id` = $petId ORDER BY `vhi_date` DESC;";
		$result = $GLOBALS['db']->select($sql);
		if (empty($result)) {
	    	return false;
	    } else {
		 	return $result;
		}
	}
	
	function getNewVets() {
		$sql = "SELECT 'Vet' user_type,usr_email email,vet_name name,vet_cellphone_no cellphone,vet_registration_date registration_date,usr_id FROM `vet` inner join `user` on vet_usr_id = usr_id WHERE `vet_verified_by_admin` = 'N'
union all
SELECT 'Welfare Organisation' user_type,usr_email,wel_contact_fullname,wel_contact_mobile_number,wel_registration_date,usr_id FROM `welfareOrganisation`
inner join `user` on wel_usr_id = usr_id WHERE `wel_verified_by_admin` = 'N'";
		$result = $GLOBALS['db']->select($sql);
		if (empty($result)) {
	    	return false;
	    } else {
		 	return $result;
		}
	}
		
	function getVaccinationsForPet($species) {
		$sql = "SELECT * FROM `vaccinations` WHERE `vac_animal_species` = '$species' ORDER BY `vac_grouping`;";
		$result = $GLOBALS['db']->select($sql);
		if (empty($result)) {
	    	return false;
	    } else {
		 	return $result;
		}
	}
	
	function getAllSpecies() {
		$sql = "SELECT * FROM `species`;";
		$result = $GLOBALS['db']->select($sql);
		if (empty($result)) {
	    	return false;
	    } else {
		 	return $result;
		}
	}

	function populatePetImageForEdit($imgNumber,$imageFilename=null,$showImage=false) {
	 	$display = ($showImage) ? '':'display:none;';
	 	$image = (empty($imageFilename)) ? 'img/dog_cartoon.png':$imageFilename;
		$return = '<input type="file" id="photo_'.$imgNumber.'" name="pet_photo_'.$imgNumber.'" onchange="showPreview(\'photo_'.$imgNumber.'\',\'imgPreview'.$imgNumber.'\')"><br />
					<img src="'.$image.'" id="imgPreview'.$imgNumber.'" width="192" height="144" class="previewImg" style="'.$display.'" />
                    <img src="img/delete.png" onclick="removePhoto(\'pet_photo_'.$imgNumber.'\',\'imgPreview'.$imgNumber.'\',this);" style="cursor:pointer;'.$display.'" title="delete image" />
                    <input type="hidden" name="pet_photo_'.$imgNumber.'" id="pet_photo_'.$imgNumber.'" value="'.$imageFilename.'" />';
		return $return;
	}
	
	function getPetStatuses() {
		$sql = "SELECT * FROM `status`;";
		$result = $GLOBALS['db']->select($sql);
		if (empty($result)) {
	    	return false;
	    } else {
		 	return $result;
		}		
	}
	
	function checkForTransfers($usrId) {
		$sql = "SELECT * FROM `inTransfer` where trf_new_usr_id = $usrId and (trf_accepted_date is null or trim(trf_accepted_date)='') and (trf_rejected_date is null or trim(trf_rejected_date)='');";
		$result = $GLOBALS['db']->select($sql);
		if (empty($result)) {
	    	return false;
	    } else {
		 	return $result;
		}		
	}
	
	function getInjectorInfo($usrId){
		$implantedBy['name'] = '';
		$implantedBy['contactNo'] = '';
		$implantedBy['identityNo'] = '';
		
		/* add new entities as they require */
		
		$vet = new extendedVet();
		$welfare = new extendedWelfareOrganisation();
		$admin = new extendedAdminStaff();
		$pow = new extendedPetOwner();
		
		switch(true) {
			case ($vet->LoadByUserId($usrId)):
				$implantedBy['name'] = $vet->vet_name;
				$implantedBy['contactNo'] = $vet->vet_practice_telephone_no;
				$implantedBy['identityNo'] = $vet->vet_statutory_id;
				break;
			case ($welfare->LoadByUserId($usrId)):
				$implantedBy['name'] = $welfare->wel_contact_fullname;
				$implantedBy['contactNo'] = $welfare->wel_contact_number;
				$implantedBy['identityNo'] = '';
				break;
			case ($admin->LoadByUserId($usrId)):
				$implantedBy['name'] = 'BringMeHome Admin';
				$implantedBy['contactNo'] = (string)$GLOBALS['cfg']->info->contactNumber;
				$implantedBy['identityNo'] = '';
				break;
			case ($pow->LoadByUserId($usrId)):
				$implantedBy['name'] = trim($pow->pow_first_name . ' ' . $pow->pow_last_name);
				$implantedBy['contactNo'] = (empty($pow->pow_cellphone_no)) ? $pow->pow_telephone_no:$pow->pow_cellphone_no;
				$implantedBy['identityNo'] = '';
				break;
		}
		return $implantedBy;
	}
	
	function getInjectors() {
		$sql = "SELECT 'Vet' user_type,vet_name name,vet_practice_no practice_no,vet_practice_name practice_name,usr_id FROM `vet` inner join `user` on vet_usr_id = usr_id WHERE `vet_verified_by_admin` = 'Y'
union all
			SELECT 'Welfare Organisation' user_type,wel_contact_fullname,null,wel_name,usr_id FROM `welfareOrganisation`
						inner join `user` on wel_usr_id = usr_id WHERE `wel_verified_by_admin` = 'Y'
				order by 1,4";
		$result = $GLOBALS['db']->select($sql);
		if (empty($result)) {
	    	return false;
	    } else {
		 	return $result;
		}
	}
}

?>