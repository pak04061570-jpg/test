<?php
include 'db_connect.php';

// ดึงข้อมูล เรียงจากแก้ไขล่าสุดขึ้นก่อน
$sql = "SELECT * FROM products ORDER BY last_updated DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="table table-hover align-middle mb-0">';
    echo '<thead class="table-light">
            <tr>
                <th>Barcode</th>
                <th>ชื่อสินค้า</th>
                <th class="text-end">ราคาขาย</th>
                <th class="text-center">คงเหลือ</th>
                <th class="text-center">หน่วย</th>
                <th class="text-center">จัดการ</th>
            </tr>
          </thead>';
    echo '<tbody>';

    while($row = $result->fetch_assoc()){
        // --- เริ่มต้น Loop (ทำงานทีละบรรทัด) ---
        
        // จัดการสีของ Badge
        $badgeColor = ($row['quantity'] > 0) ? 'bg-success' : 'bg-danger';
        $price_show = number_format($row['price_sell'], 2);

        echo "<tr>";
        echo "<td><span class='badge bg-light text-dark border'>{$row['barcode']}</span></td>";
        echo "<td class='fw-bold text-primary'>{$row['name']}</td>";
        echo "<td class='text-end'>{$price_show}</td>";
        echo "<td class='text-center'><span class='badge {$badgeColor} rounded-pill'>{$row['quantity']}</span></td>";
        echo "<td class='text-center'>{$row['unit']}</td>";
        
        // ส่วนของปุ่มกด (ต้องอยู่ภายใน Loop นี้เท่านั้น)
        echo "<td class='text-center'>
                <button class='btn btn-sm btn-info text-white me-1' 
                    onclick='openSerialModal(\"{$row['barcode']}\", \"{$row['name']}\")'>
                    <i class='fas fa-barcode'></i> S/N
                </button>
                <button class='btn btn-sm btn-outline-warning' 
                    onclick='openEditModal({$row['id']}, \"{$row['name']}\", {$row['price_sell']}, {$row['quantity']}, \"{$row['unit']}\")'>
                    <i class='fas fa-edit'></i> แก้ไข
                </button>
              </td>";
        echo "</tr>";
        
        // --- จบ Loop ---
    }
    echo '</tbody></table>';
} else {
    echo '<div class="text-center p-5 text-muted">
            <i class="fas fa-box-open fa-3x mb-3"></i><br>
            ยังไม่มีสินค้าในระบบ เริ่มสแกนได้เลย!
          </div>';
}
?>