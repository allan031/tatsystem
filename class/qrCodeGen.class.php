<?php 
include_once dirname(__DIR__,1).'../class/dbconnBizbox.class.php';
include_once dirname(__DIR__,1).'/class/dbconn.class.php'; 
//ini_set('memory_limit', '1024M');    

class QrCodeGeneration extends DBConnection {

    public function InsertQR($patID,$qrcode,$sex,$ageGroup,$createdBy,$createdDate){
        $query = 'INSERT INTO  TblPatient(PatientID,QRCode,PatientSex,PatientAgeGroup,CreatedBy,CreatedDate) 
        VALUES (:PatientID,:QRCode,:PatientSex,:PatientAgeGroup,:CreatedBy,:CreatedDate)';
        $param = array(':PatientID' => $patID,':QRCode'=>$qrcode,':PatientSex'=> $sex,
        ':PatientAgeGroup'=>$ageGroup,':CreatedBy'=>$createdBy,':CreatedDate'=>$createdDate);
        $stmt =$this->mssql_connect()->prepare($query);                                                                                                    $result = $stmt->execute($param);
        echo $result; 
    }

    //check if tat start already in db
    public function CheckTAT($qrcode,$deptD,$procTypeID,$subprocTypeID,$procedure,$tranxTiming){
        $query = "Select * from TblTransaction where
        QRCode = :QRCode and DepartmentID = :DepartmentID 
        and ProcedureTypeID = :ProcedureTypeID and SubProcedureTypeID = :SubProcedureTypeID and 
        [Procedure] = :Procedure and TransactionTiming = :TransactionTiming";
        $param = array(':QRCode' =>$qrcode,':DepartmentID' =>$deptD,
        ':ProcedureTypeID' =>$procTypeID, ':SubProcedureTypeID' =>$subprocTypeID,
        ':Procedure' => $procedure,':TransactionTiming' => $tranxTiming);
        $stmt = $this->mssql_connect()->prepare($query);
        $stmt->execute($param);
        $row = $stmt->fetch();
        if($row){
            return true;
        }else{
            return false;
        }
    }

