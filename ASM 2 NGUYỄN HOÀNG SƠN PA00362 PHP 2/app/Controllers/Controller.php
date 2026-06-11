<?php
namespace App\Controllers;

use eftec\bladeone\BladeOne;

class Controller {
    protected $blade;

    public function __construct() {
        $views = __DIR__ . '/../../views';
        $cache = __DIR__ . '/../../cache';
        
        // Tạo thư mục cache nếu chưa tồn tại
        if (!is_dir($cache)) {
            mkdir($cache, 0777, true);
        }
        
        $this->blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);
    }

    public function render($view, $data = []) {
        echo $this->blade->run($view, $data);
    }

    /**
     * Phân tích chuỗi ảnh (JSON array hoặc chuỗi đơn) thành mảng đường dẫn ảnh.
     * Đảm bảo tương thích ngược với dữ liệu sản phẩm cũ chỉ có 1 ảnh.
     */
    protected function parseImages($image_str) {
        if (empty($image_str)) {
            return ['uploads/product_hero_showcase.jpg'];
        }
        $decoded = json_decode($image_str, true);
        if (is_array($decoded) && !empty($decoded)) {
            return array_values(array_filter(array_map('trim', $decoded)));
        }
        return [trim($image_str)];
    }
}
