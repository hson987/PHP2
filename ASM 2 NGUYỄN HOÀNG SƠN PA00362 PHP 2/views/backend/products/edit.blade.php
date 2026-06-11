@extends('layouts.main')

@section('title', 'Chỉnh sửa sản phẩm - Z DEMO')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="space-y-1">
        <nav class="flex text-xs text-slate-400 items-center space-x-2">
            <a href="{{ BASE_URL }}/" class="hover:text-emerald-600 transition"><i class="fa-solid fa-house"></i> Trang chủ</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <a href="{{ BASE_URL }}/admin/products" class="hover:text-emerald-600 transition">Trang quản trị</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <span class="text-slate-950 font-semibold">Chỉnh sửa sản phẩm</span>
        </nav>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
            <span class="bg-blue-50 text-blue-600 rounded-xl p-2.5 text-sm"><i class="fa-solid fa-pen-to-square"></i></span>
            Chỉnh Sửa Sản Phẩm
        </h1>
    </div>

    <!-- Error Alerts -->
    @if(!empty($error))
        <div class="p-4 bg-rose-50 border border-rose-100 text-rose-600 rounded-2xl text-xs flex items-center gap-3">
            <i class="fa-solid fa-circle-exclamation text-lg"></i>
            <span class="font-bold">{{ $error }}</span>
        </div>
    @endif

    <!-- Form Container Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-6 md:p-8">
        <form action="{{ BASE_URL }}/admin/product/edit/{{ $product['id'] }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs font-semibold text-slate-700">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tên sản phẩm -->
                <div class="space-y-1.5 md:col-span-2">
                    <label for="name" class="block">Tên sản phẩm <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="name" required value="{{ $product['name'] }}" placeholder="Nhập tên đầy đủ" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition">
                </div>

                <!-- Danh mục sản phẩm -->
                <div class="space-y-1.5">
                    <label for="category" class="block">Danh mục sản phẩm <span class="text-rose-500">*</span></label>
                    <select name="category" id="category" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition">
                        @foreach($categories as $cat)
                            <option value="{{ $cat['code'] }}" {{ $product['category'] === $cat['code'] ? 'selected' : '' }}>{{ $cat['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Phân loại (Sale vs Thường) -->
                <div class="space-y-1.5 flex flex-col justify-end pb-3">
                    <label class="relative inline-flex items-center cursor-pointer space-x-3 bg-slate-50 border border-slate-200 p-3 rounded-2xl select-none hover:bg-slate-100/50 transition">
                        <input type="checkbox" name="is_sale" id="is_sale" class="sr-only peer" onchange="toggleDiscountFields()" {{ $product['is_sale'] == 1 ? 'checked' : '' }}>
                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[16px] after:left-[16px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:bg-emerald-600"></div>
                        <span class="text-xs font-bold text-slate-700">Bật chế độ "SĂN SALE" (Khuyến mãi)</span>
                    </label>
                </div>

                <!-- Giá bán và Giá gốc -->
                <div class="space-y-1.5">
                    <label for="price" class="block">Giá bán hiện tại (đ) <span class="text-rose-500">*</span></label>
                    <input type="number" min="0" step="any" name="price" id="price" required value="{{ $product['price'] }}" placeholder="Ví dụ: 35000" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition">
                </div>

                <!-- Các trường giảm giá (Chỉ hiển thị khi bật is_sale) -->
                <div id="discount_section" class="grid grid-cols-2 gap-4 {{ $product['is_sale'] == 1 ? '' : 'hidden' }}">
                    <div class="space-y-1.5">
                        <label for="original_price" class="block">Giá bán gốc cũ (đ)</label>
                        <input type="number" min="0" step="any" name="original_price" id="original_price" value="{{ $product['original_price'] }}" placeholder="Ví dụ: 50000" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition" {{ $product['is_sale'] == 1 ? 'required' : '' }}>
                    </div>
                    <div class="space-y-1.5">
                        <label for="discount_percent" class="block">Phần trăm giảm (%)</label>
                        <input type="number" min="0" max="100" name="discount_percent" id="discount_percent" value="{{ $product['discount_percent'] }}" placeholder="Ví dụ: 30" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition" {{ $product['is_sale'] == 1 ? 'required' : '' }}>
                    </div>
                </div>
            </div>

            <!-- Upload hình ảnh - Tối đa 6 ảnh (Pre-fill ảnh hiện tại) -->
            @php
                $existingImages = isset($currentImages) ? $currentImages : [];
                while (count($existingImages) < 6) { $existingImages[] = ''; }
            @endphp
            <div class="space-y-3 p-5 bg-gradient-to-br from-blue-50 to-slate-50 border border-blue-100 rounded-2xl">
                <div class="flex items-center justify-between">
                    <p class="font-bold text-slate-800 flex items-center gap-1.5">
                        <i class="fa-solid fa-images text-blue-600"></i> Hình ảnh sản phẩm
                        <span class="text-[10px] font-normal text-slate-500 ml-1">(để trống để giữ ảnh cũ, ảnh đầu tiên là ảnh đại diện)</span>
                    </p>
                    <span class="text-[10px] font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded-full" id="img-counter">
                        {{ count(array_filter($existingImages)) }}/6 ảnh
                    </span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3" id="image-slots-grid">
                    @for($i = 1; $i <= 6; $i++)
                    @php
                        $existImg = $existingImages[$i - 1] ?? '';
                        $existImgUrl = !empty($existImg) ? (preg_match('/^https?:\/\//i', $existImg) ? $existImg : BASE_URL . '/' . $existImg) : '';
                        $hasExistImg = !empty($existImg);
                    @endphp
                    <div class="image-slot relative rounded-2xl border-2 {{ $hasExistImg ? 'border-blue-300 border-solid has-image' : 'border-dashed border-slate-200' }} bg-white overflow-hidden transition duration-200 hover:border-emerald-400 group" data-slot="{{ $i }}">
                        <!-- Preview ảnh -->
                        <div class="aspect-square w-full bg-slate-50 relative overflow-hidden">
                            <img id="preview_{{ $i }}" src="{{ $existImgUrl }}" alt="" class="w-full h-full object-cover {{ $hasExistImg ? '' : 'hidden' }} transition duration-300">
                            <div id="placeholder_{{ $i }}" class="absolute inset-0 flex flex-col items-center justify-center text-slate-300 space-y-1.5 {{ $hasExistImg ? 'hidden' : '' }}">
                                <i class="fa-solid fa-image text-2xl"></i>
                                <span class="text-[10px] font-semibold">Ảnh {{ $i }}{{ $i === 1 ? ' (đại diện)' : '' }}</span>
                            </div>
                        </div>

                        <!-- Controls -->
                        <div class="p-2 space-y-1.5 border-t border-slate-100">
                            <label class="flex items-center gap-1.5 text-[10px] font-bold text-slate-600 cursor-pointer">
                                <i class="fa-solid fa-upload text-emerald-500"></i>
                                <span>Tải file lên</span>
                                <input type="file" name="image_file_{{ $i }}" id="image_file_{{ $i }}" accept="image/*" class="hidden image-file-input" data-slot="{{ $i }}">
                            </label>
                            <input type="text" name="image_url_{{ $i }}" id="image_url_{{ $i }}" value="{{ $existImg }}" placeholder="Hoặc dán link ảnh..." class="image-url-input w-full px-2 py-1.5 text-[10px] bg-slate-50 border border-slate-100 focus:border-emerald-400 outline-none rounded-lg transition" data-slot="{{ $i }}">
                        </div>

                        <!-- Badges -->
                        @if($i === 1)
                        <span class="absolute top-2 left-2 bg-emerald-500 text-white text-[9px] font-bold px-2 py-0.5 rounded-full z-10">Đại diện</span>
                        @else
                        <span class="absolute top-2 left-2 bg-blue-400 text-white text-[9px] font-bold px-2 py-0.5 rounded-full z-10 slot-badge {{ $hasExistImg ? '' : 'hidden' }}">Ảnh {{ $i }}</span>
                        @endif

                        <!-- Nút xóa ảnh -->
                        <button type="button" class="absolute top-2 right-2 w-6 h-6 bg-rose-100 text-rose-500 rounded-full {{ $hasExistImg ? 'flex' : 'hidden' }} items-center justify-center text-[9px] clear-slot-btn z-10" data-slot="{{ $i }}">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Mô tả chi tiết -->
            <div class="space-y-1.5">
                <label for="description" class="block">Mô tả sản phẩm</label>
                <textarea name="description" id="description" rows="4" placeholder="Nhập mô tả sản phẩm..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition resize-none">{{ $product['description'] }}</textarea>
            </div>

            <!-- Tác vụ nút -->
            <div class="flex items-center gap-4 pt-4 border-t border-slate-100 justify-end">
                <a href="{{ BASE_URL }}/admin/products" class="px-6 py-3 border border-slate-200 text-slate-500 rounded-2xl font-bold hover:bg-slate-50 transition">
                    HỦY BỎ
                </a>
                <button type="submit" class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold rounded-2xl transition shadow-md shadow-emerald-50 tracking-wider">
                    CẬP NHẬT SẢN PHẨM <i class="fa-solid fa-check ml-1"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleDiscountFields() {
        const isSale = document.getElementById('is_sale').checked;
        const discountSection = document.getElementById('discount_section');
        const origPrice = document.getElementById('original_price');
        const discountPct = document.getElementById('discount_percent');

        if (isSale) {
            discountSection.classList.remove('hidden');
            origPrice.setAttribute('required', 'required');
            discountPct.setAttribute('required', 'required');
        } else {
            discountSection.classList.add('hidden');
            origPrice.removeAttribute('required');
            discountPct.removeAttribute('required');
            origPrice.value = '';
            discountPct.value = '';
        }
    }

    // jQuery: Xử lý preview ảnh cho form chỉnh sửa
    $(document).ready(function () {
        var baseUrl = '{{ BASE_URL }}';

        function updateCounter() {
            var count = $('.image-slot.has-image').length;
            $('#img-counter').text(count + '/6 ảnh');
        }

        function showPreview(slot, src) {
            var $slot = $('.image-slot[data-slot="' + slot + '"]');
            $('#preview_' + slot).attr('src', src).removeClass('hidden');
            $('#placeholder_' + slot).addClass('hidden');
            $slot.addClass('has-image border-blue-300 border-solid').removeClass('border-dashed border-slate-200');
            $slot.find('.clear-slot-btn').addClass('flex').removeClass('hidden');
            $slot.find('.slot-badge').removeClass('hidden');
            updateCounter();
        }

        function clearSlot(slot) {
            var $slot = $('.image-slot[data-slot="' + slot + '"]');
            $('#preview_' + slot).attr('src', '').addClass('hidden');
            $('#placeholder_' + slot).removeClass('hidden');
            $slot.removeClass('has-image border-blue-300 border-solid').addClass('border-dashed border-slate-200');
            $slot.find('.clear-slot-btn').addClass('hidden').removeClass('flex');
            $slot.find('.slot-badge').addClass('hidden');
            $('#image_file_' + slot).val('');
            $('#image_url_' + slot).val('');
            updateCounter();
        }

        // File input: hiển thị preview từ file đã chọn
        $(document).on('change', '.image-file-input', function () {
            var slot = $(this).data('slot');
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function (e) { showPreview(slot, e.target.result); };
                reader.readAsDataURL(file);
                $('#image_url_' + slot).val('');
            }
        });

        // URL input: hiển thị preview từ đường dẫn đã nhập
        $(document).on('input', '.image-url-input', function () {
            var slot = $(this).data('slot');
            var url = $(this).val().trim();
            if (url) {
                var displayUrl = url.startsWith('http') ? url : baseUrl + '/' + url;
                showPreview(slot, displayUrl);
                $('#image_file_' + slot).val('');
            } else {
                clearSlot(slot);
            }
        });

        // Nút xóa ảnh
        $(document).on('click', '.clear-slot-btn', function (e) {
            e.preventDefault();
            var slot = $(this).data('slot');
            clearSlot(slot);
        });
    });
</script>
@endsection
