<?php $content = '';
ob_start();
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Restablecer Contraseña</h2>
                    <p class="text-muted">Ingresa tu nueva contraseña</p>
                </div>

                <?php 
                $hasErrors = !empty($data['password_err']) || !empty($data['confirm_password_err']);
                
                if ($hasErrors): ?>
                    <div class="alert alert-danger">
                        <?php 
                        if (!empty($data['password_err'])) echo '<p>' . $data['password_err'] . '</p>';
                        if (!empty($data['confirm_password_err'])) echo '<p>' . $data['confirm_password_err'] . '</p>';
                        ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo URL_ROOT; ?>/auth/reset-password/<?php echo $data['token']; ?>" method="post" class="needs-validation" novalidate>
                    <input type="hidden" name="token" value="<?php echo $data['token']; ?>">
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" 
                                   id="password" 
                                   name="password"
                                   minlength="6"
                                   required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="bi bi-eye"></i>
                            </button>
                            <div class="invalid-feedback">
                                La contraseña debe tener al menos 6 caracteres
                            </div>
                        </div>
                        <div class="form-text">Mínimo 6 caracteres</div>
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" 
                                   id="confirm_password" 
                                   name="confirm_password"
                                   required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="bi bi-eye"></i>
                            </button>
                            <div class="invalid-feedback">
                                Las contraseñas no coinciden
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                        Restablecer Contraseña
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
    </div>
</div>

<?php
$content = ob_get_clean();
?>
