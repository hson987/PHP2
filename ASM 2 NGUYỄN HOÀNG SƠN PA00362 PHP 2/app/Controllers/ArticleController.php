<?php
namespace App\Controllers;

use App\Models\ArticleModel;

class ArticleController extends Controller {
    private $articleModel;

    public function __construct() {
        parent::__construct();
        $this->articleModel = new ArticleModel();
    }

    // Danh sách tin tức - frontend
    public function listArticles() {
        $articles = $this->articleModel->getAllArticles();
        $this->render('frontend.news', ['articles' => $articles]);
    }

    // Chi tiết bài viết - frontend
    public function detailArticle($id) {
        $article = $this->articleModel->getArticleById($id);
        if (!$article) {
            header('Location: ' . BASE_URL . '/news');
            exit;
        }
        $related = $this->articleModel->getAllArticles();
        $related = array_filter($related, fn($a) => $a['id'] != $id);
        $related = array_slice(array_values($related), 0, 3);

        $this->render('frontend.news-detail', [
            'article' => $article,
            'related' => $related,
        ]);
    }
}
