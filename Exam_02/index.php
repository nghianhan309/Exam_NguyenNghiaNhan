<?php
require_once "dao/DeviceDao.php";
$dao = new DeviceDao();

$allDevices = $dao->getAll();

// Thống kê
$totalDevices = count($allDevices);
$totalConTrong = 0;
$totalDaDat = 0;
$totalBaoTri = 0;

foreach ($allDevices as $dev) {
    if ($dev->status == "Còn trống") {
        $totalConTrong++;
    }
    if ($dev->status == "Đã đặt") {
        $totalDaDat++;
    }
    if ($dev->status == "Bảo trì") {
        $totalBaoTri++;
    }
}

// Xử lý sắp xếp
$sort = "";
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
}

$displayList = $allDevices;
if ($sort == "asc") {
    $displayList = $dao->sortPriceASC($displayList);
} else if ($sort == "desc") {
    $displayList = $dao->sortPriceDESC($displayList);
}

// Xử lý phân trang
$pageSize = 5;
$totalItems = count($displayList);
$totalPages = ceil($totalItems / $pageSize);

$page = 1;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
}
if ($page < 1) $page = 1;
if ($page > $totalPages && $totalPages > 0) $page = $totalPages;

// Lấy dữ liệu cho trang hiện tại
$pagedList = $dao->paging($displayList, $page, $pageSize);

require_once "includes/header.php";
require_once "includes/menu.php";
?>

<div class="container mb-5">
    <!-- Thống kê -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Tổng thiết bị</div>
                <div class="card-body"><h4 class="card-title"><?= $totalDevices ?></h4></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Còn trống</div>
                <div class="card-body"><h4 class="card-title"><?= $totalConTrong ?></h4></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Đã đặt</div>
                <div class="card-body"><h4 class="card-title"><?= $totalDaDat ?></h4></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-dark bg-warning mb-3">
                <div class="card-header">Bảo trì</div>
                <div class="card-body"><h4 class="card-title"><?= $totalBaoTri ?></h4></div>
            </div>
        </div>
    </div>

    <!-- Sắp xếp -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Danh sách Thiết Bị</h4>
        <div>
            Sắp xếp theo giá: 
            <a href="?sort=asc" class="btn btn-outline-secondary btn-sm <?= ($sort == 'asc') ? 'active' : '' ?>">Tăng dần</a>
            <a href="?sort=desc" class="btn btn-outline-secondary btn-sm <?= ($sort == 'desc') ? 'active' : '' ?>">Giảm dần</a>
        </div>
    </div>

    <!-- Bảng danh sách -->
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>STT</th>
                <th>Hình ảnh</th>
                <th>Tên thiết bị</th>
                <th>Loại</th>
                <th>Hãng</th>
                <th>Giá (đ)</th>
                <th>Số lượng</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stt = ($page - 1) * $pageSize + 1;
            foreach ($pagedList as $device) {
                // Xác định màu trạng thái
                $statusClass = "";
                if ($device->status == "Còn trống") {
                    $statusClass = "status-trong"; // màu xanh (theo style.css)
                } else if ($device->status == "Đã đặt") {
                    $statusClass = "status-dat"; // màu đỏ
                } else if ($device->status == "Bảo trì") {
                    $statusClass = "status-baotri"; // màu vàng
                }
            ?>
                <tr>
                    <td><?= $stt++; ?></td>
                    <td><img src="<?= $device->image ?>" alt="<?= $device->deviceName ?>" class="device-img"></td>
                    <td><?= $device->deviceName ?></td>
                    <td><?= $device->category ?></td>
                    <td><?= $device->brand ?></td>
                    <td><?= number_format($device->price, 0) ?> đ</td>
                    <td><?= $device->quantity ?></td>
                    <td class="<?= $statusClass ?>"><?= $device->status ?></td>
                    <td>
                        <a href="detail.php?id=<?= $device->id ?>" class="btn btn-info btn-sm">Chi tiết</a>
                    </td>
                </tr>
            <?php
            }
            if (count($pagedList) == 0) {
                echo '<tr><td colspan="9" class="text-center">Không có thiết bị nào.</td></tr>';
            }
            ?>
        </tbody>
    </table>

    <!-- Phân trang -->
    <?php if ($totalPages > 1) { ?>
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?><?= ($sort != '') ? '&sort='.$sort : '' ?>"><?= $i ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    <?php } ?>

</div>

<?php
require_once "includes/footer.php";
?>
