<?php
namespace App\Models;

class ProductModel extends Model {
    
    // Lấy toàn bộ sản phẩm nông sản thường (Không sale)
    public function getAllProducts() {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE is_sale = 0 ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy danh sách sản phẩm khuyến mãi (Săn Sale)
    public function getSaleProducts() {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE is_sale = 1 ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy chi tiết sản phẩm theo ID
    public function getProductById($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Xóa sản phẩm nông sản theo ID
    public function deleteProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Thêm sản phẩm mới vào CSDL
    public function addProduct($data) {
        $sql = "INSERT INTO products (name, price, original_price, discount_percent, image, description, is_sale, category) 
                VALUES (:name, :price, :original_price, :discount_percent, :image, :description, :is_sale, :category)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'original_price' => $data['original_price'] !== '' && $data['original_price'] !== null ? $data['original_price'] : null,
            'discount_percent' => !empty($data['discount_percent']) ? intval($data['discount_percent']) : 0,
            'image' => !empty($data['image']) ? $data['image'] : 'uploads/product_hero_showcase.jpg',
            'description' => $data['description'] ?? '',
            'is_sale' => isset($data['is_sale']) ? intval($data['is_sale']) : 0,
            'category' => $data['category'] ?? 'rau_cu'
        ]);
    }

    // Lấy toàn bộ bài viết từ CSDL
    public function getAllArticles() {
        $stmt = $this->db->prepare("SELECT * FROM articles ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy toàn bộ sản phẩm (không phân biệt sale/thường) cho admin
    public function getAdminAllProducts() {
        $stmt = $this->db->prepare("SELECT * FROM products ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Cập nhật thông tin sản phẩm
    public function updateProduct($id, $data) {
        $sql = "UPDATE products SET 
                name = :name, 
                price = :price, 
                original_price = :original_price, 
                discount_percent = :discount_percent, 
                image = :image, 
                description = :description, 
                is_sale = :is_sale, 
                category = :category 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'original_price' => $data['original_price'] !== '' && $data['original_price'] !== null ? $data['original_price'] : null,
            'discount_percent' => !empty($data['discount_percent']) ? intval($data['discount_percent']) : 0,
            'image' => !empty($data['image']) ? $data['image'] : 'uploads/product_hero_showcase.jpg',
            'description' => $data['description'] ?? '',
            'is_sale' => isset($data['is_sale']) ? intval($data['is_sale']) : 0,
            'category' => $data['category'] ?? 'rau_cu',
            'id' => $id
        ]);
    }

    // Lấy danh sách khuyến mãi đang hoạt động
    public function getPromotions($limit = 6) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM promotions WHERE is_active = 1 ORDER BY sort_order ASC LIMIT :limit");
            $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            return [];
        }
    }

    // Lấy bài viết mới nhất (cho trang chủ)
    public function getLatestArticles($limit = 3) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM articles ORDER BY id DESC LIMIT :limit");
            $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            return [];
        }
    }
}
