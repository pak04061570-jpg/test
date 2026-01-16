<?php
include 'db_connect.php'; // เรียกใช้การเชื่อมต่อฐานข้อมูล

// ตรวจสอบว่ามีการส่งค่า barcode และ serial มาหรือไม่
if(isset($_POST['barcode']) && isset($_POST['serial'])){
    $barcode = mysqli_real_escape_string($conn, $_POST['barcode']);
    $serial = mysqli_real_escape_string($conn, $_POST['serial']);

    // ป้องกันค่าว่าง
    if(trim($serial) == "" || trim($barcode) == ""){
        echo "กรุณากรอกข้อมูลให้ครบถ้วน";
        exit;
    }

    // 1. ตรวจสอบว่า Serial Number นี้มีอยู่แล้วในระบบหรือไม่?
    // (Serial Number ไม่ควรซ้ำกันเลยในระบบ ไม่ว่าจะเป็นสินค้าตัวไหน)
    $checkQuery = "SELECT id FROM product_serials WHERE serial_number = '$serial'";
    $check = $conn->query($checkQuery);

    if($check->num_rows > 0){
        // ถ้าเจอซ้ำ ให้แจ้งเตือนกลับไป
        echo "Serial Number นี้ ($serial) มีอยู่ในระบบแล้ว"; 
        exit;
    }

    // 2. บันทึกลงตาราง product_serials
    // กำหนดสถานะเริ่มต้นเป็น 'available' (พร้อมขาย) และลงเวลาปัจจุบัน (NOW())
    $sql = "INSERT INTO product_serials (product_barcode, serial_number, status, date_added) 
            VALUES ('$barcode', '$serial', 'available', NOW())";

    if($conn->query($sql) === TRUE){
        // ส่งค่ากลับว่า Success เพื่อให้ JavaScript ในหน้า index.php รู้ว่าบันทึกสำเร็จ
        echo "Success"; 
    } else {
        // ส่ง Error ของ SQL กลับไป
        echo "SQL Error: " . $conn->error;
    }
} else {
    echo "ไม่พบข้อมูลที่ส่งมา (Invalid Request)";
}
?>