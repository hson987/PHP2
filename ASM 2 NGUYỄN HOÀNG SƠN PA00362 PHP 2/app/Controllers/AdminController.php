<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\UserModel;
use App\Models\ArticleModel;
use App\Models\CategoryModel;

class AdminController extends Controller {
    private $productModel;
    private $userModel;
    private $articleModel;
    private $categoryModel;


    public function __construct() {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Bảo mật phân quyền: Chỉ cho phép Admin truy cập
        if (!isset($_SESSION['admin'])) {
            $_SESSION['auth_error'] = 'Bạn cần đăng nhập bằng tài khoản Quản trị viên để vào trang này!';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
        $this->articleModel = new ArticleModel();
        $this->categoryModel = new CategoryModel();
    }

    // Hiển thị danh sách sản phẩm quản trị
    public function listProducts() {
        $products = $this->productModel->getAdminAllProducts();

        // Tính toán các thông số thống kê
        $totalProducts = count($products);
        $saleProductsCount = 0;
        $normalProductsCount = 0;
        $categories = [];

        foreach ($products as $p) {
            if ($p['is_sale'] == 1) {
                $saleProductsCount++;
            } else {
                $normalProductsCount++;
            }
            if (!empty($p['category'])) {
                $categories[$p['category']] = true;
            }
        }
        $totalCategories = count($categories);

        $this->render('backend.products.index', [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'saleProductsCount' => $saleProductsCount,
            'normalProductsCount' => $normalProductsCount,
            'totalCategories' => $totalCategories
        ]);
    }

    // Thêm sản phẩm mới
    public function addProduct() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $original_price = isset($_POST['original_price']) && $_POST['original_price'] !== '' ? floatval($_POST['original_price']) : null;
            $discount_percent = isset($_POST['discount_percent']) && $_POST['discount_percent'] !== '' ? intval($_POST['discount_percent']) : 0;
            $category = trim($_POST['category'] ?? 'rau_cu');
            $is_sale = isset($_POST['is_sale']) ? 1 : 0;
            $description = trim($_POST['description'] ?? '');

            if ($name === '' || $price <= 0) {
                $error = 'Vui lòng nhập tên sản phẩm hợp lệ và giá bán phải lớn hơn 0!';
            } else {
                // Xử lý upload file ảnh - hỗ trợ tối đa 6 ảnh
                $images = [];
                $uploadFileDir = __DIR__ . '/../../uploads/';
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0777, true);
                }
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                for ($i = 1; $i <= 6; $i++) {
                    $fileKey = 'image_file_' . $i;
                    $urlKey  = 'image_url_' . $i;

                    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
                        $fileTmpPath   = $_FILES[$fileKey]['tmp_name'];
                        $fileName      = $_FILES[$fileKey]['name'];
                        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                        if (in_array($fileExtension, $allowedExtensions)) {
                            $newFileName = 'product_' . time() . '_' . rand(1000, 9999) . '_' . $i . '.' . $fileExtension;
                            $destPath    = $uploadFileDir . $newFileName;
                            if (move_uploaded_file($fileTmpPath, $destPath)) {
                                $images[] = 'uploads/' . $newFileName;
                            }
                        }
                    } elseif (!empty($_POST[$urlKey])) {
                        $imgUrl = trim($_POST[$urlKey]);
                        if (!preg_match('/^https?:\/\//i', $imgUrl) && !preg_match('/^uploads\//i', $imgUrl)) {
                            $imgUrl = 'uploads/' . $imgUrl;
                        }
                        $images[] = $imgUrl;
                    }
                }

                // Nếu không có ảnh nào được cung cấp, dùng ảnh mặc định
                if (empty($images)) {
                    $images = ['uploads/product_hero_showcase.jpg'];
                }

                // Lưu dưới dạng JSON nếu nhiều ảnh, còn nếu chỉ 1 ảnh lưu dưới dạng chuỗi thường để tương thích cũ
                $imageValue = count($images) > 1 ? json_encode($images, JSON_UNESCAPED_UNICODE) : $images[0];

                $productData = [
                    'name'             => $name,
                    'price'            => $price,
                    'original_price'   => $original_price,
                    'discount_percent' => $discount_percent,
                    'image'            => $imageValue,
                    'description'      => $description,
                    'is_sale'          => $is_sale,
                    'category'         => $category
                ];

                $result = $this->productModel->addProduct($productData);
                if ($result) {
                    $_SESSION['admin_success'] = 'Thêm sản phẩm mới "' . htmlspecialchars($name) . '" thành công!';
                    header('Location: ' . BASE_URL . '/admin/products');
                    exit;
                } else {
                    $error = 'Có lỗi xảy ra khi lưu sản phẩm vào cơ sở dữ liệu!';
                }
            }
        }

        $categories = $this->categoryModel->getAllCategories();
        $this->render('backend.products.create', [
            'error'      => $error,
            'success'    => $success,
            'categories' => $categories
        ]);
    }

    // Chỉnh sửa thông tin sản phẩm
    public function editProduct($id) {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            header('Location: ' . BASE_URL . '/admin/products');
            exit;
        }

        $error = '';
        $success = '';

        // Giải mã ảnh hiện tại của sản phẩm
        $currentImages = $this->parseImages($product['image']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $original_price = isset($_POST['original_price']) && $_POST['original_price'] !== '' ? floatval($_POST['original_price']) : null;
            $discount_percent = isset($_POST['discount_percent']) && $_POST['discount_percent'] !== '' ? intval($_POST['discount_percent']) : 0;
            $category = trim($_POST['category'] ?? 'rau_cu');
            $is_sale = isset($_POST['is_sale']) ? 1 : 0;
            $description = trim($_POST['description'] ?? '');

            if ($name === '' || $price <= 0) {
                $error = 'Vui lòng nhập tên sản phẩm hợp lệ và giá bán phải lớn hơn 0!';
            } else {
                // Xử lý upload file ảnh - hỗ trợ tối đa 6 ảnh
                $images = [];
                $uploadFileDir = __DIR__ . '/../../uploads/';
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0777, true);
                }
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                for ($i = 1; $i <= 6; $i++) {
                    $fileKey = 'image_file_' . $i;
                    $urlKey  = 'image_url_' . $i;

                    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
                        $fileTmpPath   = $_FILES[$fileKey]['tmp_name'];
                        $fileName      = $_FILES[$fileKey]['name'];
                        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                        if (in_array($fileExtension, $allowedExtensions)) {
                            $newFileName = 'product_' . time() . '_' . rand(1000, 9999) . '_' . $i . '.' . $fileExtension;
                            $destPath    = $uploadFileDir . $newFileName;
                            if (move_uploaded_file($fileTmpPath, $destPath)) {
                                $images[] = 'uploads/' . $newFileName;
                            }
                        }
                    } elseif (!empty($_POST[$urlKey])) {
                        $imgUrl = trim($_POST[$urlKey]);
                        if (!preg_match('/^https?:\/\//i', $imgUrl) && !preg_match('/^uploads\//i', $imgUrl)) {
                            $imgUrl = 'uploads/' . $imgUrl;
                        }
                        $images[] = $imgUrl;
                    }
                }

                // Nếu không upload ảnh mới nào, giữ lại ảnh cũ
                if (empty($images)) {
                    $images = $currentImages;
                }

                // Lưu dưới dạng JSON nếu nhiều ảnh, còn nếu chỉ 1 ảnh lưu dưới dạng chuỗi thường
                $imageValue = count($images) > 1 ? json_encode($images, JSON_UNESCAPED_UNICODE) : $images[0];

                $productData = [
                    'name'             => $name,
                    'price'            => $price,
                    'original_price'   => $original_price,
                    'discount_percent' => $discount_percent,
                    'image'            => $imageValue,
                    'description'      => $description,
                    'is_sale'          => $is_sale,
                    'category'         => $category
                ];

                $result = $this->productModel->updateProduct($id, $productData);
                if ($result) {
                    $_SESSION['admin_success'] = 'Cập nhật sản phẩm "' . htmlspecialchars($name) . '" thành công!';
                    header('Location: ' . BASE_URL . '/admin/products');
                    exit;
                } else {
                    $error = 'Có lỗi xảy ra khi cập nhật thông tin sản phẩm!';
                }
            }
        }

        $categories = $this->categoryModel->getAllCategories();
        $this->render('backend.products.edit', [
            'product'       => $product,
            'currentImages' => $currentImages,
            'error'         => $error,
            'success'       => $success,
            'categories'    => $categories
        ]);
    }

    // Xóa sản phẩm
    public function deleteProduct($id) {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            $this->productModel->deleteProduct($id);
            $_SESSION['admin_success'] = 'Đã xóa sản phẩm "' . htmlspecialchars($product['name']) . '" thành công!';
        }
        header('Location: ' . BASE_URL . '/admin/products');
        exit;
    }

    // Hiển thị danh sách nhân viên
    public function listEmployees() {
        $employees = $this->userModel->getEmployees();
        $totalEmployees = count($employees);

        $this->render('backend.employees.index', [
            'employees' => $employees,
            'totalEmployees' => $totalEmployees
        ]);
    }

    // Thêm nhân viên mới
    public function addEmployee() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($fullname === '' || $email === '' || $password === '') {
                $error = 'Vui lòng điền đầy đủ thông tin nhân viên!';
            } elseif (strlen($password) < 6) {
                $error = 'Mật khẩu phải chứa ít nhất 6 ký tự!';
            } else {
                $existing = $this->userModel->getUserByEmail($email);
                if ($existing) {
                    $error = 'Email này đã tồn tại trong hệ thống!';
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $result = $this->userModel->createUser($fullname, $email, $hashedPassword, 'staff');
                    if ($result) {
                        $_SESSION['admin_success'] = 'Đã thêm nhân viên mới "' . htmlspecialchars($fullname) . '" thành công!';
                        header('Location: ' . BASE_URL . '/admin/employees');
                        exit;
                    } else {
                        $error = 'Có lỗi xảy ra khi tạo tài khoản nhân viên, vui lòng thử lại!';
                    }
                }
            }
        }

        $this->render('backend.employees.create', [
            'error' => $error,
            'success' => $success
        ]);
    }

    // Chỉnh sửa nhân viên
    public function editEmployee($id) {
        $employee = $this->userModel->getUserById($id);
        if (!$employee || $employee['role'] !== 'staff') {
            header('Location: ' . BASE_URL . '/admin/employees');
            exit;
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($fullname === '' || $email === '') {
                $error = 'Vui lòng điền đầy đủ các thông tin!';
            } else {
                $existing = $this->userModel->getUserByEmail($email);
                if ($existing && $existing['id'] != $id) {
                    $error = 'Email này đã tồn tại ở một tài khoản khác!';
                } else {
                    $hashedPassword = null;
                    if ($password !== '') {
                        if (strlen($password) < 6) {
                            $error = 'Mật khẩu mới phải chứa ít nhất 6 ký tự!';
                        } else {
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        }
                    }

                    if (empty($error)) {
                        $result = $this->userModel->updateEmployee($id, $fullname, $email, $hashedPassword);
                        if ($result) {
                            $_SESSION['admin_success'] = 'Đã cập nhật thông tin nhân viên "' . htmlspecialchars($fullname) . '" thành công!';
                            header('Location: ' . BASE_URL . '/admin/employees');
                            exit;
                        } else {
                            $error = 'Có lỗi xảy ra khi cập nhật thông tin nhân viên!';
                        }
                    }
                }
            }
        }

        $this->render('backend.employees.edit', [
            'employee' => $employee,
            'error' => $error,
            'success' => $success
        ]);
    }

    // Xóa nhân viên
    public function deleteEmployee($id) {
        $employee = $this->userModel->getUserById($id);
        if ($employee && $employee['role'] === 'staff') {
            $this->userModel->deleteUser($id);
            $_SESSION['admin_success'] = 'Đã xóa tài khoản nhân viên "' . htmlspecialchars($employee['fullname']) . '" thành công!';
        }
        header('Location: ' . BASE_URL . '/admin/employees');
        exit;
    }

    // ===== CRUD TIN TỨC =====

    // Danh sách tin tức
    public function listArticles() {
        $articles = $this->articleModel->getAllArticles();
        $this->render('backend.articles.index', ['articles' => $articles]);
    }

    // Thêm tin tức
    public function addArticle() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title       = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $imageUrl    = trim($_POST['image_url'] ?? '');
            $imagePath   = '';

            if ($title === '') {
                $error = 'Tiêu đề bài viết không được để trống!';
            } else {
                // Xử lý upload file ảnh
                if (!empty($_FILES['image_file']['name'])) {
                    $file    = $_FILES['image_file'];
                    $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    if (!in_array($ext, $allowed)) {
                        $error = 'Chỉ chấp nhận ảnh JPG, PNG, GIF, WEBP!';
                    } elseif ($file['size'] > 5 * 1024 * 1024) {
                        $error = 'Dung lượng ảnh không quá 5MB!';
                    } else {
                        $filename  = 'article_' . time() . '_' . uniqid() . '.' . $ext;
                        $uploadDir = __DIR__ . '/../../uploads/';
                        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                            $imagePath = 'uploads/' . $filename;
                        } else {
                            $error = 'Lỗi khi tải ảnh lên server!';
                        }
                    }
                } elseif (!empty($imageUrl)) {
                    $imagePath = $imageUrl;
                }

                if (empty($error)) {
                    $result = $this->articleModel->addArticle([
                        'title'       => $title,
                        'image'       => $imagePath,
                        'description' => $description,
                    ]);
                    if ($result) {
                        $_SESSION['admin_success'] = 'Đã thêm bài viết "' . htmlspecialchars($title) . '" thành công!';
                        header('Location: ' . BASE_URL . '/admin/articles');
                        exit;
                    } else {
                        $error = 'Có lỗi khi lưu bài viết, vui lòng thử lại!';
                    }
                }
            }
        }

        $this->render('backend.articles.create', ['error' => $error, 'success' => $success]);
    }

    // Sửa tin tức
    public function editArticle($id) {
        $article = $this->articleModel->getArticleById($id);
        if (!$article) {
            header('Location: ' . BASE_URL . '/admin/articles');
            exit;
        }

        $error   = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title       = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $imageUrl    = trim($_POST['image_url'] ?? '');
            $imagePath   = $article['image']; // Giữ ảnh cũ mặc định

            if ($title === '') {
                $error = 'Tiêu đề bài viết không được để trống!';
            } else {
                if (!empty($_FILES['image_file']['name'])) {
                    $file    = $_FILES['image_file'];
                    $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    if (!in_array($ext, $allowed)) {
                        $error = 'Chỉ chấp nhận ảnh JPG, PNG, GIF, WEBP!';
                    } elseif ($file['size'] > 5 * 1024 * 1024) {
                        $error = 'Dung lượng ảnh không quá 5MB!';
                    } else {
                        $filename  = 'article_' . time() . '_' . uniqid() . '.' . $ext;
                        $uploadDir = __DIR__ . '/../../uploads/';
                        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                            $imagePath = 'uploads/' . $filename;
                        } else {
                            $error = 'Lỗi khi tải ảnh lên server!';
                        }
                    }
                } elseif (!empty($imageUrl)) {
                    $imagePath = $imageUrl;
                }

                if (empty($error)) {
                    $result = $this->articleModel->updateArticle($id, [
                        'title'       => $title,
                        'image'       => $imagePath,
                        'description' => $description,
                    ]);
                    if ($result) {
                        $_SESSION['admin_success'] = 'Đã cập nhật bài viết "' . htmlspecialchars($title) . '" thành công!';
                        header('Location: ' . BASE_URL . '/admin/articles');
                        exit;
                    } else {
                        $error = 'Có lỗi khi cập nhật bài viết!';
                    }
                }
            }
        }

        $this->render('backend.articles.edit', [
            'article' => $article,
            'error'   => $error,
            'success' => $success,
        ]);
    }

    // Xóa tin tức
    public function deleteArticle($id) {
        $article = $this->articleModel->getArticleById($id);
        if ($article) {
            $this->articleModel->deleteArticle($id);
            $_SESSION['admin_success'] = 'Đã xóa bài viết "' . htmlspecialchars($article['title']) . '" thành công!';
        }
        header('Location: ' . BASE_URL . '/admin/articles');
        exit;
    }

    // ===== CRUD DANH MỤC =====

    // Danh sách danh mục
    public function listCategories() {
        $categories = $this->categoryModel->getAllCategories();
        $this->render('backend.categories.index', ['categories' => $categories]);
    }

    // Thêm danh mục mới
    public function addCategory() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = trim($_POST['code'] ?? '');
            $name = trim($_POST['name'] ?? '');

            if ($code === '' || $name === '') {
                $error = 'Vui lòng nhập đầy đủ mã danh mục và tên danh mục!';
            } elseif (!preg_match('/^[a-z0-9_]+$/', $code)) {
                $error = 'Mã danh mục chỉ chứa chữ thường không dấu, số và dấu gạch dưới (ví dụ: rau_cu)!';
            } else {
                $existing = $this->categoryModel->getCategoryByCode($code);
                if ($existing) {
                    $error = 'Mã danh mục này đã tồn tại trong hệ thống!';
                } else {
                    $result = $this->categoryModel->createCategory([
                        'code' => $code,
                        'name' => $name,
                    ]);
                    if ($result) {
                        $_SESSION['admin_success'] = 'Thêm danh mục mới "' . htmlspecialchars($name) . '" thành công!';
                        header('Location: ' . BASE_URL . '/admin/categories');
                        exit;
                    } else {
                        $error = 'Có lỗi xảy ra khi lưu danh mục, vui lòng thử lại!';
                    }
                }
            }
        }

        $this->render('backend.categories.create', ['error' => $error, 'success' => $success]);
    }

    // Chỉnh sửa danh mục
    public function editCategory($id) {
        $category = $this->categoryModel->getCategoryById($id);
        if (!$category) {
            header('Location: ' . BASE_URL . '/admin/categories');
            exit;
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = trim($_POST['code'] ?? '');
            $name = trim($_POST['name'] ?? '');

            if ($code === '' || $name === '') {
                $error = 'Vui lòng nhập đầy đủ mã danh mục và tên danh mục!';
            } elseif (!preg_match('/^[a-z0-9_]+$/', $code)) {
                $error = 'Mã danh mục chỉ chứa chữ thường không dấu, số và dấu gạch dưới!';
            } else {
                $existing = $this->categoryModel->getCategoryByCode($code);
                if ($existing && $existing['id'] != $id) {
                    $error = 'Mã danh mục này đã tồn tại ở một danh mục khác!';
                } else {
                    $result = $this->categoryModel->updateCategory($id, [
                        'code' => $code,
                        'name' => $name,
                    ]);
                    if ($result) {
                        $_SESSION['admin_success'] = 'Cập nhật danh mục "' . htmlspecialchars($name) . '" thành công!';
                        header('Location: ' . BASE_URL . '/admin/categories');
                        exit;
                    } else {
                        $error = 'Có lỗi xảy ra khi cập nhật danh mục!';
                    }
                }
            }
        }

        $this->render('backend.categories.edit', [
            'category' => $category,
            'error' => $error,
            'success' => $success
        ]);
    }

    // Xóa danh mục
    public function deleteCategory($id) {
        $category = $this->categoryModel->getCategoryById($id);
        if ($category) {
            $this->categoryModel->deleteCategory($id);
            $_SESSION['admin_success'] = 'Đã xóa danh mục "' . htmlspecialchars($category['name']) . '" thành công!';
        }
        header('Location: ' . BASE_URL . '/admin/categories');
        exit;
    }

    // ===== CRUD TÀI KHOẢN (USER/ACCOUNT CRUD) =====

    // Danh sách tài khoản
    public function listUsers() {
        $users = $this->userModel->getAllUsers();
        $totalUsers = count($users);

        // Đếm các loại vai trò
        $adminCount = 0;
        $staffCount = 0;
        $customerCount = 0;

        foreach ($users as $u) {
            if ($u['role'] === 'admin') {
                $adminCount++;
            } elseif ($u['role'] === 'staff') {
                $staffCount++;
            } else {
                $customerCount++;
            }
        }

        $this->render('backend.users.index', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'adminCount' => $adminCount,
            'staffCount' => $staffCount,
            'customerCount' => $customerCount
        ]);
    }

    // Thêm tài khoản mới
    public function addUser() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = trim($_POST['role'] ?? 'user');

            if ($fullname === '' || $email === '' || $password === '') {
                $error = 'Vui lòng điền đầy đủ các thông tin!';
            } elseif (strlen($password) < 6) {
                $error = 'Mật khẩu phải chứa ít nhất 6 ký tự!';
            } elseif (!in_array($role, ['user', 'staff', 'admin'])) {
                $error = 'Vai trò người dùng không hợp lệ!';
            } else {
                $existing = $this->userModel->getUserByEmail($email);
                if ($existing) {
                    $error = 'Email này đã tồn tại trong hệ thống!';
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $result = $this->userModel->createUser($fullname, $email, $hashedPassword, $role);
                    if ($result) {
                        $_SESSION['admin_success'] = 'Đã thêm tài khoản mới "' . htmlspecialchars($fullname) . '" thành công!';
                        header('Location: ' . BASE_URL . '/admin/users');
                        exit;
                    } else {
                        $error = 'Có lỗi xảy ra khi tạo tài khoản, vui lòng thử lại!';
                    }
                }
            }
        }

        $this->render('backend.users.create', [
            'error' => $error,
            'success' => $success
        ]);
    }

    // Chỉnh sửa tài khoản
    public function editUser($id) {
        $user = $this->userModel->getUserById($id);
        if (!$user) {
            header('Location: ' . BASE_URL . '/admin/users');
            exit;
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = trim($_POST['role'] ?? 'user');

            if ($fullname === '' || $email === '') {
                $error = 'Vui lòng điền đầy đủ các thông tin!';
            } elseif (!in_array($role, ['user', 'staff', 'admin'])) {
                $error = 'Vai trò không hợp lệ!';
            } else {
                $existing = $this->userModel->getUserByEmail($email);
                if ($existing && $existing['id'] != $id) {
                    $error = 'Email này đã tồn tại ở một tài khoản khác!';
                } else {
                    $hashedPassword = null;
                    if ($password !== '') {
                        if (strlen($password) < 6) {
                            $error = 'Mật khẩu mới phải chứa ít nhất 6 ký tự!';
                        } else {
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        }
                    }

                    if (empty($error)) {
                        $result = $this->userModel->updateUser($id, $fullname, $email, $role, $hashedPassword);
                        if ($result) {
                            $_SESSION['admin_success'] = 'Đã cập nhật tài khoản "' . htmlspecialchars($fullname) . '" thành công!';
                            header('Location: ' . BASE_URL . '/admin/users');
                            exit;
                        } else {
                            $error = 'Có lỗi xảy ra khi cập nhật tài khoản!';
                        }
                    }
                }
            }
        }

        $this->render('backend.users.edit', [
            'user' => $user,
            'error' => $error,
            'success' => $success
        ]);
    }

    // Xóa tài khoản
    public function deleteUser($id) {
        $user = $this->userModel->getUserById($id);
        if ($user) {
            // Bảo vệ: Không cho phép tự xóa chính mình
            $currentAdminId = $_SESSION['admin']['id'] ?? null;
            if ($currentAdminId == $id) {
                $_SESSION['admin_error'] = 'Bạn không thể tự xóa tài khoản quản trị đang đăng nhập của chính mình!';
                header('Location: ' . BASE_URL . '/admin/users');
                exit;
            }

            $this->userModel->deleteUser($id);
            $_SESSION['admin_success'] = 'Đã xóa tài khoản "' . htmlspecialchars($user['fullname']) . '" thành công!';
        }
        header('Location: ' . BASE_URL . '/admin/users');
        exit;
    }
}
