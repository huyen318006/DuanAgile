<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Chi tiết đơn hàng</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>

body{
background-image:
linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
url("https://images.unsplash.com/photo-1504674900247-0877df9cc836");

background-size:cover;
background-position:center;
background-attachment:fixed;
font-family: 'Segoe UI', sans-serif;
}

.order-card{
border-radius:20px;
box-shadow:0 10px 40px rgba(0,0,0,0.2);
}

.order-header{
background:linear-gradient(135deg,#ff7e5f,#ffb347);
color:white;
border-radius:20px 20px 0 0;
}

.food-img{
width:60px;
height:60px;
object-fit:cover;
border-radius:10px;
}

.status{
font-weight:bold;
padding:5px 15px;
border-radius:20px;
}

.status-success{
background:#d4edda;
color:#155724;
}

.total-box{
background:#fff3cd;
border-radius:15px;
padding:20px;
}

</style>
</head>

<body>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-lg-10">

<div class="card order-card border-0">

<!-- Header -->

<div class="order-header p-4">

<div class="d-flex justify-content-between align-items-center">

<h4 class="mb-0">
<i class="bi bi-receipt me-2"></i>
Chi tiết đơn hàng #{{ $order_id ?? ($oders[0]['order_id'] ?? '...') }}
</h4>

<span class="status status-success">Đã giao</span>

</div>

</div>

<!-- Body -->

<div class="card-body p-4 bg-white">

<div class="row mb-4">

<div class="col-md-6">
<p><b>Khách hàng:</b> {{ $_SESSION['user']['name'] }}</p>
<p><b>SĐT:</b> {{ $_SESSION['user']['phone'] }}</p>
<p><b>Địa chỉ:</b> {{ $_SESSION['user']['address'] }}</p>
</div>

<div class="col-md-6 text-md-end">
<p><b>Ngày đặt:</b> 12/03/2026</p>
<p><b>Phương thức:</b> Thanh toán khi nhận</p>
</div>

</div>

<hr>

<h5 class="mb-3">
<i class="bi bi-basket me-2"></i>Danh sách món ăn
</h5>

<div class="table-responsive">

<table class="table align-middle">

<thead class="table-light">
<tr>
<th>Món ăn</th>
<th>Giá</th>
<th>Trạng thái</th>

</tr>
</thead>

<tbody>

@foreach ($oders as $order)
<tr>
<td>
<div class="d-flex align-items-center">
<img src="{{ $order['food_image'] }}" class="food-img me-3">
{{ $order['food_name'] }}</div>
</td>

<td>{{ number_format(($order['price'] ?? 0) * ($order['quantity'] ?? 0)) }} VNĐ</td>
<td>
    <?php
    if($order['status']=='delivered'){
        echo '<span class="status status-success">Đã giao</span>';
    }else if($order['status']=='pending'){
        echo '<span class="status status-pending">Chờ xử lý</span>';
    }else   if($order['status']=='shipping'){
        echo '<span class="status status-shipping">Đang giao</span>';
    }else if($order['status']=='cancelled'){
        echo '<span class="status status-cancelled">Đã hủy</span>';
    }
    ?>
</td>


</tr>

@endforeach

</tbody>

</table>

</div>

<div class="row justify-content-end mt-4">

<div class="col-md-4">

<div class="total-box">





<hr>

<h5 class="d-flex justify-content-between text-danger">
<span>Tổng tiền:</span>
<span>{{ $total_price }}</span>
</h5>

</div>

</div>

</div>

<div class="text-center mt-4">

<a href="{{ route('/') }}" class="btn btn-dark rounded-pill px-4">
<i class="bi bi-arrow-left me-2"></i>
Quay lại đơn hàng
</a>

</div>

</div>

</div>

</div>

</div>

</div>

</body>
</html>