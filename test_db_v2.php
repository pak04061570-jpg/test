<?php
include 'db_connect.php'; // สร้างไฟล์ db_connect.php รวมการ connect ไว้ทีเดียวก็ดีครับ
// หรือใช้: $conn = new mysqli("localhost", "root", "", "inventory_system");

$result = $conn->query("SELECT * FROM products ORDER BY last_updated DESC");

echo '<table class="table table-hover align-middle mb-0">';
echo '<thead class="table-light"><tr>
        <th>Barcode</th>
        <th>ชื่อสินค้า</th>
        <th class="text-end">ราคาขาย</th>
        <th class="text-center">คงเหลือ</th>
        <th class="text-center">หน่วยนับ</th>
        <th class="text-center">จัดการ</th>
      </tr></thead>';
echo '<tbody>';

while($row = $result->fetch_assoc()){
    echo "<tr>";
    echo "<td><span class='badge bg-light text-dark border'>{$row['barcode']}</span></td>";
    echo "<td class='fw-bold'>{$row['name']}</td>";
    echo "<td class='text-end'>" . number_format($row['price_sell'], 2) . "</td>";
    
    // ไฮไลท์ถ้าของหมด
    $qty_badge = $row['quantity'] > 0 ? 'bg-success' : 'bg-danger';
    echo "<td class='text-center'><span class='badge $qty_badge rounded-pill'>{$row['quantity']}</span></td>";
    
    echo "<td class='text-center'>{$row['unit']}</td>";
    
    // ปุ่มกดเพื่อแก้ไข (ส่งค่าเข้าไปใน JS Function)
    echo "<td class='text-center'>
            <button class='btn btn-sm btn-outline-primary' 
                onclick='openEditModal({$row['id']}, \"{$row['barcode']}\", \"{$row['name']}\", {$row['price_sell']}, {$row['quantity']}, \"{$row['unit']}\")'>
                <i class='fas fa-edit'></i> แก้ไข
            </button>
          </td>";
    echo "</tr>";
}
echo '</tbody></table>';
?>