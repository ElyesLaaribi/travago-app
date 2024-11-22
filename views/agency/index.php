<?php
session_start();
require 'config/auth.php';
require 'config/connect.php';
require 'utils/menu-bar.php';

$user = $_SESSION['USER'];

$company_id = $user['company_id'];
$role = $user['user_type'];

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/output.css" rel="stylesheet">
    <title>My Agency</title>
</head>

<body>
    <header class="bg-white shadow border-b">
        <div class="flex mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 space-x-4">
            <a href="/travago/home" class="text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-8 h-8 text-gray">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                Dashboard
            </h1>
        </div>
    </header>
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <dl class="grid grid-cols-1 lg:grid lg:grid-cols-4 gap-x-8 gap-y-16 text-center">
                <?php
                if ($role == 'admin') {
                    try {
                        $sql = "SELECT COUNT(id) AS num FROM companies WHERE name != 'Travago'";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $agencyCount = $stmt->fetch(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    echo "<div class='mx-auto flex max-w-xs flex-col gap-y-4'>
                        <dt class='text-base leading-7 text-gray-600'>
                            Total Companies
                        </dt>
                        <dd class='order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl'>";
                    echo $agencyCount['num'] . ' agencies';
                    echo "</dd></div>";
                }
                ?>
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                    <dt class="text-base leading-7 text-gray-600">Total Users</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                        <?php
                        if ($role == 'admin') {

                            try {
                                $sql = "SELECT * FROM users WHERE user_type='agency' OR user_type='user'";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                echo $stmt->rowCount() . ' users';
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                        } else {
                            try {
                                $sql = "SELECT * FROM users WHERE company_id = $company_id AND user_type='user'";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                echo $stmt->rowCount() . ' users';
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                        }

                        ?>
                    <dt class="text-base leading-7 text-gray-600">
                        <!-- in which how many admin and how many customers -->
                        <?php
                        if ($role == 'admin') {
                            $adminCount = 0;
                            $customerCount = 0;
                            foreach ($users as $user) {
                                if ($user['user_type'] == 'agency') {
                                    $adminCount++;
                                } else if ($user['user_type'] == 'user') {
                                    $customerCount++;
                                }
                            }
                            echo $adminCount . ' agencies and ' . $customerCount . ' customers';
                        } else {
                            $customerCount = 0;
                            foreach ($users as $user) {
                                if ($user['user_type'] == 'user') {
                                    $customerCount++;
                                }
                            }
                            echo $customerCount . ' customers';
                        }

                        ?>
                    </dt>
                    </dd>

                </div>
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                    <dt class="text-base leading-7 text-gray-600">Total trips</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                        <?php
                        try {
                            $sql = "SELECT COUNT(id) AS num FROM trips WHERE company_id = $company_id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $tripCount = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $tripCount['num'] . ' trips';
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </dd>
                </div>
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                    <dt class="text-base leading-7 text-gray-600">Total circuits</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                        <?php
                        try {
                            $sql = "SELECT COUNT(id) AS num FROM tours WHERE company_id = $company_id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $circuitCount = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $circuitCount['num'] . ' circuits';
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </dd>
                </div>
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                    <dt class="text-base leading-7 text-gray-600">Total vehicles</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                        <?php
                        try {
                            $sql = "SELECT * FROM vehicles WHERE company_id = $company_id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            echo $stmt->rowCount() . ' vehicles';
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        } ?>
                    <dt class="text-base leading-7 text-gray-600">
                        <?php
                        // available vehicles
                        $availableVehicles = 0;
                        foreach ($vehicles as $vehicle) {
                            if ($vehicle['availability'] == true) {
                                $availableVehicles++;
                            }
                        }
                        echo $availableVehicles . ' available vehicles';

                        ?>
                    </dt>
                    </dd>
                </div>
            </dl>
        </div>
    </div>

</body>

</html>