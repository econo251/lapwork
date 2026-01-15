<?php
include "db_connect_pdo.php";

/* ================= AJAX ACTION ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    // ADD
    if ($_POST['action'] === 'add') {
        $stmt = $pdo->prepare(
            "INSERT INTO users (name, sex, phone, email, birthday)
             VALUES (:name, :sex, :phone, :email, :birthday)"
        );
        $stmt->execute([
            ':name' => $_POST['name'],
            ':sex' => $_POST['sex'],
            ':phone' => $_POST['phone'],
            ':email' => $_POST['email'],
            ':birthday' => $_POST['birthday']
        ]);
        echo "ok";
        exit;
    }

    // EDIT
    if ($_POST['action'] === 'edit') {
        $stmt = $pdo->prepare(
            "UPDATE users SET
                name=:name,
                sex=:sex,
                phone=:phone,
                email=:email,
                birthday=:birthday
             WHERE id=:id"
        );
        $stmt->execute([
            ':id' => $_POST['id'],
            ':name' => $_POST['name'],
            ':sex' => $_POST['sex'],
            ':phone' => $_POST['phone'],
            ':email' => $_POST['email'],
            ':birthday' => $_POST['birthday']
        ]);
        echo "ok";
        exit;
    }

    // DELETE
    if ($_POST['action'] === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id=:id");
        $stmt->execute([':id' => $_POST['id']]);
        echo "ok";
        exit;
    }
}

/* ================= FETCH DATA ================= */
$rows = $pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>CRUD Users | PDO AJAX</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f3f6fb;
    font-family:'Segoe UI',sans-serif;
}
.card{
    border:none;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}
.table thead{
    background:#1e40af;
    color:#fff;
}
.table tbody tr:hover{
    background:#eef2ff;
}
.btn{
    border-radius:10px;
}
</style>
</head>

<body class="container py-5">

<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">📋 ระบบจัดการข้อมูลผู้ใช้</h4>
        <button class="btn btn-success" onclick="openAdd()">➕ เพิ่มข้อมูล</button>
    </div>

    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>ชื่อ</th>
                <th>เพศ</th>
                <th>โทรศัพท์</th>
                <th>Email</th>
                <th>วันเกิด</th>
                <th width="160">จัดการ</th>
            </tr>
        </thead>
        <tbody>
        <?php if(count($rows)==0){ ?>
            <tr><td colspan="7" class="text-center text-muted">ยังไม่มีข้อมูล</td></tr>
        <?php } ?>

        <?php foreach($rows as $r){ ?>
            <tr id="row<?= $r['id'] ?>">
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['name']) ?></td>
                <td><?= $r['sex'] ?></td>
                <td><?= $r['phone'] ?></td>
                <td><?= $r['email'] ?></td>
                <td><?= $r['birthday'] ?></td>
                <td>
                    <button class="btn btn-warning btn-sm"
                        onclick='openEdit(<?= json_encode($r) ?>)'>แก้ไข</button>
                    <button class="btn btn-danger btn-sm"
                        onclick='openDelete(<?= json_encode($r) ?>)'>ลบ</button>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<!-- ===== ADD / EDIT MODAL ===== -->
<div class="modal fade" id="dataModal">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header bg-primary text-white">
    <h5 class="modal-title" id="modalTitle"></h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<form id="dataForm">
    <input type="hidden" name="id" id="id">
    <input type="hidden" name="action" id="action">

    <label>ชื่อ</label>
    <input class="form-control mb-2" name="name" id="name" required>

    <label>เพศ</label>
    <select class="form-control mb-2" name="sex" id="sex">
        <option value="ชาย">ชาย</option>
        <option value="หญิง">หญิง</option>
        <option value="อื่นๆ">อื่นๆ</option>
    </select>

    <label>โทรศัพท์</label>
    <input class="form-control mb-2" name="phone" id="phone">

    <label>Email</label>
    <input class="form-control mb-2" name="email" id="email">

    <label>วันเกิด</label>
    <input type="date" class="form-control" name="birthday" id="birthday">
</form>
</div>
<div class="modal-footer">
    <button class="btn btn-success" onclick="saveData()">บันทึก</button>
</div>
</div>
</div>
</div>

<!-- ===== DELETE MODAL ===== -->
<div class="modal fade" id="deleteModal">
<div class="modal-dialog modal-sm modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-danger text-white">
    <h5 class="modal-title">ยืนยันการลบ</h5>
</div>
<div class="modal-body">
    <p id="deleteText"></p>
    <input type="hidden" id="deleteId">
</div>
<div class="modal-footer">
    <button class="btn btn-danger" onclick="confirmDelete()">ลบ</button>
    <button class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
let dataModal = new bootstrap.Modal(document.getElementById('dataModal'));
let deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

function openAdd(){
    modalTitle.innerText = "เพิ่มข้อมูล";
    dataForm.reset();
    action.value = "add";
    dataModal.show();
}

function openEdit(d){
    modalTitle.innerText = "แก้ไขข้อมูล";
    action.value = "edit";
    id.value = d.id;
    name.value = d.name;
    sex.value = d.sex;
    phone.value = d.phone;
    email.value = d.email;
    birthday.value = d.birthday;
    dataModal.show();
}

function saveData(){
    fetch("show_users_pdo.php",{
        method:"POST",
        body:new FormData(dataForm)
    })
    .then(res=>res.text())
    .then(res=>{
        if(res==="ok"){
            location.reload();
        }
    });
}

function openDelete(d){
    deleteText.innerText = `ต้องการลบ "${d.name}" ใช่หรือไม่`;
    deleteId.value = d.id;
    deleteModal.show();
}

function confirmDelete(){
    fetch("show_users_pdo.php",{
        method:"POST",
        headers:{ "Content-Type":"application/x-www-form-urlencoded" },
        body:"action=delete&id="+deleteId.value
    })
    .then(res=>res.text())
    .then(res=>{
        if(res==="ok"){
            document.getElementById("row"+deleteId.value).remove();
            deleteModal.hide();
        }
    });
}
</script>

</body>
</html>
