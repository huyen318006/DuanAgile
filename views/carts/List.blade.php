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
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td><img src="{{ asset('assets/img/gallery/' . $food->image) }}" alt="{{ $food->name }}"
                                        width="100" class="rounded-circle"></td>
                                <td>{{ $food->name ?? 'N/A' }}</td>
                                <td>{{ $cart->quantity }}</td>
                                <td>{{ $food ? number_format($food->price, 0, ',', '.') . 'đ' : 'N/A' }}</td>
                                <td>{{ $food ? number_format($food->price * $cart->quantity, 0, ',', '.') . 'đ' : 'N/A' }}
                                </td>
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
    </main>
@endsection
