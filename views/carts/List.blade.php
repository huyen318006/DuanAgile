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
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="table-responsive">
                    <table class="table cart-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên Món</th>
                                <th scope="col">Size</th>
                                <th scope="col">Topping</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Tổng Tiền</th>
                                <th scope="col">Tuỳ Chọn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $key => $cart)
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
                            <tr data-cart-id="{{ $cart->id }}" data-price="{{ $unitPrice }}">
                                <th scope="row">{{ $key + 1 }}</th>
                                <td><img src="{{ asset('assets/img/gallery/' . $food->image) }}" alt="{{ $food->name }}"
                                        width="100" class="rounded-circle"></td>
                                <td>{{ $food->name ?? 'N/A' }}</td>
                                <td>
                                    @if($sizeObj)
                                        {{ $sizeObj->name }}
                                        <div class="text-muted" style="font-size:12px;">+{{ number_format($sizeObj->price, 0, ',', '.') }}đ</div>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($cartToppings))
                                        @foreach($cartToppings as $tp)
                                            <div>{{ $tp->name }} <span class="text-muted" style="font-size:12px;">(+{{ number_format($tp->price, 0, ',', '.') }}đ)</span></div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ number_format($unitPrice, 0, ',', '.') }}đ</td>
                                <td class="line-total">{{ number_format($unitPrice * $cart->quantity, 0, ',', '.') }}đ</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="{{ route('cart/' . $cart->id . '/delete') }}" method="post">
                                            <button onclick="return confirm('Bạn có chắc chắn muốn xóa không?')" type="submit"
                                                class="btn btn-cart-remove rounded-circle bg-light border">
                                                <i class="fa fa-times text-danger"></i>
                                            </button>
                                        </form>
                                        <button class="btn btn-cart-update rounded-circle bg-light border btn-edit-cart"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCartModal"
                                            data-cart-id="{{ $cart->id }}"
                                            data-food-id="{{ $food->id }}"
                                            data-food-name="{{ $food->name }}"
                                            data-food-price="{{ $food->price }}"
                                            data-food-image="{{ asset('assets/img/gallery/' . $food->image) }}"
                                            data-food-description="{{ $food->description }}"
                                            data-cart-quantity="{{ $cart->quantity }}"
                                            data-cart-size-id="{{ $cart->size_id ?? '' }}"
                                            data-cart-topping-ids="{{ $cart->topping_ids ?? '[]' }}">
                                            <i class="fa fa-edit text-primary"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="bg-light rounded p-4 cart-sidebar">
                    <h4 class="fw-bold mb-4">Thanh Toán</h4>

                    <div class="mb-3">
                        <label class="form-label fw-bold mb-1">Tên Khách Hàng</label>
                        <input type="text" class="form-control" id="checkoutName" name="checkout_name" value="{{ $user->name }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold mb-1">Số điện thoại</label>
                        <input type="tel" class="form-control" id="checkoutPhone" name="checkout_phone" value="{{ $user->phone }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold mb-1">Địa chỉ</label>
                        <textarea class="form-control" id="checkoutAddress" name="checkout_address" rows="2">{{ $user->address }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold mb-1">Ghi chú đơn hàng <span class="text-muted fw-normal">(optional)</span></label>
                        <textarea class="form-control" id="checkoutNotes" name="checkout_notes" rows="3" placeholder="Ví dụ: Giao trước 12h, không hành, ít cay..."></textarea>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="fw-bold mb-0">Tổng Tiền:</h5>
                        <h5 class="fw-bold text-primary mb-0" id="grandTotal">{{ number_format($total, 0, ',', '.') }}đ</h5>
                    </div>
                    <button class="btn btn-primary w-100 rounded-pill py-3 text-uppercase fw-bold" id="btnCheckout" type="button">
                        <i class="fas fa-check me-2"></i>Đặt Món
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

@include('carts.Update')
@include('carts.Checkout')

@endsection
