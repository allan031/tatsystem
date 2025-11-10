<?php

include_once dirname(__DIR__, 1) . '/class/dbconn.class.php';

class Transaction extends DBConnection
{
    public function ViewTransation()
    {
        $query = "Select * 
            from vw_TATtransaction
            ORDER BY CreatedDate DESC";
        $stmt = $this->mssql_connect()->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $counter = 0;
        echo '<table class="w-full h-auto table-auto bg-white mr-48" id="patient-all-data">
                    <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                        <tr class="">
                            <th class="p-2"></th>
                            <th class="p-2">Created Date</th>
                            <th class="p-2">Patient Number</th>
                            <th class="p-2">Department</th>
                            <th class="p-2">Procedure Type</th>
                            <th class="p-2">Sub Procedure Type</th>
                            <th class="p-2">Time Start</th>
                            <th class="p-2">Time End</th>
                            <th class="p-2">Duration</th>
                            <th class="p-2">Remarks</th>
                            <th class="p-2">Created By</th>
                        </tr>
                    </thead>
                    <tbody>';
        if ($row) {
            do {
                echo '<tr class="align-top border bottom-px text-third bg-white">
                            <td class="p-2 text-center">' . ++$counter . '</td>
                            <td class="p-2 text-center">' . $row['CreatedDate'] . '</td>
                            <td class="p-2 text-center">' . $row['PatientNumber'] . '</td>
                            <td class="p-2 text-center">' . $row['Department'] . '</td>
                            <td class="p-2 text-center">' . $row['ProcedureType'] . '</td>
                            <td class="p-2 text-center">' . $row['SubProcedureType'] . '</td>
                            <td class="p-2 text-center">' . $row['Start'] . '</td>
                            <td class="p-2 text-center">' . $row['End'] . '</td>
                            <td class="p-2 text-center">' . $row['Sub Total'] . '</td>
                            <td class="p-2 text-center">' . $row['Remarks'] . '</td>
                            <td class="p-2 text-center">' . $row['FullName'] . '</td>
                        </tr>';
            } while ($row = $stmt->fetch());

            echo '</tbody>
            </table>';
        }
    }
    //for mobile
    public function ViewTransationMobile($dept)
    {
        $query = "Select TransactionID,QRCode,EmpDepartment,TranxType, 
        TransactionTime,TransactionTiming,CreatedBy,ProcedureType 
        from vw_TATTransactions where DepartmentID = '" . $dept . "' ORDER BY CONVERT(DATE,TransactionTime) DESC";
        $stmt = $this->mssql_connect()->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $counter = 0;
        if ($row) {
            echo '<table class=" bg-white xs:w-full sm:w-full md:w-full xs:text-[9px] sm:text-[9px]" id="patient-history-datatable">
                    <thead class=" text-md font-semibold text-black bg-white uppercase border bottom-px">
                        <tr class="">
                            <th class="">QR Code</th>
                            <th class="">Procedure Type</th>
                            <th class="">Scan Date</th>
                            <th class="">Transaction Timing</th>
                            <th class="">Created By</th>

                        </tr>
                    </thead>
                    <tbody>';
            do {
                echo '<tr class="align-top border bottom-px text-black bg-white">
                        <td class="text-center">' . $row['QRCode'] . '</td>
                        <td class="text-center">' . $row['ProcedureType'] . '</td>
                        <td class="text-center">' . $row['TransactionTime'] . '</td>
                        <td class="text-center">' . $row['TransactionTiming'] . '</td>
                        <td class="text-center">' . $row['CreatedBy'] . '</td>
                    </tr>';
            } while ($row = $stmt->fetch());

            echo '</tbody>
        </table>';
        }
    }

