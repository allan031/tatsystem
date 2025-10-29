<?php
if(isset($_GET['from']) && isset($_GET['to']) && isset($_GET['reportname'])){
    require dirname(__DIR__, 1) . '/tatsystem/class/SimpleXLSXGen.php';
    include_once dirname(__DIR__, 1) . '/tatsystem/class/transaction.class.php';
    include_once dirname(__DIR__, 1) . '/tatsystem/class/patient.class.php';


    $xlsx = new SimpleXLSXGen();
    $transaction = new Transaction();
    $patient = new Patient();

    $resultsArr = array();
    $from = $_GET['from'];
    $to = $_GET['to'];
    $report = $_GET['reportname'];
}

switch($report) {
    case 'Patient History':
        $resultsArr = $transaction->testDataTable_filter($from,$to);
        $reportname = "TAT History";
        break;
    // case 'TAT Summary':
    //     $resultsArr = $transaction->TATSumExport($from,$to); //commented due to error in script 202/11/25 7:31PM
    //     $reportname = "TAT Summary with Elapsed Time";
    //     break;
    case 'Patient Lists':
        $resultsArr = $patient->ExportPL($from,$to);
        $reportname = "Patient Lists";
        break;

}

date_default_timezone_set('Asia/Manila');
$xlsx::fromArray($resultsArr)->downloadAs(trim($reportname).'_'.$from. ' - '.$to.'.xlsx');
?>