@extends('layouts.main')
@section('title', $article['title'] . ' - Tin Tức Z DEMO')
@section('content')
@php
    $imgUrl = !empty($article['image'])
        ? (preg_match('/^https?:\/\//i', $article['image']) ? $article['image'] : BASE_URL . '/' . $article['image'])
        : BASE_URL . '/uploads/article_1.jpg';
@endphp
<div class="space-y-8 max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-slate-500 items-center space-x-2 flex-wrap gap-y-1">
        <a href="{{ BASE_URL }}/" class="hover:text-emerald-600 transition"><i class="fa-solid fa-house"></i> Trang chủ</a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
        <a href="{{ BASE_URL }}/news" class="hover:text-emerald-600 transition">Tin tức</a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
        <span class="text-slate-900 font-medium truncate max-w-xs">{{ $article['title'] }}</span>
    </nav>

    <!-- Article -->
    <article class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- Hero Image -->
        <div class="h-72 sm:h-96 overflow-hidden relative">
            <img src="{{ $imgUrl }}" alt="{{ $article['title'] }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-8 right-8">
                <h1 class="text-2xl sm:text-3xl font-black text-white drop-shadow leading-snug">{{ $article['title'] }}</h1>
                <div class="flex items-center gap-3 mt-2 text-white/75 text-xs">
                    <span><i class="fa-regular fa-calendar mr-1"></i>{{ date('d/m/Y', strtotime($article['created_at'])) }}</span>
                    <span>·</span>
                    <span><i class="fa-regular fa-clock mr-1"></i>{{ max(1, ceil(str_word_count($article['description'] ?? '') / 200)) }} phút đọc</span>
                </div>
            </div>
        </div>

        <!-- Content Body -->
        <div class="p-8 sm:p-10">
            <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed text-base">
                {!! nl2br(htmlspecialchars($article['description'])) !!}
            </div>

            <!-- Share & Back -->
            <div class="mt-10 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <a href="{{ BASE_URL }}/news"
                   class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-emerald-600 transition">
                    <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách tin tức
                </a>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-400 font-semibold">Chia sẻ:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(BASE_URL . '/news/' . $article['id']) }}" target="_blank"
                       class="w-8 h-8 rounded-full bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center text-xs transition">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($article['title']) }}&url={{ urlencode(BASE_URL . '/news/' . $article['id']) }}" target="_blank"
                       class="w-8 h-8 rounded-full bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center text-xs transition">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                </div>
            </div>
        </div>
    </article>

    <!-- Related Articles -->
    @if(count($related) > 0)
    <div>
        <h2 class="text-lg font-extrabold text-slate-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-bookmark text-emerald-500"></i> Bài viết liên quan
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            @foreach($related as $rel)
            @php
                $relImg = !empty($rel['image'])
                    ? (preg_match('/^https?:\/\//i', $rel['image']) ? $rel['image'] : BASE_URL . '/' . $rel['image'])
                    : BASE_URL . '/uploads/article_1.jpg';
            @endphp
            <a href="{{ BASE_URL }}/news/{{ $rel['id'] }}" class="group bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col">
                <div class="h-36 overflow-hidden bg-slate-100">
                    <img src="{{ $relImg }}" alt="{{ $rel['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 flex-grow">
                    <p class="text-xs text-slate-400 mb-1">{{ date('d/m/Y', strtotime($rel['created_at'])) }}</p>
                    <h3 class="text-sm font-bold text-slate-800 group-hover:text-emerald-600 transition line-clamp-2 leading-snug">{{ $rel['title'] }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
