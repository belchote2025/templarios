<?php
class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    private $table = 'users';

    // Register user
    public function register($data) {
        $this->db->query('INSERT INTO ' . $this->table . ' (nombre, apellidos, email, password, rol, activo, fecha_registro, ultimo_acceso) 
                         VALUES(:nombre, :apellidos, :email, :password, :rol, :activo, NOW(), NOW())');
        
        // Bind values
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':apellidos', $data['apellidos']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':rol', $data['rol'] ?? 'user');
        $this->db->bind(':activo', $data['activo'] ?? 1);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Find user by email
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email = :email');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    // Find user by ID
    public function findUserById($id) {
        error_log("User::findUserById called with ID: " . $id);
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        error_log("User::findUserById result: " . ($result ? 'found' : 'not found'));
        return $result;
    }

    // Get user by ID (alias for findUserById)
    public function getUserById($id) {
        return $this->findUserById($id);
    }

    // Login user
    public function login($email, $password) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($row) {
            $hashed_password = $row->password;
            if (password_verify($password, $hashed_password)) {
                // Update last login time
                $this->updateLastLogin($row->id);
                
                return $row;
            }
        }
        return false;
    }

    // Update last login time
    public function updateLastLogin($userId) {
        $this->db->query('UPDATE ' . $this->table . ' SET ultimo_acceso = NOW() WHERE id = :id');
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }

    // Create password reset token
    public function createPasswordResetToken($email, $token, $expires) {
        // Update user with reset token
        $this->db->query('UPDATE ' . $this->table . ' SET token_reset = :token, token_expira = :expires WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->db->bind(':token', $token);
        $this->db->bind(':expires', $expires);
        
        return $this->db->execute();
    }

    // Find user by reset token
    public function findUserByResetToken($token) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE token_reset = :token AND token_expira > NOW()');
        $this->db->bind(':token', $token);
        return $this->db->single();
    }

    // Update user password
    public function updatePassword($userId, $hashedPassword, $plainPassword = null) {
        // Actualizar únicamente la contraseña y limpiar posibles campos temporales si existen
        try {
            $this->db->query('UPDATE ' . $this->table . ' SET password = :password, temp_password = NULL, temp_password_created = NULL WHERE id = :id');
            $this->db->bind(':password', $hashedPassword);
            $this->db->bind(':id', $userId);
            return $this->db->execute();
        } catch (Exception $e) {
            // Si falla, usar consulta mínima
            $this->db->query('UPDATE ' . $this->table . ' SET password = :password WHERE id = :id');
            $this->db->bind(':password', $hashedPassword);
            $this->db->bind(':id', $userId);
            return $this->db->execute();
        }
    }
    
    // Update user password with temporary password
    public function updatePasswordWithTemp($userId, $hashedPassword, $tempPassword) {
        // Verificar si los campos temp_password existen
        try {
            $this->db->query('UPDATE ' . $this->table . ' SET password = :password, temp_password = :temp_password, temp_password_created = NOW() WHERE id = :id');
            $this->db->bind(':password', $hashedPassword);
            $this->db->bind(':temp_password', $tempPassword);
            $this->db->bind(':id', $userId);
            return $this->db->execute();
        } catch (Exception $e) {
            // Si falla, solo actualizar la contraseña normal
            $this->db->query('UPDATE ' . $this->table . ' SET password = :password WHERE id = :id');
            $this->db->bind(':password', $hashedPassword);
            $this->db->bind(':id', $userId);
            return $this->db->execute();
        }
    }
    
    // Clear temporary password
    public function clearTempPassword($userId) {
        // Verificar si los campos temp_password existen
        try {
            $this->db->query('UPDATE ' . $this->table . ' SET temp_password = NULL, temp_password_created = NULL WHERE id = :id');
            $this->db->bind(':id', $userId);
            return $this->db->execute();
        } catch (Exception $e) {
            // Si falla, no hacer nada (los campos no existen)
            return true;
        }
    }

    // Delete reset token
    public function deleteResetToken($token) {
        $this->db->query('UPDATE ' . $this->table . ' SET token_reset = NULL, token_expira = NULL WHERE token_reset = :token');
        $this->db->bind(':token', $token);
        return $this->db->execute();
    }

    // Delete user
    public function deleteUser($id) {
        $this->db->query('DELETE FROM users WHERE id = :id');
        
        // Bind values
        $this->db->bind(':id', $id);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Get user count for dashboard
    public function getUserCount() {
        $this->db->query('SELECT COUNT(*) as count FROM ' . $this->table);
        $result = $this->db->single();
        return $result->count;
    }

    // Get recent users for dashboard
    public function getRecentUsers($limit = 5) {
        $this->db->query('SELECT id, nombre, apellidos, email, rol, fecha_registro FROM ' . $this->table . ' ORDER BY fecha_registro DESC LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    // Get all users with pagination
    public function getAllUsers($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        // Consulta estándar sin incluir ningún campo de contraseñas en texto plano
        $this->db->query('SELECT id, nombre, apellidos, email, rol, activo, fecha_registro, ultimo_acceso FROM ' . $this->table . ' ORDER BY fecha_registro DESC LIMIT :limit OFFSET :offset');
        $this->db->bind(':limit', $perPage);
        $this->db->bind(':offset', $offset);
        $result = $this->db->resultSet();
        
        return $result;
    }

    // Count all users
    public function countAllUsers() {
        $this->db->query('SELECT COUNT(*) as count FROM ' . $this->table);
        $result = $this->db->single();
        return $result->count;
    }

    // Set or clear the must_change_password flag
    public function setMustChangePassword($userId, $mustChange = 1) {
        try {
            $this->db->query('UPDATE ' . $this->table . ' SET must_change_password = :must WHERE id = :id');
            $this->db->bind(':must', (int)$mustChange);
            $this->db->bind(':id', $userId);
            return $this->db->execute();
        } catch (Exception $e) {
            // If column doesn't exist, just ignore to avoid breaking
            return true;
        }
    }

    // Update user
    public function updateUser($data) {
        // Debug logging
        error_log("User::updateUser called with data: " . print_r($data, true));
        
        $query = 'UPDATE ' . $this->table . ' SET nombre = :nombre, apellidos = :apellidos, email = :email, rol = :rol, activo = :activo';
        
        // Add password to query if provided
        if (!empty($data['password'])) {
            $query .= ', password = :password';
        }
        
        $query .= ' WHERE id = :id';
        
        error_log("SQL Query: " . $query);
        error_log("Table name: " . $this->table);
        error_log("Data types:");
        error_log("  - ID: " . gettype($data['id']) . " = " . $data['id']);
        error_log("  - Nombre: " . gettype($data['nombre']) . " = " . $data['nombre']);
        error_log("  - Apellidos: " . gettype($data['apellidos']) . " = " . $data['apellidos']);
        error_log("  - Email: " . gettype($data['email']) . " = " . $data['email']);
        error_log("  - Rol: " . gettype($data['rol']) . " = " . $data['rol']);
        error_log("  - Activo: " . gettype($data['activo']) . " = " . $data['activo']);
        
        $this->db->query($query);
        
        // Bind values
        error_log("Binding values to query...");
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':apellidos', $data['apellidos']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':rol', $data['rol']);
        $this->db->bind(':activo', $data['activo']);

        if (!empty($data['password'])) {
            error_log("Binding password field");
            $this->db->bind(':password', $data['password']);
        }

        // Execute
        try {
            $result = $this->db->execute();
            error_log("Database execute result: " . ($result ? 'true' : 'false'));
            error_log("Rows affected: " . $this->db->rowCount());
            return $result;
        } catch (Exception $e) {
            error_log("Database error in updateUser: " . $e->getMessage());
            return false;
        }
    }

    // Update user status (activate/deactivate)
    public function updateUserStatus($id, $status) {
        $this->db->query('UPDATE ' . $this->table . ' SET activo = :status WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
