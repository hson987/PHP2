@extends('layouts.main')
@section('title', 'Thêm bài viết - Admin Z DEMO')
@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-slate-500 items-center space-x-2">
        <a href="{{ BASE_URL }}/admin/articles" class="hover:text-emerald-600 transition"><i class="fa-solid fa-newspaper"></i> Bài viết</a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
        <span class="text-slate-900 font-medium">Thêm bài viết</span>
    </nav>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
        <h1 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-2">
            <span class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm"><i class="fa-solid fa-plus"></i></span>
            Thêm bài viết mới
        </h1>

        @if($error)
        <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl px-5 py-3 text-sm font-semibold flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i> {{ $error }}
        </div>
        @endif

        <form method="POST" action="{{ BASE_URL }}/admin/article/add" enctype="multipart/form-data" class="space-y-6">

            <!-- Tiêu đề -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Tiêu đề bài viết <span class="text-rose-500">*</span></label>
                <input type="text" name="title" required
                       value="{{ $_POST['title'] ?? '' }}"
                       placeholder="Nhập tiêu đề bài viết..."
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition">
            </div>

            <!-- Upload ảnh -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Hình ảnh bài viết</label>
                <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:border-emerald-400 transition duration-200" id="upload-zone">
                    <!-- Preview -->
                    <div id="img-preview-wrap" class="hidden mb-4">
                        <img id="img-preview" src="" alt="Preview" class="mx-auto max-h-48 rounded-xl object-cover shadow-sm border border-slate-200">
                        <button type="button" onclick="clearImage()" class="mt-2 text-xs text-rose-500 hover:text-rose-600 font-semibold"><i class="fa-solid fa-xmark mr-1"></i>Xóa ảnh</button>
                    </div>
                    <div id="upload-placeholder">
                        <i class="fa-solid fa-image text-4xl text-slate-300 mb-3"></i>
                        <p class="text-sm text-slate-500 mb-3">Kéo thả hoặc click để chọn ảnh</p>
                        <label for="image_file" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition">
                            <i class="fa-solid fa-upload"></i> Chọn file ảnh
                        </label>
                        <input type="file" id="image_file" name="image_file" accept="image/*" class="hidden" onchange="previewImage(this)">
                        <p class="text-xs text-slate-400 mt-2">JPG, PNG, GIF, WEBP — Tối đa 5MB</p>
                    </div>
                </div>

                <!-- Hoặc link URL -->
                <div class="mt-3">
                    <p class="text-xs text-slate-400 mb-1.5 font-semibold">Hoặc dán link ảnh URL:</p>
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

            <!-- Mô tả / nội dung -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Mô tả / Nội dung bài viết</label>
                <textarea name="description" rows="6" placeholder="Nhập nội dung bài viết..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition resize-none leading-relaxed">{{ $_POST['description'] ?? '' }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-grow py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Lưu bài viết
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
    } else {
        clearImage();
    }
}
function clearImage() {
    document.getElementById('img-preview').src = '';
    document.getElementById('img-preview-wrap').classList.add('hidden');
    document.getElementById('upload-placeholder').classList.remove('hidden');
    document.getElementById('image_file').value = '';
    document.getElementById('image_url').value = '';
}
</script>
@endsection
