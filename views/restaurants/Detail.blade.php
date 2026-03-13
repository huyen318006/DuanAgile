@extends('layouts.AdminLayout')

@section('content')
<section class="py-6" style="margin-top:20px">
 <div class="container">
  <h2 class="restaurant-title mb-2">{{ $restaurant->name }}</h2>
  <p class="restaurant-slogan mb-5">{{ $restaurant->slogan }}</p>

  <div class="row">

   <div class="col-md-9">
    <div class="row">

     @foreach($foods as $food)

     <div class="col-md-4 mb-4">
      <div class="food-card">
       <span class="food-badge">Best Seller</span>
       <img class="food-img" src="{{ asset('assets/img/foods/'.$food->image) }}">

       <div class="food-body">
        <div class="food-name">{{ $food->name }}</div>

        <div class="food-rating">
         <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>

        <div class="d-flex justify-content-between align-items-center">
         <span class="food-price">{{ number_format($food->price) }} đ</span>

         <button class="add-cart-btn" data-bs-toggle="modal" data-bs-target="#foodModal{{ $food->id }}">
          <i class="fas fa-cart-plus"></i>
         </button>
        </div>

       </div>
      </div>
     </div>


     <!-- popup chọn size -->
     <div class="modal fade" id="foodModal{{ $food->id }}">
      <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">

        <form action="/cart/add" method="POST">

         <div class="modal-header">
          <h5>{{ $food->name }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
         </div>

         <div class="modal-body">

            <img src="{{ asset('assets/img/foods/'.$food->image) }}" style="width:100%;height:200px;object-fit:cover;border-radius:10px;margin-bottom:15px">

            <input type="hidden" name="food_id" value="{{ $food->id }}">

            @if(isset($food->sizes) && count($food->sizes))
            <label class="fw-bold mb-2">Chọn size</label>
            <div class="mb-3">
            @foreach($food->sizes as $size)
            <div>
            <input type="radio" name="size" value="{{ $size->id }}">
            {{ $size->name }} (+{{ number_format($size->price) }}đ)
            </div>
            @endforeach
            </div>
            @endif

            @if(isset($food->toppings) && count($food->toppings))
            <label class="fw-bold mb-2">Topping</label>
            <div>
            @foreach($food->toppings as $topping)
            <div>
            <input type="checkbox" name="topping[]" value="{{ $topping->id }}">
            {{ $topping->name }} (+{{ number_format($topping->price) }}đ)
            </div>
            @endforeach
            </div>
            @endif

        </div>

         <div class="modal-footer">
          <button class="btn btn-warning w-100">Thêm vào giỏ</button>
         </div>

        </form>

       </div>
      </div>
     </div>

     @endforeach

    </div>
   </div>


   <!-- giỏ hàng -->

   <div class="col-md-3">
    <div class="cart-box">
     <div class="cart-title"><i class="fas fa-shopping-cart"></i> Giỏ hàng</div>
     <p class="text-muted">Chưa có món nào</p>
     <button class="btn btn-warning w-100">Thanh toán</button>
    </div>
   </div>

  </div>
 </div>
</section>
<style>
.restaurant-title{
 font-size:32px;
 font-weight:700;
 color:#333;
}

.restaurant-slogan{
 color:#777;
 font-size:14px;
}

/* card món */
.food-card{
 border-radius:14px;
 overflow:hidden;
 background:#fff;
 transition:.3s;
 cursor:pointer;
 position:relative;
}

.food-card:hover{
 transform:translateY(-6px);
 box-shadow:0 12px 30px rgba(0,0,0,0.12);
}

/* ảnh món */
.food-img{
 height:200px;
 width:100%;
 object-fit:cover;
 transition:.4s;
}

.food-card:hover .food-img{
 transform:scale(1.05);
}

/* badge */
.food-badge{
 position:absolute;
 top:10px;
 left:10px;
 background:#ff5722;
 color:#fff;
 font-size:12px;
 padding:4px 8px;
 border-radius:6px;
 font-weight:600;
}

/* body */
.food-body{
 padding:14px 16px;
}

.food-name{
 font-size:16px;
 font-weight:600;
 color:#333;
 margin-bottom:6px;
}

.food-rating{
 font-size:13px;
 color:#ffa000;
 margin-bottom:6px;
}

.food-price{
 font-size:16px;
 font-weight:700;
 color:#ff5722;
}

.add-cart-btn{
 width:36px;
 height:36px;
 border-radius:50%;
 background:#ffb30e;
 border:none;
 color:#fff;
 display:flex;
 align-items:center;
 justify-content:center;
 transition:.25s;
}

.add-cart-btn:hover{
 background:#ff9800;
 transform:scale(1.1);
}

/* giỏ hàng */
.cart-box{
 background:#fff;
 border-radius:12px;
 padding:20px;
 box-shadow:0 8px 25px rgba(0,0,0,0.08);
 position:sticky;
 top:100px;
}

.cart-title{
 font-size:18px;
 font-weight:700;
 margin-bottom:15px;
}

</style>
@endsection