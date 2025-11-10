<?php
include_once dirname(__DIR__, 1) . '/class/transaction.class.php';

$transaction = new Transaction();
$tranx_js = json_decode($_POST['data']);

if ($tranx_js->{'Action'} == 'Search') {
   $searchTxt = $tranx_js->{'searchVal'};
   $searchFilter = $tranx_js->{'searchFilter'};
   $page = $tranx_js->{'pageVal'};
   $searchTxt = '%' . $searchTxt . '%';


   $transaction->TransactionWPagination($searchFilter, $searchTxt, $page);
}
if ($tranx_js->{'Action'} == 'SearchTATSummary') {
   $transaction->TATSummaryDataTable();
}
if ($tranx_js->{'Action'} == 'LoadAllData') {
   $transaction->testDataTable();
}
if ($tranx_js->{'Action'} == 'DisplayAllTATData') {
   $from = $tranx_js->{'from'};
   $to = $tranx_js->{'to'};

   //$transaction->TATAllData($from, $to); 
}
if ($tranx_js->{'Action'} == 'LoadTATDashboard') {
   $transaction->TATDashboard();
}