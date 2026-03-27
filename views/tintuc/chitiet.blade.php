@extends('layouts.AdminLayout')

@section('content')

<section class="py-5 bg-light">

<div class="mb-5">
  <a href="{{ route('tintuc') }}" 
   class="btn btn-dark d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill shadow-sm btn-back">
   ← Quay lại danh sách
</a>
</div>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-11 col-xl-9">

        <div class="card border-0 shadow-xl rounded-4 overflow-hidden">

          <!-- Featured Image -->
          <div class="position-relative">
            <img 
              src="{{ asset('assets/img/gallery/' . ($post->image ?? 'default.png')) }}"
              class="w-100 img-featured"
              alt="{{ $post->title }}">
            
            <!-- Overlay gradient -->
            <div class="position-absolute bottom-0 start-0 w-100 h-50 bg-gradient-overlay"></div>
          </div>

          <!-- Content -->
          <div class="p-4 p-md-5">

            <!-- Title -->
            <h1 class="fw-bold display-5 lh-1 mb-4">
              {{ $post->title }}
            </h1>

            <!-- Meta Information -->
            <div class="d-flex flex-wrap gap-4 text-muted mb-5 border-bottom pb-4">
              <div class="d-flex align-items-center gap-2">
                <i class="bi bi-calendar3"></i>
                <span>{{ $post->created_at ? date('d/m/Y', strtotime($post->created_at)) : 'N/A' }}</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <i class="bi bi-person"></i>
                <span>{{ $post->author ?? 'Admin' }}</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <i class="bi bi-eye"></i>
                <span>{{ number_format($post->views ?? 0) }} lượt xem</span>
              </div>
            </div>

            <!-- Main Content -->
            <div class="post-content">
              {!! $post->content !!}
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
/* ==================== HIỆN ĐẠI & ĐẸP ==================== */
.img-featured {
    height: 460px;
    object-fit: cover;
    transition: transform 0.6s ease;
}
.card:hover .img-featured {
    transform: scale(1.03);
}
.bg-gradient-overlay {
    background: linear-gradient(to top, rgba(0,0,0,0.65), transparent);
}

/* Nội dung bài viết */
.post-content {
    font-size: 1.1rem;
    line-height: 1.9;
    color: #2c2c2c;
    word-break: break-word;
}

/* Tiêu đề phụ */
.post-content h1, .post-content h2, .post-content h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 700;
    color: #111;
    border-left: 4px solid #0d6efd;
    padding-left: 0.75rem;
}

/* Đoạn văn */
.post-content p {
    margin-bottom: 1.5rem;
    text-align: justify;
}

/* Ảnh trong nội dung */
.post-content img {
    display: block;
    max-width: 100%;
    height: auto;
    border-radius: 14px;
    margin: 2rem auto;
    box-shadow: 0 12px 28px rgba(0,0,0,0.12);
    transition: transform 0.3s ease;
}
.post-content img:hover {
    transform: scale(1.04);
}

/* Danh sách */
.post-content ul, .post-content ol {
    margin: 1.5rem 0;
    padding-left: 1.5rem;
}
.post-content li {
    margin-bottom: 0.75rem;
}

/* Trích dẫn */
.post-content blockquote {
    border-left: 4px solid #0d6efd;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #555;
    background: #f8f9fa;
    border-radius: 6px;
}

/* Card Hover Effect */
.card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.15) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .img-featured {
        height: 320px;
    }
    .p-4.p-md-5 {
        padding: 1.75rem !important;
    }
    .post-content {
        font-size: 1rem;
        line-height: 1.7;
    }
}
</style>

@endsection
