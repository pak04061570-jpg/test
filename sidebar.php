<style>
    /* ย้าย CSS ของ Sidebar มารวมไว้ที่นี่ */
    .sidebar { height: 100vh; width: 250px; position: fixed; top: 0; left: 0; background: white; border-right: 1px solid #e1e4e8; padding-top: 20px; }
    .sidebar .nav-link { color: #555; padding: 12px 20px; margin: 4px 10px; border-radius: 8px; text-decoration: none; display: block;}
    .sidebar .nav-link:hover { background-color: #e8f5e9; color: #2e7d32; }
    
    /* นี่คือส่วนที่เคยหายไปในหน้าอื่นๆ (ตัวหนังสือสีเขียว ตัวใหญ่) */
    .sidebar-brand { padding: 0 24px 20px; font-size: 1.5rem; font-weight: bold; color: #2e7d32; }
</style>

<div class="sidebar">
    <div class="sidebar-brand"><i class="fas fa-cube"></i> MyStock</div>
    <nav class="nav flex-column">
        <a class="nav-link" href="index.php"><i class="fas fa-home me-2"></i> ภาพรวม (Dashboard)</a>
        <a class="nav-link" href="products.php"><i class="fas fa-boxes me-2"></i> สินค้าทั้งหมด</a>
        <a class="nav-link" href="reports.php"><i class="fas fa-file-invoice me-2"></i> เอกสาร/รายงาน</a>
    </nav>
</div>
