CREATE DATABASE IF NOT EXISTS db_company_v2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_company_v2;
CREATE TABLE IF NOT EXISTS employees (
  emp_id INT AUTO_INCREMENT PRIMARY KEY,
  emp_code VARCHAR(20) NOT NULL UNIQUE,
  full_name VARCHAR(120) NOT NULL,
  position VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  salary DECIMAL(10,2) NOT NULL DEFAULT 0.00
);
CREATE TABLE IF NOT EXISTS customers (
  customer_id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(120) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  email VARCHAR(120) NOT NULL,
  province VARCHAR(80) NOT NULL
);
INSERT INTO employees (emp_code, full_name, position, phone, salary) VALUES
('E201', 'วรวุฒิ ศรีประเสริฐ', 'โปรแกรมเมอร์', '081-555-1001', 38000),
('E202', 'มัลลิกา แสนดี', 'ฝ่ายบุคคล', '081-555-1002', 29000);
INSERT INTO customers (customer_name, phone, email, province) VALUES
('บริษัท สยามเทค จำกัด', '02-333-4455', 'contact@siamtech.co.th', 'กรุงเทพมหานคร'),
('ร้านเจริญพาณิชย์', '086-777-8899', 'charoen@gmail.com', 'ชลบุรี');
