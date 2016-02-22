<?php 

session_start();

if (!isset($_SESSION['user']['isAuthenticated'])) session_destroy();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Backend Closed</title>
        <link rel="icon" type="image/png" href="img/favicon.png" />
        <link rel="stylesheet" type="text/css" href="css/global.css" />
        <link rel="stylesheet" type="text/css" href="css/reset.login.css" />
        <style type="text/css">
            .bx {
                margin-left: 20px;
                margin-top: 20px;
            }
            .hdg {
                    margin-left: 20px;
    font-size: 18pt;
    font-weight: bold;
            }
        </style>
	</head>
	<body>
		<div id="mainDiv">
            <div style="padding:20px;width: auto !important;text-align: center;">
                <img src="img/bmh_logo.png" width="265" height="86" />
				<hr />
            </div>
  
            <!-- start here -->
            <div class="hdg">Site Closed</div>
            <div class="bx">
                <p>Access to the backend has been temporarily closed.</p>
                <p>Send all new applications to the BringMeHome Admin department.</p>
                <p>New applications can take up to 5 working days for processing.</p>
            </div>
            
            <div id="heading">Contact Us</div>    
	        <div id="verifcationResults">
              Contact us on 021 556 0003<br />
              email: <a href="mailto:info@bringmehome.co.za">info@bringmehome.co.za</a> or <a href="mailto:admin@bringmehome.co.za">admin@bringmehome.co.za</a>
			  <p><a href="www.rfid-experts.co.za">www.rfid-experts.co.za</a></p>
            </div>
            <div style="margin-left:20px;margin-top: 15px;margin-bottom: 15px;clear: both;">
				<a href="login.php" style="color: inherit;font-weight: normal;font-size: 10pt">&gt; login</a>
                <a href="index.php" style="color: inherit;font-weight: normal;font-size: 10pt">&gt; home</a>
			</div>
		</div>
        <div id="footerDiv">
            All Rights Reserved &reg;. BringMeHome Microchip Database &#124; <a href="contactus.php">Contact Us</a> &#124; <a href="legal.php">Legal</a>
        </div>
	</body>
</html>