@extends('layouts.main')
@section('title', 'Quản lý Danh mục - Admin Z DEMO')
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
                <span class="text-slate-950 font-semibold">Danh sách danh mục</span>
            </nav>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="bg-blue-100 text-blue-600 rounded-xl p-2.5 text-sm"><i class="fa-solid fa-tags"></i></span>
                Quản Lý Danh Mục
            </h1>
        </div>
        <div>
            <a href="{{ BASE_URL }}/admin/category/add" class="inline-flex items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-2xl transition shadow-md shadow-emerald-50">
                <i class="fa-solid fa-plus text-[10px]"></i> THÊM DANH MỤC MỚI
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
        <a href="{{ BASE_URL }}/admin/articles" class="text-slate-400 hover:text-emerald-600 pb-3 flex items-center gap-2 transition">
            <i class="fa-solid fa-newspaper"></i> QUẢN LÝ BÀI VIẾT
        </a>
        <a href="{{ BASE_URL }}/admin/categories" class="border-b-2 border-emerald-500 pb-3 text-emerald-600 flex items-center gap-2">
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
        <!-- Card 1: Tổng số danh mục -->
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shadow-inner">
                <i class="fa-solid fa-tags"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tổng số danh mục</p>
                <p class="text-2xl font-black text-slate-800 leading-none mt-1">{{ count($categories) }}</p>
            </div>
        </div>

        <!-- Card 2: Dữ liệu động -->
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex items-center gap-4 md:col-span-2">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg shadow-inner">
                <i class="fa-solid fa-circle-info"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Trạng thái CSDL</p>
                <p class="text-xs font-bold text-slate-800 mt-1 leading-relaxed text-slate-500">
                    Danh mục được load động từ bảng `categories` và liên kết với trường `category` trong bảng sản phẩm.
                </p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        @if(count($categories) === 0)
        <div class="py-20 text-center text-slate-400">
            <i class="fa-solid fa-tags text-5xl mb-4"></i>
            <p class="text-lg font-bold">Chưa có danh mục nào</p>
            <p class="text-sm mt-1">Nhấn "Thêm danh mục" để bắt đầu</p>
        </div>
        @else
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 text-left w-20"># ID</th>
                    <th class="px-6 py-4 text-left">Mã Danh Mục (Code)</th>
                    <th class="px-6 py-4 text-left">Tên Danh Mục (Name)</th>
                    <th class="px-6 py-4 text-left hidden md:table-cell">Ngày tạo</th>
                    <th class="px-6 py-4 text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($categories as $cat)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-slate-400 font-mono text-xs">{{ $cat['id'] }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-slate-100 text-slate-600 font-mono">{{ $cat['code'] }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-800">{{ $cat['name'] }}</p>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell text-slate-400 text-xs whitespace-nowrap">
                        {{ date('d/m/Y', strtotime($cat['created_at'])) }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ BASE_URL }}/admin/category/edit/{{ $cat['id'] }}"
                               class="p-2 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 transition" title="Sửa">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <a href="{{ BASE_URL }}/admin/category/delete/{{ $cat['id'] }}"
                               onclick="return confirm('Bạn có chắc muốn xóa danh mục này không? Các sản phẩm thuộc danh mục này sẽ giữ nguyên mã nhưng không còn danh mục này trong quản trị.')"
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
