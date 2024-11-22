<?php
// Start the session
session_start();
require 'config/connect.php';

// check if already logged in
if (isset($_SESSION['USER']['id'])) {
    header("Location: /home");
} else {

    // checks if the server request is sent
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // if no credentials
        $error = "";
        $success = "";
        if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
            $error = "Please provide your credentials";
        } else {
            // read credentials and check it in database
            try {
                $email = $_POST['email'];
                $pass = $_POST['password'];
                $confirm_pass = $_POST['confirm_password'];

                //search for user by email
                $sql = "SELECT * from users WHERE email=:email";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':email', $email);
                $stmt->execute();
                $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($userExists) {
                    $verifyPassword = $pass == $confirm_pass;
                    if ($verifyPassword) {
                        $sql = "UPDATE users SET password=:password WHERE email=:email";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindValue(':password', password_hash($pass, PASSWORD_DEFAULT));
                        $stmt->bindValue(':email', $email);
                        $stmt->execute();

                        $success = "Password updated successfully";
                    } else {
                        // password false
                        $error = "Password does not match";
                    }
                } else {
                    $error = "Email dosen't exist</p>";
                }
            } catch (PDOException $e) {
                $error = "Error: " . $e->getMessage();
                echo '<script type="text/javascript">alert("' . $error . '");</script>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/output.css" rel="stylesheet">
    <style>
        .background {
            height: 100vh;
            background-image: url('https://tailwindui.com/img/ecommerce-images/category-page-01-image-card-01.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
    <title>Login</title>
</head>

<body>
    <div class="flex justify-start h-full max-h-full">
        <div class="hidden lg:flex w-full background">
        </div>
        <div class="flex flex-col items-center justify-center w-full min-h-full px-6 py-12 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                    alt="Your Company">
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Reset your
                    password</h2>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <?php if ($error) { ?>
                    <p class="text-red-500 text-center">
                        <?php echo $error; ?>
                    </p>
                <?php } ?>
                <?php if ($success) { ?>
                    <p class="text-green-500 text-center">
                        <?php echo $success; ?>
                    </p>
                <?php } ?>

                <form class="space-y-6" action="/travago/reset-password" method="POST">

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
                            <div class="text-sm">
                            </div>
                        </div>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="confirm_password"
                                class="block text-sm font-medium leading-6 text-gray-900">Confirm password</label>
                            <div class="text-sm">
                            </div>
                        </div>
                        <div class="mt-2">
                            <input id="confirm_password" name="confirm_password" type="password"
                                autocomplete="current-password"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save
                            password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>