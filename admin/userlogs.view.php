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
        <p class="text-white font-bold text-3xl">User Logs</p>
        <hr class="my-5">
        <div class="w-full mt-5">
            <?php echo $registration->GetUserLogs();?>
        </div>
    </section>
</main>

<script type="text/javascript" src="../assets/js/registration.js" defer></script>