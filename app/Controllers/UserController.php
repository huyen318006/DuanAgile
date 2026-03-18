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
            $id = $_SESSION['user']['id'];

            $user = Users::find($id);

            if (!$user) {
                header('location:' . APP_URL);
                exit();
            }

            // lấy dữ liệu
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            //update thông tin thường
            $user->update([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
            ]);

            //CHỈ update password nếu có nhập
            if (!empty($_POST['password'])) {

                if ($_POST['password'] != $_POST['repassword']) {
                    die("Mật khẩu không khớp");
                }

                $user->update([
                    'password' => $_POST['password']
                ]);
            }

            // cập nhật session
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['phone'] = $phone;
            $_SESSION['user']['address'] = $address;

            header('location:' . APP_URL . 'profile');
            exit();
        }
}