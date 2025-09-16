<?php
// Cargar la clase base Controller primero
require_once __DIR__ . '/Controller.php';

class UserController extends Controller {
    private $userModel;

    public function __construct() {
        // Verificar que el usuario esté logueado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /prueba-php/public/login');
            exit;
        }
        
        // Inicializar modelo
        $this->userModel = $this->model('User');
    }
    
    // Dashboard del usuario
    public function dashboard() {
        $data = [
            'title' => 'Mi Panel'
        ];
        
        $this->view('user/dashboard', $data);
    }
    
    // Perfil del usuario
    public function profile() {
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        
        $data = [
            'title' => 'Mi Perfil',
            'user' => $user
        ];
        
        $this->view('user/profile', $data);
    }
    
    // Actualizar perfil
    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userData = [
                'id' => $_SESSION['user_id'],
                'nombre' => trim(htmlspecialchars($_POST['nombre'] ?? '')),
                'apellidos' => trim(htmlspecialchars($_POST['apellidos'] ?? '')),
                'email' => filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL),
                'errors' => []
            ];
            
            // Validar datos
            if (empty($userData['nombre'])) $userData['errors']['nombre'] = 'Nombre requerido';
            if (empty($userData['email'])) $userData['errors']['email'] = 'Email requerido';
            if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                $userData['errors']['email'] = 'Email inválido';
            }
            
            if (empty($userData['errors'])) {
                $result = $this->userModel->updateUser($userData);
                if ($result) {
                    setFlashMessage('success', 'Perfil actualizado correctamente');
                    $this->redirect('/profile');
                } else {
                    setFlashMessage('error', 'Error al actualizar el perfil');
                }
            }
        }
        
        $this->redirect('/profile');
    }
    
    // Cambiar contraseña
    public function changePassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentPassword = trim($_POST['current_password'] ?? '');
            $newPassword = trim($_POST['new_password'] ?? '');
            $confirmPassword = trim($_POST['confirm_password'] ?? '');
            
            $errors = [];
            
            // Validar contraseña actual
            if (empty($currentPassword)) {
                $errors['current_password'] = 'Contraseña actual requerida';
            } else {
                // Verificar contraseña actual
                $user = $this->userModel->getUserById($_SESSION['user_id']);
                if (!password_verify($currentPassword, $user->password)) {
                    $errors['current_password'] = 'Contraseña actual incorrecta';
                }
            }
            
            // Validar nueva contraseña
            if (empty($newPassword)) {
                $errors['new_password'] = 'Nueva contraseña requerida';
            } elseif (strlen($newPassword) < 6) {
                $errors['new_password'] = 'La contraseña debe tener al menos 6 caracteres';
            }
            
            // Validar confirmación
            if (empty($confirmPassword)) {
                $errors['confirm_password'] = 'Confirmar contraseña requerida';
            } elseif ($newPassword !== $confirmPassword) {
                $errors['confirm_password'] = 'Las contraseñas no coinciden';
            }
            
            if (empty($errors)) {
                // Hash nueva contraseña
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                
                // Actualizar contraseña (esto limpiará automáticamente la contraseña temporal)
                $result = $this->userModel->updatePassword($_SESSION['user_id'], $hashedPassword);
                
                if ($result) {
                    setFlashMessage('success', 'Contraseña actualizada correctamente');
                } else {
                    setFlashMessage('error', 'Error al actualizar la contraseña');
                }
            } else {
                setFlashMessage('error', 'Errores de validación: ' . implode(', ', $errors));
            }
        }
        
        $this->redirect('/profile');
    }
}
