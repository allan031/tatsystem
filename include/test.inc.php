<?php
include_once dirname(__DIR__,1).'../class/test.class.php';

$test = new Test();
$test2 = new Test2();
$test_js = json_decode($_POST['data']);

if($test_js->{'Action'} == 'LoadProcedures'){
    $type = $test_js->{'type'};
    $test->GetLabProcedures($type);
}if($test_js->{'Action'} == 'GetSubProcedureType'){
    $subProcTypeID = $test_js->{'subProcTypeID'};

    $test2->GetSubProcedureType($subProcTypeID);
}



?>