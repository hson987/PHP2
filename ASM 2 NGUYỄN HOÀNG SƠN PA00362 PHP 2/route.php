<?php
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;

$router = new RouteCollector();

// Định nghĩa các route của dự án nông sản Z DEMO
$router->get('/', ['App\Controllers\ProductController', 'listProducts']);
$router->get('/products', ['App\Controllers\ProductController', 'storeProducts']);
$router->get('/product/{id:\d+}', ['App\Controllers\ProductController', 'detailProduct']);
$router->get('/product/{id:\d+}/delete', ['App\Controllers\ProductController', 'deleteProduct']);
$router->post('/product/add', ['App\Controllers\ProductController', 'addProduct']);
$router->get('/about', ['App\Controllers\ProductController', 'about']);
$router->get('/contact', ['App\Controllers\ProductController', 'contact']);
$router->post('/contact', ['App\Controllers\ProductController', 'contact']);

// Định nghĩa các định tuyến Tin tức (News/Articles)
$router->get('/news', ['App\Controllers\ArticleController', 'listArticles']);
$router->get('/news/{id:\d+}', ['App\Controllers\ArticleController', 'detailArticle']);

// Định nghĩa các định tuyến Xác thực (Auth)
$router->get('/login', ['App\Controllers\AuthController', 'login']);
$router->post('/login', ['App\Controllers\AuthController', 'login']);
$router->get('/register', ['App\Controllers\AuthController', 'register']);
$router->post('/register', ['App\Controllers\AuthController', 'register']);
$router->get('/logout', ['App\Controllers\AuthController', 'logout']);
$router->get('/forgot-password', ['App\Controllers\AuthController', 'forgotPassword']);
$router->post('/forgot-password', ['App\Controllers\AuthController', 'forgotPassword']);
$router->get('/reset-password', ['App\Controllers\AuthController', 'resetPassword']);
$router->post('/reset-password', ['App\Controllers\AuthController', 'resetPassword']);

// Định nghĩa các định tuyến Quản trị (Admin)
$router->get('/admin/products', ['App\Controllers\AdminController', 'listProducts']);
$router->get('/admin/product/add', ['App\Controllers\AdminController', 'addProduct']);
$router->post('/admin/product/add', ['App\Controllers\AdminController', 'addProduct']);
$router->get('/admin/product/edit/{id:\d+}', ['App\Controllers\AdminController', 'editProduct']);
$router->post('/admin/product/edit/{id:\d+}', ['App\Controllers\AdminController', 'editProduct']);
$router->get('/admin/product/delete/{id:\d+}', ['App\Controllers\AdminController', 'deleteProduct']);

// Định nghĩa các định tuyến Quản trị Nhân viên (Staff Admin)
$router->get('/admin/employees', ['App\Controllers\AdminController', 'listEmployees']);
$router->get('/admin/employee/add', ['App\Controllers\AdminController', 'addEmployee']);
$router->post('/admin/employee/add', ['App\Controllers\AdminController', 'addEmployee']);
$router->get('/admin/employee/edit/{id:\d+}', ['App\Controllers\AdminController', 'editEmployee']);
$router->post('/admin/employee/edit/{id:\d+}', ['App\Controllers\AdminController', 'editEmployee']);
$router->get('/admin/employee/delete/{id:\d+}', ['App\Controllers\AdminController', 'deleteEmployee']);

// Định nghĩa các định tuyến Quản trị Tài khoản (User/Account Admin)
$router->get('/admin/users', ['App\Controllers\AdminController', 'listUsers']);
$router->get('/admin/user/add', ['App\Controllers\AdminController', 'addUser']);
$router->post('/admin/user/add', ['App\Controllers\AdminController', 'addUser']);
$router->get('/admin/user/edit/{id:\d+}', ['App\Controllers\AdminController', 'editUser']);
$router->post('/admin/user/edit/{id:\d+}', ['App\Controllers\AdminController', 'editUser']);
$router->get('/admin/user/delete/{id:\d+}', ['App\Controllers\AdminController', 'deleteUser']);

