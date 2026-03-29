<!DOCTYPE html>

<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Sửa hồ sơ</title>

<!-- Bootstrap -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Fontawesome -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
background-image: linear-gradient(
rgba(0,0,0,0.7),
rgba(0,0,0,0.7)
),
url("https://images.unsplash.com/photo-1504674900247-0877df9cc836");
background-size: cover;
background-position: center;
background-attachment: fixed;
font-family: 'Segoe UI', sans-serif;
}

/* Card chính */
.card{
border-radius:20px;
backdrop-filter: blur(10px);
background: rgba(255,255,255,0.95);
transition: 0.3s;
}

.card:hover{
transform: translateY(-5px);
box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

/* Title */
.title{
color:#ff6a00;
font-weight:700;
letter-spacing:1px;
}

/* Input */
.form-control{
border-radius:12px;
padding:10px 15px;
border:1px solid #ddd;
transition: all 0.25s ease;
}

.form-control:focus{
border-color:#ff6a00;
box-shadow: 0 0 0 2px rgba(255,106,0,0.2);
}

/* Label */
label{
font-weight:500;
margin-bottom:5px;
}

/* Button */
.btn-warning{
background: linear-gradient(135deg,#ff9a44,#ff6a00);
border:none;
color:white;
font-weight:600;
transition: 0.3s;
}

.btn-warning:hover{
transform: translateY(-2px);
box-shadow: 0 8px 20px rgba(255,106,0,0.4);
}

.btn-secondary{
border-radius:30px;
}

/* Divider */
hr{
border-top:1px dashed #ccc;
}

/* Password section */
h6{
font-size:14px;
}

/* Responsive */
@media(max-width:768px){
.card{
padding:20px;
}
}

</style>

</head>

<body>

<div class="container py-5">
<div class="row justify-content-center">
<div class="col-lg-6">

<div class="card shadow-lg border-0 p-4">

<h3 class="text-center title mb-4">
<i class="fa fa-user-edit"></i> Sửa hồ sơ
</h3>

<form action="{{ route('updateprofile') }}" method="POST" onsubmit="return validateProfileForm()">

<!-- Name -->

<div class="mb-3">
<label>Họ tên</label>
<div class="input-group">
<span class="input-group-text"><i class="fa fa-user"></i></span>
<input type="text" name="name" id="name" class="form-control"
value="<?= $_SESSION['user']['name'] ?>">
</div>
</div>

<!-- Email -->

<div class="mb-3">
<label>Email</label>
<div class="input-group">
<span class="input-group-text"><i class="fa fa-envelope"></i></span>
<input type="email" name="email" id="email" class="form-control"
value="<?= $_SESSION['user']['email'] ?>">
</div>
</div>

<!-- Phone -->

<div class="mb-3">
<label>Số điện thoại</label>
<div class="input-group">
<span class="input-group-text"><i class="fa fa-phone"></i></span>
<input type="text" name="phone" id="phone" class="form-control"
value="<?= $_SESSION['user']['phone'] ?? '' ?>">
</div>
</div>

<!-- Address -->

<div class="mb-3">
<label>Địa chỉ</label>
<div class="input-group">
<span class="input-group-text"><i class="fa fa-map-marker"></i></span>
<input type="text" name="address" id="address" class="form-control"
value="<?= $_SESSION['user']['address'] ?? '' ?>">
</div>
</div>
<hr>

<!-- Password -->
<div class="mb-3">
<label>Mật khẩu mới (bỏ trống nếu không đổi)</label>
<div class="input-group">
<span class="input-group-text">
<i class="fa fa-lock"></i>
</span>
<input type="password" name="password" id="password" class="form-control">
</div>
</div>

<!-- Confirm Password -->
<div class="mb-3">
<label>Nhập lại mật khẩu</label>
<div class="input-group">
<span class="input-group-text">
<i class="fa fa-key"></i>
</span>
<input type="password" name="repassword" id="repassword" class="form-control">
</div>
</div>

<!-- Buttons -->

<div class="text-center mt-4">

<button type="submit" class="btn btn-warning px-4 me-2">
<i class="fa fa-save"></i> Cập nhật
</button>

<a href="{{ route('profile') }}" class="btn btn-outline-dark px-4">
Huỷ
</a>

</div>

</form>

<script>
function validateProfileForm() {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const address = document.getElementById('address').value.trim();
    const password = document.getElementById('password').value;
    const repassword = document.getElementById('repassword').value;

    // Kiểm tra trống
    if (!name) { alert("⚠️ Vui lòng nhập họ tên!"); return false; }
    if (!email) { alert("⚠️ Vui lòng nhập email!"); return false; }
    if (!phone) { alert("⚠️ Vui lòng nhập số điện thoại!"); return false; }
    if (!address) { alert("⚠️ Vui lòng nhập địa chỉ!"); return false; }

    // Kiểm tra định dạng email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("⚠️ Email không hợp lệ!");
        return false;
    }

    // Kiểm tra định dạng số điện thoại VN (10 số, bắt đầu bằng 0)
    const phoneRegex = /^0[0-9]{9}$/;
    if (!phoneRegex.test(phone)) {
        alert("⚠️ Số điện thoại không hợp lệ (phải có 10 số và bắt đầu bằng 0)!");
        return false;
    }

    // Kiểm tra mật khẩu (nếu có nhập)
    if (password) {
        if (password.length < 6) {
            alert("⚠️ Mật khẩu mới phải có ít nhất 6 ký tự!");
            return false;
        }
        if (password !== repassword) {
            alert("⚠️ Mật khẩu nhập lại không khớp!");
            return false;
        }
    }

    return true;
}
</script>

</div>

</div>
</div>
</div>

</body>
</html>
