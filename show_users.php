<?php
include "db_connect.php";

/* เพิ่มข้อมูล */
if (isset($_POST['add'])) {
    $sql = "INSERT INTO users (name, sex, phone, email, birthday)
            VALUES (
                '{$_POST['name']}',
                '{$_POST['sex']}',
                '{$_POST['phone']}',
                '{$_POST['email']}',
                '{$_POST['birthday']}'
            )";
    $conn->query($sql);
    header("Location: show_users.php");
}

/* แก้ไขข้อมูล */
if (isset($_POST['update'])) {
    $sql = "UPDATE users SET
            name='{$_POST['name']}',
            sex='{$_POST['sex']}',
            phone='{$_POST['phone']}',
            email='{$_POST['email']}',
            birthday='{$_POST['birthday']}'
            WHERE id={$_POST['id']}";
    $conn->query($sql);
    header("Location: show_users.php");
}

/* ลบข้อมูล */
if (isset($_GET['delete'])) {
    $conn->query("DELETE FROM users WHERE id=".$_GET['delete']);
    header("Location: show_users.php");
}

/* ดึงข้อมูลแก้ไข */
$editData = null;
if (isset($_GET['edit'])) {
    $edit = $conn->query("SELECT * FROM users WHERE id=".$_GET['edit']);
    $editData = $edit->fetch_assoc();
}

/* ดึงข้อมูลทั้งหมด */
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>CRUD Users</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f5f7fa;
}
.card {
    border-radius: 12px;
}
.table thead th {
    vertical-align: middle;
}
.form-control, .form-select {
    border-radius: 8px;
}
.btn {
    border-radius: 8px;
}
</style>
</head>

<body>

<div class="container mt-5">

<!-- ===== หัวข้อ ===== -->
<div class="text-center mb-4">
    <h2 class="fw-bold text-primary">ระบบจัดการข้อมูลผู้ใช้</h2>
    <p class="text-muted">เพิ่ม แก้ไข และลบข้อมูลผู้ใช้</p>
</div>

<!-- =====================
     ฟอร์มกรอกข้อมูล
===================== -->
<div class="card shadow-sm mb-4">
<div class="card-header <?= $editData ? 'bg-warning' : 'bg-success' ?> text-white">
<?= $editData ? 'แก้ไขข้อมูลผู้ใช้' : 'เพิ่มข้อมูลผู้ใช้' ?>
</div>

<div class="card-body">
<form method="post">
<input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

<div class="row g-3">
<div class="col-md-3">
<label class="form-label">ชื่อ</label>
<input type="text" name="name" class="form-control"
       value="<?= $editData['name'] ?? '' ?>" required>
</div>

<div class="col-md-2">
<label class="form-label">เพศ</label>
<select name="sex" class="form-select">
<option value="ชาย" <?= (isset($editData)&&$editData['sex']=="ชาย")?"selected":"" ?>>ชาย</option>
<option value="หญิง" <?= (isset($editData)&&$editData['sex']=="หญิง")?"selected":"" ?>>หญิง</option>
</select>
</div>

<div class="col-md-2">
<label class="form-label">โทรศัพท์</label>
<input type="text" name="phone" class="form-control"
       value="<?= $editData['phone'] ?? '' ?>">
</div>

<div class="col-md-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control"
       value="<?= $editData['email'] ?? '' ?>">
</div>

<div class="col-md-2">
<label class="form-label">วันเกิด</label>
<input type="date" name="birthday" class="form-control"
       value="<?= $editData['birthday'] ?? '' ?>">
</div>
</div>

<div class="mt-4 text-end">
<?php if ($editData) { ?>
<button name="update" class="btn btn-warning px-4">บันทึกการแก้ไข</button>
<a href="show_users.php" class="btn btn-secondary px-4">ยกเลิก</a>
<?php } else { ?>
<button name="add" class="btn btn-success px-4">เพิ่มข้อมูล</button>
<?php } ?>
</div>

</form>
</div>
</div>

<!-- =====================
     ตารางแสดงข้อมูล
===================== -->
<div class="card shadow-sm">
<div class="card-header bg-dark text-white">
รายการข้อมูลผู้ใช้
</div>

<div class="card-body p-0">
<table class="table table-hover mb-0">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>ชื่อ</th>
<th>เพศ</th>
<th>โทรศัพท์</th>
<th>Email</th>
<th>วันเกิด</th>
<th class="text-center">จัดการ</th>
</tr>
</thead>

<tbody>
<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['name'] ?></td>
<td><?= $row['sex'] ?></td>
<td><?= $row['phone'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['birthday'] ?></td>
<td class="text-center">
<a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">แก้ไข</a>
<button class="btn btn-danger btn-sm"
        onclick="confirmDelete(<?= $row['id'] ?>)">ลบ</button>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>

</div>

<!-- =====================
     Modal ลบข้อมูล
===================== -->
<div class="modal fade" id="deleteModal">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-danger text-white">
<h5 class="modal-title">ยืนยันการลบข้อมูล</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
คุณต้องการลบข้อมูลนี้หรือไม่?
</div>
<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
<a id="deleteBtn" class="btn btn-danger">ลบข้อมูล</a>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function confirmDelete(id) {
    document.getElementById("deleteBtn").href = "?delete=" + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

</body>
</html>
