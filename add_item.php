<?php
// เปิดการแสดง Error ของ PHP ทั้งหมด
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php'; // เรียกใช้ไฟล์เชื่อมต่อ

if(isset($_POST['barcode'])){
    $barcode = $_POST['barcode'];
    
    // 1. ลองเช็คของเดิม
    $check = $conn->query("SELECT * FROM products WHERE barcode = '$barcode'");

    if($check === FALSE) {
        // ถ้า Query พัง ให้บอกว่าพังเพราะอะไร
        echo "❌ SQL Error (Check): " . $conn->error;
        exit;
    }

    if($check->num_rows > 0){
        // 2. ถ้ามีแล้ว -> บวกเพิ่ม
        $update = $conn->query("UPDATE products SET quantity = quantity + 1 WHERE barcode = '$barcode'");
        if(!$update) echo "❌ SQL Error (Update): " . $conn->error;
        else echo "✅ อัปเดตจำนวนสำเร็จ";
    } else {
        // 3. ถ้ายังไม่มี -> สร้างใหม่
        // จุดนี้มักจะพังถ้าคอลัมน์ในฐานข้อมูลไม่ครบ
        $insert = $conn->query("INSERT INTO products (barcode, name, quantity, price_sell, unit) VALUES ('$barcode', 'สินค้าใหม่ $barcode', 1, 0, 'ชิ้น')");
        
        if(!$insert) {
            echo "❌ SQL Error (Insert): " . $conn->error;
        } else {
            echo "✅ เพิ่มสินค้าใหม่สำเร็จ";
        }
    }
} else {
    echo "⚠️ ไม่ได้รับค่า Barcode ส่งมา";
}
?>