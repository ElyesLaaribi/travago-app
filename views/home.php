<?php
// Start the session
session_start();
require 'config/connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/output.css" rel="stylesheet">
    <link rel="shortcut icon" href="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
        type="image/x-icon" />
    <title>TravaGo</title>
</head>

<body>
    <div class="bg-white">
        <!-- Cover image -->
        <img class="w-full h-full fixed opacity-[80%]" src="./public/travago-cover.png" alt="banner">
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <!-- Logo -->
                <div class="flex lg:flex-1">
                    <a href="/travago/home" class="-m-1.5 p-1.5 flex  
                    ">
                        <span class="sr-only">Your Agency</span>
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                            alt="logo">
                        <!-- if user is connected, show profile link else show nothing-->
                        <!-- Company name -->
                        <?php
                        if (isset($_SESSION['USER']) && isset($_SESSION['USER']['id'])) {
                            $companyId = $_SESSION['USER']['company_id'];
                            // get company name
                            $sql = "SELECT * from companies WHERE id=:id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindValue(':id', $companyId);
                            $stmt->execute();
                            $company = $stmt->fetch(PDO::FETCH_ASSOC);
                            $companyName = $company['name'];

                            if ($_SESSION['USER']['user_type'] !== 'user') {
                                echo ("<a href='/travago/agency'
                                style='color: #000668;font-weight: bold;display:flex;align-items:center;gap:0.5rem;'
                                >$companyName
                                </a>");
                            } else if (isset($_SESSION['USER']['username'])) {
                                echo ("<a href='/travago/trips'
                                style='color: #000668;font-weight: bold;display:flex;align-items:center;gap:0.5rem;'
                                >$companyName
                                </a>");
                            }

                        } else {
                            echo ("<a href='/travago/home'
                            style='color: #000668;font-weight: bold;display:flex;align-items:center;gap:0.5rem;'
                            >TravaGo
                            </a>");

                        }
                        ?>

                    </a>
                </div>
                <!-- Desktop menu -->
                <div class="flex lg:hidden">
                    <button type="button"
                        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700"
                        onclick="toggleMenu()">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                    <a href="/travago/trips" class="text-sm font-semibold leading-6 text-gray-900">Trips</a>
                    <?php
                    if (isset($_SESSION['USER']) && $_SESSION['USER']['user_type'] !== 'user') {

                        echo "<a href='/travago/agency' class='text-sm font-semibold leading-6 text-gray-900'>Agency</a>";
                    }
                    ?>
                    <a href="/travago/about" class="text-sm font-semibold leading-6 text-gray-900">About us</a>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    <?php
                    $username = $_SESSION['USER']['username'];
                    if (isset($_SESSION['USER']['username'])) {
                        echo ("<a href='/travago/profile' 
                                    style='color: #000668;font-weight: bold;display:flex;align-items:center;gap:0.5rem;'
                                    >Connected as $username
                                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-6 h-6'>
                                    <path stroke-linecap='round' stroke-linejoin='round' d='M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z' />
                                    </svg>
                                    </a>");
                        //disconnect button
                        echo ("<a href='/travago/utils/logout.php' class='mx-3 block rounded-lg px-2 py-2 text-base font-semibold leading-7 text-red-500'>
                                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-6 h-6'>
                                    <path stroke-linecap='round' stroke-linejoin='round' d='M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15' />
                                    </svg>
                                    </a>");
                    } else {
                        echo ("<a href='/travago/login' class='-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50'>Log in</a>");
                    }
                    ?>
                </div>
            </nav>
            <!-- Mobile menu, show/hide based on menu open state. -->

            <div id="travago-mobile-menu" class="hidden lg:hidden" role="dialog" aria-modal="true">
                <!-- Background backdrop, show/hide based on slide-over state. -->
                <div class="fixed inset-0 z-50"></div>
                <div
                    class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                    <div class="flex items-center justify-between">
                        <a href="/travago" class="-m-1.5 p-1.5">
                            <span class="sr-only">Your Agency</span>
                            <img class="h-8 w-auto"
                                src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
                        </a>
                        <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" onclick="toggleMenu()">
                            <span class="sr-only">Close menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-gray-500/10">
                            <div class="space-y-2 py-6">
                                <a href="/travago/trips"
                                    class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Trips</a>
                                <?php
                                if (isset($_SESSION['USER']) && $_SESSION['USER']['user_type'] !== 'user') {

                                    echo "<a href='/travago/agency' class='-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50'>Agency</a>";
                                } ?> <a href="/travago/about"
                                    class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">About
                                    us</a>
                            </div>
                            <div class="py-6">
                                <?php
                                $username = $_SESSION['USER']['username'];
                                if (isset($_SESSION['USER']['username'])) {
                                    echo ("<a href='/travago/profile' 
                                    style='color: #000668;font-weight: bold;display:flex;align-items:center;gap:0.5rem;'
                                    >Connected as $username
                                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-6 h-6'>
                                    <path stroke-linecap='round' stroke-linejoin='round' d='M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z' />
                                    </svg>
                                    </a>");
                                } else {
                                    echo ("<a href='/travago/login' class='-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50'>Log in</a>");
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>

        <div class="relative isolate px-6 pt-14 lg:px-8">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
                aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
            <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Travel Made Simple</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-800">Unleash the Power of Travel: Simplify, Streamline,
                        Succeed</p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <?php
                        if (!isset($_SESSION['USER']['username'])) {
                            echo "<a href='/travago/register/customer' 
                            class='rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'
                            >Get started</a>";
                        } else {
                            echo "<a href='/travago/trips' 
                            class='rounded-md px-2 py-2.5 text-2xl font-semibold text-indigo-700 shadow-sm 
                            hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 
'                            >Welcome to $companyName<br>
                                Reserve a Trip";
                        }
                        ?>

                    </div>
                </div>
            </div>
            <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
                aria-hidden="true">
                <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
        </div>
    </div>
    <script>
        // unhide mobile menu
        function toggleMenu() {
            const menu = document.getElementById('travago-mobile-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        }
    </script>
    <?php
    ?>
</body>

</html>