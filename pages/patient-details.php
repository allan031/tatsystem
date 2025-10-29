<?php
    include_once dirname(__DIR__,1).'../header.php';
    include_once dirname(__DIR__,1).'/sidebar.php';
    include_once dirname(__DIR__,1).'/class/patient.class.php'; 
    $patient = new Patient();

    $username = $_SESSION['username'];
?>

<main class="flex grow p-5 ">
    <div class="w-full mt-24 ml-[300px]">
        <span id="uname" class="hidden"><?php echo $username;?></span>
        <p class="text-white text-3xl font-bold mb-4 text-left">Patient Information</p>
        <hr class="h-px my-4 bg-white border-0">
        <?php echo $patient->PatientDataTable();?>
        <div id="searchresultPD">

        </div> 
    </div>
</main>

<!-- edit modal -->
<div class="fixed h-full inset-0 bg-black bg-opacity-80 justify-center items-center hidden edit-patient-modal" id="edit-patient-modal">
    <div class="xs:w-full sm:w-full lg-xl2-w-50 p-3 xs:p-4 sm:p-4 bg-gray-500 rounded shadow-xl ml-[300px] mt-28">
        <div id="modal-title" >
           <p class=" text-white text-xl font-bold">Edit Patient</p>
           <hr class="h-px my-4 bg-white border-0">
           <div id="passval" class="hidden"></div> 
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div id="modal-body">
                <div class="w-full  mb-4 p-2  bg-gray-200 border border-gray-200 rounded shadow-xl">   
                    <label for="lname" class="block mb-2 text-third text-base font-semibold bg-gray-200" >Gender</label>
                    <input 
                        id="patx-sex" 
                        name="patx-sex"
                        type="text" 
                        class="patx-sex appearance-none block w-full bg-gray-200  text-third text-lg font-bold focus:outline-none" 
                        required readonly/>
                </div>
                <div class="w-full  mb-4 p-2  bg-gray-200 border border-gray-200 rounded shadow-xl">   
                    <label for="lname" class="block mb-2 text-third text-base font-semibold bg-gray-200" >Age Group</label>
                    <input 
                        id="age-group" 
                        name="age-group"
                        type="text" 
                        class="age-group appearance-none block w-full bg-gray-200  text-third text-lg font-bold focus:outline-none" 
                        required readonly/>
                </div>
                <div class="w-full  mb-4 p-2  bg-gray-200 border border-gray-200 rounded shadow-xl">   
                    <label for="lname" class="block mb-2 text-third text-base font-semibold bg-gray-200" >Patient ID (Patient No. - From Bizbox)</label>
                    <input 
                        id="patientID_FK" 
                        name="patientID_FK"
                        type="text" 
                        class="patientID_FK appearance-none block w-full bg-gray-200  text-third text-lg font-bold focus:outline-none" 
                        required />
                </div>
                <div class="w-full  mb-4 p-2  bg-gray-200 border border-gray-200 rounded shadow-xl">   
                    <label for="lname" class="block mb-2 text-third text-base font-semibold bg-gray-200" >Last Name</label>
                    <input 
                        id="lname" 
                        name="lname"
                        type="text" 
                        class="lname appearance-none block w-full bg-gray-200  text-third text-lg font-bold focus:outline-none" 
                        required />
                </div>
                <div class="w-full  mb-4 p-2  bg-gray-200 border border-gray-200 rounded shadow-xl">   
                    <label for="fname" class="block mb-2 text-third text-base font-semibold bg-gray-200" >First Name</label>
                    <input 
                        id="fname" 
                        name="fname" 
                        type="text"
                        class="fname appearance-none block w-full bg-gray-200  text-third text-lg font-bold focus:outline-none" 
                        required />
                </div>
                <div class="w-full  mb-4 p-2  bg-gray-200 border border-gray-200 rounded shadow-xl">   
                    <label for="mname" class="block mb-2 text-third text-base font-semibold bg-gray-200" >Middle Name</label>
                    <input 
                        id="mname" 
                        name="mname" 
                        type="text"
                        class="mname appearance-none block w-full bg-gray-200  text-third text-lg font-bold focus:outline-none" 
                        required />
                </div>
                <div class="w-full  mb-4 p-2  bg-gray-200 border border-gray-200 rounded shadow-xl">   
                    <label for="bDate" class="block mb-2 text-third text-base font-semibold bg-gray-200" >Birth Date (MM-DD-YYYY)</label>
                    <input 
                        id="bDate" 
                        name="bDate" 
                        type="date"
                        class="bDate appearance-none block w-full bg-gray-200  text-third text-lg font-bold focus:outline-none" 
                        required />
                </div>
            </div>
            <div id="modal-footer">
                <div class="pt-2 flex flex-row justify-end md:space-x-4 lg:space-x-4 xl:space-x-4 xl1:space-x-4 xl2:space-x-4 xs:flex-col sm:flex-col xs:items-center sm:items-center xs:justify-center sm:justify-center ">
                    <button 
                        type="submit" 
                        name="btn-edit-save" 
                        id="btn-edit-save" 
                        class="btn-edit-save w-28 px-4 py-2 xs:mb-4 sm:mb-4 xs:w-full sm:w-full bg-third text-white text-md font-semibold rounded-lg shadow-2xl hover:bg-blue-300 hover:text-third">
                        Save
                    </button>
                    <button 
                        type="button" 
                        name="btn-close" 
                        id="btn-close-edit" 
                        class="btn-close-edit px-4 py-2 xs:mb-4 sm:mb-4 xs:w-full sm:w-full bg-transparent border border-white text-white text-md font-semibold rounded-lg shadow-2xl">
                        Close
                    </button>
                </div>
            </div>
        </form>
    </div>

</div> 


<!-- modal --> 
<div class="fixed h-full inset-0 bg-black bg-opacity-80 hidden justify-center items-center" id="qr-code-generation">
    <!-- <div class="xs:w-full sm:w-full p-4 xs:p-2.5 sm:p-2.5 rounded shadow-xl"> -->
        <div class="bg-white rounded shadow-lg md-xl:flex md-xl:flex-col md-xl:justify-center ml-[250px] w-[300px] h-[300px]">
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
            <!-- <div class="xs-md:flex flex xs-md:justify-center justify-center xs-md:items-center items-center mt-10">
               <div class="border-2 border-black flex flex-col justify-center items-center" id="print-container">
                    <div class="my-2 px-3 flex flex-row justify-center items-center img-container" id="img-container">
                        <img id="qrcode-holder" src="" alt="" class="w-[90px] h-[90px]">
                        <span id="qrcode-label-holder" val="" class="font-semibold text-[20px]"></span>
                    </div>
               </div>
            </div> -->
            <div class="xs-md:flex flex xs-md:justify-center justify-center xs-md:items-center items-center mt-10">
               <div class="border-2 border-black flex flex-col justify-center items-center" id="print-container">
                    <div class="my-2 px-3 flex flex-row justify-center items-center img-container" id="img-container">
                        <img id="qrcode-holder" src="" alt="" class="w-[90px] h-[90px]">
                        <span id="qrcode-label-holder" data-val="" class="font-semibold text-[20px]"></span>
                    </div>
               </div>
            </div>
            <div class="border-t-2 px-4 border-black flex flex-row justify-center items-center mt-14">
                <button name="submit" id="btn-print" class="btn-print my-2 py-2 mx-2 xs:w-32 sm:w-48 w-32 bg-third text-white text-sm uppercase font-bold rounded-lg shadow-2xl hover:text-third hover:bg-blue-400">Print</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../assets/js/patient-details.js" defer></script>
