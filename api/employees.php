<?php
require_once "db.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  echo json_encode(["success" => true, "data" => $pdo->query("SELECT * FROM employees ORDER BY emp_id DESC")->fetchAll(PDO::FETCH_ASSOC)]);
  exit();
}
$in = json_decode(file_get_contents("php://input"), true) ?? [];
if (($in['action'] ?? '') === 'delete') {
  $pdo->prepare("DELETE FROM employees WHERE emp_id = ?")->execute([intval($in['emp_id'])]);
  echo json_encode(["success" => true, "message" => "ลบข้อมูลพนักงานเรียบร้อยแล้ว"]);
} else {
  $pdo->prepare("INSERT INTO employees (emp_code, full_name, position, phone, salary) VALUES (?,?,?,?,?)")
      ->execute([$in['emp_code'], $in['full_name'], $in['position'], $in['phone'], floatval($in['salary'])]);
  echo json_encode(["success" => true, "message" => "เพิ่มข้อมูลพนักงานเรียบร้อยแล้ว"]);
}
?>
