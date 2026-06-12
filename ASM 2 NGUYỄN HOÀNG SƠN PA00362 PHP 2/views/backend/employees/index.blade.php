@extends('layouts.main')

@section('title', 'Quản lý nhân viên - Z DEMO')

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
                <span class="text-slate-950 font-semibold">Danh sách nhân viên</span>
            </nav>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="bg-blue-100 text-blue-600 rounded-xl p-2.5 text-sm"><i class="fa-solid fa-users-gear"></i></span>
                Quản Lý Nhân Viên
            </h1>
        </div>
        <div>
            <a href="{{ BASE_URL }}/admin/employee/add" class="inline-flex items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-2xl transition shadow-md shadow-emerald-50">
                <i class="fa-solid fa-plus text-[10px]"></i> THÊM NHÂN VIÊN MỚI
            </a>
        </div>
    </div>

    <!-- Admin Sub-navigation Menu -->
    <div class="flex border-b border-slate-200 gap-6 text-xs font-bold pt-2 overflow-x-auto whitespace-nowrap">
        <a href="{{ BASE_URL }}/admin/products" class="text-slate-400 hover:text-emerald-600 pb-3 flex items-center gap-2 transition">
            <i class="fa-solid fa-boxes-stacked"></i> QUẢN LÝ SẢN PHẨM
        </a>
        <a href="{{ BASE_URL }}/admin/employees" class="border-b-2 border-emerald-500 pb-3 text-emerald-600 flex items-center gap-2">
            <i class="fa-solid fa-users"></i> QUẢN LÝ NHÂN VIÊN
        </a>
        <a href="{{ BASE_URL }}/admin/articles" class="text-slate-400 hover:text-emerald-600 pb-3 flex items-center gap-2 transition">
            <i class="fa-solid fa-newspaper"></i> QUẢN LÝ BÀI VIẾT
        </a>
        <a href="{{ BASE_URL }}/admin/categories" class="text-slate-400 hover:text-emerald-600 pb-3 flex items-center gap-2 transition">
            <i class="fa-solid fa-tags"></i> QUẢN LÝ DANH MỤC
        </a>
        <a href="{{ BASE_URL }}/admin/users" class="text-slate-400 hover:text-emerald-600 pb-3 flex items-center gap-2 transition">
            <i class="fa-solid fa-user-shield"></i> QUẢN LÝ TÀI KHOẢN
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
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shadow-inner"><i class="fa-solid fa-user-tie"></i></div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tổng số nhân viên</p>
                <p class="text-xl font-black text-slate-800">{{ $totalEmployees }}</p>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg shadow-inner"><i class="fa-solid fa-circle-check"></i></div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Trạng thái làm việc</p>
                <p class="text-xl font-black text-slate-800">Đang hoạt động</p>
            </div>
        </div>
    </div>

    <!-- Employees Table Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-black text-slate-800">Danh Sách Tài Khoản Nhân Viên</h3>
            <span class="text-[10px] bg-slate-100 text-slate-500 font-bold px-2.5 py-1 rounded-full">Tổng số: {{ $totalEmployees }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-[10px] font-bold uppercase tracking-wider border-b border-slate-100">
                        <th class="py-4 px-6 text-center">Mã ID</th>
                        <th class="py-4 px-6">Họ và tên</th>
                        <th class="py-4 px-6">Email nhân viên</th>
                        <th class="py-4 px-6">Vai trò</th>
                        <th class="py-4 px-6">Ngày khởi tạo</th>
                        <th class="py-4 px-6 text-center">Tác vụ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                    @if(count($employees) == 0)
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i class="fa-solid fa-user-slash text-3xl text-slate-200"></i>
                                    <p>Chưa có tài khoản nhân viên nào trong hệ thống.</p>
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach($employees as $e)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-center text-slate-400 font-mono text-[11px]">#{{ $e['id'] }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                                            {{ mb_substr($e['fullname'], 0, 1) }}
                                        </div>
                                        <span class="font-extrabold text-slate-800">{{ $e['fullname'] }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-mono text-slate-600 text-[11px]">{{ $e['email'] }}</td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center gap-1 text-[10px] px-2.5 py-1 rounded-full font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                        <i class="fa-solid fa-user-tie text-[9px]"></i> Nhân Viên Bán Hàng
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-slate-400 font-normal">{{ date('d/m/Y H:i', strtotime($e['created_at'])) }}</td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ BASE_URL }}/admin/employee/edit/{{ $e['id'] }}" class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition" title="Chỉnh sửa">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        <a href="{{ BASE_URL }}/admin/employee/delete/{{ $e['id'] }}" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản nhân viên này? Thao tác không thể hoàn tác!')" class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition" title="Xóa">
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
