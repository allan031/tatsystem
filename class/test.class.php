<?php

include_once dirname(__DIR__,1).'/class/dbconn.class.php'; 

class Transaction extends DBConnection{
    public function ViewTransation(){
        $query = "Select TransactionID,QRCode,EmpDepartment,TranxType,
        [Procedure],TransactionTime,TransactionTiming,CreatedBy 
        from vw_TATTransactions ORDER BY TransactionTime DESC ";
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $counter = 0;
        if($row){
            echo'<table class="w-full h-auto table-auto bg-white mr-48">
                    <thead class=" text-md font-semibold text-third bg-fifth uppercase border bottom-px">
                        <tr class="">
                            <th class="p-2"></th>
                            <th class="p-2">QR Code</th>
                            <th class="p-2">Department</th>
                            <th class="p-2">Transcation Type</th>
                            <th class="p-2">Procedure</th>
                            <th class="p-2">Scan Date</th>
                            <th class="p-2">Transaction Timing</th>
                            <th class="p-2">Created By</th>
                            <th class="p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>';   
            do{
                echo '<tr class="align-top border bottom-px text-third bg-white">
                        <td class="p-2 text-center">'.++$counter.'</td>
                        <td class="p-2 text-center">'.$row['QRCode'].'</td>
                        <td class="p-2 text-center">'.$row['EmpDepartment'].'</td>
                        <td class="p-2 text-center">'.$row['TranxType'].'</td>
                        <td class="p-2 text-center">'.$row['Procedure'].'</td>
                        <td class="p-2 text-center">'.$row['TransactionTime'].'</td>
                        <td class="p-2 text-center">'.$row['TransactionTiming'].'</td>
                        <td class="p-2 text-center">'.$row['CreatedBy'].'</td>
                        
                    </tr>';
            }while($row = $stmt->fetch());

            echo '</tbody>
        </table>';
        }
    }
    //for mobile
    public function ViewTransationMobile(){
        $query = "Select TransactionID,QRCode,EmpDepartment,TranxType,
        [Procedure],TransactionTime,TransactionTiming,CreatedBy,ProcedureType 
        from vw_TATTransactions ORDER BY TransactionTime DESC ";
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $counter = 0;
        if($row){
            echo'<table class=" bg-white xs:w-full sm:w-full xs:text-[9px] sm:text-[9px]">
                    <thead class=" text-md font-semibold text-black bg-fifth uppercase border bottom-px">
                        <tr class="">
                            <th class="">QR Code</th>
                            <th class="">Transcation Type</th>
                            <th class="">Procedure</th>
                            <th class="">Procedure Type</th>
                            <th class="">Scan Date</th>
                            <th class="">Transaction Timing</th>
                            <th class="">Created By</th>

                        </tr>
                    </thead>
                    <tbody>';   
            do{
                echo '<tr class="align-top border bottom-px text-black bg-white">
                        <td class="text-center">'.$row['QRCode'].'</td>
                        <td class="text-center">'.$row['TranxType'].'</td>
                        <td class="text-center">'.$row['Procedure'].'</td>
                        <td class="text-center">'.$row['ProcedureType'].'</td>
                        <td class="text-center">'.$row['TransactionTime'].'</td>
                        <td class="text-center">'.$row['TransactionTiming'].'</td>
                        <td class="text-center">'.$row['CreatedBy'].'</td>
                    </tr>';
            }while($row = $stmt->fetch());

            echo '</tbody>
        </table>';
        }
    }
    