    public function testDataTable()
    { // patient history{ 
        $display = '';
        $counter = 0;

        $query = "Select * from vw_TATtransaction order by convert(date,[Start]) DESC";
        $stmt = $this->mssql_connect()->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();

        echo '
        <table class="w-full table-auto bg-white mr-48" id="table-patient-history">
            <thead class="w-full text-md font-semibold text-[14px] text-third bg-white uppercase border bottom-px">
                <tr class="">
                    <th class="p-2"></th>
                    <th class="p-2">Created Date</th>
                    <th class="p-2">Patient Number</th>
                    <th class="p-2">Patient</th>
                    <th class="p-2">Department</th>
                    <th class="p-2">Procedure Type</th>
                    <th class="p-2">Sub Procedure Type</th>
                    <th class="p-2">Time Start</th>
                    <th class="p-2">Time End</th>
                    <th class="p-2">Duration</th>
                    <th class="p-2">Remarks</th>
                    <th class="p-2">Created By</th>
                </tr>
            </thead>
        <tbody>';
        if ($row) {
            do {
                echo '<tr class="align-top border bottom-px text-third bg-white">
                   <td class="p-2 text-center">' . ++$counter . '</td>
                   <td class="p-2 text-center">' . $row['CreatedDate'] . '</td>
                   <td class="p-2 text-center">' . $row['PatientNumber'] . '</td>
                   <td class="p-2 text-center">' . $row['Patient'] . '</td>
                   <td class="p-2 text-center">' . $row['Department'] . '</td>
                   <td class="p-2 text-center">' . $row['ProcedureType'] . '</td>
                   <td class="p-2 text-center">' . $row['SubProcedureType'] . '</td>
                   <td class="p-2 text-center">' . $row['Start'] . '</td>
                   <td class="p-2 text-center">' . $row['End'] . '</td>
                   <td class="p-2 text-center">' . $row['Sub Total'] . '</td>
                   <td class="p-2 text-center">' . $row['Remarks'] . '</td>
                   <td class="p-2 text-center">' . $row['FullName'] . '</td>
            </tr>';
            } while ($row = $stmt->fetch());

            echo '</tbody>';
        }
        echo '</table>';
    }


    public function testDataTable_filter($from, $to)
    { // patient history export function

        $query = "Select * from vw_TATtransaction where convert(date,[Start]) between :from AND :to order by convert(date,[Start]) DESC";
        $param = array(':from' => $from, ':to' => $to);
        $stmt = $this->mssql_connect()->prepare($query);
        $stmt->execute($param);
        $row = $stmt->fetch();

        $resultArr = array();
        array_push($resultArr, array(
            '<b>Created Date</b>',
            '<b>Patient Number</b>',
            '<b>Patient</b>',
            '<b>Department</b>',
            '<b>Procedure Type</b>',
            '<b>Sub Procedure Type</b>',
            '<b>Time Start</b>',
            '<b>Time End</b>',
            '<b>Duration</b>',
            '<b>Remarks</b>',
            '<b>Created By</b>'
        ));
        if ($row) {
            do {
                array_push($resultArr, array(
                    'CreatedDate' => $row['CreatedDate'],
                    'PatientNumber' => $row['PatientNumber'],
                    'Patient' => $row['Patient'],
                    'Department' => $row['Department'],
                    'ProcedureType' => $row['ProcedureType'],
                    'SubProcedureType' => $row['SubProcedureType'],
                    'Start' => $row['Start'],
                    'End' => $row['End'],
                    'Sub' => $row['Sub Total'],
                    'Remarks' => $row['Remarks'],
                    'FullName' => $row['FullName']
                ));
            } while ($row = $stmt->fetch());
        }

        return $resultArr;
    }

