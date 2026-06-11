@extends('layouts.main')

@section('title', 'Đăng nhập - Z DEMO')

@section('content')
<div class="max-w-md mx-auto my-10">
    <!-- Card Container -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden p-6 md:p-8 space-y-6">
        
        <!-- Header -->
        <div class="text-center space-y-2">
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Chào mừng quay lại!</h1>
            <p class="text-xs text-slate-400">Đăng nhập tài khoản để tiếp tục mua sắm tại Z DEMO</p>
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

        <!-- Role Tab Selector -->
        <div class="bg-slate-50 p-1.5 rounded-2xl flex border border-slate-100">
            <button type="button" onclick="selectRole('user')" id="btn-tab-user" class="w-1/2 py-2.5 text-xs font-bold rounded-xl transition duration-200 bg-white text-emerald-600 shadow-sm border border-slate-100">
                <i class="fa-solid fa-user mr-1.5"></i> Khách hàng
            </button>
            <button type="button" onclick="selectRole('admin')" id="btn-tab-admin" class="w-1/2 py-2.5 text-xs font-bold rounded-xl transition duration-200 text-slate-400 hover:text-slate-700">
                <i class="fa-solid fa-user-shield mr-1.5"></i> Quản trị viên
            </button>
        </div>

        <!-- Login Form -->
        <form action="{{ BASE_URL }}/login" method="POST" class="space-y-4 text-xs font-semibold text-slate-700">
            <!-- Hidden Role Input -->
            <input type="hidden" name="role" id="input-role" value="user">

            <div class="space-y-1.5">
                <label for="email" class="block">Địa chỉ Email</label>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-slate-400"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" id="email" required placeholder="example@domain.com" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition">
                </div>
            </div>

            <div class="space-y-1.5">
                <div class="flex justify-between items-center">
                    <label for="password" class="block">Mật khẩu</label>
                    <a href="{{ BASE_URL }}/forgot-password" class="text-[11px] text-emerald-600 hover:text-emerald-700 transition">Quên mật khẩu?</a>
                </div>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-slate-400"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 outline-none rounded-2xl transition">
                </div>
            </div>

            <!-- Login Button -->
            <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm rounded-2xl transition shadow-md shadow-emerald-50 tracking-wide mt-2">
                ĐĂNG NHẬP NGAY
            </button>
        </form>

        <!-- Footer Info -->
        <div class="text-center text-slate-400 text-[11px] pt-2 border-t border-slate-100">
            Chưa có tài khoản khách hàng? 
            <a href="{{ BASE_URL }}/register" class="text-emerald-600 font-bold hover:underline">Đăng ký tại đây</a>
        </div>

        <!-- Quick Demo login credentials helper -->
        <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-4 text-[10px] text-slate-500 leading-relaxed space-y-1">
            <p class="font-bold text-blue-900 flex items-center"><i class="fa-solid fa-circle-info mr-1.5 text-xs"></i> Tài khoản chạy thử nghiệm (Demo):</p>
            <p><span class="font-semibold text-slate-700">Khách hàng:</span> <code class="bg-white px-1.5 py-0.5 rounded border border-slate-200">son@fpt.edu.vn</code> / mật khẩu <code class="bg-white px-1.5 py-0.5 rounded border border-slate-200">123456</code></p>
            <p><span class="font-semibold text-slate-700">Quản trị viên:</span> <code class="bg-white px-1.5 py-0.5 rounded border border-slate-200">admin@fpt.edu.vn</code> / mật khẩu <code class="bg-white px-1.5 py-0.5 rounded border border-slate-200">123456</code></p>
        </div>
    </div>
</div>

<script>
    function selectRole(role) {
        const btnUser = document.getElementById('btn-tab-user');
        const btnAdmin = document.getElementById('btn-tab-admin');
        const inputRole = document.getElementById('input-role');

        if (role === 'admin') {
            btnAdmin.className = 'w-1/2 py-2.5 text-xs font-bold rounded-xl transition duration-200 bg-white text-emerald-600 shadow-sm border border-slate-100';
            btnUser.className = 'w-1/2 py-2.5 text-xs font-bold rounded-xl transition duration-200 text-slate-400 hover:text-slate-700';
            inputRole.value = 'admin';
        } else {
            btnUser.className = 'w-1/2 py-2.5 text-xs font-bold rounded-xl transition duration-200 bg-white text-emerald-600 shadow-sm border border-slate-100';
            btnAdmin.className = 'w-1/2 py-2.5 text-xs font-bold rounded-xl transition duration-200 text-slate-400 hover:text-slate-700';
            inputRole.value = 'user';
        }
    }
</script>
@endsection
