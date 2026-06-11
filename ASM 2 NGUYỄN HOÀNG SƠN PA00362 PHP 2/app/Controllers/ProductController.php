<?php
namespace App\Controllers;

use App\Models\ProductModel;

class ProductController extends Controller {
    private $productModel;

    public function __construct() {
        parent::__construct();
        $this->productModel = new ProductModel();
    }

    // Hiển thị danh sách sản phẩm (Trang chủ Z DEMO)
    public function listProducts() {
        $products = [];
        $saleProducts = [];
        $articles = [];
        $promotions = [];
        $latestArticles = [];
        try {
            $products = $this->productModel->getAllProducts();
            $saleProducts = $this->productModel->getSaleProducts();
            $articles = $this->productModel->getAllArticles();
            $promotions = $this->productModel->getPromotions(6);
            $latestArticles = $this->productModel->getLatestArticles(3);
            
            // Check if names contain question marks, indicating encoding issue
            $hasEncodingIssue = false;
            foreach ($products as $p) {
                if (isset($p['name']) && strpos($p['name'], '??') !== false) {
                    $hasEncodingIssue = true;
                    break;
                }
            }
            if (!$hasEncodingIssue) {
                foreach ($saleProducts as $p) {
                    if (isset($p['name']) && strpos($p['name'], '??') !== false) {
                        $hasEncodingIssue = true;
                        break;
                    }
                }
            }

            if ($hasEncodingIssue) {
                $this->autoRepairDatabase();
                $products = $this->productModel->getAllProducts();
                $saleProducts = $this->productModel->getSaleProducts();
                $articles = $this->productModel->getAllArticles();
                $promotions = $this->productModel->getPromotions(6);
                $latestArticles = $this->productModel->getLatestArticles(3);
            }
        } catch (\Exception $e) {
            // Nếu lỗi CSDL, khởi tạo dữ liệu mẫu nông sản và sản phẩm sale trong Session
            if (!isset($_SESSION['demo_products'])) {
                $_SESSION['demo_products'] = $this->getDemoProducts();
            }
            if (!isset($_SESSION['demo_sale_products'])) {
                $_SESSION['demo_sale_products'] = $this->getDemoSaleProducts();
            }
            if (!isset($_SESSION['demo_articles'])) {
                $_SESSION['demo_articles'] = $this->getDemoArticles();
            }
            $products = $_SESSION['demo_products'];
            $saleProducts = $_SESSION['demo_sale_products'];
            $articles = $_SESSION['demo_articles'];
        }

        $this->render('frontend.products', [
            'products'       => array_map([$this, 'attachImages'], $products),
            'saleProducts'   => array_map([$this, 'attachImages'], $saleProducts),
            'articles'       => $articles,
            'promotions'     => $promotions,
            'latestArticles' => $latestArticles,
        ]);
    }

    // Bổ sung mảng 'images' và ảnh đại diện vào dữ liệu sản phẩm
    private function attachImages($product) {
        $imgs = $this->parseImages($product['image'] ?? '');
        $product['images'] = $imgs;
        $product['image']  = $imgs[0];   // ảnh đại diện (giữ tương thích)
        return $product;
    }

    // Hiển thị chi tiết sản phẩm nông sản
    public function detailProduct($id) {
        $product = null;
        try {
            $product = $this->productModel->getProductById($id);
            if ($product && isset($product['name']) && strpos($product['name'], '??') !== false) {
                $this->autoRepairDatabase();
                $product = $this->productModel->getProductById($id);
            }
        } catch (\Exception $e) {
            // Kiểm tra trong session sản phẩm thường
            if (!isset($_SESSION['demo_products'])) {
                $_SESSION['demo_products'] = $this->getDemoProducts();
            }
            foreach ($_SESSION['demo_products'] as $p) {
                if ($p['id'] == $id) {
                    $product = $p;
                    break;
                }
            }
            // Nếu chưa thấy, kiểm tra trong session sản phẩm sale
            if (!$product) {
                if (!isset($_SESSION['demo_sale_products'])) {
                    $_SESSION['demo_sale_products'] = $this->getDemoSaleProducts();
                }
                foreach ($_SESSION['demo_sale_products'] as $p) {
                    if ($p['id'] == $id) {
                        $product = $p;
                        break;
                    }
                }
            }
        }

        if (!$product) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        $product = $this->attachImages($product);

        $this->render('frontend.product-detail', [
            'product' => $product
        ]);
    }

