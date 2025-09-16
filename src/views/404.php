<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada | Filá Mariscales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8B0000;
            --primary-dark: #660000;
            --secondary: #DC143C;
            --accent: #B22222;
            --light: #FFFFFF;
            --dark: #1a0000;
            --success: #228B22;
            --danger: #8B0000;
            --warning: #FF4500;
            --info: #4682B4;
            --gold: #FFD700;
            --silver: #C0C0C0;
        }

        body {
            font-family: 'Crimson Text', serif;
            color: var(--dark);
            line-height: 1.6;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d1810 50%, #1a1a1a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-container {
            text-align: center;
            background: rgba(255, 255, 255, 0.95);
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            border: 2px solid var(--primary);
            max-width: 600px;
            margin: 0 auto;
        }

        .error-code {
            font-family: 'Cinzel', serif;
            font-size: 8rem;
            font-weight: 800;
            color: var(--primary);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin-bottom: 1rem;
            line-height: 1;
        }

        .error-title {
            font-family: 'Cinzel', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .error-message {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
        }

        .btn-home {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: 2px solid var(--primary);
            color: var(--light);
            font-family: 'Cinzel', serif;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-home:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 0, 0, 0.4);
            color: var(--light);
        }

        .knight-icon {
            font-size: 4rem;
            color: var(--gold);
            margin-bottom: 1rem;
        }
    </style></head>
<body>
    <div class="error-container">
        <div class="knight-icon">⚔️</div>
        <div class="error-code">404</div>
        <h1 class="error-title">Página no encontrada</h1>
        <p class="error-message">
            Lo sentimos, la página que buscas no existe en nuestro reino templario.
        </p>
        <a href="/prueba-php/public/" class="btn btn-home">
            Volver al Inicio
        </a>
    </div>
</body>
</html>

