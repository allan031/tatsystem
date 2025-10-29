<?php

include_once './phpqrcode/qrlib.php';
include_once './class/qrCodeGen.class.php';
 
$qrcodeGen = new QrCodeGeneration();
 
$qrcode_js = json_decode($_POST['data']);

if($qrcode_js->{'Action'} == 'Generate'){
    //generate qr code
    $testArray = array();
    $path = './assets/images/';
    $patID = $qrcode_js->{'patID'};
    $qrcode = $path.$patID.".png";
    $sex = $qrcode_js->{'sex'}; 
    $ageGroup = $qrcode_js->{'ageGroup'};
    QRCode :: png($patID, $qrcode, 'H',4,4);

    //try
    array_push($testArray,$patID);
    array_push($testArray,$qrcode);
    array_push($testArray,$sex);
    array_push($testArray,$ageGroup);
    echo json_encode([
        'id'=> $testArray[0],
        'qrcode'=>$testArray[1],
        'sex'=>$testArray[2],
        'ageGroup'=>$testArray[3]
    ]);
}if($qrcode_js->{'Action'} == 'InsertQR'){
    //INSERT TO DB
    $patID = $qrcode_js->{'patID'};
    $sex = $qrcode_js->{'sex'};
    $ageGroup = $qrcode_js->{'ageGroup'};
    $createdBy = $qrcode_js->{'createdBy'};
    $createdDate = $qrcode_js->{'createdDate'};
 
    $qrcodeGen->InsertQR($patID,$patID,$sex,$ageGroup,$createdBy,$createdDate); 
}
if($qrcode_js->{'Action'} == 'InsertQrTat'){
    //INSERT TO DB
    $patID = $qrcode_js->{'patID'};
    $deptD = $qrcode_js->{'deptD'};
    //$tranTypeID = $qrcode_js->{'tranTypeID'};
    $procTypeID = $qrcode_js->{'procTypeID'};
    $subprocTypeID = $qrcode_js->{'subprocTypeID'};
    $procedure = $qrcode_js->{'procedure'};
    $scanDate = $qrcode_js->{'scanDate'};
    $tranxTiming = $qrcode_js->{'tranxTiming'};
    $remarks = $qrcode_js->{'remarks'};
    $createdBy = $qrcode_js->{'createdBy'};
    $createdDate = $qrcode_js->{'createdDate'};
    $procTypeID = $qrcode_js->{'procTypeID'};

    $qrcodeGen->InsertTAT($patID,$deptD,$procTypeID,$subprocTypeID,
    $procedure,$scanDate,$tranxTiming,$remarks,$createdBy,$createdDate); 
}
if($qrcode_js->{'Action'} == 'GetProcedure'){
    $procTypeID = $qrcode_js->{'procTypeID'};

    $qrcodeGen->GetProcedure($procTypeID);
}
if($qrcode_js->{'Action'} == 'GetDept'){
    $deptID = $qrcode_js->{'deptID'};
    $qrcodeGen->GetDept($deptID);
}



?>