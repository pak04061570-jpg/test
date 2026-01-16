<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyStock - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Sarabun', sans-serif; background-color: #f7f9fc; }
        .sidebar { height: 100vh; width: 250px; position: fixed; top: 0; left: 0; background: white; border-right: 1px solid #e1e4e8; padding-top: 20px; }
        .sidebar .nav-link { color: #555; padding: 12px 20px; margin: 4px 10px; border-radius: 8px; }
        .sidebar .nav-link:hover { background-color: #e8f5e9; color: #2e7d32; }
        .sidebar-brand { padding: 0 24px 20px; font-size: 1.5rem; font-weight: bold; color: #2e7d32; }
        .main-content { margin-left: 250px; padding: 30px; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.04); background: white; }
    </style>
<head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <h3 class="mb-4">จัดการสต็อกสินค้า</h3>

    <div class="card card-custom p-4 mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <label class="form-label text-muted">สแกนบาร์โค้ดเพื่อรับของเข้า</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fas fa-barcode"></i></span>
                    <input type="text" id="barcodeInput" class="form-control form-control-lg" placeholder="ยิงบาร์โค้ด หรือพิมพ์ตัวเลข..." autofocus>
                    <button class="btn btn-primary" id="btnSave">บันทึก</button>
                <div>
            </div>
            <div class="col-md-4 text-end">
                <?php
                // นับจำนวนสินค้าทั้งหมดมาโชว์
                $count = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc();
                ?>
                <h1 class="text-success mb-0"><?php echo $count['total']; ?></h1>
                <small class="text-muted">รายการสินค้าทั้งหมด</small>
            </div>
        <div>
    </div>

    <div class="card card-custom p-0">
        <div id="productTable"></div> </div>
<div>

<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">แก้ไขข้อมูลสินค้า</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="edit_id">
        <div class="mb-2"><label>ชื่อสินค้า</label><input type="text" id="edit_name" class="form-control"></div>
        <div class="row mb-2">
            <div class="col"><label>ราคาขาย</label><input type="number" id="edit_price" class="form-control"></div>
            <div class="col"><label>จำนวน</label><input type="number" id="edit_qty" class="form-control"></div>
        </div>
        <div class="mb-2"><label>หน่วยนับ</label><input type="text" id="edit_unit" class="form-control"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="saveEdit()">บันทึก</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function(){
        loadTable(); // โหลดตารางทันทีที่เข้าหน้าเว็บ
        
        // ฟังก์ชันสแกน
        $('#barcodeInput').keypress(function(e){
            if(e.which == 13 && $(this).val() != ""){
                scanItem($(this).val());
            }
        });
        $('#btnSave').click(function(){
            if($('#barcodeInput').val() != "") scanItem($('#barcodeInput').val());
        });
    });

    function scanItem(code){
        $.post("add_item.php", { barcode: code }, function(){
            loadTable();
            $('#barcodeInput').val("").focus();
        });
    }

    function loadTable(){
        $("#productTable").load("load_table.php");
    }

    // ฟังก์ชันเปิด Modal แก้ไข (รับค่าจากปุ่มแก้ไขในตาราง)
    window.openEditModal = function(id, name, price, qty, unit) {
        $('#edit_id').val(id);
        $('#edit_name').val(name);
        $('#edit_price').val(price);
        $('#edit_qty').val(qty);
        $('#edit_unit').val(unit);
        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    function saveEdit(){
        $.post("update_item.php", {
            id: $('#edit_id').val(),
            name: $('#edit_name').val(),
            price: $('#edit_price').val(),
            qty: $('#edit_qty').val(),
            unit: $('#edit_unit').val()
        }, function(){
            alert("บันทึกเรียบร้อย!");
            location.reload();
        });
    }
</script>
<div class="modal fade" id="serialModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-barcode"></i> จัดการ Serial Number</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h5 id="serialProductName" class="mb-3 text-primary"></h5>
                <input type="hidden" id="serialProductBarcode">
                
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                    <input type="text" id="inputSerial" class="form-control" placeholder="ยิง Serial Number ที่นี่เพื่อเพิ่ม..." autocomplete="off">
                    <button class="btn btn-success" onclick="addSerial()">บันทึก S/N</button>
                <div>

                <div id="serialList" style="height: 300px; overflow-y: auto; border: 1px solid #ddd;">
                    <p class="text-center mt-3 text-muted">กำลังโหลดข้อมูล...</p>
                </div>
            </div>
        <div>
    </div>
<div>

<script>
    // ฟังก์ชัน: เปิดหน้าต่าง S/N
    function openSerialModal(barcode, name) {
        // รับค่าจากปุ่ม แล้วเอาไปแปะในหน้าต่าง
        $('#serialProductBarcode').val(barcode);
        $('#serialProductName').text("สินค้า: " + name);
        
        // โหลดข้อมูล S/N เก่ามาโชว์
        loadSerials(barcode);
        
        // สั่งเปิด Modal
        var myModal = new bootstrap.Modal(document.getElementById('serialModal'));
        myModal.show();
        
        // รอแป๊บนึงค่อยโฟกัสช่องพิมพ์ (เพื่อให้ Modal เด้งเสร็จก่อน)
        setTimeout(() => { $('#inputSerial').focus(); }, 500);
    }

    // ฟังก์ชัน: สั่งบันทึก S/N
    function addSerial() {
        var barcode = $('#serialProductBarcode').val();
        var serial = $('#inputSerial').val();
        
        if(serial == "") { alert("กรุณายิงเลข Serial Number"); return; }

        $.post("add_serial.php", { barcode: barcode, serial: serial }, function(data){
            if(data.trim() == "Success") {
                loadSerials(barcode); // รีโหลดลิสต์ S/N
                $('#inputSerial').val("").focus(); // เคลียร์ช่องรอรับค่าใหม่
                loadTable(); // รีเฟรชหน้าหลัก (อัปเดตจำนวนรวม)
            } else {
                alert("เกิดข้อผิดพลาด: " + data); // แจ้งเตือนถ้า S/N ซ้ำ
                $('#inputSerial').val("").focus();
            }
        });
    }

    // ฟังก์ชัน: ดึงรายการ S/N มาโชว์
    function loadSerials(barcode) {
        $("#serialList").load("load_serials.php?barcode=" + barcode);
    }

    // เพิ่มลูกเล่น: พอกด Enter ในช่อง S/N ให้กดปุ่มบันทึกอัตโนมัติ
    $(document).ready(function(){
        $('#inputSerial').keypress(function(e){
            if(e.which == 13){ // 13 คือปุ่ม Enter
                addSerial();
            }
        });
    });
</script>
<body>
<html>