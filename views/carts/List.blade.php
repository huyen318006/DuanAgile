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
                    <h1 class="fw-bold mb-4 text-white fs-6">Bạn đã sẵn sàng đặt món <br />với những ưu đãi tốt nhất chưa?</h1>
                    <a class="btn btn-danger" href="#">ĐẶT MÓN NGAY <i class="fas fa-chevron-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid py-5">
        
        <form action="{{ route('checkout/store') }}" method="POST" id="checkoutForm">

            <div class="row">

                <!-- Bảng giỏ hàng -->
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table cart-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ảnh</th>
                                    <th>Tên Món</th>
                                    <th>Size</th>
                                    <th>Topping</th>
                                    <th>Giá</th>
                                    <th>Tổng Tiền</th>
                                    <th>Tuỳ Chọn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $cart)
                                @php
                                    $food = $foods[$cart->food_id] ?? null;
                                    $unitPrice = $food ? $food->price : 0;
                                    $sizeObj = ($cart->size_id && isset($sizes[$cart->size_id])) ? $sizes[$cart->size_id] : null;
                                    if ($sizeObj) $unitPrice += $sizeObj->price;

                                    $cartToppings = [];
                                    if ($cart->topping_ids) {
                                        $tIds = json_decode($cart->topping_ids, true);
                                        if (is_array($tIds)) {
                                            foreach ($tIds as $tid) {
                                                if (isset($toppingsMap[$tid])) {
                                                    $cartToppings[] = $toppingsMap[$tid];
                                                    $unitPrice += $toppingsMap[$tid]->price;
                                                }
                                            }
                                        }
                                    }
                                @endphp

                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td><img src="{{ asset('assets/img/gallery/' . ($food->image ?? '')) }}" width="100" class="rounded-circle" alt=""></td>
                                    <td>{{ $food->name ?? 'N/A' }}</td>
                                    <td>@if($sizeObj) {{ $sizeObj->name }} @else <span class="text-muted">N/A</span> @endif</td>
                                    <td>
                                        @if(!empty($cartToppings))
                                            @foreach($cartToppings as $tp)
                                                <div>{{ $tp->name }}</div>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Không có</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($unitPrice, 0, ',', '.') }}đ</td>
                                    <td class="line-total">{{ number_format($unitPrice * $cart->quantity, 0, ',', '.') }}đ</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-white shadow-sm border text-primary" data-bs-toggle="modal" data-bs-target="#updateCartModal{{ $cart->id }}" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('cart/'.$cart->id.'/delete') }}" method="POST" class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-white shadow-sm border text-danger" onclick="return confirm('Xóa món này?')" title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- ==================== CÁCH GỬI KIỂU MẢNG RIÊNG ==================== -->
                                <input type="hidden" name="food_id[]"     value="{{ $cart->food_id }}">
                                <input type="hidden" name="quantity[]"    value="{{ $cart->quantity }}">
                                <input type="hidden" name="size_id[]"     value="{{ $cart->size_id ?? '' }}">
                                <input type="hidden" name="topping_ids[]" value="{{ $cart->topping_ids ?? '' }}">

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Phần thanh toán -->
                <div class="col-lg-3">
                    <div class="bg-light rounded p-4 cart-sidebar">
                        <h4 class="fw-bold mb-4">Thanh Toán</h4>

                        <div class="mb-3">
                            <label class="form-label fw-bold mb-1">Tên Khách Hàng</label>
                            <input type="text" class="form-control" name="checkout_name" id="checkoutName" value="{{ $user->name ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold mb-1">Số điện thoại</label>
                            <input type="tel" class="form-control" name="checkout_phone" id="checkoutPhone" value="{{ $user->phone ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold mb-1">Địa chỉ</label>
                            <textarea class="form-control" name="checkout_address" id="checkoutAddress" rows="2">{{ $user->address ?? '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold mb-1">Ghi chú đơn hàng</label>
                            <textarea class="form-control" name="checkout_notes" id="checkoutNotes" rows="3" placeholder="Ghi chú..."></textarea>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="fw-bold mb-0">Tổng Tiền:</h5>
                            <h5 class="fw-bold text-primary mb-0" id="grandTotal">{{ number_format($total ?? 0, 0, ',', '.') }}đ</h5>
                            <input type="hidden" name="price" value="{{ $total ?? 0 }}">
                        </div>

                        <button type="button" id="btnCheckout" class="btn btn-primary w-100 rounded-pill py-3 text-uppercase fw-bold">
                            <i class="fas fa-check me-2"></i> Đặt Món
                        </button>
                    </div>
                </div>

            </div>
            @include('carts.Checkout')
        </form>
    </div>
</main>

@include('carts.Update')

@endsection