@extends('layouts.AdminLayout')

@section('content')

<section class="py-5 bg-light">
  <div class="container">

    <h2 class="mb-5 fw-bold text-center">Tin tức mới nhất</h2>

    <div class="row g-4">

      @foreach($posts as $post)
      <div class="col-12">

        <div class="card h-100 shadow-sm border-0 overflow-hidden hover-card">

          <div class="row g-0 h-100">

            <!-- IMAGE -->
            <div class="col-md-4 col-lg-3">
              <img 
                src="{{ asset('assets/img/gallery/' . ($post->image ?? 'default.png')) }}"
                class="img-fluid h-100 w-100"
                style="object-fit: cover; height: 220px;"
                alt="{{ $post->title }}">
            </div>

            <!-- CONTENT -->
            <div class="col-md-8 col-lg-9 d-flex flex-column p-4">

              <div class="flex-grow-1">
                <!-- Title -->
                <h5 class="card-title fw-bold mb-3">
                  {{ $post->title ?? 'Không có tiêu đề' }}
                </h5>

                <!-- Short Description -->
                <p class="card-text text-muted mb-3 line-clamp-3">
                  {{ substr(strip_tags($post->content ?? ''), 0, 160) }}...
                </p>

                <!-- Meta -->
                <small class="text-muted d-flex align-items-center gap-3">
                  <span>
                    📅 {{ isset($post->created_at) ? date('d/m/Y', strtotime($post->created_at)) : 'N/A' }}
                  </span>
                  @if(isset($post->views))
                  <span>👁 {{ number_format($post->views) }} lượt xem</span>
                  @endif
                </small>
              </div>

              <!-- Button -->
              <div class="mt-3">
                <a href="{{ route('post/'.$post->id.'/show') }}" 
                   class="btn btn-primary px-4 py-2">
                  Xem chi tiết →
                </a>
              </div>

            </div>

          </div>
        </div>

      </div>
      @endforeach

    </div>

  </div>
</section>
<style>
    .hover-card {
    transition: all 0.3s ease;
    border-radius: 12px;
}

.hover-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Responsive */
@media (max-width: 768px) {
    .img-fluid {
        height: 180px !important;
    }
}
</style>

@endsection