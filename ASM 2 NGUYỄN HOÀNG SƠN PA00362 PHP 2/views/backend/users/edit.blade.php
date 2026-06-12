@extends('layouts.main')

@section('title', 'Sửa tài khoản - Z DEMO')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="space-y-1">
        <nav class="flex text-xs text-slate-400 items-center space-x-2">
            <a href="{{ BASE_URL }}/" class="hover:text-emerald-600 transition"><i class="fa-solid fa-house"></i> Trang chủ</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <a href="{{ BASE_URL }}/admin/users" class="hover:text-emerald-600 transition">Quản lý tài khoản</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <span class="text-slate-950 font-semibold">Sửa thông tin tài khoản</span>
        </nav>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
            <span class="bg-amber-50 text-amber-600 rounded-xl p-2.5 text-sm"><i class="fa-solid fa-user-pen"></i></span>
            Sửa Tài Khoản #{{ $user['id'] }}
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
        <form action="{{ BASE_URL }}/admin/user/edit/{{ $user['id'] }}" method="POST" class="space-y-5 text-xs font-semibold text-slate-700">
            
            <!-- Họ và tên -->
            <div class="space-y-1.5">
                <label for="fullname" class="block">Họ và tên người dùng <span class="text-rose-500">*</span></label>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-slate-400"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="fullname" id="fullname" required value="{{ htmlspecialchars($user['fullname']) }}" placeholder="Nhập họ và tên đầy đủ" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition">
                </div>
            </div>

            <!-- Email đăng nhập -->
            <div class="space-y-1.5">
                <label for="email" class="block">Địa chỉ Email đăng nhập <span class="text-rose-500">*</span></label>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-slate-400"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" id="email" required value="{{ htmlspecialchars($user['email']) }}" placeholder="user@example.com" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition">
                </div>
            </div>

            <!-- Mật khẩu mới (Không bắt buộc) -->
            <div class="space-y-1.5">
                <label for="password" class="block">Mật khẩu mới <span class="text-slate-400 font-normal">(Để trống nếu không muốn đổi mật khẩu)</span></label>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-slate-400"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="password" placeholder="Nhập mật khẩu mới (tối thiểu 6 ký tự)" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition">
                </div>
            </div>

            <!-- Vai trò (Role) -->
            <div class="space-y-1.5">
                <label for="role" class="block">Vai trò / Phân quyền <span class="text-rose-500">*</span></label>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-slate-400"><i class="fa-solid fa-shield-halved"></i></span>
                    <select name="role" id="role" required class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition appearance-none cursor-pointer">
                        <option value="user" {{ $user['role'] === 'user' ? 'selected' : '' }}>Khách hàng (User)</option>
                        <option value="staff" {{ $user['role'] === 'staff' ? 'selected' : '' }}>Nhân viên (Staff)</option>
                        <option value="admin" {{ $user['role'] === 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                    </select>
                    <span class="absolute right-4 text-slate-400 pointer-events-none"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
            </div>

            <!-- Tác vụ nút -->
            <div class="flex items-center gap-4 pt-4 border-t border-slate-100 justify-end">
                <a href="{{ BASE_URL }}/admin/users" class="px-6 py-3 border border-slate-200 text-slate-500 rounded-2xl font-bold hover:bg-slate-50 transition">
                    HỦY BỎ
                </a>
                <button type="submit" class="px-8 py-3 bg-amber-500 hover:bg-amber-600 text-white font-extrabold rounded-2xl transition shadow-md shadow-amber-50 tracking-wider">
                    LƯU THAY ĐỔI <i class="fa-solid fa-check ml-1"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