    public function TATSumExport($from, $to)
    {
        $query = "Select
            convert(date,CreatedDate) as [CreatedDate],
            PatientNumber,
            HIS_ID,
            FullName,
            Triage,
            Registration,
            DoctorsOrder,
            CarryOut,
            PaymentSettlement,
            ReadyToTransfer,
            TransferToRoom,
            Disposition,
            TotalTAT,
            InitialDiagnosis,
            TriageToClerk_Duration,
            TriageToClerk_ElapsedTime,
            ClerkToDoctorsOrder_Duration,
            ClerkToDoctorsOrder_ElapsedTime,
            DoctorsOrderToCarryOut_Duration,
            DoctorsOrderToCarryOut_ElapsedTime,
            CarryOutToPaymentSettlement_Duration,
            CarryOutToPaymentSettlement_ElapsedTime,
            CarryOutToDisposition_Duration,
            CarryOutToDisposition_ElapsedTime,
            CarryOutToReadyToTransfer_Duration,
            CarryOutToReadyToTransfer_ElapsedTime,
            ReadyToTransferToTransferToRoom_Duration,
            ReadyToTransferToTransferToRoom_ElapsedTime
            from Tbl_TATSummary_ET 
            where convert(date,CreatedDate) between :from AND :to
            order by CreatedDate desc";
        $param = array(':from' => $from, ':to' => $to);
        $stmt = $this->mssql_connect()->prepare($query);
        $stmt->execute($param);
        $row = $stmt->fetch();

        $resultArr = array();
        array_push($resultArr, array(
            '<b>Created Date</b>',
            '<b>Patient Number</b>',
            '<b>Patient No.(HIS)</b>',
            '<b>Patient Name</b>',
            '<b>Triage</b>',
            '<b>Registration</b>',
            '<b>Doctors Order</b>',
            '<b>Carry Out</b>',
            '<b>Payment Settlement</b>',
            '<b>Ready To Transfer</b>',
            '<b>Transfer To Room</b>',
            '<b>Disposition</b>',
            '<b>Total TAT</b>',
            '<b>Initial Diagnosis</b>',
            '<b>TriageToClerk - Duration</b>',
            '<b>TriageToClerk - ElapsedTime</b>',
            '<b>RegistrationToDoctorsOrder - Duration</b>',
            '<b>RegistrationToDoctorsOrder - ElapsedTime</b>',
            '<b>DoctorsOrderToCarryOut - Duration</b>',
            '<b>DoctorsOrderToCarryOut - ElapsedTime</b>',
            '<b>CarryOutToPaymentSettlement - Duration</b>',
            '<b>CarryOutToPaymentSettlement - ElapsedTime</b>',
            '<b>CarryOutToDisposition - Duration</b>',
            '<b>CarryOutToDisposition - ElapsedTime</b>',
            '<b>CarryOutToReadyToTransfer - Duration</b>',
            '<b>CarryOutToReadyToTransfer - ElapsedTime</b>',
            '<b>ReadyToTransferToTransferToRoom - Duration</b>',
            '<b>ReadyToTransferToTransferToRoom - ElapsedTime</b>'
        ));
        if ($row) {
            do {
                array_push($resultArr, array(
                    'CreatedDate' => $row['CreatedDate'],
                    'PatientNumber' => $row['PatientNumber'],
                    'HIS_ID' => $row['HIS_ID'],
                    'FullName' => $row['FullName'],
                    'Triage' => $row['Triage'],
                    'Clerk' => $row['Registration'],
                    'DoctorsOrder' => $row['DoctorsOrder'],
                    'CarryOut' => $row['CarryOut'],
                    'PaymentSettlement' => $row['PaymentSettlement'],
                    'ReadyToTransfer' => $row['ReadyToTransfer'],
                    'TransferToRoom' => $row['TransferToRoom'],
                    'Disposition' => $row['Disposition'],
                    'TotalTAT' => $row['TotalTAT'],
                    'InitialDiagnosis' => $row['InitialDiagnosis'],
                    'TriageToClerk_Duration' => $row['TriageToClerk_Duration'],
                    'TriageToClerk_ElapsedTime' => $row['TriageToClerk_ElapsedTime'],
                    'ClerkToDoctorsOrder_Duration' => $row['ClerkToDoctorsOrder_Duration'],
                    'ClerkToDoctorsOrder_ElapsedTime' => $row['ClerkToDoctorsOrder_ElapsedTime'],
                    'DoctorsOrderToCarryOut_Duration' => $row['DoctorsOrderToCarryOut_Duration'],
                    'DoctorsOrderToCarryOut_ElapsedTime' => $row['DoctorsOrderToCarryOut_ElapsedTime'],
                    'CarryOutToPaymentSettlement_Duration' => $row['CarryOutToPaymentSettlement_Duration'],
                    'CarryOutToPaymentSettlement_ElapsedTime' => $row['CarryOutToPaymentSettlement_ElapsedTime'],
                    'CarryOutToDisposition_Duration' => $row['CarryOutToDisposition_Duration'],
                    'CarryOutToDisposition_ElapsedTime' => $row['CarryOutToDisposition_ElapsedTime'],
                    'CarryOutToReadyToTransfer_Duration' => $row['CarryOutToReadyToTransfer_Duration'],
                    'CarryOutToReadyToTransfer_ElapsedTime' => $row['CarryOutToReadyToTransfer_ElapsedTime'],
                    'ReadyToTransferToTransferToRoom_Duration' => $row['ReadyToTransferToTransferToRoom_Duration'],
                    'ReadyToTransferToTransferToRoom_ElapsedTime' => $row['ReadyToTransferToTransferToRoom_ElapsedTime']
                ));
            } while ($row = $stmt->fetch());
        }

        return $resultArr;
    }

