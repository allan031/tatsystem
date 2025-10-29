<?php
    // session_start();
    // if(isset($_SESSION['username'])){

    // }else{
    //     header("refresh:0; url=../login.php");
    // }
    include_once dirname(__DIR__,1).'../header.php';
    include_once dirname(__DIR__,1).'/class/transaction.class.php'; 
    $transaction = new Transaction();
?>

 

<?php include_once dirname(__DIR__,1).'/sidebar.php';?>
<main class="flex grow p-5 mt-24 ml-[300px] cursor-pointer">
    <div class="w-full">
        <div class="flex flex-row justify-between items-center">
        <span class="hidden" id="dept-value"><?php echo $_SESSION['Department'];?></span>
            <p class="text-white text-3xl font-bold mb-4 text-left" id="rpttitle">Patient History</p>
            <div class="relative h-12 w-12">
                <span id="notif-count" class="absolute right-0 rounded-full bg-red-600 text-white text-[10px] p-1 font-bold"></span>
                <button id="btn-notif">
                    <svg class="w-10 h-10 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 20">
                        <path d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z"/>
                    </svg>
                </button>
            </div>
        </div>
        <hr class="h-px my-4 bg-white border-0">
        <div class="flex justify-end mb-2">
            <button type="submit" id="btn-export-tat" name="btn-export-tat" class="btn-export-tat bg-blue-500 border-2 border-third h-8 w-20 rounded-md hover:bg-blue-300 text-white">Export</button>
        </div>
        <div id="normal-table" class="flex flex-col">
            <?php echo $transaction->testDataTable();?>
            <div id="result-table" class="w-full hidden">
            </div> 
        </div>
</main>

<!-- modal notif-->
<div class="fixed h-full inset-0 bg-black bg-opacity-80 hidden justify-center items-center" id="notif-modal">
    <div class="">
        <div class="bg-white rounded shadow-lg w-[800px] h-[500px] overflow-auto pb-4">
            <!-- Modal header -->
            <div class="py-7 px-2 flex flex-row bg-red-400">
                <span class="font-semibold text-[20px] text-white">Notifications</span>
                <button id="btn-close-notif" class="">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-10 h-8 ml-[620px] hover:bg-red-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- modal body -->
            <div id="notif-body" class="xs-md:flex flex-col xs-md:justify-center justify-center xs-md:items-center items-center w-[750] px-4">

            </div>
        </div>
    </div>
</div>


<!-- modal export-->
<div class="fixed h-full inset-0 bg-black bg-opacity-80 hidden justify-center items-center" id="export-modal">
    <div class="">
        <div class="bg-white rounded shadow-lg w-[350px] h-[220px] overflow-auto">
            <!-- Modal header -->
            <div class="">
                <span class="font-semibold text-[20px] text-black ml-2">Select date range</span>
                <hr class="bg-black border-black">
            </div>
            <!-- modal body -->
            <div id="notif-body" class="xs-md:flex flex-col xs-md:justify-center justify-center xs-md:items-center items-center w-[750] px-4">
                <span class="font-semibold text-[20px] text-black ml-1 mt-2">From:</span>
                <input type="date" class="w-full h-9 border border-black rounded-md" id="date_from">
                <span class="font-semibold text-[20px] text-black ml-1 mt-2">To:</span>
                <input type="date" class="w-full h-9 border border-black rounded-md" id="date_to">
            </div>
            <!-- modal footer-->
             <div class="flex items-center justify-center mt-3">
                <button type="submit" id="btn-submit-date" name="btn-submit-date" class="btn-submit-date bg-blue-500 border-2 border-third h-8 w-20 rounded-md hover:bg-blue-300 text-white">Submit</button>
                <button type="submit" id="btn-cancel-export" name="btn-cancel-export" class="btn-cancel-export ml-5 bg-red-500 border-2 border-black h-8 w-20 rounded-md hover:bg-red-700 text-white">Cancel</button>
             </div>
        </div>
    </div>
</div>

</div>



<script type="text/javascript" src="../assets/js/patient-history.js" defer></script>
