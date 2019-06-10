<?php
error_reporting(0);
		
class func{
	public static function checkLoginState($myConn){
    global $uri;
			if(!isset($_SESSION)){
				session_start();
			}
			if(isset($_COOKIE['ad_id']) && isset($_COOKIE['ad_token']) && isset($_COOKIE['ad_serial'])){
				
				$userid = $_COOKIE['ad_id'];
				$token = $_COOKIE['ad_token'];
				$serial = $_COOKIE['ad_serial'];
				
				$query = "SELECT * FROM `admn_tb-ss` WHERE `ss_us_id` = :userid AND `ss_tkn` = :token AND `ss_srl` = :serial;";
				
				$stmt = $dbh ->prepare($query);
				$stmt->execute(array(':userid' =>$userid, ':token' =>$token, ':serial' =>$serial));
				
				$row = $stmt-> fetch(PDO::FETCH_ASSOC);
				
				if($row['ss_id'] >0){
					if(
					$row['ss_us_id'] == $_COOKIE['ad_id'] && 
					$row['ss_tkn'] == $_COOKIE['ad_token'] &&
					$row['ss_srl'] == $_COOKIE['ad_serial']
					
					)
					{
					if(
					$row['ss_us_id'] == $_SESSION['ad_id'] && 
					$row['ss_tkn'] == $_SESSION['ad_token'] &&
					$row['ss_srl'] == $_SESSION['ad_serial']
					)
					{
						return true;
					}else{
            return false;
						func::deleteCookie();
            header("location:".$uri."/?error=session-expired");
					}
				}
				
			}
			
		}

	}
	public static function escape_data ($dbc, $data) {

		if (function_exists('mysql_real_escape_string')) {
			$data = mysqli_real_escape_string ($dbc, trim($data));
			$data = strip_tags($data);
		} else {
			$data = mysqli_escape_string ($dbc, trim($data));
			$data = strip_tags($data);
		}	
		return $data;

	}

	public static function createRecord($dbh,$admin_name, $admin_id){
		
		
		
		$token = func:: createString(30);
		$serial = func:: createString(30);
		
		
		func:: createCookie($admin_name, $admin_id, $token, $serial);
		func:: createSession($admin_name, $admin_id, $token, $serial);
		$dt = date("d/m/Y");
		
		$query ="INSERT INTO `admn_tb-ss`(`ss_id`, `ss_us_id`, `ss_tkn`, `ss_srl`, `ss_dt`) VALUES ('',:admin_id,:token,:serial,:dt)";
		
		$dbh->prepare('DELETE FROM `admn_tb-ss` WHERE  `ss_us_id` = :sessions_userid;') ->execute(array(':sessions_userid' =>$admin_id));
		$stmt = $dbh -> prepare($query);
		$stmt->execute(array(':admin_id' =>$admin_id, ':token' => $token, ':serial' => $serial, ':dt' => $dt));
		
		
	}	
	public static function createCookie($admin_name, $admin_id, $token, $serial){
		setcookie('ad_id', $admin_id, time() + (86400) * 30, "/");
		setcookie('ad_name', $admin_name, time() + (86400) * 30, "/");
		setcookie('ad_token', $token, time() + (86400) * 30, "/");
		setcookie('ad_serial', $serial, time() + (86400) * 30, "/");
	}
	public static function deleteCookie(){
		setcookie('ad_id', '', time() -1, "/");
		setcookie('ad_name', '', time() -1, "/");
		setcookie('ad_token', '', time() -1, "/");
		setcookie('ad_serial', '', time() -1, "/");
		session_destroy();
	}
	public static function createSession($admin_name, $admin_id, $token, $serial){
		
		if(!isset($_SESSION)){
			session_start();
		}
		$_SESSION['ad_id'] = $admin_id;
		$_SESSION['ad_token'] = $token;
		$_SESSION['ad_serial'] = $serial;
		$_SESSION['ad_name'] = $admin_name;
		
    }
	public static function createString($len){
		$string = "1qay2wsx3edc4rfv5tgb6zhn7ujm8ik9ollpAQWSXEDCVFRTGBNHYZUJMKILOP";
		
		return substr(str_shuffle($string), 0, $len);
	}
	
	public static function code($len){
		//$len here is the length of the string in-between the dashes
	return strtoupper(func::createString($len))."-".strtoupper(func::createString($len))."-".strtoupper(func::createString($len))."-".strtoupper(func::createString($len));
	
	}
	public static function checkLoanStatus($user){
		//return an array or json with status = either 1 or 2, loan ID if any, loan cat if any
	}
}



 ?>