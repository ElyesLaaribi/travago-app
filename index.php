<?php
// This is the front controller for the application 
$request = strtok($_SERVER['REQUEST_URI'], '?'); // Remove query string from request URI
$viewDir = 'views/';

// Define routes with regular expressions to capture dynamic parts
$routes = array(
    '' => array(
        'view' => 'home.php',
        'pattern' => '/^\/travago\/?$/'
    ),
    '/travago/home' => array(
        'view' => 'home.php',
        'pattern' => '/^\/travago\/home$/'
    ),
    '/travago/about' => array(
        'view' => 'about.php',
        'pattern' => '/^\/travago\/about$/'
    ),
    '/travago/admin' => array(
        'view' => 'admin.php',
        'pattern' => '/^\/travago\/admin$/'
    ),
    '/travago/trips' => array(
        'view' => 'trips.php',
        'pattern' => '/^\/travago\/trips$/'
    ),
    '/travago/profile' => array(
        'view' => 'profile.php',
        'pattern' => '/^\/travago\/profile$/'
    ),
    '/travago/login' => array(
        'view' => 'login/index.php',
        'pattern' => '/^\/travago\/login$/'
    ),
    '/travago/reset-password' => array(
        'view' => 'login/reset-password.php',
        'pattern' => '/^\/travago\/reset-password$/'
    ),
    '/travago/register' => array(
        'view' => 'register/agency.php',
        'pattern' => '/^\/travago\/register$/'
    ),
    '/travago/register/agency' => array(
        'view' => 'register/agency.php',
        'pattern' => '/^\/travago\/register\/agency$/'
    ),
    '/travago/register/customer' => array(
        'view' => 'register/customer.php',
        'pattern' => '/^\/travago\/register\/customer$/'
    ),
    '/travago/agency' => array(
        'view' => 'agency/index.php',
        'pattern' => '/^\/travago\/agency$/'
    ),
    '/travago/agency/trips' => array(
        'view' => 'agency/trips/index.php',
        'pattern' => '/^\/travago\/agency\/trips$/'
    ),
    '/travago/agency/trips/add-trip' => array(
        'view' => 'agency/trips/add-trip.php',
        'pattern' => '/^\/travago\/agency\/trips\/add-trip$/'
    ),
    '/travago/agency/trips/edit-trip' => array(
        'view' => 'agency/trips/edit-trip.php',
        'pattern' => '/^\/travago\/agency\/trips\/edit-trip(\?tripId=\d+)?$/'
    ),
    '/travago/agency/circuits' => array(
        'view' => 'agency/circuits/index.php',
        'pattern' => '/^\/travago\/agency\/circuits$/'
    ),
    '/travago/agency/circuits/add-circuit' => array(
        'view' => 'agency/circuits/add-circuit.php',
        'pattern' => '/^\/travago\/agency\/circuits\/add-circuit$/'
    ),
    '/travago/agency/circuits/edit-circuit' => array(
        'view' => 'agency/circuits/edit-circuit.php',
        'pattern' => '/^\/travago\/agency\/circuits\/edit-circuit(\?circuitId=\d+)?$/'
    ),
    '/travago/agency/vehicles' => array(
        'view' => 'agency/vehicles/index.php',
        'pattern' => '/^\/travago\/agency\/vehicles$/'
    ),
    '/travago/agency/vehicles/add-vehicle' => array(
        'view' => 'agency/vehicles/add-vehicle.php',
        'pattern' => '/^\/travago\/agency\/vehicles\/add-vehicle$/'
    ),
    '/travago/agency/vehicles/edit-vehicle' => array(
        'view' => 'agency/vehicles/edit-vehicle.php',
        'pattern' => '/^\/travago\/agency\/vehicles\/edit-vehicle(\?vehicleId=\d+)?$/'
    ),
    '/travago/agency/customers' => array(
        'view' => 'agency/customers.php',
        'pattern' => '/^\/travago\/agency\/customers$/'
    ),
    // Add more routes as needed...
);


// Function to match the request URI against defined routes
function matchRoute($request, $routes)
{
    foreach ($routes as $route => $details) {
        if (preg_match($details['pattern'], $request, $matches)) {
            return array('view' => $details['view'], 'matches' => $matches);
        }
    }
    return null;
}

// Match the request URI to a route
$routeMatch = matchRoute($request, $routes);

if ($routeMatch !== null) {
    $view = $routeMatch['view'];
    require $viewDir . $view;
} else {
    // Handle 404
    http_response_code(404);
    require $viewDir . '/404.php';
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/travago/public/favicon.svg" type="image/x-icon" />
    <title>Travago</title>
</head>

<body>
    <!-- Your HTML content here -->
</body>

</html>