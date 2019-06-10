<?php
session_start();
if(!isset($_SESSION['AdminNatID'])){
	header("location: http://localhost/orinon/?error=log-in-required");
	exit();
}
include('../dbconnect.php');
include('../functions.php');

if (!isset($_GET['fileType']) || !isset($_GET['file']) || !isset($_GET['ticket']) || !isset($_GET['mID']) || !isset($_GET['score'])) {
    header("location: http://localhost/orinon/admin/credit-score.php?error=invalid-access-detected");
	exit();
}

$tp = func::escape_data($myConn, $_GET['fileType']);
$fl = func::escape_data($myConn, $_GET['file']);
$tkt = func::escape_data($myConn, $_GET['ticket']);
$mid = func::escape_data($myConn, $_GET['mID']);
$scr = func::escape_data($myConn, $_GET['score']);
$sql = "SELECT * FROM `creditscoreuploads` WHERE `user`='$mid' AND `job`='$tkt' AND `cat`= '$tp'";
$qry = mysqli_query($myConn, $sql);
if (mysqli_num_rows($qry) != 0) {
    $rs = mysqli_fetch_assoc($qry);
    if ($rs['status'] == 0) {
        $che = "SELECT * FROM `clients` WHERE `nationalId`='$mid'";
        $chqry = mysqli_query($myConn, $che);
        $chrs = mysqli_fetch_assoc($chqry);
        $newSc = $chrs['c_score'] + $scr;
        $usql = "UPDATE `clients` SET `c_score`='$newSc' WHERE `nationalId`='$mid'";
        $uqry = mysqli_query($myConn, $usql);
        if ($uqry) {
            # code...
            $ucsql = "UPDATE `creditscoreuploads` SET `status`= '1' WHERE `user`='$mid' AND `job`='$tkt' AND `cat`= '$tp'";
            $ucqry = mysqli_query($myConn, $ucsql);
            if($ucqry){
                $rsq = "SELECT * FROM `creditscoreuploads` WHERE `user`='$mid' AND `job`='$tkt' AND `status`= '0'";
                $rsqry = mysqli_query($myConn, $rsq);
                if(mysqli_num_rows($rsqry) == 0){
                    $jsql = "UPDATE `jobs` SET `status`='1'";
                    $jqry = mysqli_query($myConn, $jsql);
                    if (!$jqry) {
                        $dsql = "DELETE FROM `jobs` WHERE `id`='$tkt'";
                        $dqry = mysqli_query($myConn, $dsql);
                    }
                }
                echo("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('File Validated. Credit Score Saved')
                window.location.href='credit-scores.php'
            </SCRIPT>");
            exit();
            }
        }else{

        }

    }elseif($rs['status'] == 1){
        echo("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('File Already Validated')
            window.location.href='credit-scores.php'
        </SCRIPT>");
        exit();
    }
}else {
    echo("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Application Not Found.')
			window.location.href='credit-scoress.php'
        </SCRIPT>");
        exit();
}
?>
