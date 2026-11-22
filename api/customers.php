<?php
require_once "db.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  echo json_encode(["success" => true, "data" => $pdo->query("SELECT * FROM customers ORDER BY customer_id DESC")->fetchAll(PDO::FETCH_ASSOC)]);
  exit();
}
$in = json_decode(file_get_contents("php://input"), true) ?? [];
if (($in['action'] ?? '') === 'delete') {
  $pdo->prepare("DELETE FROM customers WHERE customer_id = ?")->execute([intval($in['customer_id'])]);
  echo json_encode(["success" => true, "message" => "ลบข้อมูลลูกค้าเรียบร้อยแล้ว"]);
} else {
  $pdo->prepare("INSERT INTO customers (customer_name, phone, email, province) VALUES (?,?,?,?)")
      ->execute([$in['customer_name'], $in['phone'], $in['email'], $in['province']]);
  echo json_encode(["success" => true, "message" => "เพิ่มข้อมูลลูกค้าเรียบร้อยแล้ว"]);
}
?>
