<?php
ini_set('memory_limit', '44M');
include_once dirname(__DIR__,1).'/class/dbconn.class.php';

class Patient extends DBConnection{
    //function to search and display patients
    public function SearchPatientList($searchFilter,$searchVal,$pageVal){
        $limit = 10; 
        $page = 0;

        $display = ""; 
 
        if($pageVal != ""){
            $page = $pageVal;
        }else{
            $page = 1;
        }

        $start_from = (($page - 1) * $limit) + 1;
        $max = $page * $limit;

        if($searchVal == "" || $searchFilter == ""){
                        //get all patients
            $query = "SELECT  *
            FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY PatientID DESC ) AS RowNum, *
                        FROM      vw_TATPatient
                    ) AS RowConstrainedResult
            WHERE   (RowNum >= :start_from
                AND RowNum <= :max)
            ORDER BY RowNum";
            $param = array(':start_from'=>$start_from, ':max'=> $max);
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute($param);
            $row = $stmt->fetch();
            $counter = 0;

            //count of all patient
            $query2 = "SELECT COUNT(PatientID) as [RowCount] from TblPatient";
            $stmt2 =$this->mssql_connect()->prepare($query2);
            $stmt2->execute();
            $count_rows = $stmt2->fetch();

            //pagination
            $total_pages = ceil($count_rows['RowCount']/$limit);

            $display .= '
                <div class="flex flex-row mb-5 items-start justify-start bg-gray-800>"
                <ul class="flex -space-x-px list-none list-inside">';
            
                if($page > 0){
                    $prev = $page - 1;

                    $display .= '<li class="list-none rounded-l-lg page-item px-3 py-2 leading-tight text-white bg-blue-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" id="1"><span class="page-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M15 6l-6 6l6 6"></path>
                    </svg></span></li>';
                }

                for($i=1;$i<=$total_pages;$i++){
                    $active_class = "";
                    if($i == $page){
                        $active_class = "active";
                    }
                    $display .= '
                    <li class="text-center text-[20px] list-none page-item '.$active_class.' w-16 h-12 px-3 py-2 leading-tight text-white bg-blue-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" id="'.$i.'"><span class="page-link">'.$i.'</span></li>';
                }
                if($page < $total_pages){
                    $page++;
                    $display .= '<li class="list-none rounded-r-lg page-item px-3 py-2 leading-tight text-white bg-blue-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" id="'.$total_pages.'"><span class="page-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M9 6l6 6l-6 6"></path>
                    </svg></span</li>';
                }
                $display .= '
                </ul>
                </div>';

