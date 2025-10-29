<?php
    session_start();
    if(isset($_SESSION['username'])){

    }else{
        header("refresh:0; url=./login.php");
    }
?>
<script type="text/javascript" src="/tatsystem/assets/js/clock.js" defer></script>

<nav class="w-full xs:z-20 sm:z-20 z-20 bg-white p-4 fixed top-0 left-0 h-24 xs:h-36 sm:h-36">
    <div class="flex flex-wrap xs:flex-col sm:flex-col md:flex-row justify-between md:items-end lg:items-center xl:items-center xl1:items-center xl2:items-center">
        <div class="flex items-center justify-center">
            <a href="/tatsystem/welcome.php"><img src="/tatsystem/assets/images/logo_sm.png" alt="logo" srcset="" class=""></a>
        </div>
        <div id="sys-name" class="xs:hidden sm:hidden md:hidden ml-0">
            <span class="flex italic text-3xl text-third font-semibold">Turn Around Time System</span>
        </div>
        <!-- <hr class="h-px bg-third border-0"> -->
        <div class="flex xs:flex sm:flex md:flex flex-wrap items-end justify-center xs:justify-center sm:justify-center md:justify-end">
            <div 
                id="clock"
                class="px-2.5 py-4 xs:py-2.5 sm:py-2.5 text-center text-third text-4xl xs:text-sm sm:text-sm md:text-[28px] font-bold">
            </div>
            <div class="flex items-end justify-between lg:hidden xl:hidden xl1:hidden xl2:hidden">
                <div class="group">
                    <button id="btn-menu" class="text-black px-4 py-1 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="xs:w-8 xs:h-8 sm:w-8 sm:h-8 md:w-10 md:h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                    </button>
                    <span class="hidden absolute text-black font-semibold xs:text-[20px] sm:text-[20px] md:text-[15px] group-hover:flex items-end justify-end">Menu</span>
                </div>
            </div>
            <div id="menu-bar" class="md:hidden lg:hidden xl:hidden xl1:hidden xl2:hidden xs:mx-3 sm:mx-3">
                <span id="dept-value" class="hidden"><?php echo $_SESSION['Department'];?></span>
                <span id="dept-container" class="font-semibold text-[20px] text-third"></span>
            </div> 
        </div>
    </div>
