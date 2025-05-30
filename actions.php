<?php
session_start();
header('Content-Type: application/json');

$method = $_GET['method'] ?? '';

switch ($method) {
    case 'connect':
        $input = json_decode(file_get_contents('php://input'), true);
        $host = $input['host'] ?? '';
        $user = $input['user'] ?? '';
        $pass = $input['pass'] ?? '';
        $database = $input['database'] ?? '';

        if (!$host || !$user || !$database) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'All fields are empty']);
            exit;
        }

        $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";

        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

          
            $_SESSION['db'] = compact('host', 'user', 'database');

            echo json_encode([
                'success' => true,
                'loggedIn' => true,
                'session' => $_SESSION['db']
            ]);
        } catch (PDOException $e) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'Connection failure : ' . $e->getMessage()
            ]);
        }
        break;

    case 'logout':
        $_SESSION = [];
        session_destroy();
        echo json_encode(['success' => true, 'loggedIn' => false]);
        break;

    case 'sessionCheck':
        echo json_encode([
            'success' => isset($_SESSION['db']),
            'loggedIn' => isset($_SESSION['db']),
            'session' => $_SESSION['db'] ?? null
        ]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Unknow method']);
}
