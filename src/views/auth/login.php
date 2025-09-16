<?php
// Vista de login - Filá Mariscales con estilo medieval
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
.login-container { 
    max-width: 500px; 
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
.login-container::before {
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
.login-title { 
    color: #8B0000; 
    font-family: 'Cinzel', serif;
    font-size: 2.5rem; 
    font-weight: 700; 
    margin-bottom: 20px; 
    text-shadow: 2px 2px 4px rgba(139,0,0,0.3);
    letter-spacing: 3px;
}
.login-subtitle {
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
    color: #8B0000;
    font-size: 1.2rem;
    cursor: pointer;
    z-index: 10;
}
.toggle-password:hover {
    color: #FFD700;
}
.btn-login {
    background: linear-gradient(135deg, #8B4513 0%, #654321 100%);
    color: #FFFFFF;
    border: 2px solid #D4AF37;
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
.btn-login::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}
.btn-login:hover::before {
    left: 100%;
}
.btn-login:hover {
    background: linear-gradient(135deg, #654321 0%, #8B4513 100%);
    color: #FFFFFF;
    border-color: #FFD700;
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
.form-check {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}
.form-check-input {
    background-color: rgba(0, 0, 0, 0.6);
    border: 2px solid #8B4513;
    border-radius: 0;
}
.form-check-input:checked {
    background-color: #8B4513;
    border-color: #D4AF37;
}
.form-check-label {
    color: #C0C0C0;
    font-family: 'Crimson Text', serif;
    margin-left: 10px;
}
.forgot-link {
    color: #D4AF37;
    text-decoration: none;
    font-family: 'Crimson Text', serif;
    font-size: 1rem;
    transition: color 0.3s ease;
}
.forgot-link:hover {
    color: #FFD700;
    text-decoration: none;
}
.register-link {
    color: #D4AF37;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}
.register-link:hover {
    color: #FFD700;
    text-decoration: none;
}
.register-text {
    color: #C0C0C0;
    font-family: 'Crimson Text', serif;
    font-size: 1.1rem;
    margin-top: 25px;
}
@media (max-width: 768px) {
    .login-container { 
        margin: 20px auto; 
        padding: 30px 20px; 
    }
    .login-title { 
        font-size: 2rem; 
    }
    .btn-login { 
        padding: 15px 25px; 
        font-size: 1rem; 
    }
}
</style>

<div class="login-container">
    <h1 class="login-title">⚔️ Iniciar Sesión</h1>
    <p class="login-subtitle">Ingresa a tu cuenta para continuar</p>

    <?php if (!empty($data['email_err']) || !empty($data['password_err'])): ?>
        <div class="alert">
            <?php 
            if (!empty($data['email_err'])) echo '<p>' . $data['email_err'] . '</p>';
            if (!empty($data['password_err'])) echo '<p>' . $data['password_err'] . '</p>';
            ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo URL_ROOT; ?>/login" method="post" class="needs-validation" novalidate>
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
                Por favor ingrese su correo electrónico
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
                       required>
                <button class="toggle-password" type="button">
                    <i class="bi bi-eye"></i>
                </button>
                <div class="invalid-feedback">
                    Por favor ingrese su contraseña
                </div>
            </div>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Recordarme</label>
        </div>

        <div style="text-align: right; margin-bottom: 25px;">
            <a href="<?php echo URL_ROOT; ?>/auth/forgot-password" class="forgot-link">
                ¿Olvidaste tu contraseña?
            </a>
        </div>

        <button type="submit" class="btn-login">
            <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
        </button>

        <div class="register-text">
            ¿No tienes una cuenta? 
            <a href="<?php echo URL_ROOT; ?>/registro" class="register-link">
                Regístrate aquí
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.querySelector('.toggle-password');
    const password = document.querySelector('#password');
    
    if (togglePassword && password) {
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    }
});
</script>
