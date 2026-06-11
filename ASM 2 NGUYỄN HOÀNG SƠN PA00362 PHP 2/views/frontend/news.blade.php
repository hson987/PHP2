@extends('layouts.main')
@section('title', 'Tin Tức - Z DEMO Thực Phẩm Sạch')
@section('content')
<div class="space-y-8">

    <!-- ===== BANNER SLIDER 15 ẢNH ===== -->
    @php
    $newsBanners = [
        ['src' => BASE_URL . '/uploads/news_banner_1.png',  'title' => 'Rau củ sạch tươi ngon mỗi ngày',        'sub' => 'Thực phẩm an toàn từ vườn đến bàn ăn'],
        ['src' => BASE_URL . '/uploads/news_banner_2.png',  'title' => 'Salad healthy cho cuộc sống lành mạnh', 'sub' => 'Bí quyết ăn uống khoa học và cân bằng'],
        ['src' => BASE_URL . '/uploads/news_banner_3.png',  'title' => 'Phở — Tinh hoa ẩm thực Việt Nam',       'sub' => 'Hương vị truyền thống đậm đà khó quên'],
        ['src' => BASE_URL . '/uploads/news_banner_4.png',  'title' => 'Nông sản hữu cơ trực tiếp từ nông trại','sub' => 'Chứng nhận VietGAP, an toàn tuyệt đối'],
        ['src' => BASE_URL . '/uploads/news_banner_5.png',  'title' => 'Trái cây nhiệt đới phong phú',           'sub' => 'Thanh long, xoài, vải thiều, măng cụt...'],
        ['src' => BASE_URL . '/uploads/news_banner_6.png',  'title' => 'Nghệ thuật nấu ăn tại gia',             'sub' => 'Công thức đơn giản, ngon miệng, bổ dưỡng'],
        ['src' => BASE_URL . '/uploads/news_banner_7.jpg',  'title' => 'Bí quyết chọn rau củ tươi ngon',        'sub' => 'Mách nhỏ từ chuyên gia thực phẩm'],
        ['src' => BASE_URL . '/uploads/news_banner_8.jpg',  'title' => 'Top món ăn từ thịt heo dễ làm',         'sub' => '10 công thức nấu ăn gia đình tuyệt vời'],
        ['src' => BASE_URL . '/uploads/news_banner_9.jpg',  'title' => 'Lợi ích của rau xanh mỗi ngày',         'sub' => 'Tăng cường sức khỏe, phòng ngừa bệnh tật'],
        ['src' => BASE_URL . '/uploads/news_banner_10.jpg', 'title' => 'Bảo quản thực phẩm đúng cách',          'sub' => 'Giữ tươi ngon lâu hơn với mẹo hay này'],
        ['src' => BASE_URL . '/uploads/news_banner_11.jpg', 'title' => 'Trái cây nhập khẩu cao cấp',            'sub' => 'Táo Nhật, nho Mỹ, cherry tươi ngon'],
        ['src' => BASE_URL . '/uploads/news_banner_12.jpg', 'title' => 'Công thức salad rau củ healthy',         'sub' => 'Ăn kiêng ngon miệng không lo tăng cân'],
        ['src' => BASE_URL . '/uploads/news_banner_13.jpg', 'title' => 'Thực phẩm hữu cơ vs thông thường',      'sub' => 'Cách phân biệt và lựa chọn thông minh'],
        ['src' => BASE_URL . '/uploads/news_banner_14.jpg', 'title' => '10 mẹo nấu ăn ít dầu mỡ',              'sub' => 'Ngon bổ lành mà không lo béo phì'],
        ['src' => BASE_URL . '/uploads/news_banner_15.jpg', 'title' => 'Xu hướng ẩm thực lành mạnh 2026',       'sub' => 'Plant-based, smoothie xanh, acai bowl...'],
    ];
    @endphp

    <div class="relative w-full rounded-3xl overflow-hidden shadow-2xl group" id="newsBannerSlider" style="height:420px;">

        <!-- Slides -->
        <div class="relative w-full h-full">
            @foreach($newsBanners as $bi => $banner)
            <div class="news-slide absolute inset-0 transition-all duration-700 ease-in-out {{ $bi === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                 data-index="{{ $bi }}">
                <!-- Background Image -->
                <img src="{{ $banner['src'] }}" alt="{{ $banner['title'] }}"
                     class="w-full h-full object-cover"
                     onerror="this.src='{{ BASE_URL }}/uploads/article_1.jpg'">
                <!-- Gradient overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/30 to-transparent"></div>
                <!-- Text content -->
                <div class="absolute inset-0 flex flex-col justify-center px-10 md:px-16 z-10">
                    <span class="inline-flex items-center gap-2 bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full mb-4 w-fit uppercase tracking-wider">
                        <i class="fa-solid fa-newspaper text-[10px]"></i> Blog & Tin tức
                    </span>
                    <h2 class="text-white text-2xl md:text-4xl font-black leading-tight drop-shadow-lg max-w-lg">
                        {{ $banner['title'] }}
                    </h2>
                    <p class="text-white/75 text-sm md:text-base mt-2 max-w-md drop-shadow">
                        {{ $banner['sub'] }}
                    </p>
                    <div class="mt-5">
                        <a href="{{ BASE_URL }}/news" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold px-5 py-2.5 rounded-full transition shadow-lg">
                            Xem bài viết <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <!-- Slide counter badge -->
                <div class="absolute top-4 right-4 bg-black/40 text-white text-xs font-bold px-3 py-1 rounded-full backdrop-blur-sm">
                    {{ $bi + 1 }} / {{ count($newsBanners) }}
                </div>
            </div>
            @endforeach
        </div>

        <!-- Nút Prev < -->
        <button id="newsBannerPrev"
                class="absolute left-3 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-sm text-white flex items-center justify-center transition-all duration-200 hover:scale-110 shadow-lg opacity-0 group-hover:opacity-100"
                onclick="newsBannerMove(-1)" aria-label="Slide trước">
            <i class="fa-solid fa-chevron-left text-sm"></i>
        </button>

        <!-- Nút Next > -->
        <button id="newsBannerNext"
                class="absolute right-3 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-sm text-white flex items-center justify-center transition-all duration-200 hover:scale-110 shadow-lg opacity-0 group-hover:opacity-100"
                onclick="newsBannerMove(1)" aria-label="Slide tiếp">
            <i class="fa-solid fa-chevron-right text-sm"></i>
        </button>

        <!-- Chấm tròn dots -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-30 flex items-center gap-2">
            @foreach($newsBanners as $bi => $banner)
            <button class="news-dot transition-all duration-300 rounded-full {{ $bi === 0 ? 'w-6 h-2 bg-emerald-400' : 'w-2 h-2 bg-white/50 hover:bg-white/80' }}"
                    onclick="newsBannerGoTo({{ $bi }})"
                    data-dot="{{ $bi }}"
                    aria-label="Slide {{ $bi + 1 }}"></button>
            @endforeach
        </div>

        <!-- Progress bar -->
        <div class="absolute bottom-0 left-0 h-0.5 bg-emerald-400 z-30 transition-all duration-100" id="newsBannerProgress" style="width:0%"></div>
    </div>

    <!-- ===== BREADCRUMB ===== -->
    <nav class="flex text-sm text-slate-500 items-center space-x-2">
        <a href="{{ BASE_URL }}/" class="hover:text-emerald-600 transition"><i class="fa-solid fa-house"></i> Trang chủ</a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
        <span class="text-slate-900 font-medium">Tin tức</span>
    </nav>

    <!-- ===== ARTICLES GRID ===== -->
    @if(count($articles) === 0)
    <div class="py-20 text-center bg-white rounded-3xl border border-slate-100 text-slate-400">
        <i class="fa-solid fa-newspaper text-5xl mb-4"></i>
        <p class="text-lg font-bold">Chưa có bài viết nào</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($articles as $idx => $article)
        @php
            $imgUrl = !empty($article['image'])
                ? (preg_match('/^https?:\/\//i', $article['image']) ? $article['image'] : BASE_URL . '/' . $article['image'])
                : BASE_URL . '/uploads/article_1.jpg';
            $isHero = ($idx === 0);
        @endphp

        <article class="group bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition duration-300 flex flex-col {{ $isHero ? 'sm:col-span-2 lg:col-span-2' : '' }}">
            <!-- Thumbnail -->
            <a href="{{ BASE_URL }}/news/{{ $article['id'] }}" class="block overflow-hidden {{ $isHero ? 'h-64' : 'h-48' }} bg-slate-100 relative">
                <img src="{{ $imgUrl }}" alt="{{ $article['title'] }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                @if($isHero)
                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                <span class="absolute top-4 left-4 bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Nổi bật</span>
                @endif
            </a>

            <!-- Content -->
            <div class="p-6 flex flex-col flex-grow">
                <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                    <i class="fa-regular fa-calendar"></i>
                    <span>{{ date('d/m/Y', strtotime($article['created_at'])) }}</span>
                    <span class="mx-1">·</span>
                    <i class="fa-regular fa-clock"></i>
                    <span>{{ max(1, ceil(str_word_count($article['description'] ?? '') / 200)) }} phút đọc</span>
                </div>

                <h2 class="font-extrabold text-slate-900 group-hover:text-emerald-600 transition leading-snug {{ $isHero ? 'text-xl' : 'text-base' }} mb-2">
                    <a href="{{ BASE_URL }}/news/{{ $article['id'] }}">{{ $article['title'] }}</a>
                </h2>

                <p class="text-sm text-slate-500 leading-relaxed line-clamp-3 flex-grow">
                    {{ $article['description'] }}
                </p>

                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                    <a href="{{ BASE_URL }}/news/{{ $article['id'] }}"
                       class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 transition">
                        Đọc thêm <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                    <span class="text-xs text-slate-300 font-mono">#{{ $article['id'] }}</span>
                </div>
            </div>
        </article>
        @endforeach
    </div>
    @endif
