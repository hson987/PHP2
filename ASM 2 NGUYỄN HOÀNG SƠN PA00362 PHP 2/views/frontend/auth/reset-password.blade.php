@extends('layouts.main')

@section('title', 'Đặt lại mật khẩu - Z DEMO')

@section('content')
<div class="max-w-md mx-auto my-10">
    <!-- Card Container -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden p-6 md:p-8 space-y-6">
        
        <!-- Header -->
        <div class="text-center space-y-2">
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Đặt lại mật khẩu</h1>
            <p class="text-xs text-slate-400">Thiết lập mật khẩu mới cho tài khoản của bạn</p>
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
            <div class="text-center pt-2">
                <a href="{{ BASE_URL }}/login" class="inline-block px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition shadow-md shadow-emerald-50">
                    Đăng nhập ngay
                </a>
            </div>
        @endif

        <!-- Reset Password Form -->
        @if($userValid && empty($success))
            <form action="{{ BASE_URL }}/reset-password" method="POST" class="space-y-4 text-xs font-semibold text-slate-700">
                <!-- Hidden Token Input -->
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="space-y-1.5">
                    <label for="password" class="block">Mật khẩu mới</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-slate-400"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" id="password" required placeholder="Tối thiểu 6 ký tự" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="confirm_password" class="block">Nhập lại mật khẩu mới</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-slate-400"><i class="fa-solid fa-shield-halved"></i></span>
                        <input type="password" name="confirm_password" id="confirm_password" required placeholder="Trùng khớp với mật khẩu mới trên" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm rounded-2xl transition shadow-md shadow-emerald-50 tracking-wide mt-2">
                    LƯU MẬT KHẨU MỚI
                </button>
            </form>
        @elseif(!$userValid)
            <div class="text-center space-y-4 py-4">
                <p class="text-xs text-slate-400 leading-relaxed">Bạn có thể yêu cầu gửi lại liên kết khôi phục mật khẩu khác để tiếp tục.</p>
                <a href="{{ BASE_URL }}/forgot-password" class="inline-block px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition border border-slate-200">
                    Yêu cầu lại liên kết
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
