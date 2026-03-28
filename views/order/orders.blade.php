@extends('layouts.AdminLayout')

@section('content')
<section class="py-5" style="margin-top:120px; background: linear-gradient(135deg,#fff6f0,#f8f9fa);">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="fw-bold">{{ $food->name }}</h2>
            <p class="text-muted">Tuỳ chỉnh món ăn theo sở thích của bạn 🍔</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <form action="{{ route('order/add') }}" method="POST" onsubmit="return handleSubmit()">
                        @csrf
                        <input type="hidden" name="food_id" value="{{ $food->id }}">
                        <input type="hidden" name="totalPrice" id="totalPriceInput">

                        <div class="row g-0 flex-column flex-md-row">

                        <!-- ẢNH -->
                        <div class="col-md-5">
                            <img src="{{ asset('assets/img/gallery/' . $food->image) }}"
                                class="w-100"
                                style="object-fit:cover; max-height:420px;">
                            
                            <!-- MÔ TẢ -->
                            @if(!empty($food->description))
                            <div class="px-4 py-3">
                                <label class="fw-bold mb-2 d-block text-muted small uppercase">Mô tả sản phẩm</label>
                                <p class="mb-0 text-secondary" style="font-size: 0.95rem; line-height: 1.6;">
                                    {{ $food->description }}
                                </p>
                            </div>
                            @endif

                            <!-- KHÁCH HÀNG (Dưới ảnh) -->
                            <div class="p-4 pt-3 border-top bg-light">
                                <label class="fw-bold mb-3 d-block">Thông tin giao hàng</label>
                                
                                <div class="mb-3">
                                    <input type="text" name="receiver" class="form-control rounded-3 border-2" 
                                        placeholder="Tên người nhận" value="{{ $_SESSION['user']['name'] ?? '' }}">
                                </div>
                                
                                <div class="mb-3">
                                    <input type="tel" name="phone" class="form-control rounded-3 border-2" 
                                        placeholder="Số điện thoại" value="{{ $_SESSION['user']['phone'] ?? '' }}">
                                </div>
                                
                                <div class="mb-0">
                                    <textarea name="note" class="form-control rounded-3 border-2" 
                                        rows="2" placeholder="Ghi chú đơn hàng (không bắt buộc)"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- NỘI DUNG -->
                        <div class="col-md-7">
                            <div class="p-4 p-lg-5">

                                <!-- TÊN + GIÁ -->
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                                    <h4 class="fw-bold mb-2">{{ $food->name }}</h4>
                                    
                                    <h5 class="text-danger fw-bold mb-0" id="totalPrice" name="totalPrice">
                                         đ
                                    </h5>
                                </div>

    <!-- SỐ LƯỢNG -->
    <div class="mb-4">
        <label class="fw-bold mb-2 d-block">Số lượng</label>
        <div class="quantity-box">
            <button type="button" onclick="decrease()">-</button>
            <input type="number" name="quantity" id="quantity" value="1" min="1">
            <button type="button" onclick="increase()">+</button>
        </div>
    </div>

<!-- SIZE -->
@if(!empty($food->size))
<div class="mb-4">
    <label class="fw-bold mb-3 d-block">Chọn size <span class="text-danger">*</span></label>
    <div class="option-grid">
        @foreach($food->size as $sz)
        <div class="option-box">
            <input type="radio" name="size"
                data-price="{{ $sz->price }}"
                id="size{{ $sz->id }}"
                value="{{ $sz->id }}">
            <label for="size{{ $sz->id }}">
                <div class="fw-bold">{{ $sz->name }}</div>
                <small>+{{ number_format($sz->price) }}đ</small>
            </label>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- TOPPING -->
@if(!empty($food->topping))
<div class="mb-4">
    <label class="fw-bold mb-3 d-block">Thêm topping</label>
    <div class="option-grid">
        @foreach($food->topping as $tp)
        <div class="option-box">
            <input type="checkbox"
                data-price="{{ $tp->price }}"
                id="tp{{ $tp->id }}"
                name="topping[]"
                value="{{ $tp->id }}">
            <label for="tp{{ $tp->id }}">
                <span>{{ $tp->name }}</span>
                <b>+{{ number_format($tp->price) }}đ</b>
            </label>
        </div>
        @endforeach
    </div>
</div>
@endif


    <!-- PAYMENT -->
    <div class="mb-4">
        <label class="fw-bold mb-3 d-block">Phương thức thanh toán</label>

        <div class="option-grid">

            <div class="option-box">
                <input type="radio" name="payment_method" id="cash" value="Cash" checked>
                <label for="cash">💵 Tiền mặt</label>
            </div>

            <div class="option-box">
                <input type="radio" name="payment_method" id="banking" value="Banking">
                <label for="banking">🏦 Chuyển khoản</label>
            </div>

            <div class="option-box">
                <input type="radio" name="payment_method" id="momo" value="Momo">
                <label for="momo">
                    <img src="{{ asset('assets/img/gallery/Logo-MoMo-Square.webp') }}">
                    <span>MoMo</span>
                </label>
            </div>

        </div>
    </div>


    <button class="btn btn-lg w-100 text-white fw-bold"
        style="background: linear-gradient(45deg,#ff6b00,#ff8c00); border:none; border-radius:50px;">
        🛒 Đặt Hàng
    </button>
                            </div>
                        </div>

                    </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</section>

