@extends('layouts.main')

@section('title', 'Quản lý tài khoản - Z DEMO')

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
                <span class="text-slate-950 font-semibold">Danh sách tài khoản</span>
            </nav>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="bg-blue-100 text-blue-600 rounded-xl p-2.5 text-sm"><i class="fa-solid fa-user-gear"></i></span>
                Quản Lý Tài Khoản
            </h1>
        </div>
        <div>
            <a href="{{ BASE_URL }}/admin/user/add" class="inline-flex items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-2xl transition shadow-md shadow-emerald-50">
                <i class="fa-solid fa-plus text-[10px]"></i> THÊM TÀI KHOẢN MỚI
            </a>
        </div>
    </div>

    <!-- Admin Sub-navigation Menu -->
    <div class="flex border-b border-slate-200 gap-6 text-xs font-bold pt-2 overflow-x-auto whitespace-nowrap">
        <a href="{{ BASE_URL }}/admin/products" class="text-slate-400 hover:text-emerald-600 pb-3 flex items-center gap-2 transition">
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
        <a href="{{ BASE_URL }}/admin/users" class="border-b-2 border-emerald-500 pb-3 text-emerald-600 flex items-center gap-2">
            <i class="fa-solid fa-user-shield"></i> QUẢN LÝ TÀI KHOẢN
        </a>
    </div>

    <!-- Alert Notifications -->
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

    @if(isset($_SESSION['admin_error']))
        <div class="p-4 bg-rose-50 border border-rose-100 text-rose-600 rounded-2xl text-xs flex items-center justify-between gap-3 animate-fade-in shadow-xs">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation text-lg"></i>
                <span class="font-bold">{{ $_SESSION['admin_error'] }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-600 transition"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @php unset($_SESSION['admin_error']); @endphp
    @endif

    <!-- Admin Dashboard Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1 -->
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-600 flex items-center justify-center text-lg shadow-inner"><i class="fa-solid fa-users"></i></div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tổng tài khoản</p>
                <p class="text-xl font-black text-slate-800">{{ $totalUsers }}</p>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg shadow-inner"><i class="fa-solid fa-user-shield"></i></div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Quản trị viên (Admin)</p>
                <p class="text-xl font-black text-slate-800">{{ $adminCount }}</p>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg shadow-inner"><i class="fa-solid fa-user-tie"></i></div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nhân viên (Staff)</p>
                <p class="text-xl font-black text-slate-800">{{ $staffCount }}</p>
            </div>
        </div>
        <!-- Card 4 -->
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shadow-inner"><i class="fa-solid fa-user"></i></div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Khách hàng (User)</p>
                <p class="text-xl font-black text-slate-800">{{ $customerCount }}</p>
            </div>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-black text-slate-800">Danh Sách Toàn Bộ Tài Khoản Hệ Thống</h3>
            <span class="text-[10px] bg-slate-100 text-slate-500 font-bold px-2.5 py-1 rounded-full">Tổng số: {{ $totalUsers }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-[10px] font-bold uppercase tracking-wider border-b border-slate-100">
                        <th class="py-4 px-6 text-center">ID</th>
                        <th class="py-4 px-6">Họ và tên</th>
                        <th class="py-4 px-6">Email đăng nhập</th>
                        <th class="py-4 px-6">Vai trò</th>
                        <th class="py-4 px-6">Ngày tạo</th>
                        <th class="py-4 px-6 text-center">Tác vụ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                    @if(count($users) == 0)
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i class="fa-solid fa-users text-4xl text-slate-200"></i>
                                    <p class="text-sm font-bold text-slate-400">Không tìm thấy tài khoản nào trong hệ thống</p>
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach($users as $u)
                            <tr class="hover:bg-slate-50/80 transition duration-150">
                                <td class="py-4 px-6 text-center font-mono text-slate-400 text-[11px]">#{{ $u['id'] }}</td>
                                <td class="py-4 px-6 font-bold text-slate-900">{{ $u['fullname'] }}</td>
                                <td class="py-4 px-6 text-slate-500 font-mono">{{ $u['email'] }}</td>
                                <td class="py-4 px-6">
                                    @if($u['role'] === 'admin')
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-rose-50 text-rose-600 border border-rose-100 inline-flex items-center gap-1 shadow-xs">
                                            <i class="fa-solid fa-user-shield text-[9px]"></i> QUẢN TRỊ
                                        </span>
                                    @elseif($u['role'] === 'staff')
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-600 border border-blue-100 inline-flex items-center gap-1 shadow-xs">
                                            <i class="fa-solid fa-user-tie text-[9px]"></i> NHÂN VIÊN
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200 inline-flex items-center gap-1">
                                            <i class="fa-solid fa-user text-[9px]"></i> KHÁCH HÀNG
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-slate-400 font-medium whitespace-nowrap">{{ date('d/m/Y H:i', strtotime($u['created_at'])) }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ BASE_URL }}/admin/user/edit/{{ $u['id'] }}" class="p-2 rounded-xl text-slate-400 hover:text-amber-600 hover:bg-amber-50 border border-transparent hover:border-amber-100 transition duration-150" title="Chỉnh sửa">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>
                                        @if(isset($_SESSION['admin']) && $_SESSION['admin']['id'] == $u['id'])
                                            <span class="p-2 rounded-xl text-slate-300 cursor-not-allowed border border-transparent" title="Không thể tự xóa chính mình">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </span>
                                        @else
                                            <a href="{{ BASE_URL }}/admin/user/delete/{{ $u['id'] }}" onclick="return confirm('Bạn có chắc muốn xóa tài khoản này không? Hành động này không thể hoàn tác!')" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition duration-150" title="Xóa tài khoản">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </a>
                                        @endif
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
