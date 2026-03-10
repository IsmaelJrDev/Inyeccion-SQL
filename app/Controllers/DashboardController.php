<?php

class DashboardController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function showDashboard() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }

        $users = $this->userModel->getAllUsers();
        $currentUser = $_SESSION['username'];
        
        include __DIR__ . '/../Views/dashboard.php';
    }
}
?>
