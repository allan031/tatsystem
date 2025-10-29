<?php

include_once dirname(__DIR__,1).'/class/dbconn.class.php';    

class Registration extends DBConnection{ 

    //insert to tbluser
    public function CreateTblUser($username,$password,$fname,$mname,$lname,$birthDate,$emailAdd,$empDept,$createdBy,$createdDate,$platform,$AccType,$AccAccess){
        $data = [];
        $SuccessMessage = "";
        $ErrorMessage = "";

        if($this->CheckUserID($username) === true){
            $ErrorMessage = "There is an existing employee ID in the database!";
        }else{
            $query = 'INSERT INTO TblUser (UserID,EmpPassword,EmpFirstName,EmpMiddleName,EmpLastName,EmpBirthDate,
            EmpEmailAddress,EmpDepartment,InitialLogin,LockCounter,LockFlag,CreatedBy,CreatedDate,Platform,Status,AccountType,IsAccess) VALUES(:UserID,:EmpPassword,:EmpFirstName,:EmpMiddleName,:EmpLastName,:EmpBirthDate
            ,:EmpEmailAddress,:EmpDepartment,:InitialLogin,:LockCounter,:LockFlag,:CreatedBy,:CreatedDate,:Platform,:Status,:AccountType,:IsAccess)';
            $param = array(':UserID' => $username,':EmpPassword' => password_hash($password, PASSWORD_DEFAULT),':EmpFirstName' => $fname,
            ':EmpFirstName' => $fname,':EmpMiddleName' => $mname,':EmpLastName' => $lname,':EmpBirthDate' => $birthDate,':EmpEmailAddress' => $emailAdd,
            ':EmpDepartment' => $empDept,':InitialLogin'=>0,':LockCounter'=>5,':LockFlag'=>0,':CreatedBy' => $createdBy,':CreatedDate'=>$createdDate,':Platform'=>$platform,':Status'=>0,':AccountType'=> $AccType,':IsAccess' => $AccAccess);
            $stmt =$this->mssql_connect()->prepare($query);
            $result = $stmt->execute($param);
            $SuccessMessage = 'User added successfully!';
        }
        $data = array([
            'errormsg'=> $ErrorMessage,
            'successmsg' => $SuccessMessage
        ]);
        echo json_encode($data);
    }

    public function ChangePassword($username,$password,$repassword){
        if($password === $repassword){
            $query = 'UPDATE TblUser SET EmpPassword = :password, InitialLogin = :ispasswordchange WHERE UserID = :username ';
            $param = array(':username' => $username,':password' => password_hash($password, PASSWORD_DEFAULT),':ispasswordchange' => 1);
            $stmt =$this->mssql_connect()->prepare($query);
            $result = $stmt->execute($param);
            return true;
        }else{
            return false;
        }
    }

    public function ResetPassword($userid){
        $query = 'UPDATE TblUser SET EmpPassword = :password, InitialLogin = :ispasswordchange WHERE UserID = :username ';
            $param = array(':username' => $userid,':password' => password_hash($userid, PASSWORD_DEFAULT),':ispasswordchange' => 0);
            $stmt =$this->mssql_connect()->prepare($query);
            $result = $stmt->execute($param);
            return true;
    }

    public function ViewRegisteredUser(){
        $query = "Select UserID,empid,name,EmpDepartment,passwordchange,accStatus,CreatedBy,CreatedDate from vw_TATUser ORDER BY CreatedDate DESC";
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $counter = 0;
        if($row){

            echo'<table class="w-full table-auto bg-white mr-48">
                    <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                        <tr class="">
                            <th class="p-2"></th>
                            <th class="p-2">Employee ID</th>
                            <th class="p-2">Name</th>
                            <th class="p-2">Department</th>
                            <th class="p-2">passwordchange</th>
                            <th class="p-2">Account Status</th>
                            <th class="p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>';   
            do{
                echo '<tr class="align-top border bottom-px text-third bg-white">
                        <td class="p-2 text-left">'.++$counter.'</td>
                        <td class="p-2 text-left">'.$row['empid'].'</td>
                        <td class="p-2 text-left">'.$row['name'].'</td>
                        <td class="p-2 text-left">'.$row['EmpDepartment'].'</td>
                        <td class="p-2 text-left">'.$row['passwordchange'].'</td>
                        <td class="p-2 text-left">'.$row['accStatus'].'</td>
                        <td class="p-2 text-left flex flex-row">
                            <div class="group">
                                <button 
                                    id="btn-password-reset" 
                                    data-userid = "'.$row['UserID'].'" 
                                    class="btn-password-reset hover:bg-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                    </svg>
                                </button>
                                <span class="hidden absolute text-black group-hover:flex items-center justify-center">Reset Password</span>
                            </div>
                            <div class="group">
                                <button 
                                    id="btn-user-edit" 
                                    data-userid = "'.$row['UserID'].'" 
                                    class="btn-user-edit hover:bg-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </button>
                                <span class="hidden absolute text-black group-hover:flex items-center justify-center">Edit User</span>
                            </div>
                            <div class="group">
                                <button 
                                    id="btn-user-delete" 
                                    data-userid = "'.$row['UserID'].'" 
                                    class="btn-user-delete hover:bg-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                                <span class="hidden absolute text-black group-hover:flex">Delete User</span>
                            </div>
                        </td>
                    </tr>';
            }while($row = $stmt->fetch());

            echo '</tbody>
            <tfoot>
                <tr class="border-t-2 border-third">
                    
                </tr>
            </tfoot>
        </table>';
        }
    }

    public function PaginationTableWithSearchRegisteredUser(){

        $display = ""; 
            $query = "SELECT  * FROM vw_TATUser ORDER BY name";
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch();
            $counter = 0;

            $display .= '
            <table class="w-full table-auto bg-white mr-48" id="user-datatable">
            <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                <tr class="">
                    <th class="p-2"></th>
                    <th class="p-2">Employee ID</th>
                    <th class="p-2">Name</th>
                    <th class="p-2">Department</th>
                    <th class="p-2">passwordchange</th>
                    <th class="p-2">Account Status</th>
                    <th class="p-2">Access</th>
                    <th class="p-2">Action</th>
                </tr>
            </thead>
            <tbody>';
            if($row > 0){
                do{
                    $display .= '<tr class="align-top border bottom-px text-third bg-white">
                    <td class="p-2 text-left">'.++$counter.'</td>
                    <td class="p-2 text-left">'.$row['empid'].'</td>
                    <td class="p-2 text-left">'.$row['name'].'</td>
                    <td class="p-2 text-left">'.$row['EmpDepartment'].'</td>
                    <td class="p-2 text-left">'.$row['passwordchange'].'</td>
                    <td class="p-2 text-left">'.$row['accStatus'].'</td>
                    <td class="p-2 text-left">'.$row['Access'].'</td>
                    <td class="p-2 text-left flex flex-row">
                        <div class="group">
                            <button 
                                id="btn-password-reset" 
                                data-userid = "'.$row['UserID'].'" 
                                class="btn-password-reset hover:bg-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                            </button>
                            <span class="hidden absolute text-black group-hover:flex items-center justify-center">Reset Password</span>
                        </div>
                        <div class="group">
                            <button 
                                id="btn-user-edit" 
                                data-userid = "'.$row['UserID'].'" 
                                class="btn-user-edit hover:bg-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </button>
                            <span class="hidden absolute text-black group-hover:flex items-center justify-center">Edit User</span>
                        </div>
                        <div class="group">
                            <button 
                                id="btn-user-delete" 
                                data-userid = "'.$row['UserID'].'" 
                                class="btn-user-delete hover:bg-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                            <span class="hidden absolute text-black group-hover:flex">Delete User</span>
                        </div>
                    </td>
                </tr>';
                }while($row = $stmt->fetch());

                $display .= '</tbody>';
            }else{
            $display .= '
            <table class="w-full table-auto bg-white mr-48" id="user-datatable">
            <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                <tr class="">
                    <th class="p-2"></th>
                    <th class="p-2">Employee ID</th>
                    <th class="p-2">Name</th>
                    <th class="p-2">Department</th>
                    <th class="p-2">passwordchange</th>
                    <th class="p-2">Account Status</th>
                    <th class="p-2">Access</th>
                    <th class="p-2">Action</th>
                </tr>
            </thead>
            <tbody>';
                     $display .= '</tbody>';
                     $display .= '
                        <tr>
                            <td colspan="7" class="text-center">There is no data available in the table</td> 
                        </tr>';
           }

        $display .= '</table>';
        echo $display;

    }

    //get department
    public function GetDepartment(){
        $query = "SELECT DepartmentID,DepartmentName,DepartmentAbbreviation FROM TblDepartment ORDER BY DepartmentID ASC";
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        if($row){
            echo '<select name="dept" id="dept" class="w-full h-12 ml-0 rounded-md">';
            echo '<option value="">--Select Department Type--</option>';
            do{
                    echo '<option class="text-md text-third font-medium" value="'.$row['DepartmentID'].'">'.$row['DepartmentAbbreviation'].'</option>';
                }while($row = $stmt->fetch());
            echo '</select>';       
        }
    }   

    //delete user
    public function DeleteUser($UserID){
            $query = 'UPDATE TblUser SET Status = :status WHERE UserID = :UserID ';
            $param = array(':UserID' => $UserID, ':status'=>1);
            $stmt =$this->mssql_connect()->prepare($query);
            $result = $stmt->execute($param);
            return $result;
    }


    //check if UserID exist in db
    public function CheckUserID($userid){
        $query = "Select UserID from vw_TATUser where UserID = :UserID";
        $param = array('UserID'=> $userid);
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute($param);
        $row = $stmt->fetch();
        if($row){
           return true;
        }else{ 
            return false;
        }
    }

    //get user details
    public function GetUsers($id){
        $query = "SELECT  dbo.udf_GetDepartmentTAT(EmpDepartment) as [DeptName],dbo.udf_GetAccAccess(IsAccess) as [AccAccess],* FROM TblUser WHERE UserID = :UserID";
        $param = array(':UserID' => $id);
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute($param);
        $row = $stmt->fetch();
        
        $data = [];
        if($row){
            $data = array([
                'UserID' => $row['UserID'],
                'EmpFirstName' => $row['EmpFirstName'],
                'EmpMiddleName' => $row['EmpMiddleName'],
                'EmpLastName' => $row['EmpLastName'],
                'EmpDept' => $row['EmpDepartment'],
                'EmpDeptName' => $row['DeptName'],
                'EmpBirthDate' => $row['EmpBirthDate'],
                'EmpEmailAddress' => $row['EmpEmailAddress'],
                'Platform' => $row['Platform'],
                'Status' => $row['Status'],
                'AccountType' => $row['AccountType'],
                'TransactionType'=> $row['TransactionType'],
                'IsAccess' => $row['IsAccess'],
                'AccAccess' => $row['AccAccess']
            ]);

            echo json_encode($data);
        }
    }

    //Edit function user
    public function EditUser($fname,$mname,$lname,$dep,$bDay,$emailAdd,$updatedBy,$updateDate,$platform,$accType,$userid,$IsAccess){
        $query = 'UPDATE TblUser SET EmpFirstName = :EmpFirstName, EmpMiddleName = :EmpMiddleName, 
        EmpLastName = :EmpLastName, EmpDepartment = :EmpDepartment, EmpBirthDate = :EmpBirthDate,EmpEmailAddress = :EmpEmailAddress,
        UpdatedBy = :UpdatedBy,UpdatedDate = :UpdateDate, Platform = :Platform, AccountType = :AccountType,IsAccess = :IsAccess WHERE UserID = :UserID';
        $param = array('UserID' => $userid,':EmpFirstName' => $fname,':EmpMiddleName' => $mname,
        'EmpLastName' => $lname,'EmpDepartment' => $dep, 'EmpBirthDate' => $bDay,'EmpEmailAddress' => $emailAdd,
        'UpdatedBy' => $updatedBy, 'UpdateDate' => $updateDate,'Platform' => $platform, 'AccountType'=>$accType, 'IsAccess' => $IsAccess);
        $stmt =$this->mssql_connect()->prepare($query);
        $result = $stmt->execute($param);
        return true;
    }


    //Get account access
    public function GetAccountAccess(){
        $query = "SELECT ID,JobDesc FROM TblAccAccess ORDER BY ID ASC";
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        if($row){
            echo '<select name="accAccess" id="accAccess" class="w-full h-12 ml-0 rounded-md">';
            echo '<option value="">--Select Account Access--</option>';
            do{
                    echo '<option class="text-md text-third font-medium" value="'.$row['ID'].'">'.$row['JobDesc'].'</option>';
                }while($row = $stmt->fetch());
            echo '</select>';       
        }
    }


    //get user logs
    public function GetUserLogs(){
        $query = "Select			
                dbo.udf_GetDepartmentTAT(b.EmpDepartment) as [Department],
                a.UserID as [User ID],
                dbo.udf_GetUserName(a.UserID) as [User],
				CASE
                    WHEN dbo.udf_GetAccAccess(b.IsAccess) IS NULL THEN 'Admin'
                    ELSE dbo.udf_GetAccAccess(b.IsAccess)
                END as [Account Access],
                FORMAT(LastLoginDateTime,'yyyy-MM-dd HH:mm:ss') as [login],
                FORMAT(LastLogoutDateTime,'yyyy-MM-dd HH:mm:ss') as [logout]
                from Tbl_UserLogs a
				inner join TblUser b on a.UserID = b.UserID
				order by LastLoginDateTime desc";
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $counter = 0;

        if($row){
            echo'<table class="w-full table-auto bg-white mr-48" id="table-user-logs">
                    <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                        <tr class="">
                            <th class="p-2"></th>
                            <th class="p-2">Department</th>
                            <th class="p-2">User ID</th>
                            <th class="p-2">User</th>
                             <th class="p-2">Account Access</th>
                            <th class="p-2">Last Login DateTime</th>
                            <th class="p-2">Last Logout DateTime</th>
                        </tr>
                    </thead>
                    <tbody>';   
            do{
                echo '<tr class="align-top border bottom-px text-third bg-white">
                        <td class="p-2 text-left">'.++$counter.'</td>
                        <td class="p-2 text-left">'.$row['Department'].'</td>
                        <td class="p-2 text-left">'.$row['User ID'].'</td>
                        <td class="p-2 text-left">'.$row['User'].'</td>
                        <td class="p-2 text-left">'.$row['Account Access'].'</td>
                        <td class="p-2 text-left">'.$row['login'].'</td>
                        <td class="p-2 text-left">'.$row['logout'].'</td>
                    </tr>';
            }while($row = $stmt->fetch());

            echo '</tbody>
            <tfoot>
                <tr class="border-t-2 border-third">
                    
                </tr>
            </tfoot>
        </table>';
        }
        
    }

}