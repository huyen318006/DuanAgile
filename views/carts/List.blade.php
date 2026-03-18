@extends('layouts.AdminLayout')

@section('content')
    <main class="main" id="top">
        <section class="py-5 overflow-hidden bg-primary" id="home">
            <div class="bg-holder"
                style="background-image:url({{ asset('assets/img/gallery/cta-two-bg.png') }});background-position:center;background-size:cover;">
            </div>
            <div class="container">
                <div class="row flex-center">
                    <div class="col-xxl-9 py-7 text-center">
                        <h1 class="fw-bold mb-4 text-white fs-6"> Bạn đã sẵn sàng đặt món <br />với những ưu đãi tốt nhất
                            chưa?</h1><a class="btn btn-danger" href="#"> ĐẶT MÓN NGAY<i
                                class="fas fa-chevron-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </section>
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table cart-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Tên Món</th>
                                    <th scope="col">Số Lượng</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Tổng Tiền</th>
                                    <th scope="col">Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $key => $cart)
                                    @php
                                        $food = $foods[$cart->food_id] ?? null;
                                    @endphp
                                    <tr data-cart-id="{{ $cart->id }}" data-price="{{ $food->price ?? 0 }}">
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td><img src="{{ asset('assets/img/gallery/' . $food->image) }}" alt="{{ $food->name }}"
                                                width="100" class="rounded-circle"></td>
                                        <td>{{ $food->name ?? 'N/A' }}</td>
                                        <td>
                                            <div class="input-group quantity">
                                                <button class="btn btn-sm rounded-circle bg-light border btn-qty-minus" type="button">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <input type="text" class="form-control form-control-sm text-center border-0 qty-value" value="{{ $cart->quantity }}" readonly>
                                                <button class="btn btn-sm rounded-circle bg-light border btn-qty-plus" type="button">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>{{ $food ? number_format($food->price, 0, ',', '.') . 'đ' : 'N/A' }}</td>
                                        <td class="line-total">{{ $food ? number_format($food->price * $cart->quantity, 0, ',', '.') . 'đ' : 'N/A' }}</td>
                                        <td>
                                            <form action="{{ route('cart/' . $cart->id . '/delete') }}" method="post">
                                                <button onclick="return confirm('Bạn có chắc chắn muốn xóa không?')" type="submit"
                                                    class="btn btn-cart-remove rounded-circle bg-light border">
                                                    <i class="fa fa-times text-danger"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-light rounded p-4 cart-sidebar">
                        <h4 class="fw-bold mb-4">Thanh Toán</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Số món:</span>
                            <span class="fw-bold">{{ count($carts) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tên Khách Hàng:</span>
                            <span class="fw-bold">{{ $user->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Số điện thoại:</span>
                            <span class="fw-bold">{{ $user->phone }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Địa chỉ:</span>
                            <span class="fw-bold">{{ $user->address }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="fw-bold mb-0">Tổng Tiền:</h5>
                            <h5 class="fw-bold text-primary mb-0" id="grandTotal">{{ number_format($total, 0, ',', '.') }}đ</h5>
                        </div>
                        <button class="btn btn-primary w-100 rounded-pill py-3 text-uppercase fw-bold" type="button">
                            <i class="fas fa-check me-2"></i>Đặt Món
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  function formatNumber(n) {
    return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + 'đ';
  }

  function recalcGrandTotal() {
    var total = 0;
    document.querySelectorAll('.cart-table tbody tr[data-cart-id]').forEach(function(row) {
      var price = parseInt(row.getAttribute('data-price')) || 0;
      var qty = parseInt(row.querySelector('.qty-value').value) || 0;
      total += price * qty;
    });
    document.getElementById('grandTotal').textContent = formatNumber(total);
  }

  function updateQuantity(row, newQty) {
    if (newQty < 1) return;

    var cartId = row.getAttribute('data-cart-id');
    var price = parseInt(row.getAttribute('data-price')) || 0;
    var qtyInput = row.querySelector('.qty-value');
    var lineTotal = row.querySelector('.line-total');

    qtyInput.value = newQty;
    lineTotal.textContent = formatNumber(price * newQty);
    recalcGrandTotal();

    var formData = new FormData();
    formData.append('quantity', newQty);

    fetch('{{ APP_URL }}cart/' + cartId + '/update', {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      body: formData
    });
  }

  document.querySelectorAll('.btn-qty-minus').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var row = this.closest('tr');
      var qty = parseInt(row.querySelector('.qty-value').value) || 1;
      updateQuantity(row, qty - 1);
    });
  });

  document.querySelectorAll('.btn-qty-plus').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var row = this.closest('tr');
      var qty = parseInt(row.querySelector('.qty-value').value) || 1;
      updateQuantity(row, qty + 1);
    });
  });
});
</script>
@endsection
@endsection
