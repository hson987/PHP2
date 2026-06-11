@extends('layouts.main')

@section('title', 'Z DEMO - Thực Phẩm Sạch & Đi Chợ Online')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap');
.font-cursive {
    font-family: 'Dancing Script', cursive;
}
/* === Homepage Mini Card Slider === */
.product-slider .slider-dot {
    display: inline-block;
    width: 6px; height: 6px;
    border-radius: 50%;
    background: rgba(255,255,255,0.55);
    border: 1px solid rgba(255,255,255,0.35);
    cursor: pointer;
    transition: all .2s ease;
    box-shadow: 0 1px 2px rgba(0,0,0,.2);
    flex-shrink: 0;
}
.product-slider .slider-dot.active {
    background: #34d399;
    border-color: #10b981;
    transform: scale(1.4);
}
.product-slider .slider-main-img {
    transition: opacity .18s ease;
}
.card-nav-btn {
    position: absolute;
    top: 50%; transform: translateY(-50%);
    width: 28px; height: 28px;
    border-radius: 50%;
    background: rgba(255,255,255,.88);
    box-shadow: 0 1px 6px rgba(0,0,0,.18);
    border: none;
    display: flex; align-items: center; justify-content: center;
    color: #334155;
    cursor: pointer;
    z-index: 25;
    font-size: 10px;
    opacity: 0;
    transition: opacity .2s, background .2s, color .2s;
}
.product-card:hover .card-nav-btn { opacity: 1; }
.card-nav-btn:hover { background: #10b981; color: #fff; }
.card-nav-prev { left: 8px; }
.card-nav-next { right: 8px; }
.slider-thumb.active {
    border-color: #10b981 !important;
}
</style>
<div class="space-y-12">

    <!-- === Hero Banner Slider (6 ảnh) === -->
    <div id="hero-slider" class="relative rounded-3xl overflow-hidden shadow-xl" style="height:340px;">

        <!-- Slides -->
        @php
        $heroBanners = [
            ['img' => BASE_URL . '/uploads/banner_hero_1.png', 'label' => 'TechShop & Z DEMO', 'title' => 'Đi Chợ Online', 'sub' => 'Tươi Ngon Thượng Hạng', 'desc' => 'Nông sản hữu cơ đạt chuẩn VietGAP, tươi sạch mỗi ngày.', 'btn' => 'MUA NGAY', 'link' => '#featured-products', 'bg' => 'from-cyan-500 via-sky-500 to-blue-600'],
            ['img' => BASE_URL . '/uploads/banner_hero_2.png', 'label' => 'Trái cây nhập khẩu', 'title' => 'Trái Cây Tươi Ngon', 'sub' => 'Nhập khẩu chính hãng', 'desc' => 'Hàng trăm loại trái cây tươi ngon từ khắp nơi trên thế giới.', 'btn' => 'XEM NGAY', 'link' => BASE_URL . '/products', 'bg' => 'from-orange-400 via-amber-400 to-yellow-500'],
            ['img' => BASE_URL . '/uploads/banner_hero_3.png', 'label' => '🔥 Flash Sale', 'title' => 'Săn Sale Siêu Hời', 'sub' => 'Giảm đến 50%', 'desc' => 'Hàng ngàn sản phẩm khuyến mãi mỗi ngày, số lượng có hạn!', 'btn' => 'SĂN NGAY', 'link' => BASE_URL . '/products', 'bg' => 'from-rose-600 via-red-500 to-orange-500'],
            ['img' => BASE_URL . '/uploads/banner_hero_4.png', 'label' => 'Hữu cơ & VietGAP', 'title' => 'Nông Sản Hữu Cơ', 'sub' => 'Chuẩn VietGAP', 'desc' => 'Được trồng và chăm sóc theo tiêu chuẩn hữu cơ nghiêm ngặt.', 'btn' => 'TÌM HIỂU', 'link' => BASE_URL . '/products', 'bg' => 'from-emerald-600 via-green-500 to-teal-500'],
            ['img' => BASE_URL . '/uploads/banner_hero_5.png', 'label' => '🛵 Giao hàng nhanh', 'title' => 'Giao Hàng Miễn Phí', 'sub' => 'Trong vòng 2 giờ', 'desc' => 'Đặt hàng trước 10 giờ sáng — nhận ngay trong buổi sáng!', 'btn' => 'ĐẶT HÀNG', 'link' => BASE_URL . '/products', 'bg' => 'from-violet-600 via-purple-500 to-fuchsia-500'],
            ['img' => BASE_URL . '/uploads/banner_hero_6.png', 'label' => 'Hải sản & Thịt tươi', 'title' => 'Thịt Cá Tươi Ngon', 'sub' => 'Nhập mới mỗi ngày', 'desc' => 'Hải sản cao cấp, thịt sạch — đảm bảo chất lượng từ trang trại đến bàn ăn.', 'btn' => 'XEM SẢN PHẨM', 'link' => BASE_URL . '/products', 'bg' => 'from-slate-800 via-blue-900 to-indigo-900'],
        ];
        @endphp

        @foreach($heroBanners as $bi => $banner)
        <div class="hero-slide absolute inset-0 transition-opacity duration-700 bg-gradient-to-r {{ $banner['bg'] }}"
             style="{{ $bi === 0 ? 'opacity:1;z-index:2;' : 'opacity:0;z-index:1;' }}">
            <!-- Background image overlay -->
            <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('{{ $banner['img'] }}'); opacity:0.35;"></div>
            <!-- Content -->
            <div class="relative z-10 h-full flex flex-col md:flex-row items-center justify-between px-8 sm:px-14 gap-6">
                <div class="max-w-xl space-y-4 text-white text-center md:text-left">
                    <span class="inline-block bg-white/20 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider border border-white/30">
                        {{ $banner['label'] }}
                    </span>
                    <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight drop-shadow-sm uppercase">
                        {{ $banner['title'] }}<br>
                        <span class="text-yellow-300">{{ $banner['sub'] }}</span>
                    </h2>
                    <p class="text-white/85 text-sm sm:text-base leading-relaxed">
                        {{ $banner['desc'] }}
                    </p>
                    <div class="pt-2">
                        <a href="{{ $banner['link'] }}" class="inline-flex items-center gap-2 px-7 py-3 rounded-full bg-yellow-400 hover:bg-yellow-300 text-slate-900 font-extrabold shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 duration-200 text-sm">
                            {{ $banner['btn'] }} <i class="fa-solid fa-chevron-right text-xs"></i>
                        </a>
                    </div>
                </div>
                <!-- Ảnh phụ bên phải -->
                <div class="hidden md:flex flex-shrink-0 w-72 h-52 rounded-2xl overflow-hidden border-4 border-white/30 shadow-2xl">
                    <img src="{{ $banner['img'] }}" alt="{{ $banner['title'] }}" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
        @endforeach

        <!-- Prev / Next Buttons -->
        <button id="hero-prev" type="button" style="position:absolute;left:16px;top:50%;transform:translateY(-50%);z-index:30;width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,0.2);border:2px solid rgba(255,255,255,0.5);color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:16px;backdrop-filter:blur(4px);transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,0.4)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button id="hero-next" type="button" style="position:absolute;right:16px;top:50%;transform:translateY(-50%);z-index:30;width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,0.2);border:2px solid rgba(255,255,255,0.5);color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:16px;backdrop-filter:blur(4px);transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,0.4)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

        <!-- Dot Indicators -->
        <div id="hero-dots" style="position:absolute;bottom:16px;left:0;right:0;display:flex;justify-content:center;gap:8px;z-index:30;">
            @foreach($heroBanners as $bi => $banner)
            <span class="hero-dot" data-index="{{ $bi }}"
                  style="display:inline-block;width:{{ $bi===0 ? '28px' : '10px' }};height:10px;border-radius:5px;background:{{ $bi===0 ? 'rgba(255,255,255,1)' : 'rgba(255,255,255,0.45)' }};cursor:pointer;transition:all .3s ease;box-shadow:0 1px 4px rgba(0,0,0,.3);">
            </span>
            @endforeach
        </div>

        <!-- Slide counter -->
        <div style="position:absolute;top:16px;right:20px;z-index:30;background:rgba(0,0,0,.35);color:#fff;font-size:11px;font-weight:700;padding:4px 10px;border-radius:20px;backdrop-filter:blur(4px);" id="hero-counter">
            1 / {{ count($heroBanners) }}
        </div>
    </div>

    <!-- Hero Slider JS -->
    <script>
    (function () {
        var slides    = document.querySelectorAll('.hero-slide');
        var dots      = document.querySelectorAll('.hero-dot');
        var counter   = document.getElementById('hero-counter');
        var total     = slides.length;
        var current   = 0;
        var autoTimer = null;

        function goTo(idx) {
            if (idx < 0) idx = total - 1;
            if (idx >= total) idx = 0;

            // Hide all
            slides.forEach(function (s) {
                s.style.opacity = '0';
                s.style.zIndex  = '1';
            });
            dots.forEach(function (d) {
                d.style.width      = '10px';
                d.style.background = 'rgba(255,255,255,0.45)';
            });

            // Show active
            slides[idx].style.opacity = '1';
            slides[idx].style.zIndex  = '2';
            dots[idx].style.width     = '28px';
            dots[idx].style.background = 'rgba(255,255,255,1)';

            if (counter) counter.textContent = (idx + 1) + ' / ' + total;
            current = idx;
        }

        function startAuto() {
            stopAuto();
            autoTimer = setInterval(function () { goTo(current + 1); }, 5000);
        }
        function stopAuto() {
            if (autoTimer) { clearInterval(autoTimer); autoTimer = null; }
        }

        document.getElementById('hero-prev').addEventListener('click', function () {
            goTo(current - 1); stopAuto(); startAuto();
        });
        document.getElementById('hero-next').addEventListener('click', function () {
            goTo(current + 1); stopAuto(); startAuto();
        });
        dots.forEach(function (d) {
            d.addEventListener('click', function () {
                goTo(parseInt(d.getAttribute('data-index')));
                stopAuto(); startAuto();
            });
        });

        // Touch swipe support
        var txStart = 0;
        var slider = document.getElementById('hero-slider');
        slider.addEventListener('touchstart', function (e) { txStart = e.changedTouches[0].screenX; }, { passive: true });
        slider.addEventListener('touchend', function (e) {
            var diff = txStart - e.changedTouches[0].screenX;
            if (Math.abs(diff) > 50) { goTo(diff > 0 ? current + 1 : current - 1); stopAuto(); startAuto(); }
        }, { passive: true });

        startAuto();
    })();
    </script>
    <!-- === End Hero Banner Slider === -->

    <!-- Z DEMO Categories Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Category Card 1 (Orange Theme) -->
        <div class="bg-amber-50/70 border border-amber-100 rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition duration-300">
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-amber-900">Rau, củ, trái cây</h3>
                <ul class="space-y-2 text-sm text-amber-800/80">
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-amber-600 align-middle"></i>Rau xanh, Rau tươi</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-amber-600 align-middle"></i>Củ, quả, măng tươi</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-amber-600 align-middle"></i>Hành, tỏi, ớt, rau thơm</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-amber-600 align-middle"></i>Nấm các loại</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-amber-600 align-middle"></i>Combo rau củ quả</li>
                </ul>
            </div>
            <div class="mt-6">
                <a href="#featured-products" class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-full text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition">
                    Mua sắm ngay
                </a>
            </div>
        </div>

        <!-- Category Card 2 (Blue Theme) -->
        <div class="bg-blue-50/70 border border-blue-100 rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition duration-300">
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-blue-900">Trái cây nhiệt đới</h3>
                <ul class="space-y-2 text-sm text-blue-800/80">
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-blue-600 align-middle"></i>Bưởi da xanh</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-blue-600 align-middle"></i>Cam sành, quýt đường</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-blue-600 align-middle"></i>Dưa hấu Long An</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-blue-600 align-middle"></i>Xoài cát Hòa Lộc</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-blue-600 align-middle"></i>Trái cây đóng hộp</li>
                </ul>
            </div>
            <div class="mt-6">
                <a href="#featured-products" class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-full text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition">
                    Mua sắm ngay
                </a>
            </div>
        </div>

        <!-- Category Card 3 (Pink Theme) -->
        <div class="bg-pink-50/70 border border-pink-100 rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition duration-300">
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-pink-900">Gia vị & Hương liệu</h3>
                <ul class="space-y-2 text-sm text-pink-800/80">
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-pink-600 align-middle"></i>Tiêu đen, tiêu sọ</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-pink-600 align-middle"></i>Ớt bột, bột nghệ</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-pink-600 align-middle"></i>Hạt nêm hữu cơ</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-pink-600 align-middle"></i>Dầu hào, nước tương</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-pink-600 align-middle"></i>Gia vị lẩu thái</li>
                </ul>
            </div>
            <div class="mt-6">
                <a href="#featured-products" class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-full text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition">
                    Mua sắm ngay
                </a>
            </div>
        </div>

        <!-- Category Card 4 (Green Theme) -->
        <div class="bg-emerald-50/70 border border-emerald-100 rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition duration-300">
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-emerald-900">Nước ép & Đồ uống</h3>
                <ul class="space-y-2 text-sm text-emerald-800/80">
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-emerald-600 align-middle"></i>Nước ép cam nguyên chất</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-emerald-600 align-middle"></i>Nước dừa tươi đóng chai</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-emerald-600 align-middle"></i>Trà xanh thảo mộc</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-emerald-600 align-middle"></i>Nước ép rau củ detox</li>
                    <li><i class="fa-solid fa-circle text-[6px] mr-2 text-emerald-600 align-middle"></i>Sữa hạt óc chó</li>
                </ul>
            </div>
            <div class="mt-6">
                <a href="#featured-products" class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-full text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition">
                    Mua sắm ngay
                </a>
            </div>
        </div>

    </div>

    <!-- Z DEMO Flash Sale Section -->
    <div class="bg-rose-600 rounded-3xl p-6 text-white space-y-6 shadow-lg shadow-rose-100">
        <!-- Sale Header -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="space-y-1 text-center sm:text-left">
                <h2 class="text-2xl font-black tracking-tight uppercase flex items-center justify-center sm:justify-start">
                    <i class="fa-solid fa-fire text-yellow-300 mr-2 animate-bounce"></i> Săn Sale đón lễ
                </h2>
                <p class="text-xs text-rose-100">Hàng ngàn sản phẩm giảm giá diễn ra từ ngày 30/4 đến 30/6</p>
            </div>
            
            <!-- Countdown Timer -->
            <div class="flex items-center space-x-3 bg-rose-700/60 px-4 py-2 rounded-2xl border border-rose-500/30">
                <span class="text-xs font-bold text-rose-200">Kết thúc sau</span>
                <div class="flex items-center space-x-1">
                    <div id="hours-box" class="w-8 h-8 rounded-lg bg-yellow-400 text-slate-900 font-extrabold flex items-center justify-center text-sm shadow-sm">00</div>
                    <span class="text-yellow-400 font-bold">:</span>
                    <div id="minutes-box" class="w-8 h-8 rounded-lg bg-yellow-400 text-slate-900 font-extrabold flex items-center justify-center text-sm shadow-sm">00</div>
                    <span class="text-yellow-400 font-bold">:</span>
                    <div id="seconds-box" class="w-8 h-8 rounded-lg bg-yellow-400 text-slate-900 font-extrabold flex items-center justify-center text-sm shadow-sm">00</div>
                </div>
            </div>
        </div>

        <!-- Sale Products Grid -->
        @if(empty($saleProducts))
        <div class="text-center py-8 bg-white/10 rounded-2xl text-rose-100">
            Các sản phẩm sale đã được bán hết hoặc bị xóa!
        </div>
        @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($saleProducts as $saleProd)
            <div class="bg-white rounded-2xl overflow-hidden p-3 text-slate-800 flex flex-col justify-between relative group hover:shadow-md transition">
                <!-- Sale Badge -->
                <span class="absolute top-2.5 right-2.5 bg-emerald-500 text-white font-extrabold text-[10px] px-2 py-0.5 rounded-full z-10">
                    {{ $saleProd['discount_percent'] }}%
                </span>
                
                <!-- Delete Badge -->
                <a href="{{ BASE_URL }}/product/{{ $saleProd['id'] }}/delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm sale này không?')" class="absolute top-2.5 left-2.5 bg-rose-500 hover:bg-rose-600 text-white p-1.5 rounded-full z-10 opacity-0 group-hover:opacity-100 transition duration-200 text-[10px]">
                    <i class="fa-solid fa-trash-can"></i>
                </a>

                <!-- Product Image -->
                <div class="aspect-square w-full rounded-xl overflow-hidden bg-slate-50 relative">
                    <img src="{{ $saleProd['image'] }}" alt="{{ $saleProd['name'] }}" class="h-full w-full object-cover">
                </div>

                <!-- Product Details -->
                <div class="mt-3 flex flex-col flex-grow">
                    <span class="text-[10px] text-slate-400 uppercase font-semibold">Thịt các loại</span>
                    <h4 class="text-xs font-bold text-slate-900 mt-1 line-clamp-2 hover:text-emerald-600 transition flex-grow">
                        <a href="{{ BASE_URL }}/product/{{ $saleProd['id'] }}">
                            {{ $saleProd['name'] }}
                        </a>
                    </h4>
                    
                    <!-- Prices -->
                    <div class="mt-3 flex flex-col">
                        <span class="text-xs font-black text-rose-600">
                            {{ number_format($saleProd['price'], 0, ',', '.') }}đ
                        </span>
                        @if($saleProd['original_price'])
                        <span class="text-[10px] text-slate-400 line-through">
                            {{ number_format($saleProd['original_price'], 0, ',', '.') }}đ
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Action button -->
                <div class="mt-3 pt-2 border-t border-slate-50 flex items-center justify-between">
                    <a href="{{ BASE_URL }}/product/{{ $saleProd['id'] }}" class="text-[10px] font-semibold text-emerald-600 hover:underline">Chi tiết</a>
                    <button class="add-to-cart-btn w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition shadow-sm"
                            data-id="{{ $saleProd['id'] }}"
                            data-name="{{ $saleProd['name'] }}"
                            data-price="{{ $saleProd['price'] }}"
                            data-image="{{ $saleProd['image'] }}">
                        <i class="fa-solid fa-plus text-xs"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- JavaScript for Dynamic Countdown Timer -->
    <script>
        (function() {
            function updateTimer() {
                var now = new Date();
                var hours = 23 - now.getHours();
                var minutes = 59 - now.getMinutes();
                var seconds = 59 - now.getSeconds();
                
                var hBox = document.getElementById('hours-box');
                var mBox = document.getElementById('minutes-box');
                var sBox = document.getElementById('seconds-box');
                
                if (hBox && mBox && sBox) {
                    hBox.innerText = hours < 10 ? '0' + hours : hours;
                    mBox.innerText = minutes < 10 ? '0' + minutes : minutes;
                    sBox.innerText = seconds < 10 ? '0' + seconds : seconds;
                }
            }
            updateTimer();
            setInterval(updateTimer, 1000);
        })();
    </script>

    <!-- Z DEMO Featured Brands Section -->
    <div class="space-y-6">
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Thương hiệu nổi bật</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
            
            <!-- Left Banner: THƯƠNG HIỆU CHÍNH HÃNG -->
            <div class="bg-gradient-to-br from-rose-500 to-red-600 rounded-3xl p-6 text-white flex flex-col justify-between shadow-lg shadow-red-100 min-h-[300px]">
                <div class="space-y-6">
                    <div class="inline-block bg-white/20 backdrop-blur-sm px-3.5 py-1 rounded-full text-xs font-bold uppercase">
                        Gian hàng uy tín
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-3xl font-black tracking-tight leading-none">THƯƠNG HIỆU<br>CHÍNH HÃNG</h3>
                        <div class="h-1 w-16 bg-white/60 rounded-full mt-3"></div>
                    </div>
                    <ul class="space-y-2 text-sm text-red-50">
                        <li><i class="fa-solid fa-circle-check mr-2 text-yellow-300"></i>100% Sản phẩm chính hãng</li>
                        <li><i class="fa-solid fa-circle-check mr-2 text-yellow-300"></i>Hoàn tiền 200% nếu giả mạo</li>
                        <li><i class="fa-solid fa-circle-check mr-2 text-yellow-300"></i>Được kiểm tra trước khi nhận</li>
                    </ul>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-xs text-red-100 font-medium">TechShop & Z DEMO Coop</span>
                    <i class="fa-solid fa-award text-3xl text-yellow-300"></i>
                </div>
            </div>

            <!-- Right Grid: Brand Logos (3x3 grid) -->
            <div class="lg:col-span-2 grid grid-cols-3 gap-4">
                
                <!-- Vinamilk -->
                <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-center justify-center hover:shadow-md transition">
                    <div class="text-center">
                        <span class="inline-block px-4 py-2 bg-blue-600 rounded-full text-white text-xs font-extrabold italic tracking-wider shadow-sm">VINAMILK</span>
                        <p class="text-[9px] text-slate-400 mt-1 font-semibold">Thương hiệu sữa Việt</p>
                    </div>
                </div>

                <!-- TH True Milk -->
                <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-center justify-center hover:shadow-md transition">
                    <div class="text-center">
                        <span class="text-sky-500 font-extrabold text-sm flex items-center justify-center">
                            TH<span class="text-emerald-500 text-xs ml-0.5"><i class="fa-solid fa-leaf"></i></span> true MILK
                        </span>
                        <p class="text-[9px] text-slate-400 mt-1 font-semibold">Thật sự thiên nhiên</p>
                    </div>
                </div>

                <!-- Nestle -->
                <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-center justify-center hover:shadow-md transition">
                    <div class="text-center">
                        <span class="text-blue-800 font-black text-sm tracking-wide"><i class="fa-solid fa-dove mr-1"></i>Nestlé</span>
                        <p class="text-[9px] text-slate-400 mt-1 font-semibold">Good food, Good life</p>
                    </div>
                </div>

                <!-- Wall's -->
                <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-center justify-center hover:shadow-md transition">
                    <div class="text-center">
                        <span class="text-red-500 font-black text-sm"><i class="fa-solid fa-heart mr-1"></i>WALL\'S</span>
                        <p class="text-[9px] text-slate-400 mt-1 font-semibold">Kem ngon sảng khoái</p>
                    </div>
                </div>

                <!-- Cornetto -->
                <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-center justify-center hover:shadow-md transition">
                    <div class="text-center">
                        <span class="text-slate-800 font-extrabold italic text-sm font-serif">Cornetto</span>
                        <p class="text-[9px] text-slate-400 mt-1 font-semibold">Kem ốc quế tình yêu</p>
                    </div>
                </div>

                <!-- Merino -->
                <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-center justify-center hover:shadow-md transition">
                    <div class="text-center">
                        <span class="text-red-600 font-extrabold text-sm tracking-widest uppercase">Merino</span>
                        <p class="text-[9px] text-slate-400 mt-1 font-semibold">Dzui bất tận</p>
                    </div>
                </div>

                <!-- Celano -->
                <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-center justify-center hover:shadow-md transition">
                    <div class="text-center">
                        <span class="text-slate-900 font-bold italic text-sm tracking-wider">Celano</span>
                        <p class="text-[9px] text-slate-400 mt-1 font-semibold">Kem cao cấp</p>
                    </div>
                </div>

                <!-- Hảo Hảo -->
                <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-center justify-center hover:shadow-md transition">
                    <div class="text-center text-red-600 font-extrabold italic text-sm leading-none">
                        <span>Hảo Hảo</span>
                        <p class="text-[9px] text-slate-400 mt-1.5 font-normal">Mì ăn liền quốc dân</p>
                    </div>
                </div>

                <!-- Gấu Đỏ -->
                <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-center justify-center hover:shadow-md transition">
                    <div class="text-center text-red-500 font-bold text-xs flex flex-col items-center leading-none">
                        <span class="bg-red-500 text-white rounded px-1 text-[10px] font-black mb-0.5">GẤU ĐỎ</span>
                        <p class="text-[9px] text-slate-400 mt-1 font-semibold">Năng lượng tràn đầy</p>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- THỊT, CÁ, TRỨNG RAU SECTION (DYNAMIC TABS & DOUBLE BANNER) -->
    <div class="space-y-6 pt-6 bg-slate-100/50 rounded-3xl p-6 border border-slate-200/40">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between border-b border-slate-200/60 pb-4 gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight uppercase flex items-center">
                    <span class="bg-emerald-600 text-white rounded-lg p-1.5 mr-2.5 text-xs"><i class="fa-solid fa-drumstick-bite"></i></span>
                    Thịt, Cá, Trứng Rau
                </h2>
                <p class="text-xs text-slate-500 mt-1">Dữ liệu tươi ngon mỗi ngày từ nhà cung cấp uy tín</p>
            </div>
            
            <!-- Category Tabs -->
            <div class="flex flex-wrap gap-2 text-xs font-bold text-slate-600">
                <button onclick="switchCategoryTab('thit_ca_trung_rau')" id="btn-tab-thit_ca_trung_rau" class="cat-tab-btn px-4 py-2.5 bg-slate-200 text-slate-800 rounded-xl transition duration-200 shadow-sm">
                    Thịt cá trứng rau
                </button>
                <button onclick="switchCategoryTab('dong_mat')" id="btn-tab-dong_mat" class="cat-tab-btn px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition duration-200 shadow-sm">
                    Hàng đông mát
                </button>
                <button onclick="switchCategoryTab('mi_lien')" id="btn-tab-mi_lien" class="cat-tab-btn px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition duration-200 shadow-sm">
                    Mì, miến, cháo, phở
                </button>
                <button onclick="switchCategoryTab('gao_bot')" id="btn-tab-gao_bot" class="cat-tab-btn px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition duration-200 shadow-sm">
                    Gạo, bột, đồ khô
                </button>
            </div>
        </div>

        <!-- Product Grid for the section -->
        <div id="cat-products-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            <!-- Products will be dynamically populated/filtered here by Javascript -->
        </div>
        
        <!-- Double Promo Banners -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
            <!-- Banner 1: Ngon Chào Hè -->
            <div class="rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                <img src="{{ BASE_URL }}/uploads/banner_summer_deal.png" alt="Ngon Chào Hè - Triệu Deal Hot" class="w-full h-auto object-cover">
            </div>
            <!-- Banner 2: Bách Hóa Tại Gia -->
            <div class="rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                <img src="{{ BASE_URL }}/uploads/banner_grocery_home.png" alt="Bách Hóa Tại Gia - Giảm Đến 40%" class="w-full h-auto object-cover">
            </div>
        </div>
    </div>

    <!-- JavaScript for Client-Side Filtering -->
    <script>
        (function() {
            // Danh mục sản phẩm từ CSDL (gộp cả sản phẩm thường và sản phẩm sale)
            const productsList = {!! json_encode(array_merge($products, $saleProducts)) !!};
            const baseUrl = "{{ BASE_URL }}";

            // Map key danh mục sang tên tiếng Việt
            const categoryLabels = {
                'dong_mat': 'Hàng đông mát',
                'thit_ca': 'Thịt các loại',
                'rau_cu': 'Rau củ sạch',
                'trai_cay': 'Trái cây sạch',
                'nam': 'Nấm các loại',
                'mi_lien': 'Mì & phở ăn liền',
                'gao_bot': 'Gạo & bột khô'
            };

            window.switchCategoryTab = function(categoryKey) {
                // Cập nhật trạng thái các nút tab
                const tabs = ['thit_ca_trung_rau', 'dong_mat', 'mi_lien', 'gao_bot'];
                tabs.forEach(function(key) {
                    const btn = document.getElementById('btn-tab-' + key);
                    if (btn) {
                        if (key === categoryKey) {
                            btn.className = "cat-tab-btn px-4 py-2.5 bg-slate-200 text-slate-800 rounded-xl transition duration-200 shadow-sm";
                        } else {
                            btn.className = "cat-tab-btn px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition duration-200 shadow-sm";
                        }
                    }
                });

                // Lọc sản phẩm
                let filtered = [];
                if (categoryKey === 'thit_ca_trung_rau') {
                    // Hiển thị thịt, cá, rau củ, nấm
                    filtered = productsList.filter(function(p) {
                        return p.category === 'thit_ca' || p.category === 'rau_cu' || p.category === 'nam';
                    });
                } else {
                    // Lọc theo danh mục cụ thể
                    filtered = productsList.filter(function(p) {
                        return p.category === categoryKey;
                    });
                }

                // Render lưới sản phẩm
                const grid = document.getElementById('cat-products-grid');
                if (!grid) return;

                if (filtered.length === 0) {
                    grid.className = "block py-12 text-center bg-white rounded-2xl border border-slate-100 text-slate-400";
                    grid.innerHTML = `<i class="fa-solid fa-basket-shopping text-3xl mb-2 text-slate-300"></i><p class="text-sm">Hiện chưa có sản phẩm nào trong mục này.</p>`;
                    return;
                }

                grid.className = "grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4";
                let html = '';
                filtered.forEach(function(p) {
                    const priceFormatted = new Intl.NumberFormat('vi-VN').format(p.price) + 'đ';
                    const originalPriceFormatted = p.original_price ? new Intl.NumberFormat('vi-VN').format(p.original_price) + 'đ' : '';
                    const hasDiscount = p.discount_percent && p.discount_percent > 0;
                    
                    const label = categoryLabels[p.category] || 'Nông sản sạch';
                    
                    html += `
                    <div class="bg-white rounded-2xl overflow-hidden p-3.5 border border-slate-100 text-slate-800 flex flex-col justify-between relative group hover:shadow-md transition duration-300">
                        <!-- Discount Badge -->
                        ${hasDiscount ? `
                        <span class="absolute top-2.5 right-2.5 bg-emerald-500 text-white font-extrabold text-[10px] px-2 py-0.5 rounded-full z-10">
                            ${p.discount_percent}%
                        </span>
                        ` : ''}
                        
                        <!-- Delete Button (Admin) -->
                        <a href="${baseUrl}/product/${p.id}/delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')" class="absolute top-2.5 left-2.5 bg-rose-500 hover:bg-rose-600 text-white p-1.5 rounded-full z-10 opacity-0 group-hover:opacity-100 transition duration-200 text-[10px]">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>

                        <!-- Product Image -->
                        <div class="aspect-square w-full rounded-xl overflow-hidden bg-slate-50 relative">
                            <img src="${p.image}" alt="${p.name}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
                        </div>

                        <!-- Product Details -->
                        <div class="mt-3 flex flex-col flex-grow">
                            <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">${label}</span>
                            <h4 class="text-xs font-bold text-slate-900 mt-1 line-clamp-2 hover:text-emerald-600 transition flex-grow">
                                <a href="${baseUrl}/product/${p.id}">
                                    ${p.name}
                                </a>
                            </h4>
                            
                            <!-- Prices -->
                            <div class="mt-3 flex flex-col">
                                <span class="text-xs font-black text-rose-600">
                                    ${priceFormatted}
                                </span>
                                ${hasDiscount ? `
                                <span class="text-[10px] text-slate-400 line-through">
                                    ${originalPriceFormatted}
                                </span>
                                ` : ''}
                            </div>
                        </div>

                        <!-- Action button -->
                        <div class="mt-3 pt-2 border-t border-slate-50 flex items-center justify-between">
                            <a href="${baseUrl}/product/${p.id}" class="text-[10px] font-bold text-emerald-600 hover:underline">Chi tiết</a>
                            <button class="add-to-cart-btn w-7 h-7 rounded-full border border-emerald-200 text-emerald-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition shadow-sm"
                                    data-id="${p.id}"
                                    data-name="${p.name}"
                                    data-price="${p.price}"
                                    data-image="${p.image}">
                                <i class="fa-solid fa-plus text-xs"></i>
                            </button>
                        </div>
                    </div>
                    `;
                });
                grid.innerHTML = html;
            };

            // Khởi tạo tab đầu tiên khi tải trang xong hoặc gọi trực tiếp
            window.switchCategoryTab('thit_ca_trung_rau');
            document.addEventListener("DOMContentLoaded", function() {
                window.switchCategoryTab('thit_ca_trung_rau');
            });
        })();
    </script>

    <!-- SỮA CÁC LOẠI SECTION (VERTICAL BANNER & HORIZONTAL CARDS) -->
    <div class="space-y-6 pt-6">
        <div class="flex items-center justify-between border-b border-emerald-500 pb-2">
            <h2 class="text-xl font-bold text-emerald-800 tracking-tight uppercase flex items-center">
                Sữa các loại
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-stretch">
            
            <!-- Left Banner Ad (Red Vertical Banner) -->
            <div class="lg:col-span-1 rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                <img src="{{ BASE_URL }}/uploads/banner_milk_discount.png" alt="Nhập NGONGIAM40K Giảm 40K" class="w-full h-full object-cover">
            </div>

            <!-- Right Product Grid (Horizontal Cards) -->
            <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4" id="milk-products-grid">
                <!-- Products will be dynamically populated here by Javascript -->
            </div>
            
        </div>
    </div>

    <!-- JavaScript for Sữa Các Loại Grid -->
    <script>
        (function() {
            // Load products from DB
            const productsList = {!! json_encode(array_merge($products, $saleProducts)) !!};
            const baseUrl = "{{ BASE_URL }}";

            // Lọc ra các sản phẩm thuộc category thit_ca và dong_mat (giống screenshot của bạn)
            const milkSectionProds = productsList.filter(function(p) {
                return p.category === 'thit_ca' || p.category === 'dong_mat';
            }).slice(0, 9); // Lấy tối đa 9 sản phẩm để lấp đầy lưới 3x3

            const grid = document.getElementById('milk-products-grid');
            if (grid) {
                let html = '';
                milkSectionProds.forEach(function(p) {
                    const priceFormatted = new Intl.NumberFormat('vi-VN').format(p.price) + 'đ';
                    const originalPriceFormatted = p.original_price ? new Intl.NumberFormat('vi-VN').format(p.original_price) + 'đ' : '';
                    const hasDiscount = p.discount_percent && p.discount_percent > 0;
                    
                    // Đối với Sườn heo C.P khay 500g, hiển thị khoảng giá 79.000đ - 83.000đ cho giống screenshot
                    let displayPrice = priceFormatted;
                    if (p.name.includes('Sườn già heo C.P')) {
                        displayPrice = '79.000đ – 83.000đ';
                    }

                    html += `
                    <div class="bg-white border border-slate-100 rounded-2xl p-3 flex gap-4 hover:shadow-md transition duration-300 relative group">
                        
                        <!-- Delete Button (Admin) -->
                        <a href="${baseUrl}/product/${p.id}/delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')" class="absolute top-1.5 left-1.5 bg-rose-500 hover:bg-rose-600 text-white p-1 rounded-full z-20 opacity-0 group-hover:opacity-100 transition duration-200 text-[8px]">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>

                        <!-- Left side: Image -->
                        <div class="w-20 h-20 rounded-xl overflow-hidden bg-slate-50 relative flex-shrink-0">
                            <!-- Discount Badge -->
                            ${hasDiscount ? `
                            <span class="absolute top-1 left-1 bg-emerald-500 text-white font-extrabold text-[8px] px-1.5 py-0.5 rounded-full z-10">
                                ${p.discount_percent}%
                            </span>
                            ` : ''}
                            <img src="${p.image}" alt="${p.name}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>

                        <!-- Right side: Content -->
                        <div class="flex flex-col justify-between flex-grow min-w-0">
                            <h4 class="text-xs font-bold text-slate-800 line-clamp-2 hover:text-emerald-600 transition">
                                <a href="${baseUrl}/product/${p.id}">
                                    ${p.name}
                                </a>
                            </h4>
                            
                            <div class="mt-1 flex flex-col">
                                <span class="text-xs font-black text-emerald-600">
                                    ${displayPrice}
                                </span>
                                ${hasDiscount && !p.name.includes('Sườn già heo C.P') ? `
                                <span class="text-[9px] text-slate-400 line-through">
                                    ${originalPriceFormatted}
                                </span>
                                ` : ''}
                            </div>
                        </div>

                    </div>
                    `;
                });
                grid.innerHTML = html;
            }
        })();
    </script>

    <!-- THỦY HẢI SẢN SECTION (VERTICAL BANNER ON RIGHT & HORIZONTAL CARDS ON LEFT) -->
    <div class="space-y-6 pt-6">
        <div class="flex items-center justify-between border-b border-emerald-500 pb-2">
            <h2 class="text-xl font-bold text-emerald-800 tracking-tight uppercase flex items-center">
                Thủy Hải Sản
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-stretch">
            
            <!-- Left Product Grid (Horizontal Cards) - 3/4 Width -->
            <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4" id="seafood-products-grid">
                <!-- Products will be dynamically populated here by Javascript -->
            </div>

            <!-- Right Banner Ad (Red Vertical Banner) - 1/4 Width -->
            <div class="lg:col-span-1 rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                <img src="{{ BASE_URL }}/uploads/banner_milk_discount.png" alt="Nhập NGONGIAM40K Giảm 40K" class="w-full h-full object-cover">
            </div>
            
        </div>
    </div>

    <!-- JavaScript for Thủy Hải Sản Grid -->
    <script>
        (function() {
            // Load products from DB
            const productsList = {!! json_encode(array_merge($products, $saleProducts)) !!};
            const baseUrl = "{{ BASE_URL }}";

            // Lọc ra các sản phẩm thuộc category thit_ca và dong_mat (giống screenshot của bạn)
            const seafoodSectionProds = productsList.filter(function(p) {
                return p.category === 'thit_ca' || p.category === 'dong_mat';
            }).slice(0, 8); // Lấy tối đa 8 sản phẩm theo đúng số lượng trong screenshot của bạn

            const grid = document.getElementById('seafood-products-grid');
            if (grid) {
                let html = '';
                seafoodSectionProds.forEach(function(p) {
                    const priceFormatted = new Intl.NumberFormat('vi-VN').format(p.price) + 'đ';
                    const originalPriceFormatted = p.original_price ? new Intl.NumberFormat('vi-VN').format(p.original_price) + 'đ' : '';
                    const hasDiscount = p.discount_percent && p.discount_percent > 0;
                    
                    // Đối với Sườn heo C.P khay 500g, hiển thị khoảng giá 79.000đ - 83.000đ cho giống screenshot
                    let displayPrice = priceFormatted;
                    if (p.name.includes('Sườn già heo C.P')) {
                        displayPrice = '79.000đ – 83.000đ';
                    }

                    html += `
                    <div class="bg-white border border-slate-100 rounded-2xl p-3 flex gap-4 hover:shadow-md transition duration-300 relative group">
                        
                        <!-- Delete Button (Admin) -->
                        <a href="${baseUrl}/product/${p.id}/delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')" class="absolute top-1.5 left-1.5 bg-rose-500 hover:bg-rose-600 text-white p-1 rounded-full z-20 opacity-0 group-hover:opacity-100 transition duration-200 text-[8px]">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>

                        <!-- Left side: Image -->
                        <div class="w-20 h-20 rounded-xl overflow-hidden bg-slate-50 relative flex-shrink-0">
                            <!-- Discount Badge -->
                            ${hasDiscount ? `
                            <span class="absolute top-1 left-1 bg-emerald-500 text-white font-extrabold text-[8px] px-1.5 py-0.5 rounded-full z-10">
                                ${p.discount_percent}%
                            </span>
                            ` : ''}
                            <img src="${p.image}" alt="${p.name}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>

                        <!-- Right side: Content -->
                        <div class="flex flex-col justify-between flex-grow min-w-0">
                            <h4 class="text-xs font-bold text-slate-800 line-clamp-2 hover:text-emerald-600 transition">
                                <a href="${baseUrl}/product/${p.id}">
                                    ${p.name}
                                </a>
                            </h4>
                            
                            <div class="mt-1 flex flex-col">
                                <span class="text-xs font-black text-emerald-600">
                                    ${displayPrice}
                                </span>
                                ${hasDiscount && !p.name.includes('Sườn già heo C.P') ? `
                                <span class="text-[9px] text-slate-400 line-through">
                                    ${originalPriceFormatted}
                                </span>
                                ` : ''}
                            </div>
                        </div>

                    </div>
                    `;
                });
                grid.innerHTML = html;
            }
        })();
    </script>

    <!-- MÓN NGON MỖI NGÀY SECTION (GRID OF 4 ARTICLES) -->
    <div class="space-y-6 pt-6">
        <div class="flex items-center justify-between border-b border-emerald-500 pb-2">
            <h2 class="text-xl font-bold text-emerald-800 tracking-tight uppercase flex items-center">
                Món ngon mỗi ngày
            </h2>
        </div>

        @if(empty($articles))
        <div class="text-center py-12 bg-white rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="w-12 h-12 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto text-2xl">
                <i class="fa-regular fa-newspaper"></i>
            </div>
            <p class="text-sm text-slate-400">Không có bài viết nào.</p>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($articles as $article)
            <div class="flex flex-col space-y-3 group cursor-pointer">
                <!-- Article Image -->
                <div class="aspect-video w-full rounded-2xl overflow-hidden bg-slate-50 relative border border-slate-100 shadow-xs">
                    <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                
                <!-- Article Content -->
                <div class="space-y-1.5">
                    <h3 class="text-xs font-bold text-slate-900 group-hover:text-emerald-600 transition leading-snug line-clamp-2">
                        {{ $article['title'] }}
                    </h3>
                    <p class="text-[10px] text-slate-500 line-clamp-2 leading-relaxed">
                        {{ $article['description'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Z DEMO Products Section -->
    <div id="featured-products" class="space-y-8 pt-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Sản phẩm nổi bật</h2>
                <p class="text-sm text-slate-500 mt-1">Đảm bảo tươi sạch, an toàn cho sức khỏe gia đình bạn.</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Trực tiếp từ nông trại</span>
            </div>
        </div>

        @if(empty($products))
        <div class="text-center py-16 bg-white rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto text-3xl">
                <i class="fa-solid fa-basket-shopping"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Danh sách trống</h3>
            <p class="text-sm text-slate-400 max-w-xs mx-auto">Tất cả sản phẩm đã bị xóa. Hãy tải lại trang hoặc tạo lại database để hiển thị lại dữ liệu mẫu.</p>
        </div>
        @else
        <!-- Products Grid - Multi-Image Slider Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $product)
            @php
                $pImages = isset($product['images']) && is_array($product['images']) && count($product['images']) > 0
                    ? $product['images']
                    : [$product['image'] ?? 'uploads/product_hero_showcase.jpg'];
                $pImgCount  = count($pImages);
                $pImgsJson  = json_encode(array_map(function($img) {
                    return preg_match('/^https?:\/\//i', $img) ? $img : BASE_URL . '/' . $img;
                }, $pImages), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                $pFirstImg  = preg_match('/^https?:\/\//i', $pImages[0]) ? $pImages[0] : BASE_URL . '/' . $pImages[0];
                $catLabels  = ['rau_cu'=>'Rau củ sạch','trai_cay'=>'Trái cây','nam'=>'Nấm tươi','thit_ca'=>'Thịt & Cá','dong_mat'=>'Đồ khô','mi_lien'=>'Mì & Phở','gao_bot'=>'Gạo & Bột'];
                $catLabel   = $catLabels[$product['category']] ?? 'Nông sản';
            @endphp
            <div class="product-card bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-slate-100 transition duration-300 flex flex-col h-full group"
                 data-id="{{ $product['id'] }}">

                <!-- Mini Image Slider -->
                <div class="relative aspect-video w-full overflow-hidden bg-slate-50 product-slider" data-images='{{ $pImgsJson }}' data-count="{{ $pImgCount }}">

                    <!-- Ảnh chính -->
                    <img class="slider-main-img absolute inset-0 w-full h-full object-cover transition-all duration-500 group-hover:scale-105"
                         src="{{ $pFirstImg }}" alt="{{ $product['name'] }}">

                    <!-- Overlay gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/20 to-transparent pointer-events-none"></div>

                    <!-- Category badge -->
                    <div class="absolute top-3 left-3 bg-emerald-600/90 backdrop-blur-sm px-2.5 py-1 rounded-full text-[10px] font-bold text-white shadow-sm z-10">
                        {{ $catLabel }}
                    </div>

                    <!-- Discount badge -->
                    @if(!empty($product['discount_percent']) && $product['discount_percent'] > 0)
                    <div class="absolute top-3 right-3 bg-rose-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full shadow z-10">
                        -{{ $product['discount_percent'] }}%
                    </div>
                    @endif

                    @if($pImgCount > 1)
                    <!-- Prev / Next — plain CSS buttons, not Tailwind opacity tricks -->
                    <button class="card-nav-btn card-nav-prev slider-prev" type="button">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button class="card-nav-btn card-nav-next slider-next" type="button">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <!-- Dot indicators — use plain 'active' class, not Tailwind /opacity -->
                    <div class="slider-dots absolute bottom-2 left-0 right-0 flex justify-center gap-1.5 z-10">
                        @for($di = 0; $di < $pImgCount; $di++)
                        <span class="slider-dot {{ $di === 0 ? 'active' : '' }}" data-index="{{ $di }}"></span>
                        @endfor
                    </div>

                    <!-- Image count badge -->
                    <div class="absolute bottom-2 right-3 text-[9px] font-bold text-white z-10 slider-counter" style="text-shadow:0 1px 3px rgba(0,0,0,.5);">
                        1/{{ $pImgCount }}
                    </div>
                    @endif
                </div>

                <!-- Thumbnail strip (chỉ hiện khi có nhiều ảnh) -->
                @if($pImgCount > 1)
                <div class="flex gap-1.5 px-3 pt-2 overflow-x-auto slider-thumbs">
                    @foreach($pImages as $ti => $tImg)
                    @php $tUrl = preg_match('/^https?:\/\//i', $tImg) ? $tImg : BASE_URL . '/' . $tImg; @endphp
                    <div class="slider-thumb flex-shrink-0 w-10 h-10 rounded-lg overflow-hidden border-2 {{ $ti === 0 ? 'border-emerald-500' : 'border-transparent' }} cursor-pointer hover:border-emerald-400 transition duration-150" data-index="{{ $ti }}" data-src="{{ $tUrl }}">
                        <img src="{{ $tUrl }}" alt="" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Info Container -->
                <div class="p-5 flex flex-col flex-grow">
                    <h3 class="text-base font-extrabold text-slate-900 group-hover:text-emerald-600 transition leading-snug">
                        <a href="{{ BASE_URL }}/product/{{ $product['id'] }}">{{ $product['name'] }}</a>
                    </h3>
                    <p class="mt-1.5 text-xs text-slate-500 line-clamp-2 flex-grow leading-relaxed">
                        {{ $product['description'] }}
                    </p>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-lg font-black text-emerald-600">
                                {{ number_format($product['price'], 0, ',', '.') }}đ
                            </span>
                            @if(!empty($product['original_price']))
                            <span class="text-xs text-slate-400 line-through ml-2">{{ number_format($product['original_price'], 0, ',', '.') }}đ</span>
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ BASE_URL }}/product/{{ $product['id'] }}" class="inline-flex items-center justify-center px-3 py-1.5 rounded-xl text-[11px] font-bold text-slate-700 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <i class="fa-solid fa-eye mr-1"></i> Chi tiết
                            </a>
                            <button class="add-to-cart-btn inline-flex items-center justify-center w-8 h-8 rounded-xl text-emerald-600 bg-emerald-50 hover:bg-emerald-600 hover:text-white transition shadow-sm"
                                    data-id="{{ $product['id'] }}"
                                    data-name="{{ $product['name'] }}"
                                    data-price="{{ $product['price'] }}"
                                    data-image="{{ $pImages[0] }}">
                                <i class="fa-solid fa-plus text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- ===== SECTION: KHUYẾN MÃI NỔI BẬT ===== -->
    @if(!empty($promotions))
    <div class="space-y-6 pt-4">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-500 flex items-center justify-center text-sm"><i class="fa-solid fa-fire-flame-curved"></i></span>
                    Ưu Đãi Hấp Dẫn
                </h2>
                <p class="text-sm text-slate-500 mt-1">Chương trình khuyến mãi đặc biệt trong tuần này</p>
            </div>
            <a href="{{ BASE_URL }}/products" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-full transition">
                Xem tất cả <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- Promotion Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($promotions as $promo)
            @php
                $promoImg = !empty($promo['image'])
                    ? (preg_match('/^https?:\/\//i', $promo['image']) ? $promo['image'] : BASE_URL . '/' . $promo['image'])
                    : BASE_URL . '/uploads/news_banner_1.png';
                $badgeColors = [
                    'HOT DEAL'   => 'bg-rose-500',
                    'NEW IN'     => 'bg-blue-500',
                    'SALE 50%'   => 'bg-orange-500',
                    'ORGANIC'    => 'bg-emerald-500',
                    'FLASH SALE' => 'bg-amber-500',
                    'FREESHIP'   => 'bg-purple-500',
                ];
                $badgeColor = $badgeColors[$promo['badge'] ?? ''] ?? 'bg-slate-500';
            @endphp
            <a href="{{ BASE_URL }}{{ $promo['btn_link'] }}"
               class="group relative rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 block"
               style="height: 200px;">
                <!-- Background Image -->
                <img src="{{ $promoImg }}" alt="{{ $promo['title'] }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                     onerror="this.src='{{ BASE_URL }}/uploads/article_1.jpg'">
                <!-- Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/30 to-transparent"></div>
                <!-- Badge -->
                @if(!empty($promo['badge']))
                <span class="absolute top-3 left-3 {{ $badgeColor }} text-white text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-wide shadow">
                    {{ $promo['badge'] }}
                </span>
                @endif
                <!-- Content -->
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <h3 class="text-white font-bold text-sm leading-snug drop-shadow line-clamp-2">{{ $promo['title'] }}</h3>
                    @if(!empty($promo['subtitle']))
                    <p class="text-white/70 text-xs mt-1 line-clamp-1">{{ $promo['subtitle'] }}</p>
                    @endif
                    <span class="mt-2 inline-flex items-center gap-1 text-emerald-300 text-xs font-bold group-hover:text-white transition">
                        {{ $promo['btn_text'] }} <i class="fa-solid fa-arrow-right text-[9px]"></i>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- ===== SECTION: TIN TỨC MỚI NHẤT ===== -->
    @if(!empty($latestArticles))
    <div class="space-y-6 pt-4">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-500 flex items-center justify-center text-sm"><i class="fa-solid fa-newspaper"></i></span>
                    Tin Tức Mới Nhất
                </h2>
                <p class="text-sm text-slate-500 mt-1">Cập nhật kiến thức dinh dưỡng và ẩm thực mỗi ngày</p>
            </div>
            <a href="{{ BASE_URL }}/news" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-full transition">
                Xem tất cả <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- Latest News Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($latestArticles as $latestIdx => $latestArt)
            @php
                $latestImg = !empty($latestArt['image'])
                    ? (preg_match('/^https?:\/\//i', $latestArt['image']) ? $latestArt['image'] : BASE_URL . '/' . $latestArt['image'])
                    : BASE_URL . '/uploads/article_1.jpg';
            @endphp
            <article class="group bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-lg transition duration-300 flex flex-col">
                <!-- Image -->
                <a href="{{ BASE_URL }}/news/{{ $latestArt['id'] }}" class="block overflow-hidden h-44 bg-slate-100 relative">
                    <img src="{{ $latestImg }}" alt="{{ $latestArt['title'] }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                         onerror="this.src='{{ BASE_URL }}/uploads/article_1.jpg'">
                    @if($latestIdx === 0)
                    <span class="absolute top-3 left-3 bg-blue-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full">MỚI NHẤT</span>
                    @endif
                </a>
                <!-- Content -->
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                        <i class="fa-regular fa-calendar text-[10px]"></i>
                        <span>{{ date('d/m/Y', strtotime($latestArt['created_at'])) }}</span>
                        <span class="mx-1">·</span>
                        <i class="fa-regular fa-clock text-[10px]"></i>
                        <span>{{ max(1, ceil(str_word_count($latestArt['description'] ?? '') / 200)) }} phút</span>
                    </div>
                    <h3 class="font-bold text-slate-900 group-hover:text-blue-600 transition leading-snug text-sm mb-2 line-clamp-2">
                        <a href="{{ BASE_URL }}/news/{{ $latestArt['id'] }}">{{ $latestArt['title'] }}</a>
                    </h3>
                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed flex-grow">{{ $latestArt['description'] }}</p>
                    <div class="mt-4 pt-3 border-t border-slate-50">
                        <a href="{{ BASE_URL }}/news/{{ $latestArt['id'] }}"
                           class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-700 transition">
                            Đọc thêm <i class="fa-solid fa-arrow-right text-[9px]"></i>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
    @endif

    <!-- ===== SECTION: ĐÁNH GIÁ KHÁCH HÀNG (TESTIMONIALS) ===== -->
    <div class="bg-gradient-to-br from-emerald-800 via-emerald-700 to-emerald-800 rounded-3xl p-8 md:p-12 shadow-lg mt-6 relative overflow-hidden">
        <!-- Background organic pattern decoration -->
        <div class="absolute -top-12 -left-12 w-48 h-48 rounded-full bg-white/5 pointer-events-none"></div>
        <div class="absolute -bottom-12 -right-12 w-48 h-48 rounded-full bg-white/5 pointer-events-none"></div>
        
        <div class="relative z-10 space-y-8">
            <!-- Header -->
            <div class="text-center">
                <h2 class="text-3xl md:text-4xl font-cursive text-white tracking-wide">Khách Hàng Nói Về chúng tôi</h2>
                <!-- Wavy Underline SVG -->
                <svg class="mx-auto mt-2" width="64" height="12" viewBox="0 0 60 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M 0 6 Q 7.5 12 15 6 T 30 6 T 45 6 T 60 6" stroke="#ffffff" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                </svg>
            </div>

            <!-- Testimonial Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                <!-- Testimonial 1 -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 md:gap-6 bg-emerald-900/20 p-6 rounded-2xl border border-white/5 hover:bg-emerald-900/30 transition duration-300">
                    <img src="{{ BASE_URL }}/uploads/avatar_customer_1.jpg" alt="Mark Jance" class="w-20 h-20 rounded-full border-2 border-white/40 object-cover flex-shrink-0 shadow-md">
                    <div class="space-y-2 text-center sm:text-left flex-grow">
                        <div class="flex justify-center sm:justify-start gap-1">
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                        </div>
                        <p class="text-xs md:text-sm leading-relaxed text-white/90 font-medium italic">
                            "The overall use of flatsome is very VERY useful. It lacks very few, if any, things! I loved it and have created my first ever website Punsteronline.com! Best yet, flatsome gets free updates that are great! (and the support is amazing as well!:)"
                        </p>
                        <div class="text-xs font-bold text-white/80 mt-2">
                            Mark Jance <span class="font-normal text-white/60">/ Facebook</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 md:gap-6 bg-emerald-900/20 p-6 rounded-2xl border border-white/5 hover:bg-emerald-900/30 transition duration-300">
                    <img src="{{ BASE_URL }}/uploads/avatar_customer_2.jpg" alt="Mark Jance" class="w-20 h-20 rounded-full border-2 border-white/40 object-cover flex-shrink-0 shadow-md">
                    <div class="space-y-2 text-center sm:text-left flex-grow">
                        <div class="flex justify-center sm:justify-start gap-1">
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                        </div>
                        <p class="text-xs md:text-sm leading-relaxed text-white/90 font-medium italic">
                            "This is a FANTASTIC Theme. Do you think that in the next version you could try and have it Multilanguage. Because I have nothing bad to say about this theme. Thank a million!"
                        </p>
                        <div class="text-xs font-bold text-white/80 mt-2">
                            Mark Jance <span class="font-normal text-white/60">/ Facebook</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== SECTION: ĐỐI TÁC - KHÁCH HÀNG ===== -->
    <div class="bg-slate-50 border border-slate-100 rounded-3xl p-8 md:p-12 shadow-sm mt-6 relative overflow-hidden">
        <!-- Subtle diagonal background pattern -->
        <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: linear-gradient(45deg, #cbd5e1 25%, transparent 25%, transparent 75%, #cbd5e1 75%, #cbd5e1), linear-gradient(45deg, #cbd5e1 25%, transparent 25%, transparent 75%, #cbd5e1 75%, #cbd5e1); background-size: 20px 20px; background-position: 0 0, 10px 10px;"></div>
        
        <div class="relative z-10 space-y-6">
            <!-- Header -->
            <div class="text-center space-y-2 max-w-3xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-cursive text-amber-600 tracking-wide">Đối Tác – Khách Hàng</h2>
                <!-- Wavy Underline SVG -->
                <svg class="mx-auto mt-2" width="64" height="12" viewBox="0 0 60 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M 0 6 Q 7.5 12 15 6 T 30 6 T 45 6 T 60 6" stroke="#d97706" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                </svg>
                <p class="text-xs md:text-sm text-slate-500 leading-relaxed pt-2">
                    Việc cung cấp những sản phẩm organic chất lượng cao sẽ góp phần đem đến cho gia đình những bữa ăn ngon miệng, an toàn vì một cuộc sống khỏe mạnh và hạnh phúc.
                </p>
            </div>

            <!-- Partner Logos grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 pt-4">
                <!-- Tony's House -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md border border-slate-100 flex items-center justify-center p-4 aspect-[2/1] transition duration-300 hover:-translate-y-1 hover:shadow-emerald-100">
                    <img src="{{ BASE_URL }}/uploads/partner_tonys.png" alt="Tony's House" class="max-h-full max-w-full object-contain">
                </div>
                <!-- AEON -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md border border-slate-100 flex items-center justify-center p-4 aspect-[2/1] transition duration-300 hover:-translate-y-1 hover:shadow-purple-100">
                    <img src="{{ BASE_URL }}/uploads/partner_aeon.png" alt="AEON" class="max-h-full max-w-full object-contain">
                </div>
                <!-- Sweetbay -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md border border-slate-100 flex items-center justify-center p-4 aspect-[2/1] transition duration-300 hover:-translate-y-1 hover:shadow-blue-100">
                    <img src="{{ BASE_URL }}/uploads/partner_sweetbay.png" alt="Sweetbay" class="max-h-full max-w-full object-contain">
                </div>
                <!-- Co.opmart -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md border border-slate-100 flex items-center justify-center p-4 aspect-[2/1] transition duration-300 hover:-translate-y-1 hover:shadow-cyan-100">
                    <img src="{{ BASE_URL }}/uploads/partner_coopmart.png" alt="Co.opmart" class="max-h-full max-w-full object-contain">
                </div>
                <!-- GO! -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md border border-slate-100 flex items-center justify-center p-4 aspect-[2/1] transition duration-300 hover:-translate-y-1 hover:shadow-red-100">
                    <img src="{{ BASE_URL }}/uploads/partner_go.png" alt="GO!" class="max-h-full max-w-full object-contain">
                </div>
            </div>
        </div>
    </div>

    <!-- ===== SECTION: THỐNG KÊ + ĐĂNG KÝ NHẬN TIN ===== -->
    <div class="space-y-0 pt-4">
        <!-- Thống kê ấn tượng -->
        <div class="bg-gradient-to-br from-emerald-600 via-emerald-500 to-teal-500 rounded-3xl p-8 md:p-12 shadow-xl relative overflow-hidden">
            <!-- Decorative circles -->
            <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/10"></div>
            <div class="absolute -bottom-8 -left-8 w-32 h-32 rounded-full bg-white/10"></div>
            <div class="absolute top-1/2 left-1/2 w-64 h-64 rounded-full bg-white/5 -translate-x-1/2 -translate-y-1/2"></div>

            <div class="relative z-10">
                <div class="text-center mb-10">
                    <span class="inline-block bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-wider backdrop-blur-sm">
                        <i class="fa-solid fa-chart-line mr-1"></i> Thành tựu của chúng tôi
                    </span>
                    <h2 class="text-2xl md:text-3xl font-black text-white drop-shadow">Z DEMO — Tươi Sạch Tin Cậy</h2>
                    <p class="text-white/75 text-sm mt-2">Hàng nghìn gia đình tin tưởng lựa chọn mỗi ngày</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @php
                    $stats = [
                        ['icon' => 'fa-users', 'value' => '15.000+', 'label' => 'Khách hàng', 'sub' => 'thân thiết'],
                        ['icon' => 'fa-box-open', 'value' => '500+',    'label' => 'Sản phẩm', 'sub' => 'tươi sạch'],
                        ['icon' => 'fa-star',     'value' => '4.9/5',   'label' => 'Đánh giá',  'sub' => 'trung bình'],
                        ['icon' => 'fa-truck',    'value' => '2 giờ',   'label' => 'Giao hàng', 'sub' => 'nhanh chóng'],
                    ];
                    @endphp
                    @foreach($stats as $stat)
                    <div class="text-center group">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:bg-white/30 transition">
                            <i class="fa-solid {{ $stat['icon'] }} text-white text-xl"></i>
                        </div>
                        <div class="text-3xl font-black text-white drop-shadow">{{ $stat['value'] }}</div>
                        <div class="text-white font-bold text-sm mt-0.5">{{ $stat['label'] }}</div>
                        <div class="text-white/60 text-xs">{{ $stat['sub'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Newsletter Subscribe -->
        <div class="bg-slate-900 rounded-3xl p-8 md:p-10 mt-6 relative overflow-hidden">
            <!-- Background pattern -->
            <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width=40 height=40 viewBox=0 0 40 40 xmlns=http://www.w3.org/2000/svg%3E%3Cg fill=%23fff fill-opacity=1%3E%3Cpath d=M20 20.5V18H0v5h5v5H0v5h20v-5h-5v-5h5v-5h15v5h-5v5h5v5H20v-5h5v-5h-5V18h-5z/%3E%3C/g%3E%3C/svg%3E');"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="text-center md:text-left">
                    <div class="flex items-center gap-2 justify-center md:justify-start mb-2">
                        <span class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-envelope-open-text"></i>
                        </span>
                        <span class="text-emerald-400 text-xs font-bold uppercase tracking-widest">Newsletter</span>
                    </div>
                    <h3 class="text-2xl font-black text-white">Đăng ký nhận tin khuyến mãi</h3>
                    <p class="text-slate-400 text-sm mt-1 max-w-sm">Nhận ngay ưu đãi 10% cho đơn hàng đầu tiên và cập nhật sản phẩm mới mỗi tuần!</p>
                    <div class="flex items-center gap-4 mt-3">
                        <div class="flex items-center gap-1.5 text-xs text-slate-400">
                            <i class="fa-solid fa-shield-halved text-emerald-500"></i> Bảo mật tuyệt đối
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-slate-400">
                            <i class="fa-solid fa-ban text-emerald-500"></i> Không spam
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-slate-400">
                            <i class="fa-solid fa-rotate-left text-emerald-500"></i> Hủy bất kỳ lúc nào
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-auto md:min-w-[400px]">
                    <form id="newsletter-form" class="space-y-3" onsubmit="submitNewsletter(event)">
                        <div class="flex gap-2">
                            <input type="email" id="newsletter-email"
                                   placeholder="Nhập email của bạn..."
                                   required
                                   class="flex-grow px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                            <button type="submit"
                                    class="px-5 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm transition shadow-lg whitespace-nowrap flex items-center gap-2">
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                                <span class="hidden sm:inline">Đăng ký</span>
                            </button>
                        </div>
                        <div id="newsletter-msg" class="hidden text-xs font-semibold text-emerald-400 flex items-center gap-2">
                            <i class="fa-solid fa-circle-check"></i> Đăng ký thành công! Kiểm tra email của bạn nhé.
                        </div>
                    </form>
                    <!-- Quick stats below form -->
                    <div class="flex items-center gap-4 mt-4">
                        <div class="flex -space-x-2">
                            @php $avatarColors = ['bg-rose-400','bg-blue-400','bg-amber-400','bg-purple-400']; @endphp
                            @foreach($avatarColors as $ac)
                            <div class="w-7 h-7 rounded-full {{ $ac }} border-2 border-slate-900 flex items-center justify-center">
                                <i class="fa-solid fa-user text-white text-[8px]"></i>
                            </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-slate-400"><strong class="text-white">2.500+</strong> người đã đăng ký</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
function submitNewsletter(e) {
    e.preventDefault();
    var email = document.getElementById('newsletter-email').value;
    var msg   = document.getElementById('newsletter-msg');
    if (email) {
        document.getElementById('newsletter-email').value = '';
        msg.classList.remove('hidden');
        setTimeout(function() { msg.classList.add('hidden'); }, 5000);
    }
}
</script>


<!-- jQuery: Homepage Product Card Mini-Sliders -->
<script>
$(document).ready(function () {
    $('.product-slider').each(function () {
        var $slider  = $(this);
        var images   = JSON.parse($slider.attr('data-images') || '[]');
        var count    = parseInt($slider.attr('data-count') || '1');
        if (count <= 1) return;

        var current  = 0;
        var $card    = $slider.closest('.product-card');
        var autoplay = null;

        function goTo(idx) {
            if (idx < 0)    idx = count - 1;
            if (idx >= count) idx = 0;
            current = idx;

            // Fade swap main image
            var $img = $slider.find('.slider-main-img');
            $img.css('opacity', 0);
            setTimeout(function () {
                $img.attr('src', images[current]).css('opacity', 1);
            }, 160);

            // Dots — plain 'active' class only, no Tailwind /opacity class
            $slider.find('.slider-dot').removeClass('active');
            $slider.find('.slider-dot[data-index="' + current + '"]').addClass('active');

            // Counter badge
            $slider.find('.slider-counter').text((current + 1) + '/' + count);

            // Thumbnails
            $card.find('.slider-thumb').removeClass('active');
            $card.find('.slider-thumb[data-index="' + current + '"]').addClass('active');
        }

        // Prev / Next
        $slider.find('.slider-prev').on('click', function (e) {
            e.preventDefault(); e.stopPropagation();
            goTo(current - 1);
            resetAutoPlay();
        });
        $slider.find('.slider-next').on('click', function (e) {
            e.preventDefault(); e.stopPropagation();
            goTo(current + 1);
            resetAutoPlay();
        });

        // Dots
        $slider.find('.slider-dot').on('click', function (e) {
            e.stopPropagation();
            goTo(parseInt($(this).data('index')));
            resetAutoPlay();
        });

        // Thumbnails
        $card.find('.slider-thumb').on('click', function (e) {
            e.stopPropagation();
            goTo(parseInt($(this).data('index')));
            resetAutoPlay();
        });

        // Touch swipe
        var txStart = 0;
        $slider[0].addEventListener('touchstart', function (e) {
            txStart = e.changedTouches[0].screenX;
        }, { passive: true });
        $slider[0].addEventListener('touchend', function (e) {
            var diff = txStart - e.changedTouches[0].screenX;
            if (Math.abs(diff) > 40) { goTo(diff > 0 ? current + 1 : current - 1); resetAutoPlay(); }
        }, { passive: true });

        // Auto-play khi hover vào card
        $card.on('mouseenter', function () {
            autoplay = setInterval(function () { goTo(current + 1); }, 2500);
        }).on('mouseleave', function () {
            clearInterval(autoplay); autoplay = null;
        });

        function resetAutoPlay() {
            clearInterval(autoplay);
            if ($card.is(':hover')) {
                autoplay = setInterval(function () { goTo(current + 1); }, 2500);
            }
        }
    });
});
</script>
@endsection

