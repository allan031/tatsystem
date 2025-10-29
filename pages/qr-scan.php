<?php 
// ob_start();
// session_start();
// if(isset($_SESSION['username'])){

// }else{
//     header("refresh:0; url=../login.php");
// }
    include_once dirname(__DIR__,1).'../header.php';
    include_once dirname(__DIR__,1).'/class/registration.class.php';   
    include_once dirname(__DIR__,1).'/class/qrCodeGen.class.php'; 
    $registration = new Registration();
    $qrcode = new QrCodeGeneration();
?>

<script type="text/javascript" src="../assets/js/qrcodeGen.js"></script>

<?php include_once dirname(__DIR__,1).'/sidebar.php';?>

<main class="flex grow p-5">
    <div class="w-full xs:mt-40 sm:mt-40 md:mt-24 mt-24 mx-auto lg:ml-[300px] xl:ml-[300px]"> <!--remove xs:w-auto sm:w-auto 06-26-24 2:52PM-->
        <div class="relative h-10 w-10">
            <span id="notif" class="absolute right-0 rounded-full bg-red-600 text-white text-[10px] p-1 font-bold"></span>
            <button id="btn-notif">
                <svg class="w-8 h-8 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 20">
                    <path d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z"/>
                </svg>
            </button>
        </div>
        <div class="flex flex-col">
            <p class="text-white text-[22px] font-bold text-center">Scan Patient Qr Code</p>
        </div>
        <span class="hidden" id="dept-value"><?php echo $_SESSION['Department'];?></span>
        <span class="hidden" id="username-value"><?php echo $_SESSION['username'];?></span>
        <span class="hidden" id="clock1"></span>
        <p class="flex" id="exceedProcess"></p>
        <span class="hidden" id="qr-value"></span>
        <hr class="h-px my-4 bg-white border-0 xs:w-full sm:w-full">
        <div class="flex flex-col justify-center items-center xs-sm-w">
            <div class="w-full pr-4 pl-4 pb-4 rounded-lg bg-white border border-black shadow-2xl">
                <div class="flex flex-col">
                    <div class="mb-4 mt-4 md:text-lg" id="dept">
                        <div id="passVal-proc" class="hidden"></div>
                        <?php echo $qrcode->GetProcedureTypeModified($_SESSION['Department'],$_SESSION['IsAccess']); ?>   
                    </div>
                    <div class="mb-4 hidden flex-col" id="select-procedure">
                        <label for="SubProcedure" class="text-third text-lg mt-1">Procedure List (Optional):</label>
                        <select name="procedure" id="procedure" class="w-full h-12 ml-0 rounded-md border-2 border-third">
                            <option></option>
                        </select>
                    </div>
                    <label for="TranasctTiming" class="text-third text-[20px]">Transaction Timing:</label>
                    <div class="flex flex-row px-2">
                        <input type="radio" id="rd-transactTimingStart" class="radioBtnClassTranxTiming mr-2 h-8 w-8 mb-2" name="transactTiming" value="Start">
                        <label for="Web" class="text-third text-[20px]">Start</label><br>
                    </div>
                    <div class="flex flex-row px-2">
                        <input type="radio" id="rd-transactTimingStartEnd" class="radioBtnClassTranxTiming mr-2 h-8 w-8" name="transactTiming" value="End">
                        <label for="Mobile" class="text-third text-[20px]">End</label><br>
                    </div>
                    <!-- <div id="reader" width="500px" height="500px"></div> -->
                </div>
            </div>
        </div>
    </div>
</main> 



<!-- modal -->
<div class="fixed h-full inset-0 bg-black bg-opacity-80 hidden justify-center items-center" id="qr-scan-modal">
    <div class="xs:w-full sm:w-full md:w-full  p-4 xs:p-2.5 sm:p-2.5 rounded shadow-xl">
        <div id="reader" class="" width="500px" height="500px" class ="border-b-2 bg-white mt-2"></div>
    </div>
</div>


<!-- modal -->
<div class="fixed h-full inset-0 bg-black bg-opacity-80 hidden justify-center items-center" id="remarks-modal">
    <div class="">
        <div class="bg-white rounded shadow-lg xs:w-[300px] xs:h-[200px] sm:w-[300px] sm:h-[200px] md:w-[500px] md:h-[300px]">
            <!-- Modal header -->
            <div class="py-2 px-2 flex flex-row">
                <span class="font-semibold xs:text-[14px] sm:text-[14px] md:text-[16px]">Remarks</span>
            </div>
            <!-- modal body -->
            <div class="xs-md:flex flex-col xs-md:justify-center justify-center xs-md:items-center items-center md:px-2">
                <textarea id="txtremarks" name="txtremarks" rows="1" cols="1" class="border-2 border-black xs:px-2 sm:px-2 ml-2 xs:w-[280px] xs:h-[100px] sm:w-[280px] sm:h-[100px] md:w-[470px] md:h-[200px]" value="">
                    
                </textarea>
                <!-- <input type="text" id="txtremarks" class="border-2 border-black px-2 ml-2 xs:w-[280px] xs:h-[100px] sm:w-[280px] sm:h-[100px]" name="txtremarks"> -->
            </div>
            <div class="flex flex-row justify-center items-center">
                <button name="submit" id="btn-submit-remarks" class="btn-submit-remarks my-2 py-2 mx-2 xs:w-32 sm:w-48 w-32 bg-third text-white text-sm uppercase font-bold rounded-lg shadow-2xl hover:text-third hover:bg-blue-400">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- modal notif-->
<div class="fixed h-full inset-0 bg-black bg-opacity-80 hidden justify-center items-center" id="notif-modal">
    <div class="">
        <div class="bg-white rounded shadow-lg xs:w-[300px] xs:h-[350px] sm:w-[300px] sm:h-[350px] md:w-[500px] md:h-[450px] overflow-auto pb-4 xs:mt-44 sm:mt-44">
            <!-- Modal header -->
            <div class="py-4 px-2 flex flex-row bg-red-400">
                <span class="font-semibold text-[16px] text-white">Notifications</span>
                <button id="btn-close-notif" class="">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="xs:w-5 xs:h-5 xs:ml-44 sm:w-5 sm:h-5 sm:ml-44 md:w-7 md:h-7 md:ml-[350px] hover:bg-red-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>
            <!-- modal body -->
            <div id="notif-body" class="xs-md:flex flex-col xs-md:justify-center justify-center xs-md:items-center items-center w-[270] px-4">

            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../assets/js/test1.js"></script>
<script src="../node_modules/html5-qrcode/html5-qrcode.min.js"></script>

<?php //include_once dirname(__DIR__,1).'../footer.php';?>