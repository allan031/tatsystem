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
    <section class="w-full mt-24 ml-[300px]">
        <div class="flex flex-wrap justify-between items-center py-5">
            <p class="text-white font-bold text-3xl">User Registration</p>
            <a href="/tatsystem/admin/registration.php" class=" py-2 px-4 text-third text-base font-semibold uppercase bg-white hover:text-white hover:bg-third rounded-lg shadow-lg">
                <span class="flex flex-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                    </svg>
                    &nbsp;
                    <span class="">Add User</span>  
                </span>
            </a>
        </div>
        <hr class="h-px my-4 bg-white border-0">
        <?php echo $registration->PaginationTableWithSearchRegisteredUser(); ?>
        <div id="searchresultPD" class="hidden">

        </div>              
    </section>
</main>

<!-- modal -->
<div class="fixed h-full inset-0 bg-black bg-opacity-80 justify-center items-center hidden" id="password-change-modal">
    <div class="xs:w-full sm:w-full lg-xl2-w-50 p-8 xs:p-4 sm:p-4 bg-gray-500 rounded shadow-xl ml-[300px]">
        <div id="modal-title" >
           <p class="pt-4 text-white text-xl font-bold">Change Password</p>
           <hr class="h-px my-4 bg-white border-0">
           <div id="passval" class="hidden"></div>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div id="modal-body">
                <div class="w-full  mb-4 p-2  bg-gray-200 border border-gray-200 rounded shadow-xl">   
                    <label for="password" class="block mb-2 text-third text-base font-semibold bg-gray-200" >Password</label>
                    <input 
                        id="password" 
                        name="password"
                        type="password" 
                        class="appearance-none block w-full bg-gray-200  text-third text-lg font-bold focus:outline-none" 
                        required />
                </div>
                <div class="w-full  mb-4 p-2  bg-gray-200 border border-gray-200 rounded shadow-xl">   
                    <label for="repassword" class="block mb-2 text-third text-base font-semibold bg-gray-200" >Re-Password</label>
                    <input 
                        id="repassword" 
                        name="repassword" 
                        type="password"
                        class="appearance-none block w-full bg-gray-200  text-third text-lg font-bold focus:outline-none" 
                        required />
                </div>
            </div>
            <div id="modal-footer">
                <div class="pt-4 flex flex-row justify-end md:space-x-4 lg:space-x-4 xl:space-x-4 xl1:space-x-4 xl2:space-x-4 xs:flex-col sm:flex-col xs:items-center sm:items-center xs:justify-center sm:justify-center ">
                    <button 
                        type="submit" 
                        name="btn-password-change" 
                        id="btn-password-change" 
                        class="btn-password-change px-4 py-3 xs:mb-4 sm:mb-4 xs:w-full sm:w-full bg-third text-white text-md font-semibold rounded-lg shadow-2xl hover:bg-blue-300 hover:text-third">
                        Change Password
                    </button>
                    <button 
                        type="button" 
                        name="btn-close" 
                        id="btn-close-reset" 
                        class="btn-close px-4 py-3 xs:mb-4 sm:mb-4 xs:w-full sm:w-full bg-transparent border border-white text-white text-md font-semibold rounded-lg shadow-2xl">
                        Close
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- modal for edit user -->
<div class="fixed inset-0 bg-black bg-opacity-80 justify-center items-center hidden" id="edit-save-modal">
    <div class="xs:w-full sm:w-full md-xl2-w-50 p-4 xs:p-2.5 sm:p-2.5 bg-gray-500 rounded shadow-xl ml-[300px] w-[820px]">
        <div id="modal-title" >
        <span id="passVal" class="hidden"><?php echo $_SESSION['username'];?></span>
           <p class="pt-4 text-white text-lg font-semibold">Edit User</p>
           <hr class="h-px my-4 bg-white border-0">
        </div>
        <div id="modal-body">
        <span class="flex flex-wrap w-[650px]">
            <div class="flex flex-row">
                <span class="w-64 mb-4 p-2 mr-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                    <label 
                        class="block mb-2 text-third text-base font-semibold bg-slate-100" 
                        for="first-name">
                        First Name
                    </label>
                    <input 
                        class="appearance-none block w-full bg-slate-100  text-third text-lg font-bold focus:outline-none"  
                        id="edit-first-name" 
                        type="text"> 
                </span>
                <span class="w-64 mb-4 p-2 mr-2   bg-slate-100 border border-slate-200 rounded shadow-xl">   
                    <label 
                        class="block mb-2 text-third text-base font-semibold bg-slate-100" 
                        for="middle-name">
                        Middle Name
                    </label>
                    <input class="appearance-none block w-full bg-slate-100  text-third text-lg font-bold focus:outline-none" id="edit-middle-name" type="text">
                </span>
                <span class="w-64 mb-4 p-2 mr-2   bg-slate-100 border border-slate-200 rounded shadow-xl">   
                    <label class="block mb-2 text-third text-base font-semibold bg-slate-100" for="last-name">
                        Last Name
                    </label>
                    <input class="appearance-none block w-full bg-slate-100  text-third text-lg font-bold focus:outline-none" id="edit-last-name" type="text">
                </span>
            </div>
            <div class="flex flex-row">
                <span class="w-[783px] mb-4 p-2 mr-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                    <label class="block text-third text-base font-semibold bg-slate-100" for="department">
                        Department
                    </label>
                    <?php echo $registration->GetDepartment(); ?>
                </span>
            </div>
            <div class="flex flex-row">
                <span class="w-64 mb-4 p-2 mr-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                    <label class="block mb-2 text-third text-base font-semibold bg-slate-100" for="birthdate">
                        Birth Date (MM-DD-YYYY)
                    </label>
                    <input class="appearance-none block w-full bg-slate-100  text-third text-lg font-bold focus:outline-none" id="edit-birthDate" type="date">
                </span>
                <span class="w-64 mb-4 p-2 mr-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                    <label class="block mb-2 text-third text-base font-semibold bg-slate-100" for="position">
                        Email Address
                    </label>
                    <input class="appearance-none block w-full bg-slate-100  text-third text-lg font-bold focus:outline-none" id="edit-emailAdd" type="email" required>
                </span>
                <span class="w-64 mb-4 p-2 mr-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                    <label class="block mb-2 text-third text-base font-semibold bg-slate-100" for="username">
                        Employee Number
                    </label>
                    <input class="appearance-none block w-full bg-slate-100  text-third text-lg font-bold focus:outline-none" id="edit-username" type="text">
                </span>
            </div>
            <div class="flex flex-row">
                <span class="w-[257px] mb-4 p-2 mr-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                <label class="block mb-2 text-third text-base font-semibold bg-slate-100" for="username">
                    Platform
                </label>
                <div class="flex flex-row flex-1">
                    <div class="flex flex-row mr-5">
                        <input type="radio" id="web" class="edit-radioBtnClass" name="platform" value="W">
                        <label for="Web" class="text-third text-lg">Web</label><br>
                    </div>
                    <div class="flex flex-row mr-5">
                        <input type="radio" id="mobile" class="edit-radioBtnClass" name="platform" value="M">
                        <label for="Mobile" class="text-third text-lg">Mobile</label><br>
                    </div>
                    <div class="flex flex-row">   
                        <input type="radio" id="both" class="edit-radioBtnClass" name="platform" value="B">
                        <label for="Both" class="text-third text-lg">Both</label>
                    </div>
                </div>
                </span>
                <span class="w-[255px] mb-4 p-2 mr-2  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                    <label class="block mb-2 text-third text-base font-semibold bg-slate-100" for="accType">
                        Account Type
                    </label>
                    <div class="flex flex-row flex-1">
                        <div class="flex flex-row mr-16">
                            <input type="radio" id="web" class="edit-radioBtnClassAccType" name="admin" value="0">
                            <label for="user" class="text-third text-lg">Admin</label><br>
                        </div>
                        <div class="flex flex-row mr-16">
                            <input type="radio" id="mobile" class="edit-radioBtnClassAccType" name="user" value="2">
                            <label for="user" class="text-third text-lg">User</label><br>
                        </div>
                    </div>
                </span>
                <span class="w-[258px] mb-4 p-2 mr-1  bg-slate-100 border border-slate-200 rounded shadow-xl">   
                    <label class="block mb-2 text-third text-base font-semibold bg-slate-100" for="accType">
                        Account Type
                    </label>
                    <?php echo $registration->GetAccountAccess(); ?>
                </span>
            </div>
        </span>
        </div>
        <div id="modal-footer">
            <hr class="h-px my-4 bg-white border-0">
            <div class="pt-4 flex flex-row justify-end space-x-4">
                <button 
                    type="submit" 
                    name="btn-edit" 
                    id="btn-edit" 
                    class="btn-edit px-3 py-2.5 mb-4 bg-third text-white text-sm font-semibold rounded-lg shadow-2xl hover:bg-blue-300 hover:text-third">
                    Save Changes
                </button>
                <button 
                    type="button" 
                    name="btn-edit-close" 
                    id="btn-edit-close" 
                    class="btn-edit-close px-3 py-2.5 mb-4 bg-transparent border border-white text-white text-sm font-semibold rounded-lg shadow-2xl hover:bg-white hover:text-third hover:border-third">
                    Close
                </button>
                <span class="hidden" id="passValUserID"></span>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="../assets/js/registration.js" defer></script>
<?php //include_once dirname(__DIR__,1).'/footer.php';?>



