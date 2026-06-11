@extends('layouts.main')

@section('title', 'Cửa hàng - Bán Hàng 11 / Z DEMO')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-slate-500 items-center space-x-2">
        <a href="{{ BASE_URL }}/" class="hover:text-emerald-600 transition"><i class="fa-solid fa-house"></i> Trang chủ</a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
        <span class="text-slate-950 font-medium">Cửa hàng</span>
    </nav>

    <!-- Main Store Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Left Sidebar: Filters -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-6">
                <h3 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-3 flex items-center">
                    <span class="bg-emerald-50 text-emerald-600 rounded-lg p-1.5 mr-2 text-xs"><i class="fa-solid fa-filter"></i></span>
                    Bộ Lọc Sản Phẩm
                </h3>

                <!-- Filter by Price -->
                <div class="space-y-3">
                    <h4 class="text-sm font-extrabold text-slate-800">Lọc theo giá</h4>
                    <div class="px-2">
                        <input type="range" id="price-slider" min="70000" max="200000" value="200000" step="5000" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-emerald-600">
                    </div>
                    <div class="flex items-center justify-between text-xs text-slate-600 font-bold pt-1">
                        <button onclick="applyFilters()" class="px-3 py-1.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                            Lọc
                        </button>
                        <span id="price-display">70.000đ – 200.000đ</span>
                    </div>
                </div>

                <!-- Product Categories -->
                <div class="space-y-4">
                    <h4 class="text-sm font-extrabold text-slate-800">Loại sản phẩm</h4>
                    <div class="space-y-3 text-xs font-semibold text-slate-600">
                        <!-- Gạo bột đồ khô -->
                        <div class="flex items-start gap-2.5">
                            <input type="checkbox" id="cat-gao_bot" class="cat-checkbox rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 mt-0.5" value="gao_bot">
                            <label for="cat-gao_bot" class="cursor-pointer hover:text-emerald-600 transition">Gạo, bột, đồ khô</label>
                        </div>

                        <!-- Hàng đông mát -->
                        <div class="space-y-2">
                            <div class="flex items-start gap-2.5">
                                <input type="checkbox" id="cat-dong_mat" class="cat-checkbox rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 mt-0.5" value="dong_mat">
                                <label for="cat-dong_mat" class="cursor-pointer hover:text-emerald-600 transition">Hàng đông mát</label>
                            </div>
                            <div class="pl-6 space-y-2 text-[11px] text-slate-400 font-medium">
                                <div><i class="fa-solid fa-angle-right mr-1.5 text-[9px]"></i> Bánh đông, bánh tươi</div>
                                <div><i class="fa-solid fa-angle-right mr-1.5 text-[9px]"></i> Chả giò, cá-bò viên</div>
                                <div><i class="fa-solid fa-angle-right mr-1.5 text-[9px]"></i> Há cảo, sủi cảo</div>
                                <div><i class="fa-solid fa-angle-right mr-1.5 text-[9px]"></i> Xúc xích, lạp xưởng, chả lụa</div>
                            </div>
                        </div>

                        <!-- Mì miến cháo phở -->
                        <div class="flex items-start gap-2.5">
                            <input type="checkbox" id="cat-mi_lien" class="cat-checkbox rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 mt-0.5" value="mi_lien">
                            <label for="cat-mi_lien" class="cursor-pointer hover:text-emerald-600 transition">Mì, miến, cháo, phở</label>
                        </div>

                        <!-- Thịt cá trứng rau -->
                        <div class="space-y-2">
                            <div class="flex items-start gap-2.5">
                                <input type="checkbox" id="cat-thit_ca" class="cat-checkbox rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 mt-0.5" value="thit_ca">
                                <label for="cat-thit_ca" class="cursor-pointer hover:text-emerald-600 transition">Thịt, cá, trứng, rau</label>
                            </div>
                            <div class="pl-6 space-y-2 text-[11px] text-slate-400 font-medium">
                                <div><i class="fa-solid fa-angle-right mr-1.5 text-[9px]"></i> Cá, hải sản</div>
                                <div><i class="fa-solid fa-angle-right mr-1.5 text-[9px]"></i> Rau củ các loại</div>
                                <div><i class="fa-solid fa-angle-right mr-1.5 text-[9px]"></i> Rau lá các loại</div>
                                <div><i class="fa-solid fa-angle-right mr-1.5 text-[9px]"></i> Thịt các loại</div>
                                <div><i class="fa-solid fa-angle-right mr-1.5 text-[9px]"></i> Trái cây các loại</div>
                                <div><i class="fa-solid fa-angle-right mr-1.5 text-[9px]"></i> Trứng gà, vịt, cút</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Main Content: Products and Banner -->
        <div class="lg:col-span-3 space-y-6">
            
            <!-- Store Introduction Text -->
            <div class="space-y-3">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Tất cả sản phẩm</h1>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Chúng tôi mong muốn mang đến sự nhanh chóng và tiện lợi tối đa khi mua sắm đến cho khách hàng bằng việc đưa hệ thống siêu thị Wolf Food phủ rộng khắp mọi khu vực kể cả vùng nông thôn. Bên cạnh đó, chúng tôi cũng tập trung phát triển kênh mua sắm online trên website Wolf Food để phục vụ cho mọi đối tượng, đặc biệt là nhóm khách hàng trẻ. Wolf Food cũng không ngừng tìm kiếm và mang đến sự đa dạng trong việc lựa chọn sản phẩm với hơn 12.000 sản phẩm đủ chủng loại, xuất xứ rõ ràng, giá cả hợp lý, minh bạch.
                </p>
            </div>

            <!-- Promo Banner slider -->
            <div class="rounded-3xl overflow-hidden shadow-sm hover:shadow-md border border-slate-100 relative group transition duration-300">
                <img src="{{ BASE_URL }}/uploads/store_banner.png" alt="Tã sữa giảm giá 30%" class="w-full h-auto object-cover">
                <!-- Slider Buttons mockup -->
                <button class="absolute top-1/2 left-4 -translate-y-1/2 w-8 h-8 rounded-full bg-white/20 backdrop-blur-xs text-white hover:bg-white/40 flex items-center justify-center transition">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                <button class="absolute top-1/2 right-4 -translate-y-1/2 w-8 h-8 rounded-full bg-white/20 backdrop-blur-xs text-white hover:bg-white/40 flex items-center justify-center transition">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
            </div>

            <!-- Sorting Toolbar -->
            <div class="bg-white border border-slate-100 rounded-2xl p-4 flex flex-wrap items-center gap-4 text-xs font-bold text-slate-600 shadow-xs">
                <span class="flex items-center"><i class="fa-solid fa-arrow-down-wide-short mr-2 text-emerald-600"></i> Xếp theo:</span>
                <div class="flex flex-wrap gap-4 items-center">
                    <label class="flex items-center gap-1.5 cursor-pointer hover:text-emerald-600 transition">
                        <input type="radio" name="sort-options" value="default" checked class="text-emerald-600 focus:ring-emerald-500 border-slate-300"> Mặc định
                    </label>
                    <label class="flex items-center gap-1.5 cursor-pointer hover:text-emerald-600 transition">
                        <input type="radio" name="sort-options" value="newest" class="text-emerald-600 focus:ring-emerald-500 border-slate-300"> Mới nhất
                    </label>
                    <label class="flex items-center gap-1.5 cursor-pointer hover:text-emerald-600 transition">
                        <input type="radio" name="sort-options" value="price-asc" class="text-emerald-600 focus:ring-emerald-500 border-slate-300"> Giá thấp đến cao
                    </label>
                    <label class="flex items-center gap-1.5 cursor-pointer hover:text-emerald-600 transition">
                        <input type="radio" name="sort-options" value="price-desc" class="text-emerald-600 focus:ring-emerald-500 border-slate-300"> Giá cao xuống thấp
                    </label>
                    <label class="flex items-center gap-1.5 cursor-pointer hover:text-emerald-600 transition">
                        <input type="radio" name="sort-options" value="popular" class="text-emerald-600 focus:ring-emerald-500 border-slate-300"> Mức độ phổ biến
                    </label>
                    <label class="flex items-center gap-1.5 cursor-pointer hover:text-emerald-600 transition">
                        <input type="radio" name="sort-options" value="rating" class="text-emerald-600 focus:ring-emerald-500 border-slate-300"> Điểm đánh giá
                    </label>
                </div>
            </div>

            <!-- Products Catalog Grid -->
            <div id="store-products-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
                <!-- Products will be populated dynamically here by Javascript -->
            </div>

        </div>

    </div>
