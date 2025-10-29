<?php
include_once '../phpqrcode/qrlib.php';
include_once dirname(__DIR__,1).'/class/patient.class.php';

$patient = new Patient();
$patient_js = json_decode($_POST['data']);

if($patient_js->{'Action'} == 'SearchPat'){
    $pageVal = $patient_js->{'pageVal'};
    $searchVal = $patient_js->{'searchVal'};
    $searchFilter = $patient_js->{'searchFilter'};
    // $searchVal = preg_replace('/\s/', '%%',$searchVal);
    $searchVal = '%'.$searchVal.'%';

    $patient->SearchPatientList($searchFilter,$searchVal,$pageVal);
}
if($patient_js->{'Action'} == 'EditPatxDetails'){
    $id = $patient_js->{'id'};
    $fname = $patient_js->{'fname'};
    $mname = $patient_js->{'mname'};
    $lname = $patient_js->{'lname'};
    $bDay = $patient_js->{'bDay'};
    $patID_FK = $patient_js->{'patID_FK'};
    $updatedBy = $patient_js->{'updateBy'};
    $updateDate = $patient_js->{'updateDate'};

    $patient->EditPatientDetails($id,$patID_FK,$fname,$mname,$lname,$bDay,$updatedBy,$updateDate);

}if($patient_js->{'Action'} == 'Generate'){
    //get qr code
    $testArray = array();
    $path = '../assets/images/';
    $patID = $patient_js->{'patID'};
    $qrcode = $path.$patID.".png";
    //QRCode :: png($patID, $qrcode, 'H',4,4);

    array_push($testArray,$patID);
    array_push($testArray,$qrcode);
    echo json_encode([
        'id'=> $testArray[0],
        'qrcode'=>$testArray[1],
    ]);
}
if($patient_js->{'Action'} == 'SearchPatxList'){
    $patxQrCode = $patient_js->{'input'};
    $patient->SearchPatxList($patxQrCode);
}
if($patient_js->{'Action'} == 'GetPatient'){
    $patxID = $patient_js->{'id'};

    $patient->GetPatxDetails($patxID); 
}
if($patient_js->{'Action'} == 'Load'){
    $pageVal = $patient_js->{'pageVal'};
    $searchVal = $patient_js->{'searchVal'};
    $searchFilter = $patient_js->{'searchFilter'};
    // $searchVal = preg_replace('/\s/', '%%',$searchVal);
    $searchVal = '%'.$searchVal.'%';

    $patient->PaginationTableWithSearch($searchFilter,$searchVal,$pageVal);
}if($patient_js->{'Action'} == 'DisplayPatientListAll'){
    $patient->SearchPatxList();
}