<style>
.option-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.option-box input {
    display: none;
}

.option-box label {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 6px;
    padding: 16px;
    border: 2px solid #ddd;
    border-radius: 12px;
    cursor: pointer;
    transition: 0.3s;
    height: 90px;
}

.option-box input:checked + label {
    border-color: #ff6b00;
    background: #fff3e6;
    box-shadow: 0 0 0 2px rgba(255,107,0,0.2);
}

.quantity-box {
    display: flex;
    align-items: center;
    gap: 10px;
}

.quantity-box button {
    width: 40px;
    height: 40px;
    border: none;
    background: #ff6b00;
    color: #fff;
    font-size: 18px;
    border-radius: 50%;
}

.quantity-box input {
    width: 60px;
    text-align: center;
    border: 2px solid #ddd;
    border-radius: 8px;
    height: 40px;
}

.option-box label img {
    height: 28px;
    object-fit: contain;
}
</style>

<script>
function increase(){
    let qty = document.getElementById('quantity');
    qty.value = parseInt(qty.value) + 1;
    updatePrice();
}

function decrease(){
    let qty = document.getElementById('quantity');
    if(qty.value > 1){
        qty.value = parseInt(qty.value) - 1;
        updatePrice();
    }
}

document.addEventListener("DOMContentLoaded", function () {

    const sizeOptions = document.querySelectorAll('input[name="size"]');
    const toppingOptions = document.querySelectorAll('input[name="topping[]"]');
    const priceElement = document.getElementById('totalPrice');
    const quantityInput = document.getElementById('quantity');
    const totalInput = document.getElementById('totalPriceInput');

window.updatePrice = function () {
    let basePrice = {{ $food->price }};
    let sizePrice = 0;
    let toppingPrice = 0;

    sizeOptions.forEach(option => {
        if (option.checked) {
            sizePrice = parseInt(option.dataset.price);
        }
    });

    toppingOptions.forEach(option => {
        if (option.checked) {
            toppingPrice += parseInt(option.dataset.price);
        }
    });

    let quantity = parseInt(quantityInput.value) || 1;

    let totalPrice = (basePrice + sizePrice + toppingPrice) * quantity;

    priceElement.textContent = totalPrice.toLocaleString('vi-VN') + ' đ';

    if(totalInput){
        totalInput.value = totalPrice;
    }
}

    sizeOptions.forEach(el => el.addEventListener('change', updatePrice));
    toppingOptions.forEach(el => el.addEventListener('change', updatePrice));
    quantityInput.addEventListener('input', updatePrice);

    updatePrice();
});

// PAYMENT
document.addEventListener("DOMContentLoaded", function () {
    const momo = document.getElementById("momo");
    const banking = document.getElementById("banking");
    const cash = document.getElementById("cash");
    const qrBox = document.getElementById("qr-box");

    momo.addEventListener("change", function () {
        alert("⚠️ Thanh toán MoMo hiện chưa khả dụng!");
        qrBox.style.display = "none";
    });

    banking.addEventListener("change", function () {
        alert("⚠️ Chuyển khoản hiện chưa khả dụng!");
        qrBox.style.display = "none";
    });

    cash.addEventListener("change", function () {
        qrBox.style.display = "none";
    });
});
function handleSubmit(){
    updatePrice(); // tính lại giá cuối cùng

    // Kiểm tra size
    const sizeOptions = document.querySelectorAll('input[name="size"]');
    if(sizeOptions.length > 0){
        const sizeSelected = document.querySelector('input[name="size"]:checked');
        if(!sizeSelected){
            alert("⚠️ Vui lòng chọn size trước khi đặt hàng!");
            return false; 
        }
    }

    // Kiểm tra topping (Bỏ bắt buộc chọn)
    // const toppingCheckboxes = document.querySelectorAll('input[name="topping[]"]');
    // if(toppingCheckboxes.length > 0){
    //     const toppingSelected = document.querySelectorAll('input[name="topping[]"]:checked');
    //     if(!toppingSelected.length){
    //         alert("⚠️ Vui lòng chọn ít nhất 1 topping!");
    //         return false;
    //     }
    // }

    // Kiểm tra totalPrice
    const total = document.getElementById('totalPriceInput').value;
    if(!total || total == 0){
        alert("⚠️ Lỗi: chưa có giá tiền!");
        return false;
    }

    return true;
}
</script>

@endsection