<?php
class Device {
    public $id;
    public $deviceName;
    public $category;
    public $brand;
    public $price;
    public $quantity;
    public $status;
    public $location;
    public $image;
    public $description;

    public function __construct($id, $deviceName, $category, $brand, $price, $quantity, $status, $location, $image, $description) {
        $this->id = $id;
        $this->deviceName = $deviceName;
        $this->category = $category;
        $this->brand = $brand;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->status = $status;
        $this->location = $location;
        $this->image = $image;
        $this->description = $description;
    }
}
?>
