<?php
require 'db.php'; // Include the database connection

$requestMethod = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);
$action = $_GET['action'] ?? '';

// API Endpoints
switch ($action) {
    // 1. Get ticket date
    case 'get_ticket_date':
        if ($requestMethod === 'GET') {
            $ticketId = $_GET['ticket_id'] ?? '';
            if ($ticketId) {
                $stmt = $db->prepare("SELECT date FROM ticket WHERE carid = :ticketId");
                $stmt->bindParam(':ticketId', $ticketId);
                $stmt->execute();
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                echo json_encode(["error" => "Ticket ID is required"]);
            }
        }
        break;

    // 2. Get net profit + expenses + selling
    case 'get_profit':
        if ($requestMethod === 'GET') {
            $stmt = $db->query("SELECT 
                                    (SUM(price) - SUM(propriety_price)) AS net_profit 
                                FROM ticket 
                                JOIN services ON ticket.name = services.name");
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        }
        break;

    // 3. Add, delete, or edit a service
    case 'manage_service':
        if ($requestMethod === 'POST') {
            $type = $data['type'] ?? '';
            if ($type === 'add') {
                $stmt = $db->prepare("INSERT INTO services (name, propriety_price, des, image) 
                                      VALUES (:name, :propriety_price, :des, :image)");
                $stmt->execute([
                    'name' => $data['name'],
                    'propriety_price' => $data['propriety_price'],
                    'des' => $data['des'],
                    'image' => $data['image']
                ]);
                echo json_encode(["message" => "Service added successfully"]);
            } elseif ($type === 'edit') {
                $stmt = $db->prepare("UPDATE services 
                                      SET propriety_price = :propriety_price, des = :des, image = :image 
                                      WHERE name = :name");
                $stmt->execute([
                    'name' => $data['name'],
                    'propriety_price' => $data['propriety_price'],
                    'des' => $data['des'],
                    'image' => $data['image']
                ]);
                echo json_encode(["message" => "Service updated successfully"]);
            } elseif ($type === 'delete') {
                $stmt = $db->prepare("DELETE FROM services WHERE name = :name");
                $stmt->execute(['name' => $data['name']]);
                echo json_encode(["message" => "Service deleted successfully"]);
            } else {
                echo json_encode(["error" => "Invalid operation type"]);
            }
        }
        break;

    // 4. Add message / Get messages
    case 'manage_messages':
        if ($requestMethod === 'POST') {
            $stmt = $db->prepare("INSERT INTO msg (from, to, date, title, detelis) 
                                  VALUES (:from, :to, :date, :title, :details)");
            $stmt->execute([
                'from' => $data['from'],
                'to' => $data['to'],
                'date' => $data['date'],
                'title' => $data['title'],
                'details' => $data['details']
            ]);
            echo json_encode(["message" => "Message added successfully"]);
        } elseif ($requestMethod === 'GET') {
            $stmt = $db->query("SELECT * FROM msg");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    // 5. Get all services
    case 'get_services':
        if ($requestMethod === 'GET') {
            $stmt = $db->query("SELECT * FROM services");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    // 6. Add ticket and car model
    case 'add_ticket_car':
        if ($requestMethod === 'POST') {
            // Insert car
            $stmt = $db->prepare("INSERT INTO car (carid, type, model, year, username, fuel_type) 
                                  VALUES (:carid, :type, :model, :year, :username, :fuel_type)");
            $stmt->execute([
                'carid' => $data['carid'],
                'type' => $data['type'],
                'model' => $data['model'],
                'year' => $data['year'],
                'username' => $data['username'],
                'fuel_type' => $data['fuel_type']
            ]);

            // Insert ticket
            $stmt = $db->prepare("INSERT INTO ticket (carid, name, price, username, date, stat, year) 
                                  VALUES (:carid, :name, :price, :username, :date, :stat, :year)");
            $stmt->execute([
                'carid' => $data['carid'],
                'name' => $data['name'],
                'price' => $data['price'],
                'username' => $data['username'],
                'date' => $data['date'],
                'stat' => $data['stat'],
                'year' => $data['year']
            ]);

            echo json_encode(["message" => "Car and ticket added successfully"]);
        }
        break;

    // 7. Get completed tickets for a user
    case 'get_completed_tickets':
        if ($requestMethod === 'GET') {
            $username = $_GET['username'] ?? '';
            $stmt = $db->prepare("SELECT * FROM ticket WHERE username = :username AND stat = 'complete'");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    // 8. Add car
    case 'add_car':
        if ($requestMethod === 'POST') {
            $stmt = $db->prepare("INSERT INTO car (carid, type, model, year, username, fuel_type) 
                                  VALUES (:carid, :type, :model, :year, :username, :fuel_type)");
            $stmt->execute([
                'carid' => $data['carid'],
                'type' => $data['type'],
                'model' => $data['model'],
                'year' => $data['year'],
                'username' => $data['username'],
                'fuel_type' => $data['fuel_type']
            ]);
            echo json_encode(["message" => "Car added successfully"]);
        }
        break;

    // 9. Get user info
    case 'get_user_info':
        if ($requestMethod === 'GET') {
            $username = $_GET['username'] ?? '';
            $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        }
        break;

    // 10. Check if username is available
    case 'is_username_available':
        if ($requestMethod === 'GET') {
            $username = $_GET['username'] ?? '';
            $stmt = $db->prepare("SELECT COUNT(*) AS count FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode(["available" => $result['count'] == 0]);
        }
        break;

    // 11. Update user info
    case 'update_user_info':
        if ($requestMethod === 'POST') {
            $stmt = $db->prepare("UPDATE users SET email = :email, phone = :phone, type = :type, password = :password 
                                  WHERE username = :username");
            $stmt->execute([
                'username' => $data['username'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'type' => $data['type'],
                'password' => $data['password']
            ]);
            echo json_encode(["message" => "User info updated successfully"]);
        }
        break;

    // 12. Check login API
    case 'check_login':
        if ($requestMethod === 'POST') {
            $stmt = $db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
            $stmt->execute([
                'username' => $data['username'],
                'password' => $data['password']
            ]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                echo json_encode($user);
            } else {
                echo json_encode(["error" => "Invalid credentials"]);
            }
        }
        break;

    // 13. Sign up and check username availability
    case 'sign_up':
        if ($requestMethod === 'POST') {
            $stmt = $db->prepare("INSERT INTO users (username, email, phone, type, password) 
                                  VALUES (:username, :email, :phone, :type, :password)");
            $stmt->execute([
                'username' => $data['username'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'type' => $data['type'],
                'password' => $data['password']
            ]);
            echo json_encode(["message" => "User registered successfully"]);
        }
        break;

    // 14. Get all tickets with car info
    case 'get_tickets_with_car':
        if ($requestMethod === 'GET') {
            $stmt = $db->query("SELECT ticket.*, car.model, car.type, car.year 
                                FROM ticket 
                                JOIN car ON ticket.carid = car.carid");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(["error" => "Invalid API action"]);
        break;
}
?>
