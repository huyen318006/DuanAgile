@extends('layouts.AdminLayout')

@section('content')
<section class="py-6" style="margin-top:20px">
 <div class="container">
  <h2 class="restaurant-title mb-4">🧾 Đơn hàng của bạn</h2>

  <div class="row justify-content-center">
    <div class="col-lg-8">

      @foreach($orders as $order)
      <div class="order-card mb-4">
        <h5>Đơn hàng #{{ $order->id }}</h5>
        @foreach($order->foodIds as $food)
          <p>{{ $food->name }}</p>
        @endforeach
        <p><strong>Ngày đặt:</strong> {{ $order->created_at }}</p>
        <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price,0,',','.') }} VND</p>
        <p>
          <strong>Trạng thái:</strong>
          @if($order->status == 'processing')
            <span class="badge bg-warning">Đang xử lý</span>
          @elseif($order->status == 'delivering')
            <span class="badge bg-primary">Đang giao</span>
          @elseif($order->status == 'done')
            <span class="badge bg-success">Hoàn thành</span>
          @endif
        </p>

        <div class="text-end">
          <!-- Nút xem chi tiết đẹp -->
          <button type="button" class="btn btn-view-detail" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
            <i class="fas fa-eye me-1"></i> Xem chi tiết
          </button>
        </div>
      </div>

      <!-- Modal chi tiết đơn hàng -->
      <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderLabel{{ $order->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title" id="orderLabel{{ $order->id }}">Chi tiết đơn hàng #{{ $order->id }}</h5>
              
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
        
@if($order->sizes)
<div class="modal-body">
  <h6 class="mb-3">Size đã chọn:</h6>
  <ul class="list-group">
    @foreach($order->sizes as $size)
      <li class="list-group-item">{{ $size->name }}</li>
    @endforeach
  </ul>
</div>
@endif

@if($order->toppings)
<div class="modal-body">
  <h6 class="mb-3">Toppings đã chọn:</h6>
  <ul class="list-group">
    @foreach($order->toppings as $topping)
      <li class="list-group-item">{{ $topping->name }}</li>
    @endforeach
  </ul>
</div>
@endif

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Đóng</button>
            </div>

          </div>
        </div>
      </div>
      @endforeach

    </div>
  </div>

 </div>
</section>

<style>
/* Card đơn hàng */
.order-card{
  background:#fff;
  color:#000;
  border-radius:12px;
  padding:20px;
  box-shadow:0 5px 15px rgba(0,0,0,0.1);
  transition:0.3s;
}
.order-card:hover{
  transform:translateY(-4px);
  box-shadow:0 12px 25px rgba(0,0,0,0.15);
}

/* Nút xem chi tiết đẹp */
.btn-view-detail{
  background: linear-gradient(135deg,#ff9a44,#ff6a00);
  color:white;
  border:none;
  border-radius:50px;
  padding:6px 18px;
  font-weight:600;
  transition:0.3s;
  display:flex;
  align-items:center;
}
.btn-view-detail i{
  font-size:14px;
}
.btn-view-detail:hover{
  background: linear-gradient(135deg,#ff6a00,#ff9a44);
  transform:scale(1.05);
}

/* Badge trạng thái */
.badge{
  font-size:0.85rem;
  padding:0.35em 0.7em;
}

</style>
@endsection