<?php 
// ob_start();
// session_start();
// if(isset($_SESSION['username'])){

// }else{
//     header("refresh:0; url=../login.php");
// }
    include_once dirname(__DIR__,1).'../header.php';
    include_once dirname(__DIR__,1).'/class/transaction.class.php'; 
    include_once dirname(__DIR__,1).'/class/qrCodeGen.class.php'; 
    $tranx = new Transaction();
?>

<script type="text/javascript" src="../assets/js/qrcodeGen.js" defer></script>

<?php include_once dirname(__DIR__,1).'/sidebar.php';?>

<main class="flex grow p-5">
    <div class="xs:w-full sm:w-full md:w-full xs:mt-44 sm:mt-44 md:mt-24">
        <?php echo $tranx->ViewTransationMobile($_SESSION['Department']);?>
    </div>
</main>
<?php include_once dirname(__DIR__,1).'../footer.php';?>