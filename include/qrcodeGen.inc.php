<?php
include_once dirname(__DIR__,1).'/class/qrCodeGen.class.php';  

$qrcodeGen = new QrCodeGeneration();
//$qrcodeGen2 = new QrCodeGeneration2();

$qrcodeGen_js = json_decode($_POST['data']);

if($qrcodeGen_js->{'Action'} == 'InsertQR'){
    $patID = $qrcodeGen_js->{'patID'};
    $qr_label = $qrcodeGen_js->{'qr_label'};
    $qr_lname = $qrcodeGen_js->{'lastname'};
    $qr_fname = $qrcodeGen_js->{'firstname'};
    $qr_mname = $qrcodeGen_js->{'middlename'};
    $qr_cnum = $qrcodeGen_js->{'contactNo'};
    $createdBy = $qrcodeGen_js->{'Admin'};

    $qrcodeGen->InsertQR($patID,$qr_label,$qr_lname,$qr_fname,$qr_mname,$qr_cnum,$createdBy); 
}if($qrcodeGen_js->{'Action'} == 'GetSubProcedureType'){
    $subProcTypeID = $qrcodeGen_js->{'subProcTypeID'};
    $deptID = $qrcodeGen_js->{'deptID'};

    $qrcodeGen->GetSubProcedureType($subProcTypeID,$deptID);
}if($qrcodeGen_js->{'Action'} == 'GetProcedure'){
    $subname = $qrcodeGen_js->{'subname'};

    $qrcodeGen->GetLabProcedures($subname);
}if($qrcodeGen_js->{'Action'} == 'GetProcedureImaging'){
    $procTypeID = $qrcodeGen_js->{'procTypeID'};

    $qrcodeGen->GetProcedure($procTypeID);
}if($qrcodeGen_js->{'Action'} == 'GetAllTranxStart'){ 
    $deptID = $qrcodeGen_js->{'deptID'};
    $userID = $qrcodeGen_js->{'userID'};

    $qrcodeGen->GetStartProcess($deptID,$userID);
}if($qrcodeGen_js->{'Action'} == 'Exceed'){
    $tranxID = $qrcodeGen_js->{'tranxID'};
    $createdBy = $qrcodeGen_js->{'createdBy'};
    $createdDate = $qrcodeGen_js->{'createdDate'};

    $qrcodeGen->InsertExceedTAT($tranxID,$createdBy,$createdDate); 
}if($qrcodeGen_js->{'Action'} == 'GetExceedProcess'){
    $qr = $qrcodeGen_js->{'qr'};
    //$tranxID = $qrcodeGen_js->{'tranxID'};
    $procID = $qrcodeGen_js->{'procID'};
    $subProcID = $qrcodeGen_js->{'subProcID'};

    $qrcodeGen->GetExceedProcess($qr,$procID,$subProcID);
}if($qrcodeGen_js->{'Action'} == 'UpdateExceedTAT'){
    $tranxID = $qrcodeGen_js->{'tranxID'};
    $updatedBy = $qrcodeGen_js->{'updatedBy'};
    $updatedDate = $qrcodeGen_js->{'updatedDate'};

    $qrcodeGen->UpdateTAT($tranxID,$updatedBy,$updatedDate);
}if($qrcodeGen_js->{'Action'} == 'CountNotifs'){
    $deptID = $qrcodeGen_js->{'deptID'};
    $userID = $qrcodeGen_js->{'userID'};
    $qrcodeGen->ExceedTATCount($deptID,$userID);
}if($qrcodeGen_js->{'Action'} == 'GetNotifications'){
    $deptID = $qrcodeGen_js->{'deptID'};
    $userID = $qrcodeGen_js->{'UserID'};
    $qrcodeGen->GetNotifications($deptID,$userID);
}
