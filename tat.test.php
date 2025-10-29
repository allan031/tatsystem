<?php
    session_start();
    include_once dirname(__DIR__,1).'/tatsystem/header.php';
    include_once dirname(__DIR__,1).'/tatsystem/class/qrCodeGen.class.php';
    include_once dirname(__DIR__,1).'/tatsystem/class/test.class.php';
    $transaction = new Transaction();
?>



<?php include_once dirname(__DIR__,1).'/tatsystem/sidebar.php';?>
<main class="flex grow p-5 mt-24 ml-[300px]">
    <div class="w-full">
        <p class="text-white text-3xl font-bold mb-4 text-left">TAT Summary</p>
        <hr class="h-px my-4 bg-white border-0">
        <div class="flex flex-row items-end justify-end mb-3 w-full">
            <div>
                <select name="filterColumn" id="filterColumn" class="h-12 w-32 rounded-md border-2 border-third">
                    <option value="">Select filter</option>
                    <option value="PatientNumber">Patient Number</option>
                    <option value="TransactionType">Transaction Type</option>
                    <option value="[Procedure]">Procedure</option>
                </select>
                <input type="text" name="search" id="search" placeholder="Search based on filter..." class="border-third border-2 h-12 w-96 rounded-md indent-3 italic">
                <button type="submit" id="btn-submit" name="btn-submit" class="bg-blue-500 border-2 border-third h-12 w-20 rounded-md hover:bg-blue-300 text-white">Search</button>
                <button type="submit" id="btn-export-tat" name="btn-export-tat" class="btn-export-tat bg-blue-500 border-2 border-third h-12 w-20 rounded-md hover:bg-blue-300 text-white">Export</button>
            </div>
        </div>
        <div id="page-item-count" class=""></div>
        <div id="searchresult">

        </div> 
    </div>
</main>
</div>
<?php include_once dirname(__DIR__,1).'/tatsystem/footer.php';?>
<script type="text/javascript" src="/tatsystem/assets/js/test.js" defer></script>