    public function SearchTransaction($qrcode){
        if($qrcode == ""){
            $query = "Select TransactionID,QRCode,EmpDepartment,TranxType,
            [Procedure],TransactionTime,TransactionTiming,CreatedBy 
            from vw_TATTransactions ORDER BY TransactionTime DESC ";
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch();
            $counter = 0;
            if($row){

            echo'<table class="w-full table-auto bg-white mr-48">
                    <thead class=" text-md font-semibold text-third bg-fifth uppercase border bottom-px">
                        <tr class="">
                            <th class="p-2"></th>
                            <th class="p-2">QR Code</th>
                            <th class="p-2">Department</th>
                            <th class="p-2">Transcation Type</th>
                            <th class="p-2">Procedure</th>
                            <th class="p-2">Transaction Time</th>
                            <th class="p-2">Transaction Timing</th>
                            <th class="p-2">Created By</th>
                        </tr>
                    </thead>
                    <tbody>';   
            do{
                echo '<tr class="align-top border bottom-px text-third bg-white">
                        <td class="p-2 text-center">'.++$counter.'</td>
                        <td class="p-2 text-center">'.$row['QRCode'].'</td>
                        <td class="p-2 text-center">'.$row['EmpDepartment'].'</td>
                        <td class="p-2 text-center">'.$row['TranxType'].'</td>
                        <td class="p-2 text-center">'.$row['Procedure'].'</td>
                        <td class="p-2 text-center">'.$row['TransactionTime'].'</td>
                        <td class="p-2 text-center">'.$row['TransactionTiming'].'</td>
                        <td class="p-2 text-center">'.$row['CreatedBy'].'</td>
                        
                    </tr>';
            }while($row = $stmt->fetch());

            echo '</tbody>
        </table>';
        }
    }else{
        $query = "Select TransactionID,QRCode,EmpDepartment,TranxType,
        [Procedure],TransactionTime,TransactionTiming,CreatedBy 
        from vw_TATTransactions WHERE QRCode LIKE '%".$qrcode."%' ORDER BY TransactionTime DESC ";
        $stmt =$this->mssql_connect()->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $counter = 0;
        if($row){

            echo'<table class="w-full table-auto bg-white mr-48">
                    <thead class=" text-md font-semibold text-third bg-fifth uppercase border bottom-px">
                        <tr class="">
                            <th class="p-2"></th>
                            <th class="p-2">QR Code</th>
                            <th class="p-2">Department</th>
                            <th class="p-2">Transcation Type</th>
                            <th class="p-2">Procedure</th>
                            <th class="p-2">Transaction Time</th>
                            <th class="p-2">Transaction Timing</th>
                            <th class="p-2">Created By</th>
                        </tr>
                    </thead>
                    <tbody>';   
            do{
                echo '<tr class="align-top border bottom-px text-third bg-white">
                        <td class="p-2 text-center">'.++$counter.'</td>
                        <td class="p-2 text-center">'.$row['QRCode'].'</td>
                        <td class="p-2 text-center">'.$row['EmpDepartment'].'</td>
                        <td class="p-2 text-center">'.$row['TranxType'].'</td>
                        <td class="p-2 text-center">'.$row['Procedure'].'</td>
                        <td class="p-2 text-center">'.$row['TransactionTime'].'</td>
                        <td class="p-2 text-center">'.$row['TransactionTiming'].'</td>
                        <td class="p-2 text-center">'.$row['CreatedBy'].'</td>
                        
                    </tr>';
            }while($row = $stmt->fetch());

            echo '</tbody>
        </table>';
        }else{
            echo'<table class="w-full table-auto bg-white mr-48">
                    <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                        <tr class="">
                            <th class="p-2">QR Code</th>
                            <th class="p-2">Department</th>
                            <th class="p-2">Transcation Type</th>
                            <th class="p-2">Procedure</th>
                            <th class="p-2">Transaction Time</th>
                            <th class="p-2">Transaction Timing</th>
                            <th class="p-2">Created By</th>
                        </tr>
                    </thead>
                    <tbody>   
                <tr class="align-top border bottom-px text-third bg-white">
                        <td class="p-2 text-center"><h3 class="text-[20px] text-black font-semibold">No data found</h3></td>  
                    </tr>
                    </tbody>';
        }
    }
    
    }