    //working on Tranx ID
    public function InsertTAT($qrcode,$deptD,$procTypeID,$subprocTypeID,$procedure,$scanDate,$tranxTiming,$remarks,$createdBy,$createdDate){
        $data = [];
        $SuccessMessage = "";
        $ErrorMessage = "";
        if($this->CheckTAT($qrcode,$deptD,$procTypeID,$subprocTypeID,$procedure,$tranxTiming) === true){
            $ErrorMessage = "There is an existing TAT in the database!";
        }else{
            if($procTypeID == 9002){
                if($tranxTiming == 'End'){
                    try{ //add try catch to get the error from the database
                        $this->InsertPatientNumber($qrcode,$createdBy,$createdDate);
                    }catch(Exception $e){
                        $ErrorMessage = 'Message: ' . $e->getMessage();
                    }
                    $query = 'INSERT INTO  TblTransaction(QRCode,DepartmentID,
                    ProcedureTypeID,SubProcedureTypeID,[Procedure],ScanDate,TransactionTiming,Remarks,CreatedBy,CreatedDate) 
                    VALUES (:QRCode,:DepartmentID,:ProcedureTypeID,:SubProcedureTypeID,:Procedure,
                    :ScanDate,:TransactionTiming,:Remarks,:CreatedBy,:CreatedDate)';
                    $param = array(':QRCode'=>$qrcode,':DepartmentID'=> $deptD,
                    ':ProcedureTypeID'=>$procTypeID,':SubProcedureTypeID' => $subprocTypeID
                    ,':Procedure'=>$procedure,':ScanDate'=> $scanDate,
                    'TransactionTiming'=>$tranxTiming,':Remarks' => $remarks ,':CreatedBy'=>$createdBy,':CreatedDate'=>$createdDate);
                    $stmt =$this->mssql_connect()->prepare($query);                                                                                                    
                    $result = $stmt->execute($param);
                    $SuccessMessage = 'TAT added successfully!';
                }else{
                    $query = 'INSERT INTO  TblTransaction(QRCode,DepartmentID,
                    ProcedureTypeID,SubProcedureTypeID,[Procedure],ScanDate,TransactionTiming,Remarks,CreatedBy,CreatedDate) 
                    VALUES (:QRCode,:DepartmentID,:ProcedureTypeID,:SubProcedureTypeID,:Procedure,
                    :ScanDate,:TransactionTiming,:Remarks,:CreatedBy,:CreatedDate)';
                    $param = array(':QRCode'=>$qrcode,':DepartmentID'=> $deptD,
                    ':ProcedureTypeID'=>$procTypeID,':SubProcedureTypeID' => $subprocTypeID
                    ,':Procedure'=>$procedure,':ScanDate'=> $scanDate,
                    'TransactionTiming'=>$tranxTiming,':Remarks' => $remarks ,':CreatedBy'=>$createdBy,':CreatedDate'=>$createdDate);
                    $stmt =$this->mssql_connect()->prepare($query);                                                                                                    
                    $result = $stmt->execute($param);
                    $SuccessMessage = 'TAT added successfully!';
                }
            }else{
                $query = 'INSERT INTO  TblTransaction(QRCode,DepartmentID,
                ProcedureTypeID,SubProcedureTypeID,[Procedure],ScanDate,TransactionTiming,Remarks,CreatedBy,CreatedDate) 
                VALUES (:QRCode,:DepartmentID,:ProcedureTypeID,:SubProcedureTypeID,:Procedure,
                :ScanDate,:TransactionTiming,:Remarks,:CreatedBy,:CreatedDate)';
                $param = array(':QRCode'=>$qrcode,':DepartmentID'=> $deptD,
                ':ProcedureTypeID'=>$procTypeID,':SubProcedureTypeID' => $subprocTypeID
                ,':Procedure'=>$procedure,':ScanDate'=> $scanDate,
                'TransactionTiming'=>$tranxTiming,':Remarks' => $remarks ,':CreatedBy'=>$createdBy,':CreatedDate'=>$createdDate);
                $stmt =$this->mssql_connect()->prepare($query);                                                                                                    
                $result = $stmt->execute($param);
                $SuccessMessage = 'TAT added successfully!';
            }
        }
        $data = array([
            'errormsg'=> $ErrorMessage,
            'successmsg' => $SuccessMessage
        ]);
        echo json_encode($data);
    }

    //get procedure type
    public function GetProcedureType($deptID){
        $output = "";
        if($deptID == 2013){
            $query = "SELECT ProcedureTypeID,ProcedureType FROM vw_TATProcedureType
            where ProcedureTypeID in (9008,9004,9005,9006,9007,9002,9003)
            ORDER By CreatedDate DESC";
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch();
            if($row){ 
                $output .= '<label for="Procedure" class="text-third text-lg">Choose from the list:</label><br>';
                $output .= '<ul class= px-2 text-white rounded-md">';
                    do{
                        $output .= '<li>
                                        <input type="checkbox" class="checkboxBtnClassProcedure mr-2" id="'.$row['ProcedureType'].'" name="'.$row['ProcedureType'].'" value="'.$row['ProcedureTypeID'].'">
                                        <label for="'.$row['ProcedureType'].'" class="text-third text-lg">'.$row['ProcedureType'].'</label><br>
                                    </li>';
                    }while($row = $stmt->fetch());
                $output .= '</ul>';       
            }
        }else if($deptID == 2024 || $deptID == 2038){
            $query = "SELECT ProcedureTypeID,ProcedureType FROM vw_TATProcedureType
            where ProcedureTypeID = 9004
            ORDER By CreatedDate DESC";
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch();
            if($row){
                $output .= '<label for="Procedure" class="text-third text-lg">Choose from the list:</label><br>';
                $output .= '<ul class=" px-2 text-third rounded-md">';
                    do{
                        $output .= '<li>
                                        <input type="checkbox" class="checkboxBtnClassProcedure mr-2" name="tranType" value="'.$row['ProcedureTypeID'].'">
                                        <label for="Charging" class="text-third text-lg">'.$row['ProcedureType'].'</label><br>
                                    </li>';
                    }while($row = $stmt->fetch());
                $output .= '</ul>';       
            }
        }else{
            $query = "SELECT ProcedureTypeID,ProcedureType FROM vw_TATProcedureType 
            where Department = '".$deptID. "' ORDER By CreatedDate DESC";
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch();
            if($row){
                $output .= '<label for="Procedure" class="text-third text-lg">Choose from the list:</label><br>';
                $output .= '<ul class=" px-2 text-third rounded-md">';
                    do{
                        $output .= '<li>
                                        <input type="checkbox" class="checkboxBtnClassProcedure mr-2" name="tranType" value="'.$row['ProcedureTypeID'].'">
                                        <label for="Charging" class="text-third text-lg">'.$row['ProcedureType'].'</label><br>
                                    </li>';
                    }while($row = $stmt->fetch());
                $output .= '</ul>';       
            }
        }
        echo $output; 
    }

    //modified function for listing of TAT process
    public function GetProcedureTypeModified($deptID,$isAccess){
        $output = "";
        if($deptID == 2013){
            $query = "SELECT ProcedureTypeID,ProcedureType FROM vw_TATProcedureType where IsAccess ='".$isAccess ."' 
            and Department = '".$deptID."' ORDER By ProcedureTypeID ASC";
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch();
            if($row){
                $output .= '<label for="Procedure" class="text-third text-[20px]">Choose from the list:</label><br>';
                $output .= '<ul class= px-2 text-white rounded-md">';
                    do{
                        $output .= '<li id="'.$row['ProcedureTypeID'].'">
                                        <input type="checkbox" class="checkboxBtnClassProcedure mr-2 h-10 w-10" id="'.$row['ProcedureType'].'" name="procedureType" value="'.$row['ProcedureTypeID'].'">
                                        <label for="'.$row['ProcedureType'].'" class="text-third text-[22px]">'.$row['ProcedureType'].'</label><br>
                                    </li>';
                        if($row['ProcedureTypeID'] == 9004){
                            $output .= '<div class="" id="dro-sublist">
                                        </div>';
                        }if($row['ProcedureTypeID'] == 9003){
                            $output .= '<div class="" id="droc-sublist">
                                        </div>';
                        }if($row['ProcedureTypeID'] == 9006){
                            $output .= '<div class="" id="ready-sublist">
                                        </div>';
                        }if($row['ProcedureTypeID'] == 9002){
                            $output .= '<div class="" id="dro-sublist">
                                        </div>';
                        }if($row['ProcedureTypeID'] == 9008){
                            $output .= '<div class="" id="dis-sublist">
                                        </div>';
                        }
                    }while($row = $stmt->fetch());
                $output .= '</ul>';       
            }
        }else if($deptID == 2024 || $deptID == 2038){
            $query = "SELECT ProcedureTypeID,ProcedureType FROM vw_TATProcedureType 
            where ProcedureTypeID = 9004 AND IsAccess ='". $isAccess ."' ORDER By CreatedDate DESC";
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch();
            if($row){
                $output .= '<label for="Procedure" class="text-third text-[20px]">Choose from the list:</label><br>';
                $output .= '<ul class=" px-2 text-third rounded-md">';
                    do{
                        $output .= '<li>
                                        <input type="checkbox" class="checkboxBtnClassProcedure mr-2 h-10 w-10" name="procedureType" value="'.$row['ProcedureTypeID'].'">
                                        <label for="Charging" class="text-third text-[22px]">'.$row['ProcedureType'].'</label><br>
                                    </li>';
                        if($row['ProcedureTypeID'] == 9004){
                            $output .= '<div class="" id="dro-sublist">
                                        </div>';
                        }if($row['ProcedureTypeID'] == 9003){
                            $output .= '<div class="" id="droc-sublist">
                                        </div>';
                        }if($row['ProcedureTypeID'] == 9006){
                            $output .= '<div class="" id="ready-sublist">
                                        </div>';
                        }
                    }while($row = $stmt->fetch());
                $output .= '</ul>';       
            }
        }else if($deptID == 2019 || $deptID == 2001){ // abang na module para sa HMO 2024-08-19 3:11PM
            $query = "SELECT ProcedureTypeID, ProcedureType 
                      FROM vw_TATProcedureType 
                      WHERE ProcedureTypeID = 9002 AND IsAccess = '". $isAccess ."' 
                      ORDER BY CreatedDate DESC";
            
            $stmt = $this->mssql_connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch();
        
            if($row){
                $output .= '<label for="Procedure" class="text-third text-[20px]">Choose from the list:</label><br>';
                $output .= '<ul class="px-2 text-third rounded-md">';
        
                do {
                    // Determine procedure type ID based on department
                    $procedureTypeID = ($deptID == 2019) ? 9009 : (($deptID == 2001) ? 9006 : $row['ProcedureTypeID']);
        
                    $output .= '<li>
                                    <input type="checkbox" class="checkboxBtnClassProcedure mr-2 h-10 w-10" 
                                           name="procedureType" value="'. $procedureTypeID .'">
                                    <label for="Charging" class="text-third text-[22px]">'.$row['ProcedureType'].'</label><br>
                                </li>';
        
                    // Conditional elements based on ProcedureTypeID
                    if($procedureTypeID == 9006) {
                        $output .= '<div id="ready-sublist"></div>';
                    }elseif($procedureTypeID == 9009){
                        $output .= '<div id="dro-sublist"></div>';
                    }
        
                } while ($row = $stmt->fetch());
        
                $output .= '</ul>';
            }
        }
        
        // else if($deptID == 2004){ // abang na module para sa Billing dept 2024-09-23 2:34PM      //commented 2024/11/21 11:29AM
        //     $query = "SELECT ProcedureTypeID,ProcedureType FROM vw_TATProcedureType 
        //     where ProcedureTypeID = 9002 AND IsAccess ='". $isAccess ."' ORDER By CreatedDate DESC";
        //     $stmt =$this->mssql_connect()->prepare($query);
        //     $stmt->execute();
        //     $row = $stmt->fetch();
        //     if($row){
        //         $output .= '<label for="Procedure" class="text-third text-[20px]">Choose from the list:</label><br>';
        //         $output .= '<ul class=" px-2 text-third rounded-md">';
        //             do{
        //                 $output .= '<li>
        //                                 <input type="checkbox" class="checkboxBtnClassProcedure mr-2 h-10 w-10" name="procedureType" value="'.$row['ProcedureTypeID'].'">
        //                                 <label for="Charging" class="text-third text-[22px]">'.$row['ProcedureType'].'</label><br>
        //                             </li>';
        //                 if($row['ProcedureTypeID'] == 9004){
        //                     $output .= '<div class="" id="dro-sublist">
        //                                 </div>';
        //                 }if($row['ProcedureTypeID'] == 9003){
        //                     $output .= '<div class="" id="droc-sublist">
        //                                 </div>';
        //                 }if($row['ProcedureTypeID'] == 9002){
        //                     $output .= '<div class="" id="dro-sublist">
        //                                 </div>';
        //                 }if($row['ProcedureTypeID'] == 9006){
        //                     $output .= '<div class="" id="ready-sublist">
        //                                 </div>';
        //                 }
        //             }while($row = $stmt->fetch());
        //         $output .= '</ul>';       
        //     }
        // }
        else{
            $query = "SELECT ProcedureTypeID,ProcedureType FROM vw_TATProcedureType 
            where Department = '".$deptID. "' AND IsAccess = '".$isAccess."' ORDER By CreatedDate DESC";
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch();
            if($row){
                $output .= '<label for="Procedure" class="text-third text-lg">Choose from the list:</label><br>';
                $output .= '<ul class=" px-2 text-third rounded-md">';
                    do{
                        $output .= '<li>
                                        <input type="checkbox" class="checkboxBtnClassProcedure mr-2 h-10 w-10" name="procedureType" value="'.$row['ProcedureTypeID'].'">
                                        <label for="Charging" class="text-third text-[22px]">'.$row['ProcedureType'].'</label><br>
                                    </li>';
                        if($row['ProcedureTypeID'] == 9004){
                            $output .= '<div class="" id="dro-sublist">
                                        </div>';
                        }if($row['ProcedureTypeID'] == 9003){
                            $output .= '<div class="" id="droc-sublist">
                                        </div>';
                        }if($row['ProcedureTypeID'] == 9006){
                            $output .= '<div class="" id="ready-sublist">
                                        </div>';
                        }
                    }while($row = $stmt->fetch());
                $output .= '</ul>';       
            }
        }
        echo $output; 
    }

    //show sub list when select DR ORDER
    public function GetSubProcedureType($subProcTypeID,$deptID){
        $output = "";
        if($deptID == 2013){
            $query = "Select ID,
            SubProcedureType as [SubProcedureType]
            ,ProcedureTypeID from TblSubProcedureType where ProcedureTypeID = :ProcedureTypeID
             and DepartmentID = :DepartmentID";
            $param = array(':ProcedureTypeID' => $subProcTypeID,':DepartmentID' => $deptID);
            $stmt = $this->mssql_connect()->prepare($query);
            $stmt->execute($param);
            $row = $stmt->fetch();
            if($row){
                $output .= '
                    <ul class="px-5 text-third rounded-md" id="9005-sub">';
                do{
                    $output .= '
                        <li>
                            <input type="radio" class="radioBtnClassSubProcedure mr-2 h-8 w-8" id="" name="subprocedureType" value="'.$row['ID'].'">
                            <label for="test" class="text-third text-[20px]">'.$row['SubProcedureType'].'</label><br>
                        </li>';
                }while($row = $stmt->fetch());
                $output .= '
                    </ul>';
            }
        }elseif($deptID == 2024 || $deptID == 2038){
            $query = "Select ID,
            SubProcedureType as [SubProcedureType]
            ,ProcedureTypeID from TblSubProcedureType where ProcedureTypeID = :ProcedureTypeID
            and DepartmentID = :DepartmentID";
            $param = array(':ProcedureTypeID' => 0, ':DepartmentID' => $deptID);
            $stmt = $this->mssql_connect()->prepare($query);
            $stmt->execute($param);
            $row = $stmt->fetch();
            if($row){
                $output .= '
                    <ul class="px-5 text-third rounded-md" id="9005-sub">';
                do{
                    $output .= '
                        <li>
                            <input type="radio" class="radioBtnClassSubProcedure mr-2 h-8 w-8" id="" name="subprocedureType" value="'.$row['ID'].'">
                            <label for="test" class="text-third text-[20px]">'.$row['SubProcedureType'].'</label><br>
                        </li>';
                }while($row = $stmt->fetch());
                $output .= '
                    </ul>';
            }
        }elseif($deptID == 2004){ /* for Biling dept 2024/09/23 2:38PM */
            $query = "Select ID,
            SubProcedureType as [SubProcedureType]
            ,ProcedureTypeID from TblSubProcedureType where ID = :ID and ProcedureTypeID = :ProcedureTypeID";
            $param = array(':ID' => 18,':ProcedureTypeID' => $subProcTypeID);
            $stmt = $this->mssql_connect()->prepare($query);
            $stmt->execute($param);
            $row = $stmt->fetch();
            if($row){
                $output .= '
                    <ul class="px-5 text-third rounded-md" id="9005-sub">';
                do{
                    $output .= '
                        <li>
                            <input type="radio" class="radioBtnClassSubProcedure mr-2 h-8 w-8" id="" name="subprocedureType" value="'.$row['ID'].'">
                            <label for="test" class="text-third text-[20px]">'.$row['SubProcedureType'].'</label><br>
                        </li>';
                }while($row = $stmt->fetch());
                $output .= '
                    </ul>';
            }
        }elseif($deptID == 2019 || $deptID == 2001){ // HMO module and admitting edit date 11/21/2024 10:00AM
                $query = "Select ID,
                SubProcedureType as [SubProcedureType]
                ,ProcedureTypeID from TblSubProcedureType where DepartmentID = :DepartmentID";
                $param = array(':DepartmentID' => $deptID);
                $stmt = $this->mssql_connect()->prepare($query);
                $stmt->execute($param);
                $row = $stmt->fetch();
                if($row){
                    $output .= '
                        <ul class="px-5 text-third rounded-md" id="9005-sub">';
                    do{
                        $output .= '
                            <li>
                                <input type="radio" class="radioBtnClassSubProcedure mr-2 h-8 w-8" id="" name="subprocedureType" value="'.$row['ID'].'">
                                <label for="test" class="text-third text-[20px]">'.$row['SubProcedureType'].'</label><br>
                            </li>';
                    }while($row = $stmt->fetch());
                    $output .= '
                        </ul>';
                }
        }else{  
            $query = "Select ID,
            SubProcedureType as [SubProcedureType]
            ,ProcedureTypeID from TblSubProcedureType where ProcedureTypeID = :ProcedureTypeID and 
            DepartmentID = :DepartmentID";
            $param = array(':ProcedureTypeID' => $subProcTypeID, ':DepartmentID' => $deptID);
            $stmt = $this->mssql_connect()->prepare($query);
            $stmt->execute($param);
            $row = $stmt->fetch();
            if($row){
                $output .= '
                    <ul class="px-5 text-third rounded-md" id="9005-sub">';
                do{
                    $output .= '
                        <li>
                            <input type="radio" class="radioBtnClassSubProcedure mr-2 h-8 w-8" id="" name="subprocedureType" value="'.$row['ID'].'">
                            <label for="test" class="text-third text-[20px]">'.$row['SubProcedureType'].'</label><br>
                        </li>';
                }while($row = $stmt->fetch());
                $output .= '
                    </ul>';
            }
        }
        echo $output;
    }

    //get procedure type
    public function GetProcedure($procTypeID){
        $query = "SELECT ProcedureID,ProcedureTypeID,[Procedure] FROM TblProcedure where ProcedureTypeID = :ProcedureTypeID";
        $param = array(':ProcedureTypeID' => $procTypeID);
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute($param);

        $data = [];
        while($row = $stmt->fetch()){
             $data[$row['ProcedureID']] = $row['Procedure'];
        }
        echo json_encode($data);
    }

    //get department base on user login
    public function GetDept($deptID){
        $query = "SELECT DepartmentID,DepartmentName,DepartmentAbbreviation FROM TblDepartment where DepartmentID LIKE '%".$deptID."%'";
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute();

        $data = [];
        while($row = $stmt->fetch()){
            $data = array([
                'id' => $row['DepartmentID'],
                'DeptName' => $row['DepartmentName'],
                'DeptAbb' => $row['DepartmentAbbreviation']
            ]);
        }
        echo json_encode($data);
    }


    //get transaction type based on user acc access
    public function GetTranxType($userID){
        $output = "";
        $query = "SELECT TransactionType FROM TblUser where UserID ='".$userID."'";
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        if($row['TransactionType'] == 0){
                do{
                    $output .= '<div class="flex flex-col">';
                    $output .= '<div class="px-2">
                                    <input type="radio" id="rd-charging" class="radioBtnClass mr-2" name="tranType" value="1">
                                    <label for="Charging" class="text-third text-lg">Charging</label><br>
                                </div>
                                <div class="px-2">
                                    <input type="radio" id="rd-procedure" class="radioBtnClass mr-2" name="tranType" value="2">
                                    <label for="Procedure" class="text-third text-lg">Procedure</label><br>
                                </div>';
                }while($row = $stmt->fetch());
            $output .= '</div>';       
        }else if($row['TransactionType'] == 1){
            do{
                $output .= '<div class="flex flex-col">';
                $output .= '<div class="px-2">
                                <input type="radio" id="rd-charging" class="radioBtnClass mr-2" name="tranType" value="1">
                                <label for="Charging" class="text-third text-lg">Charging</label><br>
                            </div>';
            }while($row = $stmt->fetch());
        $output .= '</div>';       
        }else{
            do{
                $output .= '<div class="flex flex-col">';
                $output .= '<div class="px-2">
                                <input type="radio" id="rd-procedure" class="radioBtnClass mr-2" name="tranType" value="2">
                                <label for="Procedure" class="text-third text-lg">Procedure</label><br>
                            </div>';
            }while($row = $stmt->fetch());
        $output .= '</div>';     
        }
        echo $output;
    }

    // //get transaction which is not ended yet
    public function GetStartProcess($depID,$UserID){
        $query = "Select * from vw_TATtransaction where [End] is null and  DepartmentID = :DepartmentID and CreatedBy = :UserID";
        $param = array(':DepartmentID' => $depID,':UserID' => $UserID);
        $stmt = $this->mssql_connect()->prepare($query);
        $stmt->execute($param);
        $data = [];
        while($row = $stmt->fetch()){
            if($row > 0){
                $data[] = $row;
            }
        }
        echo json_encode($data);
    }

    public function CheckTranxID($tranxID){
        $query = "Select TransactionID_FK from TblNotification 
        where TransactionID_FK = :TransactionID_FK";
        $param = array(':TransactionID_FK' => $tranxID);
        $stmt = $this->mssql_connect()->prepare($query);
        $stmt->execute($param);
        $row = $stmt->fetch();
        if($row){
            return true;
        }else{
            return false;
        }
    }

    //insert exceed process
    public function InsertExceedTAT($tranxID,$createdBy,$createdDate){
        if($this->CheckTranxID($tranxID) === true){

        }else{
            $query = "INSERT INTO TblNotification(TransactionID_FK,Exceed,IsExceed,CreatedBy,CreatedDate) 
            values (:TransactionID_FK,:Exceed,:IsExceed,:CreatedBy,:CreatedDate)";
            $param = array(':TransactionID_FK' => $tranxID,':Exceed' => 'YES',':IsExceed' => 1,
            ':CreatedBy' => $createdBy,':CreatedDate' => $createdDate);
            $stmt = $this->mssql_connect()->prepare($query);
            $result = $stmt->execute($param);
            return true;
        }
    }

    //select process which exceeds time
    public function GetExceedProcess($qr,$procID,$subProcID){
        $query = "Select a.TransactionID_FK,a.Exceed,a.IsExceed from TblNotification a 
        inner join TblTransaction b ON a.TransactionID_FK = b.TransactionID
        where b.QRCode = :QRCode
        and b.ProcedureTypeID = :ProcedureTypeID
        and b.SubProcedureTypeID = :SubProcedureTypeID";
        $param = array(':QRCode' =>$qr ,
         ':ProcedureTypeID' =>$procID, ':SubProcedureTypeID'=>$subProcID);
        $stmt = $this->mssql_connect()->prepare($query);
        $stmt->execute($param);
        $row = $stmt->fetch();

        $data = [];
        if($row){
            do{
                $data = array([
                    'TransactionID_FK' => $row['TransactionID_FK'],
                    'Exceed' => $row['Exceed'],
                    'IsExceed' => $row['IsExceed'],
                ]);
            }while($row = $stmt->fetch());
        }
        echo json_encode($data);
    }

    //update exceed process
    public function UpdateTAT($trxID,$updatedBy,$updatedDate){
        $query = "Update TblNotification set IsExceed = :IsExceed, UpdatedBy = :UpdatedBy,  
        UpdatedDate = :UpdatedDate where TransactionID_FK = :TransactionID_FK";
        $param = array(':IsExceed' => 0,':UpdatedBy' => $updatedBy,
        ':UpdatedDate' => $updatedDate, ':TransactionID_FK' => $trxID);
        $stmt = $this->mssql_connect()->prepare($query);
        $result = $stmt->execute($param);
        return true;
    }

    //get and count process exceed
    public function ExceedTATCount($deptID,$userID){
        $query = "Select Count(*) as [CountRows] from TblNotification a
        inner join TblTransaction b ON a.TransactionID_FK = b.TransactionID
        where a.IsExceed = 1
        and b.DepartmentID = :DepartmentID and a.CreatedBy = :UserID";
        $param = array(':DepartmentID' => $deptID, ':UserID' => $userID);
        $stmt = $this->mssql_connect()->prepare($query);
        $stmt->execute($param);
        $row = $stmt->fetch();

        $data = [];
        if($row){
           do{
                $data = array([
                    'CountNotifs' => $row['CountRows']
                ]);
            }while($row = $stmt->fetch());
        }
        echo json_encode($data);
    }

    // //get notifs
    public function GetNotifications($deptID,$UserID){ 
        $query = "Select 
        a.TransactionID,
        a.QRCode,
		CASE
			WHEN Staging_TAT.[dbo].udf_GetLastNameInit(a.QRCode) IS NULL THEN a.QRCode
			ELSE Staging_TAT.[dbo].udf_GetLastNameInit(a.QRCode)
		END as [Patient],
        a.DepartmentID,
        dbo.udf_GetDepartmentTAT(a.DepartmentID) as [Department],
        dbo.udf_GetTranxTAT(a.TransactionTypeID) as [TransactionType],
		a.ProcedureTypeID,
        dbo.udf_GetProcedureTypeTAT(a.ProcedureTypeID) as [ProcedureType],
		a.SubProcedureTypeID,
        a.[Procedure],
        CASE WHEN a.ProcedureTypeID = 9003 and a.SubProcedureTypeID = 0 THEN 'Non-HMO'
        WHEN a.SubProcedureTypeID = 0 THEN 'N/A'
        ELSE dbo.udf_GetSubProcedureTypeTAT(a.SubProcedureTypeID) END as [SubProcedureType],
        FORMAT(b.CreatedDate, 'MMM dd, yyyy hh:mm') as [CreatedDate],
		a.CreatedBy
        from TblTransaction a
        inner join TblNotification b ON  a.TransactionID = b.TransactionID_FK
        where b.IsExceed = 1
        and a.DepartmentID = :DepartmentID
        and a.CreatedBy = :UserID
        ORDER by b.CreatedDate DESC";
        $param = array(':DepartmentID' => $deptID,':UserID' => $UserID);
        $stmt = $this->mssql_connect()->prepare($query);
        $stmt->execute($param);
        while($row = $stmt->fetch()){
            if($row > 0){
                $data[] = $row;
            }else{
                $data = [];
            }
        }
        echo json_encode($data);
    }

    //insert Patient Number from bizbox to TblPatientInfo
    public function InsertPatientNumber($qrcode, $updatedBy, $updatedDate){
        // Original code
        // $query = "Select 
        // Local_DB.dbo.udf_GetFullName(FK_emdPatients) as [name],
        // FK_emdPatients as [PatientNumber_HIS]
        // from Local_DB.dbo.psPatRegisters
        // where remarks = :QRCode";
        // $param = array(':QRCode' => $qrcode);
        // $stmt = $this->mssql_connect()->prepare($query);
        // $stmt->execute($param);
        // $row = $stmt->fetch();

        // Updated code for Staging_TAT
        $query = "Select 
        FullName,
        HIS_ID as [PatientNumber_HIS],
        impression
        from Staging_TAT.dbo.Tbl_PatRegister
        where remarks = :QRCode";
        $param = array(':QRCode' => $qrcode);
        $stmt = $this->mssql_connect()->prepare($query);
        $stmt->execute($param);
        $row = $stmt->fetch();
        
        //check if have there are returned rows
        if($row){
            $query = "Update TblPatient set PatientNumber = :PatientNumber, UpdatedBy = :UpdatedBy, UpdateDate = :UpdatedDate,
            PatientFullName = :PatientFullName, Impression = :Impression where PatientID = :PatientID";
            $param = array(':PatientNumber' => $row['PatientNumber_HIS'], ':PatientID' => $qrcode,
             ':UpdatedBy' => $updatedBy, ':UpdatedDate' => $updatedDate, ':PatientFullName' => $row['FullName'], ':Impression' => $row['impression']);
            $stmt = $this->mssql_connect()->prepare($query);
            $result = $stmt->execute($param);
            return $result;
        }else{
            return false;
        }
    }


    //get lab procedures
    // public function GetLabProcedures($type){
    //     $query = 'Select * from Staging_TAT.[dbo].Tbl_LabItems where itemcategory = :LabExam order by item';
    //     $param = array(':LabExam' => $type);
    //     $stmt = $this->mssql_connect()->prepare($query);
    //     $stmt->execute($param);

    //     while($row = $stmt->fetch()){ 
    //         $data[] = $row;
    //     }
    //     echo json_encode($data);
    // }

}

// class QrCodeGeneration2 extends DBConnectionBizbox{
//     //get lab procedures
//     public function GetLabProcedures($type){
//         $query = 'Select * from Tbl_LabItems where itemcategory = :LabExam order by item';
//         $param = array(':LabExam' => $type);
//         $stmt = $this->mssql_connect_bizbox()->prepare($query);
//         $stmt->execute($param);

//         while($row = $stmt->fetch()){
//             $data[] = $row;
//         }
//         echo json_encode($data);
//     }
// }