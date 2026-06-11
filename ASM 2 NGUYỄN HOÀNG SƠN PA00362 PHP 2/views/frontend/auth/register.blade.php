@extends('layouts.main')

@section('title', 'Đăng ký tài khoản - Z DEMO')

@section('content')
<div class="max-w-md mx-auto my-10">
    <!-- Card Container -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden p-6 md:p-8 space-y-6">
        
        <!-- Header -->
        <div class="text-center space-y-2">
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Tạo tài khoản mới</h1>
            <p class="text-xs text-slate-400">Đăng ký tài khoản khách hàng để nhận nhiều ưu đãi mua sắm</p>
            <div class="h-1 w-12 bg-emerald-500 rounded-full mx-auto mt-2"></div>
        </div>

        <!-- Alerts -->
        @if(!empty($error))
            <div class="p-4 bg-rose-50 border border-rose-100 text-rose-600 rounded-2xl text-xs flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation text-lg"></i>
                <span>{{ $error }}</span>
            </div>
        @endif

        @if(!empty($success))
            <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl text-xs flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-lg"></i>
                <span>{{ $success }}</span>
            </div>
        @endif

        <!-- Register Form -->
        <form action="{{ BASE_URL }}/register" method="POST" class="space-y-4 text-xs font-semibold text-slate-700">
            
            <div class="space-y-1.5">
                <label for="fullname" class="block">Họ và tên</label>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-slate-400"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="fullname" id="fullname" required placeholder="Ví dụ: Nguyễn Hoàng Sơn" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition">
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="email" class="block">Địa chỉ Email</label>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-slate-400"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" id="email" required placeholder="example@domain.com" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition">
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="password" class="block">Mật khẩu</label>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-slate-400"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="password" required placeholder="Tối thiểu 6 ký tự" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition">
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="confirm_password" class="block">Nhập lại mật khẩu</label>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-slate-400"><i class="fa-solid fa-shield-halved"></i></span>
                    <input type="password" name="confirm_password" id="confirm_password" required placeholder="Trùng khớp với mật khẩu trên" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition">
                </div>
            </div>

            <!-- Register Button -->
            <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm rounded-2xl transition shadow-md shadow-emerald-50 tracking-wide mt-2">
                ĐĂNG KÝ TÀI KHOẢN
            </button>
        </form>

        <!-- Footer Info -->
        <div class="text-center text-slate-400 text-[11px] pt-2 border-t border-slate-100">
            Đã có tài khoản? 
            <a href="{{ BASE_URL }}/login" class="text-emerald-600 font-bold hover:underline">Đăng nhập ngay</a>
        </div>
    </div>
</div>
@endsection
