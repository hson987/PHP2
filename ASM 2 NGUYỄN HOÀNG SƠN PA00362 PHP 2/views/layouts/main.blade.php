<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Z DEMO - Thực Phẩm Sạch & Rau Củ Quả')</title>
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    <!-- Top Bar -->
    <div class="bg-slate-100 border-b border-slate-200 text-xs text-slate-600 py-2">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div class="flex space-x-6">
                <span class="hover:text-emerald-600 cursor-pointer transition">Hệ thống cửa hàng</span>
                <span class="hover:text-emerald-600 cursor-pointer transition">Hỗ trợ mua hàng</span>
            </div>
            <div class="flex space-x-6">
                <span class="hover:text-emerald-600 cursor-pointer transition">Sản phẩm mới</span>
                <span class="hover:text-emerald-600 cursor-pointer transition">Yêu thích <span class="text-emerald-600 font-bold">0</span></span>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <header class="bg-white shadow-sm border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                
                <!-- Logo Z DEMO -->
                <div class="flex items-center justify-between">
                    <a href="{{ BASE_URL }}/" class="text-3xl font-extrabold flex items-center tracking-tight">
                        <span class="text-blue-600">Z</span>
                        <span class="text-emerald-500 ml-1">DEMO</span>
                    </a>
                    <div class="md:hidden">
                        <span class="text-xs px-2 py-1 rounded bg-emerald-50 text-emerald-600 font-semibold">PA00362</span>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="flex-grow max-w-xl md:mx-8">
                    <form action="#" class="relative flex items-center">
                        <input type="text" placeholder="Tìm sản phẩm..." class="w-full pl-4 pr-12 py-2.5 bg-slate-100 focus:bg-white border border-slate-200 focus:border-emerald-500 rounded-lg outline-none text-sm transition duration-200">
                        <button type="submit" class="absolute right-3 text-slate-500 hover:text-emerald-600">
                            <i class="fa-solid fa-magnifying-glass text-lg"></i>
                        </button>
                    </form>
                </div>

                <!-- Hotline, Login & Cart -->
                <div class="flex items-center justify-between sm:justify-end space-x-6">
                    <div class="flex items-center space-x-3 text-sm text-slate-700">
                        <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Hotline</p>
                            <p class="font-bold text-slate-800">0123 456 789</p>
                        </div>
                    </div>

                    @if(isset($_SESSION['admin']))
                        <div class="flex items-center space-x-3 text-sm text-slate-700">
                            <span class="text-xs px-2 py-1 rounded-full bg-rose-50 text-rose-600 font-bold border border-rose-100 flex items-center">
                                <i class="fa-solid fa-user-shield mr-1"></i> Admin
                            </span>
                            <span class="font-bold text-slate-800 max-w-[120px] truncate">{{ $_SESSION['admin']['fullname'] }}</span>
                            <a href="{{ BASE_URL }}/admin/products" class="text-xs font-bold text-blue-600 hover:text-blue-700 bg-blue-50 border border-blue-100 hover:bg-blue-100 px-2 py-1 rounded-lg transition flex items-center gap-1">
                                <i class="fa-solid fa-gears"></i> Quản trị
                            </a>
                            <a href="{{ BASE_URL }}/admin/articles" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 border border-emerald-100 hover:bg-emerald-100 px-2 py-1 rounded-lg transition flex items-center gap-1">
                                <i class="fa-solid fa-newspaper"></i> Quản lý Bài viết
                            </a>
                            <a href="{{ BASE_URL }}/admin/categories" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 bg-indigo-50 border border-indigo-100 hover:bg-indigo-100 px-2 py-1 rounded-lg transition flex items-center gap-1">
                                <i class="fa-solid fa-tags"></i> Quản lý Danh mục
                            </a>
                            <a href="{{ BASE_URL }}/logout" class="text-xs font-bold text-rose-600 hover:text-rose-700 transition flex items-center gap-1">
                                <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                            </a>
                        </div>
                    @elseif(isset($_SESSION['user']))
                        <div class="flex items-center space-x-3 text-sm text-slate-700">
                            <span class="text-xs px-2 py-1 rounded-full bg-emerald-50 text-emerald-600 font-bold border border-emerald-100 flex items-center">
                                <i class="fa-solid fa-user mr-1"></i> Khách
                            </span>
                            <span class="font-bold text-slate-800 max-w-[120px] truncate">{{ $_SESSION['user']['fullname'] }}</span>
                            <a href="{{ BASE_URL }}/logout" class="text-xs font-bold text-rose-600 hover:text-rose-700 transition flex items-center gap-1">
                                <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                            </a>
                        </div>
                    @else
                        <a href="{{ BASE_URL }}/login" class="text-sm text-slate-700 hover:text-emerald-600 font-semibold transition flex items-center gap-1.5">
                            <i class="fa-solid fa-right-to-bracket text-emerald-500"></i> Đăng nhập
                        </a>
                    @endif

                    <a href="javascript:void(0)" onclick="toggleCartDrawer()" class="relative flex items-center space-x-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl transition shadow-sm shadow-emerald-100">
                        <i class="fa-solid fa-basket-shopping"></i>
                        <span class="text-sm font-semibold">Giỏ hàng</span>
                        <span id="cart-badge" class="absolute -top-2 -right-2 bg-rose-500 text-white text-[9px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm scale-0 transition duration-300">0</span>
                    </a>
                </div>

            </div>

            <!-- Main Navigation Menu -->
            <div class="flex items-center justify-between border-t border-slate-100 mt-4 pt-3">
                <nav class="flex space-x-8 text-sm font-semibold text-slate-600">
                    <a href="{{ BASE_URL }}/" class="text-emerald-600 border-b-2 border-emerald-500 pb-1">Trang chủ</a>
                    <a href="{{ BASE_URL }}/about" class="hover:text-emerald-600 transition pb-1">Giới thiệu</a>
                    <a href="{{ BASE_URL }}/products" class="hover:text-emerald-600 transition pb-1">Cửa hàng</a>
                    <a href="{{ BASE_URL }}/news" class="hover:text-emerald-600 transition pb-1">Tin tức</a>
                    <a href="{{ BASE_URL }}/contact" class="hover:text-emerald-600 transition pb-1">Liên hệ</a>
                </nav>
                <div class="hidden md:flex items-center space-x-2">
                    <a href="{{ BASE_URL }}/import-db" class="text-xs font-bold px-3 py-1.5 rounded-full bg-blue-50 text-blue-600 border border-blue-100 hover:bg-blue-100 transition flex items-center">
                        <i class="fa-solid fa-database mr-1"></i> Nhập CSDL mẫu
                    </a>
                    <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">
                        Nguyễn Hoàng Sơn - PA00362
                    </span>
                </div>
            </div>

        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-sm text-slate-600 pb-8 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 flex items-center">
                        <span class="text-blue-600">Z</span>
                        <span class="text-emerald-500 ml-1">DEMO</span>
                    </h3>
                    <p class="mt-3 leading-relaxed text-slate-500">Z DEMO cung cấp thực phẩm sạch, nông sản VietGAP và trái cây nhập khẩu tươi ngon thượng hạng cho gia đình bạn.</p>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-3">Liên kết hữu ích</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-emerald-600 transition">Hướng dẫn mua sắm</a></li>
                        <li><a href="#" class="hover:text-emerald-600 transition">Chính sách giao hàng</a></li>
                        <li><a href="#" class="hover:text-emerald-600 transition">Chính sách bảo mật</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-3">Liên hệ</h4>
                    <p class="text-slate-500">Địa chỉ: Trụ sở FPT Polytechnic</p>
                    <p class="mt-1 text-slate-500">Email: sonnhpa00362@fpt.edu.vn</p>
                </div>
            </div>
            <div class="text-center pt-6 text-xs text-slate-400">
                <p>&copy; 2026 Nguyễn Hoàng Sơn - PA00362. Assignment 2 - PHP 2.</p>
                <p class="mt-1">Xây dựng trên mô hình MVC với BladeOne & Phroute</p>
            </div>
        </div>
    </footer>

    <!-- Shopping Cart Drawer Overlay -->
    <div id="cart-overlay" onclick="toggleCartDrawer()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 opacity-0 pointer-events-none transition-opacity duration-300"></div>

    <!-- Shopping Cart Drawer -->
    <div id="cart-drawer" class="fixed right-0 top-0 bottom-0 w-full max-w-md bg-white shadow-2xl z-50 translate-x-full transition-transform duration-300 flex flex-col">
        <!-- Header -->
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-lg font-black text-slate-900 flex items-center">
                <span class="bg-emerald-50 text-emerald-600 rounded-lg p-2 mr-2.5 text-xs"><i class="fa-solid fa-cart-shopping"></i></span>
                Giỏ Hàng Của Bạn
            </h3>
            <button onclick="toggleCartDrawer()" class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:bg-slate-100 hover:text-slate-700 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Cart Items list -->
        <div id="cart-items-container" class="flex-grow p-6 overflow-y-auto space-y-4">
            <!-- Dynamically populated -->
        </div>

        <!-- Footer / Total -->
        <div class="p-6 border-t border-slate-100 bg-slate-50 space-y-4">
            <div class="flex items-center justify-between font-bold text-slate-800">
                <span>Tổng tiền:</span>
                <span id="cart-total-amount" class="text-lg text-rose-600 font-black">0đ</span>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <button onclick="clearCart()" class="w-full py-3 border border-slate-200 text-slate-500 rounded-xl font-bold hover:bg-white transition text-xs">
                    Xóa tất cả
                </button>
                <button onclick="showCheckoutModal()" class="w-full py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition shadow-md shadow-emerald-100 text-xs">
                    Thanh toán
                </button>
            </div>
        </div>
    </div>

    <!-- Checkout Modal Backdrop -->
    <div id="checkout-overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 opacity-0 pointer-events-none transition-opacity duration-300 flex items-center justify-center p-4">
        <!-- Checkout Card -->
        <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl p-6 md:p-8 space-y-6 transform scale-95 transition-transform duration-300 flex flex-col max-h-[90vh] overflow-y-auto relative z-50">
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-xl font-black text-slate-900 flex items-center">
                    <span class="bg-blue-50 text-blue-600 rounded-lg p-2 mr-2.5 text-xs"><i class="fa-solid fa-credit-card"></i></span>
                    Thông Tin Thanh Toán
                </h3>
                <button onclick="hideCheckoutModal()" class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:bg-slate-100 hover:text-slate-700 flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Checkout Form -->
            <form id="checkout-form" onsubmit="processCheckout(event)" class="space-y-4 text-xs font-semibold text-slate-700">
                <div class="space-y-1.5">
                    <label for="checkout-name" class="block">Họ và tên khách hàng</label>
                    <input type="text" id="checkout-name" required placeholder="Ví dụ: Nguyễn Hoàng Sơn" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 outline-none rounded-xl transition">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="checkout-phone" class="block">Số điện thoại</label>
                        <input type="tel" id="checkout-phone" required placeholder="Ví dụ: 0912345678" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 outline-none rounded-xl transition">
                    </div>
                    <div class="space-y-1.5">
                        <label for="checkout-payment" class="block">Phương thức thanh toán</label>
                        <select id="checkout-payment" onchange="togglePaymentQR()" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 outline-none rounded-xl transition">
                            <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                            <option value="banking">Chuyển khoản ngân hàng (QR Code)</option>
                            <option value="momo">Ví điện tử MoMo</option>
                        </select>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label for="checkout-address" class="block">Địa chỉ nhận hàng</label>
                    <textarea id="checkout-address" rows="3" required placeholder="Địa chỉ chi tiết (Số nhà, đường, phường/xã, quận/huyện...)" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 outline-none rounded-xl transition resize-none"></textarea>
                </div>

                <!-- QR Banking Section -->
                <div id="qr-section" class="hidden bg-blue-50/50 border border-blue-100 rounded-2xl p-4 flex flex-col items-center text-center space-y-3">
                    <p class="text-[11px] text-blue-900 font-bold">Quét mã VietQR để thanh toán chuyển khoản:</p>
                    <img id="qr-code-img" src="" alt="VietQR Payment" class="w-48 h-48 object-contain bg-white p-2 border border-slate-100 rounded-xl shadow-xs">
                    <p class="text-[10px] text-slate-400 font-normal">Nội dung chuyển khoản: <span id="qr-memo" class="font-bold text-slate-700"></span></p>
                </div>

                <!-- Footer Summary & Submit -->
                <div class="border-t border-slate-100 pt-4 mt-6 flex flex-col space-y-4">
                    <div class="flex items-center justify-between font-bold text-slate-800 text-sm">
                        <span>Tổng tiền thanh toán:</span>
                        <span id="checkout-total-amount" class="text-rose-600 font-black">0đ</span>
                    </div>
                    <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm rounded-xl transition shadow-md shadow-emerald-50 tracking-wide">
                        XÁC NHẬN ĐẶT HÀNG & MUA NGAY
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Order Success Modal -->
    <div id="success-overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 opacity-0 pointer-events-none transition-opacity duration-300 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-sm shadow-2xl p-6 text-center space-y-4 transform scale-95 transition-transform duration-300 relative z-50">
            <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-3xl animate-bounce">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h3 class="text-lg font-black text-slate-900">Đặt hàng thành công!</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Đơn hàng của bạn đã được tiếp nhận. Đội ngũ giao hàng Wolf Food sẽ liên hệ xác nhận trong vòng 10 phút. Cảm ơn bạn!</p>
            <button onclick="hideSuccessModal()" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition text-xs">
                Tuyệt vời, quay lại mua sắm
            </button>
        </div>
    </div>

    <!-- Shopping Cart Logic -->
    <script>
        (function() {
            let cart = [];
            const baseUrl = "{{ BASE_URL }}";

            // Load cart from localStorage
            function loadCart() {
                try {
                    const saved = localStorage.getItem('cart');
                    cart = saved ? JSON.parse(saved) : [];
                } catch(e) {
                    cart = [];
                }
                updateCartBadge();
            }

            // Save cart to localStorage
            function saveCart() {
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartBadge();
                renderCart();
            }

            // Add item to cart
            window.addToCart = function(item) {
                // Check if item already exists
                const existing = cart.find(x => x.id === item.id);
                if (existing) {
                    existing.quantity += 1;
                } else {
                    cart.push({
                        id: item.id,
                        name: item.name,
                        price: parseFloat(item.price),
                        image: item.image,
                        quantity: 1
                    });
                }
                saveCart();
                animateCartBadge();
            };

            // Update item quantity
            window.updateQuantity = function(id, delta) {
                const item = cart.find(x => x.id === id);
                if (item) {
                    item.quantity += delta;
                    if (item.quantity <= 0) {
                        cart = cart.filter(x => x.id !== id);
                    }
                    saveCart();
                }
            };

            // Remove item from cart
            window.removeFromCart = function(id) {
                cart = cart.filter(x => x.id !== id);
                saveCart();
            };

            // Clear cart
            window.clearCart = function() {
                if (confirm('Bạn có chắc muốn xóa sạch giỏ hàng không?')) {
                    cart = [];
                    saveCart();
                }
            };

            // Calculate total price
            function getCartTotal() {
                return cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            }

            // Update cart badge icon
            function updateCartBadge() {
                const $badge = $('#cart-badge');
                if (!$badge.length) return;
                const totalQty = cart.reduce((sum, item) => sum + item.quantity, 0);
                $badge.text(totalQty);
                if (totalQty > 0) {
                    $badge.removeClass('scale-0').addClass('scale-100');
                } else {
                    $badge.removeClass('scale-100').addClass('scale-0');
                }
            }

            // Animate badge on add to cart
            function animateCartBadge() {
                const $badge = $('#cart-badge');
                if (!$badge.length) return;
                $badge.addClass('scale-125');
                setTimeout(() => {
                    $badge.removeClass('scale-125');
                }, 150);
            }

            // Toggle cart drawer visibility
            window.toggleCartDrawer = function() {
                const $drawer = $('#cart-drawer');
                const $overlay = $('#cart-overlay');
                if (!$drawer.length || !$overlay.length) return;

                const isOpen = !$drawer.hasClass('translate-x-full');
                if (isOpen) {
                    $drawer.addClass('translate-x-full');
                    $overlay.addClass('opacity-0 pointer-events-none');
                } else {
                    renderCart();
                    $drawer.removeClass('translate-x-full');
                    $overlay.removeClass('opacity-0 pointer-events-none');
                }
            };

            // Render items in cart drawer
            function renderCart() {
                const $container = $('#cart-items-container');
                const $totalDisplay = $('#cart-total-amount');
                if (!$container.length || !$totalDisplay.length) return;

                if (cart.length === 0) {
                    $container.html(`
                        <div class="flex flex-col items-center justify-center h-64 text-slate-400 space-y-4">
                            <i class="fa-solid fa-basket-shopping text-4xl text-slate-200"></i>
                            <p class="text-xs">Giỏ hàng của bạn đang trống.</p>
                        </div>
                    `);
                    $totalDisplay.text('0đ');
                    return;
                }

                let html = '';
                cart.forEach(item => {
                    const priceFormatted = new Intl.NumberFormat('vi-VN').format(item.price) + 'đ';
                    const subtotalFormatted = new Intl.NumberFormat('vi-VN').format(item.price * item.quantity) + 'đ';
                    const imageUrl = item.image.startsWith('http') ? item.image : `${baseUrl}/${item.image}`;

                    html += `
                        <div class="flex items-center gap-4 bg-slate-50 p-3 rounded-2xl border border-slate-100 relative group">
                            <!-- Remove button -->
                            <button onclick="removeFromCart(${item.id})" class="absolute top-2 right-2 text-slate-300 hover:text-rose-500 transition">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>

                            <!-- Image -->
                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-white border border-slate-100 flex-shrink-0">
                                <img src="${imageUrl}" alt="${item.name}" class="w-full h-full object-cover">
                            </div>

                            <!-- Info -->
                            <div class="flex-grow space-y-1 min-w-0 pr-4">
                                <h4 class="text-xs font-bold text-slate-800 truncate">${item.name}</h4>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <button onclick="updateQuantity(${item.id}, -1)" class="w-5 h-5 rounded bg-white border border-slate-200 flex items-center justify-center text-[10px] hover:bg-slate-100">-</button>
                                        <span class="text-xs font-bold text-slate-700">${item.quantity}</span>
                                        <button onclick="updateQuantity(${item.id}, 1)" class="w-5 h-5 rounded bg-white border border-slate-200 flex items-center justify-center text-[10px] hover:bg-slate-100">+</button>
                                    </div>
                                    <span class="text-xs font-black text-rose-500">${subtotalFormatted}</span>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $container.html(html);
                $totalDisplay.text(new Intl.NumberFormat('vi-VN').format(getCartTotal()) + 'đ');
            }

            // Checkout Modal control
            window.showCheckoutModal = function() {
                if (cart.length === 0) {
                    alert('Giỏ hàng của bạn đang trống!');
                    return;
                }
                toggleCartDrawer(); // Close drawer
                
                const $overlay = $('#checkout-overlay');
                const $totalDisplay = $('#checkout-total-amount');
                if ($overlay.length && $totalDisplay.length) {
                    $totalDisplay.text(new Intl.NumberFormat('vi-VN').format(getCartTotal()) + 'đ');
                    $overlay.removeClass('opacity-0 pointer-events-none');
                    $overlay.children().first().removeClass('scale-95');
                }
                togglePaymentQR();
            };

            window.hideCheckoutModal = function() {
                const $overlay = $('#checkout-overlay');
                if ($overlay.length) {
                    $overlay.addClass('opacity-0 pointer-events-none');
                    $overlay.children().first().addClass('scale-95');
                }
            };

            // Show QR banking dynamically
            window.togglePaymentQR = function() {
                const payment = $('#checkout-payment').val();
                const $qrSection = $('#qr-section');
                const $qrImg = $('#qr-code-img');
                const $qrMemo = $('#qr-memo');

                if (payment === 'banking') {
                    const total = getCartTotal();
                    const memo = 'WF' + Date.now().toString().slice(-6);
                    $qrMemo.text(memo);
                    $qrImg.attr('src', `https://api.vietqr.io/image/970415-113366668888-vietqr.jpg?accountName=WOLF%20FOOD&amount=${total}&addInfo=${encodeURIComponent(memo)}`);
                    $qrSection.removeClass('hidden');
                } else {
                    $qrSection.addClass('hidden');
                }
            };

            // Process Checkout Order Submit
            window.processCheckout = function(event) {
                event.preventDefault();
                
                // Clear cart state
                cart = [];
                localStorage.removeItem('cart');
                updateCartBadge();
                
                // Close checkout modal
                hideCheckoutModal();
                
                // Show order success modal
                showSuccessModal();
            };

            // Success modal controls
            window.showSuccessModal = function() {
                const $overlay = $('#success-overlay');
                if ($overlay.length) {
                    $overlay.removeClass('opacity-0 pointer-events-none');
                    $overlay.children().first().removeClass('scale-95');
                }
            };

            // success modal hides
            window.hideSuccessModal = function() {
                const $overlay = $('#success-overlay');
                if ($overlay.length) {
                    $overlay.addClass('opacity-0 pointer-events-none');
                    $overlay.children().first().addClass('scale-95');
                }
            };

            // Bind click events dynamically on document to support dynamic products using jQuery
            $(document).on('click', '.add-to-cart-btn', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const id = parseInt($btn.attr('data-id'));
                const name = $btn.attr('data-name');
                const price = parseFloat($btn.attr('data-price'));
                const image = $btn.attr('data-image');
                
                window.addToCart({id, name, price, image});
            });

            // Initialize cart
            loadCart();
        })();
    </script>
</body>
</html>
