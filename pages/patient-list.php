<?php
    // session_start();
    // if(isset($_SESSION['username'])){

    // }else{
    //     header("refresh:0; url=../login.php");
    // }
    include_once dirname(__DIR__,1).'../header.php';
    include_once dirname(__DIR__,1).'/class/patient.class.php';
    $patient = new Patient();
    
?>


<?php include_once dirname(__DIR__,1).'/sidebar.php';?>
<main class="flex flex-col grow p-5 mt-24 ml-[300px]">
    <div class="w-full">
        <p class="text-white text-3xl font-bold mb-4 text-left" id="rpttitle">Patient Lists</p> 
        <hr class="h-px my-4 bg-white border-0">
        <div class="flex justify-end mb-2">
            <button type="submit" id="btn-export-tat" name="btn-export-tat" class="btn-export-tat bg-blue-500 border-2 border-third h-8 w-40 text-sm rounded-md hover:bg-blue-300 text-white">Export</button>
        </div>
        <div id="normal-table-patLists" class="flex flex-col">
            <?php echo $patient->SearchPatxList();?>
            <div id="result-table-pat" class="w-full hidden"> 

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
</main>
<?php //include_once dirname(__DIR__,1).'../footer.php';?>
<script type="text/javascript" src="../assets/js/report.patient-list.js" defer></script>




