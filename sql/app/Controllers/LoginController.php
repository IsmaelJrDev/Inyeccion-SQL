<?php

class LoginController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function showLoginForm() {
        include __DIR__ . '/../Views/login.php';
    }

    public function handleLogin() {
        $response = [
            'success' => false,
            'message' => '',
            'redirect' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            if (empty($username) || empty($password)) {
                $response['message'] = 'Por favor completa todos los campos';
                echo json_encode($response);
                return;
            }

            // Usar el método vulnerable para propósitos educativos
            $user = $this->userModel->loginVulnerable($username, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                
                $response['success'] = true;
                $response['message'] = 'Login exitoso';
                $response['redirect'] = 'index.php?action=dashboard';
            } else {
                $response['message'] = 'Usuario o contraseña inválidos';
            }
        }

        echo json_encode($response);
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
?>
