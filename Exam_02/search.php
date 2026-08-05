<?php
require_once "dao/DeviceDao.php";
$dao = new DeviceDao();

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
$category = isset($_GET['category']) ? $_GET['category'] : "";
$status = isset($_GET['status']) ? $_GET['status'] : "";
$minPrice = isset($_GET['minPrice']) ? $_GET['minPrice'] : "";
$maxPrice = isset($_GET['maxPrice']) ? $_GET['maxPrice'] : "";

$isSearched = isset($_GET['btnSearch']);

$resultList = [];
if ($isSearched) {
    $resultList = $dao->search($keyword, $category, $status, $minPrice, $maxPrice);
}

require_once "includes/header.php";
require_once "includes/menu.php";
?>

<div class="container mb-5">
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Tìm kiếm Thiết Bị</h5>
        </div>
        <div class="card-body">
            <form method="get" action="search.php">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Tên thiết bị:</label>
                        <input type="text" name="keyword" class="form-control" value="<?= htmlspecialchars($keyword) ?>" placeholder="Nhập tên thiết bị cần tìm...">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">Loại thiết bị:</label>
                        <select name="category" class="form-select">
                            <option value="">-- Tất cả --</option>
                            <option value="Thiết bị mạng" <?= ($category == "Thiết bị mạng") ? "selected" : "" ?>>Thiết bị mạng</option>
                            <option value="Lưu trữ" <?= ($category == "Lưu trữ") ? "selected" : "" ?>>Lưu trữ</option>
                            <option value="Máy chủ" <?= ($category == "Máy chủ") ? "selected" : "" ?>>Máy chủ</option>
                            <option value="Phụ kiện" <?= ($category == "Phụ kiện") ? "selected" : "" ?>>Phụ kiện</option>
                            <option value="Camera" <?= ($category == "Camera") ? "selected" : "" ?>>Camera</option>
                            <option value="Smart Home" <?= ($category == "Smart Home") ? "selected" : "" ?>>Smart Home</option>
                            <option value="Âm thanh" <?= ($category == "Âm thanh") ? "selected" : "" ?>>Âm thanh</option>
                            <option value="Màn hình" <?= ($category == "Màn hình") ? "selected" : "" ?>>Màn hình</option>
                            <option value="Máy chiếu" <?= ($category == "Máy chiếu") ? "selected" : "" ?>>Máy chiếu</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Trạng thái:</label>
                        <select name="status" class="form-select">
                            <option value="">-- Tất cả --</option>
                            <option value="Còn trống" <?= ($status == "Còn trống") ? "selected" : "" ?>>Còn trống</option>
                            <option value="Đã đặt" <?= ($status == "Đã đặt") ? "selected" : "" ?>>Đã đặt</option>
                            <option value="Bảo trì" <?= ($status == "Bảo trì") ? "selected" : "" ?>>Bảo trì</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Giá từ (đ):</label>
                        <input type="number" name="minPrice" class="form-control" value="<?= htmlspecialchars($minPrice) ?>" placeholder="VD: 1000000">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Giá đến (đ):</label>
                        <input type="number" name="maxPrice" class="form-control" value="<?= htmlspecialchars($maxPrice) ?>" placeholder="VD: 5000000">
                    </div>
                </div>
                
                <div class="mt-4 text-center">
                    <button type="submit" name="btnSearch" class="btn btn-primary px-5">Tìm Kiếm</button>
                    <a href="search.php" class="btn btn-secondary px-4">Xóa Bộ Lọc</a>
                </div>
            </form>
        </div>
    </div>

    <?php if ($isSearched) { ?>
        <h5 class="mb-3">Kết quả tìm kiếm (Tìm thấy <?= count($resultList) ?> thiết bị)</h5>
        
        <?php if (count($resultList) > 0) { ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($resultList as $dev) { 
                    $statusClass = "";
                    if ($dev->status == "Còn trống") $statusClass = "status-trong"; 
                    else if ($dev->status == "Đã đặt") $statusClass = "status-dat"; 
                    else if ($dev->status == "Bảo trì") $statusClass = "status-baotri"; 
                ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="<?= $dev->image ?>" class="card-img-top mx-auto mt-3" style="width:150px;" alt="...">
                            <div class="card-body text-center">
                                <h5 class="card-title text-primary"><?= $dev->deviceName ?></h5>
                                <p class="card-text mb-1">Hãng: <?= $dev->brand ?> | Loại: <?= $dev->category ?></p>
                                <p class="card-text text-danger fw-bold mb-1"><?= number_format($dev->price, 0) ?> đ</p>
                                <p class="card-text mb-3">Trạng thái: <span class="<?= $statusClass ?>"><?= $dev->status ?></span></p>
                                <a href="detail.php?id=<?= $dev->id ?>" class="btn btn-outline-info btn-sm">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="alert alert-warning text-center">Không tìm thấy thiết bị nào phù hợp với tiêu chí tìm kiếm.</div>
        <?php } ?>
    <?php } ?>
</div>

<?php
require_once "includes/footer.php";
?>
