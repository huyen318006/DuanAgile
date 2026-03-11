<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu - Food Order</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
        }

        .login-box {
            width: 380px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: fadeIn 1s;
        }

        .login-title {
            background: #ff5722;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        form {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: 0.3s;
        }

        input:focus {
            border-color: #ff5722;
            outline: none;
            box-shadow: 0 0 5px rgba(255, 87, 34, 0.4);
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #ff5722;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #e64a19;
            transform: scale(1.05);
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .login-link a {
            color: #ff5722;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .note {
            font-size: 13px;
            color: #777;
            margin-top: -10px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="login-box">

        <div class="login-title">
            🔑 Quên mật khẩu
        </div>
        <!--  -->
        <?php
        if (isset($_GET['step'])) {
        ?>
            <form method="post" action="<?= APP_URL ?>updatepassword">

                <input type="hidden" name="email" value="{{ $_GET['email'] }}">
                <input type="hidden" name="phone" value="{{ $_GET['phone'] }}">

                <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit">Đổi mật khẩu</button>

            </form>
        <?php
        } else {
        ?>
            <form method="post" action="{{ route('sendforgotpassword') }}">

                <div class="form-group">
                    <label>Email của bạn</label>
                    <input type="email" name="email" placeholder="Nhập email đã đăng ký" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" placeholder="Nhập số điện thoại đã đăng ký" required>
                </div>

                <div class="note">
                    Chúng tôi sẽ cần kiểm tra thông tin để xác minh.
                </div>

                <button type="submit">Gửi yêu cầu xác minh</button>

                <div class="login-link">
                    <a href="{{ route('login') }}">← Quay lại đăng nhập</a>
                </div>

                <?php
                if (isset($_GET['error'])) {
                ?>
                    <div style="color:white;background:red;padding:10px;border-radius:6px;margin-top:10px;">
                        Email không tồn tại!
                    </div>
                <?php
                } ?>

            </form>
        <?php
        }
        ?>
        <!--  -->





    </div>

</body>

</html>