    // Xóa sản phẩm nông sản hoặc sản phẩm sale
    public function deleteProduct($id) {
        try {
            $this->productModel->deleteProduct($id);
        } catch (\Exception $e) {
            // Giả lập xóa sản phẩm trong session demo
            if (isset($_SESSION['demo_products'])) {
                $_SESSION['demo_products'] = array_filter($_SESSION['demo_products'], function($p) use ($id) {
                    return $p['id'] != $id;
                });
                $_SESSION['demo_products'] = array_values($_SESSION['demo_products']);
            }
            if (isset($_SESSION['demo_sale_products'])) {
                $_SESSION['demo_sale_products'] = array_filter($_SESSION['demo_sale_products'], function($p) use ($id) {
                    return $p['id'] != $id;
                });
                $_SESSION['demo_sale_products'] = array_values($_SESSION['demo_sale_products']);
            }
        }

        header('Location: ' . BASE_URL . '/');
        exit;
    }

    // Thêm sản phẩm mới (Xử lý POST request)
    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $original_price = isset($_POST['original_price']) && $_POST['original_price'] !== '' ? floatval($_POST['original_price']) : null;
            $discount_percent = isset($_POST['discount_percent']) && $_POST['discount_percent'] !== '' ? intval($_POST['discount_percent']) : 0;
            $image = trim($_POST['image'] ?? '');
            if ($image !== '') {
                if (!preg_match('/^https?:\/\//i', $image) && !preg_match('/^uploads\//i', $image)) {
                    $image = 'uploads/' . $image;
                }
            }
            $category = trim($_POST['category'] ?? 'rau_cu');
            $is_sale = isset($_POST['is_sale']) ? 1 : 0;
            $description = trim($_POST['description'] ?? '');

