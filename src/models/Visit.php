<?php

class Visit {
    private $db;
    
    public function __construct() {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=mariscales_db', 'root', '');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log("Error de conexión a la base de datos en Visit: " . $e->getMessage());
            throw new Exception("Error de conexión a la base de datos");
        }
    }
    
    /**
     * Registrar una nueva visita
     */
    public function recordVisit($pageUrl = '/', $referrer = null) {
        try {
            $ip = $this->getClientIP();
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
            $sessionId = session_id();
            
            // Verificar si es una visita única (misma IP en las últimas 24 horas)
            $isUnique = $this->isUniqueVisit($ip, $pageUrl);
            
            // Detectar información del dispositivo y navegador
            $deviceInfo = $this->detectDeviceInfo($userAgent);
            
            $stmt = $this->db->prepare("
                INSERT INTO visitas (
                    ip_address, user_agent, page_url, referrer, session_id, 
                    is_unique, device_type, browser, os
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $ip,
                $userAgent,
                $pageUrl,
                $referrer,
                $sessionId,
                $isUnique ? 1 : 0,
                $deviceInfo['device_type'],
                $deviceInfo['browser'],
                $deviceInfo['os']
            ]);
            
            // Actualizar estadísticas diarias
            $this->updateDailyStats();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error al registrar visita: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtener estadísticas de visitas
     */
    public function getVisitStats($days = 30) {
        try {
            $stats = [];
            
            // Visitas totales
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as total_visitas 
                FROM visitas 
                WHERE visit_date >= DATE_SUB(NOW(), INTERVAL ? DAY)
            ");
            $stmt->execute([$days]);
            $stats['total_visitas'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_visitas'];
            
            // Visitas únicas
            $stmt = $this->db->prepare("
                SELECT COUNT(DISTINCT ip_address) as visitas_unicas 
                FROM visitas 
                WHERE visit_date >= DATE_SUB(NOW(), INTERVAL ? DAY)
            ");
            $stmt->execute([$days]);
            $stats['visitas_unicas'] = $stmt->fetch(PDO::FETCH_ASSOC)['visitas_unicas'];
            
            // Visitas de hoy
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as visitas_hoy 
                FROM visitas 
                WHERE DATE(visit_date) = CURDATE()
            ");
            $stmt->execute();
            $stats['visitas_hoy'] = $stmt->fetch(PDO::FETCH_ASSOC)['visitas_hoy'];
            
            // Visitas únicas de hoy
            $stmt = $this->db->prepare("
                SELECT COUNT(DISTINCT ip_address) as visitas_unicas_hoy 
                FROM visitas 
                WHERE DATE(visit_date) = CURDATE()
            ");
            $stmt->execute();
            $stats['visitas_unicas_hoy'] = $stmt->fetch(PDO::FETCH_ASSOC)['visitas_unicas_hoy'];
            
            // Páginas más visitadas
            $stmt = $this->db->prepare("
                SELECT page_url, COUNT(*) as visitas 
                FROM visitas 
                WHERE visit_date >= DATE_SUB(NOW(), INTERVAL ? DAY)
                GROUP BY page_url 
                ORDER BY visitas DESC 
                LIMIT 10
            ");
            $stmt->execute([$days]);
            $stats['paginas_populares'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Dispositivos
            $stmt = $this->db->prepare("
                SELECT device_type, COUNT(*) as cantidad 
                FROM visitas 
                WHERE visit_date >= DATE_SUB(NOW(), INTERVAL ? DAY)
                GROUP BY device_type
            ");
            $stmt->execute([$days]);
            $stats['dispositivos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Navegadores
            $stmt = $this->db->prepare("
                SELECT browser, COUNT(*) as cantidad 
                FROM visitas 
                WHERE visit_date >= DATE_SUB(NOW(), INTERVAL ? DAY)
                GROUP BY browser 
                ORDER BY cantidad DESC 
                LIMIT 5
            ");
            $stmt->execute([$days]);
            $stats['navegadores'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Visitas por hora del día
            $stmt = $this->db->prepare("
                SELECT HOUR(visit_date) as hora, COUNT(*) as visitas 
                FROM visitas 
                WHERE visit_date >= DATE_SUB(NOW(), INTERVAL ? DAY)
                GROUP BY HOUR(visit_date) 
                ORDER BY hora
            ");
            $stmt->execute([$days]);
            $stats['visitas_por_hora'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Visitas por día (últimos 30 días)
            $stmt = $this->db->prepare("
                SELECT DATE(visit_date) as fecha, COUNT(*) as visitas, COUNT(DISTINCT ip_address) as visitas_unicas
                FROM visitas 
                WHERE visit_date >= DATE_SUB(NOW(), INTERVAL ? DAY)
                GROUP BY DATE(visit_date) 
                ORDER BY fecha DESC
            ");
            $stmt->execute([$days]);
            $stats['visitas_por_dia'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $stats;
        } catch (PDOException $e) {
            error_log("Error al obtener estadísticas de visitas: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtener estadísticas en tiempo real
     */
    public function getRealTimeStats() {
        try {
            $stats = [];
            
            // Visitas en la última hora
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as visitas_ultima_hora 
                FROM visitas 
                WHERE visit_date >= DATE_SUB(NOW(), INTERVAL 1 HOUR)
            ");
            $stmt->execute();
            $stats['visitas_ultima_hora'] = $stmt->fetch(PDO::FETCH_ASSOC)['visitas_ultima_hora'];
            
            // Usuarios online (últimos 5 minutos)
            $stmt = $this->db->prepare("
                SELECT COUNT(DISTINCT ip_address) as usuarios_online 
                FROM visitas 
                WHERE visit_date >= DATE_SUB(NOW(), INTERVAL 5 MINUTE)
            ");
            $stmt->execute();
            $stats['usuarios_online'] = $stmt->fetch(PDO::FETCH_ASSOC)['usuarios_online'];
            
            // Páginas más visitadas hoy
            $stmt = $this->db->prepare("
                SELECT page_url, COUNT(*) as visitas 
                FROM visitas 
                WHERE DATE(visit_date) = CURDATE()
                GROUP BY page_url 
                ORDER BY visitas DESC 
                LIMIT 5
            ");
            $stmt->execute();
            $stats['paginas_hoy'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $stats;
        } catch (PDOException $e) {
            error_log("Error al obtener estadísticas en tiempo real: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Verificar si es una visita única (por IP, no por página)
     */
    private function isUniqueVisit($ip, $pageUrl) {
        try {
            // Verificar si esta IP ya visitó el sitio en las últimas 24 horas
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as count 
                FROM visitas 
                WHERE ip_address = ? 
                AND visit_date >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
            ");
            $stmt->execute([$ip]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] == 0;
        } catch (PDOException $e) {
            return true; // En caso de error, considerar como única
        }
    }
    
    /**
     * Obtener IP del cliente
     */
    private function getClientIP() {
        $ipKeys = ['HTTP_CF_CONNECTING_IP', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
    
    /**
     * Detectar información del dispositivo
     */
    private function detectDeviceInfo($userAgent) {
        $deviceType = 'Desktop';
        $browser = 'Unknown';
        $os = 'Unknown';
        
        // Detectar dispositivo
        if (preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent)) {
            $deviceType = 'Mobile';
        } elseif (preg_match('/Tablet|iPad/i', $userAgent)) {
            $deviceType = 'Tablet';
        }
        
        // Detectar navegador
        if (preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Edge/i', $userAgent)) {
            $browser = 'Edge';
        } elseif (preg_match('/Opera/i', $userAgent)) {
            $browser = 'Opera';
        }
        
        // Detectar sistema operativo
        if (preg_match('/Windows/i', $userAgent)) {
            $os = 'Windows';
        } elseif (preg_match('/Mac/i', $userAgent)) {
            $os = 'macOS';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $os = 'Android';
        } elseif (preg_match('/iOS/i', $userAgent)) {
            $os = 'iOS';
        }
        
        return [
            'device_type' => $deviceType,
            'browser' => $browser,
            'os' => $os
        ];
    }
    
    /**
     * Actualizar estadísticas diarias
     */
    private function updateDailyStats() {
        try {
            $today = date('Y-m-d');
            
            // Verificar si ya existe el registro de hoy
            $stmt = $this->db->prepare("SELECT id FROM estadisticas_visitas WHERE fecha = ?");
            $stmt->execute([$today]);
            
            if ($stmt->rowCount() > 0) {
                // Actualizar estadísticas existentes
                $stmt = $this->db->prepare("
                    UPDATE estadisticas_visitas 
                    SET 
                        total_visitas = (SELECT COUNT(*) FROM visitas WHERE DATE(visit_date) = ?),
                        visitas_unicas = (SELECT COUNT(DISTINCT ip_address) FROM visitas WHERE DATE(visit_date) = ?),
                        dispositivos_moviles = (SELECT COUNT(*) FROM visitas WHERE DATE(visit_date) = ? AND device_type = 'Mobile'),
                        dispositivos_escritorio = (SELECT COUNT(*) FROM visitas WHERE DATE(visit_date) = ? AND device_type = 'Desktop'),
                        updated_at = NOW()
                    WHERE fecha = ?
                ");
                $stmt->execute([$today, $today, $today, $today, $today]);
            } else {
                // Crear nuevo registro
                $stmt = $this->db->prepare("
                    INSERT INTO estadisticas_visitas (
                        fecha, total_visitas, visitas_unicas, dispositivos_moviles, dispositivos_escritorio
                    ) VALUES (?, 1, 1, 0, 1)
                ");
                $stmt->execute([$today]);
            }
        } catch (PDOException $e) {
            error_log("Error al actualizar estadísticas diarias: " . $e->getMessage());
        }
    }
}
