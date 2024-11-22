<?php
session_start();
require 'config/auth.php';
require 'config/connect.php';
require 'utils/menu-bar.php';

$user = $_SESSION['USER'];
$company_id = $user['company_id'];

////////////////////////////// ACTIVATE OR NOT 
try {
  if (isset($_POST['activate']) && isset($_POST['activate_id'])) {
    $id = $_POST['activate_id'];
    $sql = 'UPDATE users SET isVerified = !isVerified WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    if ($stmt->execute()) {
      echo "<script>alert('user status modified successfully')</script>";
    } else {
      echo "<script>alert('user status modification failed')</script>";
    }
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

////////////////////////////// DELETE 
try {
  // Check if ID is set and valid
  if (isset($_POST['delete']) && is_numeric($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    // Prepare and execute delete statement
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindValue(':id', $id);

    $stmt->execute();
    echo "Record deleted successfully";

  }
} catch (PDOException $e) {
  echo "connection failed: " . $e->getMessage();
}

/////////////////////////////// GET FOR ADMIN
if (isset($_GET['search'])) {
  $search = $_GET['search'];
  if (empty($search)) {
    $errorSearch = "Please enter a keyword to search";
  } else {

    if ($user['user_type'] == "admin") {
      try {
        /////////////////////////////// get all users as admin 
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id LIKE '%$search%' AND username != '%travago%'");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    } else if ($user['user_type'] == "agency") {

      /////////////////////////////// GET FOR agency
      try {

        $sql = "SELECT * FROM users WHERE id LIKE '%$search%' AND company_id = :company_id AND user_type != 'agency'";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':company_id', $company_id);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }

    }
  }
} else {
  if ($user['user_type'] == "admin") {
    try {
      /////////////////////////////// get all users as admin 
      $stmt = $pdo->prepare("SELECT * FROM users WHERE user_type != 'admin'");
      $stmt->execute();
      $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  } else if ($user['user_type'] == "agency") {

    /////////////////////////////// GET FOR agency
    try {

      $sql = "SELECT * FROM users WHERE company_id = :company_id AND user_type != 'agency'";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':company_id', $company_id);
      $stmt->execute();
      $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/travago/styles/output.css" rel="stylesheet">
  <title>Customers</title>
</head>

<body>
  <header class="bg-white shadow border-b">
    <div class="flex mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 space-x-4">
      <a href="/travago/agency/vehicles" class="text-gray-800">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-8 h-8 text-gray">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
      </a>
      <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Customers
      </h1>
    </div>
  </header>

  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-24">
    <div class="relative overflow-x-auto">
      <!-- Search -->
      <div class="p-2 w-full flex justify-between">
        <form method="GET" action="/travago/agency/customers">
          <div class='flex flex-wrap gap-2 items-center'>
            <input type="text" class="w-32 lg:w-auto p-2 border border-gray-300 rounded-md" name="search"
              value="<?php echo $_GET['search'] ?? ''; ?>" placeholder="Search by Id">
            <?php
            if (isset($_GET['search'])) {
              echo "<a href='/travago/agency/customers'
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
      </div>
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              Id
            </th>
            <th scope="col" class="px-6 py-3">
              Email
            </th>
            <th scope="col" class="px-6 py-3">
              Active
            </th>
            <th>
              Address
            </th>
            <th scope="col" class="px-6 py-3">
              Phone
            </th>
            <th>
              Created at
            </th>
            <th>
              Company name
            </th>
            <th>
            </th>
            <th>
            </th>
          </tr>
        </thead>

        <tbody>
          <?php
          if (empty($users)) {
            echo "<tr><td colspan='10' class='text-center text-lg'>No trips found</td></tr>";
          } else {
            foreach ($users as $user) {
              $active = $user['isVerified'] == 1 ? 'Yes' : 'No';

              $id = $user['id'];
              $email = $user['email'];
              $isVerified = $user['isVerified'];
              $address = $user['address'];
              $phone = $user['phone'];
              $created_at = $user['created_at'];
              $role = $user['user_type'];
              $company_id = $user['company_id'];

              echo " <tr
                    class='odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700'>
                    <th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>
                        $id
                    </th>
                    <td class='px-6 py-4'>
                        $email
                    </td>
                    <td class='px-6 py-4'>
                        $active
                    </td>
                    <td class='px-6 py-4'>
                        $address
                    </td>
                    <td class='px-6 py-4'>
                        $phone
                    </td>
                    <td class='px-6 py-4'>
                        $created_at
                    </td>
                    <td class='px-6 py-4'>
                        $company_id
                    </td>
                    <td class='px-6 py-4'>
                    <form method='POST' action='/travago/agency/customers'> <!-- change to ur file name -->
                            <input type='hidden' name='activate_id' value='$id'> <!-- Pass the delete_id as a hidden input -->
                            <input type='hidden' name='isVerified' value='$isVerified'> <!-- Pass the delete_id as a hidden input -->
                            <button class='btn' name='activate' id='yesButton' style='color:blue;'>Change Status</button>
                        </button>
                        </form>
                    </td>
                    <td class='px-6 py-4'>
                        <form method='POST' action='/travago/agency/customers'> <!-- change to ur file name -->
                            <input type='hidden' name='delete_id' value='$id'> <!-- Pass the delete_id as a hidden input -->
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