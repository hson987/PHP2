<?php
namespace App\Models;

class CategoryModel extends Model {

    // Lấy tất cả danh mục
    public function getAllCategories() {
        $stmt = $this->db->prepare("SELECT * FROM categories ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy danh mục theo ID
    public function getCategoryById($id) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Lấy danh mục theo Code/Slug
    public function getCategoryByCode($code) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE code = :code");
        $stmt->execute(['code' => $code]);
        return $stmt->fetch();
    }

    // Thêm danh mục mới
    public function createCategory($data) {
        $sql = "INSERT INTO categories (code, name) VALUES (:code, :name)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'code' => $data['code'],
            'name' => $data['name'],
        ]);
    }

    // Cập nhật danh mục
    public function updateCategory($id, $data) {
        $sql = "UPDATE categories SET code = :code, name = :name WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id'   => $id,
            'code' => $data['code'],
            'name' => $data['name'],
        ]);
    }

    // Xóa danh mục
    public function deleteCategory($id) {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
