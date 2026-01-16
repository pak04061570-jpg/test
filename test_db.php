<?php
// ตั้งค่าการเชื่อมต่อ
$servername = "localhost";
$username = "root";
$password = "123456"; // ปกติ XAMPP รหัสผ่านจะว่างไว้
$dbname = "inventory_system"; // ต้องตรงกับชื่อใน phpMyAdmin

// ลองเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// เช็คว่าเชื่อมต่อได้ไหม
if ($conn->connect_error) {
  die("❌ เชื่อมต่อไม่ได้! เพราะ: " . $conn->connect_error);
}
echo "✅ เชื่อมต่อสำเร็จ! ฐานข้อมูลพร้อมใช้งาน";
?>