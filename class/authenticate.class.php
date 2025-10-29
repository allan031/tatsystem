<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once dirname(__DIR__,1).'/class/dbconn.class.php'; 
class AuthenticateUser extends DBConnection{
	public function Authenticate($username,$password){
		$query = "SELECT A.UserID,A.EmpPassword,A.EmpDepartment,A.Platform,A.InitialLogin,A.AccountType,
		upper(ltrim(dbo.udf_GetUserName(A.UserID))) as [FullName],IsAccess from dbo.TblUser A where A.UserID = :username";	
		$param = array(":username" => $username);
		$stmt =$this->mssql_connect()->prepare($query);
		$stmt->execute($param);
		$row = $stmt->fetch();
		if($row){
			if(password_verify($password, $row['EmpPassword'])){
				$this->IsLogin($username);
				if($row['Platform'] == 'W' || $row['Platform'] == 'B'){
					$_SESSION['username'] = $row['UserID'];
					$_SESSION['Department'] = $row['EmpDepartment'];
				 	$_SESSION['InitLogin'] = $row['InitialLogin'];
					$_SESSION['Platform'] = $row['Platform'];
					$_SESSION['AccountType'] = $row['AccountType'];
					$_SESSION['FullName'] = $row['FullName'];
					$_SESSION['IsAccess'] = $row['IsAccess'];
					
				return true;
				}else{
					$_SESSION['username'] = $row['UserID'];
					$_SESSION['Department'] = $row['EmpDepartment'];
					$_SESSION['InitLogin'] = $row['InitialLogin'];
					$_SESSION['Platform'] = $row['Platform'];
					$_SESSION['AccountType'] = $row['AccountType'];
					$_SESSION['FullName'] = $row['FullName'];
					$_SESSION['IsAccess'] = $row['IsAccess'];
					
					return true;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	//function to update the login status if user login or not
	public function IsLogin($username){
		date_default_timezone_set('Asia/Manila');
		$query = "INSERT INTO Tbl_UserLogs (UserID,LastLoginDateTime) VALUES (:UserID,:LastLoginDateTime)";
		$param = array(":UserID" => $username,":LastLoginDateTime" => date("Y-m-d H:i:s"));
		$stmt = $this->mssql_connect()->prepare($query);
		$stmt->execute($param);		
		$row = $stmt->rowCount();

		if($row > 0){
			$query = "Update TblUser set IsLogin = 1 where UserID = :UserID";
			$param = array(":UserID" => $username);
			$stmt = $this->mssql_connect()->prepare($query);
			$stmt->execute($param);
			return true;
		}else{
			return false;
		}
	}


	//function to update the status of IsLogin to 0
	public function IsLogout($username){
		date_default_timezone_set('Asia/Manila');
		$query = "Update Tbl_UserLogs set LastLogoutDateTime = :LastLogoutDateTime where UserID = :UserID and LastLogoutDateTime is null";
		$param = array(":UserID" => $username,":LastLogoutDateTime" => date("Y-m-d H:i:s"));
		$stmt = $this->mssql_connect()->prepare($query);
		$stmt->execute($param);		
		$row = $stmt->rowCount();

		if($row > 0){
			$query = "Update TblUser set IsLogin = 0 where UserID = :UserID";
			$param = array(":UserID" => $username);
			$stmt = $this->mssql_connect()->prepare($query);
			$stmt->execute($param);
			$row = $stmt->rowCount();
			return true;
		}else{
			return false;
		}
	}
}