            if ($name !== '' && $price > 0) {
                $productData = [
                    'name' => $name,
                    'price' => $price,
                    'original_price' => $original_price,
                    'discount_percent' => $discount_percent,
                    'image' => $image,
                    'description' => $description,
                    'is_sale' => $is_sale,
                    'category' => $category
                ];

                try {
                    $this->productModel->addProduct($productData);
                } catch (\Exception $e) {
                    // Fallback to Session Demo data if DB fails
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    if (!isset($_SESSION['demo_products'])) {
                        $_SESSION['demo_products'] = $this->getDemoProducts();
                    }
                    if (!isset($_SESSION['demo_sale_products'])) {
                        $_SESSION['demo_sale_products'] = $this->getDemoSaleProducts();
                    }

                    $newId = time(); // Temporary unique ID
                    $productData['id'] = $newId;
                    
                    if ($is_sale) {
                        $_SESSION['demo_sale_products'][] = $productData;
                    } else {
                        $_SESSION['demo_products'][] = $productData;
                    }
                }
            }
        }

        header('Location: ' . BASE_URL . '/');
        exit;
    }

    // Danh sách sản phẩm thực phẩm sạch mẫu (Z DEMO)
    private function getDemoProducts() {
        return [
            [
                'id' => 1,
                'name' => 'Rau Xà Lách Cuộn Mỡ',
                'price' => 18000,
                'image' => 'uploads/product_1.jpg',
                'description' => 'Rau xà lách mỡ tươi ngon được trồng theo phương pháp hữu cơ tại Đà Lạt, ngọt giòn, thích hợp làm salad.',
                'category' => 'rau_cu'
            ],
            [
                'id' => 2,
                'name' => 'Khoai Tây Hồng Đà Lạt',
                'price' => 32000,
                'image' => 'uploads/product_2.jpg',
                'description' => 'Khoai tây ruột vàng ngọt bùi, vỏ mỏng nhiều dinh dưỡng, thích hợp nấu canh, chiên giòn cho cả gia đình.',
                'category' => 'rau_cu'
            ],
            [
                'id' => 3,
                'name' => 'Cà Tomato Đỏ Hữu Cơ',
                'price' => 28000,
                'image' => 'uploads/product_3.jpg',
                'description' => 'Cà chua bi trái nhỏ ngọt thanh, mọng nước, giàu Vitamin A & C, là sản phẩm ăn sống trực tiếp tuyệt vời.',
                'category' => 'rau_cu'
            ],
            [
                'id' => 4,
                'name' => 'Combo Rau Củ Quả Tiện Lợi',
                'price' => 99000,
                'image' => 'uploads/product_4.jpg',
                'description' => 'Set rau củ quả tươi sạch kết hợp gồm: cà rốt, khoai tây, cải ngọt, súp lơ xanh và hành tây tiện lợi cho bữa ăn hàng ngày.',
                'category' => 'rau_cu'
            ],
            [
                'id' => 5,
                'name' => 'Táo Đỏ Envy Nhập Khẩu',
                'price' => 85000,
                'image' => 'uploads/product_5.jpg',
                'description' => 'Táo Envy nhập khẩu trực tiếp từ New Zealand, độ giòn cao, hương thơm tự nhiên và vị ngọt đậm đặc trưng.',
                'category' => 'trai_cay'
            ],
            [
                'id' => 6,
                'name' => 'Nấm Đùi Gà Tươi Sạch',
                'price' => 45000,
                'image' => 'uploads/product_6.jpg',
                'description' => 'Nấm đùi gà được sản xuất tại nông trại đạt tiêu chuẩn VietGAP, dai ngọt tự nhiên, thích hợp cho các món xào, lẩu.',
                'category' => 'nam'
            ],
            [
                'id' => 12,
                'name' => 'Tiêu đen xay Natas hũ 55g',
                'price' => 105000,
                'image' => 'uploads/product_12.jpg',
                'description' => 'Tiêu đen xay Natas hũ 55g thơm ngon đậm đà, làm từ hạt tiêu đen Tây Nguyên chất lượng cao.',
                'category' => 'dong_mat'
            ],
            [
                'id' => 13,
                'name' => 'Đầu cá hồi tươi túi 1kg (300g - 500g/cái)',
                'price' => 105000,
                'image' => 'uploads/product_13.jpg',
                'description' => 'Đầu cá hồi tươi ngon ngọt nước, giàu omega-3, thích hợp nấu lẩu, nấu canh chua thơm ngon bổ dưỡng.',
                'category' => 'thit_ca'
            ],
            [
                'id' => 14,
                'name' => 'Tiêu đen xay Phú Quốc Minh Hà hũ 50g',
                'price' => 105000,
                'image' => 'uploads/product_14.jpg',
                'description' => 'Tiêu đen xay Phú Quốc Minh Hà hũ 50g thơm nồng nàn cay ấm, đặc sản tiêu sạch chất lượng.',
                'category' => 'thit_ca'
            ],
            [
                'id' => 15,
                'name' => 'Vai bò Úc tươi Trung Đồng hút chân không khay 250g',
                'price' => 105000,
                'image' => 'uploads/product_15.jpg',
                'description' => 'Thịt vai bò Úc tươi sống nhập khẩu trực tiếp từ Úc, đóng khay 250g tiện lợi.',
                'category' => 'thit_ca'
            ],
            [
                'id' => 16,
                'name' => 'Vai bò Úc tươi Trung Đồng hút chân không khay 250g',
                'price' => 105000,
                'image' => 'uploads/product_16.jpg',
                'description' => 'Thịt vai bò Úc tươi ngon chuẩn nhập khẩu, giàu dinh dưỡng cho bữa cơm gia đình.',
                'category' => 'thit_ca'
            ],
            [
                'id' => 17,
                'name' => 'Vai bò Úc tươi Trung Đồng hút chân không khay 250g',
                'price' => 105000,
                'image' => 'uploads/product_17.jpg',
                'description' => 'Thịt vai bò Úc tươi nhập khẩu đóng khay hút chân không 250g tiện lợi vệ sinh.',
                'category' => 'thit_ca'
            ],
            [
                'id' => 18,
                'name' => 'Mì Hảo Hảo tôm chua cay gói 75g',
                'price' => 4500,
                'image' => 'uploads/product_18.jpg',
                'description' => 'Mì ăn liền Hảo Hảo hương vị tôm chua cay quốc dân đậm đà thơm ngon.',
                'category' => 'mi_lien'
            ],
            [
                'id' => 19,
                'name' => 'Phở gà ăn liền Đệ Nhất gói 65g',
                'price' => 8000,
                'original_price' => 10000,
                'discount_percent' => 20,
                'image' => 'uploads/product_19.jpg',
                'description' => 'Phở ăn liền Đệ Nhất hương vị gà thơm ngon, sợi bánh dai mượt chuẩn vị phở Hà Nội.',
                'category' => 'mi_lien'
            ],
            [
                'id' => 20,
                'name' => 'Gạo thơm ST25 Sóc Trăng túi 5kg',
                'price' => 190000,
                'original_price' => 220000,
                'discount_percent' => 13,
                'image' => 'uploads/product_20.jpg',
                'description' => 'Gạo ngon nhất thế giới ST25 hạt dài, trắng trong, cơm dẻo thơm mùi lá dứa.',
                'category' => 'gao_bot'
            ],
            [
                'id' => 21,
                'name' => 'Bột mì đa dụng Meizan gói 1kg',
                'price' => 25000,
                'image' => 'uploads/product_21.jpg',
                'description' => 'Bột mì đa dụng Meizan chất lượng cao, thích hợp làm các loại bánh mỳ, bánh ngọt.',
                'category' => 'gao_bot'
            ]
        ];
    }

    // Danh sách sản phẩm khuyến mãi (Săn Sale) mẫu khi không có CSDL
    private function getDemoSaleProducts() {
        return [
            [
                'id' => 7,
                'name' => 'Sườn già heo C.P khay 500g (9-11 miếng)',
                'price' => 79000,
                'original_price' => 150000,
                'discount_percent' => 47,
                'image' => 'uploads/product_7.jpg',
                'description' => 'Sườn già heo C.P được đóng khay vệ sinh, nguồn gốc rõ ràng, thịt sườn dày nhiều nạc, thích hợp kho, nấu canh.'
            ],
            [
                'id' => 8,
                'name' => 'Thịt heo xay C.P khay 300g',
                'price' => 82000,
                'original_price' => 105000,
                'discount_percent' => 22,
                'image' => 'uploads/product_8.jpg',
                'description' => 'Thịt heo xay C.P được tuyển chọn từ nguồn thịt tươi ngon, xay nhỏ vừa vặn, thích hợp nấu canh, làm chả, nhân bánh.'
            ],
            [
                'id' => 9,
                'name' => 'Thịt heo xay C.P khay 300g 1',
                'price' => 82000,
                'original_price' => 105000,
                'discount_percent' => 22,
                'image' => 'uploads/product_9.jpg',
                'description' => 'Thịt heo xay C.P loại đặc biệt có tỷ lệ mỡ nạc hoàn hảo, thích hợp nấu cháo hoặc làm nhân nem cuốn.'
            ],
            [
                'id' => 10,
                'name' => 'Sườn già heo C.P khay 500g (9-11 miếng)',
                'price' => 79000,
                'original_price' => 150000,
                'discount_percent' => 47,
                'image' => 'uploads/product_10.jpg',
                'description' => 'Sườn già heo C.P đóng khay tiện lợi giúp bạn chế biến nhanh các món sườn ram mặn ngọt thơm ngon.'
            ],
            [
                'id' => 11,
                'name' => 'Thịt heo xay C.P khay 300g',
                'price' => 82000,
                'original_price' => 105000,
                'discount_percent' => 22,
                'image' => 'uploads/product_11.jpg',
                'description' => 'Thịt nạc vai xay sạch từ thương hiệu C.P uy tín, tươi ngon, giàu đạm và dưỡng chất cho bữa ăn hàng ngày.'
            ]
        ];
    }

    private function autoRepairDatabase() {
        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $port = $_ENV['DB_PORT'] ?? '3306';
        $dbname = $_ENV['DB_NAME'] ?? 'asm2_zdemo_php2';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? '';

        try {
            $db = new \PDO("mysql:host=$host;port=$port;charset=utf8mb4", $user, $pass, [
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ]);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            $sql = file_get_contents(__DIR__ . '/../../database.sql');
            $db->exec($sql);
            
            // Clear session data to ensure fresh reload
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            unset($_SESSION['demo_products']);
            unset($_SESSION['demo_sale_products']);
            unset($_SESSION['demo_articles']);
        } catch (\Exception $e) {
            // Silence is golden
        }
    }

    private function getDemoArticles() {
        return [
            [
                'id' => 1,
                'title' => 'Biến tấu nhân bánh mì cho bữa sáng lành mạnh',
                'image' => 'uploads/article_1.jpg',
                'description' => 'Hải sản, trứng, rau củ đều phù hợp để ăn kèm sandwich, burger. Chỉ ...'
            ],
            [
                'id' => 2,
                'title' => '10 trải nghiệm ẩm thực phải thử trong năm 2022',
                'image' => 'uploads/article_2.jpg',
                'description' => 'Lonely Planet vừa chọn ra những trải nghiệm ẩm thực nổi bật cho du ...'
            ],
            [
                'id' => 3,
                'title' => 'Gần 100 loại bánh dân gian hội tụ ở miền Tây',
                'image' => 'uploads/article_3.jpg',
                'description' => 'Rất nhiều món ăn ngon được người dân miền Tây mang đến lễ hội ...'
            ],
            [
                'id' => 4,
                'title' => '10 loại thực phẩm tốt dành cho bà bầu trong suốt thai kỳ',
                'image' => 'uploads/article_4.jpg',
                'description' => '1. Các loại thịt đỏ: Thành phần dinh dưỡng chứa chất sắt và vitamin B. ...'
            ]
        ];
    }

    // Hiển thị trang giới thiệu
    public function about() {
        $this->render('frontend.about');
    }

    // Hiển thị trang cửa hàng với tất cả sản phẩm
    public function storeProducts() {
        $products = [];
        $saleProducts = [];
        try {
            $products = $this->productModel->getAllProducts();
            $saleProducts = $this->productModel->getSaleProducts();
            
            // Check if names contain question marks, indicating encoding issue
            $hasEncodingIssue = false;
            foreach ($products as $p) {
                if (isset($p['name']) && strpos($p['name'], '??') !== false) {
                    $hasEncodingIssue = true;
                    break;
                }
            }
            if (!$hasEncodingIssue) {
                foreach ($saleProducts as $p) {
                    if (isset($p['name']) && strpos($p['name'], '??') !== false) {
                        $hasEncodingIssue = true;
                        break;
                    }
                }
            }

            if ($hasEncodingIssue) {
                $this->autoRepairDatabase();
                $products = $this->productModel->getAllProducts();
                $saleProducts = $this->productModel->getSaleProducts();
            }
        } catch (\Exception $e) {
            // Fallback to session
            if (!isset($_SESSION['demo_products'])) {
                $_SESSION['demo_products'] = $this->getDemoProducts();
            }
            if (!isset($_SESSION['demo_sale_products'])) {
                $_SESSION['demo_sale_products'] = $this->getDemoSaleProducts();
            }
            $products = $_SESSION['demo_products'];
            $saleProducts = $_SESSION['demo_sale_products'];
        }

        $this->render('frontend.store', [
            'products'     => array_map([$this, 'attachImages'], $products),
            'saleProducts' => array_map([$this, 'attachImages'], $saleProducts)
        ]);
    }

    // Trang Liên hệ
    public function contact() {
        $success = '';
        $error   = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name    = trim($_POST['name']    ?? '');
            $email   = trim($_POST['email']   ?? '');
            $phone   = trim($_POST['phone']   ?? '');
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if (empty($name) || empty($email) || empty($message)) {
                $error = 'Vui lòng điền đầy đủ Họ tên, Email và Nội dung!';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Địa chỉ email không hợp lệ!';
            } else {
                $_SESSION['contact_success'] = true;
                header('Location: ' . BASE_URL . '/contact');
                exit;
            }
        }

        if (isset($_SESSION['contact_success'])) {
            $success = 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong vòng 24 giờ.';
            unset($_SESSION['contact_success']);
        }

        $this->render('frontend.contact', [
            'success' => $success,
            'error'   => $error,
        ]);
    }
}

