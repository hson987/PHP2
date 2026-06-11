@extends('layouts.main')
@section('title', 'Quản lý Bài Viết - Admin Z DEMO')
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
                <span class="text-slate-950 font-semibold">Danh sách bài viết</span>
            </nav>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="bg-blue-100 text-blue-600 rounded-xl p-2.5 text-sm"><i class="fa-solid fa-newspaper"></i></span>
                Quản Lý Bài Viết
            </h1>
        </div>
        <div>
            <a href="{{ BASE_URL }}/admin/article/add" class="inline-flex items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-2xl transition shadow-md shadow-emerald-50">
                <i class="fa-solid fa-plus text-[10px]"></i> THÊM BÀI VIẾT MỚI
            </a>
        </div>
    </div>

    <!-- Admin Sub-navigation Menu -->
    <div class="flex border-b border-slate-200 gap-6 text-xs font-bold pt-2">
        <a href="{{ BASE_URL }}/admin/products" class="text-slate-400 hover:text-emerald-600 pb-3 flex items-center gap-2 transition">
            <i class="fa-solid fa-boxes-stacked"></i> QUẢN LÝ SẢN PHẨM
        </a>
        <a href="{{ BASE_URL }}/admin/employees" class="text-slate-400 hover:text-emerald-600 pb-3 flex items-center gap-2 transition">
            <i class="fa-solid fa-users"></i> QUẢN LÝ NHÂN VIÊN
        </a>
        <a href="{{ BASE_URL }}/admin/articles" class="border-b-2 border-emerald-500 pb-3 text-emerald-600 flex items-center gap-2">
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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Card 1: Tổng số bài viết -->
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shadow-inner">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tổng số bài viết</p>
                <p class="text-2xl font-black text-slate-800 leading-none mt-1">{{ count($articles) }}</p>
            </div>
        </div>

        <!-- Card 2: Bài viết mới nhất -->
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex items-center gap-4 md:col-span-2">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg shadow-inner">
                <i class="fa-solid fa-bolt"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bài viết mới nhất</p>
                <p class="text-sm font-bold text-slate-800 truncate mt-1">
                    @if(count($articles) > 0)
                        {{ $articles[0]['title'] }}
                    @else
                        Chưa có bài viết nào
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        @if(count($articles) === 0)
        <div class="py-20 text-center text-slate-400">
            <i class="fa-solid fa-newspaper text-5xl mb-4"></i>
            <p class="text-lg font-bold">Chưa có bài viết nào</p>
            <p class="text-sm mt-1">Nhấn "Thêm bài viết" để bắt đầu</p>
        </div>
        @else
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 text-left w-12">#</th>
                    <th class="px-4 py-4 text-left w-20">Ảnh</th>
                    <th class="px-4 py-4 text-left">Tiêu đề</th>
                    <th class="px-4 py-4 text-left hidden md:table-cell">Mô tả</th>
                    <th class="px-4 py-4 text-left hidden lg:table-cell">Ngày tạo</th>
                    <th class="px-6 py-4 text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($articles as $article)
                @php
                    $imgUrl = !empty($article['image'])
                        ? (preg_match('/^https?:\/\//i', $article['image']) ? $article['image'] : BASE_URL . '/' . $article['image'])
                        : BASE_URL . '/uploads/article_1.jpg';
                @endphp
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-slate-400 font-mono text-xs">{{ $article['id'] }}</td>
                    <td class="px-4 py-4">
                        <div class="w-16 h-12 rounded-lg overflow-hidden bg-slate-100 border border-slate-200">
                            <img src="{{ $imgUrl }}" alt="" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <p class="font-bold text-slate-800 line-clamp-2 max-w-xs">{{ $article['title'] }}</p>
                    </td>
                    <td class="px-4 py-4 hidden md:table-cell">
                        <p class="text-slate-500 text-xs line-clamp-2 max-w-sm">{{ $article['description'] }}</p>
                    </td>
                    <td class="px-4 py-4 hidden lg:table-cell text-slate-400 text-xs whitespace-nowrap">
                        {{ date('d/m/Y', strtotime($article['created_at'])) }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ BASE_URL }}/news/{{ $article['id'] }}" target="_blank"
                               class="p-2 rounded-lg text-slate-500 hover:text-sky-600 hover:bg-sky-50 transition" title="Xem">
                                <i class="fa-solid fa-eye text-xs"></i>
                            </a>
                            <a href="{{ BASE_URL }}/admin/article/edit/{{ $article['id'] }}"
                               class="p-2 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 transition" title="Sửa">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <a href="{{ BASE_URL }}/admin/article/delete/{{ $article['id'] }}"
                               onclick="return confirm('Bạn có chắc muốn xóa bài viết này không?')"
                               class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition" title="Xóa">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
