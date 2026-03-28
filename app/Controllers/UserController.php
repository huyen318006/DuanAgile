<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Users;

use App\Models\Order;

class UserController
{
    public function login()
    {
        return view('login-out.login');
    }

  public function checklogin()
{
        $user = Users::where('email', $_POST['email'])->first();

        if ($user && $user->password == $_POST['password']) {
            $_SESSION['user'] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
               'phone' => $user->phone,
               'address' => $user->address,
               
            ];
          
            header('location:' . APP_URL);
            exit();
        } else {
            header('location:' . APP_URL . 'login?error=1');
            exit();
        }
}

    //logout
    public function logout()
    {
        session_start();
        session_destroy();
        session_unset();
        header('location:' . APP_URL);
        exit();
    }


        //register
        public function register()
        {
            return view('login-out.register');
        }
        public function addregister()
        {
            $email= $_POST['email'];
            $user = Users::where('email', $email)->first();
            if ($user) {
                header('location:' . APP_URL . 'register?error=2');
                exit();
            }
            $repassword = $_POST['repassword'];
            if ($repassword != $_POST['password']) {
                header('location:' . APP_URL . 'register?error=1');
                exit();
            }
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'phone' => $_POST['phone'],
            ];
            Users::create($data);
            header('location:' . APP_URL . 'login');
            exit();
        }
        public function forgotpassword()
        {
            return view('login-out.forgotpassword');
        }
        //send forgot password
        public function sendforgotpassword()
        {
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $user = Users::where('email', $email)->where('phone', $phone)->first();
            if ($user) {
               
                header('location:' . APP_URL . 'forgotpassword?step=1&email=' . $email . '&phone=' . $phone);
                exit();
            } else {
                header('location:' . APP_URL . 'forgotpassword?error=1');
                exit();
            }
        }
        public function updatepassword()
        {
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $user = Users::where('email', $email)->where('phone', $phone)->first();
            if ($user) {
             
                $user->update(['password' => $password]);
                header('location:' . APP_URL . 'login?reset=1');
                exit();
            } else {
                header('location:' . APP_URL . 'login');
                exit();
            }
        }


        //profile-hồ sơ cá nhân
        public function profile()
        {
            $oders= Order::where('user_id', $_SESSION['user']['id'])->get();
           

            return view('login-out.profile',compact('oders'));
        }
        public function orderforme()
        {
            $oders= Order::where('user_id', $_SESSION['user']['id'])->get();
           

            return view('login-out.orderforme',compact('oders'));
        }

        //Edit profile
        public function editprofile()
        {
            return view('login-out.editprofile');
        }

        //update profile
        public function updateprofile()
        {
            try {
                $id = $_SESSION['user']['id'];
                $user = Users::find($id);

                if (!$user) {
                    throw new \Exception("Không tìm thấy người dùng.");
                }

                // Lấy dữ liệu
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $phone = trim($_POST['phone'] ?? '');
                $address = trim($_POST['address'] ?? '');
                $password = $_POST['password'] ?? '';
                $repassword = $_POST['repassword'] ?? '';

                // 1. Validate trống
                if (!$name) throw new \Exception("Vui lòng nhập họ tên.");
                if (!$email) throw new \Exception("Vui lòng nhập email.");
                if (!$phone) throw new \Exception("Vui lòng nhập số điện thoại.");
                if (!$address) throw new \Exception("Vui lòng nhập địa chỉ.");

                // 2. Validate email định dạng
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new \Exception("Email không đúng định dạng.");
                }

                // 3. Validate email duy nhất (trừ bản thân)
                $existingUser = Users::where('email', $email)->where('id', '!=', $id)->first();
                if ($existingUser) {
                    throw new \Exception("Email này đã được sử dụng bởi tài khoản khác.");
                }

                // 4. Validate số điện thoại (10 số, bắt đầu bằng 0)
                if (!preg_match("/^(0[3|5|7|8|9])[0-9]{8}$/", $phone)) {
                    throw new \Exception("Số điện thoại không hợp lệ (10 số, bắt đầu bằng 0).");
                }

                // 5. Update thông tin cơ bản
                $user->update([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                ]);

                // 6. Xử lý mật khẩu nếu có nhập
                if (!empty($password)) {
                    if (strlen($password) < 6) {
                        throw new \Exception("Mật khẩu mới phải từ 6 ký tự trở lên.");
                    }
                    if ($password !== $repassword) {
                        throw new \Exception("Mật khẩu nhập lại không khớp.");
                    }
                    $user->update(['password' => $password]);
                }

                // Cập nhật session
                $_SESSION['user']['name'] = $name;
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['phone'] = $phone;
                $_SESSION['user']['address'] = $address;

                echo "<script>
                    alert('✅ Cập nhật hồ sơ thành công!');
                    window.location.href = '" . APP_URL . "profile';
                </script>";
                exit();

            } catch (\Exception $e) {
                echo "<script>
                    alert('❌ Lỗi: " . addslashes($e->getMessage()) . "');
                    window.history.back();
                </script>";
                exit();
            }
        }
}