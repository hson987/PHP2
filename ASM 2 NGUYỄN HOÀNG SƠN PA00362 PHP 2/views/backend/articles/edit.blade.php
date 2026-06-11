@extends('layouts.main')
@section('title', 'Sửa bài viết - Admin Z DEMO')
@section('content')
@php
    $currentImgUrl = !empty($article['image'])
        ? (preg_match('/^https?:\/\//i', $article['image']) ? $article['image'] : BASE_URL . '/' . $article['image'])
        : '';
@endphp
<div class="max-w-3xl mx-auto space-y-6">
    <nav class="flex text-sm text-slate-500 items-center space-x-2">
        <a href="{{ BASE_URL }}/admin/articles" class="hover:text-emerald-600 transition"><i class="fa-solid fa-newspaper"></i> Bài viết</a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
        <span class="text-slate-900 font-medium">Sửa bài viết #{{ $article['id'] }}</span>
    </nav>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
        <h1 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-2">
            <span class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-sm"><i class="fa-solid fa-pen"></i></span>
            Chỉnh sửa bài viết
        </h1>

        @if($error)
        <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl px-5 py-3 text-sm font-semibold flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i> {{ $error }}
        </div>
        @endif

        <form method="POST" action="{{ BASE_URL }}/admin/article/edit/{{ $article['id'] }}" enctype="multipart/form-data" class="space-y-6">

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Tiêu đề bài viết <span class="text-rose-500">*</span></label>
                <input type="text" name="title" required
                       value="{{ $article['title'] }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition">
            </div>

            <!-- Upload ảnh -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Hình ảnh bài viết</label>
                <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:border-emerald-400 transition duration-200">
                    <input type="file" id="image_file" name="image_file" accept="image/*" class="hidden" onchange="previewImage(this)">
                    
                    <div id="img-preview-wrap" class="{{ $currentImgUrl ? '' : 'hidden' }} mb-4">
                        <img id="img-preview" src="{{ $currentImgUrl }}" alt="Preview" class="mx-auto max-h-48 rounded-xl object-cover shadow-sm border border-slate-200">
                        <p class="text-xs text-emerald-600 font-semibold mt-2"><i class="fa-solid fa-check mr-1"></i>Ảnh hiện tại — để trống ô bên dưới để giữ ảnh này</p>
                        <button type="button" onclick="clearImage()" class="mt-1 text-xs text-rose-500 hover:text-rose-600 font-semibold"><i class="fa-solid fa-xmark mr-1"></i>Xóa ảnh</button>
                    </div>
                    
                    <div id="upload-placeholder" class="{{ $currentImgUrl ? 'hidden' : '' }}">
                        <i class="fa-solid fa-image text-4xl text-slate-300 mb-3"></i>
                        <p class="text-sm text-slate-500 mb-3">Chọn ảnh mới để thay thế</p>
                        <label for="image_file" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition">
                            <i class="fa-solid fa-upload"></i> Chọn file ảnh
                        </label>
                        <p class="text-xs text-slate-400 mt-2">JPG, PNG, GIF, WEBP — Tối đa 5MB</p>
                    </div>
                    
                    @if($currentImgUrl)
                    <div class="mt-3 text-center" id="change-image-btn-wrap">
                        <label for="image_file" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 border border-slate-200 hover:border-emerald-400 text-slate-600 hover:text-emerald-600 text-xs font-semibold rounded-lg transition">
                            <i class="fa-solid fa-rotate"></i> Thay ảnh mới
                        </label>
                    </div>
                    @endif
                </div>

                <div class="mt-3">
                    <p class="text-xs text-slate-400 mb-1.5 font-semibold">Hoặc thay bằng link ảnh URL:</p>
                    <div class="flex gap-2">
                        <input type="text" id="image_url" name="image_url" placeholder="https://example.com/image.jpg"
                               class="flex-grow px-3 py-2 rounded-lg border border-slate-200 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition"
                               oninput="previewUrl(this.value)">
                        <button type="button" onclick="document.getElementById('image_url').value='';clearImage()" class="px-3 py-2 rounded-lg border border-slate-200 text-slate-400 hover:text-rose-500 transition text-xs">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Mô tả / Nội dung bài viết</label>
                <textarea name="description" rows="6"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition resize-none leading-relaxed">{{ $article['description'] }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-grow py-3 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm shadow transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Cập nhật bài viết
                </button>
                <a href="{{ BASE_URL }}/admin/articles" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-sm transition flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Hủy
                </a>
            </div>
        </form>
    </div>
</div>
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('img-preview').src = e.target.result;
            document.getElementById('img-preview-wrap').classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
            document.getElementById('image_url').value = '';
            var btnWrap = document.getElementById('change-image-btn-wrap');
            if (btnWrap) {
                btnWrap.classList.remove('hidden');
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function previewUrl(url) {
    if (url.trim()) {
        document.getElementById('img-preview').src = url;
        document.getElementById('img-preview-wrap').classList.remove('hidden');
        document.getElementById('upload-placeholder').classList.add('hidden');
        document.getElementById('image_file').value = '';
        var btnWrap = document.getElementById('change-image-btn-wrap');
        if (btnWrap) {
            btnWrap.classList.remove('hidden');
        }
    }
}
function clearImage() {
    document.getElementById('img-preview').src = '';
    document.getElementById('img-preview-wrap').classList.add('hidden');
    document.getElementById('upload-placeholder').classList.remove('hidden');
    document.getElementById('image_file').value = '';
    document.getElementById('image_url').value = '';
    var btnWrap = document.getElementById('change-image-btn-wrap');
    if (btnWrap) {
        btnWrap.classList.add('hidden');
    }
}
</script>
@endsection
