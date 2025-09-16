<!-- Hero Section -->
<section class="hero-section text-white text-center py-8 mb-8" style="background: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.1)), url('/mariscales1-php/public/assets/images/backgrounds/knight-templar-background.jpg') center/cover; backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Patrocinadores</h1>
        <p class="lead">Agradecemos el apoyo de todas las empresas y entidades que hacen posible nuestra labor</p>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <!-- Introduction -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10 text-center">
                <h2 class="fw-bold mb-4">Nuestros Patrocinadores</h2>
                <p class="lead">La colaboración de empresas y entidades es fundamental para el desarrollo de nuestras actividades y la conservación de nuestras tradiciones. Gracias a su apoyo, podemos seguir creciendo y ofreciendo lo mejor de nosotros en cada actuación.</p>
            </div>
        </div>
        
        <!-- Main Sponsors -->
        <div class="row mb-5">
            <div class="col-12 mb-4">
                <h3 class="fw-bold border-bottom pb-2">Patrocinadores Oficiales</h3>
                <p class="text-muted">Nuestros principales colaboradores</p>
            </div>
            
            <!-- Sponsor 1 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <div class="sponsor-logo mb-4">
                            <img src="/mariscales1-php/public/assets/images/patrocinadores/logo1.png" alt="Patrocinador 1" class="img-fluid" style="max-height: 100px;">
                        </div>
                        <h4 class="fw-bold">Empresa Ejemplo S.A.</h4>
                        <p class="text-muted">Patrocinador Principal</p>
                        <p class="card-text">Desde 2018 apoyando nuestras actividades y eventos más destacados.</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Visitar web</a>
                    </div>
                </div>
            </div>
            
            <!-- Sponsor 2 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <div class="sponsor-logo mb-4">
                            <img src="/mariscales1-php/public/assets/images/patrocinadores/logo2.png" alt="Patrocinador 2" class="img-fluid" style="max-height: 100px;">
                        </div>
                        <h4 class="fw-bold">Grupo Empresarial</h4>
                        <p class="text-muted">Patrocinador Oficial</p>
                        <p class="card-text">Colaborando con la promoción de nuestra cultura y tradiciones.</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Visitar web</a>
                    </div>
                </div>
            </div>
            
            <!-- Sponsor 3 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <div class="sponsor-logo mb-4">
                            <img src="/mariscales1-php/public/assets/images/patrocinadores/logo3.png" alt="Patrocinador 3" class="img-fluid" style="max-height: 100px;">
                        </div>
                        <h4 class="fw-bold">Fundación Cultural</h4>
                        <p class="text-muted">Patrocinador Cultural</p>
                        <p class="card-text">Apoyando nuestras iniciativas culturales y educativas.</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Visitar web</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Collaborators -->
        <div class="row mb-5">
            <div class="col-12 mb-4">
                <h3 class="fw-bold border-bottom pb-2">Colaboradores</h3>
                <p class="text-muted">Empresas que nos apoyan en diferentes eventos</p>
            </div>
            
            <div class="col-12">
                <div class="row g-4">
                    <?php 
                    $collaborators = [
                        ['name' => 'Restaurante La Tradición', 'type' => 'Hostelería'],
                        ['name' => 'Imprenta Moderna', 'type' => 'Comunicación'],
                        ['name' => 'Talleres del Mediterráneo', 'type' => 'Mantenimiento'],
                        ['name' => 'Estudio Creativo', 'type' => 'Diseño'],
                        ['name' => 'Transportes Elche', 'type' => 'Logística'],
                        ['name' => 'Seguridad Integral', 'type' => 'Seguridad']
                    ];
                    
                    foreach($collaborators as $collaborator): 
                    ?>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card h-100 border-0 text-center p-3">
                            <div class="bg-light rounded-circle p-4 mb-3 mx-auto" style="width: 80px; height: 80px;">
                                <i class="bi bi-building display-6 text-muted"></i>
                            </div>
                            <h6 class="mb-1"><?php echo $collaborator['name']; ?></h6>
                            <small class="text-muted"><?php echo $collaborator['type']; ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Become a Sponsor -->
        <div class="row align-items-center bg-light rounded-3 p-5 mb-5">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">¿Quieres ser patrocinador?</h2>
                <p class="lead">Únete a nuestra lista de empresas colaboradoras y forma parte de nuestra historia.</p>
                <p>Ofrecemos diferentes modalidades de patrocinio adaptadas a las necesidades de cada empresa, con ventajas como:</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-danger me-2"></i>Presencia en nuestros eventos</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-danger me-2"></i>Logotipo en nuestra web y redes sociales</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-danger me-2"></i>Invitaciones a actos exclusivos</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-danger me-2"></i>Descuentos en publicidad</li>
                </ul>
                <a href="#contacto" class="btn btn-primary btn-lg mt-3">Solicitar información</a>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4">Contacta con nosotros</h4>
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre de la empresa</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Persona de contacto</label>
                                <input type="text" class="form-control" id="contact" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="phone">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="message" rows="3" required></textarea>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="privacy" required>
                                <label class="form-check-label small" for="privacy">
                                    Acepto la <a href="#" class="text-danger">política de privacidad</a> y el tratamiento de mis datos
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Enviar solicitud</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Testimonials -->
        <div class="row mb-5">
            <div class="col-12 mb-4">
                <h3 class="fw-bold border-bottom pb-2">Lo que dicen nuestros patrocinadores</h3>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="/mariscales1-php/public/assets/images/patrocinadores/testimonio1.jpg" class="rounded-circle me-3" width="60" height="60" alt="Testimonio 1">
                            <div>
                                <h5 class="mb-0">Ana Martínez</h5>
                                <p class="text-muted mb-0">Directora de Marketing<br><small>Empresa Ejemplo S.A.</small></p>
                            </div>
                        </div>
                        <p class="card-text">"Colaborar con la Filá Mariscales ha sido una experiencia increíble. La profesionalidad y dedicación de todo el equipo es excepcional."</p>
                        <div class="text-warning">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="/mariscales1-php/public/assets/images/patrocinadores/testimonio2.jpg" class="rounded-circle me-3" width="60" height="60" alt="Testimonio 2">
                            <div>
                                <h5 class="mb-0">Carlos Ruiz</h5>
                                <p class="text-muted mb-0">CEO<br><small>Grupo Empresarial</small></p>
                            </div>
                        </div>
                        <p class="card-text">"El retorno de la inversión ha superado nuestras expectativas. La visibilidad que nos ha dado ha sido extraordinaria."</p>
                        <div class="text-warning">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="/mariscales1-php/public/assets/images/patrocinadores/testimonio3.jpg" class="rounded-circle me-3" width="60" height="60" alt="Testimonio 3">
                            <div>
                                <h5 class="mb-0">Laura Gómez</h5>
                                <p class="text-muted mb-0">Directora de RSC<br><small>Fundación Cultural</small></p>
                            </div>
                        </div>
                        <p class="card-text">"Compartimos valores con la Filá Mariscales, especialmente en la promoción de la cultura y las tradiciones locales."</p>
                        <div class="text-warning">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-danger text-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">¿Listo para unirte a nuestra familia de patrocinadores?</h2>
        <p class="lead mb-4">Descubre cómo tu empresa puede beneficiarse de esta colaboración</p>
        <a href="#contacto" class="btn btn-light btn-lg me-2">Solicitar información</a>
        <a href="#" class="btn btn-outline-light btn-lg">Descargar dossier</a>
    </div>
</section>