    public function TATSummaryDataTable()
    {
        $display = "";
        $query = "
                    Select
                    convert(date,CreatedDate) as [CreatedDate],
                    PatientNumber,
                    HIS_ID,
                    FullName,
                    Triage,
                    Registration,
                    DoctorsOrder,
                    CarryOut,
                    PaymentSettlement,
                    ReadyToTransfer,
                    TransferToRoom,
                    Disposition,
                    TotalTAT,
                    InitialDiagnosis,
                    TriageToClerk_Duration,
                    TriageToClerk_ElapsedTime,
                    ClerkToDoctorsOrder_Duration,
                    ClerkToDoctorsOrder_ElapsedTime,
                    DoctorsOrderToCarryOut_Duration,
                    DoctorsOrderToCarryOut_ElapsedTime,
                    CarryOutToPaymentSettlement_Duration,
                    CarryOutToPaymentSettlement_ElapsedTime,
                    CarryOutToDisposition_Duration,
                    CarryOutToDisposition_ElapsedTime,
                    CarryOutToReadyToTransfer_Duration,
                    CarryOutToReadyToTransfer_ElapsedTime,
                    ReadyToTransferToTransferToRoom_Duration,
                    ReadyToTransferToTransferToRoom_ElapsedTime
                    from Tbl_TATSummary_ET 
                    order by CreatedDate desc";
        $stmt = $this->mssql_connect()->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $counter = 0;

        $display .= '
            <table class="w-full bg-white mr-48" id="table-TAT">
            <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                <tr class="">
                    <th class="p-2 w-auto"></th>
                    <th class="p-2 w-auto">Created Date</th>
                    <th class="p-2 w-auto">Patient Number</th>
                    <th class="p-2 w-auto">Patient No.(HIS)</th>
                    <th class="p-2 w-auto">Patient Name</th>
                    <th class="p-2 w-auto">Triage</th>
                    <th class="p-2 w-auto">Registration</th>
                    <th class="p-2 w-auto">Doctors Order</th>
                    <th class="p-2 w-auto">Carry Out</th>
                    <th class="p-2 w-auto">Payment Settlement</th>
                    <th class="p-2 w-auto">Ready To Transfer</th>
                    <th class="p-2 w-auto">Transfer To Room</th>
                    <th class="p-2 w-auto">Disposition</th>
                    <th class="p-2 w-auto">Total TAT</th>
                    <th class="p-2 w-auto">Initial Diagnosis</th>
                    <th class="p-2 w-auto">TriageToRegistration - Duration</th>
                    <th class="p-2 w-auto">Triage To Registration - Elapsed Time</th>
                    <th class="p-2 w-auto">RegistrationToDoctorsOrder - Duration</th>
                    <th class="p-2 w-auto">Registration To Doctors Order - Elapsed Time</th>
                    <th class="p-2 w-auto">DoctorsOrderToCarryOut - Duration</th>
                    <th class="p-2 w-auto">Doctors Order To Carry Out - Elapsed Time</th>
                    <th class="p-2 w-auto">CarryOutToPaymentSettlement - Duration</th>
                    <th class="p-2 w-auto">Carry Out To Payment Settlement Elapsed Time</th>
                    <th class="p-2 w-auto">CarryOutToDisposition - Duration</th>
                    <th class="p-2 w-auto">Carry Out To Disposition Elapsed Time</th>
                    <th class="p-2 w-auto">CarryOutToReadyToTransfer - Duration</th>
                    <th class="p-2 w-auto">Carry Out To Ready To Transfer - Elapsed Time</th>
                    <th class="p-2 w-auto">ReadyToTransferToTransferToRoom - Duration</th>
                    <th class="p-2 w-auto">Ready To Transfer To Transfer To Room - Elapsed Time</th>
                </tr>
            </thead>
            <tbody>';
        if ($row) {
            do {
                $display .= '<tr class="align-top border bottom-px text-third bg-white">
                    <td class="p-2 text-center">' . ++$counter . '</td>
                    <td class="p-2 text-center">' . $row['CreatedDate'] . '</td>
                    <td class="p-2 text-center">' . $row['PatientNumber'] . '</td>
                    <td class="p-2 text-center">' . $row['HIS_ID'] . '</td>
                    <td class="p-2 text-center">' . $row['FullName'] . '</td>
                    <td class="p-2 text-center">' . $row['Triage'] . '</td>
                    <td class="p-2 text-center">' . $row['Registration'] . '</td>
                    <td class="p-2 text-center">' . $row['DoctorsOrder'] . '</td>
                    <td class="p-2 text-center">' . $row['CarryOut'] . '</td>
                     <td class="p-2 text-center">' . $row['PaymentSettlement'] . '</td>
                    <td class="p-2 text-center">' . $row['ReadyToTransfer'] . '</td>
                    <td class="p-2 text-center">' . $row['TransferToRoom'] . '</td>
                    <td class="p-2 text-center">' . $row['Disposition'] . '</td>
                    <td class="p-2 text-center">' . $row['TotalTAT'] . '</td>
                    <td class="p-2 text-center">' . $row['InitialDiagnosis'] . '</td>
                    <td class="p-2 text-center">' . $row['TriageToClerk_Duration'] . '</td>
                    <td class="p-2 text-center">' . $row['TriageToClerk_ElapsedTime'] . '</td>
                    <td class="p-2 text-center">' . $row['ClerkToDoctorsOrder_Duration'] . '</td>
                    <td class="p-2 text-center">' . $row['ClerkToDoctorsOrder_ElapsedTime'] . '</td>
                    <td class="p-2 text-center">' . $row['DoctorsOrderToCarryOut_Duration'] . '</td>
                    <td class="p-2 text-center">' . $row['DoctorsOrderToCarryOut_ElapsedTime'] . '</td>
                    <td class="p-2 text-center">' . $row['CarryOutToPaymentSettlement_Duration'] . '</td>
                    <td class="p-2 text-center">' . $row['CarryOutToPaymentSettlement_ElapsedTime'] . '</td>
                    <td class="p-2 text-center">' . $row['CarryOutToDisposition_Duration'] . '</td>
                    <td class="p-2 text-center">' . $row['CarryOutToDisposition_ElapsedTime'] . '</td>
                    <td class="p-2 text-center">' . $row['CarryOutToReadyToTransfer_Duration'] . '</td>
                    <td class="p-2 text-center">' . $row['CarryOutToReadyToTransfer_ElapsedTime'] . '</td>
                    <td class="p-2 text-center">' . $row['ReadyToTransferToTransferToRoom_Duration'] . '</td>
                    <td class="p-2 text-center">' . $row['ReadyToTransferToTransferToRoom_ElapsedTime'] . '</td>
                </tr>';
            } while ($row = $stmt->fetch());

            $display .= '</tbody>';
        }
        $display .= '</table>';
        echo $display;
    }

