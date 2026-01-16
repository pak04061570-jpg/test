<?php
include 'db_connect.php';

// ตรวจสอบว่ามีการส่ง ID มาหรือไม่
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $unit = $_POST['unit'];

    // คำสั่ง SQL สำหรับอัปเดตข้อมูล
    $sql = "UPDATE products SET 
            name = '$name', 
            price_sell = '$price', 
            quantity = '$qty', 
            unit = '$unit' 
            WHERE id = $id";

    if($conn->query($sql) === TRUE) {
        echo "บันทึกสำเร็จ";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "ไม่พบข้อมูลที่ส่งมา";
}
?>