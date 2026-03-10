<?php
session_start();

// Autoloader para cargar clases automáticamente
spl_autoload_register(function($class) {
    $paths = [
        __DIR__ . '/../app/Models/',
        __DIR__ . '/../app/Controllers/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Inicializar base de datos
$database = new Database();
$userModel = new User($database);

// Router simple
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

switch ($action) {
    case 'login':
        $controller = new LoginController($userModel);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->handleLogin();
        } else {
            $controller->showLoginForm();
        }
        break;
    
    case 'dashboard':
        $controller = new DashboardController($userModel);
        $controller->showDashboard();
        break;
    
    case 'logout':
        $controller = new LoginController($userModel);
        $controller->logout();
        break;
    
    default:
        // Si el usuario está logueado, mostrar dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?action=dashboard');
        } else {
            $controller = new LoginController($userModel);
            $controller->showLoginForm();
        }
        break;
}
?>