    public function TATSummaryDataTablev2()
    {
        $display = "";
        $query = "
                    Select 
        EntryDate as [CreatedDate], 
        [HIS_ID] as [PatientNo],
        PatientID,
        a.PatientNumber,
        CONCAT(LEFT(FullName,CHARINDEX(',',FullName)-1),' ',dbo.GetInitials(SUBSTRING(FullName,CHARINDEX(' ',FullName)+1, ( LEN(FullName) - CHARINDEX(' ',FullName)+1) ))) as [PatientName],
        CASE
            WHEN PatientType = 'E' THEN 'ER-OP'
            ELSE PatientType
        END as PatientType,
        AttendingDoctor as AttendingDoctor,
        Specialization,
        Triage,
        Clerk as [Registration],
        [Doctors Order] as DoctorsOrder,
        [Carry Out] as CarryOut,
        [Payment Settlement] as PaymentSettlement,
        [Ready To Transfer] as ReadyToTransfer,
        [Transfer To Room] as TransferToRoom,
        Disposition,
        [Total TAT] as TotalTAT,
        impression as InitialDiagnosis,
        DischargeDiagnosis as [DischargeDiagnosis],
        [TriageToClerk - Duration] as TC_Dur, 
        [Triage To Clerk - Elapsed Time] as TC_ET,
        [TriageToDoctorsOrder - Duration] as TDO_Dur,
        [Triage To Doctors Order - Elapsed Time] as TDO_ET,
        [TriageToCarryOut - Duration] as TCO_Dur,
        [Triage To Carry Out - Elapsed Time] as TCO_ET,
        [TriageToPaymentSettlement - Duration] as TPS_Dur,
        [Triage To Payment Settlement Elapsed Time] as TPS_ET,
        [TriageToDisposition - Duration] as TD_Dur,
        [Triage To Disposition Elapsed Time] as TD_ET,
        [TriageToReadyToTransfer - Duration] as TRT_Dur,
        [Triage To Ready To Transfer - Elapsed Time] as TRT_ET,
        [TriageToTransferToRoom - Duration] as TTR_Dur,
        [Triage To Transfer To Room - Elapsed Time] as TTR_ET
        from Z_vwTATTable_v2 a
        left join Z_vwElapsedTime_v6 b on a.PatientNumber = b.PatientNumber
        where  a.PatientNumber NOT IN ('202405070001', '202412060006', '202412060007')
        and EntryDate = convert(date,GETDATE())
        order by EntryDate desc
        ";
        $stmt = $this->mssql_connect()->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $counter = 0;

        $display .= '
            <table class="w-full bg-white mr-48" id="table-TAT">
            <thead class=" text-md font-semibold text-third bg-white uppercase border bottom-px">
                <tr class="">
                    <th class="p-2 w-auto"></th>
                    <th class="p-2 w-auto">Created Date</th>
                    <th class="p-2 w-auto">PatientNo(HIS)</th>
                    <th class="p-2 w-auto">PatientID(HIS)</th>
                    <th class="p-2 w-auto">Patient Number</th>
                    <th class="p-2 w-auto">Patient Name</th>
                    <th class="p-2 w-auto">Patient Type</th>
                    <th class="p-2 w-auto">Attending Doctor</th>
                    <th class="p-2 w-auto">Specialization</th>
                    <th class="p-2 w-auto">Triage</th>
                    <th class="p-2 w-auto">Registration</th>
                    <th class="p-2 w-auto">Doctors Order</th>
                    <th class="p-2 w-auto">Carry Out</th>
                    <th class="p-2 w-auto">Payment Settlement</th>
                    <th class="p-2 w-auto">Ready To Transfer</th>
                    <th class="p-2 w-auto">Transfer To Room</th>
                    <th class="p-2 w-auto">Disposition</th>
                    <th class="p-2 w-auto">Total TAT</th>
                    <th class="p-2 w-auto">Initial Diagnosis</th>
                    <th class="p-2 w-auto">Discharge Diagnosis</th>
                    <th class="p-2 w-auto">TriageToClerk - Duration</th>
                    <th class="p-2 w-auto">Triage To Clerk - Elapsed Time</th>
                    <th class="p-2 w-auto">TriageToDoctorsOrder - Duration</th>
                    <th class="p-2 w-auto">Triage To Doctors Order - Elapsed Time</th>
                    <th class="p-2 w-auto">TriageToCarryOut - Duration</th>
                    <th class="p-2 w-auto">Triage To Carry Out - Elapsed Time</th>
                    <th class="p-2 w-auto">TriageToPaymentSettlement - Duration</th>
                    <th class="p-2 w-auto">Triage To Payment Settlement Elapsed Time</th>
                    <th class="p-2 w-auto">TriageToDisposition - Duration</th>
                    <th class="p-2 w-auto">Triage To Disposition Elapsed Time</th>
                    <th class="p-2 w-auto">TriageToReadyToTransfer - Duration</th>
                    <th class="p-2 w-auto">Triage To Ready To Transfer - Elapsed Time</th>
                    <th class="p-2 w-auto">TriageToTransferToRoom - Duration</th>
                    <th class="p-2 w-auto">Triage To Transfer To Room - Elapsed Time</th>
                </tr>
            </thead>
            <tbody>';
        if ($row) {
            do {
                $display .= '<tr class="align-top border bottom-px text-third bg-white">
                    <td class="p-2 text-center">' . ++$counter . '</td>
                    <td class="p-2 text-center">' . $row['CreatedDate'] . '</td>
                    <td class="p-2 text-center">' . $row['PatientNo'] . '</td>
                    <td class="p-2 text-center">' . $row['PatientID'] . '</td>
                    <td class="p-2 text-center">' . $row['PatientNumber'] . '</td>
                    <td class="p-2 text-center">' . $row['PatientName'] . '</td>
                    <td class="p-2 text-center">' . $row['PatientType'] . '</td>
                    <td class="p-2 text-center">' . $row['AttendingDoctor'] . '</td>
                    <td class="p-2 text-center">' . $row['Specialization'] . '</td>
                    <td class="p-2 text-center">' . $row['Triage'] . '</td>
                    <td class="p-2 text-center">' . $row['Registration'] . '</td>
                    <td class="p-2 text-center">' . $row['DoctorsOrder'] . '</td>
                    <td class="p-2 text-center">' . $row['CarryOut'] . '</td>
                    <td class="p-2 text-center">' . $row['PaymentSettlement'] . '</td>
                    <td class="p-2 text-center">' . $row['ReadyToTransfer'] . '</td>
                    <td class="p-2 text-center">' . $row['TransferToRoom'] . '</td>
                    <td class="p-2 text-center">' . $row['Disposition'] . '</td>
                    <td class="p-2 text-center">' . $row['TotalTAT'] . '</td>
                    <td class="p-2 text-center">' . $row['InitialDiagnosis'] . '</td>
                    <td class="p-2 text-center">' . $row['DischargeDiagnosis'] . '</td>
                    <td class="p-2 text-center">' . $row['TC_Dur'] . '</td>
                    <td class="p-2 text-center">' . $row['TC_ET'] . '</td>
                    <td class="p-2 text-center">' . $row['TDO_Dur'] . '</td>
                    <td class="p-2 text-center">' . $row['TDO_ET'] . '</td>
                    <td class="p-2 text-center">' . $row['TCO_Dur'] . '</td>
                    <td class="p-2 text-center">' . $row['TCO_ET'] . '</td>
                    <td class="p-2 text-center">' . $row['TPS_Dur'] . '</td>
                    <td class="p-2 text-center">' . $row['TPS_ET'] . '</td>
                    <td class="p-2 text-center">' . $row['TD_Dur'] . '</td>
                    <td class="p-2 text-center">' . $row['TD_ET'] . '</td>
                    <td class="p-2 text-center">' . $row['TRT_Dur'] . '</td>
                    <td class="p-2 text-center">' . $row['TRT_ET'] . '</td>
                    <td class="p-2 text-center">' . $row['TTR_Dur'] . '</td>
                    <td class="p-2 text-center">' . $row['TTR_ET'] . '</td>
                </tr>';
            } while ($row = $stmt->fetch());

            $display .= '</tbody>';
        }
        $display .= '</table>';
        echo $display;
    }


