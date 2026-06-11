@extends('layouts.main')

@section('title', 'Liên Hệ - Z DEMO Thực Phẩm Sạch')

@section('content')
<div class="space-y-8">

    <!-- Breadcrumb -->
    <nav class="flex text-sm text-slate-500 items-center space-x-2">
        <a href="{{ BASE_URL }}/" class="hover:text-emerald-600 transition"><i class="fa-solid fa-house"></i> Trang chủ</a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
        <span class="text-slate-900 font-medium">Liên hệ</span>
    </nav>

    <!-- ===== BANNER SLIDER 8 ẢNH ===== -->
    @php
    $contactBanners = [
        ['img' => BASE_URL.'/uploads/contact_banner_1.png', 'label' => '📍 Liên hệ với chúng tôi', 'title' => 'Chúng Tôi Luôn', 'sub' => 'Lắng Nghe Bạn', 'desc' => 'Đội ngũ hỗ trợ luôn sẵn sàng 24/7. Liên hệ ngay để được tư vấn!', 'bg' => 'from-emerald-600 via-teal-600 to-cyan-700'],
        ['img' => BASE_URL.'/uploads/contact_banner_2.png', 'label' => '🛵 Giao hàng siêu tốc',    'title' => 'Giao Hàng Trong', 'sub' => '2 Giờ Đồng Hồ',    'desc' => 'Đặt hàng trước 10:00 sáng – nhận hàng ngay trong buổi sáng hôm đó!', 'bg' => 'from-violet-700 via-purple-600 to-fuchsia-600'],
        ['img' => BASE_URL.'/uploads/contact_banner_3.png', 'label' => '🥦 Rau củ tươi ngon',      'title' => 'Sản Phẩm', 'sub' => 'Tươi Sạch Mỗi Ngày', 'desc' => 'Rau củ quả VietGAP, trái cây nhập khẩu, thịt cá tươi — có mặt khắp nơi.', 'bg' => 'from-rose-600 via-orange-500 to-amber-500'],
        ['img' => BASE_URL.'/uploads/contact_banner_4.png', 'label' => '📱 Đặt hàng online',       'title' => 'Mua Sắm', 'sub' => 'Dễ Dàng & Tiện Lợi', 'desc' => 'Đặt hàng online qua website, thanh toán linh hoạt, nhận hàng tại nhà.', 'bg' => 'from-indigo-700 via-blue-600 to-cyan-500'],
        ['img' => BASE_URL.'/uploads/contact_banner_5.png', 'label' => '🛡️ Cam kết chất lượng',   'title' => 'Đảm Bảo', 'sub' => 'Uy Tín & Chất Lượng', 'desc' => '100% sản phẩm có nguồn gốc rõ ràng, kiểm định nghiêm ngặt từ trang trại.', 'bg' => 'from-slate-800 via-blue-900 to-indigo-900'],
        ['img' => BASE_URL.'/uploads/contact_banner_6.png', 'label' => '🔥 Khuyến mãi hot',        'title' => 'Sale Khủng', 'sub' => 'Giảm Đến 50%',      'desc' => 'Flash sale mỗi ngày từ 7:00 – 9:00 sáng. Đặt hàng sớm để không bỏ lỡ!', 'bg' => 'from-amber-600 via-orange-500 to-yellow-500'],
        ['img' => BASE_URL.'/uploads/contact_banner_7.png', 'label' => '🌿 Hữu cơ & Xanh',        'title' => 'Nông Sản', 'sub' => 'Hữu Cơ Chuẩn GAP',   'desc' => 'Trồng theo tiêu chuẩn hữu cơ, không thuốc trừ sâu, tốt cho cả gia đình.', 'bg' => 'from-emerald-700 via-green-600 to-lime-500'],
        ['img' => BASE_URL.'/uploads/contact_banner_8.png', 'label' => '👑 Thành viên VIP',        'title' => 'Tích Điểm', 'sub' => 'Nhận Quà Hấp Dẫn',  'desc' => 'Đăng ký thành viên VIP – tích điểm mỗi đơn hàng, đổi ngay quà tặng giá trị!', 'bg' => 'from-slate-800 via-slate-700 to-pink-900'],
    ];
    @endphp

    <div id="contact-slider" class="relative rounded-3xl overflow-hidden shadow-xl" style="height:300px;">

        <!-- Slides -->
        @foreach($contactBanners as $ci => $cb)
        <div class="contact-slide absolute inset-0 bg-gradient-to-r {{ $cb['bg'] }}"
             style="{{ $ci === 0 ? 'opacity:1;z-index:2;' : 'opacity:0;z-index:1;' }} transition: opacity .7s ease;">
            <!-- Ảnh nền mờ -->
            <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('{{ $cb['img'] }}');opacity:.3;"></div>
            <!-- Pattern overlay -->
            <div class="absolute inset-0 opacity-5" style="background-image:url('data:image/svg+xml,%3Csvg width=40 height=40 viewBox=0 0 40 40 xmlns=http://www.w3.org/2000/svg%3E%3Cg fill=%23fff fill-opacity=1 fill-rule=evenodd%3E%3Ccircle cx=20 cy=20 r=3/%3E%3C/g%3E%3C/svg%3E');"></div>

            <!-- Content -->
            <div class="relative z-10 h-full flex flex-col md:flex-row items-center justify-between px-8 sm:px-14 gap-6">
                <div class="text-white text-center md:text-left max-w-xl space-y-3">
                    <span class="inline-block bg-white/20 backdrop-blur-sm border border-white/30 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider">
                        {{ $cb['label'] }}
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-black tracking-tight leading-tight drop-shadow">
                        {{ $cb['title'] }}<br>
                        <span class="text-yellow-300">{{ $cb['sub'] }}</span>
                    </h1>
                    <p class="text-white/80 text-sm leading-relaxed max-w-md">{{ $cb['desc'] }}</p>
                    <a href="#contact-form-section"
                       class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-white/20 hover:bg-white/30 border border-white/40 text-white font-bold text-xs backdrop-blur-sm transition">
                        <i class="fa-solid fa-paper-plane"></i> Liên hệ ngay
                    </a>
                </div>
                <!-- Ảnh bên phải -->
                <div class="hidden md:block flex-shrink-0 w-64 h-44 rounded-2xl overflow-hidden border-4 border-white/25 shadow-2xl">
                    <img src="{{ $cb['img'] }}" alt="{{ $cb['title'] }}" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
        @endforeach

        <!-- Nút Prev / Next -->
        <button id="contact-prev" type="button"
                style="position:absolute;left:14px;top:50%;transform:translateY(-50%);z-index:30;width:42px;height:42px;border-radius:50%;background:rgba(255,255,255,0.18);border:2px solid rgba(255,255,255,0.45);color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:15px;backdrop-filter:blur(4px);transition:background .2s;"
                onmouseover="this.style.background='rgba(255,255,255,0.38)'" onmouseout="this.style.background='rgba(255,255,255,0.18)'">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button id="contact-next" type="button"
                style="position:absolute;right:14px;top:50%;transform:translateY(-50%);z-index:30;width:42px;height:42px;border-radius:50%;background:rgba(255,255,255,0.18);border:2px solid rgba(255,255,255,0.45);color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:15px;backdrop-filter:blur(4px);transition:background .2s;"
                onmouseover="this.style.background='rgba(255,255,255,0.38)'" onmouseout="this.style.background='rgba(255,255,255,0.18)'">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

        <!-- Dot Indicators -->
        <div id="contact-dots" style="position:absolute;bottom:14px;left:0;right:0;display:flex;justify-content:center;gap:7px;z-index:30;">
            @foreach($contactBanners as $ci => $cb)
            <span class="contact-dot" data-idx="{{ $ci }}"
                  style="display:inline-block;width:{{ $ci===0?'26px':'9px' }};height:9px;border-radius:5px;
                         background:{{ $ci===0?'rgba(255,255,255,1)':'rgba(255,255,255,0.4)' }};
                         cursor:pointer;transition:all .3s ease;box-shadow:0 1px 4px rgba(0,0,0,.3);">
            </span>
            @endforeach
        </div>

        <!-- Slide counter -->
        <div id="contact-counter" style="position:absolute;top:14px;right:16px;z-index:30;background:rgba(0,0,0,.32);color:#fff;font-size:10px;font-weight:700;padding:3px 9px;border-radius:20px;backdrop-filter:blur(4px);">
            1 / {{ count($contactBanners) }}
        </div>
    </div>

    <!-- Slider JS -->
    <script>
    (function(){
        var slides  = document.querySelectorAll('.contact-slide');
        var dots    = document.querySelectorAll('.contact-dot');
        var counter = document.getElementById('contact-counter');
        var total   = slides.length, cur = 0, timer = null;

        function goTo(i) {
            if (i < 0) i = total - 1;
            if (i >= total) i = 0;
            slides.forEach(function(s){ s.style.opacity='0'; s.style.zIndex='1'; });
            dots.forEach(function(d){ d.style.width='9px'; d.style.background='rgba(255,255,255,0.4)'; });
            slides[i].style.opacity = '1'; slides[i].style.zIndex = '2';
            dots[i].style.width = '26px'; dots[i].style.background = 'rgba(255,255,255,1)';
            if(counter) counter.textContent = (i+1)+' / '+total;
            cur = i;
        }
        function startAuto(){ stopAuto(); timer = setInterval(function(){ goTo(cur+1); }, 5000); }
        function stopAuto(){ if(timer){ clearInterval(timer); timer=null; } }

        document.getElementById('contact-prev').addEventListener('click', function(){ goTo(cur-1); stopAuto(); startAuto(); });
        document.getElementById('contact-next').addEventListener('click', function(){ goTo(cur+1); stopAuto(); startAuto(); });
        dots.forEach(function(d){
            d.addEventListener('click', function(){ goTo(parseInt(d.getAttribute('data-idx'))); stopAuto(); startAuto(); });
        });

        // Touch swipe
        var tx0 = 0, sl = document.getElementById('contact-slider');
        sl.addEventListener('touchstart', function(e){ tx0 = e.changedTouches[0].screenX; }, {passive:true});
        sl.addEventListener('touchend',   function(e){
            var dx = tx0 - e.changedTouches[0].screenX;
            if(Math.abs(dx)>50){ goTo(dx>0?cur+1:cur-1); stopAuto(); startAuto(); }
        }, {passive:true});

        startAuto();
    })();
    </script>
    <!-- ===== END BANNER SLIDER ===== -->


    <!-- Info Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-start gap-4 hover:shadow-md transition">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 text-lg">
                <i class="fa-solid fa-location-dot"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Địa chỉ</p>
                <p class="text-sm font-semibold text-slate-800 leading-snug">FPT Polytechnic<br>Hà Nội, Việt Nam</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-start gap-4 hover:shadow-md transition">
            <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0 text-lg">
                <i class="fa-solid fa-phone"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Điện thoại</p>
                <p class="text-sm font-semibold text-slate-800">0909 123 456</p>
                <p class="text-xs text-slate-400 mt-0.5">08:00 – 21:00 mỗi ngày</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-start gap-4 hover:shadow-md transition">
            <div class="w-11 h-11 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center flex-shrink-0 text-lg">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Email</p>
                <p class="text-sm font-semibold text-slate-800 break-all">sonnhpa00362@fpt.edu.vn</p>
                <p class="text-xs text-slate-400 mt-0.5">Phản hồi trong 24h</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-start gap-4 hover:shadow-md transition">
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 text-lg">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Giờ làm việc</p>
                <p class="text-sm font-semibold text-slate-800">T2 – T7: 08:00 – 21:00</p>
                <p class="text-xs text-slate-400 mt-0.5">CN: 09:00 – 18:00</p>
            </div>
        </div>
    </div>

    <!-- Main: Form + Map -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Contact Form -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
            <h2 class="text-xl font-black text-slate-900 mb-1 flex items-center gap-2">
                <span class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-paper-plane"></i>
                </span>
                Gửi tin nhắn cho chúng tôi
            </h2>
            <p class="text-sm text-slate-400 mb-6 ml-11">Điền form bên dưới và chúng tôi sẽ liên hệ lại sớm nhất.</p>

            @if($success)
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl px-5 py-4 flex items-start gap-3">
                <i class="fa-solid fa-circle-check text-xl mt-0.5"></i>
                <div>
                    <p class="font-bold text-sm">Gửi thành công!</p>
                    <p class="text-xs mt-0.5 text-emerald-600">{{ $success }}</p>
                </div>
            </div>
            @endif

            @if($error)
            <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl px-5 py-4 flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p class="text-sm font-semibold">{{ $error }}</p>
            </div>
            @endif

            <form method="POST" action="{{ BASE_URL }}/contact" class="space-y-4" id="contact-form">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Họ tên -->
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">
                            Họ và tên <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                            <input type="text" name="name" required
                                   value="{{ $_POST['name'] ?? '' }}"
                                   placeholder="Nguyễn Văn A"
                                   class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition">
                        </div>
                    </div>
                    <!-- Điện thoại -->
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Số điện thoại</label>
                        <div class="relative">
                            <i class="fa-solid fa-phone absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                            <input type="tel" name="phone"
                                   value="{{ $_POST['phone'] ?? '' }}"
                                   placeholder="0909 123 456"
                                   class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition">
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">
                        Email <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                        <input type="email" name="email" required
                               value="{{ $_POST['email'] ?? '' }}"
                               placeholder="email@example.com"
                               class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition">
                    </div>
                </div>

                <!-- Chủ đề -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Chủ đề</label>
                    <select name="subject"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition bg-white">
                        <option value="">-- Chọn chủ đề --</option>
                        <option value="order" {{ (($_POST['subject'] ?? '') === 'order') ? 'selected' : '' }}>Đặt hàng & Giao hàng</option>
                        <option value="product" {{ (($_POST['subject'] ?? '') === 'product') ? 'selected' : '' }}>Thông tin sản phẩm</option>
                        <option value="complaint" {{ (($_POST['subject'] ?? '') === 'complaint') ? 'selected' : '' }}>Khiếu nại & Đổi trả</option>
                        <option value="partnership" {{ (($_POST['subject'] ?? '') === 'partnership') ? 'selected' : '' }}>Hợp tác kinh doanh</option>
                        <option value="other" {{ (($_POST['subject'] ?? '') === 'other') ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>

                <!-- Nội dung -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">
                        Nội dung tin nhắn <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="message" rows="5" required
                              placeholder="Nhập nội dung bạn muốn gửi đến Z DEMO..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition resize-none leading-relaxed">{{ $_POST['message'] ?? '' }}</textarea>
                    <p class="text-xs text-slate-400 mt-1" id="char-count">0 / 500 ký tự</p>
                </div>

                <!-- Captcha đơn giản -->
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 flex items-center gap-3">
                    <div class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center cursor-pointer" id="captcha-box" onclick="toggleCaptcha()">
                        <i class="fa-solid fa-check text-[10px] text-emerald-500 hidden" id="captcha-check"></i>
                    </div>
                    <input type="hidden" name="captcha_done" id="captcha-input" value="0">
                    <label class="text-sm text-slate-600 cursor-pointer" onclick="toggleCaptcha()">Tôi không phải robot 🤖</label>
                    <i class="fa-solid fa-shield-halved text-emerald-500 ml-auto text-lg"></i>
                </div>

                <button type="submit" id="submit-btn"
                        class="w-full py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm shadow-lg shadow-emerald-100 transition flex items-center justify-center gap-2 group">
                    <i class="fa-solid fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                    Gửi tin nhắn ngay
                </button>
            </form>
        </div>

        <!-- Map + Social -->
        <div class="space-y-5">

            <!-- Google Maps Embed - FPT Polytechnic HN -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 text-sm">FPT Polytechnic Hà Nội</p>
                        <p class="text-xs text-slate-400">Số 13A Trịnh Văn Bô, Nam Từ Liêm, Hà Nội</p>
                    </div>
                    <a href="https://maps.google.com/?q=FPT+Polytechnic+Hanoi" target="_blank"
                       class="ml-auto text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 transition">
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Mở Maps
                    </a>
                </div>
                <!-- Google Maps iFrame -->
                <div class="relative" style="height: 320px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.7643433847507!2d105.77001291533557!3d21.038193585994073!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab358b9dc4cd%3A0x8a7b1bdcf43c4813!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2svn!4v1686900000000!5m2!1svi!2svn"
                        width="100%"
                        height="320"
                        style="border:0; display:block;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Bản đồ FPT Polytechnic Hà Nội">
                    </iframe>
                </div>
            </div>

            <!-- Social Media -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                <h3 class="text-sm font-black text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-share-nodes text-emerald-500"></i>
                    Kết nối với Z DEMO
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="#" class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50 transition group">
                        <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center text-sm">
                            <i class="fa-brands fa-facebook-f"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-700 group-hover:text-blue-600 transition">Facebook</p>
                            <p class="text-[10px] text-slate-400">Z DEMO Official</p>
                        </div>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-100 hover:border-pink-200 hover:bg-pink-50 transition group">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-pink-500 to-orange-400 text-white flex items-center justify-center text-sm">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-700 group-hover:text-pink-600 transition">Instagram</p>
                            <p class="text-[10px] text-slate-400">@zdemo.food</p>
                        </div>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-100 hover:border-red-200 hover:bg-red-50 transition group">
                        <div class="w-9 h-9 rounded-xl bg-red-600 text-white flex items-center justify-center text-sm">
                            <i class="fa-brands fa-youtube"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-700 group-hover:text-red-600 transition">YouTube</p>
                            <p class="text-[10px] text-slate-400">Z DEMO Channel</p>
                        </div>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-100 hover:border-sky-200 hover:bg-sky-50 transition group">
                        <div class="w-9 h-9 rounded-xl bg-sky-500 text-white flex items-center justify-center text-sm">
                            <i class="fa-brands fa-telegram"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-700 group-hover:text-sky-600 transition">Telegram</p>
                            <p class="text-[10px] text-slate-400">@zdemo_support</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- FAQ nhanh -->
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-3xl border border-emerald-100 p-6">
                <h3 class="text-sm font-black text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-question text-emerald-500"></i>
                    Câu hỏi thường gặp
                </h3>
                <div class="space-y-3">
                    @php
                    $faqs = [
                        ['q' => 'Thời gian giao hàng bao lâu?', 'a' => 'Giao trong vòng 2 giờ kể từ khi đặt hàng (nội thành).'],
                        ['q' => 'Có đổi trả sản phẩm không?', 'a' => 'Chấp nhận đổi trả trong 24 giờ nếu sản phẩm bị lỗi hoặc không đúng.'],
                        ['q' => 'Đặt hàng tối thiểu bao nhiêu?', 'a' => 'Không có giới hạn đơn hàng tối thiểu, miễn phí ship từ 200.000đ.'],
                    ];
                    @endphp
                    @foreach($faqs as $faq)
                    <div class="bg-white rounded-xl p-4 border border-emerald-100">
                        <p class="text-xs font-bold text-emerald-700"><i class="fa-solid fa-circle-check mr-1.5 text-emerald-400"></i>{{ $faq['q'] }}</p>
                        <p class="text-xs text-slate-500 mt-1 ml-5 leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

<script>
// Đếm ký tự textarea
document.querySelector('textarea[name="message"]').addEventListener('input', function () {
    var len = this.value.length;
    document.getElementById('char-count').textContent = len + ' / 500 ký tự';
    if (len > 500) {
        this.value = this.value.substring(0, 500);
        document.getElementById('char-count').textContent = '500 / 500 ký tự';
    }
});

// Simple captcha toggle
function toggleCaptcha() {
    var box   = document.getElementById('captcha-box');
    var check = document.getElementById('captcha-check');
    var input = document.getElementById('captcha-input');
    var done  = input.value === '1';
    if (done) {
        box.classList.remove('border-emerald-500', 'bg-emerald-50');
        box.classList.add('border-slate-300');
        check.classList.add('hidden');
        input.value = '0';
    } else {
        box.classList.add('border-emerald-500', 'bg-emerald-50');
        box.classList.remove('border-slate-300');
        check.classList.remove('hidden');
        input.value = '1';
    }
}

// Validate captcha before submit
document.getElementById('contact-form').addEventListener('submit', function (e) {
    if (document.getElementById('captcha-input').value !== '1') {
        e.preventDefault();
        alert('Vui lòng xác nhận "Tôi không phải robot" trước khi gửi!');
    }
});

// Animate info cards on scroll
if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.hover\\:shadow-md').forEach(function (el, i) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity .5s ease ' + (i * 0.1) + 's, transform .5s ease ' + (i * 0.1) + 's';
        observer.observe(el);
    });
}
</script>
@endsection
