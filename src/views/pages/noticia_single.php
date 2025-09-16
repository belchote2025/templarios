<main class="container py-5 mt-5">
    <div class="row g-5 justify-content-center">
        <div class="col-lg-8">
            <article class="blog-post">
                <h1 class="display-4 link-body-emphasis mb-1"><?= htmlspecialchars($news->titulo) ?></h1>
                <p class="blog-post-meta text-muted">
                    Publicado el <?= date('d \d\e F \d\e Y', strtotime($news->fecha_publicacion)) ?> 
                    por <?= htmlspecialchars($news->autor_nombre . ' ' . $news->autor_apellidos) ?>
                </p>

                <?php if (!empty($news->imagen_portada)): ?>
                    <img src="<?= URL_ROOT ?>/serve-image.php?path=uploads/news/<?= urlencode($news->imagen_portada) ?>" class="img-fluid rounded my-4" alt="Imagen de portada de <?= htmlspecialchars($news->titulo) ?>">
                <?php endif; ?>

                <div class="news-content" style="line-height: 1.8; font-size: 1.1rem;">
                    <?= $news->contenido ?>
                </div>
            </article>

            <hr class="my-5">

            <div class="d-flex justify-content-between align-items-center">
                <a href="<?= URL_ROOT ?>/noticias" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Volver a todas las noticias
                </a>
                <div>
                    <span class="text-muted me-2">Compartir:</span>
                    <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-info"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-success"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

        </div>
    </div>
</main>

<style>
    .news-content p { margin-bottom: 1.5rem; }
</style>