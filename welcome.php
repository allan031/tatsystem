<?php
    ob_start();
    session_start();
    include_once dirname(__DIR__,1).'/tatsystem/header.php';
    if(isset($_SESSION['username'])){
        if(isset($_SESSION['InitLogin'])){
            $ispasswordchange = $_SESSION['InitLogin'];
            if($_SESSION['Platform'] == 'W' || $_SESSION['Platform'] == 'B'){
                if($ispasswordchange == 1){
                    header("url=./welcome.php");
                }else{
                    $username = $_SESSION['username'];
                    include_once dirname(__DIR__,1).'/tatsystem/class/registration.class.php';
                    $registration = new Registration();
                }
            }else{
                if($ispasswordchange == 1){
                    header("refresh:0; url=./pages/qr-scan.php");
                }else{
                    $username = $_SESSION['username'];
                    include_once dirname(__DIR__,1).'/tatsystem/class/registration.class.php';
                    $registration = new Registration();
                }
            }
        }
    }else{
        header("refresh:0; url=./login.php");
    }
    if(isset($_POST['btn-password-change'])){ 
        $password = (isset($_POST['password']) ? $_POST['password'] : null);
        $repassword = (isset($_POST['repassword']) ? $_POST['repassword'] : null);
        if($registration->ChangePassword($username,$password,$repassword)){
            $_SESSION['InitLogin'] = 1;
            //header("Refresh:0");
            if($_SESSION['Platform'] == 'W' || $_SESSION['Platform'] == 'B'){
                header("Refresh:0");
            }
            else{
                header("refresh:0; url=./pages/qr-scan.php");
            }
        }
    }
?>
<main class="hidden text-white bg-blue-800 mt-24">
    <div class="w-full mx-auto pt-7 ml-0">
        <span id="userid-hidden" class="hidden text-xs"><?php echo $username;?></span>
        <span id="ispasswordchange-hidden" class="hidden text-xs"><?php echo $ispasswordchange;?></span>
    </div> 
</main>

<!-- <script type="text/javascript" src="/tatsystem/assets/js/sidebar.js" defer></script> -->

<?php include_once dirname(__DIR__,1).'/tatsystem/sidebar.php';?>

<div class="fixed h-full inset-0 bg-black bg-opacity-80 justify-center items-center hidden" id="password-change-modal">
    <div class="xs:w-full sm:w-full lg-xl2-w-50 p-8 xs:p-4 sm:p-4 bg-blue-500 rounded shadow-xl mt-24 ml-[300px] xs:ml-0 sm:ml-0">
        <div id="modal-title" >
           <p class="pt-4 text-white text-xl font-bold">Change Password</p>
           <hr class="h-px my-4 bg-white border-0">
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
                        class="px-4 py-3 xs:mb-4 sm:mb-4 xs:w-full sm:w-full bg-third text-white text-md font-semibold rounded-lg shadow-2xl hover:bg-blue-300 hover:text-third">
                        Change Password
                    </button>
                    <button 
                        type="button" 
                        name="btn-close" 
                        id="btn-close" 
                        class="btn-close px-4 py-3 xs:mb-4 sm:mb-4 xs:w-full sm:w-full bg-transparent border border-white text-white text-md font-semibold rounded-lg shadow-2xl">
                        Close
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- <script type="text/javascript" src="./assets/js/sidebar.js" defer></script> -->
<script type="text/javascript" src="./assets/js/password_change.js" defer></script>

<?php include_once dirname(__DIR__,1).'/tatsystem/footer.php';?>
<script type="text/javascript"> //add this to prevent user from going back to login page 2023-09-26
    function preventBack(){window.history.forward()};
    setTimeout("preventBack()",0);
    window.onunload= function(){null};
</script>


