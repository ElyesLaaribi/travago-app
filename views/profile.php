<?php
session_start();
require 'config/connect.php';

if ($_SESSION['USER']['user_type'] != 'user') {
    require 'utils/menu-bar.php';
}
// Get the user ID from the session
$userId = $_SESSION['USER']['id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Read form data

    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Update user information in the database
    try {
        $sql = "UPDATE users SET username=:username, email=:email, address=:address, phone=:phone WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':id', $userId);
        $stmt->execute();
        // Fetch the updated user information
        $sql = "SELECT * FROM users WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $userId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<script>alert('Success')</script>";
        $_SESSION['USER'] = $user;
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
        echo "<p class='absolute w-full mx-auto text-center text-red-500'>
        $error
    </p>";
    }
} else {
    // If the form is not submitted, fetch the user data
    try {
        $sql = "SELECT * FROM users WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $userId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
        echo "<p class='absolute w-full mx-auto text-center text-red-500'>
        $error
    </p>";
    }
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/output.css" rel="stylesheet">
    <title>My profile</title>
</head>

<body>
    <header class="bg-white shadow">
        <div class="flex mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 space-x-4">
            <a href="/travago/home" class="text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-8 h-8 text-gray">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
               My profile
            </h1>
        </div>
    </header>
    <div class="flex flex-row items-center justify-center px-6 w-full my-2">

        <form action="/travago/profile" method="POST">
            <!-- <div class="space-y-2 lg:w-1/2 mx-auto"> -->
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-4">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Profile</h2>
                    <p class=" text-sm leading-6 text-gray-600">This information will be displayed publicly so be
                        careful what you share.</p>

                    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">

                        <!-- username -->
                        <div class="sm:col-span-4">
                            <label for="username"
                                class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                            <div class="mt-2">
                                <div
                                    class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                    <span
                                        class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">travago.com/</span>
                                    <input type="text" name="username" id="username" autocomplete="username"
                                        class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                        placeholder="janesmith" value="<?php echo $user['username']; ?>">
                                </div>
                                <p class="absolute w-full mx-auto text-center text-red-500">
                                    <?php echo $error['username']; ?>
                                </p>
                            </div>
                        </div>

                        <!-- <div class="col-span-full">
                            <label for="about" class="block text-sm font-medium leading-6 text-gray-900">About</label>
                            <div class="mt-2">
                                <textarea id="about" name="about" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about yourself.</p>
                        </div> -->

                    </div>
                </div>

                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>

                    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"> <!-- email -->
                        <div class="sm:col-span-3">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                                address</label>
                            <div class="mt-2">
                                <input value="<?php echo $user['email']; ?>" id="email" name="email" type="email"
                                    autocomplete="email"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <!-- address -->
                        <div class="sm:col-span-3">
                            <label for="address"
                                class="block text-sm font-medium leading-6 text-gray-900">Address</label>
                            <div class="mt-2">
                                <input value="<?php echo $user['address'] ?>" type="text" name="address" id="address"
                                    autocomplete="address"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="sm:col-span-3">
                            <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Phone
                                number</label>
                            <div class="mt-2">
                                <input value="<?php echo $user['phone'] ?>" type="text" name="phone" id="phone"
                                    autocomplete="phone"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <!-- role -->
                        <div class="sm:col-span-3">
                            <label for="role" class="block text-sm font-medium leading-6 text-gray-900">Role</label>
                            <div class="mt-2">
                                <input value="<?php echo $user['user_type'] ?>" type="text" name="role" id="role"
                                    autocomplete="role" disabled
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <!-- isVerfied -->
                        <!-- <div class="sm:col-span-3">
                            <label for="isVerfied"
                                class="block text-sm font-medium leading-6 text-gray-900">Active</label>
                            <div class="mt-2">
                                <input checked="<?php echo $user['isVerfied'] ?>" type="checkbox" name="role" id="role"
                                    autocomplete="role">
                            </div>
                        </div> -->

                        <div class="sm:col-span-3">
                            <label for="role" class="block text-sm font-medium leading-6 text-gray-900">User
                                since</label>
                            <div class="mt-2">
                                <input value="<?php
                                $date = $user['created_at'];
                                $date = explode(" ", $date);
                                echo $date[0];
                                ?>" type="text" name="role" id="role" autocomplete="role" disabled
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="sm:col-span-6 w-full mt-6 flex items-center justify-center gap-x-6">
                            <button type="button"
                                class="w-full text-sm font-semibold leading-6 text-gray-900 px-3 py-2">
                                <a href="/travago/home">
                                    Cancel
                                </a>
                            </button>
                            <button type="submit"
                                class="w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm 
                                hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save
                            </button>
                        </div>
                    </div>
        </form>
    </div>

</body>

</html>