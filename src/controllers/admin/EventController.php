<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller {
    private $eventModel;
    private $userModel;
    private $perPage = 10;

    public function __construct() {
        parent::__construct();
        
        // Verificar si el usuario está autenticado y es administrador
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            $this->redirect('/auth/login')->with('error', 'Acceso denegado. Debes ser administrador.');
        }
        
        $this->eventModel = new Event();
        $this->userModel = new User();
    }

    // Lista todos los eventos con paginación y filtros
    public function index($page = 1) {
        $page = max(1, (int)$page);
        
        // Obtener filtros de búsqueda
        $filters = [
            'search' => $_GET['search'] ?? '',
            'fecha_desde' => $_GET['fecha_desde'] ?? '',
            'fecha_hasta' => $_GET['fecha_hasta'] ?? '',
            'es_publico' => $_GET['es_publico'] ?? '',
        ];
        
        // Validar fechas
        if (!empty($filters['fecha_desde']) && !$this->validateDate($filters['fecha_desde'])) {
            $filters['fecha_desde'] = '';
        }
        
        if (!empty($filters['fecha_hasta']) && !$this->validateDate($filters['fecha_hasta'])) {
            $filters['fecha_hasta'] = '';
        }
        
        // Obtener eventos con filtros
        $events = $this->eventModel->searchEvents($filters, $page, $this->perPage);
        $totalEvents = $this->eventModel->countSearchEvents($filters);
        $totalPages = ceil($totalEvents / $this->perPage);
        
        // Pasar los filtros a la vista para mantenerlos en el formulario
        $this->view('admin/eventos/index', [
            'events' => $events,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalEvents' => $totalEvents,
            'filters' => $filters
        ]);
    }
    
    // Muestra el formulario para crear un nuevo evento
    public function create() {
        $this->view('admin/eventos/editar', [
            'event' => (object)[
                'titulo' => '',
                'descripcion' => '',
                'fecha' => date('Y-m-d'),
                'hora' => '20:00',
                'lugar' => '',
                'imagen_url' => '',
                'es_publico' => 1,
                'errors' => []
            ]
        ]);
    }
    
    // Almacena un nuevo evento
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/eventos');
        }
        
        // Validar token CSRF
        if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin/eventos')->with('error', 'Token de seguridad inválido');
        }
        
        $data = $this->validateEventData($_POST);
        
        if (empty($data['errors'])) {
            $data['usuario_id'] = $_SESSION['user_id'];
            
            // Procesar la imagen si se subió
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $this->uploadImage($_FILES['imagen']);
                if ($uploadResult['success']) {
                    $data['imagen_url'] = $uploadResult['path'];
                } else {
                    $data['errors']['imagen'] = $uploadResult['error'];
                }
            }
            
            if (empty($data['errors'])) {
                $eventId = $this->eventModel->createEvent($data);
                
                if ($eventId) {
                    $this->redirect('/admin/eventos')->with('success', 'Evento creado exitosamente');
                } else {
                    $data['errors']['general'] = 'Error al guardar el evento. Inténtalo de nuevo.';
                }
            }
        }
        
        // Si hay errores, volver al formulario con los datos
        $this->view('admin/eventos/editar', [
            'event' => (object)$data
        ]);
    }
    
    // Muestra el formulario para editar un evento
    public function edit($id) {
        $event = $this->eventModel->getEventById($id);
        
        if (!$event) {
            $this->redirect('/admin/eventos')->with('error', 'Evento no encontrado');
        }
        
        $event->errors = [];
        $this->view('admin/eventos/editar', [
            'event' => $event
        ]);
    }
    
    // Actualiza un evento existente
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/eventos');
        }
        
        // Validar token CSRF
        if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->redirect("/admin/eventos/editar/$id")->with('error', 'Token de seguridad inválido');
        }
        
        $event = $this->eventModel->getEventById($id);
        
        if (!$event) {
            $this->redirect('/admin/eventos')->with('error', 'Evento no encontrado');
        }
        
        $data = $this->validateEventData($_POST, $id);
        
        // Procesar la imagen si se subió una nueva
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->uploadImage($_FILES['imagen']);
            if ($uploadResult['success']) {
                // Eliminar la imagen anterior si existe
                if ($event->imagen_url && file_exists(ROOT . $event->imagen_url)) {
                    unlink(ROOT . $event->imagen_url);
                }
                $data['imagen_url'] = $uploadResult['path'];
            } else {
                $data['errors']['imagen'] = $uploadResult['error'];
            }
        }
        
        if (empty($data['errors'])) {
            if ($this->eventModel->updateEvent(array_merge(['id' => $id], $data))) {
                $this->redirect("/admin/eventos/editar/$id")->with('success', 'Evento actualizado exitosamente');
            } else {
                $data['errors']['general'] = 'Error al actualizar el evento. Inténtalo de nuevo.';
            }
        }
        
        // Si hay errores, volver al formulario con los datos
        $event = (object)array_merge((array)$event, $data);
        $this->view('admin/eventos/editar', [
            'event' => $event
        ]);
    }
    
    // Elimina un evento
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/eventos');
        }
        
        // Validar token CSRF
        if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin/eventos')->with('error', 'Token de seguridad inválido');
        }
        
        $event = $this->eventModel->getEventById($id);
        
        if ($event) {
            // Eliminar la imagen si existe
            if ($event->imagen_url && file_exists(ROOT . $event->imagen_url)) {
                unlink(ROOT . $event->imagen_url);
            }
            
            if ($this->eventModel->delete($id)) {
                $this->redirect('/admin/eventos')->with('success', 'Evento eliminado exitosamente');
            } else {
                $this->redirect('/admin/eventos')->with('error', 'Error al eliminar el evento');
            }
        } else {
            $this->redirect('/admin/eventos')->with('error', 'Evento no encontrado');
        }
    }
    
    // Muestra los asistentes a un evento
    public function showAttendees($eventId) {
        $event = $this->eventModel->getEventById($eventId);
        
        if (!$event) {
            $this->redirect('/admin/eventos')->with('error', 'Evento no encontrado');
        }
        
        $attendees = $this->eventModel->getEventAttendees($eventId);
        
        $this->view('admin/eventos/asistentes', [
            'event' => $event,
            'attendees' => $attendees
        ]);
    }
    
    // Exporta la lista de asistentes a un archivo
    public function exportAttendees($eventId) {
        $event = $this->eventModel->getEventById($eventId);
        
        if (!$event) {
            $this->redirect('/admin/eventos')->with('error', 'Evento no encontrado');
        }
        
        $attendees = $this->eventModel->getEventAttendees($eventId);
        
        // Configurar cabeceras para descarga
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="asistentes-evento-' . $eventId . '.csv"');
        
        // Crear archivo CSV de salida
        $output = fopen('php://output', 'w');
        
        // Escribir encabezados
        fputcsv($output, ['Nombre', 'Email', 'Teléfono', 'Fecha de Registro']);
        
        // Escribir datos de asistentes
        foreach ($attendees as $attendee) {
            fputcsv($output, [
                $attendee->nombre . ' ' . $attendee->apellidos,
                $attendee->email,
                $attendee->telefono ?? 'No especificado',
                date('d/m/Y H:i', strtotime($attendee->fecha_registro))
            ]);
        }
        
        fclose($output);
        exit;
    }
    
    // Valida los datos del formulario de evento
    private function validateEventData($postData, $eventId = null) {
        $data = [
            'titulo' => trim($postData['titulo'] ?? ''),
            'descripcion' => trim($postData['descripcion'] ?? ''),
            'fecha' => $postData['fecha'] ?? '',
            'hora' => $postData['hora'] ?? '20:00',
            'lugar' => trim($postData['lugar'] ?? ''),
            'es_publico' => isset($postData['es_publico']) ? 1 : 0,
            'errors' => []
        ];
        
        // Validar título
        if (empty($data['titulo'])) {
            $data['errors']['titulo'] = 'El título es obligatorio';
        } elseif (strlen($data['titulo']) > 255) {
            $data['errors']['titulo'] = 'El título no puede tener más de 255 caracteres';
        }
        
        // Validar fecha
        if (empty($data['fecha']) || !strtotime($data['fecha'])) {
            $data['errors']['fecha'] = 'La fecha es obligatoria y debe ser válida';
        } else {
            $eventDate = new \DateTime($data['fecha'] . ' ' . $data['hora']);
            $now = new \DateTime();
            
            if ($eventDate < $now) {
                $data['errors']['fecha'] = 'La fecha y hora del evento no pueden ser en el pasado';
            }
        }
        
        // Validar hora
        if (empty($data['hora']) || !preg_match('/^\d{2}:\d{2}$/', $data['hora'])) {
            $data['errors']['hora'] = 'La hora es obligatoria y debe tener el formato HH:MM';
        }
        
        return $data;
    }
    
    // Sube una imagen y devuelve la ruta relativa
    private function uploadImage($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!in_array($file['type'], $allowedTypes)) {
            return ['success' => false, 'error' => 'El archivo debe ser una imagen (JPEG, PNG o GIF)'];
        }
        
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'error' => 'La imagen no puede pesar más de 5MB'];
        }
        
        $uploadDir = '/uploads/eventos/' . date('Y/m/');
        $uploadPath = ROOT . $uploadDir;
        
        // Crear directorio si no existe
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        $fileName = uniqid() . '_' . preg_replace('/[^a-z0-9\.]/', '_', strtolower($file['name']));
        $targetPath = $uploadPath . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return [
                'success' => true,
                'path' => $uploadDir . $fileName
            ];
        }
        
        return ['success' => false, 'error' => 'Error al subir la imagen. Inténtalo de nuevo.'];
    }
}
