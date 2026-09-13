<?php

namespace App\Controllers;

use App\Models\StudentModel;

class APIController
{
    private $studentModel;

    public function __construct(\mysqli $conn)
    {
        $this->studentModel = new StudentModel($conn);
    }

    public function api()
    {
        header('Content-Type: application/json');

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $this->store();
                break;
            default:
                $this->index();
                break;
        }
    }

    private function index()
    {
        if (isset($_GET['id'])) {
            $this->show((int) $_GET['id']);
            return;
        }

        $users = $this->studentModel->getAllUsers();

        echo json_encode([
            'success' => true,
            'data' => $users
        ]);
        exit;
    }

    private function show($id)
    {
        $user = $this->studentModel->getUserById($id);

        if (!$user) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'User not found.'
            ]);
            exit;
        }

        echo json_encode([
            'success' => true,
            'data' => $user
        ]);
        exit;
    }

    private function store()
    {
        // Daripada mobile apps, perlu hantar data dalam format JSON. Jadi kita baca input dari php://input
        $input = json_decode(file_get_contents('php://input'), true);
        if (!is_array($input)) {
            $input = $_POST;
        }

        $name = trim($input['name'] ?? '');
        $nric = trim($input['nric'] ?? '');
        $program = trim($input['program'] ?? '');
        $password = $input['password'] ?? '';

        if ($name === '' || $nric === '' || $program === '' || $password === '') {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'name, nric, program and password are required.'
            ]);
            exit;
        }

        if (strlen($nric) !== 12) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'NRIC must be exactly 12 characters.'
            ]);
            exit;
        }

        $existing = $this->studentModel->getUser($nric);
        if ($existing->num_rows >= 1) {
            http_response_code(409);
            echo json_encode([
                'success' => false,
                'message' => 'NRIC already exists.'
            ]);
            exit;
        }

        $created = $this->studentModel->registerUser($name, $nric, $program, $password);

        if ($created) {
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'User registered successfully.'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to register user.'
            ]);
        }
        exit;
    }
}
