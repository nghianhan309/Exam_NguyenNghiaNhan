<?php
require_once __DIR__ . '/../models/Device.php';

class DeviceDao
{
    public $devices = [];

    public function __construct()
    {
        // Khởi tạo tối thiểu 10 đối tượng
        $this->devices = [
            new Device(1, "Router Wifi 6 Asus", "Thiết bị mạng", "Asus", 2500000, 15, "Còn trống", "Phòng IT", "assets/images/img1.jpg", "Router Wifi tốc độ cao"),
            new Device(2, "Switch 24-Port Cisco", "Thiết bị mạng", "Cisco", 5000000, 5, "Đã đặt", "Tủ Rack 1", "assets/images/img2.jpg", "Bộ chia mạng 24 cổng gigabit"),
            new Device(3, "Ổ cứng mạng NAS Synology", "Lưu trữ", "Synology", 12000000, 3, "Bảo trì", "Kho Dữ liệu", "assets/images/img3.jpg", "Hệ thống lưu trữ đám mây nội bộ"),
            new Device(4, "Máy chủ Dell PowerEdge", "Máy chủ", "Dell", 55000000, 2, "Còn trống", "Datacenter", "assets/images/img4.jpg", "Máy chủ cấu hình mạnh mẽ"),
            new Device(5, "Tủ mạng Rack 42U", "Phụ kiện", "APC", 6500000, 4, "Đã đặt", "Datacenter", "assets/images/img5.jpg", "Tủ chứa thiết bị viễn thông"),
            new Device(6, "Camera an ninh Hikvision", "Camera", "Hikvision", 1200000, 20, "Còn trống", "Hành lang", "assets/images/img6.jpg", "Camera hồng ngoại ban đêm"),
            new Device(7, "Khóa cửa thông minh Xiaomi", "Smart Home", "Xiaomi", 3500000, 10, "Còn trống", "Cửa chính", "assets/images/img7.jpg", "Khóa vân tay an toàn"),
            new Device(8, "Đèn thông minh Philips Hue", "Smart Home", "Philips", 1500000, 30, "Bảo trì", "Phòng họp", "assets/images/img8.jpg", "Đèn đổi màu 16 triệu màu"),
            new Device(9, "Loa Google Nest", "Âm thanh", "Google", 2000000, 8, "Còn trống", "Lễ tân", "assets/images/img9.jpg", "Loa trợ lý ảo thông minh"),
            new Device(10, "Robot hút bụi Roborock", "Smart Home", "Roborock", 10000000, 5, "Đã đặt", "Kho vệ sinh", "assets/images/img10.jpg", "Robot lau nhà tự động giặt giẻ"),
            new Device(11, "Màn hình ViewSonic 75inch", "Màn hình", "ViewSonic", 40000000, 2, "Còn trống", "Phòng họp lớn", "assets/images/img11.jpg", "Màn hình tương tác thông minh"),
            new Device(12, "Máy chiếu mini XGIMI", "Máy chiếu", "XGIMI", 15000000, 4, "Đã đặt", "Phòng Demo", "assets/images/img12.jpg", "Máy chiếu di động độ nét cao")
        ];
    }

    public function getAll()
    {
        return $this->devices;
    }

    public function findById($id)
    {
        foreach ($this->devices as $device) {
            if ($device->id == $id) {
                return $device;
            }
        }
        return null;
    }

    public function search($keyword, $category = "", $status = "", $minPrice = "", $maxPrice = "")
    {
        $result = [];
        foreach ($this->devices as $device) {
            $match = true;

            // Tìm theo tên thiết bị (không phân biệt chữ hoa/thường)
            if (!empty($keyword)) {
                if (stripos($device->deviceName, $keyword) === false) {
                    $match = false;
                }
            }

            // Lọc theo loại thiết bị
            if (!empty($category)) {
                if ($device->category != $category) {
                    $match = false;
                }
            }

            // Lọc theo trạng thái
            if (!empty($status)) {
                if ($device->status != $status) {
                    $match = false;
                }
            }

            // Lọc theo khoảng giá
            if ($minPrice !== "") {
                if ($device->price < $minPrice) {
                    $match = false;
                }
            }
            if ($maxPrice !== "") {
                if ($device->price > $maxPrice) {
                    $match = false;
                }
            }

            if ($match) {
                $result[] = $device;
            }
        }
        return $result;
    }

    public function sortPriceASC($dataList)
    {
        usort($dataList, function ($a, $b) {
            if ($a->price == $b->price)
                return 0;
            return ($a->price < $b->price) ? -1 : 1;
        });
        return $dataList;
    }

    public function sortPriceDESC($dataList)
    {
        usort($dataList, function ($a, $b) {
            if ($a->price == $b->price)
                return 0;
            return ($a->price > $b->price) ? -1 : 1;
        });
        return $dataList;
    }

    public function paging($dataList, $page, $pageSize)
    {
        // Tính toán vị trí bắt đầu
        $start = ($page - 1) * $pageSize;
        // Cắt mảng
        return array_slice($dataList, $start, $pageSize);
    }
}
?>