    public function TATDashboard()
    {
        try {
            date_default_timezone_set('Asia/Manila');
            $query = "
                WITH cte_start AS (
                    SELECT
                        t.TransactionID,
                        t.QRCode AS [PatientNumber],
                        t.DepartmentID,
                        t.TransactionTypeID AS [tTypeID],
                        t.ProcedureTypeID,
                        t.SubProcedureTypeID AS [subID],
                        t.[Procedure],
                        t.ScanDate AS [start],
                        t.CreatedBy,
                        t.ScanDate AS [CreatedDate]
                    FROM TblTransaction t
                    WHERE t.TransactionTiming = 'Start'
                ),
                cte_end AS (
                    SELECT
                        e.QRCode,
                        e.TransactionTypeID,
                        e.ProcedureTypeID,
                        e.SubProcedureTypeID,
                        e.[Procedure],
                        e.ScanDate AS [end],
                        e.Remarks
                    FROM TblTransaction e
                    WHERE e.TransactionTiming = 'End'
                ),

                cte_patientid AS (
                    SELECT 
                        QRCode,
                        LTRIM(RTRIM(RIGHT(Remarks, CHARINDEX('/', REVERSE(Remarks)) - 1))) AS ExtractedPatientID
                    FROM TblTransaction
                    WHERE SubProcedureTypeID IN (
                        SELECT ID FROM TblSubProcedureType WHERE SubProcedureType = 'Registration'
                    )
                    AND CHARINDEX('/', Remarks) > 0
                    AND TransactionTiming = 'End'
                )

                SELECT 
                    COALESCE(pid.ExtractedPatientID, a.PatientNumber) AS [PatientNumber], -- ✅ use extracted ID if available

                    p.PatientAgeGroup AS [AgeGroup],
                    d.DepartmentAbbreviation as Department,
                    pt.ProcedureType AS [ProcedureType],
                    CASE 
                        WHEN a.ProcedureTypeID = 9003 AND a.subID = 0 THEN 'Patient Assessment'
                        WHEN a.subID = 0 THEN 'N/A'
                        ELSE spt.SubProcedureType 
                    END AS [SubProcedureType],
                    
                    CONVERT(VARCHAR(19), a.[start], 120) AS [Start],
                    CONVERT(VARCHAR(19), b.[end], 120) AS [End],
                    CONCAT(EmpLastName, ', ', EmpFirstName, ' ', EmpMiddleName) AS [FullName],

                    CASE 
                        WHEN spt.SubProcedureType = 'Registration' THEN b.Remarks
                        ELSE NULL
                    END AS [Remarks],

                    pid.ExtractedPatientID AS [ExtractedRemarks] -- show extracted ID for reference

                FROM cte_start a
                LEFT JOIN cte_end b 
                    ON b.QRCode = a.PatientNumber
                    AND b.SubProcedureTypeID = a.subID
                    AND b.ProcedureTypeID = a.ProcedureTypeID
                    AND a.[Procedure] = b.[Procedure]

                LEFT JOIN dbo.TblDepartment d 
                    ON a.DepartmentID = d.DepartmentID

                LEFT JOIN dbo.TblProcedureType pt 
                    ON a.ProcedureTypeID = pt.ProcedureTypeID

                LEFT JOIN dbo.TblSubProcedureType spt 
                    ON a.SubID = spt.ID

                LEFT JOIN dbo.TblUser u 
                    ON a.CreatedBy = u.UserID

                LEFT JOIN Staging_TAT.dbo.Tbl_PatRegister2 pr
                    ON a.PatientNumber COLLATE DATABASE_DEFAULT = pr.remarks COLLATE DATABASE_DEFAULT

                LEFT JOIN dbo.TblPatient p 
                    ON a.PatientNumber = p.QRCode

                LEFT JOIN cte_patientid pid 
                    ON pid.QRCode = a.PatientNumber

                WHERE CONVERT(date, a.[start]) = CONVERT(date, GETDATE())
                ORDER BY a.[start] DESC;
            ";

            $stmt = $this->mssql_connect()->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            function parseTime($dtStr)
            {
                if (!$dtStr) return null;
                $ts = strtotime(str_replace('-', '/', $dtStr));
                return $ts ?: null;
            }

            $now = time();
            $patients = [];

            foreach ($result as $row) {
                $startTS = parseTime($row['Start']);
                $endTS = parseTime($row['End']);
                $hasEnded = $endTS !== null;

                $elapsed = '';
                if ($startTS) {
                    $diff = $hasEnded ? ($endTS - $startTS) : ($now - $startTS);
                    if ($diff < 0) $diff = 0;
                    $h = floor($diff / 3600);
                    $m = floor(($diff % 3600) / 60);
                    $s = $diff % 60;
                    $elapsed = sprintf('%02d:%02d:%02d', $h, $m, $s);
                }

                // Initialize patient record if not yet present
                if (!isset($patients[$row['PatientNumber']])) {
                    $patients[$row['PatientNumber']] = [
                        'PatientNumber' => $row['PatientNumber'],
                        'AgeGroup' => $row['AgeGroup'],
                        'HasOngoing' => false,  // flag for sorting later
                        'LatestStart' => $startTS ?? 0,
                        'Procedures' => []
                    ];
                }

                // Update latest start time
                if ($startTS && $startTS > $patients[$row['PatientNumber']]['LatestStart']) {
                    $patients[$row['PatientNumber']]['LatestStart'] = $startTS;
                }

                // Detect ongoing procedure
                if (!$endTS) {
                    $patients[$row['PatientNumber']]['HasOngoing'] = true;
                }

                // Append procedure
                $patients[$row['PatientNumber']]['Procedures'][] = [
                    'Department' => $row['Department'],
                    'ProcedureType' => $row['ProcedureType'],
                    'SubProcedureType' => $row['SubProcedureType'],
                    'StartTime' => $startTS ? date('H:i', $startTS) : '—',
                    'EndTime' => $endTS ? date('H:i', $endTS) : null,
                    'StartTS' => $startTS,
                    'EndTS' => $endTS,
                    'HasEnded' => $hasEnded,
                    'Elapsed' => $elapsed,
                    'FullName' => $row['FullName'],
                    'UniqueId' => md5($row['PatientNumber'] . $row['ProcedureType'] . $startTS)
                ];
            }

            // 🔹 Sort patients: ongoing first, then latest start time desc
            usort($patients, function ($a, $b) {
                if ($a['HasOngoing'] === $b['HasOngoing']) {
                    return $b['LatestStart'] <=> $a['LatestStart'];
                }
                return $a['HasOngoing'] ? -1 : 1; // ongoing first
            });

            $response = [
                'serverTime' => $now,
                'data' => array_values($patients)
            ];

            echo json_encode($response);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}