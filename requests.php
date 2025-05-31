<?php
session_start();
header('Content-Type: application/json');

$method = $_GET['method'] ?? '';

function getPDO(): ?PDO
{
    if (!isset($_SESSION['db'])) return null;

    $config = $_SESSION['db'];
    $host = $config['host'];
    $user = $config['user'];
    $pass = $config['pass'] ?? '';
    $database = $config['database'];

    try {
        return new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        return null;
    }
}

switch ($method) {
    case 'connect':
        $input = json_decode(file_get_contents('php://input'), true);
        $host = $input['host'] ?? '';
        $user = $input['user'] ?? '';
        $pass = $input['pass'] ?? '';
        $database = $input['database'] ?? '';

        if (!$host || !$user || !$database) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $user, $pass, [
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
                'message' => 'Connection failed: ' . $e->getMessage()
            ]);
        }
        break;

    case 'logout':
        $_SESSION = [];
        session_destroy();
        echo json_encode(['success' => true, 'loggedIn' => false]);
        break;

    case 'tables':
        $pdo = getPDO();
        if (!$pdo) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Not connected']);
            break;
        }

        try {
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo json_encode(['success' => true, 'tables' => $tables]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'dropDatabase':
        $config = $_SESSION['db'] ?? null;

        if (!$config) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Not connected']);
            break;
        }

        $host = $config['host'];
        $user = $config['user'];
        $pass = $config['pass'] ?? '';
        $database = $config['database'];

        try {

            $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);


            $pdo->exec("DROP DATABASE `$database`");


            $_SESSION = [];
            session_destroy();

            echo json_encode([
                'success' => true,
                'message' => "Database `$database` dropped successful.",
                'loggedIn' => false
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => "Failure in drop database: " . $e->getMessage()
            ]);
        }
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
        echo json_encode(['success' => false, 'message' => 'Unknown method']);
}
