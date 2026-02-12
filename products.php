<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . "/../config/database.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // GET: อ่านทั้งหมด
    case 'GET':
        $sql = "SELECT * FROM products ORDER BY id DESC";
        $result = $conn->query($sql);

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        echo json_encode($products);
        break;

    // POST: เพิ่ม
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->product_name) || !isset($data->price)) {
            echo json_encode(["status" => 400, "message" => "Invalid payload"]);
            exit;
        }

        $name = $conn->real_escape_string($data->product_name);
        $price = floatval($data->price);

        $sql = "INSERT INTO products (product_name, price) VALUES ('$name', '$price')";
        if ($conn->query($sql)) {
            echo json_encode(["status" => 201, "message" => "Product created successfully"]);
        } else {
            echo json_encode(["status" => 500, "message" => "Insert failed"]);
        }
        break;

    // PUT: แก้ไข
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        $id = intval($data->id ?? 0);
        $name = $conn->real_escape_string($data->product_name ?? "");
        $price = floatval($data->price ?? 0);

        $sql = "UPDATE products SET product_name='$name', price='$price' WHERE id=$id";
        if ($conn->query($sql)) {
            echo json_encode(["status" => 200, "message" => "Product updated successfully"]);
        } else {
            echo json_encode(["status" => 500, "message" => "Update failed"]);
        }
        break;

    // DELETE: ลบ
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $id = intval($data->id ?? 0);

        $sql = "DELETE FROM products WHERE id=$id";
        if ($conn->query($sql)) {
            echo json_encode(["status" => 200, "message" => "Product deleted successfully"]);
        } else {
            echo json_encode(["status" => 500, "message" => "Delete failed"]);
        }
        break;

    default:
        echo json_encode(["status" => 400, "message" => "Invalid request"]);
}
