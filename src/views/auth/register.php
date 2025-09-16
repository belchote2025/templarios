<?php
// Vista de registro - Filá Mariscales con estilo medieval
?>

<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Text:wght@400;600&display=swap" rel="stylesheet">
<style>
body { 
    font-family: 'Crimson Text', serif; 
    margin: 0; 
    background: linear-gradient(135deg, #8B0000 0%, #660000 50%, #8B0000 100%); 
    min-height: 100vh; 
    color: #FFFFFF;
}
.register-container { 
    max-width: 600px; 
    margin: 50px auto; 
    background: rgba(255, 255, 255, 0.95); 
    padding: 40px; 
    border-radius: 15px; 
    box-shadow: 0 0 30px rgba(139,0,0,0.8); 
    text-align: center; 
    border: 3px solid #8B0000;
    position: relative;
    color: #8B0000;
}
.register-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"%238B0000\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain)\"/></svg>');
    pointer-events: none;
    z-index: -1;
}
.register-title { 
    color: #8B0000; 
    font-family: 'Cinzel', serif;
    font-size: 2.5rem; 
    font-weight: 700; 
    margin-bottom: 20px; 
    text-shadow: 2px 2px 4px rgba(139,0,0,0.3);
    letter-spacing: 3px;
}
.register-subtitle {
    color: #DC143C;
    font-family: 'Cinzel', serif;
    font-size: 1.1rem;
    font-weight: 400;
    margin-bottom: 30px;
    letter-spacing: 1px;
}
.form-group {
    margin-bottom: 25px;
    text-align: left;
}
.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 25px;
}
.form-col {
    flex: 1;
}
.form-label {
    color: #8B0000;
    font-family: 'Cinzel', serif;
    font-weight: 600;
    font-size: 1.1rem;
    letter-spacing: 1px;
    margin-bottom: 10px;
    display: block;
}
.form-control {
    background: rgba(255, 255, 255, 0.9) !important;
    border: 2px solid #8B0000 !important;
    border-radius: 8px !important;
    color: #8B0000 !important;
    font-family: 'Crimson Text', serif;
    font-size: 1.1rem;
    padding: 15px 20px;
    transition: all 0.3s ease;
    width: 100%;
}
.form-control:focus {
    background: rgba(255, 255, 255, 1) !important;
    border-color: #DC143C !important;
    box-shadow: 0 0 15px rgba(139, 0, 0, 0.3) !important;
    color: #8B0000 !important;
}
.form-control::placeholder {
    color: #8B0000;
    opacity: 0.7;
}
.input-group {
    position: relative;
}
.toggle-password {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #D4AF37;
    font-size: 1.2rem;
    cursor: pointer;
    z-index: 10;
}
.toggle-password:hover {
    color: #FFD700;
}
.btn-register {
    background: linear-gradient(135deg, #2d1810 0%, #4a2c1a 100%);
    color: #90EE90;
    border: 2px solid #90EE90;
    font-family: 'Cinzel', serif;
    font-weight: 600;
    font-size: 1.1rem;
    padding: 18px 35px;
    border-radius: 0;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: all 0.4s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.6);
    width: 100%;
    position: relative;
    overflow: hidden;
}
.btn-register::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}
.btn-register:hover::before {
    left: 100%;
}
.btn-register:hover {
    background: linear-gradient(135deg, #4a2c1a 0%, #2d1810 100%);
    color: #98FB98;
    border-color: #98FB98;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.8);
}
.alert {
    background: rgba(139, 69, 19, 0.3);
    border: 2px solid #8B4513;
    border-radius: 0;
    color: #FF6B6B;
    font-weight: bold;
    padding: 15px;
    margin-bottom: 25px;
}
.form-text {
    color: #8B4513;
    font-family: 'Crimson Text', serif;
    font-size: 0.9rem;
    margin-top: 5px;
}
.login-link {
    color: #D4AF37;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}
.login-link:hover {
    color: #FFD700;
    text-decoration: none;
}
.login-text {
    color: #C0C0C0;
    font-family: 'Crimson Text', serif;
    font-size: 1.1rem;
    margin-top: 25px;
}
@media (max-width: 768px) {
    .register-container { 
        margin: 20px auto; 
        padding: 30px 20px; 
    }
    .register-title { 
        font-size: 2rem; 
    }
    .btn-register { 
        padding: 15px 25px; 
        font-size: 1rem; 
    }
    .form-row {
        flex-direction: column;
        gap: 0;
    }
}
</style>

<div class="register-container">
    <h1 class="register-title">⚔️ Crear Cuenta</h1>
    <p class="register-subtitle">Completa el formulario para registrarte</p>

    <?php 
    $hasErrors = !empty($data['nombre_err']) || !empty($data['apellidos_err']) || 
                !empty($data['email_err']) || !empty($data['password_err']) || 
                !empty($data['confirm_password_err']);
    
    if ($hasErrors): ?>
        <div class="alert">
            <?php 
            if (!empty($data['nombre_err'])) echo '<p>' . $data['nombre_err'] . '</p>';
            if (!empty($data['apellidos_err'])) echo '<p>' . $data['apellidos_err'] . '</p>';
            if (!empty($data['email_err'])) echo '<p>' . $data['email_err'] . '</p>';
            if (!empty($data['password_err'])) echo '<p>' . $data['password_err'] . '</p>';
            if (!empty($data['confirm_password_err'])) echo '<p>' . $data['confirm_password_err'] . '</p>';
            ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo URL_ROOT; ?>/registro" method="post" class="needs-validation" novalidate>
        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" 
                           class="form-control <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" 
                           id="nombre" 
                           name="nombre" 
                           value="<?php echo $data['nombre']; ?>"
                           placeholder="Ingresa tu nombre"
                           required>
                    <div class="invalid-feedback">
                        Por favor ingrese su nombre
                    </div>
                </div>
            </div>
            
            <div class="form-col">
                <div class="form-group">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" 
                           class="form-control <?php echo (!empty($data['apellidos_err'])) ? 'is-invalid' : ''; ?>" 
                           id="apellidos" 
                           name="apellidos" 
                           value="<?php echo $data['apellidos']; ?>"
                           placeholder="Ingresa tus apellidos"
                           required>
                    <div class="invalid-feedback">
                        Por favor ingrese sus apellidos
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" 
                   class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                   id="email" 
                   name="email" 
                   value="<?php echo $data['email']; ?>"
                   placeholder="Ingresa tu correo electrónico"
                   required>
            <div class="invalid-feedback">
                Por favor ingrese un correo electrónico válido
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Contraseña</label>
            <div class="input-group">
                <input type="password" 
                       class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" 
                       id="password" 
                       name="password"
                       placeholder="Ingresa tu contraseña"
                       minlength="6"
                       required>
                <button class="toggle-password" type="button">
                    <i class="bi bi-eye"></i>
                </button>
                <div class="invalid-feedback">
                    La contraseña debe tener al menos 6 caracteres
                </div>
            </div>
            <div class="form-text">Mínimo 6 caracteres</div>
        </div>

        <div class="form-group">
            <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
            <div class="input-group">
                <input type="password" 
                       class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" 
                       id="confirm_password" 
                       name="confirm_password"
                       placeholder="Confirma tu contraseña"
                       required>
                <button class="toggle-password" type="button">
                    <i class="bi bi-eye"></i>
                </button>
                <div class="invalid-feedback">
                    Las contraseñas no coinciden
                </div>
            </div>
        </div>

        <button type="submit" class="btn-register">
            <i class="bi bi-person-plus me-2"></i>Crear Cuenta
        </button>

        <div class="login-text">
            ¿Ya tienes una cuenta? 
            <a href="<?php echo URL_ROOT; ?>/login" class="login-link">
                Inicia sesión aquí
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility for both password fields
    const togglePasswords = document.querySelectorAll('.toggle-password');
    
    togglePasswords.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    });
});
</script>
