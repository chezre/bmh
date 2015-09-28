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
$ROWLIMIT = 10;

$thead = $tbody = $tfoot = '';
$page = (empty($_GET['pg'])) ? 0:($_GET['pg']-1)*$ROWLIMIT;
if (empty($_GET['srch_value'])) {
	echo '<tbody><tr><td>No Data Found</td></tr></tbody>';
	exit();
} 
$srchValue = $_GET['srch_value'];

$data = $GLOBALS['fn']->getAllSearchedVets($page,$ROWLIMIT,$srchValue);

$thead = '';
$tbody = "\n" . '<tbody>';

$hide = array('vet_id','usr_id');
$total = 0;

if (!empty($data)) {
	$total = count($data);
	foreach ($data as $d) {
		$colspan = 0;
		if (empty($thead)) {
			$thead = "\n" . "<thead><tr>";
			foreach ($d as $k=>$v) if (!in_array($k,$hide)) $thead .= '<td>'.$k.'</td>';
			$thead .= "</tr></thead>";
		}
		$cells = '';
		foreach ($d as $k=>$v) {
			if (!in_array($k,$hide)) $cells .= '<td>'.$v.'</td>';
			$colspan++;
		}
		$tbody .= "\n" . '<tr vid="'.$d['vet_id'].'">'.$cells.'</tr>';
	}
	$pages = ceil($total/$ROWLIMIT);
	$pg = ($page/$ROWLIMIT)+1;
	if ($total>10) $tfoot = '<tfoot><tr><td colspan="'.$colspan.'"><div id="paginationDiv"><div id="pageFirst">first</div><div id="pagePrev">prev</div><div><input type="text" id="page" placeholder="'.$pg.'" /></div><div>of '.$pages.'</div><div id="pageNext" val="'.$pages.'">next</div><div id="pageLast" val="'.$pages.'">last</div></div></td></tr></tfoot>';
} else {
	$tbody .= '<tr><td>No Data Found</td></tr>';
}
$tbody .= "</tbody>";
echo '<table width="100%" align="center" id="tblVets" cellspacing="0" cellpadding="5">' . $thead . $tbody . $tfoot; 
?>
<tbody style="display:none">
    <tr>
        <td>
            <script language="text/javascript">
                $(document).ready(function(){
               	    $("tr").click(function(){
               	       if (!isNaN($(this).attr('vid'))) editVet($(this).attr('vid')); 
               	    });
					$("#pageFirst").click(function(){
						currentPage = 1;
						findVets();
					});
					$("#pagePrev").click(function(){
						currentPage--;
						if (currentPage<1) currentPage = 1;
						findVets();
					});
					$("#pageLast").click(function(){
						currentPage = $(this).attr('val');
						findVets();
					});
					$("#pageNext").click(function(){
						currentPage++;
						if (currentPage>$(this).attr('val')) currentPage = $(this).attr('val');
						findVets();
					});
					$("#page").blur(function() {
						if (!isNaN($(this).val())) {
							currentPage = $(this).val();
							if (currentPage>$(this).attr('val')) currentPage = $(this).attr('val');
							if (currentPage<1) currentPage = 1;
							findVets();
						}
					});
                });
            </script>
        </td>
    </tr>
</tbody> 
</table>