<?php
include_once dirname(__DIR__,1).'/class/registration.class.php';

$registration = new Registration();
$registration_js = json_decode($_POST['data']);

if($registration_js->{'Action'} == 'AddUser'){ 
    $firstname = $registration_js->{'firstname'};
    $middlename = $registration_js->{'middlename'};
    $lastname = $registration_js->{'lastname'};
    $department = $registration_js->{'department'};
    $birthDate = $registration_js->{'birthdate'};
    $emailAdd = $registration_js->{'emailAddress'};
    $username = $registration_js->{'username'};
    $createdDate = $registration_js->{'createdDate'};
    $platform = $registration_js->{'Utype'};
    $AccType = $registration_js->{'AcctType'};
    // $Ttype = $registration_js->{'Ttype'};
    $createdBy = $registration_js->{'createdBy'};
    $IsAccess = $registration_js->{'AccAccess'};


    $registration->CreateTblUser($username,$username,$firstname,$middlename,$lastname,
    $birthDate,$emailAdd,$department,$createdBy,$createdDate,$platform,$AccType,$IsAccess);

}if($registration_js->{'Action'} == 'ResetPassword'){
    $userid = $registration_js->{'userid'};

    $registration->ResetPassword($userid);

}if($registration_js->{'Action'} == 'DeleteUser'){
    $userID = $registration_js->{'userid'};

    $registration->DeleteUser($userID);
}if($registration_js->{'Action'} == 'GetUser'){
    $userID = $registration_js->{'id'};

    $registration->GetUsers($userID);
}
if($registration_js->{'Action'} == 'EditUser'){
    $userID = $registration_js->{'id'};
    $firstname = $registration_js->{'firstname'};
    $middlename = $registration_js->{'middlename'};
    $lastname = $registration_js->{'lastname'};
    $department = $registration_js->{'department'};
    $birthDate = $registration_js->{'birthdate'};
    $emailAdd = $registration_js->{'emailAddress'};
    $updateBy = $registration_js->{'updateBy'};
    $updateDate = $registration_js->{'updatedDate'};
    $platform = $registration_js->{'Utype'};
    $AccType = $registration_js->{'AcctType'};
    $IsAccess = $registration_js->{'isAccess'};

    $registration->EditUser($firstname,$middlename,$lastname,$department,
    $birthDate,$emailAdd,$updateBy,$updateDate,$platform,$AccType,$userID,$IsAccess);
}if($registration_js->{'Action'} == 'Load'){
    $registration->PaginationTableWithSearchRegisteredUser();
}