            $display .= '<div id="print-table-div" class="print-table-div">
                <table id="print-table" class="print-table w-full table-auto bg-white mr-48 mt-5">
                    <thead class="thead-table text-md font-semibold text-third bg-white uppercase border bottom-px">
                        <tr class="">
                            <th class="p-2"></th>
                            <th class="p-2">QR Code</th>
                            <th class="p-2">Sex</th>
                            <th class="p-2">Age Group</th>
                            <th class="p-2">Patient ID (From Bizbox)</th>
                            <th class="p-2">Patient Name</th>
                            <th class="p-2">Created By</th>
                            <th class="p-2">Created Date</th>
                            <th class="p-2">Updated By</th>
                            <th class="p-2">Updated Date</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-table">';
            if($row){
                do{
                    $display .= '<tr class="align-top border bottom-px text-third bg-white">
                            <td class="td-table p-2 text-center">'.++$counter.'</td>
                            <td class="p-2 text-center">'.$row['QRCode'].'</td>
                            <td class="p-2 text-center">'.$row['PatientSex'].'</td>
                            <td class="p-2 text-center">'.$row['PatientAgeGroup'].'</td>
                            <td class="p-2 text-center">'.$row['PatientNumber'].'</td>
                            <td class="p-2 text-center">'.$row['PatientName'].'</td>
                            <td class="p-2 text-center">'.$row['CreatedBy'].'</td>
                            <td class="p-2 text-center">'.$row['CreatedDate'].'</td>
                            <td class="p-2 text-center">'.$row['UpdatedBy'].'</td>
                            <td class="p-2 text-center">'.$row['UpdateDate'].'</td>
                        </tr>';
                }while($row = $stmt->fetch());

                $display .= '</tbody>';
            }else{
                $display .= '<tr>
                                <td colspan="11" class="text-center">There is no data available in the table</td>
                            </tr>';
            }
        }else{
            $query = "SELECT  *
            FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY PatientID DESC ) AS RowNum, *
                        FROM      vw_TATPatient WHERE ".$searchFilter." LIKE '".$searchVal."'
                    ) AS RowConstrainedResult
            WHERE   RowNum >= '".$start_from."'
                AND RowNum <= '".$max."'
            ORDER BY RowNum";
            //$param = array(':searchFilter'=>$searchFilter,':searchVal'=>$searchVal,':start_from'=>$start_from, ':max'=> $max);
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch();
            $counter = 0;

           if($row){
             //count of all patient based on search
             $query2 = "SELECT  COUNT(*) as [RowCount]
             FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY PatientID DESC ) AS RowNum, *
                         FROM      vw_TATPatient WHERE ".$searchFilter." LIKE '".$searchVal."'
                     ) AS RowConstrainedResult
             WHERE   RowNum >= ".$start_from."
                 AND RowNum <= ".$max."";
             //$param = array(':searchFilter'=>$searchFilter,':searchVal'=>$searchVal,':start_from'=>$start_from, ':max'=> $max);
             $stmt2 =$this->mssql_connect()->prepare($query2);
             $stmt2->execute();
             $count_rows = $stmt2->fetch();
 
 
             //pagination
             $total_pages = ceil($count_rows['RowCount']/$limit);
 
             $display .= '
                 <div class="flex flex-row mb-5 items-start justify-start bg-gray-800>"
                 <ul class="flex -space-x-px list-none list-inside">';
             
                 if($page > 0){
                     $prev = $page - 1;
 
                     $display .= '<li class="list-none rounded-l-lg page-item px-3 py-2 leading-tight text-white bg-blue-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" id="1"><span class="page-link">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                     <path d="M15 6l-6 6l6 6"></path>
                     </svg></span></li>';
                 }
 
                 for($i=1;$i<=$total_pages;$i++){
                     $active_class = "";
                     if($i == $page){
                         $active_class = "active";
                     }
                     $display .= '
                     <li class="text-center text-[20px] list-none page-item '.$active_class.' w-16 h-12 px-3 py-2 leading-tight text-white bg-blue-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" id="'.$i.'"><span class="page-link">'.$i.'</span></li>';
                 }
                 if($page < $total_pages){
                     $page++;
                     $display .= '<li class="list-none rounded-r-lg page-item px-3 py-2 leading-tight text-white bg-blue-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" id="'.$total_pages.'"><span class="page-link">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                     <path d="M9 6l6 6l-6 6"></path>
                     </svg></span</li>';
                 }
                 $display .= '
                 </ul>
                 </div>';
 
             $display .= '<div id="print-table-div" class="print-table-div">
                 <table id="print-table" class="print-table w-full table-auto bg-white mr-48 mt-5">
                     <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                         <tr class="">
                             <th class="p-2"></th>
                             <th class="p-2">QR Code</th>
                             <th class="p-2">Gender</th>
                             <th class="p-2">Age Group</th>
                             <th class="p-2">Patient ID (From Bizbox)</th>
                             <th class="p-2">Patient Name</th>
                             <th class="p-2">Created By</th>
                             <th class="p-2">Created Date</th>
                             <th class="p-2">Updated By</th>
                             <th class="p-2">Updated Date</th>
                         </tr>
                     </thead>
                     <tbody>';
             if($row){
                 do{
                     $display .= '<tr class="align-top border bottom-px text-third bg-white">
                             <td class="p-2 text-center">'.++$counter.'</td>
                             <td class="p-2 text-center">'.$row['QRCode'].'</td>
                             <td class="p-2 text-center">'.$row['PatientSex'].'</td>
                             <td class="p-2 text-center">'.$row['PatientAgeGroup'].'</td>
                             <td class="p-2 text-center">'.$row['PatientNumber'].'</td>
                             <td class="p-2 text-center">'.$row['PatientName'].'</td>
                             <td class="p-2 text-center">'.$row['CreatedBy'].'</td>
                             <td class="p-2 text-center">'.$row['CreatedDate'].'</td>
                             <td class="p-2 text-center">'.$row['UpdatedBy'].'</td>
                             <td class="p-2 text-center">'.$row['UpdateDate'].'</td>
                         </tr>';
                 }while($row = $stmt->fetch());
 
                 $display .= '</tbody>';
             }else{
                $display .= '<tr>
                                <td colspan="11" class="text-center">There is no data available in the table</td>
                            </tr>';
             }
           }else{
            $display .= '<div id="print-table-div" class="print-table-div">
                 <table id="print-table" class="print-table w-full table-auto bg-white mr-48 mt-5">
                     <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                         <tr class="">
                             <th class="p-2"></th>
                             <th class="p-2">QR Code</th>
                             <th class="p-2">Sex</th>
                             <th class="p-2">Age Group</th>
                             <th class="p-2">Patient ID (From Bizbox)</th>
                             <th class="p-2">Patient Name</th>
                             <th class="p-2">Created By</th>
                             <th class="p-2">Created Date</th>
                             <th class="p-2">Updated By</th>
                             <th class="p-2">Updated Date</th>
                         </tr>
                     </thead>
                     <tbody>';
                     $display .= '</tbody>';
                     $display .= '<tr>
                                    <td colspan="11" class="text-center">There is no data available in the table</td>
                                </tr>';
           }
        }

        $display .= '</table>
        </div>';

        
        echo $display;
    
    }

    //save patient details,EDIT Function
    public function EditPatientDetails($id,$patID_FK,$fname,$mname,$lname,$bday,$updatedBy,$updateDate){
        $query = 'UPDATE TblPatient SET PatientNumber = :PatientNumber, PatientFirstName = :PatientFirstName, PatientMiddleName = :PatientMiddleName, 
        PatientLastName = :PatientLastName, PatientBirthDate = :PatientBirthDate, UpdatedBy = :UpdatedBy,
        UpdateDate = :UpdateDate WHERE PatientID = :PatientID';
        $param = array(':PatientID' => $id,'PatientNumber' => $patID_FK,':PatientFirstName' => $fname,':PatientMiddleName' => $mname,
        'PatientLastName' => $lname, 'PatientBirthDate' => $bday, 'UpdatedBy' => $updatedBy, 'UpdateDate' => $updateDate);
        $stmt =$this->mssql_connect()->prepare($query);
        $result = $stmt->execute($param);
        return true;
    }

    //get patient w/o action
    public function SearchPatxList(){ 
            $query = "Select * from vw_TATPatient order by CreatedDate DESC";
            $stmt = $this->mssql_connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch();
            $counter = 0;

            echo'<table class="w-full table-auto bg-white mr-48" id="table-patient">
                    <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                        <tr class="">
                            <th class="p-2"></th>
                            <th class="p-2">QR Code</th>
                            <th class="p-2">Gender</th>
                            <th class="p-2">Age Group</th>
                            <th class="p-2">Patient Number(Bizbox)</th>
                            <th class="p-2">Patient Name</th>
                            <th class="p-2">Created By</th>
                            <th class="p-2">Created Date</th>
                            <th class="p-2">Updated By</th>
                            <th class="p-2">Updated Date</th>
                        </tr>
                    </thead>
                    <tbody>';    
            if($row){
                do{
                    echo '<tr class="align-top border bottom-px text-third bg-white">
                            <td class="p-2 text-center">'.++$counter.'</td>
                            <td class="p-2 text-center">'.$row['QRCode'].'</td>
                            <td class="p-2 text-center">'.$row['PatientSex'].'</td>
                            <td class="p-2 text-center">'.$row['PatientAgeGroup'].'</td>
                            <td class="p-2 text-center">'.$row['PatientNumber'].'</td>
                            <td class="p-2 text-center">'.$row['PatientName'].'</td>
                            <td class="p-2 text-center">'.$row['CreatedBy'].'</td>
                            <td class="p-2 text-center">'.$row['CreatedDate'].'</td>
                            <td class="p-2 text-center">'.$row['UpdatedBy'].'</td>
                            <td class="p-2 text-center">'.$row['UpdateDate'].'</td>
                        </tr>';
                }while($row = $stmt->fetch());
            }
            echo '</tbody>
            </table>';
    }



    //export data of patient lists
    public function ExportPL($from,$to){
        $query = "Select * from vw_TATPatient where convert(date,CreatedDate) between :from AND :to order by CreatedDate DESC";
        $param = array(':from' => $from, ':to' => $to);
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute($param);
        $row = $stmt->fetch();

        $resultArr = array();
        array_push($resultArr,array('<b>QR Code</b>','<b>Gender</b>','<b>Age Group</b>','<b>Patient Number(Bizbox)</b>',
        '<b>Patient Name</b>','<b>Created By</b>','<b>Created Date</b>','<b>Updated By</b>','<b>Updated Date</b>'));
        if($row){
            do{
                array_push($resultArr, array(
                    'QRCode' => $row['QRCode'],
                    'PatientSex' => $row['PatientSex'],
                    'PatientAgeGroup' => $row['PatientAgeGroup'],
                    'PatientNumber' => $row['PatientNumber'],
                    'PatientName' => $row['PatientName'],
                    'CreatedBy' => $row['CreatedBy'],
                    'CreatedDate' => $row['CreatedDate'],
                    'UpdatedBy' => $row['UpdatedBy'],
                    'UpdateDate' => $row['UpdateDate'],
                ));
            } while($row = $stmt->fetch());
        }

        return $resultArr;
    }



    //get patient details
    public function GetPatxDetails($id){
        $query = "SELECT  * FROM TblPatient WHERE PatientID = :PatientID";
        $param = array(':PatientID' => $id);
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute($param);
        $row = $stmt->fetch();
        
        $data = [];
        if($row){
            $data = array([
                'PatientID' => $row['PatientID'],
                'BizBoxID' => $row['PatientNumber'],
                'PatFirstName' => $row['PatientFirstName'],
                'PatMiddleName' => $row['PatientMiddleName'],
                'PatLastName' => $row['PatientLastName'],
                'PatBirthDate' => $row['PatientBirthDate'],
                'PatientSex' => $row['PatientSex'],
                'PatientAgeGroup' => $row['PatientAgeGroup']
            ]);

            echo json_encode($data);
        }
    }

    //pagination table data
    public function PaginationTable($pageVal){
        $limit = 4; 
        $page = 0;

        $display = ""; 

        if($pageVal != ""){
            $page = $pageVal;
        }else{
            $page = 1;
        }

        $start_from = (($page - 1) * $limit) + 1;
        $max = $page * $limit;
        //get all patients
        $query = "SELECT  *
        FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY CreatedDate DESC ) AS RowNum, *
                    FROM      vw_TATPatient
                ) AS RowConstrainedResult
        WHERE   RowNum >= '".$start_from."'
            AND RowNum <= '".$max."'
        ORDER BY RowNum";
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $counter = 0;

        //count of all patient
        $query2 = "SELECT COUNT(PatientID) as [RowCount] from TblPatient";
        $stmt2 =$this->mssql_connect()->prepare($query2);
        $stmt2->execute();
        $count_rows = $stmt2->fetch();

        //pagination
        $total_pages = ceil($count_rows['RowCount']/$limit);

        $display .= '
            <div class="flex flex-row mb-5 items-start justify-start bg-gray-800>"
            <ul class="flex -space-x-px list-none list-inside">';
        
            if($page > 0){
                $prev = $page - 1;

                $display .= '<li class="list-none rounded-l-lg page-item px-3 py-2 leading-tight text-white bg-blue-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" id="1"><span class="page-link">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M15 6l-6 6l6 6"></path>
                </svg></span></li>';
            }

            for($i=1;$i<=$total_pages;$i++){
                $active_class = "";
                if($i == $page){
                    $active_class = "active";
                }
                $display .= '
                <li class="text-center text-[20px] list-none page-item '.$active_class.' w-16 h-12 px-3 py-2 leading-tight text-white bg-blue-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" id="'.$i.'"><span class="page-link">'.$i.'</span></li>';
            }
            if($page < $total_pages){
                $page++;
                $display .= '<li class="list-none rounded-r-lg page-item px-3 py-2 leading-tight text-white bg-blue-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" id="'.$total_pages.'"><span class="page-link">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M9 6l6 6l-6 6"></path>
                </svg></span</li>';
            }
            $display .= '
            </ul>
            </div>';

        $display .= '
            <table class="w-full table-auto bg-white mr-48 mt-5">
                <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                    <tr class="">
                        <th class="p-2"></th>
                        <th class="p-2">QR Code</th>
                        <th class="p-2">Sex</th>
                        <th class="p-2">Age Group</th>
                        <th class="p-2">Patient ID (From Bizbox)</th>
                        <th class="p-2">Patient Name</th>
                        <th class="p-2">Created By</th>
                        <th class="p-2">Created Date</th>
                        <th class="p-2">Updated By</th>
                        <th class="p-2">Updated Date</th>
                        <th class="p-2">Action</th>
                    </tr>
                </thead>
                <tbody>';
        if($count_rows > 0){
            do{
                $display .= '<tr class="align-top border bottom-px text-third bg-white">
                        <td class="p-2 text-center">'.++$counter.'</td>
                        <td class="p-2 text-center">'.$row['QRCode'].'</td>
                        <td class="p-2 text-center">'.$row['PatientSex'].'</td>
                        <td class="p-2 text-center">'.$row['PatientAgeGroup'].'</td>
                        <td class="p-2 text-center">'.$row['PatientNumber'].'</td>
                        <td class="p-2 text-center">'.$row['PatientName'].'</td>
                        <td class="p-2 text-center">'.$row['CreatedBy'].'</td>
                        <td class="p-2 text-center">'.$row['CreatedDate'].'</td>
                        <td class="p-2 text-center">'.$row['UpdatedBy'].'</td>
                        <td class="p-2 text-center">'.$row['UpdateDate'].'</td>
                        <td class="p-2 text-center ">
                            <button 
                                id="btn-edit-patx" 
                                data-userid = "'.$row['PatientID'].'" 
                                class="btn-edit-patx hover:bg-gray-600 ">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                <path d="M16 5l3 3"></path>
                                </svg>
                            </button>
                            <button 
                                id="btn-print-qr" 
                                data-userid = "'.$row['PatientID'].'" 
                                class="btn-print-qr hover:bg-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path>
                                <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                                <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>';
            }while($row = $stmt->fetch());

            $display .= '</tbody>';
        }else{
            $display .= '<tr>
                            <td>There is no data available in the table</td>
                        </tr>';
        }

        $display .= '</table>';

        
        echo $display;

    }

    //working
    //pagination with search button
    public function PaginationTableWithSearch($searchFilter,$searchVal,$pageVal){
        $limit = 10; 
        $page = 0;

        $display = ""; 

        if($pageVal != ""){
            $page = $pageVal;
        }else{
            $page = 1;
        }

        $start_from = (($page - 1) * $limit) + 1;
        $max = $page * $limit;

        if($searchVal == "" || $searchFilter == ""){
                        //get all patients
            $query = "SELECT  *
            FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY PatientID DESC ) AS RowNum, *
                        FROM      vw_TATPatient
                    ) AS RowConstrainedResult
            WHERE   (RowNum >= :start_from
                AND RowNum <= :max)
            ORDER BY RowNum";
            $param = array(':start_from'=>$start_from, ':max'=> $max);
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute($param);
            $row = $stmt->fetch();
            $counter = 0;

            //count of all patient
            $query2 = "SELECT COUNT(PatientID) as [RowCount] from TblPatient";
            $stmt2 =$this->mssql_connect()->prepare($query2);
            $stmt2->execute();
            $count_rows = $stmt2->fetch();

            //pagination
            $total_pages = ceil($count_rows['RowCount']/$limit);

            $display .= '
                <div class="flex flex-row mb-5 items-start justify-start bg-gray-800>"
                <ul class="flex -space-x-px list-none list-inside">';
            
                if($page > 0){
                    $prev = $page - 1;

                    $display .= '<li class="list-none rounded-l-lg page-item px-3 py-2 leading-tight text-white bg-blue-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" id="1"><span class="page-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M15 6l-6 6l6 6"></path>
                    </svg></span></li>';
                }

                for($i=1;$i<=$total_pages;$i++){
                    $active_class = "";
                    if($i == $page){
                        $active_class = "active";
                    }
                    $display .= '
                    <li class="text-center text-[20px] list-none page-item '.$active_class.' w-16 h-12 px-3 py-2 leading-tight text-white bg-blue-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" id="'.$i.'"><span class="page-link">'.$i.'</span></li>';
                }
                if($page < $total_pages){
                    $page++;
                    $display .= '<li class="list-none rounded-r-lg page-item px-3 py-2 leading-tight text-white bg-blue-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" id="'.$total_pages.'"><span class="page-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M9 6l6 6l-6 6"></path>
                    </svg></span</li>';
                }
                $display .= '
                </ul>
                </div>';

            $display .= '<div id="print-table-div" class="print-table-div">
                <table class="w-full table-auto bg-white mr-48 mt-5">
                    <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                        <tr class="">
                            <th class="p-2"></th>
                            <th class="p-2">QR Code</th>
                            <th class="p-2">Gender</th>
                            <th class="p-2">Age Group</th>
                            <th class="p-2">Patient Number(From Bizbox)</th>
                            <th class="p-2">Patient Name</th>
                            <th class="p-2">Created By</th>
                            <th class="p-2">Created Date</th>
                            <th class="p-2">Updated By</th>
                            <th class="p-2">Updated Date</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                    <tbody>';
            if($row){
                do{
                    $display .= '<tr class="align-top border bottom-px text-third bg-white">
                            <td class="p-2 text-center">'.++$counter.'</td>
                            <td class="p-2 text-center">'.$row['QRCode'].'</td>
                            <td class="p-2 text-center">'.$row['PatientSex'].'</td>
                            <td class="p-2 text-center">'.$row['PatientAgeGroup'].'</td>
                            <td class="p-2 text-center">'.$row['PatientNumber'].'</td>
                            <td class="p-2 text-center">'.$row['PatientName'].'</td>
                            <td class="p-2 text-center">'.$row['CreatedBy'].'</td>
                            <td class="p-2 text-center">'.$row['CreatedDate'].'</td>
                            <td class="p-2 text-center">'.$row['UpdatedBy'].'</td>
                            <td class="p-2 text-center">'.$row['UpdateDate'].'</td>
                            <td class="text-center">
                                <div class="group">
                                    <button 
                                        id="btn-print-qr" 
                                        data-userid = "'.$row['PatientID'].'" 
                                        class="btn-print-qr hover:bg-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path>
                                        <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                                        <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path>
                                        </svg>
                                    </button>
                                    <span class="hidden absolute text-black group-hover:flex items-center justify-center">Print QR</span>
                                </div>
                            </td>
                        </tr>';
                }while($row = $stmt->fetch());
                $display .= '</tbody>';
            }else{
                $display .= '<tr>
                                <td colspan="11" class="text-center">There is no data available in the table</td>
                            </tr>';
            }
        }else{
            $query = "SELECT  *
            FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY PatientID DESC ) AS RowNum, *
                        FROM      vw_TATPatient WHERE ".$searchFilter." LIKE '".$searchVal."'
                    ) AS RowConstrainedResult
            WHERE   RowNum >= '".$start_from."'
                AND RowNum <= '".$max."'
            ORDER BY RowNum";
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch();
            $counter = 0;

           if($row){
             //count of all patient based on search
             $query2 = "SELECT  COUNT(*) as [RowCount]
             FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY PatientID DESC ) AS RowNum, *
                         FROM      vw_TATPatient WHERE ".$searchFilter." LIKE '".$searchVal."'
                     ) AS RowConstrainedResult
             WHERE   RowNum >= ".$start_from."
                 AND RowNum <= ".$max."";
             $stmt2 =$this->mssql_connect()->prepare($query2);
             $stmt2->execute();
             $count_rows = $stmt2->fetch();
 
 
             //pagination
             $total_pages = ceil($count_rows['RowCount']/$limit);
 
             $display .= '
                 <div class="flex flex-row mb-5 items-start justify-start bg-gray-800>"
                 <ul class="flex -space-x-px list-none list-inside">';
             
                 if($page > 0){
                     $prev = $page - 1;
 
                     $display .= '<li class="list-none rounded-l-lg page-item px-3 py-2 leading-tight text-white bg-blue-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" id="1"><span class="page-link">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                     <path d="M15 6l-6 6l6 6"></path>
                     </svg></span></li>';
                 }
 
                 for($i=1;$i<=$total_pages;$i++){
                     $active_class = "";
                     if($i == $page){
                         $active_class = "active";
                     }
                     $display .= '
                     <li class="text-center text-[20px] list-none page-item '.$active_class.' w-16 h-12 px-3 py-2 leading-tight text-white bg-blue-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" id="'.$i.'"><span class="page-link">'.$i.'</span></li>';
                 }
                 if($page < $total_pages){
                     $page++;
                     $display .= '<li class="list-none rounded-r-lg page-item px-3 py-2 leading-tight text-white bg-blue-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" id="'.$total_pages.'"><span class="page-link">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                     <path d="M9 6l6 6l-6 6"></path>
                     </svg></span</li>';
                 }
                 $display .= '
                 </ul>
                 </div>';
 
             $display .= '<div id="print-table-div" class="print-table-div">
                 <table class="w-full table-auto bg-white mr-48 mt-5">
                     <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                         <tr class="">
                             <th class="p-2"></th>
                             <th class="p-2">QR Code</th>
                             <th class="p-2">Gender</th>
                             <th class="p-2">Age Group</th>
                             <th class="p-2">Patient Number(From Bizbox)</th>
                             <th class="p-2">Patient Name</th>
                             <th class="p-2">Created By</th>
                             <th class="p-2">Created Date</th>
                             <th class="p-2">Updated By</th>
                             <th class="p-2">Updated Date</th>
                             <th class="">Action</th>
                         </tr>
                     </thead>
                     <tbody>';
             if($row){
                 do{
                     $display .= '<tr class="align-top border bottom-px text-third bg-white">
                             <td class="p-2 text-center">'.++$counter.'</td>
                             <td class="p-2 text-center">'.$row['QRCode'].'</td>
                             <td class="p-2 text-center">'.$row['PatientSex'].'</td>
                             <td class="p-2 text-center">'.$row['PatientAgeGroup'].'</td>
                             <td class="p-2 text-center">'.$row['PatientNumber'].'</td>
                             <td class="p-2 text-center">'.$row['PatientName'].'</td>
                             <td class="p-2 text-center">'.$row['CreatedBy'].'</td>
                             <td class="p-2 text-center">'.$row['CreatedDate'].'</td>
                             <td class="p-2 text-center">'.$row['UpdatedBy'].'</td>
                             <td class="p-2 text-center">'.$row['UpdateDate'].'</td>
                             <td class="text-center ">
                                 <div class="group">
                                    <button 
                                        id="btn-print-qr" 
                                        data-userid = "'.$row['PatientID'].'" 
                                        class="btn-print-qr hover:bg-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path>
                                        <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                                        <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path>
                                        </svg>
                                    </button>
                                    <span class="hidden absolute text-black group-hover:flex items-center justify-center">Print QR</span>
                                </div>
                             </td>
                         </tr>';
                 }while($row = $stmt->fetch());
 
                 $display .= '</tbody>';
             }else{
                $display .= '<tr>
                                <td colspan="11" class="text-center">There is no data available in the table</td>
                            </tr>';
             }
           }else{
            $display .= '<div id="print-table-div" class="print-table-div">
                 <table class="w-full table-auto bg-white mr-48 mt-5">
                     <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                         <tr class="">
                             <th class="p-2"></th>
                             <th class="p-2">QR Code</th>
                             <th class="p-2">Gender</th>
                             <th class="p-2">Age Group</th>
                             <th class="p-2">Patient Number(From Bizbox)</th>
                             <th class="p-2">Patient Name</th>
                             <th class="p-2">Created By</th>
                             <th class="p-2">Created Date</th>
                             <th class="p-2">Updated By</th>
                             <th class="p-2">Updated Date</th>
                             <th class="p-2">Action</th>
                         </tr>
                     </thead>
                     <tbody>';
                     $display .= '</tbody>';
                     $display .= '<tr>
                                    <td colspan="11" class="text-center">There is no data available in the table</td>
                                </tr>';
           }
        }

        $display .= '</table>
        </div>';

        
        echo $display;

    }

    public function PatientDataTable(){
 
        $display = ""; 
        $query = "SELECT  * FROM vw_TATPatient ORDER BY CreatedDateTime DESC"; 
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $counter = 0;
        
        $display .= '<div id="print-table-div" class="print-table-div">
            <table class="w-full table-auto bg-white mr-48 mt-5" id="patient-dataTable">
                <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                    <tr class="">
                        <th class="p-2"></th>
                        <th class="p-2">QR Code</th>
                        <th class="p-2">Gender</th>
                        <th class="p-2">Age Group</th>
                        <th class="p-2">Patient Number(From Bizbox)</th>
                        <th class="p-2">Patient Name</th>
                        <th class="p-2">Created By</th>
                        <th class="p-2">Created Date</th>
                        <th class="p-2">Updated By</th>
                        <th class="p-2">Updated Date</th>
                        <th class="">Action</th>
                    </tr>
                </thead>
                <tbody>';
        if($row){
            do{
                $display .= '<tr class="align-top border bottom-px text-third bg-white">
                        <td class="p-2 text-center">'.++$counter.'</td>
                        <td class="p-2 text-center">'.$row['QRCode'].'</td>
                        <td class="p-2 text-center">'.$row['PatientSex'].'</td>
                        <td class="p-2 text-center">'.$row['PatientAgeGroup'].'</td>
                        <td class="p-2 text-center">'.$row['PatientNumber'].'</td>
                        <td class="p-2 text-center">'.$row['PatientName'].'</td>
                        <td class="p-2 text-center">'.$row['CreatedBy'].'</td>
                        <td class="p-2 text-center">'.$row['CreatedDate'].'</td>
                        <td class="p-2 text-center">'.$row['UpdatedBy'].'</td>
                        <td class="p-2 text-center">'.$row['UpdateDate'].'</td>
                        <td class="text-center">
                            <div class="group">
                                <button 
                                    id="btn-print-qr" 
                                    data-userid = "'.$row['PatientID'].'" 
                                    class="btn-print-qr hover:bg-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path>
                                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                                    <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path>
                                    </svg>
                                </button>
                                <span class="hidden absolute text-black group-hover:flex items-center justify-center">Print QR</span>
                            </div>
                        </td>
                    </tr>';
            }while($row = $stmt->fetch());
            $display .= '</tbody>';
           }

        $display .= '</table>
        </div>';
        echo $display;

    }
}   