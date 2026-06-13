<?php
session_start();

// Chuẩn hóa Session dữ liệu người dùng thành mảng (tránh lỗi Cannot use object of type stdClass as array)
if (isset($_SESSION['user']) && is_object($_SESSION['user'])) {
    $_SESSION['user'] = (array)$_SESSION['user'];
}
if (isset($_SESSION['admin']) && is_object($_SESSION['admin'])) {
    $_SESSION['admin'] = (array)$_SESSION['admin'];
}

// Include Composer autoloader
$autoloader = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoloader)) {
    die("<div style='font-family: sans-serif; text-align: center; padding: 50px; line-height: 1.6;'>
            <h1 style='color: #10b981;'>Thư mục vendor chưa được cài đặt!</h1>
            <p>Vui lòng mở terminal tại thư mục dự án và chạy lệnh:</p>
            <pre style='background: #f3f4f6; padding: 15px; border-radius: 6px; display: inline-block; font-size: 1.1rem; border: 1px solid #e5e7eb;'>composer install</pre>
            <p>Sau khi thư viện đã cài đặt thành công, hãy tải lại trang này.</p>
         </div>");
}
require_once $autoloader;

// Load environment variables if package is loaded
if (class_exists('Dotenv\Dotenv')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
}

// Dynamically define BASE_URL to support flexible subdirectory hosting in XAMPP
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$baseUrl = $scriptName === '/' ? '' : $scriptName;
define('BASE_URL', $baseUrl);

// =====================================================================
// AUTO SETUP DATABASE - Tự động tạo database và bảng nếu chưa tồn tại
// =====================================================================
function autoSetupDatabase(): void {
    $host   = $_ENV['DB_HOST'] ?? '127.0.0.1';
    $port   = $_ENV['DB_PORT'] ?? '3306';
    $dbname = $_ENV['DB_NAME'] ?? 'asm2_zdemo_php2';
    $user   = $_ENV['DB_USER'] ?? 'root';
    $pass   = $_ENV['DB_PASS'] ?? '';

    try {
        // Kết nối không chọn database trước
        $pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]);

        // Tạo database nếu chưa có
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE `$dbname`");

        // Kiểm tra bảng users - nếu chưa có thì tạo tất cả
        $check = $pdo->query("SHOW TABLES LIKE 'users'")->rowCount();
        if ($check === 0) {
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

            // Bảng users
            $pdo->exec("DROP TABLE IF EXISTS `users`");
            $pdo->exec("CREATE TABLE `users` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `fullname` VARCHAR(255) NOT NULL,
                `email` VARCHAR(191) NOT NULL UNIQUE,
                `password` VARCHAR(255) NOT NULL,
                `role` VARCHAR(50) DEFAULT 'user',
                `reset_token` VARCHAR(255) DEFAULT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            // password: 123456
            $pdo->exec("INSERT INTO `users` (`fullname`,`email`,`password`,`role`) VALUES
                ('Nguyễn Hoàng Sơn','son@fpt.edu.vn','\$2y\$10\$pU8ipgElyEH9UkEX.aQlAuHCFo1lPL3CqP1nnoHnKBZbNuJ8ViBfy','user'),
                ('Administrator','admin@fpt.edu.vn','\$2y\$10\$pU8ipgElyEH9UkEX.aQlAuHCFo1lPL3CqP1nnoHnKBZbNuJ8ViBfy','admin'),
                ('Nguyễn Văn Nhân Viên','staff@fpt.edu.vn','\$2y\$10\$pU8ipgElyEH9UkEX.aQlAuHCFo1lPL3CqP1nnoHnKBZbNuJ8ViBfy','staff')");

            
            // Bảng categories
            $pdo->exec("DROP TABLE IF EXISTS `categories`");
            $pdo->exec("CREATE TABLE `categories` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `code` VARCHAR(50) NOT NULL UNIQUE,
                `name` VARCHAR(255) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            $pdo->exec("INSERT INTO `categories` (`code`,`name`) VALUES
                ('rau_cu', 'Rau củ quả sạch'),
                ('trai_cay', 'Trái cây tươi ngon'),
                ('nam', 'Nấm tươi hữu cơ'),
                ('thit_ca', 'Thịt, Thủy hải sản tươi'),
                ('dong_mat', 'Gia vị, Đồ khô, Đóng hộp'),
                ('mi_lien', 'Mì gói, Phở ăn liền'),
                ('gao_bot', 'Gạo, Bột ngũ cốc dinh dưỡng')");

// Bảng products
            $pdo->exec("DROP TABLE IF EXISTS `products`");
            $pdo->exec("CREATE TABLE `products` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL,
                `price` DECIMAL(15,2) NOT NULL,
                `original_price` DECIMAL(15,2) DEFAULT NULL,
                `discount_percent` INT DEFAULT 0,
                `image` VARCHAR(255) DEFAULT NULL,
                `images` TEXT DEFAULT NULL,
                `description` TEXT,
                `is_sale` TINYINT(1) DEFAULT 0,
                `category` VARCHAR(50) DEFAULT 'rau_cu',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            $pdo->exec("INSERT INTO `products` (`name`,`price`,`original_price`,`discount_percent`,`image`,`description`,`is_sale`,`category`) VALUES
                ('Rau Xà Lách Cuộn Mỡ',18000,24000,25,'uploads/product_1.jpg','Rau xà lách mỡ tươi ngon trồng hữu cơ tại Đà Lạt.',0,'rau_cu'),
                ('Khoai Tây Hồng Đà Lạt',32000,40000,20,'uploads/product_2.jpg','Khoai tây ruột vàng ngọt bùi, vỏ mỏng nhiều dinh dưỡng.',0,'rau_cu'),
                ('Cà Tomato Đỏ Hữu Cơ',28000,35000,20,'uploads/product_3.jpg','Cà chua bi ngọt thanh, mọng nước, giàu Vitamin A và C.',0,'rau_cu'),
                ('Combo Rau Củ Quả Tiện Lợi',99000,130000,24,'uploads/product_4.jpg','Set rau củ quả tươi sạch: cà rốt, khoai tây, cải ngọt, súp lơ.',0,'rau_cu'),
                ('Táo Đỏ Envy Nhập Khẩu',85000,110000,22,'uploads/product_5.jpg','Táo Envy từ New Zealand, giòn ngọt đặc trưng.',0,'trai_cay'),
                ('Nấm Đùi Gà Tươi Sạch',45000,58000,22,'uploads/product_6.jpg','Nấm đùi gà VietGAP, dai ngọt tự nhiên.',0,'nam'),
                ('Sườn già heo C.P khay 500g',79000,150000,47,'uploads/product_7.jpg','Sườn già heo C.P đóng khay vệ sinh, nguồn gốc rõ ràng.',1,'thit_ca'),
                ('Thịt heo xay C.P khay 300g',82000,105000,22,'uploads/product_8.jpg','Thịt heo xay C.P tươi ngon.',1,'thit_ca'),
                ('Thịt heo xay C.P khay 300g Premium',82000,105000,22,'uploads/product_9.jpg','Thịt heo xay C.P loại đặc biệt.',1,'thit_ca'),
                ('Sườn già heo C.P khay 500g (Sale)',79000,150000,47,'uploads/product_10.jpg','Sườn già heo C.P đóng khay tiện lợi.',1,'thit_ca'),
                ('Thịt heo xay C.P khay 300g (Sale)',82000,105000,22,'uploads/product_11.jpg','Thịt nạc vai xay sạch C.P.',1,'thit_ca'),
                ('Tiêu đen xay Natas hũ 55g',105000,NULL,0,'uploads/product_12.jpg','Tiêu đen xay Natas thơm ngon đậm đà.',0,'dong_mat'),
                ('Đầu cá hồi tươi túi 1kg',105000,NULL,0,'uploads/product_13.jpg','Đầu cá hồi tươi ngon, giàu omega-3.',0,'thit_ca'),
                ('Tiêu đen xay Phú Quốc hũ 50g',105000,NULL,0,'uploads/product_14.jpg','Tiêu đen xay Phú Quốc thơm nồng.',0,'dong_mat'),
                ('Vai bò Úc tươi khay 250g',105000,NULL,0,'uploads/product_15.jpg','Thịt vai bò Úc tươi nhập khẩu 250g.',0,'thit_ca'),
                ('Vai bò Úc hút chân không 250g',105000,NULL,0,'uploads/product_16.jpg','Thịt vai bò Úc tươi ngon chuẩn nhập khẩu.',0,'thit_ca'),
                ('Bột mì đa dụng Meizan 1kg',25000,NULL,0,'uploads/product_17.jpg','Bột mì Meizan chất lượng cao.',0,'gao_bot'),
                ('Mì Hảo Hảo tôm chua cay 75g',4500,NULL,0,'uploads/product_18.jpg','Mì Hảo Hảo tôm chua cay quốc dân.',0,'mi_lien'),
                ('Phở gà Đệ Nhất gói 65g',8000,10000,20,'uploads/product_19.jpg','Phở ăn liền Đệ Nhất hương gà.',0,'mi_lien'),
                ('Gạo thơm ST25 Sóc Trăng 5kg',190000,220000,13,'uploads/product_20.jpg','Gạo ngon nhất thế giới ST25.',0,'gao_bot'),
                ('Bột mì đa dụng Meizan 1kg B',25000,NULL,0,'uploads/product_21.jpg','Bột mì đa dụng Meizan.',0,'gao_bot')");

            // Bảng articles
            $pdo->exec("DROP TABLE IF EXISTS `articles`");
            $pdo->exec("CREATE TABLE `articles` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) NOT NULL,
                `image` VARCHAR(255) DEFAULT NULL,
                `description` TEXT,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            $pdo->exec("INSERT INTO `articles` (`title`,`image`,`description`) VALUES
                ('Biến tấu nhân bánh mì cho bữa sáng lành mạnh','uploads/article_1.jpg','Hải sản, trứng, rau củ đều phù hợp để ăn kèm sandwich, burger. Chỉ cần một vài thay đổi nhỏ trong cách chọn nhân, bạn có thể biến bữa sáng thông thường thành một bữa ăn giàu dinh dưỡng và đầy màu sắc. Thử kết hợp ức gà áp chảo, rau xà lách, cà chua bi và sốt mù tạt mật ong để có một chiếc bánh mì sandwich hoàn hảo cho ngày mới.'),
                ('10 trải nghiệm ẩm thực phải thử trong năm 2022','uploads/article_2.jpg','Lonely Planet vừa chọn ra những trải nghiệm ẩm thực nổi bật cho du khách trên toàn thế giới trong năm 2022. Việt Nam tự hào có hai đại diện lọt vào top này: phở Hà Nội và bánh mì Hội An. Bên cạnh đó, danh sách còn bao gồm các món ăn đặc sắc từ Mexico, Nhật Bản và Ý — những nền ẩm thực luôn làm say lòng thực khách toàn cầu với hương vị đặc trưng không thể nhầm lẫn.'),
                ('Gần 100 loại bánh dân gian hội tụ ở miền Tây','uploads/article_3.jpg','Rất nhiều món ăn ngon được người dân miền Tây mang đến lễ hội bánh dân gian Nam Bộ. Lễ hội năm nay quy tụ gần 100 loại bánh truyền thống đặc sắc như bánh tét lá cẩm, bánh bò nướng, bánh ít trần, bánh chuối nướng, bánh ú tro... Đây là dịp để người dân và du khách cùng nhau khám phá, thưởng thức và gìn giữ nét ẩm thực văn hóa truyền thống độc đáo của vùng sông nước miền Tây Nam Bộ.'),
                ('10 loại thực phẩm tốt dành cho bà bầu trong suốt thai kỳ','uploads/article_4.jpg','1. Các loại thịt đỏ: Thành phần dinh dưỡng chứa chất sắt và vitamin B. 2. Cá hồi: Giàu omega-3 DHA tốt cho não bộ thai nhi. 3. Trứng: Nguồn protein và choline hoàn hảo. 4. Bông cải xanh: Giàu axit folic, canxi và sắt. 5. Bơ: Chứa folate và kali dồi dào. 6. Quả mọng: Giàu chất chống oxy hóa và vitamin C. 7. Các loại đậu: Nguồn protein và chất xơ thực vật tuyệt vời. 8. Ngũ cốc nguyên hạt: Cung cấp năng lượng bền vững suốt ngày.'),
                ('Bí quyết chọn rau củ tươi ngon tại chợ và siêu thị','uploads/article_5.jpg','Khi đi mua rau củ, bạn cần chú ý đến màu sắc, độ cứng và mùi hương của sản phẩm. Rau xanh tươi thường có màu sáng bóng, không bị héo vàng hay dập nát. Củ quả tươi sẽ cứng chắc khi bóp nhẹ. Tránh mua các loại rau đã có dấu hiệu úa vàng hoặc xuất hiện đốm đen. Nên mua ở những nơi uy tín, có nguồn gốc rõ ràng để đảm bảo an toàn thực phẩm cho cả gia đình bạn mỗi ngày.'),
                ('Top 10 món ăn từ thịt heo dễ làm cho bữa cơm gia đình','uploads/article_6.jpg','Thịt heo là nguyên liệu quen thuộc trong bếp Việt với vô số cách chế biến phong phú. Từ thịt kho tàu đậm đà, sườn rim chua ngọt, thịt luộc chấm mắm tôm, đến bánh cuốn nhân thịt thơm ngon. Mỗi món đều mang hương vị đặc trưng riêng, phù hợp khẩu vị cả nhà. Bài viết này sẽ chia sẻ 10 công thức nấu ăn đơn giản, dễ thực hiện ngay tại nhà với nguyên liệu dễ tìm.'),
                ('Lợi ích tuyệt vời của việc ăn rau xanh mỗi ngày','uploads/article_7.jpg','Ăn rau xanh hàng ngày mang lại vô số lợi ích cho sức khỏe. Rau cung cấp chất xơ giúp tiêu hóa tốt, vitamin và khoáng chất thiết yếu cho cơ thể, đồng thời giúp phòng ngừa nhiều bệnh mãn tính như tiểu đường, tim mạch và ung thư. Các chuyên gia dinh dưỡng khuyến cáo nên ăn ít nhất 400g rau quả mỗi ngày để duy trì sức khỏe tối ưu và làn da tươi trẻ rạng rỡ.'),
                ('Hướng dẫn bảo quản thực phẩm tươi lâu trong tủ lạnh','uploads/article_8.jpg','Bảo quản thực phẩm đúng cách trong tủ lạnh giúp giữ được độ tươi ngon và dinh dưỡng lâu hơn. Thịt cá nên để ngăn đông hoặc ngăn mát dưới cùng. Rau củ nên bọc túi riêng và để ngăn rau củ. Trái cây chín nhanh như chuối, xoài nên để nhiệt độ phòng. Tránh để thức ăn chín và sống gần nhau để ngăn ngừa nhiễm khuẩn chéo. Hãy kiểm tra hạn sử dụng thường xuyên.'),
                ('5 loại trái cây nhập khẩu đang được ưa chuộng nhất hiện nay','uploads/article_9.jpg','Thị trường trái cây nhập khẩu ngày càng đa dạng với nhiều loại trái lạ đến từ khắp nơi trên thế giới. Táo Fuji Nhật Bản ngọt giòn, nho Mỹ hạt to mọng nước, cherry Mỹ đỏ thắm thơm ngon, kiwi New Zealand giàu vitamin C, và bơ Mexico béo ngậy đang là những lựa chọn hàng đầu của người tiêu dùng Việt hiện đại. Mỗi loại đều mang giá trị dinh dưỡng đặc trưng riêng.'),
                ('Công thức làm salad rau củ healthy cho người ăn kiêng','uploads/article_10.jpg','Salad rau củ là món ăn lý tưởng cho những ai đang theo đuổi lối sống lành mạnh và muốn giảm cân hiệu quả. Nguyên liệu gồm rau xà lách, cà chua bi, dưa leo, cà rốt, bắp ngô ngọt và ức gà áp chảo. Sốt trộn từ dầu ô liu, chanh, mật ong và mù tạt mang lại hương vị tươi mát, thanh nhẹ. Món ăn này cung cấp đủ protein, chất xơ và vitamin cần thiết cho cơ thể mỗi ngày.'),
                ('Cách phân biệt thực phẩm hữu cơ và thực phẩm thông thường','uploads/article_11.jpg','Thực phẩm hữu cơ được trồng và chăn nuôi hoàn toàn tự nhiên, không sử dụng thuốc trừ sâu hóa học, phân bón tổng hợp hay hormone tăng trưởng. Để phân biệt, bạn cần chú ý đến tem nhãn chứng nhận VietGAP, GlobalGAP hoặc Organic. Thực phẩm hữu cơ thường có hình dáng không đều, kích thước nhỏ hơn nhưng hương vị đậm đà và giàu dinh dưỡng hơn hẳn so với thực phẩm thông thường.'),
                ('10 mẹo nấu ăn ngon mà không cần nhiều dầu mỡ','uploads/article_12.jpg','Nấu ăn ít dầu mỡ không có nghĩa là món ăn kém ngon. Bạn có thể dùng nồi chống dính thay thế, hấp thay vì chiên rán, dùng lò nướng air fryer, tận dụng gia vị tự nhiên như tỏi gừng sả để tăng hương vị. Xào với nước dùng thay vì dầu, ướp thịt cá kỹ trước khi chế biến cũng là những mẹo nhỏ giúp tiết kiệm dầu mà vẫn đảm bảo hương vị thơm ngon, đậm đà.'),
                ('Giải mã xu hướng ăn uống lành mạnh của giới trẻ năm 2026','uploads/article_13.jpg','Giới trẻ ngày nay ngày càng quan tâm đến sức khỏe và lựa chọn thực phẩm có nguồn gốc rõ ràng. Xu hướng ăn plant-based (thuần thực vật), giảm đường, tăng cường rau xanh và hạt ngũ cốc đang lan rộng mạnh mẽ. Nhiều bạn trẻ chọn smoothie xanh, acai bowl, overnight oats thay cho bữa sáng truyền thống. Đây là tín hiệu tích cực cho thấy ý thức về sức khỏe cộng đồng ngày càng được nâng cao.'),
                ('Thực phẩm giúp tăng cường hệ miễn dịch trong mùa dịch bệnh','uploads/article_14.jpg','Hệ miễn dịch khỏe mạnh là hàng rào bảo vệ tốt nhất cho cơ thể trước các tác nhân gây bệnh. Các thực phẩm tăng cường miễn dịch gồm: tỏi chứa allicin kháng khuẩn mạnh, gừng chống viêm hiệu quả, nghệ với curcumin chống oxy hóa, cam quýt giàu vitamin C, sữa chua probiotic tốt cho đường ruột, và cá hồi giàu omega-3 và vitamin D. Bổ sung đủ nước và ngủ đủ giấc cũng rất quan trọng.'),
                ('Ăn chay đúng cách để không bị thiếu chất dinh dưỡng','uploads/article_15.jpg','Chế độ ăn chay ngày càng phổ biến nhưng cần được lên kế hoạch khoa học để tránh thiếu hụt sắt, kẽm, canxi và vitamin B12. Bạn nên đa dạng hóa các loại hạt dinh dưỡng, đậu nành, nấm và rau xanh đậm màu để đảm bảo cơ thể hấp thu đầy đủ chất dinh dưỡng mỗi ngày.'),
                ('Tác dụng kháng viêm và phục hồi sức khỏe từ củ gừng','uploads/article_16.jpg','Gừng không chỉ là gia vị quen thuộc mà còn là vị thuốc quý từ thiên nhiên. Trà gừng ấm nóng giúp giảm nhanh các triệu chứng buồn nôn, hỗ trợ tiêu hóa, kháng viêm đường hô hấp cực tốt trong những ngày chuyển mùa.'),
                ('Uống nước chanh ấm mật ong vào buổi sáng có thực sự tốt?','uploads/article_17.jpg','Thói quen uống một ly nước chanh ấm mật ong lúc mới thức dậy giúp thanh lọc cơ thể, kích hoạt hệ tiêu hóa và tăng cường sức đề kháng rất tốt. Lưu ý không pha nước quá nóng tránh phá hủy vitamin C trong chanh.'),
                ('Lợi ích sức khỏe của các loại hạt dinh dưỡng bạn nên biết','uploads/article_18.jpg','Hạt hạnh nhân, óc chó, hạt điều, hạt dẻ cười rất giàu chất béo không bão hòa lành mạnh, vitamin và khoáng chất, cực kỳ tốt cho tim mạch và não bộ. Hãy bổ sung một nắm nhỏ hạt dinh dưỡng vào bữa ăn nhẹ hàng ngày.'),
                ('Những sai lầm phổ biến khi chế biến thịt gà dễ gây ngộ độc','uploads/article_19.jpg','Rửa thịt gà sống trực tiếp dưới vòi nước dễ làm vi khuẩn Salmonella lây lan ra các dụng cụ bếp xung quanh. Hãy chế biến chín kỹ thịt gà và khử trùng sạch thớt, dao sau khi sử dụng để đảm bảo vệ sinh.'),
                ('Công thức nấu sữa hạt sen lá dứa thơm mát dễ ngủ tại nhà','uploads/article_20.jpg','Sữa hạt sen lá dứa là thức uống dinh dưỡng thơm ngon tuyệt vời, giúp giải nhiệt và đem lại giấc ngủ sâu tự nhiên. Quy trình chế biến rất đơn giản với hạt sen tươi, sữa tươi nguyên chất và vài nhánh lá dứa.'),
                ('Rau bina (cải bó xôi) và những công dụng thần kỳ với sức khỏe','uploads/article_21.jpg','Cải bó xôi là một trong những loại rau lá xanh giàu dinh dưỡng nhất. Nó cung cấp hàm lượng sắt dồi dào, kali, axit folic và vitamin K tốt cho sự phát triển xương khớp, tim mạch và hỗ trợ ngăn ngừa thiếu máu.'),
                ('Tại sao bơ được mệnh danh là siêu thực phẩm tốt cho tim mạch','uploads/article_22.jpg','Quả bơ chứa nhiều axit béo không bão hòa đơn lành mạnh, giúp kiểm soát tốt lượng cholesterol xấu. Bơ cũng rất giàu kali và chất xơ, thích hợp làm các món sinh tố mát lạnh hoặc salad dinh dưỡng.'),
                ('Cách nấu cháo yến mạch thơm ngon bổ dưỡng cho bé ăn dặm','uploads/article_23.jpg','Yến mạch dễ tiêu hóa và giàu chất xơ hòa tan, rất thích hợp làm cháo ăn dặm cho trẻ nhỏ. Bạn có thể kết hợp yến mạch với bí đỏ ngọt mát, thịt nạc bằm hoặc tôm xay để tạo nên bữa ăn phong phú.'),
                ('Thực phẩm lên men: Bí quyết cho một hệ tiêu hóa khỏe mạnh','uploads/article_24.jpg','Kim chi, sữa chua, dưa cải muối chua cung cấp nguồn probiotics (lợi khuẩn) cực kỳ dồi dào, giúp cân bằng hệ vi sinh đường ruột, tăng khả năng hấp thụ chất dinh dưỡng và tăng đề kháng cơ thể.'),
                ('Tìm hiểu về chế độ ăn Keto và những lưu ý khi áp dụng','uploads/article_25.jpg','Chế độ ăn kiêng Ketogenic cắt giảm tinh bột ở mức tối đa, thay bằng chất béo tốt và protein. Phương pháp này giúp đốt mỡ giảm cân hiệu quả nhưng cần thực hiện đúng cách để tránh mệt mỏi.'),
                ('7 lợi ích tuyệt vời của trà xanh đối với sức khỏe răng miệng','uploads/article_26.jpg','Trà xanh chứa chất chống oxy hóa epigallocatechin gallate (EGCG) giúp ức chế sự phát triển của vi khuẩn có hại trong khoang miệng, ngăn ngừa sâu răng, viêm nướu và giữ hơi thở luôn thơm mát.'),
                ('Bí quyết tự làm sữa chua Hy Lạp dẻo mịn cực đơn giản tại nhà','uploads/article_27.jpg','Sữa chua Hy Lạp được lọc tách nước whey nên có kết cấu vô cùng dẻo mịn và hàm lượng đạm cao gấp đôi sữa chua thông thường. Bạn hoàn toàn có thể tự làm tại nhà bằng túi lọc đơn giản.'),
                ('Ăn gì để cải thiện giấc ngủ tự nhiên không cần dùng thuốc','uploads/article_28.jpg','Các loại thực phẩm như hạt sen, chuối chín, sữa tươi ấm, kiwi và quả óc chó chứa tryptophan và melatonin tự nhiên, có tác dụng an thần, xoa dịu căng thẳng thần kinh và mang lại giấc ngủ ngon.'),
                ('Những lưu ý quan trọng khi chọn mua hải sản đông lạnh an toàn','uploads/article_29.jpg','Khi chọn mua hải sản đông lạnh ở siêu thị, bạn nên kiểm tra kỹ hạn sử dụng, màu sắc tự nhiên của thực phẩm và tránh mua các gói có lớp tuyết đóng quá dày vì có thể đã bị rã đông rồi cấp đông lại.'),
                ('Hạt chia và cách bổ sung năng lượng tự nhiên cho cơ thể','uploads/article_30.jpg','Hạt chia chứa lượng omega-3, chất xơ và protein dồi dào. Thêm một thìa hạt chia vào cốc nước ấm, sữa chua hoặc sinh tố trái cây mỗi ngày giúp duy trì năng lượng bền bỉ cho cơ thể hoạt động.'),
                ('Vì sao nên hạn chế ăn thực phẩm chế biến sẵn quá nhiều','uploads/article_31.jpg','Đồ ăn nhanh, xúc xích, đồ hộp chứa rất nhiều muối, chất bảo quản và chất béo bão hòa. Lạm dụng các sản phẩm này làm tăng đáng kể nguy cơ béo phì, tăng huyết áp và các bệnh tim mạch.'),
                ('Cách làm nước detox thanh lọc cơ thể từ dưa leo và bạc hà','uploads/article_32.jpg','Nước detox dưa leo bạc hà vừa thanh mát dễ uống vừa giúp cơ thể đào thải độc tố hiệu quả, hỗ trợ quá trình giảm cân và mang lại cho bạn một làn da khỏe mạnh, sáng bóng tự nhiên.'),
                ('Tác hại của việc ăn quá nhiều muối và cách giảm vị mặn hàng ngày','uploads/article_33.jpg','Thói quen ăn quá mặn gây áp lực lớn lên thận và hệ tim mạch. Hãy tập thói quen giảm lượng muối nêm nếm, ưu tiên các loại thảo mộc và gia vị tự nhiên để kích thích vị giác lành mạnh hơn.'),
                ('Lợi ích của chuối chín đối với người tập luyện thể thao','uploads/article_34.jpg','Chuối cung cấp nguồn kali và carbohydrate hấp thu nhanh giúp bù đắp năng lượng tiêu hao, ngăn ngừa tình trạng chuột rút cơ bắp hiệu quả. Đây là món ăn nhẹ tuyệt vời trước buổi tập.'),
                ('Các món ngon thanh đạm giải nhiệt cho những ngày hè nắng nóng','uploads/article_35.jpg','Canh chua dọc mùng cá lóc, canh bí đao sườn non ngọt mát hay chè hạt sen nhãn nhục thanh tao là những món ăn vô cùng lý tưởng để giải nhiệt cơ thể cho cả gia đình trong những ngày hè.'),
                ('Tầm quan trọng của Vitamin D và cách hấp thụ tối ưu nhất','uploads/article_36.jpg','Vitamin D giúp tăng hấp thụ canxi, bảo vệ hệ xương răng chắc khỏe và củng cố miễn dịch. Bạn có thể bổ sung Vitamin D qua ánh nắng sớm hoặc qua các loại thực phẩm như lòng đỏ trứng, cá hồi.'),
                ('5 thói quen ăn uống giúp ngăn ngừa lão hóa da hiệu quả','uploads/article_37.jpg','Uống nhiều nước lọc, bổ sung chất chống oxy hóa từ các loại quả mọng, ăn nhiều cá béo giàu omega-3, hạn chế đồ ngọt và duy trì khẩu phần rau xanh là chìa khóa giữ gìn làn da luôn tươi trẻ.'),
                ('Mẹo khử mùi tanh của cá sông cực hiệu quả khi nấu ăn','uploads/article_38.jpg','Để món cá sông không bị mùi tanh bùn đất, bạn có thể ngâm cá trong nước vo gạo, chà sát kỹ bằng muối hột và nước chanh hoặc pha một chút rượu trắng khi rửa sạch cá trước khi tẩm ướp.'),
                ('Chế độ ăn Địa Trung Hải: Lối sống lành mạnh giúp kéo dài tuổi thọ','uploads/article_39.jpg','Tập trung nhiều vào rau xanh, ngũ cốc nguyên hạt, dầu ô liu tinh khiết và các loại cá, chế độ ăn Địa Trung Hải được nhiều nghiên cứu khoa học chứng minh giúp bảo vệ tim mạch và tăng thọ.')");

            // Bảng promotions
            $pdo->exec("DROP TABLE IF EXISTS `promotions`");
            $pdo->exec("CREATE TABLE `promotions` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) NOT NULL,
                `subtitle` VARCHAR(255) DEFAULT NULL,
                `image` VARCHAR(255) DEFAULT NULL,
                `badge` VARCHAR(100) DEFAULT NULL,
                `btn_text` VARCHAR(100) DEFAULT 'Xem ngay',
                `btn_link` VARCHAR(255) DEFAULT '/',
                `sort_order` INT DEFAULT 0,
                `is_active` TINYINT(1) DEFAULT 1,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            $pdo->exec("INSERT INTO `promotions` (`title`,`subtitle`,`image`,`badge`,`btn_text`,`btn_link`,`sort_order`) VALUES
                ('Ưu đãi cuối tuần – Giảm 30% toàn bộ rau củ','Chỉ từ Thứ Bảy đến Chủ Nhật hàng tuần','uploads/news_banner_1.png','HOT DEAL','Mua ngay','/products',1),
                ('Trái cây nhập khẩu chính hãng giảm 25%','Táo Mỹ, Cam Úc, Nho Hàn Quốc – Tươi ngon mỗi ngày','uploads/news_banner_2.png','NEW IN','Khám phá','/products',2),
                ('Combo thịt heo C.P siêu tiết kiệm','Mua 2 tặng 1 – Áp dụng cho toàn bộ dòng C.P','uploads/news_banner_3.png','SALE 50%','Xem combo','/products',3),
                ('Thực phẩm hữu cơ VietGAP xanh-sạch-đẹp','Đảm bảo nguồn gốc, chứng nhận an toàn','uploads/news_banner_4.png','ORGANIC','Tìm hiểu','/about',4),
                ('Flash Sale: Rau xà lách Đà Lạt chỉ 15.000đ','Số lượng có hạn – Đặt hàng ngay hôm nay!','uploads/news_banner_5.png','FLASH SALE','Đặt ngay','/products',5),
                ('Freeship toàn quốc cho đơn từ 199.000đ','Giao hàng tận nơi nhanh chóng trong 2 giờ','uploads/news_banner_6.png','FREESHIP','Đặt hàng','/products',6)");

            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
        }
    } catch (\Exception $e) {
        // Không crash app - chỉ log lỗi nếu có
        error_log("AutoSetupDB Error: " . $e->getMessage());
    }
}

autoSetupDatabase();
// =====================================================================

// Include routing logic
require_once __DIR__ . '/route.php';