</div>

<!-- ===== SLIDER JAVASCRIPT ===== -->
<script>
(function() {
    var current = 0;
    var total = {{ count($newsBanners) }};
    var autoTimer = null;
    var progressTimer = null;
    var progressVal = 0;
    var INTERVAL = 5000; // 5 giây mỗi slide

    function goTo(idx) {
        var slides = document.querySelectorAll('.news-slide');
        var dots   = document.querySelectorAll('.news-dot');

        // Ẩn slide cũ
        slides[current].classList.remove('opacity-100','z-10');
        slides[current].classList.add('opacity-0','z-0');
        dots[current].classList.remove('w-6','h-2','bg-emerald-400');
        dots[current].classList.add('w-2','h-2','bg-white/50');

        current = (idx + total) % total;

        // Hiện slide mới
        slides[current].classList.remove('opacity-0','z-0');
        slides[current].classList.add('opacity-100','z-10');
        dots[current].classList.remove('w-2','h-2','bg-white/50');
        dots[current].classList.add('w-6','h-2','bg-emerald-400');

        resetProgress();
    }

    function resetProgress() {
        progressVal = 0;
        var bar = document.getElementById('newsBannerProgress');
        if (bar) bar.style.width = '0%';
        clearInterval(progressTimer);
        progressTimer = setInterval(function() {
            progressVal += 100 / (INTERVAL / 100);
            if (progressVal > 100) progressVal = 100;
            if (bar) bar.style.width = progressVal + '%';
        }, 100);
    }

    function startAuto() {
        clearInterval(autoTimer);
        autoTimer = setInterval(function() {
            goTo(current + 1);
        }, INTERVAL);
    }

    function stopAuto() {
        clearInterval(autoTimer);
        clearInterval(progressTimer);
    }

    // Expose to global scope for inline onclick
    window.newsBannerMove = function(dir) {
        stopAuto();
        goTo(current + dir);
        startAuto();
    };
    window.newsBannerGoTo = function(idx) {
        stopAuto();
        goTo(idx);
        startAuto();
    };

    // Pause on hover
    var slider = document.getElementById('newsBannerSlider');
    if (slider) {
        slider.addEventListener('mouseenter', stopAuto);
        slider.addEventListener('mouseleave', startAuto);

        // Touch swipe support
        var touchStartX = 0;
        slider.addEventListener('touchstart', function(e) {
            touchStartX = e.touches[0].clientX;
            stopAuto();
        }, {passive: true});
        slider.addEventListener('touchend', function(e) {
            var diff = touchStartX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 50) {
                goTo(diff > 0 ? current + 1 : current - 1);
            }
            startAuto();
        }, {passive: true});
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft')  { window.newsBannerMove(-1); }
        if (e.key === 'ArrowRight') { window.newsBannerMove(1);  }
    });

    // Start
    resetProgress();
    startAuto();
})();
</script>

@endsection
