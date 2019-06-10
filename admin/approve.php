<?php
session_start();
if(!isset($_SESSION['AdminNatID'])){
	header("location: http://localhost/orinon/?error=log-in-required");
	exit();
}
include('../dbconnect.php');
include('../functions.php');


if (!isset($_GET['action']) && !isset($_GET['lnID'])) {
    header("location: http://localhost/orinon/admin/loan-apps.php?error=log-invalid-access");
	exit();
}
if(func::escape_data($_GET['action']) == '1'){
    $id = $_GET['lnID'];
    $llsql = "SELECT * FROM `loanapps` WHERE `id`='$id'";
    $llqry = mysqli_query($myConn, $llsql);
    if (mysqli_num_rows($llqry) != 0) {
        //aprove now
        $rs = mysqli_fetch_assoc($llqry);
        $lID = rand(1000, 9999);
        $user = $rs['user'];
        $typ = $rs['ltype'];
        $amnt = $rs['amnt'];
        $interest = $rs['interest'];
        $date = date("Y-m-d");
        $dt = $rs['dt'];
        $dur = $rs['due_dt'];
        $due = date('Y-m-d', strtotime($date .'+'.$dur.' month'));
        $sql = "INSERT INTO `loans`(`id`, `us_id`, `type`, `amnt`, `interest`, `dt_applied`, `due_dt`, `ack_recpt`, `status`) VALUES ('$lID','$user','$typ','$amnt','$interest','$dt','$due','1','1')";
        $qry = mysqli_query($myConn, $sql);
        if($qry){
            $dsql = "DELETE FROM `loanapps` WHERE `id`='$id'";
            $dqry = mysqli_query($myConn, $dsql);
            if($dqry){
                echo("<SCRIPT LANGUAGE='JavaScript'>
                    window.alert('Loan Approved')
                    window.location.href='loan-apps.php'
                </SCRIPT>");
            }else{

            }
            
        }else{
            echo("<SCRIPT LANGUAGE='JavaScript'>
                    window.alert('Loan Approval Failed')
                    window.location.href='loan-apps.php'
                </SCRIPT>");
        }

    }
}elseif(func::escape_data($_GET['action']) == '2'){
    $id = $_GET['lnID'];
    $llsql = "SELECT * FROM `loanapps` WHERE `id`='$id'";
    $llqry = mysqli_query($myConn, $llsql);
    if (mysqli_num_rows($llqry) != 0) {
        //aprove now
        $rs = mysqli_fetch_assoc($llqry);
        $sql = "UPDATE `loanapps` SET `status`='2' WHERE `id`='$id'";
        $qry = mysqli_query($myConn, $sql);
        if($qry){
            echo("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('Loan Rejected')
                window.location.href='loan-apps.php'
            </SCRIPT>");
        }else{
            echo("<SCRIPT LANGUAGE='JavaScript'>
                    window.alert('Loan Rejection Failed')
                    window.location.href='loan-apps.php'
                </SCRIPT>");
        }
    }
}


?>