@extends('layouts.main')

@section('title', 'Quên mật khẩu - Z DEMO')

@section('content')
<div class="max-w-md mx-auto my-10">
    <!-- Card Container -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden p-6 md:p-8 space-y-6">
        
        <!-- Header -->
        <div class="text-center space-y-2">
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Quên mật khẩu?</h1>
            <p class="text-xs text-slate-400">Nhập email của bạn để nhận liên kết khôi phục mật khẩu</p>
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

        <!-- Localhost Reset Link Simulation Info -->
        @if(!empty($resetLink))
            <div class="p-4 bg-blue-50 border border-blue-100 text-slate-700 rounded-2xl text-xs space-y-3">
                <div class="flex items-center gap-2 text-blue-900 font-bold">
                    <i class="fa-solid fa-envelope-open-text text-base"></i>
                    <span>Hệ thống mô phỏng gửi Mail (Localhost):</span>
                </div>
                <p class="leading-relaxed text-[11px]">Đã tạo liên kết khôi phục mật khẩu thành công. Click vào nút dưới đây để đặt lại mật khẩu mới:</p>
                <a href="{{ $resetLink }}" class="block text-center py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition text-[11px] shadow-sm shadow-blue-100">
                    ĐẶT LẠI MẬT KHẨU NGAY <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        @endif

        <!-- Forgot Password Form -->
        <form action="{{ BASE_URL }}/forgot-password" method="POST" class="space-y-4 text-xs font-semibold text-slate-700">
            
            <div class="space-y-1.5">
                <label for="email" class="block">Nhập địa chỉ Email đã đăng ký</label>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-slate-400"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" id="email" required placeholder="example@domain.com" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm rounded-2xl transition shadow-md shadow-emerald-50 tracking-wide mt-2">
                GỬI YÊU CẦU KHÔI PHỤC
            </button>
        </form>

        <!-- Footer Info -->
        <div class="text-center text-slate-400 text-[11px] pt-2 border-t border-slate-100 flex justify-between">
            <a href="{{ BASE_URL }}/login" class="text-emerald-600 font-bold hover:underline flex items-center gap-1"><i class="fa-solid fa-arrow-left"></i> Quay lại đăng nhập</a>
            <a href="{{ BASE_URL }}/register" class="text-slate-500 hover:text-emerald-600 font-bold transition">Tạo tài khoản</a>
        </div>
    </div>
</div>
@endsection
