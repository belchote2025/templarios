<?php

return function($pdo) {
    try {
        // Crear tabla de categorías de FAQ
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS faq_categories (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                description TEXT,
                icon VARCHAR(50) DEFAULT 'bi-question-circle',
                display_order INT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
        
        echo "✅ Created faq_categories table\n";
        
        // Crear tabla de preguntas frecuentes
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS faqs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                category_id INT,
                question TEXT NOT NULL,
                answer LONGTEXT NOT NULL,
                views INT DEFAULT 0,
                is_featured BOOLEAN DEFAULT FALSE,
                status ENUM('draft', 'published', 'archived') DEFAULT 'published',
                created_by INT,
                updated_by INT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (category_id) REFERENCES faq_categories(id) ON DELETE SET NULL,
                FULLTEXT(question, answer)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
        
        echo "✅ Created faqs table\n";
        
        // Crear tabla de mensajes de chat
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS chat_messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                message TEXT NOT NULL,
                is_from_admin BOOLEAN DEFAULT FALSE,
                is_read BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
        
        echo "✅ Created chat_messages table\n";
        
        // Crear tabla de tutoriales
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS tutorials (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL UNIQUE,
                content LONGTEXT,
                video_url VARCHAR(255),
                thumbnail_url VARCHAR(255),
                duration INT COMMENT 'Duración en minutos',
                difficulty ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'beginner',
                is_featured BOOLEAN DEFAULT FALSE,
                status ENUM('draft', 'published', 'archived') DEFAULT 'published',
                created_by INT,
                updated_by INT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FULLTEXT(title, content)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
        
        echo "✅ Created tutorials table\n";
        
        // Insertar categorías por defecto
        $categories = [
            ['name' => 'General', 'description' => 'Preguntas generales sobre la Filá Mariscales', 'icon' => 'bi-question-circle'],
            ['name' => 'Miembros', 'description' => 'Preguntas sobre membresía y socios', 'icon' => 'bi-people'],
            ['name' => 'Eventos', 'description' => 'Preguntas sobre eventos y actividades', 'icon' => 'bi-calendar-event'],
            ['name' => 'Documentación', 'description' => 'Preguntas sobre documentación y requisitos', 'icon' => 'bi-file-earmark-text'],
            ['name' => 'Tecnología', 'description' => 'Preguntas sobre el uso de la web y aplicaciones', 'icon' => 'bi-laptop']
        ];

        $stmt = $pdo->prepare("
            INSERT IGNORE INTO faq_categories (name, description, icon, display_order) 
            VALUES (:name, :description, :icon, :display_order)
        ");
        
        foreach ($categories as $index => $category) {
            $stmt->execute([
                ':name' => $category['name'],
                ':description' => $category['description'],
                ':icon' => $category['icon'],
                ':display_order' => $index + 1
            ]);
            echo "✅ Added category: " . $category['name'] . "\n";
        }
        
        echo "\n✅ Migration completed successfully!\n";
        
    } catch (PDOException $e) {
        echo "\n❌ Migration failed: " . $e->getMessage() . "\n";
        throw $e; // Re-throw to allow the migration runner to handle the error
    }
};
