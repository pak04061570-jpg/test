<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สินค้าทั้งหมด - MyStock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Sarabun', sans-serif; background-color: #f7f9fc; }
        .main-content { margin-left: 250px; padding: 30px; }
        .sidebar { height: 100vh; width: 250px; position: fixed; top: 0; left: 0; background: white; border-right: 1px solid #e1e4e8; padding-top: 20px; }
        .sidebar .nav-link { color: #555; padding: 12px 20px; margin: 4px 10px; border-radius: 8px; }
        .sidebar .nav-link:hover { background-color: #e8f5e9; color: #2e7d32; }
    </style>
<head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>📦 รายการสินค้าทั้งหมด</h3>
        <button class="btn btn-outline-secondary" onclick="location.reload()"><i class="fas fa-sync"></i> อัปเดต</button>
    </div>

    <div class="card p-0 shadow-sm border-0">
        <div class="card-body">
            <?php include 'load_table.php'; ?>
        </div>
    </div>
</div>

</body>
<html>