</nav>
    <div
        id="side-menu" class="fixed top-24 xs:hidden sm:hidden md:hidden z-0 xs:z-20 sm:z-20 md:z-20 xs:top-36 sm:top-36 lg:left-0 p-2 w-[300px] overflow-y-auto text-center bg-gray-600 shadow h-screen"
        >
        <div class="text-gray-100 text-xl">
            <span id="fullname"><?php echo $_SESSION['FullName'];?></span>
            <hr class="my-2">
            <?php if($_SESSION['Platform'] == 'W'){ ?>
                <?php if($_SESSION['AccountType'] == 0){ ?>
                <nav class="flex flex-col">
                <a class="nav-link flex xs:hidden sm:hidden mt-5 items-center justify-between w-full h-9 font-semibold hover:text-white " id="management" href="" disabled>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-cog" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                <path d="M6 21v-2a4 4 0 0 1 4 -4h2.5"></path>
                <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                <path d="M19.001 15.5v1.5"></path>
                <path d="M19.001 21v1.5"></path>
                <path d="M22.032 17.25l-1.299 .75"></path>
                <path d="M17.27 20l-1.3 .75"></path>
                <path d="M15.97 17.25l1.3 .75"></path>
                <path d="M20.733 20l1.3 .75"></path>
                </svg>
                <span>Management</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M6 9l6 6l6 -6"></path>
                    </svg>
                </a>

                <nav class="flex-col relative py-2 hidden ml-6" id="nav-user">
                    <a href="/tatsystem/admin/registration.view.php" class="sub-nav-link hover:text-white hover:bg-white/10 text-[20px]">User</a>
                    <a href="/tatsystem/admin/userlogs.view.php" class="sub-nav-link hover:text-white hover:bg-white/10 text-[20px]">User Logs</a>
                </nav>
                <hr class="my-5 xs:hidden sm:hidden">
                <a id="nav-transac" class="nav-link flex xs:hidden sm:hidden items-center justify-between w-full h-9 font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-transform" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M3 6a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                <path d="M21 11v-3a2 2 0 0 0 -2 -2h-6l3 3m0 -6l-3 3"></path>
                <path d="M3 13v3a2 2 0 0 0 2 2h6l-3 -3m0 6l3 -3"></path>
                <path d="M15 18a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                </svg>
                <span>Transaction</span>
            
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M6 9l6 6l6 -6"></path>
                </svg>
            </a>
                <nav id="sub-nav-transac" class="hidden flex-col relative py-2 ml-6">
                    <a href="/tatsystem/pages/qr-generate.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">QR</a>
                    <a href="/tatsystem/pages/patient-details.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient Details</a>
                </nav>
                <hr class="my-5 xs:hidden sm:hidden">
                <a id="nav-report" class="nav-link flex xs:hidden sm:hidden items-center justify-between w-full h-9 font-semibold" href="">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-data" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                    <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                    <path d="M9 17v-4"></path>
                    <path d="M12 17v-1"></path>
                    <path d="M15 17v-2"></path>
                    <path d="M12 17v-1"></path> 
                </svg>
                <span>Reports</span>

                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M6 9l6 6l6 -6"></path>
                </svg>
                </a>
                <nav id="sub-nav-report" class="flex-col relative py-2 ml-6 hidden">
                    <a href="/tatsystem/pages/patient-list.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient Lists</a>
                    <a href="/tatsystem/pages/patient-history.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient History</a>
                    <a href="/tatsystem/pages/tat.summary.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">TAT Summary</a>
                </nav>
                <hr class="my-5 xs:hidden sm:hidden">
                <a class="nav-link flex items-center justify-between w-full h-9 font-semibold" href="/tatsystem/logout.php" id="logout">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
                </svg>
                <span>Logout</span>
                <span></span>
                <span></span>
                </a>
                <!-- <span class="absolute align-bottom">Username</span> -->
            </nav>
            <?php }else if($_SESSION['AccountType'] == 1){?>
                <nav class="flex flex-col">
                <a id="nav-transac" class="nav-link flex xs:hidden sm:hidden items-center justify-between w-full h-9 font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-transform" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M3 6a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                <path d="M21 11v-3a2 2 0 0 0 -2 -2h-6l3 3m0 -6l-3 3"></path>
                <path d="M3 13v3a2 2 0 0 0 2 2h6l-3 -3m0 6l3 -3"></path>
                <path d="M15 18a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                </svg>
                <span>Transaction</span>
            
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M6 9l6 6l6 -6"></path>
                </svg>
            </a>
                <nav id="sub-nav-transac" class="hidden flex-col relative py-2 ml-6">
                    <a href="/tatsystem/pages/qr-generate.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">QR</a>
                    <a href="/tatsystem/pages/patient-details.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient Details</a>
                </nav>
                <hr class="my-5 xs:hidden sm:hidden">
                <a id="nav-report" class="nav-link flex xs:hidden sm:hidden items-center justify-between w-full h-9 font-semibold" href="">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-data" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                    <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                    <path d="M9 17v-4"></path>
                    <path d="M12 17v-1"></path>
                    <path d="M15 17v-2"></path>
                    <path d="M12 17v-1"></path> 
                </svg>
                <span>Reports</span>

                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M6 9l6 6l6 -6"></path>
                </svg>
                </a>
                <nav id="sub-nav-report" class="flex-col relative py-2 ml-6 hidden">
                    <a href="/tatsystem/pages/patient-list.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient Lists</a>
                    <a href="/tatsystem/pages/patient-history.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient History</a>
                    <a href="/tatsystem/pages/tat.summary.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">TAT Summary</a>
                </nav>
                <hr class="my-5 xs:hidden sm:hidden">
                <a class="nav-link flex items-center justify-between w-full h-9 font-semibold" href="/tatsystem/logout.php" id="logout">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
                </svg>
                <span>Logout</span>
                <span></span>
                <span></span>
                </a>
                </nav>
            <?php }else{ ?>
                <?php if($_SESSION['Department'] == 2013 || $_SESSION['Department'] == 2024 || $_SESSION['Department'] == 2038 ){ ?>
                        <nav class="flex flex-col">
                        <a id="nav-transac" class="nav-link flex xs:hidden sm:hidden items-center justify-between w-full h-9 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-transform" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 6a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                        <path d="M21 11v-3a2 2 0 0 0 -2 -2h-6l3 3m0 -6l-3 3"></path>
                        <path d="M3 13v3a2 2 0 0 0 2 2h6l-3 -3m0 6l3 -3"></path>
                        <path d="M15 18a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                        </svg>
                        <span>Transaction</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M6 9l6 6l6 -6"></path>
                        </svg>
                    </a>
                        <nav id="sub-nav-transac" class="hidden flex-col relative py-2 ml-6">
                            <a href="/tatsystem/pages/qr-generate.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">QR</a>
                            <a href="/tatsystem/pages/patient-details.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient Details</a>
                        </nav>
                        <hr class="my-5 xs:hidden sm:hidden">
                        <a id="nav-report" class="nav-link flex xs:hidden sm:hidden items-center justify-between w-full h-9 font-semibold" href="">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-data" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                            <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                            <path d="M9 17v-4"></path>
                            <path d="M12 17v-1"></path>
                            <path d="M15 17v-2"></path>
                            <path d="M12 17v-1"></path> 
                        </svg>
                        <span>Reports</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M6 9l6 6l6 -6"></path>
                        </svg>
                        </a>
                        <nav id="sub-nav-report" class="flex-col relative py-2 ml-6 hidden">
                            <a href="/tatsystem/pages/patient-list.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient Lists</a>
                            <a href="/tatsystem/pages/patient-history.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient History</a>
                            <a href="/tatsystem/pages/tat.summary.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">TAT Summary</a>
                        </nav>
                        <hr class="my-5 xs:hidden sm:hidden">
                        <a class="nav-link flex items-center justify-between w-full h-9 font-semibold" href="/tatsystem/logout.php" id="logout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                        <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
                        </svg>
                        <span>Logout</span>
                        <span></span>
                        <span></span>
                        </a>
                        </nav>
                <?php }else { ?>
                        <nav class="flex flex-col">
                        <a id="nav-report" class="nav-link flex xs:hidden sm:hidden items-center justify-between w-full h-9 font-semibold" href="">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-data" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                            <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                            <path d="M9 17v-4"></path>
                            <path d="M12 17v-1"></path>
                            <path d="M15 17v-2"></path>
                            <path d="M12 17v-1"></path> 
                        </svg>
                        <span>Reports</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M6 9l6 6l6 -6"></path>
                        </svg>
                        </a>
                        <nav id="sub-nav-report" class="flex-col relative py-2 ml-6 hidden">
                            <a href="/tatsystem/pages/patient-list.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient Lists</a>
                            <a href="/tatsystem/pages/patient-history.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient History</a>
                            <a href="/tatsystem/pages/tat.summary.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">TAT Summary</a>
                        </nav>
                        <hr class="my-5 xs:hidden sm:hidden">
                        <a class="nav-link flex items-center justify-between w-full h-9 font-semibold" href="/tatsystem/logout.php" id="logout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                        <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
                        </svg>
                        <span>Logout</span>
                        <span></span>
                        <span></span>
                        </a>
                        </nav>
                    <?php } ?>
            <?php }?>
            <?php } else if($_SESSION['Platform'] == 'M'){ ?>
                <nav>
                <a id="nav-transac" class="nav-link flex items-center justify-between w-full h-9 font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-transform" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M3 6a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                <path d="M21 11v-3a2 2 0 0 0 -2 -2h-6l3 3m0 -6l-3 3"></path>
                <path d="M3 13v3a2 2 0 0 0 2 2h6l-3 -3m0 6l3 -3"></path>
                <path d="M15 18a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                </svg>
                <span>Transaction</span>
            
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M6 9l6 6l6 -6"></path>
                </svg>
            </a>
                <nav id="sub-nav-transac" class="hidden flex-col relative py-2 ml-6">
                    <a href="/tatsystem/pages/qr-scan.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Scan</a>
                </nav>
                <hr class="my-5">
                <a id="nav-report" class="nav-link flex items-center justify-between w-full h-9 font-semibold" href="">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-data" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                    <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                    <path d="M9 17v-4"></path>
                    <path d="M12 17v-1"></path>
                    <path d="M15 17v-2"></path>
                    <path d="M12 17v-1"></path> 
                </svg>
                <span>Reports</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M6 9l6 6l6 -6"></path>
                </svg>
                </a>
                <nav id="sub-nav-report" class="flex-col relative py-2 ml-6 hidden">
                    <a href="/tatsystem/pages/patient-history.mobile.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient History</a>
                </nav>
                <hr class="my-5">
                <a class="nav-link flex items-center justify-between w-full h-9 font-semibold" href="/tatsystem/logout.php" id="logout">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
                </svg>
                <span>Logout</span>
                <span></span>
                <span></span>
                </a>
                <!-- <span class="absolute align-bottom">Username</span> -->
                </nav>
            <?php }else { ?>
                <?php if($_SESSION['AccountType'] == 0) { ?>
                <nav class="flex flex-col">
                <a class="nav-link flex xs:hidden sm:hidden mt-5 items-center justify-between w-full h-9 font-semibold hover:text-white " id="management" href="" disabled>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-cog" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                <path d="M6 21v-2a4 4 0 0 1 4 -4h2.5"></path>
                <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                <path d="M19.001 15.5v1.5"></path>
                <path d="M19.001 21v1.5"></path>
                <path d="M22.032 17.25l-1.299 .75"></path>
                <path d="M17.27 20l-1.3 .75"></path>
                <path d="M15.97 17.25l1.3 .75"></path>
                <path d="M20.733 20l1.3 .75"></path>
                </svg>
                <span>Management</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M6 9l6 6l6 -6"></path>
                    </svg>
                </a>

                <nav class="flex-col relative py-2 hidden ml-6" id="nav-user">
                    <a href="/tatsystem/admin/registration.view.php" class="sub-nav-link hover:text-white hover:bg-white/10 text-[20px]">User</a>
                    <a href="/tatsystem/admin/userlogs.view.php" class="sub-nav-link hover:text-white hover:bg-white/10 text-[20px]">User Logs</a>
                </nav>
                <hr class="my-5 xs:hidden sm:hidden">
                <a id="nav-transac" class="nav-link flex xs:hidden sm:hidden items-center justify-between w-full h-9 font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-transform" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M3 6a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                <path d="M21 11v-3a2 2 0 0 0 -2 -2h-6l3 3m0 -6l-3 3"></path>
                <path d="M3 13v3a2 2 0 0 0 2 2h6l-3 -3m0 6l3 -3"></path>
                <path d="M15 18a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                </svg>
                <span>Transaction</span>
            
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M6 9l6 6l6 -6"></path>
                </svg>
            </a>
                <nav id="sub-nav-transac" class="hidden flex-col relative py-2 ml-6">
                    <a href="/tatsystem/pages/qr-generate.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">QR</a>
                    <a href="/tatsystem/pages/patient-details.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient Details</a>
                </nav>
                <hr class="my-5 xs:hidden sm:hidden">
                <a id="nav-report" class="nav-link flex xs:hidden sm:hidden items-center justify-between w-full h-9 font-semibold" href="">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-data" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                    <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                    <path d="M9 17v-4"></path>
                    <path d="M12 17v-1"></path>
                    <path d="M15 17v-2"></path>
                    <path d="M12 17v-1"></path> 
                </svg>
                <span>Reports</span>

                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M6 9l6 6l6 -6"></path>
                </svg>
                </a>
                <nav id="sub-nav-report" class="flex-col relative py-2 ml-6 hidden">
                    <a href="/tatsystem/pages/patient-list.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient Lists</a>
                    <a href="/tatsystem/pages/patient-history.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient History</a>
                    <a href="/tatsystem/pages/tat.summary.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">TAT Summary</a>
                </nav>
                <hr class="my-5 xs:hidden sm:hidden">
                <a class="nav-link flex items-center justify-between w-full h-9 font-semibold" href="/tatsystem/logout.php" id="logout">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
                </svg>
                <span>Logout</span>
                <span></span>
                <span></span>
                </a>
            </nav>
            <?php }else if($_SESSION['AccountType'] == 1){?>
                <nav class="flex flex-col">
                <a id="nav-transac" class="nav-link flex xs:hidden sm:hidden items-center justify-between w-full h-9 font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-transform" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M3 6a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                <path d="M21 11v-3a2 2 0 0 0 -2 -2h-6l3 3m0 -6l-3 3"></path>
                <path d="M3 13v3a2 2 0 0 0 2 2h6l-3 -3m0 6l3 -3"></path>
                <path d="M15 18a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                </svg>
                <span>Transaction</span>
            
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M6 9l6 6l6 -6"></path>
                </svg>
            </a>
                <nav id="sub-nav-transac" class="hidden flex-col relative py-2 ml-6">
                    <a href="/tatsystem/pages/qr-generate.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">QR</a>
                    <a href="/tatsystem/pages/patient-details.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient Details</a>
                </nav>
                <hr class="my-5 xs:hidden sm:hidden">
                <a id="nav-report" class="nav-link flex xs:hidden sm:hidden items-center justify-between w-full h-9 font-semibold" href="">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-data" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                    <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                    <path d="M9 17v-4"></path>
                    <path d="M12 17v-1"></path>
                    <path d="M15 17v-2"></path>
                    <path d="M12 17v-1"></path> 
                </svg>
                <span>Reports</span>

                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M6 9l6 6l6 -6"></path>
                </svg>
                </a>
                <nav id="sub-nav-report" class="flex-col relative py-2 ml-6 hidden">
                    <a href="/tatsystem/pages/patient-list.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient Lists</a>
                    <a href="/tatsystem/pages/patient-history.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient History</a>
                    <a href="/tatsystem/pages/tat.summary.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">TAT Summary</a>
                </nav>
                <hr class="my-5 xs:hidden sm:hidden">
                <a class="nav-link flex items-center justify-between w-full h-9 font-semibold" href="/tatsystem/logout.php" id="logout">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
                </svg>
                <span>Logout</span>
                <span></span>
                <span></span>
                </a>
            </nav>
            <?php }else{ ?>
                <nav class="flex flex-col">
                <a id="nav-transac" class="nav-link flex xs:hidden sm:hidden items-center justify-between w-full h-9 font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-transform" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M3 6a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                <path d="M21 11v-3a2 2 0 0 0 -2 -2h-6l3 3m0 -6l-3 3"></path>
                <path d="M3 13v3a2 2 0 0 0 2 2h6l-3 -3m0 6l3 -3"></path>
                <path d="M15 18a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                </svg>
                <span>Transaction</span>
            
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M6 9l6 6l6 -6"></path>
                </svg>
                </a>
                <nav id="sub-nav-transac" class="hidden flex-col relative py-2 ml-6">
                    <a href="/tatsystem/pages/qr-generate.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">QR</a>
                    <a href="/tatsystem/pages/qr-scan.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Scan</a>
                    <a href="/tatsystem/pages/patient-details.php" class="sub-nav-link text-[20px] hover:text-white hover:bg-white/10">Patient Details</a>
                </nav>
            </nav>
            <hr class="my-5 xs:hidden sm:hidden">
                <nav class="flex flex-col">
                <a class="nav-link flex items-center justify-between w-full h-9 font-semibold" href="/tatsystem/logout.php" id="logout">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
                </svg>
                <span>Logout</span>
                <span></span>
                <span></span>
                </a>
            </nav>
                <?php } ?>
            <?php }?>
        </div>
    </div>

    <!-- modal for logout confirmation -->
    <div class="fixed h-full inset-0 z-20 bg-black bg-opacity-80 hidden justify-center items-center xs-sm:w-full xs-sm:h-full" id="logout-modal">
        <div class="">
            <div class="bg-white rounded shadow-lg w-[300px] h-[150px]">
                <!-- Modal header -->
                <div class="border-b-2 px-3 py-5 border-black flex flex-row justify-center items-center">
                    <h3 class="text-[15px] text-black font-semibold">Are you sure you want to logout?</h3>
                </div>
                <!-- modal body -->
                <div class="xs-md:flex flex xs-md:justify-center justify-center xs-md:items-center items-center mt-5">
                    <button name="submit" id="btn-cancel-logout" class="btn-cancel-logout my-2 py-2 mx-2 xs:w-32 sm:w-48 w-32 bg-transparent border border-black text-black text-sm uppercase font-bold rounded-lg shadow-2xl hover:text-white hover:bg-red-500">Cancel</button>
                    <button name="submit" id="btn-confirm-logout" class="btn-confirm-logout my-2 py-2 mx-2 xs:w-32 sm:w-48 w-32 bg-transparent border border-black text-black text-sm uppercase font-bold rounded-lg shadow-2xl hover:text-white hover:bg-blue-400">Yes</button>
                </div>
            </div>
        </div>
    </div>  
    
<script type="text/javascript" src="/tatsystem/assets/js/sidebar.js" defer></script>
 