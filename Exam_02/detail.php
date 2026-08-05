<?php
require_once "dao/DeviceDao.php";

if (empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$dao = new DeviceDao();
$device = $dao->findById($id);

require_once "includes/header.php";
require_once "includes/menu.php";
?>

<div class="container mb-5">
    <?php if ($device == null) { ?>
        <div class="alert alert-warning">Không tìm thấy thiết bị!</div>
        <a href="index.php" class="btn btn-secondary">Quay lại danh sách</a>
    <?php } else { ?>
        <div class="card mx-auto" style="max-width: 800px;">
            <div class="row g-0">
                <div class="col-md-4 text-center p-3">
                    <img src="<?= $device->image ?>" class="img-fluid rounded-start" alt="<?= $device->deviceName ?>">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h4 class="card-title text-primary"><?= $device->deviceName ?></h4>
                        <table class="table mt-3">
                            <tr>
                                <th width="150">Mã thiết bị:</th>
                                <td><?= $device->id ?></td>
                            </tr>
                            <tr>
                                <th>Loại thiết bị:</th>
                                <td><?= $device->category ?></td>
                            </tr>
                            <tr>
                                <th>Hãng sản xuất:</th>
                                <td><?= $device->brand ?></td>
                            </tr>
                            <tr>
                                <th>Giá:</th>
                                <td><strong class="text-danger"><?= number_format($device->price, 0) ?> đ</strong></td>
                            </tr>
                            <tr>
                                <th>Số lượng:</th>
                                <td><?= $device->quantity ?></td>
                            </tr>
                            <tr>
                                <th>Trạng thái:</th>
                                <?php
                                $statusClass = "";
                                if ($device->status == "Còn trống") {
                                    $statusClass = "status-trong"; 
                                } else if ($device->status == "Đã đặt") {
                                    $statusClass = "status-dat"; 
                                } else if ($device->status == "Bảo trì") {
                                    $statusClass = "status-baotri"; 
                                }
                                ?>
                                <td class="<?= $statusClass ?>"><?= $device->status ?></td>
                            </tr>
                            <tr>
                                <th>Vị trí:</th>
                                <td><?= $device->location ?></td>
                            </tr>
                            <tr>
                                <th>Mô tả:</th>
                                <td><?= $device->description ?></td>
                            </tr>
                        </table>
                        <a href="index.php" class="btn btn-secondary">Quay lại danh sách</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php
require_once "includes/footer.php";
?>
