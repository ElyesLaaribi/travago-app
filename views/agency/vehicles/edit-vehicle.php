<?php
require 'config/auth.php';
require 'config/connect.php';
require 'utils/menu-bar.php';

$user = $_SESSION['USER'];
$company_id = $user['company_id'];
// Get the vehicle id from the URL
$id = $_GET['vehicleId'];

$erreurs = array();
if (isset($_POST['submit'])) {
    $brand = $_POST['brand'];
    if (empty($brand)) {
        $erreurs[] = "Brand cannot be empty.";
    }

    $model = $_POST['model'];
    if (empty($model)) {
        $erreurs[] = "Model cannot be empty";
    }

    $number_of_seats = $_POST['number_of_seats'];
    if (!is_numeric($number_of_seats) || $number_of_seats <= 0) {
        $erreurs[] = "Number of seats must be a positive integer.";
    }

    $plate_number = $_POST['plate_number'];
    if (!is_numeric($plate_number) || $plate_number <= 0) {
        $erreurs[] = "Plate number must be a positive integer.";
    } else {
        // errors
        if (empty($erreurs)) {
            try {
                $stmt = $pdo->prepare("UPDATE vehicles 
                SET brand = :brand, 
                model = :model, 
                number_of_seats = :number_of_seats, 
                plate_number = :plate_number WHERE id = :id");

                $stmt->bindParam(':brand', $brand);
                $stmt->bindParam(':model', $model);
                $stmt->bindParam(':number_of_seats', $number_of_seats);
                $stmt->bindParam(':plate_number', $plate_number);
                $stmt->bindParam(':id', $id);

                $stmt->execute();
                echo "<script>alert('Vehicle modified successfully!')</script>";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}

// Get the vehicles from the database
try {
    $stmt = $pdo->prepare("SELECT * FROM vehicles WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <title>Edit vehicle</title>
</head>

<body>
    <header class="bg-white shadow">
        <div class="flex mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 space-x-4">
            <a href="/travago/agency/vehicles" class="text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-8 h-8 text-gray">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                Edit vehicle N°
                <?php echo $vehicle['id']; ?>
            </h1>
        </div>
    </header>
    <div class="flex flex-col items-center justify-center w-full lg:w-1/3 mx-auto ">

        <form action="/travago/agency/vehicles/edit-vehicle?vehicleId=<?php echo $id; ?>" method="post"
            class="w-full px-2">
            <div class="space-y-2">
                <div class="w-full border-b border-gray-900/10 pb-8">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Edit vehicle</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Edit informations about the vehicle.</p>

                    <?php
                    if (!empty($erreurs)) {
                        echo "<div class='flex flex-col'><br>";
                        foreach ($erreurs as $erreur) {
                            echo "<p class='text-sm text-red-500'>- $erreur<br> </p>";
                        }
                        echo "</div>";
                    }
                    ?>

                    <div class="w-full mt-10 grid grid-cols-1 gap-x-2 gap-y-4 lg:gap-x-4 lg:gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-full">
                            <label for="brand" class="block text-sm font-medium leading-6 text-gray-900">brand</label>
                            <div class="mt-2">
                                <input type="text" name="brand" value="<?php echo $vehicle['brand']; ?>"
                                    value="<?php echo $vehicle['brand']; ?>"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="sm:col-span-full">
                            <label for="model" class="block text-sm font-medium leading-6 text-gray-900">Model:</label>
                            <div class="mt-2">
                                <input name="model" type="text" value="<?php echo $vehicle['model']; ?>"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="sm:col-span-full">
                            <label for="number_of_seats"
                                class="block text-sm font-medium leading-6 text-gray-900">number_of_seats:</label>
                            <div class="mt-2">
                                <input type="text" name="number_of_seats"
                                    value="<?php echo $vehicle['number_of_seats']; ?>"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="sm:col-span-full">
                            <label for="plate_number" value="<?php echo $vehicle['plate_number']; ?>"
                                class="block text-sm font-medium leading-6 text-gray-900">Plate number
                            </label>
                            <div class="mt-2">
                                <input type="text" name="plate_number"
                                    value="<?php echo $vehicle['plate_number']; ?>"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="w-full mt-6 flex items-center justify-center gap-x-6">
                    <button type="button" class="w-full text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                    <button type="submit" name="submit"
                        class="w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
        </form>
</body>

</html>