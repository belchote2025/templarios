<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Event;

class EventController extends Controller {
    private $eventModel;

    public function __construct() {
        parent::__construct();
        $this->eventModel = new Event();
    }

    // Mostrar lista de eventos
    public function index() {
        $events = $this->eventModel->getAll();
        $this->view('events/index', ['events' => $events]);
    }

    // Mostrar formulario de creación
    public function create() {
        $this->view('events/create');
    }

    // Almacenar nuevo evento
    public function store() {
        // Validar datos del formulario
        $data = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'date' => $_POST['date'] ?? '',
            'location' => $_POST['location'] ?? ''
        ];

        // Validar y guardar
        if ($this->eventModel->create($data)) {
            // Redirigir con mensaje de éxito
            $this->redirect('/events')->with('success', 'Evento creado exitosamente');
        } else {
            // Redirigir con mensaje de error
            $this->redirect('/events/create')->with('error', 'Error al crear el evento');
        }
    }

    // Mostrar detalles de un evento
    public function show($id) {
        $event = $this->eventModel->find($id);
        if ($event) {
            $this->view('events/show', ['event' => $event]);
        } else {
            $this->redirect('/events')->with('error', 'Evento no encontrado');
        }
    }

    // Mostrar formulario de edición
    public function edit($id) {
        $event = $this->eventModel->find($id);
        if ($event) {
            $this->view('events/edit', ['event' => $event]);
        } else {
            $this->redirect('/events')->with('error', 'Evento no encontrado');
        }
    }

    // Actualizar evento
    public function update($id) {
        $data = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'date' => $_POST['date'] ?? '',
            'location' => $_POST['location'] ?? ''
        ];

        if ($this->eventModel->update($id, $data)) {
            $this->redirect("/events/$id")->with('success', 'Evento actualizado correctamente');
        } else {
            $this->redirect("/events/$id/edit")->with('error', 'Error al actualizar el evento');
        }
    }

    // Eliminar evento
    public function delete($id) {
        if ($this->eventModel->delete($id)) {
            $this->redirect('/events')->with('success', 'Evento eliminado correctamente');
        } else {
            $this->redirect('/events')->with('error', 'Error al eliminar el evento');
        }
    }

    // Registrar usuario en evento
    public function register($eventId) {
        $userId = $_SESSION['user_id'] ?? null;
        
        if (!$userId) {
            $this->redirect('/auth/login')->with('error', 'Debes iniciar sesión para registrarte en eventos');
        }

        if ($this->eventModel->registerUser($eventId, $userId)) {
            $this->redirect("/events/$eventId")->with('success', 'Te has registrado en el evento correctamente');
        } else {
            $this->redirect("/events/$eventId")->with('error', 'Error al registrarse en el evento');
        }
    }

    // Cancelar registro de usuario en evento
    public function cancelRegistration($eventId) {
        $userId = $_SESSION['user_id'] ?? null;
        
        if (!$userId) {
            $this->redirect('/auth/login')->with('error', 'Debes iniciar sesión para cancelar tu registro');
        }

        if ($this->eventModel->cancelRegistration($eventId, $userId)) {
            $this->redirect("/events/$eventId")->with('success', 'Has cancelado tu registro al evento');
        } else {
            $this->redirect("/events/$eventId")->with('error', 'Error al cancelar el registro');
        }
    }
}
