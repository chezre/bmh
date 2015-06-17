<?php

require('inc/application.php');
require('inc/security.php');
if (!isset($_SESSION['user']['roleId'])||$_SESSION['user']['roleId']!=1) {
	if (isset($_SESSION['user']['landingPage'])) {
		header('location:'.$_SESSION['user']['landingPage']);
		exit();
	} else {
		header('location:index.php');
		exit();
	}
}

$thead = $tbody = $tfoot = '';
$rowLimit = 10;
$page = (empty($_POST['pg'])) ? 0:($_POST['pg']-1)*10;
if (empty($_POST['rfid'])&&empty($_POST['email'])) {
	echo '<tbody><tr><td>No Data Found</td></tr></tbody>';
	exit();
} 
$rfid = $_POST['rfid'];
$email = $_POST['email'];

$data = $GLOBALS['fn']->getAllSearchedChips($page,$rowLimit,$rfid,$email);
$total = $GLOBALS['fn']->getTotalSearchedChips($rfid,$email);
$thead = '';
$tbody = "\n" . '<tbody>';

$hide = array('usr_id','pow_usr_id','pet_usr_id','pet_id','pow_id');
$ids = array('Owner Name'=>'usr_id','Contact No'=>'usr_id','Email'=>'usr_id','Chip'=>'pet_id','Pet Name'=>'pet_id','Injector Name'=>'');
$classes = array('Owner Name'=>'usr','Contact No'=>'usr','Email'=>'usr','Chip'=>'pet','Pet Name'=>'pet','Injector Name'=>'');
$idTypes = array('Owner Name'=>'uid','Contact No'=>'uid','Email'=>'uid','Chip'=>'pid','Pet Name'=>'pid','Injector Name'=>'');

if (!empty($data)) {
	foreach ($data as $d) {
		$colspan = 0;
		if (empty($thead)) {
			$thead = "\n" . "<thead><tr>";
			foreach ($d as $k=>$v) if (!in_array($k, $hide)) $thead .= '<td>'.$k.'</td>';
			$thead .= "</tr></thead>";
		}
		$cells = '';
		foreach ($d as $k=>$v) {
			if (!in_array($k, $hide)) {
				$inclId = '';
				if (!empty($ids[$k])&&!empty($d[$ids[$k]])) {
					$idType = $idTypes[$k];
					$id = $d[$ids[$k]];
					$inclId = $idType.'="'.$id.'"';
				}
            	$class = (!empty($classes[$k])) ? $classes[$k]:'';
				$cells .= '<td class="'.$class.'" '.$inclId.'>'.$v.'</td>';
			}
			$colspan++;
		}
		$tbody .= "\n" . '<tr>'.$cells.'</tr>';
	}
	$pages = ceil($total/10);
	$pg = ($page/10)+1;
	$tfoot = '<tfoot><tr><td colspan="'.$colspan.'"><div id="paginationDiv"><div id="pageFirst">first</div><div id="pagePrev">prev</div><div><input type="text" id="page" placeholder="'.$pg.'" /></div><div>of '.$pages.'</div><div id="pageNext" val="'.$pages.'">next</div><div id="pageLast" val="'.$pages.'">last</div></div></td></tr></tfoot>';
} else {
	$tbody .= '<tr><td>No Data Found</td></tr>';
}
$tbody .= "</tbody>";
echo $thead . $tbody . $tfoot; 
?>
<tbody style="display:none">
    <tr>
        <td>
            <script language="text/javascript">
                $(document).ready(function(){
               	    $(".usr").click(function(){
               	       if (!isNaN($(this).attr('uid'))) location='edit.owner.php?o='+$(this).attr('uid'); 
               	    });
					$(".pet").click(function(){
               	       if (!isNaN($(this).attr('pid'))) location='edit.pet.php?p='+$(this).attr('pid'); 
				    });
					$("#pageFirst").click(function(){
						currentPage = 1;
						getSearchedChips();
					});
					$("#pagePrev").click(function(){
						currentPage--;
						if (currentPage<1) currentPage = 1;
						getSearchedChips();
					});
					$("#pageLast").click(function(){
						currentPage = $(this).attr('val');
						getSearchedChips();
					});
					$("#pageNext").click(function(){
						currentPage++;
						if (currentPage>$(this).attr('val')) currentPage = $(this).attr('val');
						getSearchedChips();
					});
					$("#page").blur(function() {
						if (!isNaN($(this).val())) {
							currentPage = $(this).val();
							if (currentPage>$(this).attr('val')) currentPage = $(this).attr('val');
							if (currentPage<1) currentPage = 1;
							getSearchedChips();
						}
					});
                });
            </script>
        </td>
    </tr>
</tbody> 