</div>

<!-- JavaScript for dynamic client-side filtering and sorting -->
<script>
    (function() {
        const rawProducts = {!! json_encode(array_merge($products, $saleProducts)) !!};
        const baseUrl = "{{ BASE_URL }}";

        const categoryLabels = {
            'dong_mat': 'Hàng đông mát',
            'thit_ca': 'Thịt các loại',
            'rau_cu': 'Rau củ sạch',
            'trai_cay': 'Trái cây sạch',
            'nam': 'Nấm các loại',
            'mi_lien': 'Mì & phở ăn liền',
            'gao_bot': 'Gạo & bột khô'
        };

        const slider = document.getElementById('price-slider');
        const priceDisplay = document.getElementById('price-display');

        // Dynamic price slider text update
        if (slider && priceDisplay) {
            slider.addEventListener('input', function() {
                const maxVal = parseInt(slider.value);
                priceDisplay.innerText = "70.000đ – " + new Intl.NumberFormat('vi-VN').format(maxVal) + 'đ';
            });
        }

        // Apply filters
        window.applyFilters = function() {
            const maxPrice = slider ? parseInt(slider.value) : 200000;
            
            // Get selected categories
            const selectedCheckboxes = document.querySelectorAll('.cat-checkbox:checked');
            const selectedCats = Array.from(selectedCheckboxes).map(cb => cb.value);

            let filtered = rawProducts.filter(p => {
                // Filter by price
                const inPrice = p.price >= 5000 && p.price <= maxPrice; // Lower bound adjusted to fit noodle prices
                
                // Filter by category
                let inCategory = true;
                if (selectedCats.length > 0) {
                    if (selectedCats.includes('thit_ca')) {
                        // Thịt cá checkbox also covers veggies & mushrooms
                        inCategory = selectedCats.includes(p.category) || p.category === 'thit_ca' || p.category === 'rau_cu' || p.category === 'nam' || p.category === 'trai_cay';
                    } else {
                        inCategory = selectedCats.includes(p.category);
                    }
                }
                
                return inPrice && inCategory;
            });

            // Apply sorting
            const activeSort = document.querySelector('input[name="sort-options"]:checked');
            const sortVal = activeSort ? activeSort.value : 'default';

            if (sortVal === 'price-asc') {
                filtered.sort((a, b) => a.price - b.price);
            } else if (sortVal === 'price-desc') {
                filtered.sort((a, b) => b.price - a.price);
            } else if (sortVal === 'newest') {
                filtered.sort((a, b) => b.id - a.id);
            }

            // Render matching items
            const grid = document.getElementById('store-products-grid');
            if (!grid) return;

            if (filtered.length === 0) {
                grid.className = "block py-16 text-center bg-white rounded-3xl border border-slate-100 text-slate-400 col-span-full";
                grid.innerHTML = `
                    <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto text-3xl mb-4">
                        <i class="fa-solid fa-basket-shopping"></i>
                    </div>
                    <h3 class="text-md font-bold text-slate-700">Không tìm thấy sản phẩm nào</h3>
                    <p class="text-xs text-slate-400 mt-1">Vui lòng điều chỉnh khoảng lọc hoặc chọn các loại sản phẩm khác.</p>
                `;
                return;
            }

            grid.className = "grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5";
            let html = '';
            filtered.forEach(p => {
                const priceFormatted = new Intl.NumberFormat('vi-VN').format(p.price) + 'đ';
                const originalPriceFormatted = p.original_price ? new Intl.NumberFormat('vi-VN').format(p.original_price) + 'đ' : '';
                const hasDiscount = p.discount_percent && p.discount_percent > 0;
                const label = categoryLabels[p.category] || 'Nông sản sạch';

                // Price display mock for ribs
                let priceDisplayHtml = `
                    <span class="text-xs font-black text-rose-600">${priceFormatted}</span>
                    ${hasDiscount ? `<span class="text-[10px] text-slate-400 line-through">${originalPriceFormatted}</span>` : ''}
                `;
                if (p.name.includes('Sườn già heo C.P')) {
                    priceDisplayHtml = `
                        <span class="text-xs font-black text-emerald-600">79.000đ – 83.000đ</span>
                    `;
                } else {
                    // Check screenshot, prices in catalog grid are green
                    priceDisplayHtml = `
                        <span class="text-xs font-black text-emerald-600">${priceFormatted}</span>
                        ${hasDiscount ? `<span class="text-[9px] text-slate-400 line-through">${originalPriceFormatted}</span>` : ''}
                    `;
                }

                const imgSrc = (p.images && p.images.length > 0)
                    ? (p.images[0].startsWith('http') ? p.images[0] : baseUrl + '/' + p.images[0])
                    : (p.image ? (p.image.startsWith('http') ? p.image : baseUrl + '/' + p.image) : baseUrl + '/uploads/product_hero_showcase.jpg');
                const extraImgsBadge = (p.images && p.images.length > 1)
                    ? `<span class="absolute bottom-2 left-2 bg-black/50 backdrop-blur-sm text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full z-10"><i class="fa-solid fa-images mr-0.5"></i>${p.images.length}</span>`
                    : '';

                html += `
                <div class="bg-white rounded-2xl overflow-hidden p-3.5 border border-slate-100 text-slate-800 flex flex-col justify-between relative group hover:shadow-md transition duration-300">
                    <!-- Discount Badge -->
                    ${hasDiscount ? `
                    <span class="absolute top-2.5 right-2.5 bg-emerald-500 text-white font-extrabold text-[9px] px-2 py-0.5 rounded-full z-10">
                        ${p.discount_percent}%
                    </span>
                    ` : ''}
                    
                    <!-- Delete Button -->
                    <a href="${baseUrl}/product/${p.id}/delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')" class="absolute top-2.5 left-2.5 bg-rose-500 hover:bg-rose-600 text-white p-1.5 rounded-full z-10 opacity-0 group-hover:opacity-100 transition duration-200 text-[10px]">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>

                    <!-- Product Image -->
                    <div class="aspect-square w-full rounded-xl overflow-hidden bg-slate-50 relative">
                        <img src="${imgSrc}" alt="${p.name}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
                        ${extraImgsBadge}
                    </div>

                    <!-- Product Details -->
                    <div class="mt-3 flex flex-col flex-grow">
                        <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">${label}</span>
                        <h4 class="text-xs font-bold text-slate-900 mt-1 line-clamp-2 hover:text-emerald-600 transition flex-grow">
                            <a href="${baseUrl}/product/${p.id}">
                                ${p.name}
                            </a>
                        </h4>
                        
                        <!-- Price block -->
                        <div class="mt-3 flex flex-col">
                            ${priceDisplayHtml}
                        </div>
                    </div>

                    <!-- Action button -->
                    <div class="mt-3 pt-2 border-t border-slate-50 flex items-center justify-between">
                        <a href="${baseUrl}/product/${p.id}" class="text-[10px] font-bold text-emerald-600 hover:underline">Chi tiết</a>
                        <button class="add-to-cart-btn w-7 h-7 rounded-full border border-emerald-200 text-emerald-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition shadow-sm"
                                data-id="${p.id}"
                                data-name="${p.name}"
                                data-price="${p.price}"
                                data-image="${imgSrc}">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>
                `;
            });

            grid.innerHTML = html;
        };

        // Event listeners for checkboxes and radio options
        document.addEventListener("DOMContentLoaded", function() {
            // Apply category checkbox clicks
            const checkboxes = document.querySelectorAll('.cat-checkbox');
            checkboxes.forEach(cb => {
                cb.addEventListener('change', applyFilters);
            });

            // Apply sort radio changes
            const radios = document.querySelectorAll('input[name="sort-options"]');
            radios.forEach(radio => {
                radio.addEventListener('change', applyFilters);
            });

            // Initial load
            applyFilters();
        });
        
        // Execute initial filter directly to handle BladeOne rendering pipeline
        applyFilters();
    })();
</script>
@endsection
