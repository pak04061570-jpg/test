<?php
include 'db_connect.php';
$barcode = $_GET['barcode'];

$result = $conn->query("SELECT * FROM product_serials WHERE product_barcode = '$barcode' ORDER BY id DESC");

echo '<table class="table table-sm table-bordered">';
echo '<thead class="table-light"><tr><th>Serial Number</th><th>สถานะ</th><th>วันที่รับเข้า</th></tr></thead>';
echo '<tbody>';

while($row = $result->fetch_assoc()){
    echo "<tr>";
    echo "<td>{$row['serial_number']}</td>";
    
    $statusColor = ($row['status'] == 'available') ? 'text-success' : 'text-secondary';
    echo "<td class='{$statusColor}'>{$row['status']}</td>";
    
    echo "<td>{$row['date_added']}</td>";
    echo "</tr>";
}
echo '</tbody></table>';
?>