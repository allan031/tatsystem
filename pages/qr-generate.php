<?php
    // session_start();
    // if(isset($_SESSION['username'])){

    // }else{
    //     header("refresh:0; url=../login.php");
    // }
    include_once dirname(__DIR__,1).'../header.php';
    include_once dirname(__DIR__,1).'/class/dbconn.class.php';

    $conn = new DBConnection();
    date_default_timezone_set('Asia/Manila');
    $dateNow = date('Ymd');//date now
    $query = "Select COUNT(*) as [RowCount] from TblPatient where convert(date,CreatedDate) = '".$dateNow."'";
    $stmt =$conn->mssql_connect()->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch();
    if($row){
        $ctr = $row['RowCount'];
        if($ctr == null ?  $ctr = 00 : $ctr);
        $ctr = substr($ctr, -4);
        $ctr = str_pad($ctr + 1, 4, 0, STR_PAD_LEFT);
        $patID =  $dateNow . $ctr;
    }
?>

<script type="text/javascript" src="../assets/js/qrcodeGen.js" defer></script>

<?php include_once dirname(__DIR__,1).'/sidebar.php';?>
<main class="flex grow p-5 h-screen">

    <div class="w-full mt-24 ml-[300px]">
        <p class="text-white text-3xl font-bold mb-4 text-center">QR Code Generation</p>
        <hr class="h-px my-4 bg-white border-0">
        <div class="flex flex-row justify-center items-center">
            <div class="xs-sm-w md-w lg-xl2-w pr-4 pl-4 pb-4 pt-7 rounded-lg bg-white shadow-2xl">
            <span>
                <div class="flex flex-col">
                    <div id="username" class="hidden"><?php echo $_SESSION['username'];?></div>
                    <input type="text" name="patID" id="patID" value="<?php echo $patID; ?>" class="appearance-none w-full mb-2 p-2 bg-transparent border-b-2 border-third text-xl text-third font-semibold placeholder-third focus:text-third focus:outline-none" readonly>
                    <label class="block mb-2 text-third text-xl font-semibold" for="sex">
                    Gender
                    </label>
                    <div class="flex flex-col flex-1">
                        <div class="flex flex-row mr-2">
                            <input type="radio" id="male" class="radioBtnClass" name="sex" value="Male">
                            <label for="Sex" class="text-third text-lg">Male</label><br>
                        </div>
                        <div class="flex flex-row mr-24">
                            <input type="radio" id="female" class="radioBtnClass" name="sex" value="Female">
                            <label for="Sex" class="text-third text-lg">Female</label><br>
                        </div>
                        <hr class="my-2 border-third border-2">
                        <div class="" id="tat">
                            <label for="AgeGroup" class="text-third text-lg font-semibold">Age Group</label>
                            <select name="ageGroup" id="ageGroup" class="border-2 border-third w-full rounded-md h-10 text-third">
                                <option value="">---Select Age Group---</option>
                                <option value="Pedia">Pedia</option>
                                <option value="Adult">Adult</option>
                                <option value="Senior Citizen">Senior Citizen</option>   
                            </select>
                        </div>
                    </div>
                    <br>
                    <button name="submit" id="generate-qr" class="w-full my-2 px-4 py-3 bg-third text-white text-xl uppercase font-bold rounded-lg shadow-2xl hover:text-third hover:bg-blue-400">Generate</button>
                </div>
            </span>   
            <!-- </form> -->
        </div>
    </div>
</main>
</div> 

<!-- modal -->
<div class="fixed h-full inset-0 bg-black bg-opacity-80 hidden justify-center items-center" id="qr-code-generation">
    <div class="">
        <div class="bg-white rounded shadow-lg w-[300px] h-[300px]">
            <!-- Modal header -->
            <div class="border-b-2 px-3 py-2 border-black flex flex-row justify-between items-start">
                <h3 class="text-left font-medium ml-10">Patient QR Code Preview</h3>
                <button id="btn-close-qr" class="btn-close-qr ml-3 hover:bg-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M18 6l-12 12"></path>
                    <path d="M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <!-- modal body --> 
            <div class="xs-md:flex flex xs-md:justify-center justify-center xs-md:items-center items-center mt-10">
               <div class="border-2 border-black flex flex-col justify-center items-center" id="print-container">
                    <div class="my-2 px-3 flex flex-row justify-center items-center img-container" id="img-container">
                        <img id="qrcode-holder" src="" alt="" class="w-[90px] h-[90px]">
                        <span id="qrcode-label-holder" val="" class="font-semibold text-[20px]"></span>
                    </div>
               </div>
            </div>
            <div class="border-t-2 px-4 border-black flex flex-row justify-center items-center mt-14">
                <button name="submit" id="btn-print" class="btn-print my-2 py-2 mx-2 xs:w-32 sm:w-48 w-32 bg-third text-white text-sm uppercase font-bold rounded-lg shadow-2xl hover:text-third hover:bg-blue-400">Print</button>
            </div>
        </div>
    </div>
</div>
<?php //include_once dirname(__DIR__,1).'../footer.php';?> 