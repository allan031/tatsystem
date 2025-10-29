<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once dirname(__DIR__,1).'/tatsystem/header.php';
include_once dirname(__DIR__,1).'/tatsystem/class/authenticate.class.php';

$authenticateuser = new AuthenticateUser();
$message = "";

// 🔹 Generate CSRF token if not already set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 🔹 Handle login
if (isset($_POST['submit'])) { 
    // ✅ Check CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "Security validation failed. Please try again.";
    } else {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        if ($authenticateuser->Authenticate($username, $password)) {
            // Rotate CSRF token after successful login (extra safety)
            unset($_SESSION['csrf_token']); 
            include_once dirname(__DIR__,1).'/tatsystem/screen.php';
            header('refresh:1;url=./index.php');
            exit;
        } else {
            $message = "Invalid Credentials"; 
            header('refresh:1;url=./login.php');
            exit;
        }
    }
}
?>

<main class="flex grow p-5">
    <div class="w-full flex items-center justify-center">
        <div class=" xs-sm-w md-w lg-xl2-w pr-4 pl-4 pb-4 pt-7 rounded-lg bg-white shadow-2xl ">
            <div class="flex justify-center items-center xs:flex-col sm:flex-col md:flex-col">
                <img src="/tatsystem/assets/images/logo.png" alt="logo" class="xs:mb-4 sm:mb-4">
            </div>
            <span class="flex justify-center items-center italic text-[25px] text-black font-semibold text-center">Turn Around Time System</span>
            <br>
            <p id="filled_success_help" class="mt-2 text-xl text-blue-600 dark:text-blue-400">
                <span class="font-medium"><?= htmlspecialchars($message);?></span>
            </p>

            <!-- ✅ Added hidden CSRF token field -->
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                
                <div class="flex items-center justify-center flex-col">
                    <input type="text" name="username" maxlength="6" 
                           onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" 
                           id="username" placeholder="Username" 
                           class="appearance-none w-full mb-2 p-2 bg-transparent border-b-2 border-third text-xl text-third font-semibold placeholder-third focus:text-third focus:outline-none ">
                    
                    <input type="password" name="password" id="password" placeholder="Password" 
                           class="appearance-none w-full mb-2 p-2 bg-transparent border-b-2 border-third text-xl text-third font-semibold placeholder-third focus:outline-none">
                    <br>
                    <button name="submit" class="w-full my-2 px-4 py-3 bg-third text-white text-xl uppercase font-bold rounded-lg shadow-2xl hover:text-third hover:bg-blue-400">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include_once dirname(__DIR__,1).'/tatsystem/footer-login.php';?>

<script type="text/javascript">
// prevent user from going back to login page
function preventBack(){window.history.forward()};
setTimeout("preventBack()",0);
window.onunload=function(){null};
</script>
