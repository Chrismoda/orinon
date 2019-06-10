<?php
session_start();
require "../dbconnect.php";
$target_dir = "users/files/";
//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$NID = $target_dir . basename($_FILES["nationalD"]["name"]);
$carEgBk = $target_dir . basename($_FILES["carReg"]["name"]);
$titleDeeds = $target_dir . basename($_FILES["titleDeeds"]["name"]);

// save for all files
$uploadOk = 1;
//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$idFileType = strtolower(pathinfo($NID,PATHINFO_EXTENSION));
$carRegBookFileType = strtolower(pathinfo($carEgBk,PATHINFO_EXTENSION));
$titleDeedsFileType = strtolower(pathinfo($titleDeeds,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
	$uploadOk = 1;
    /*$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        
    } else {
        echo "File is not an image.";
        
    }*/
}else{
	$uploadOk = 0;
}
// Check if file already exists
/*if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}*/
//national ID
if (file_exists($NID)) {
	echo "<script>alert('The National ID  select already exist. Please change the name or Select a different one')</script>";
	echo "<script>window.location('../account/credit.php?error=upload failed-file-already-exist','_self');</script>";
    $uploadOk = 0;
}
//title deeds 
if (file_exists($titleDeeds)) {
    echo "<script>alert('The Title Deeds Document select already exist. Please change the name or Select a different one')</script>";
	echo "<script>window.open('../account/credit.php?error=upload failed-file-already-exist','_self');</script>";
    $uploadOk = 0;
}
//car Reg Book
if (file_exists($carEgBk)) {
	echo "<script>alert('The Car reg select already exist. Please change the name or Select a different one')</script>";
	echo "<script>window.open('../account/credit.php?error=upload failed-file-already-exist','_self');</script>";
    $uploadOk = 0;
}

// Check file size
/*if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}*/

//title deeds formats
if($titleDeedsFileType != "pdf") {
	echo "<script>alert('Sorry, only PDF, Word Documents are allowed')</script>";
	echo "<script>window.open('../account/credit.php?error=upload failed','_self');</script>";
    $uploadOk = 0;
}
//car reg book
if($carRegBookFileType != "pdf") {
	echo "<script>alert('Sorry, only PDF Document files are allowed.')</script>";
	echo "<script>window.open('../account/credit.php?error=upload failed','_self');</script>";
	
    $uploadOk = 0;
}
//ID file type
if($idFileType != "jpg" && $idFileType != "png" && $idFileType != "jpeg" && $idFileType != "pdf") {
	echo "<script>alert('Sorry, only JPG, JPEG, PNG, PDF Document files are allowed.')</script>";
	echo "<script>window.open('../account/credit.php?error=upload failed','_self');</script>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "<script>alert('Sorry, your file was not uploaded.')</script>";
	echo "<script>window.open('../account/credit.php?error=upload failed','_self');</script>";
// if everything is ok, try to upload file
} else {
	$IDval = $_SESSION['NatID'];
	$csql = "SELECT * FROM `files` WHERE `user`='$IDval'";
	$cqry = mysqli_query($myConn, $csql);
	if(mysqli_num_rows($cqry) != 0){
		echo "<script>alert('You have already submitted theses files before. For any changes or updates Please use the Update function on the saved files tab')</script>";
		echo "<script>window.open('../account/credit.php?error=files already saved','_self');</script>";
	}else{
		
		if (move_uploaded_file($_FILES["nationalD"]["tmp_name"], $NID) && move_uploaded_file($_FILES["carReg"]["tmp_name"], $carEgBk) && move_uploaded_file($_FILES["titleDeeds"]["tmp_name"], $titleDeeds)) {
			
			$natID = basename($_FILES["nationalD"]["name"]);
			$creg = basename($_FILES["carReg"]["name"]);
			$ttDds = basename($_FILES["titleDeeds"]["name"]);
			
			$files = array(
				$natID, $creg, $ttDds
			);
			
			
			$ticket = rand(1000, 9999);
			$tsql = "INSERT INTO `jobs`(`id`, `user`, `date`, `finishDate`, `status`) VALUES ('$ticket','$IDval',now(),'' ,'0')";
			$tqry = mysqli_query($myConn, $tsql);
			if($tqry){
				for($i = 0; $i<count($files); $i++){
					//create ticket, jobs
					$doc = $files[$i];
					if($doc == $natID){
						$ct = 4;
					}elseif($doc == $creg){
						$ct = 5;
					}elseif($doc == $ttDds){
						$ct = 6;
					}
					$usql = "INSERT INTO `creditscoreuploads`(`id`, `user`, `file`, `job`, `date`,`cat`, `status`) VALUES ('','$IDval','$doc','$ticket',now(), '$ct', '0')";
					$uqry = mysqli_query($myConn, $usql);
					
					if($uqry){
						$fl = "/account/users/files/".$doc;
						$fsql = "INSERT INTO `files`(`id`, `user`, `path`, `cat`) VALUES ('','$IDval','$fl','$ct')";
						$fqry = mysqli_query($myConn, $fsql);
						
						if($fqry){
							if($files[$i] == $doc){
								echo "<script>alert('".$doc." Saved Successfully')</script>";
							}
							
						}else{
							echo "<script>alert('".$doc." Could not Save. Please Try Again by Updating Missing Files')</script>";
							
						}
						echo "<script>window.open('../account/credit.php?status=upload processed','_self');</script>";
					}
					
					
				}
			}
			
			
			
		} else {
			echo "Sorry, there was an error uploading your file.";
			echo "<script>window.open('../account/credit.php?status=upload failed','_self')</script>";
		}
	}
}
?>