    public function TransactionWPagination($searchFilter,$searchVal,$pageVal){
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
            FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY CreatedDate DESC ) AS RowNum, *
                        FROM      vw_TATTransactions
                    ) AS RowConstrainedResult
            WHERE   (RowNum >= :start_from
                AND RowNum <= :max)
            ORDER BY TransactionID DESC";
            $param = array(':start_from'=>$start_from, ':max'=> $max);
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute($param);
            $row = $stmt->fetch();
            $counter = 0;

            //count of all patient
            $query2 = "SELECT COUNT(TransactionID) as [RowCount] from TblTransaction";
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
            <table class="w-full table-auto bg-white mr-48" id="table-patient-history">
            <thead class=" text-md font-semibold text-third bg-fifth uppercase border bottom-px">
                <tr class="">
                    <th class="p-2"></th>
                    <th class="p-2">QR Code</th>
                    <th class="p-2">Department</th>
                    <th class="p-2">Transcation Type</th>
                    <th class="p-2">Procedure Type</th>
                    <th class="p-2">Sub Procedure Type</th>
                    <th class="p-2">Transaction Time</th>
                    <th class="p-2">Transaction Timing</th>
                    <th class="p-2">Created By</th>
                </tr>
            </thead>
            <tbody>';
            if($count_rows > 0){
                do{
                    $display .= '<tr class="align-top border bottom-px text-third bg-white">
                    <td class="p-2 text-center">'.++$counter.'</td>
                    <td class="p-2 text-center">'.$row['QRCode'].'</td>
                    <td class="p-2 text-center">'.$row['EmpDepartment'].'</td>
                    <td class="p-2 text-center">'.$row['TranxType'].'</td>
                    <td class="p-2 text-center">'.$row['ProcedureType'].'</td>
                    <td class="p-2 text-center">'.$row['SubProcedureType'].'</td>
                    <td class="p-2 text-center">'.$row['TransactionTime'].'</td>
                    <td class="p-2 text-center">'.$row['TransactionTiming'].'</td>
                    <td class="p-2 text-center">'.$row['CreatedBy'].'</td>
                </tr>';
                }while($row = $stmt->fetch());

                $display .= '</tbody>';
            }else{
                $display .= '<tr>
                                <td>There is no data available in the table</td>
                            </tr>';
            }
        }else{
            $query = "SELECT  *
            FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY CreatedDate DESC ) AS RowNum, *
                        FROM      vw_TATTransactions WHERE ".$searchFilter." LIKE '".$searchVal."'
                    ) AS RowConstrainedResult
            WHERE   RowNum >= '".$start_from."'
                AND RowNum <= '".$max."'
            ORDER BY TransactionID DESC";
            //$param = array(':searchFilter'=>$searchFilter,':searchVal'=>$searchVal,':start_from'=>$start_from, ':max'=> $max);
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch();
            $counter = 0;

           if($row){
             //count of all patient based on search
             $query2 = "SELECT  COUNT(*) as [RowCount]
             FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY CreatedDate DESC ) AS RowNum, *
                         FROM      vw_TATTransactions WHERE ".$searchFilter." LIKE '".$searchVal."'
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
 
             $display .= '
             <table class="w-full table-auto bg-white mr-48" id="table-patient-history">
             <thead class=" text-md font-semibold text-third bg-fifth uppercase border bottom-px">
                 <tr class="">
                    <th class="p-2"></th>
                    <th class="p-2">QR Code</th>
                    <th class="p-2">Department</th>
                    <th class="p-2">Transcation Type</th>
                    <th class="p-2">Procedure Type</th>
                    <th class="p-2">Sub Procedure Type</th>
                    <th class="p-2">Transaction Time</th>
                    <th class="p-2">Transaction Timing</th>
                    <th class="p-2">Created By</th>
                 </tr>
             </thead>
             <tbody>';
             if($count_rows > 0){
                 do{
                     $display .= '<tr class="align-top border bottom-px text-third bg-white">
                        <td class="p-2 text-center">'.++$counter.'</td>
                        <td class="p-2 text-center">'.$row['QRCode'].'</td>
                        <td class="p-2 text-center">'.$row['EmpDepartment'].'</td>
                        <td class="p-2 text-center">'.$row['TranxType'].'</td>
                        <td class="p-2 text-center">'.$row['ProcedureType'].'</td>
                        <td class="p-2 text-center">'.$row['SubProcedureType'].'</td>
                        <td class="p-2 text-center">'.$row['TransactionTime'].'</td>
                        <td class="p-2 text-center">'.$row['TransactionTiming'].'</td>
                        <td class="p-2 text-center">'.$row['CreatedBy'].'</td>
                 </tr>';
                 }while($row = $stmt->fetch());
 
                 $display .= '</tbody>';
             }else{
                 $display .= '<tr>
                                 <td>There is no data available in the table</td>
                             </tr>';
             }
           }else{
            $display .= '
            <table class="w-full table-auto bg-white mr-48" id="table-patient-history">
            <thead class=" text-md font-semibold text-third bg-fifth uppercase border bottom-px">
                <tr class="">
                    <th class="p-2"></th>
                    <th class="p-2">QR Code</th>
                    <th class="p-2">Department</th>
                    <th class="p-2">Transcation Type</th>
                    <th class="p-2">Procedure Type</th>
                    <th class="p-2">Sub Procedure Type</th>
                    <th class="p-2">Transaction Time</th>
                    <th class="p-2">Transaction Timing</th>
                    <th class="p-2">Created By</th>
                </tr>
            </thead>
            <tbody>';
                     $display .= '</tbody>';
                     $display .= '
                        <tr>
                            <td class="row-span-11 text-center">There is no data available in the table</td>
                        </tr>';
           }
        }

        $display .= '</table>';

        
        echo $display;
    
    }

    public function TATSummary($searchFilter,$searchVal,$pageVal){
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
            FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY CreatedDate DESC ) AS RowNum, *
                        FROM      vw_TATtransaction
                    ) AS RowConstrainedResult
            WHERE   (RowNum >= :start_from
                AND RowNum <= :max)
            ORDER BY TransactionID DESC";
            $param = array(':start_from'=>$start_from, ':max'=> $max);
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute($param);
            $row = $stmt->fetch();
            $counter = 0;

            //count of all patient
            $query2 = "SELECT COUNT(TransactionID) as [RowCount] from vw_TATtransaction";
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
            <table class="w-full table-auto bg-white mr-48" id="table-TAT">
            <thead class=" text-md font-semibold text-third bg-fifth uppercase border bottom-px">
                <tr class="">
                    <th class="p-2"></th>
                    <th class="p-2">Patient Number</th>
                    <th class="p-2">Department</th>
                    <th class="p-2">Transcation Type</th>
                    <th class="p-2">Procedure Type</th>
                    <th class="p-2">Sub Procedure Type</th>
                    <th class="p-2">Start Time</th>
                    <th class="p-2">End Time</th>
                    <th class="p-2">Turn Around Time</th>
                    <th class="p-2">Created By</th>
                </tr>
            </thead>
            <tbody>';
            if($count_rows > 0){
                do{
                    $display .= '<tr class="align-top border bottom-px text-third bg-white">
                    <td class="p-2 text-center">'.++$counter.'</td>
                    <td class="p-2 text-center">'.$row['PatientNumber'].'</td>
                    <td class="p-2 text-center">'.$row['Department'].'</td>
                    <td class="p-2 text-center">'.$row['TransactionType'].'</td>
                    <td class="p-2 text-center">'.$row['ProcedureType'].'</td>
                    <td class="p-2 text-center">'.$row['SubProcedureType'].'</td>
                    <td class="p-2 text-center">'.$row['Start'].'</td>
                    <td class="p-2 text-center">'.$row['End'].'</td>
                    <td class="p-2 text-center">'.$row['TAT'].'</td>
                    <td class="p-2 text-center">'.$row['FullName'].'</td>
                    
                </tr>';
                }while($row = $stmt->fetch());

                $display .= '</tbody>';
            }else{
                $display .= '<tr>
                                <td>There is no data available in the table</td>
                            </tr>';
            }
        }else{
            $query = "SELECT  *
            FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY CreatedDate DESC ) AS RowNum, *
                        FROM      vw_TATtransaction WHERE ".$searchFilter." LIKE '".$searchVal."'
                    ) AS RowConstrainedResult
            WHERE   RowNum >= '".$start_from."'
                AND RowNum <= '".$max."'
            ORDER BY TransactionID DESC";
            //$param = array(':searchFilter'=>$searchFilter,':searchVal'=>$searchVal,':start_from'=>$start_from, ':max'=> $max);
            $stmt =$this->mssql_connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch();
            $counter = 0;

           if($row){
             //count of all patient based on search
             $query2 = "SELECT  COUNT(*) as [RowCount]
             FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY CreatedDate DESC ) AS RowNum, *
                         FROM      vw_TATtransaction WHERE ".$searchFilter." LIKE '".$searchVal."'
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
 
             $display .= '
             <table class="w-full table-auto bg-white mr-48" id="table-TAT">
             <thead class=" text-md font-semibold text-third bg-fifth uppercase border bottom-px">
                 <tr class="">
                    <th class="p-2"></th>
                    <th class="p-2">Patient Number</th>
                    <th class="p-2">Department</th>
                    <th class="p-2">Transcation Type</th>
                    <th class="p-2">Procedure Type</th>
                    <th class="p-2">Sub Procedure Type</th>
                    <th class="p-2">Start Time</th>
                    <th class="p-2">End Time</th>
                    <th class="p-2">Turn Around Time</th>
                    <th class="p-2">Created By</th>
                 </tr>
             </thead>
             <tbody>';
             if($count_rows > 0){
                 do{
                     $display .= '<tr class="align-top border bottom-px text-third bg-white">
                        <td class="p-2 text-center">'.++$counter.'</td>
                        <td class="p-2 text-center">'.$row['PatientNumber'].'</td>
                        <td class="p-2 text-center">'.$row['Department'].'</td>
                        <td class="p-2 text-center">'.$row['TransactionType'].'</td>
                        <td class="p-2 text-center">'.$row['ProcedureType'].'</td>
                        <td class="p-2 text-center">'.$row['SubProcedureType'].'</td>
                        <td class="p-2 text-center">'.$row['Start'].'</td>
                        <td class="p-2 text-center">'.$row['End'].'</td>
                        <td class="p-2 text-center">'.$row['TAT'].'</td>
                        <td class="p-2 text-center">'.$row['FullName'].'</td>
                 </tr>';
                 }while($row = $stmt->fetch());
 
                 $display .= '</tbody>';
             }else{
                 $display .= '<tr>
                                 <td>There is no data available in the table</td>
                             </tr>';
             }
           }else{
            $display .= '
            <table class="w-full table-auto bg-white mr-48" id="table-TAT">
            <thead class=" text-md font-semibold text-third bg-fifth uppercase border bottom-px">
                <tr class="">
                    <th class="p-2"></th>
                    <th class="p-2">Patient Number</th>
                    <th class="p-2">Department</th>
                    <th class="p-2">Transcation Type</th>
                    <th class="p-2">Procedure Type</th>
                    <th class="p-2">Sub Procedure Type</th>
                    <th class="p-2">Start Time</th>
                    <th class="p-2">End Time</th>
                    <th class="p-2">Turn Around Time</th>
                    <th class="p-2">Created By</th>
                </tr>
            </thead>
            <tbody>';
                     $display .= '</tbody>';
                     $display .= '
                        <tr>
                            <td class="row-span-11 text-center">There is no data available in the table</td>
                        </tr>';
           }
        }

        $display .= '</table>';

        
        echo $display;
    
    }
}