<?php $content = '';
ob_start();
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Recuperar Contraseña</h2>
                    <p class="text-muted">Ingresa tu correo electrónico para restablecer tu contraseña</p>
                </div>

                <?php if (!empty($data['email_err'])): ?>
                    <div class="alert alert-danger">
                        <?php echo $data['email_err']; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo URL_ROOT; ?>/auth/forgot-password" method="post" class="needs-validation" novalidate>
                    <div class="mb-4">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" 
                               class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                               id="email" 
                               name="email" 
                               value="<?php echo $data['email'] ?? ''; ?>"
                               required>
                        <div class="invalid-feedback">
                            Por favor ingrese su correo electrónico
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                        Enviar Enlace de Recuperación
                    </button>

                    <div class="text-center mt-4">
                        <p class="mb-0">
                            <a href="<?php echo URL_ROOT; ?>/auth/login" class="text-danger text-decoration-none fw-semibold">
                                ← Volver al inicio de sesión
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <p class="text-muted">
                ¿No recibiste el correo? Revisa tu carpeta de spam o 
                <a href="<?php echo URL_ROOT; ?>/auth/forgot-password" class="text-decoration-none">
                    inténtalo de nuevo
                </a>
            </p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
?>
