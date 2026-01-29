<?php
include "db_connect_pdo.php";

/* ================= AJAX ACTION ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    function uploadImage(){
        if(!empty($_FILES['image']['name'])){
            if(!is_dir("image")) mkdir("image",0777,true);
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = time().".".$ext;
            move_uploaded_file($_FILES['image']['tmp_name'], "image/".$filename);
            return "image/".$filename;
        }
        return null;
    }

    /* ADD */
    if ($_POST['action'] === 'add') {
        $image = uploadImage();

        $stmt = $pdo->prepare("
            INSERT INTO CatBreeds
            (name_th,name_en,description,characteristics,care_instructions,image_url,is_visible)
            VALUES
            (:name_th,:name_en,:description,:characteristics,:care_instructions,:image_url,:is_visible)
        ");
        $stmt->execute([
            ':name_th'=>$_POST['name_th'],
            ':name_en'=>$_POST['name_en'],
            ':description'=>$_POST['description'],
            ':characteristics'=>$_POST['characteristics'],
            ':care_instructions'=>$_POST['care_instructions'],
            ':image_url'=>$image,
            ':is_visible'=>$_POST['is_visible']
        ]);
        exit("ok");
    }

    /* EDIT */
    if ($_POST['action'] === 'edit') {
        $image = uploadImage();
        $sqlImg = $image ? ", image_url=:image_url" : "";

        $stmt = $pdo->prepare("
            UPDATE CatBreeds SET
            name_th=:name_th,
            name_en=:name_en,
            description=:description,
            characteristics=:characteristics,
            care_instructions=:care_instructions,
            is_visible=:is_visible
            $sqlImg
            WHERE id=:id
        ");

        $data = [
            ':id'=>$_POST['id'],
            ':name_th'=>$_POST['name_th'],
            ':name_en'=>$_POST['name_en'],
            ':description'=>$_POST['description'],
            ':characteristics'=>$_POST['characteristics'],
            ':care_instructions'=>$_POST['care_instructions'],
            ':is_visible'=>$_POST['is_visible']
        ];
        if($image) $data[':image_url']=$image;

        $stmt->execute($data);
        exit("ok");
    }

    /* DELETE */
    if ($_POST['action'] === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM CatBreeds WHERE id=:id");
        $stmt->execute([':id'=>$_POST['id']]);
        exit("ok");
    }
}

/* ================= FETCH ================= */
$rows = $pdo->query("SELECT * FROM CatBreeds ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>CatBreeds CRUD</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-5">

<div class="card p-4">
<h4>🐱 ระบบจัดการสายพันธุ์แมว</h4>
<button class="btn btn-success my-3" onclick="openAdd()">➕ เพิ่ม</button>

<table class="table table-bordered align-middle">
<thead class="table-dark">
<tr>
<th>ID</th><th>รูป</th><th>ชื่อไทย</th><th>ชื่ออังกฤษ</th><th>สถานะ</th><th>จัดการ</th>
</tr>
</thead>
<tbody>
<?php foreach($rows as $r){ ?>
<tr>
<td><?= $r['id'] ?></td>
<td><?php if($r['image_url']){ ?><img src="<?= $r['image_url'] ?>" width="60"><?php } ?></td>
<td><?= htmlspecialchars($r['name_th']) ?></td>
<td><?= htmlspecialchars($r['name_en']) ?></td>
<td><?= $r['is_visible']?'แสดง':'ซ่อน' ?></td>
<td>
<button class="btn btn-warning btn-sm" onclick='openEdit(<?= json_encode($r) ?>)'>แก้ไข</button>
<button class="btn btn-danger btn-sm" onclick='openDelete(<?= json_encode($r) ?>)'>ลบ</button>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>

<!-- ADD / EDIT MODAL -->
<div class="modal fade" id="dataModal">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header bg-primary text-white">
<h5 id="modalTitle"></h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<form id="dataForm" enctype="multipart/form-data">
<input type="hidden" name="id" id="id">
<input type="hidden" name="action" id="action">

<input class="form-control mb-2" name="name_th" id="name_th" placeholder="ชื่อไทย" required>
<input class="form-control mb-2" name="name_en" id="name_en" placeholder="ชื่ออังกฤษ" required>
<textarea class="form-control mb-2" name="description" placeholder="คำอธิบาย"></textarea>
<textarea class="form-control mb-2" name="characteristics" placeholder="ลักษณะนิสัย"></textarea>
<textarea class="form-control mb-2" name="care_instructions" placeholder="การดูแล"></textarea>
<input type="file" class="form-control mb-2" name="image">
<select class="form-control" name="is_visible">
<option value="1">แสดง</option>
<option value="0">ซ่อน</option>
</select>
</form>
</div>
<div class="modal-footer">
<button class="btn btn-success" onclick="saveData()">บันทึก</button>
</div>
</div>
</div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal">
<div class="modal-dialog modal-sm modal-dialog-centered">
<div class="modal-content p-3 text-center">
<p id="deleteText"></p>
<button class="btn btn-danger" onclick="confirmDelete()">ลบ</button>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const dataModal = new bootstrap.Modal(document.getElementById("dataModal"));
const deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));
let deleteId=null;

function openAdd(){
dataForm.reset();
action.value="add";
modalTitle.innerText="เพิ่มสายพันธุ์";
dataModal.show();
}

function openEdit(d){
action.value="edit";
id.value=d.id;
name_th.value=d.name_th;
name_en.value=d.name_en;
dataModal.show();
}

function saveData(){
fetch("show_users_pdo.php",{method:"POST",body:new FormData(dataForm)})
.then(r=>r.text()).then(r=>{ if(r==="ok") location.reload(); });
}

function openDelete(d){
deleteId=d.id;
deleteText.innerText="ลบ "+d.name_th+" ?";
deleteModal.show();
}

function confirmDelete(){
fetch("show_users_pdo.php",{
method:"POST",
headers:{'Content-Type':'application/x-www-form-urlencoded'},
body:"action=delete&id="+deleteId
}).then(r=>r.text()).then(r=>{ if(r==="ok") location.reload(); });
}
</script>

</body>
</html>
