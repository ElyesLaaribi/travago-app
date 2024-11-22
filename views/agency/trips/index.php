<?php
session_start();
require 'config/auth.php';
require 'config/connect.php';
require 'utils/menu-bar.php';

$user = $_SESSION['USER'];
$company_id = $user['company_id'];

////////////////////////////// DELETE 
try {
    // Check if ID is set and valid
    if (isset($_POST['delete']) && is_numeric($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        // Prepare and execute delete statement
        $stmt = $pdo->prepare("DELETE FROM trips WHERE id = :id");
        $stmt->bindValue(':id', $id);

        $stmt->execute();
        echo "Record deleted successfully";

    }
} catch (PDOException $e) {
    echo "connection failed: " . $e->getMessage();
}

////////////////////////////// GET DATA FROM TRIPS
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    if (empty($search)) {
        $errorSearch = "Please enter a keyword to search";
    } else {
        // search by any keyword
        $sql = "SELECT * FROM trips WHERE Id LIKE '%$search%' AND company_id = $company_id";
        $result = $pdo->query($sql);
        $trips = $result->fetchAll();
    }
} else {
    $sql = "SELECT * FROM trips where company_id = $company_id";
    $result = $pdo->query($sql);
    $trips = $result->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/travago/styles/output.css">
    <title>List of trips</title>

</head>

<body>
    <header class="bg-white shadow border-b">
        <div class="flex mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 space-x-4">
            <a href="/travago/agency" class="text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-8 h-8 text-gray">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                Trips
            </h1>
        </div>
    </header>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-24">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div>
                <!-- Search -->
                <div class="p-2 w-full flex justify-between">
                    <form method="GET" action="/travago/agency/trips">
                        <div class='flex flex-wrap gap-2 items-center'>
                            <input type="text" class="w-32 lg:w-auto p-2 border border-gray-300 rounded-md" name="search"
                                value="<?php echo $_GET['search'] ?? ''; ?>" placeholder="Search by Id">
                            <?php
                            if (isset($_GET['search'])) {
                                echo "<a href='/travago/agency/trips'
                                        class='rounded-md bg-red-500 px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600'
                                        >Clear</a>";
                                if (!empty($_GET['search'])) {
                                    echo "<p class='text-green-500 text-sm'>Showing results for: <span class='text-sm text-green-500'>Id: {$_GET['search']}</span></p>";

                                }
                            } else {
                                echo "<button type='submit'
                            class='hidden lg:block rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'>
                            Search</button>";
                            }
                            if ($errorSearch) {
                                echo "<p class='text-xs text-red-500'>$errorSearch</p>";
                            }

                            ?>
                        </div>
                    </form>
                    <a href='/travago/agency/trips/add-trip'
                        class='rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'>
                        Add a trip</a>
                </div>

                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th id="c" scope="col" class="px-6 py-3">Id</th>
                            <th id="c" scope="col" class="px-6 py-3">Destination</th>
                            <th id="c" scope="col" class="px-6 py-3">Flight number</th>
                            <th id="c" scope="col" class="px-6 py-3">Number of seats</th>
                            <th id="c" scope="col" class="px-6 py-3">Plan</th>
                            <th id="c" scope="col" class="px-6 py-3"> Departure date</th>
                            <th id="c" scope="col" class="px-6 py-3">Arrival date</th>
                            <th id="c" scope="col" class="px-6 py-3">Hotel</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (empty($trips)) {
                            echo "<tr><td colspan='10' class='text-center text-lg'>No trips found</td></tr>";
                        } else {
                            foreach ($trips as $trip) {
                                $Id = $trip['Id'];
                                $Destination = $trip['Destination'];
                                $Flight_number = $trip['Flight_number'];
                                $Number_of_seats = $trip['Number_of_seats'];
                                $Plan = $trip['Plan'];
                                $Departure_date = $trip['Departure_date'];
                                $Arrival_date = $trip['Arrival_date'];
                                $Hotel = $trip['Hotel'];

                                echo " <tr
                                        class='odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700'>
                                        <th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>
                                            $Id
                                        </th>
                                        <td class='px-6 py-4'>
                                            $Destination
                                        </td>
                                        <td class='px-6 py-4'>
                                            $Flight_number
                                        </td>
                                        <td class='px-6 py-4'>
                                            $Number_of_seats
                                        </td>
                                        <td class='px-6 py-4'>
                                            $Plan
                                        </td>
                                        <td class='px-6 py-4'>
                                            $Departure_date
                                        </td>
                                        <td class='px-6 py-4'>
                                            $Arrival_date
                                        </td>
                                        <td class='px-6 py-4'>
                                            $Hotel
                                        </td>
                                        <td class='px-6 py-4'>
                                                <a href='/travago/agency/trips/edit-trip?tripId=$Id' style='color:green; name='edit'>Edit</a>
                                        </td>
                                        <td class='px-6 py-4'>
                                        <form method='POST' action='/travago/agency/trips'> <!-- change to ur file name -->
                                            <input type='hidden' name='delete_id' value='$Id'> <!-- Pass the delete_id as a hidden input -->
                                            <button class='btn' name='delete' id='yesButton' style='color:red;'>Delete</button>
                                            </button>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
</body>

</html>