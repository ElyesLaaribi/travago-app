<?php
session_start();
require 'config/connect.php';

// check if already logged in
echo $_SESSION['USER'];
if (isset($_SESSION['USER']['id'])) {
    header("Location: /home");
} else {

    if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
        $error = "";
        if (
            empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) ||
            empty($_POST['phone']) || empty($_POST['passport_number'] || empty($_POST['company_id']))
        ) {
            $error = "Please provide your credentials";
        } else {

            try {
                $user = $_POST['username'];
                $email = $_POST['email'];
                $pass = $_POST['password'];
                $phone = $_POST['phone'];
                $passport_number = $_POST['passport_number'];
                $user_type = 'user';
                // convert to number
                $company_id = (int) $_POST['company_id'];
                $isVerified = 0;
                //encrypt password
                $pass = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));

                //Check if username exists
                $sql = "SELECT COUNT(username) AS num FROM users WHERE email = :email";
                $stmt = $pdo->prepare($sql);

                $stmt->bindValue(':email', $email);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row['num'] > 0) {
                    $error = "Email already exists";
                } else {

                    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, phone, user_type, company_id, isVerified) 
                    VALUES (:username,:email, :password, :phone, :user_type, :company_id, :isVerified)");
                    $stmt->bindParam(':username', $user);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $pass);
                    $stmt->bindParam(':phone', $phone);
                    $stmt->bindParam(':user_type', $user_type);
                    $stmt->bindParam(':company_id', $company_id);
                    $stmt->bindParam(':isVerified', $isVerified);

                    if ($stmt->execute()) {
                        echo '<script>alert("New account created.")</script>';
                        //redirect to another page
                        echo '<script>window.location.replace("/travago/login")</script>';
                    } else {
                        $error = "Error creating account";
                    }
                }
            } catch (PDOException $e) {
                $error = "Error: " . $e->getMessage();
                echo '<script type="text/javascript">alert("' . $error . '");</script>';
            }
        }
    }
    // get companies
    try {
        $stmt = $pdo->prepare("SELECT * FROM companies");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "" . $e->getMessage();
        echo "" . $error . "";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles/output.css" rel="stylesheet">
    <style>
        .background {
            height: 100vh;
            background: url('https://tailwindui.com/img/ecommerce-images/category-page-01-image-card-02.jpg') no-repeat;
            background-size: 50% 100%;
            position: fixed;
        }
    </style>
    <title>Register as an agency</title>
</head>

<body>
    <div class="flex h-full relative">
        <div class="hidden lg:flex w-full background">
        </div>
        <div
            class="absolute w-full lg:w-1/2 right-0 flex min-h-full flex-col items-center justify-center px-4 py-12 lg:px-8">

            <div class=" w-full  sm:mx-auto sm:w-full sm:max-w-sm">
                <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                    alt="Your Company">


                <div class="border-b border-gray-200 dark:border-gray-700">
                    <ul
                        class="flex justify-center -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                        <li class="me-2 w-full">
                            <a href="/travago/register/customer" <?php
                            if (strpos($_SERVER['REQUEST_URI'], '/register/customer') !== true) {
                                echo 'class="inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group" aria-current="page"';
                            } else {
                                echo 'class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group"';
                            } ?>>
                                <svg <?php
                                if (strpos($_SERVER['REQUEST_URI'], '/register/customer') !== false) {
                                    echo "class='w-4 h-4 me-2 text-blue-600 dark:text-blue-500'";
                                } else {
                                    echo "class='w-4 h-4 me-2 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300'";
                                } ?> aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
                                </svg>Customer
                            </a>
                        </li>
                        <li class="me-2 w-full">
                            <a href="/travago/register/agency" <?php
                            if (strpos($_SERVER['REQUEST_URI'], '/travago/register/agency') !== false) {
                                echo 'class="inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group" aria-current="page"';
                            } else {
                                echo 'class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group"';
                            } ?> aria-current="page">
                                <svg <?php
                                if (strpos($_SERVER['REQUEST_URI'], '/travago+/register/agency') !== false) {
                                    echo "class='w-4 h-4 me-2 text-blue-600 dark:text-blue-500'";
                                } else {
                                    echo "class='w-4 h-4 me-2 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300'";
                                } ?> aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                    <path
                                        d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                                </svg>Agency
                            </a>
                        </li>
                    </ul>
                </div>

                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Create a user
                    account</h2>
            </div>

            <p class="sm:mx-auto sm:w-full sm:max-w-sm text-xs mt-10">
                By creating this account, you'll gain access to exclusive trip offers, personalized recommendations, and
                exciting updates on upcoming adventures. Get ready to embark on unforgettable journeys with us!</a>
            </p>

            <div class="w-full mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <?php if ($error) { ?>
                    <p class="text-red-500 text-center">
                        <?php echo $error; ?>
                    </p>
                <?php } ?>
                <form class="w-full space-y-4" action="/travago/register/customer" method="post">
                    <div>
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Full
                            name</label>
                        <div class="mt-2">
                            <input id="username" name="username" type="text" autocomplete="username"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                            address</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password"
                                class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        </div>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Phone
                            number</label>
                        <div class="mt-2">
                            <input id="phone" name="phone" type="phone" autocomplete="phone"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <label for="passport_number" class="block text-sm font-medium leading-6 text-gray-900">Passport
                            number</label>
                        <div class="mt-2">
                            <input id="passport_number" name="passport_number" type="passport_number"
                                autocomplete="passport_number"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="w-full sm:col-span-3">
                        <label for="company_id"
                            class="block text-sm font-medium leading-6 text-gray-900">Company</label>
                        <div class="mt-2">
                            <select id="company_id" name="company_id" autocomplete="company_id"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                <option value="">Select a company</option>
                                <?php
                                if (count($users) == 0) {
                                    echo "<option value=''>No companies found</option>";
                                } else {
                                    foreach ($users as $row) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Sign up
                        </button>
                    </div>
                </form>

                <p class="mt-10 text-center text-sm text-gray-500">
                    Already have an account?
                    <a href="/travago/login" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">
                        Login</a>
                </p>
            </div>
        </div>
    </div>

</body>

</html>