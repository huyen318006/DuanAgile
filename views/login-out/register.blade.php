<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #ff9a44, #ff6a00);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-box {
            width: 420px;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .register-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #ff6a00;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: #ff6a00;
            outline: none;
            box-shadow: 0 0 5px rgba(255, 106, 0, 0.4);
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            background: #ff6a00;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #e55d00;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            color: #ff6a00;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>

    <div class="register-box">

        <h2>Đăng ký tài khoản</h2>

        <form action="{{ route('addregister') }}" method="POST">

            <div class="input-group">
                <label>Tên người dùng</label>
                <input type="text" name="name" required>
            </div>
            <div class="input-group">
                <label>phone</label>
                <input type="phone" name="phone" required>
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" required>
            </div>

            <div class="input-group">
                <label>Nhập lại mật khẩu</label>
                <input type="password" name="repassword" required>
            </div>

            <button type="submit">Đăng ký</button>

        </form>

        <div class="login-link">
            Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
        </div>

    </div>

</body>

</html>