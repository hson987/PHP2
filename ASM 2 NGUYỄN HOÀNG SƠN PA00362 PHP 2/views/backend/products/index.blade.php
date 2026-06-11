@extends('layouts.main')

@section('title', 'Quản trị sản phẩm - Z DEMO')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb & Title -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <nav class="flex text-xs text-slate-400 items-center space-x-2">
                <a href="{{ BASE_URL }}/" class="hover:text-emerald-600 transition"><i class="fa-solid fa-house"></i> Trang chủ</a>
                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                <span class="text-slate-500 font-medium">Trang quản trị</span>
                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                <span class="text-slate-950 font-semibold">Danh sách sản phẩm</span>
            </nav>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="bg-blue-100 text-blue-600 rounded-xl p-2.5 text-sm"><i class="fa-solid fa-boxes-stacked"></i></span>
                Quản Lý Sản Phẩm
            </h1>
        </div>
        <div>
            <a href="{{ BASE_URL }}/admin/product/add" class="inline-flex items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-2xl transition shadow-md shadow-emerald-50">
                <i class="fa-solid fa-plus text-[10px]"></i> THÊM SẢN PHẨM MỚI
            </a>
        </div>
    </div>

    <!-- Admin Sub-navigation Menu -->
    <div class="flex border-b border-slate-200 gap-6 text-xs font-bold pt-2">
        <a href="{{ BASE_URL }}/admin/products" class="border-b-2 border-emerald-500 pb-3 text-emerald-600 flex items-center gap-2">
            <i class="fa-solid fa-boxes-stacked"></i> QUẢN LÝ SẢN PHẨM
        </a>
        <a href="{{ BASE_URL }}/admin/employees" class="text-slate-400 hover:text-emerald-600 pb-3 flex items-center gap-2 transition">
            <i class="fa-solid fa-users"></i> QUẢN LÝ NHÂN VIÊN
        </a>
        <a href="{{ BASE_URL }}/admin/articles" class="text-slate-400 hover:text-emerald-600 pb-3 flex items-center gap-2 transition">
            <i class="fa-solid fa-newspaper"></i> QUẢN LÝ BÀI VIẾT
        </a>
        <a href="{{ BASE_URL }}/admin/categories" class="text-slate-400 hover:text-emerald-600 pb-3 flex items-center gap-2 transition">
            <i class="fa-solid fa-tags"></i> QUẢN LÝ DANH MỤC
        </a>
    </div>

    <!-- Alert Success Notification -->
    @if(isset($_SESSION['admin_success']))
        <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl text-xs flex items-center justify-between gap-3 animate-fade-in shadow-xs">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-lg"></i>
                <span class="font-bold">{{ $_SESSION['admin_success'] }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @php unset($_SESSION['admin_success']); @endphp
    @endif

    <!-- Admin Dashboard Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1 -->
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shadow-inner"><i class="fa-solid fa-box"></i></div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tổng sản phẩm</p>
                <p class="text-xl font-black text-slate-800">{{ $totalProducts }}</p>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg shadow-inner"><i class="fa-solid fa-fire"></i></div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Đang Khuyến Mãi</p>
                <p class="text-xl font-black text-slate-800">{{ $saleProductsCount }}</p>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg shadow-inner"><i class="fa-solid fa-leaf"></i></div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sản Phẩm Thường</p>
                <p class="text-xl font-black text-slate-800">{{ $normalProductsCount }}</p>
            </div>
        </div>
        <!-- Card 4 -->
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg shadow-inner"><i class="fa-solid fa-tags"></i></div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Số Danh Mục</p>
                <p class="text-xl font-black text-slate-800">{{ $totalCategories }}</p>
            </div>
        </div>
    </div>

    <!-- Product Table Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-black text-slate-800">Tất Cả Sản Phẩm Có Trong Hệ Thống</h3>
            <span class="text-[10px] bg-slate-100 text-slate-500 font-bold px-2.5 py-1 rounded-full">Tổng số: {{ $totalProducts }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-[10px] font-bold uppercase tracking-wider border-b border-slate-100">
                        <th class="py-4 px-6 text-center">Mã ID</th>
                        <th class="py-4 px-6">Ảnh</th>
                        <th class="py-4 px-6">Tên sản phẩm</th>
                        <th class="py-4 px-6">Giá Bán / Giá Gốc</th>
                        <th class="py-4 px-6">Danh mục</th>
                        <th class="py-4 px-6">Phân loại</th>
                        <th class="py-4 px-6 text-center">Tác vụ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                    @if(count($products) == 0)
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i class="fa-solid fa-box-open text-3xl text-slate-200"></i>
                                    <p>Hệ thống hiện chưa có sản phẩm nào.</p>
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach($products as $p)
                            @php
                                $priceFormatted = number_format($p['price'], 0, ',', '.') . 'đ';
                                $originalPriceFormatted = !empty($p['original_price']) ? number_format($p['original_price'], 0, ',', '.') . 'đ' : '-';
                                
                                // Category color labels mappings
                                $catLabel = 'Khác';
                                $catClass = 'bg-slate-100 text-slate-600';
                                switch($p['category']) {
                                    case 'rau_cu':
                                        $catLabel = 'Rau củ quả';
                                        $catClass = 'bg-emerald-50 text-emerald-600 border border-emerald-100';
                                        break;
                                    case 'trai_cay':
                                        $catLabel = 'Trái cây';
                                        $catClass = 'bg-orange-50 text-orange-600 border border-orange-100';
                                        break;
                                    case 'nam':
                                        $catLabel = 'Nấm tươi';
                                        $catClass = 'bg-teal-50 text-teal-600 border border-teal-100';
                                        break;
                                    case 'thit_ca':
                                        $catLabel = 'Thịt, thủy hải sản';
                                        $catClass = 'bg-sky-50 text-sky-600 border border-sky-100';
                                        break;
                                    case 'dong_mat':
                                        $catLabel = 'Gia vị, đồ đóng hộp';
                                        $catClass = 'bg-pink-50 text-pink-600 border border-pink-100';
                                        break;
                                    case 'mi_lien':
                                        $catLabel = 'Mì gói, ăn liền';
                                        $catClass = 'bg-rose-50 text-rose-600 border border-rose-100';
                                        break;
                                    case 'gao_bot':
                                        $catLabel = 'Gạo, bột ngũ cốc';
                                        $catClass = 'bg-amber-50 text-amber-600 border border-amber-100';
                                        break;
                                }
                                
                                // Image check
                                $imgUrl = $p['image'];
                                if (!preg_match('/^https?:\/\//i', $imgUrl)) {
                                    $imgUrl = BASE_URL . '/' . $imgUrl;
                                }
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-center text-slate-400 font-mono text-[11px]">#{{ $p['id'] }}</td>
                                <td class="py-4 px-6">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                        <img src="{{ $imgUrl }}" alt="{{ $p['name'] }}" class="w-full h-full object-cover">
                                    </div>
                                </td>
                                <td class="py-4 px-6 max-w-xs">
                                    <p class="font-extrabold text-slate-800 line-clamp-1 hover:text-emerald-600 transition">{{ $p['name'] }}</p>
                                    @if(!empty($p['description']))
                                        <p class="text-[10px] text-slate-400 font-normal line-clamp-1 mt-0.5">{{ $p['description'] }}</p>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-rose-500 font-black">{{ $priceFormatted }}</span>
                                    @if(!empty($p['original_price']))
                                        <span class="text-[10px] text-slate-400 line-through block font-normal mt-0.5">Gốc: {{ $originalPriceFormatted }}</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-[10px] px-2.5 py-1 rounded-full font-bold {{ $catClass }}">{{ $catLabel }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    @if($p['is_sale'] == 1)
                                        <span class="inline-flex items-center gap-1.5 text-[10px] px-2.5 py-1 rounded-full font-bold bg-rose-50 text-rose-500 border border-rose-100">
                                            <i class="fa-solid fa-bolt text-[8px] animate-pulse"></i> SĂN SALE
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-[10px] px-2.5 py-1 rounded-full font-bold bg-blue-50 text-blue-500 border border-blue-100">
                                            THƯỜNG
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ BASE_URL }}/admin/product/edit/{{ $p['id'] }}" class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition" title="Chỉnh sửa">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        <a href="{{ BASE_URL }}/admin/product/delete/{{ $p['id'] }}" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này? Thao tác không thể hoàn tác!')" class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition" title="Xóa">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