// Định nghĩa các định tuyến Quản trị Tin tức (Admin Articles)
$router->get('/admin/articles', ['App\Controllers\AdminController', 'listArticles']);
$router->get('/admin/article/add', ['App\Controllers\AdminController', 'addArticle']);
$router->post('/admin/article/add', ['App\Controllers\AdminController', 'addArticle']);
$router->get('/admin/article/edit/{id:\d+}', ['App\Controllers\AdminController', 'editArticle']);
$router->post('/admin/article/edit/{id:\d+}', ['App\Controllers\AdminController', 'editArticle']);
$router->get('/admin/article/delete/{id:\d+}', ['App\Controllers\AdminController', 'deleteArticle']);

// Định nghĩa các định tuyến Quản trị Danh mục (Admin Categories)
$router->get('/admin/categories', ['App\Controllers\AdminController', 'listCategories']);
$router->get('/admin/category/add', ['App\Controllers\AdminController', 'addCategory']);
$router->post('/admin/category/add', ['App\Controllers\AdminController', 'addCategory']);
$router->get('/admin/category/edit/{id:\d+}', ['App\Controllers\AdminController', 'editCategory']);
$router->post('/admin/category/edit/{id:\d+}', ['App\Controllers\AdminController', 'editCategory']);
$router->get('/admin/category/delete/{id:\d+}', ['App\Controllers\AdminController', 'deleteCategory']);

$router->get('/import-db', function() {
    $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
    $port = $_ENV['DB_PORT'] ?? '3306';
    $dbname = $_ENV['DB_NAME'] ?? 'asm2_zdemo_php2';
    $user = $_ENV['DB_USER'] ?? 'root';
    $pass = $_ENV['DB_PASS'] ?? '';

    try {
        $db = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $user, $pass, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = file_get_contents(__DIR__ . '/database.sql');
        $db->exec($sql);
        
        // Clear session demo data to force reload from DB
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['demo_products']);
        unset($_SESSION['demo_sale_products']);
        
        return "<div style='font-family: sans-serif; text-align: center; padding: 50px; line-height: 1.6;'>
                    <h1 style='color: #10b981;'>Import database thành công!</h1>
                    <p>Dữ liệu tiếng Việt có dấu đã được cài đặt và lưu trữ dưới dạng UTF-8 chính xác.</p>
                    <a href='" . BASE_URL . "/' style='display: inline-block; background: #10b981; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-top: 15px;'>Quay lại Trang chủ</a>
                 </div>";
    } catch (\PDOException $e) {
        return "<div style='font-family: sans-serif; text-align: center; padding: 50px; line-height: 1.6;'>
                    <h1 style='color: #ef4444;'>Lỗi khi import database!</h1>
                    <p>" . htmlspecialchars($e->getMessage()) . "</p>
                    <a href='" . BASE_URL . "/' style='color: #10b981; text-decoration: none; font-weight: bold;'>Quay lại Trang chủ</a>
                 </div>";
    }
});

// Lấy đường dẫn URL được xử lý bởi RewriteRule của .htaccess
$url = $_GET['url'] ?? '/';
if ($url !== '/' && strpos($url, '/') !== 0) {
    $url = '/' . $url;
}

if ($url !== '/') {
    $url = rtrim($url, '/');
}

$dispatcher = new Dispatcher($router->getData());

try {
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);
    if ($response !== null) {
        echo $response;
    }
} catch (HttpRouteNotFoundException $e) {
    header("HTTP/1.0 404 Not Found");
    echo "<div style='font-family: sans-serif; text-align: center; padding: 50px;'>";
    echo "<h1 style='color: #10b981;'>404 Not Found</h1>";
    echo "<p>Đường dẫn không tồn tại trên hệ thống.</p>";
    echo "<a href='" . BASE_URL . "/' style='color: #10b981; text-decoration: none; font-weight: bold;'>Quay lại Trang chủ</a>";
    echo "</div>";
} catch (HttpMethodNotAllowedException $e) {
    header("HTTP/1.0 405 Method Not Allowed");
    echo "<div style='font-family: sans-serif; text-align: center; padding: 50px;'>";
    echo "<h1 style='color: #ef4444;'>405 Method Not Allowed</h1>";
    echo "<p>Phương thức HTTP không được hỗ trợ.</p>";
    echo "<a href='" . BASE_URL . "/' style='color: #10b981; text-decoration: none; font-weight: bold;'>Quay lại Trang chủ</a>";
    echo "</div>";
}
