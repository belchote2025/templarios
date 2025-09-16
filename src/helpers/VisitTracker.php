<?php

require_once __DIR__ . '/../models/Visit.php';

class VisitTracker {
    private static $instance = null;
    private $visitModel;
    
    private function __construct() {
        $this->visitModel = new Visit();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Registrar visita automáticamente
     */
    public function trackVisit() {
        try {
            // Obtener información de la página actual
            $pageUrl = $_SERVER['REQUEST_URI'] ?? '/';
            $referrer = $_SERVER['HTTP_REFERER'] ?? null;
            
            // Filtrar URLs que no queremos trackear
            $excludePatterns = [
                '/admin/',
                '/api/',
                '/assets/',
                '/uploads/',
                '/vendor/',
                '/src/',
                '/database/',
                '.css',
                '.js',
                '.png',
                '.jpg',
                '.jpeg',
                '.gif',
                '.ico',
                '.pdf'
            ];
            
            foreach ($excludePatterns as $pattern) {
                if (strpos($pageUrl, $pattern) !== false) {
                    return; // No registrar esta visita
                }
            }
            
            // Solo registrar visitas de páginas públicas reales
            if (strpos($pageUrl, '/public/') !== false || $pageUrl === '/' || strpos($pageUrl, '/prueba-php/') !== false) {
                $this->visitModel->recordVisit($pageUrl, $referrer);
            }
            
        } catch (Exception $e) {
            error_log("Error en VisitTracker: " . $e->getMessage());
        }
    }
    
    /**
     * Obtener estadísticas de visitas
     */
    public function getStats($days = 30) {
        try {
            return $this->visitModel->getVisitStats($days);
        } catch (Exception $e) {
            error_log("Error al obtener estadísticas: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtener estadísticas en tiempo real
     */
    public function getRealTimeStats() {
        try {
            return $this->visitModel->getRealTimeStats();
        } catch (Exception $e) {
            error_log("Error al obtener estadísticas en tiempo real: " . $e->getMessage());
            return [];
        }
    }
}
