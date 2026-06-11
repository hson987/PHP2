<?php
namespace App\Models;

class ArticleModel extends Model {

    // Lấy tất cả bài viết tin tức
    public function getAllArticles() {
        $stmt = $this->db->prepare("SELECT * FROM articles ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy bài viết theo ID
    public function getArticleById($id) {
        $stmt = $this->db->prepare("SELECT * FROM articles WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Thêm bài viết mới
    public function addArticle($data) {
        $sql = "INSERT INTO articles (title, image, description) VALUES (:title, :image, :description)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'title'       => $data['title'],
            'image'       => $data['image'],
            'description' => $data['description'],
        ]);
    }

    // Cập nhật bài viết
    public function updateArticle($id, $data) {
        $sql = "UPDATE articles SET title=:title, image=:image, description=:description WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id'          => $id,
            'title'       => $data['title'],
            'image'       => $data['image'],
            'description' => $data['description'],
        ]);
    }

    // Xóa bài viết
    public function deleteArticle($id) {
        $stmt = $this->db->prepare("DELETE FROM articles WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
