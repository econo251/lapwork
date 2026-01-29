<?php
include "db_connect_pdo.php";

/* ===== SEARCH ===== */
$keyword = $_GET['q'] ?? "";

$sql = "SELECT * FROM CatBreeds WHERE is_visible = 1";
$params = [];

if($keyword){
    $sql .= " AND (name_th LIKE :kw OR name_en LIKE :kw)";
    $params[':kw'] = "%$keyword%";
}

$sql .= " ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$cats = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>สายพันธุ์แมว</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f6fb;
}

/* CARD */
.card{
    border:none;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    transition:.3s;
}
.card:hover{
    transform:translateY(-5px);
}
.card img{
    height:220px;
    object-fit:cover;
    border-top-left-radius:18px;
    border-top-right-radius:18px;
}

/* CREDIT CAT */
.credit-cat{
    position: fixed;
    right: 16px;
    bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,0.95);
    padding: 8px 14px;
    border-radius: 30px;
    box-shadow: 0 6px 18px rgba(0,0,0,.15);
    font-size: 14px;
    color: #555;
    z-index: 9999;
}
.credit-cat img{
    width: 38px;
    height: 38px;
    border-radius: 50%;
    object-fit: cover;
}
</style>
</head>

<body>

<div class="container py-5">

<h2 class="text-center mb-4 fw-bold">🐱 รวมสายพันธุ์แมว</h2>

<!-- SEARCH -->
<form class="row justify-content-center mb-4">
    <div class="col-md-6">
        <input type="text"
               name="q"
               class="form-control form-control-lg"
               placeholder="ค้นหาสายพันธุ์..."
               value="<?= htmlspecialchars($keyword) ?>">
    </div>
</form>

<div class="row g-4">

<?php if(count($cats)==0){ ?>
    <div class="col-12 text-center text-muted">
        ไม่พบข้อมูล
    </div>
<?php } ?>

<?php foreach($cats as $c){ ?>
<div class="col-md-4">
    <div class="card h-100">
        <img src="<?= $c['image_url'] ?: 'https://via.placeholder.com/400x300' ?>">
        <div class="card-body">
            <h5 class="fw-bold"><?= htmlspecialchars($c['name_th']) ?></h5>
            <p class="text-muted"><?= htmlspecialchars($c['name_en']) ?></p>

            <button class="btn btn-primary btn-sm"
                onclick='openDetail(<?= json_encode($c, JSON_UNESCAPED_UNICODE) ?>)'>
                ดูรายละเอียด
            </button>
        </div>
    </div>
</div>
<?php } ?>

</div>
</div>

<!-- DETAIL MODAL -->
<div class="modal fade" id="detailModal">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-primary text-white">
    <h5 id="d_name"></h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
    <img id="d_img" class="img-fluid rounded mb-3">
    <p><b>ชื่ออังกฤษ:</b> <span id="d_en"></span></p>
    <p><b>คำอธิบาย:</b> <span id="d_desc"></span></p>
    <p><b>ลักษณะนิสัย:</b> <span id="d_char"></span></p>
    <p><b>การดูแล:</b> <span id="d_care"></span></p>
</div>
</div>
</div>
</div>

<!-- CREDIT BOTTOM RIGHT -->
<div class="credit-cat">
    <img src="https://cdn-icons-png.flaticon.com/512/616/616408.png" alt="cat">
    <span>ทำโดย อรรษนัย นาคภู่</span>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
let modal = new bootstrap.Modal(document.getElementById('detailModal'));

function openDetail(d){
    d_name.innerText = d.name_th;
    d_en.innerText   = d.name_en;
    d_desc.innerText = d.description || "-";
    d_char.innerText = d.characteristics || "-";
    d_care.innerText = d.care_instructions || "-";
    d_img.src        = d.image_url || "https://via.placeholder.com/400x300";
    modal.show();
}
</script>

</body>
</html>
