@extends('layouts.main')

@section('title', 'Giới thiệu - Bán Hàng 11 / Z DEMO')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-slate-500 items-center space-x-2">
        <a href="{{ BASE_URL }}/" class="hover:text-emerald-600 transition"><i class="fa-solid fa-house"></i> Trang chủ</a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
        <span class="text-slate-950 font-medium">Giới thiệu</span>
    </nav>

    <!-- Main About Container -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-6 md:p-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            
            <!-- Left Side: Text Content -->
            <div class="lg:col-span-8 space-y-6">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight flex items-center">
                        <span class="bg-emerald-100 text-emerald-600 rounded-lg p-2 mr-3 text-sm"><i class="fa-solid fa-circle-info"></i></span>
                        Giới thiệu
                    </h1>
                    <div class="h-1 w-16 bg-emerald-500 rounded-full mt-3"></div>
                </div>

                <p class="text-sm text-slate-600 leading-relaxed font-medium">
                    Chào mừng bạn đến với cửa hàng trực tuyến <strong class="text-emerald-600 font-bold">"Bán Hàng 11"</strong> - nơi bạn có thể tìm thấy đủ loại đồ ăn và thực phẩm giống như bạn thấy trong siêu thị mà không cần phải ra khỏi nhà! Với mục tiêu mang lại sự tiện lợi và lựa chọn đa dạng cho khách hàng của chúng tôi, chúng tôi tự hào là điểm đến ưa thích cho nhu cầu mua sắm hàng ngày của bạn.
                </p>

                <div class="space-y-4">
                    <!-- Section 1 -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition duration-200 flex gap-3.5">
                        <span class="text-emerald-600 text-lg mt-0.5"><i class="fa-solid fa-basket-shopping"></i></span>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-800">Sản Phẩm Đa Dạng</h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Chúng tôi cung cấp một loạt đồ ăn và thực phẩm đa dạng, từ các loại rau củ quả tươi ngon, thực phẩm đóng gói, đến các mặt hàng gia vị và thực phẩm đông lạnh. Bạn sẽ tìm thấy mọi thứ bạn cần để chuẩn bị bữa ăn tại nhà hoặc dự định một buổi tiệc đầy ấn tượng.
                            </p>
                        </div>
                    </div>

                    <!-- Section 2 -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition duration-200 flex gap-3.5">
                        <span class="text-emerald-600 text-lg mt-0.5"><i class="fa-solid fa-shield-halved"></i></span>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-800">Chất Lượng Đảm Bảo</h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Chất lượng luôn là ưu tiên hàng đầu của chúng tôi. Chúng tôi luôn lựa chọn các sản phẩm từ các nhà cung cấp uy tín để đảm bảo rằng bạn luôn nhận được sản phẩm tươi ngon và an toàn.
                            </p>
                        </div>
                    </div>

                    <!-- Section 3 -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition duration-200 flex gap-3.5">
                        <span class="text-emerald-600 text-lg mt-0.5"><i class="fa-solid fa-truck-fast"></i></span>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-800">Giao Hàng Tận Nhà</h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Chúng tôi hiểu rằng sự tiện lợi là quan trọng. Với dịch vụ giao hàng tận nhà của chúng tôi, bạn có thể đặt hàng trực tuyến và chúng tôi sẽ đưa đồ đến cửa nhà bạn. Không cần phải xếp hàng hoặc lo lắng về việc mua sắm.
                            </p>
                        </div>
                    </div>

                    <!-- Section 4 -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition duration-200 flex gap-3.5">
                        <span class="text-emerald-600 text-lg mt-0.5"><i class="fa-solid fa-tags"></i></span>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-800">Giá Cả Cạnh Tranh</h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Chúng tôi cam kết cung cấp các sản phẩm với giá cả cạnh tranh. Chúng tôi luôn theo dõi thị trường để đảm bảo rằng bạn nhận được giá tốt nhất cho những sản phẩm bạn yêu thích.
                            </p>
                        </div>
                    </div>

                    <!-- Section 5 -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition duration-200 flex gap-3.5">
                        <span class="text-emerald-600 text-lg mt-0.5"><i class="fa-solid fa-headset"></i></span>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-800">Hỗ Trợ Khách Hàng Tận Tâm</h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Đội ngũ hỗ trợ khách hàng của chúng tôi luôn sẵn sàng để giải quyết mọi câu hỏi hoặc phản hồi từ bạn. Chúng tôi luôn lắng nghe ý kiến của khách hàng để cải thiện dịch vụ của mình.
                            </p>
                        </div>
                    </div>
                </div>

                <p class="text-sm text-slate-600 leading-relaxed font-semibold pt-2">
                    Hãy tham gia cửa hàng trực tuyến <strong class="text-emerald-600 font-bold">"Bán Hàng 11"</strong> ngay hôm nay và trải nghiệm sự thuận tiện, đa dạng và chất lượng mà chúng tôi mang lại cho bạn. Cùng chúng tôi tạo nên những bữa ăn ngon và thú vị mỗi ngày!
                </p>
            </div>

            <!-- Right Side: Illustration -->
            <div class="lg:col-span-4 flex items-center justify-center">
                <div class="relative w-full max-w-sm aspect-square rounded-3xl overflow-hidden shadow-lg border border-slate-100 group">
                    <img src="{{ BASE_URL }}/uploads/about_us.png" alt="Bán Hàng 11 - Dịch vụ đi chợ online" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
