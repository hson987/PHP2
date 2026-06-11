@extends('layouts.main')

@section('title', $product['name'] . ' - Chi tiết sản phẩm Z DEMO')

@section('content')
<style>
/* === Product Detail Image Slider === */
#product-gallery .dot {
    display: inline-block;
    width: 8px; height: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,0.55);
    border: 1px solid rgba(255,255,255,0.4);
    cursor: pointer;
    transition: all .25s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,.25);
}
#product-gallery .dot.active {
    background: #10b981;
    border-color: #10b981;
    transform: scale(1.35);
}
#product-gallery .thumbnail {
    border: 2px solid #e2e8f0;
    transition: border-color .2s;
    cursor: pointer;
}
#product-gallery .thumbnail.active {
    border-color: #10b981;
}
#main-product-img {
    transition: opacity .25s ease;
}
.nav-btn {
    position: absolute;
    top: 50%; transform: translateY(-50%);
    width: 36px; height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,.92);
    box-shadow: 0 2px 8px rgba(0,0,0,.18);
    border: none;
    display: flex; align-items: center; justify-content: center;
    color: #334155;
    cursor: pointer;
    z-index: 20;
    font-size: 14px;
    transition: background .2s, color .2s;
}
.nav-btn:hover { background: #10b981; color: #fff; }
#prev-img-btn { left: 10px; }
#next-img-btn { right: 10px; }
</style>

<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-slate-500 items-center space-x-2">
        <a href="{{ BASE_URL }}/" class="hover:text-emerald-600 transition"><i class="fa-solid fa-house"></i> Trang chủ</a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
        <a href="{{ BASE_URL }}/products" class="hover:text-emerald-600 transition">Sản phẩm</a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
        <span class="text-slate-900 font-medium truncate">{{ $product['name'] }}</span>
    </nav>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-6 md:p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">

            <!-- === IMAGE SLIDER === -->
            @php
                $images = isset($product['images']) && is_array($product['images']) && count($product['images']) > 0
                    ? $product['images']
                    : [$product['image'] ?? 'uploads/product_hero_showcase.jpg'];
                $imageCount = count($images);
            @endphp

            <div class="space-y-3" id="product-gallery">
                <!-- Main image frame -->
                <div class="relative rounded-2xl overflow-hidden bg-slate-50 border border-slate-100 aspect-square" id="main-image-wrap">
                    <img id="main-product-img"
                         src="{{ preg_match('/^https?:\/\//i', $images[0]) ? $images[0] : BASE_URL . '/' . $images[0] }}"
                         alt="{{ $product['name'] }}"
                         class="w-full h-full object-cover">

                    @if(!empty($product['discount_percent']) && $product['discount_percent'] > 0)
                    <span class="absolute top-4 right-4 bg-rose-500 text-white text-xs font-black px-3 py-1 rounded-full shadow-lg z-10">
                        -{{ $product['discount_percent'] }}%
                    </span>
                    @endif

                    @if($imageCount > 1)
                    <!-- Prev / Next — plain HTML buttons, no Tailwind opacity tricks -->
                    <button id="prev-img-btn" class="nav-btn" title="Ảnh trước">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button id="next-img-btn" class="nav-btn" title="Ảnh sau">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <!-- Dot indicators -->
                    <div class="absolute bottom-3 left-0 right-0 flex justify-center gap-2" id="dot-indicators">
                        @foreach($images as $idx => $img)
                        <span class="dot {{ $idx === 0 ? 'active' : '' }}" data-index="{{ $idx }}"></span>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Thumbnails -->
                @if($imageCount > 1)
                <div class="flex gap-2 overflow-x-auto pb-1" id="thumbnail-strip">
                    @foreach($images as $idx => $img)
                    @php $thumbUrl = preg_match('/^https?:\/\//i', $img) ? $img : BASE_URL . '/' . $img; @endphp
                    <div class="thumbnail flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden {{ $idx === 0 ? 'active' : '' }}"
                         data-index="{{ $idx }}" data-src="{{ $thumbUrl }}">
                        <img src="{{ $thumbUrl }}" alt="Ảnh {{ $idx + 1 }}" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <!-- === END IMAGE SLIDER === -->

            <!-- Product Specs -->
            <div class="flex flex-col justify-between">
                <div>
                    <span class="text-xs font-semibold px-2.5 py-1.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-wider">
                        Đà Lạt Organic
                    </span>
                    <h1 class="mt-4 text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ $product['name'] }}
                    </h1>

                    <div class="mt-4 flex items-center gap-4">
                        <span class="text-3xl font-black text-emerald-600">
                            {{ number_format($product['price'], 0, ',', '.') }}đ
                        </span>
                        @if(!empty($product['original_price']))
                        <span class="text-sm text-slate-400 line-through">
                            {{ number_format($product['original_price'], 0, ',', '.') }}đ
                        </span>
                        @else
                        <span class="text-sm text-slate-400 line-through">
                            {{ number_format($product['price'] * 1.25, 0, ',', '.') }}đ
                        </span>
                        @endif
                    </div>

                    @if($imageCount > 1)
                    <div class="mt-3 flex items-center gap-1.5 text-xs text-emerald-600 font-semibold">
                        <i class="fa-solid fa-images"></i>
                        <span>{{ $imageCount }} hình ảnh sản phẩm</span>
                    </div>
                    @endif

                    <!-- Trust Badges -->
                    <div class="mt-6 grid grid-cols-2 gap-4 border-t border-b border-slate-100 py-6 my-6">
                        <div class="flex items-center space-x-2.5 text-xs text-slate-600">
                            <i class="fa-solid fa-shield-halved text-emerald-600 text-base"></i>
                            <span>100% An toàn vệ sinh</span>
                        </div>
                        <div class="flex items-center space-x-2.5 text-xs text-slate-600">
                            <i class="fa-solid fa-truck-fast text-emerald-600 text-base"></i>
                            <span>Giao hàng nhanh 2H</span>
                        </div>
                        <div class="flex items-center space-x-2.5 text-xs text-slate-600">
                            <i class="fa-solid fa-leaf text-emerald-600 text-base"></i>
                            <span>Chuẩn VietGAP hữu cơ</span>
                        </div>
                        <div class="flex items-center space-x-2.5 text-xs text-slate-600">
                            <i class="fa-solid fa-rotate-left text-emerald-600 text-base"></i>
                            <span>Đổi trả trong 24H</span>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Chi tiết sản phẩm</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            {{ $product['description'] }}
                        </p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-4">
                    <button class="add-to-cart-btn flex-grow inline-flex items-center justify-center space-x-2 px-6 py-3 border border-transparent rounded-xl text-base font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-md shadow-emerald-50 transition"
                            data-id="{{ $product['id'] }}"
                            data-name="{{ $product['name'] }}"
                            data-price="{{ $product['price'] }}"
                            data-image="{{ $images[0] }}">
                        <i class="fa-solid fa-basket-shopping"></i>
                        <span>Thêm vào giỏ</span>
                    </button>
                    <a href="{{ BASE_URL }}/" class="inline-flex items-center justify-center px-6 py-3 border border-slate-200 rounded-xl text-base font-semibold text-slate-700 bg-white hover:bg-slate-50 transition">
                        Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $jsImageUrls = array_map(function($img) {
        return preg_match('/^https?:\/\//i', $img) ? $img : BASE_URL . '/' . $img;
    }, $images);
    $jsImageJson = json_encode($jsImageUrls, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
@endphp

<script>
$(document).ready(function () {
    var images = {!! $jsImageJson !!};
    var total  = images.length;
    if (total <= 1) return;

    var currentIndex = 0;
    var autoPlay = null;

    function goTo(idx) {
        if (idx < 0)     idx = total - 1;
        if (idx >= total) idx = 0;
        currentIndex = idx;

        // Fade swap
        var $img = $('#main-product-img');
        $img.css('opacity', 0);
        setTimeout(function () {
            $img.attr('src', images[currentIndex]);
            $img.css('opacity', 1);
        }, 180);

        // Dots — dùng class 'active' thuần, không dùng Tailwind /opacity
        $('.dot').removeClass('active');
        $('.dot[data-index="' + currentIndex + '"]').addClass('active');

        // Thumbnails
        $('.thumbnail').removeClass('active');
        $('.thumbnail[data-index="' + currentIndex + '"]').addClass('active');
    }

    function startAutoPlay() {
        stopAutoPlay();
        autoPlay = setInterval(function () { goTo(currentIndex + 1); }, 4000);
    }
    function stopAutoPlay() {
        if (autoPlay) { clearInterval(autoPlay); autoPlay = null; }
    }

    // Prev / Next
    $('#prev-img-btn').on('click', function (e) {
        e.stopPropagation();
        goTo(currentIndex - 1);
        stopAutoPlay();
    });
    $('#next-img-btn').on('click', function (e) {
        e.stopPropagation();
        goTo(currentIndex + 1);
        stopAutoPlay();
    });

    // Dots
    $(document).on('click', '#dot-indicators .dot', function () {
        goTo(parseInt($(this).data('index')));
        stopAutoPlay();
    });

    // Thumbnails
    $(document).on('click', '#thumbnail-strip .thumbnail', function () {
        goTo(parseInt($(this).data('index')));
        stopAutoPlay();
    });

    // Swipe mobile
    var txStart = 0;
    document.getElementById('main-image-wrap').addEventListener('touchstart', function (e) {
        txStart = e.changedTouches[0].screenX;
    }, { passive: true });
    document.getElementById('main-image-wrap').addEventListener('touchend', function (e) {
        var diff = txStart - e.changedTouches[0].screenX;
        if (Math.abs(diff) > 45) {
            goTo(diff > 0 ? currentIndex + 1 : currentIndex - 1);
            stopAutoPlay();
        }
    }, { passive: true });

    // Bắt đầu auto-play
    startAutoPlay();
});
</script>
@endsection
