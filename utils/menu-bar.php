<?php
session_start();
$user = $_SESSION['USER'];
$role = $user['user_type'];
$name = $user['username'];
$companyName = $user['company_name'];
$email = $user['email'];

$path = $_SERVER['REQUEST_URI'];
$title = basename($path);
$title = ucfirst($title);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/travago/styles/output.css" rel="stylesheet">
    <title>
        <?php
        echo $title;
        ?>
    </title>
</head>

<body>
    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <a href="/travago/home">
                            <div class="flex-shrink-0 flex items-center gap-2">
                                <img class="h-8 w-8"
                                    src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                                    alt="Your Company">
                                <p>
                                    <a href="/travago/home" class="text-white font-semibold">
                                        <?php echo $companyName; ?>
                                    </a><!--TODO company name-->
                                </p>
                            </div>
                        </a>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <?php
                                $menu = [
                                    "Dashboard" => "/travago/agency",
                                    "Trips" => "/travago/agency/trips",
                                    "Circuits" => "/travago/agency/circuits",
                                    "Vehicles" => "/travago/agency/vehicles",
                                    "Customers" => "/travago/agency/customers"
                                ];
                                foreach ($menu as $key => $value) {
                                    $active = ($title == $key) || $title == 'Agency' && $key == "Dashboard" ? "bg-gray-900 text-white" : "text-gray-300 hover:bg-gray-700 hover:text-white";
                                    echo "<a href='$value' class=' $active block rounded-md px-3 py-2 text-base font-medium'>$key</a>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- Desktop menu -->
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <div>
                                <p class="capitalize text-white font-semibold">
                                    <?php
                                    echo $role;
                                    ?>
                                </p>
                            </div>
                            <!-- Profile dropdown -->
                            <div class="relative ml-3">
                                <div>
                                    <button type="button" onclick="toggleMenu()"
                                        class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                        id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="absolute -inset-1.5"></span>
                                        <span class="sr-only">Open user menu</span>
                                        <img class="h-8 w-8 rounded-full"
                                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                            alt="">
                                    </button>
                                </div>

                                <div id="travago-dropdown-menu"
                                    class=" hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                    tabindex="-1">
                                    <!-- Active: "bg-gray-100", Not Active: "" -->
                                    <a href="/travago/profile" class="block px-4 py-2 text-sm text-gray-700"
                                        role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                                    <a href="/travago/utils/logout.php" class="block px-4 py-2 text-sm text-gray-700"
                                        role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="-mr-2 flex items-center space-x-4 md:hidden">
                        <p class="text-white font-semibold capitalize">
                            <?php
                            echo $role;
                            ?>
                        </p>
                        <!-- Mobile menu button -->
                        <button type="button" onclick='toggleMenu()'
                            class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="absolute -inset-0.5"></span>
                            <span class="sr-only">Open main menu</span>
                            <!-- Menu open: "hidden", Menu closed: "block" -->
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <!-- Menu open: "block", Menu closed: "hidden" -->
                            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="hidden md:hidden" id="travago-dropdown-menu-mobile">
                <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <?php
                    foreach ($menu as $key => $value) {
                        $active = $title == $key ? "bg-gray-900 text-white" : "text-gray-300 hover:bg-gray-700 hover:text-white";
                        echo "<a href='$value' class=' $active block rounded-md px-3 py-2 text-base font-medium'>$key</a>";
                    }
                    ?>
                </div>
                <div class="border-t border-gray-700 pb-3 pt-4">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full"
                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt="">
                        </div>
                        <div class="ml-3 space-y-2">
                            <div class="text-base font-medium leading-none text-white">
                                <?php
                                echo $name;
                                ?>
                            </div>
                            <div class="text-sm font-medium leading-none text-gray-400">
                                <?php
                                echo $email;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1 px-2">
                        <a href="profile"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Your
                            Profile</a>
                        <a href="/login"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Sign
                            out</a>
                    </div>
                </div>
            </div>
        </nav>
        <main>
        </main>
    </div>
    <script>
        function toggleMenu() {
            const menu = document.getElementById("travago-dropdown-menu");
            const mobileMenu = document.getElementById("travago-dropdown-menu-mobile");
            if (menu.classList.contains("hidden") || menu.classList.contains("hidden")) {
                menu.classList.remove('hidden');
                mobileMenu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden')
                mobileMenu.classList.add('hidden')
            }
        }
    </script>
</body>

</html>