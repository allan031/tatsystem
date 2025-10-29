<?php 
    include_once dirname(__DIR__,1).'/app1/header.php';
    include_once dirname(__DIR__,1).'/app1/class/authenticate.class.php';
    $authenticateuser = new AuthenticateUser();

    if(isset($_POST['submit'])){ 
        $username = (isset($_POST['username']) ? $_POST['username'] : null);
        $password = (isset($_POST['password']) ? $_POST['password'] : null);
        if($authenticateuser->Authenticate2($username,$password)){
            header('refresh:1;url=./pages/qr-scan.php');
        }else{
            header('refresh:1;url=./mobile-login.php');
        }
    }
?>

<main class="flex grow p-5">
    <div class="w-full flex items-center justify-center">
        <div class=" xs-sm-w md-w lg-xl2-w pr-4 pl-4 pb-4 pt-7 rounded-lg bg-white shadow-2xl ">
            <div class="flex justify-center items-center xs:flex-col sm:flex-col md:flex-col">
                <img src="/app1/assets/images/logo.png" alt="logo" srcset="" class="xs:mb-4 sm:mb-4">
            </div>
            <span class="flex justify-center items-center italic text-[25px] text-black font-semibold text-center">Turn Around Time System</span>
            <br>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="flex items-center justify-center flex-col">
                    <input type="text" name="username" id="username" placeholder="Username" class="appearance-none w-full mb-2 p-2 bg-transparent border-b-2 border-third text-xl text-third font-semibold placeholder-third focus:text-third focus:outline-none ">
                    <input type="password" name="password" id="password" placeholder="Password" class="appearance-none w-full mb-2 p-2 bg-transparent border-b-2 border-third text-xl text-third font-semibold placeholder-third focus:outline-none">
                    <br>
                    <button name="submit" class="w-full my-2 px-4 py-3 bg-third text-white text-xl uppercase font-bold rounded-lg shadow-2xl hover:text-third hover:bg-blue-400">Login</button>
                </div>
            </form>
        </div>
    </div>
</main>



<?php include_once dirname(__DIR__,1).'/app1/footer.php';?>