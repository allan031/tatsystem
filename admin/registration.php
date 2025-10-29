<?php
    // session_start();
    // if(isset($_SESSION['username'])){

    // }else{
    //     header("refresh:0; url=../login.php");
    // }
    include_once dirname(__DIR__,1).'/header.php'; 
    include_once dirname(__DIR__,1).'/class/registration.class.php';
    $registration = new Registration();
?>

<?php include_once dirname(__DIR__,1).'/sidebar.php';?>
<main class="flex grow p-5">

    <div class="w-[60%] lg-xl2-w-50 mt-24 ml-[500px] flex flex-col items-center justify-center">

        <p class="text-white text-3xl font-bold mb-4 mt-3">User Registration Form</p>
        <hr class="h-px my-4 bg-white border-0 w-full">
        <span class="hidden" id="createdBy"><?php echo $_SESSION['username'];?> </span>
        <span class="flex flex-wrap w-[600px]">
            <span class="w-full  mb-4 p-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                <label 
                    class="block mb-2 text-third text-base font-semibold bg-slate-100" 
                    for="first-name">
                    First Name
                </label>
                <input 
                    class="appearance-none block w-full bg-slate-100  text-third text-lg font-bold focus:outline-none"  
                    id="first-name" 
                    type="text"> 
            </span>
            <span class="w-full  mb-4 p-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                <label 
                    class="block mb-2 text-third text-base font-semibold bg-slate-100" 
                    for="middle-name">
                    Middle Name
                </label>
                <input class="appearance-none block w-full bg-slate-100  text-third text-lg font-bold focus:outline-none" id="middle-name" type="text">
            </span>
            <span class="w-full  mb-4 p-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                <label class="block mb-2 text-third text-base font-semibold bg-slate-100" for="last-name">
                    Last Name
                </label>
                <input class="appearance-none block w-full bg-slate-100  text-third text-lg font-bold focus:outline-none" id="last-name" type="text">
            </span>
            <span class="w-full mb-4 p-4  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                <label class="block text-third text-base font-semibold bg-slate-100" for="department">
                    Department
                </label>
                <?php echo $registration->GetDepartment(); ?>
            </span>
            <span class="w-full  mb-4 p-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                <label class="block mb-2 text-third text-base font-semibold bg-slate-100" for="birthdate">
                    Birth Date (MM-DD-YYYY)
                </label>
                <input class="appearance-none block w-full bg-slate-100  text-third text-lg font-bold focus:outline-none" id="birthDate" type="date">
            </span>
            <span class="w-full  mb-4 p-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                <label class="block mb-2 text-third text-base font-semibold bg-slate-100" for="position">
                    Email Address
                </label>
                <input class="appearance-none block w-full bg-slate-100  text-third text-lg font-bold focus:outline-none" id="emailAdd" type="email" required>
            </span>
            <span class="w-full  mb-4 p-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                <label class="block mb-2 text-third text-base font-semibold bg-slate-100" for="username">
                    Employee Number
                </label>
                <input class="appearance-none block w-full bg-slate-100  text-third text-lg font-bold focus:outline-none" id="username" type="text">
            </span>
            <span class="w-full  mb-4 p-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                <label class="block mb-2 text-third text-base font-semibold bg-slate-100" for="username">
                    Platform
                </label>
                <div class="flex flex-row flex-1">
                    <div class="flex flex-row mr-16">
                        <input type="radio" id="web" class="radioBtnClass" name="platform" value="W">
                        <label for="Web" class="text-third text-lg">Web</label><br>
                    </div>
                    <div class="flex flex-row mr-16">
                        <input type="radio" id="mobile" class="radioBtnClass" name="platform" value="M">
                        <label for="Mobile" class="text-third text-lg">Mobile</label><br>
                    </div>
                    <div class="flex flex-row mr-16">   
                        <input type="radio" id="both" class="radioBtnClass" name="platform" value="B">
                        <label for="Both" class="text-third text-lg">Both</label>
                    </div>
                </div>
            </span>
            <span class="w-full  mb-4 p-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                <label class="block mb-2 text-third text-base font-semibold bg-slate-100" for="accType">
                    Account Type
                </label>
                <div class="flex flex-row flex-1"> 
                    <div class="flex flex-row mr-16">
                        <input type="radio" id="web" class="radioBtnClassAccType" name="user_type" value="0">
                        <label for="user" class="text-third text-lg">Admin</label><br>
                    </div>
                    <div class="flex flex-row mr-16">
                        <input type="radio" id="mobile" class="radioBtnClassAccType" name="user_type" value="2">
                        <label for="user" class="text-third text-lg">User</label><br>
                    </div>
                </div>
            </span>
            <span class="w-full  mb-4 p-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                <label class="block mb-2 text-third text-base font-semibold bg-slate-100" for="accType">
                    Account Access
                </label>
                <div class="flex flex-row flex-1">
                    <?php echo $registration->GetAccountAccess(); ?>
                </div>
            </span>
        
            <span class="w-full mt-4 flex flex-row xs:flex-col sm:flex-col items-center justify-end space-x-4 xs:space-x-0 sm:space-x-0 xs:justify-center sm:justify-center">
                <button 
                    name="btn-add-user" 
                    id="btn-add-user" 
                    class="px-4 py-2 xs:mb-4 sm:mb-4 xs:w-full sm:w-full bg-transparent border border-white text-white text-md font-semibold rounded-lg shadow-2xl hover:bg-third hover:text-white hover:border-third">
                    Save User
                </button>
                <a href="/tatsystem/admin/registration.view.php">
                <button 
                    name="btn-cancel-add-user"  
                    id="btn-cancel-add-user" 
                    class="px-4 py-2 xs:mb-4 sm:mb-4 xs:w-full sm:w-full bg-transparent border border-white text-white text-md font-semibold rounded-lg shadow-2xl hover:bg-white hover:text-third hover:border-third">
                    Cancel
                </button>
            </a>
            </span>
        </span>
    </div>
</main>

<!-- modal for user registration -->
<div class="fixed h-full inset-0 bg-black bg-opacity-80 justify-center items-center hidden" id="registration-save-modal">
    <div class="xs:w-full sm:w-full md-xl2-w-50 p-4 xs:p-2.5 sm:p-2.5 bg-gray-500 rounded shadow-xl">
        <div id="modal-title" >
           <p class="pt-4 text-white text-lg font-semibold">User Registration</p>
           <hr class="h-px my-4 bg-white border-0">
        </div>
        <div id="modal-body">
            <p class="mb-4 text-center text-white text-md font-semibold">Do you want to add this user?</p>
            <p class="mb-2.5 text-center text-white text-md font-light"><span class="text-md font-semibold">NOTE&nbsp;:&nbsp;</span>Employee Number is the Username.</p>
        </div>
        <div id="modal-footer">
            <hr class="h-px my-4 bg-white border-0">
            <div class="pt-4 flex flex-row justify-end space-x-4">
                <button 
                    type="submit" 
                    name="btn-save" 
                    id="btn-save" 
                    class="btn-save px-3 py-2.5 mb-4 bg-third text-white text-sm font-semibold rounded-lg shadow-2xl hover:bg-blue-300 hover:text-third">
                    Save
                </button>
                <button 
                    type="button" 
                    name="btn-close" 
                    id="btn-close" 
                    class="btn-close px-3 py-2.5 mb-4 bg-transparent border border-white text-white text-sm font-semibold rounded-lg shadow-2xl hover:bg-white hover:text-third hover:border-third">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="../assets/js/registration.js" defer></script>
<?php include_once dirname(__DIR__,1).'/footer.php';?>

