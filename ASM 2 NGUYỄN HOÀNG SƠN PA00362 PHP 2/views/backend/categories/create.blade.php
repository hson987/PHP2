@extends('layouts.main')
@section('title', 'Thêm Danh mục - Admin Z DEMO')
@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-slate-500 items-center space-x-2">
        <a href="{{ BASE_URL }}/admin/categories" class="hover:text-emerald-600 transition"><i class="fa-solid fa-tags"></i> Danh mục</a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
        <span class="text-slate-900 font-medium">Thêm danh mục</span>
    </nav>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
        <h1 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-2">
            <span class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm"><i class="fa-solid fa-plus"></i></span>
            Thêm danh mục mới
        </h1>

        @if($error)
        <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl px-5 py-3 text-sm font-semibold flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i> {{ $error }}
        </div>
        @endif

        <form method="POST" action="{{ BASE_URL }}/admin/category/add" class="space-y-6">

            <!-- Mã danh mục -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Mã danh mục (Code) <span class="text-rose-500">*</span></label>
                <input type="text" name="code" required
                       value="{{ $_POST['code'] ?? '' }}"
                       placeholder="Ví dụ: rau_cu, trai_cay, dong_mat..."
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition font-mono">
                <p class="text-[10px] text-slate-400 mt-1.5 leading-relaxed">
                    * Viết thường không dấu, không khoảng trắng, chỉ dùng chữ cái, chữ số và dấu gạch dưới `_`. Đây là mã dùng làm khóa liên kết với sản phẩm.
                </p>
            </div>

            <!-- Tên danh mục -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Tên danh mục (Name) <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required
                       value="{{ $_POST['name'] ?? '' }}"
                       placeholder="Ví dụ: Rau củ sạch Đà Lạt..."
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition">
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-grow py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Lưu danh mục
                </button>
                <a href="{{ BASE_URL }}/admin/categories" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-sm transition flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
