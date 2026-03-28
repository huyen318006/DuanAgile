<?php
namespace App\Controllers;

use App\Models\Vocher;
use App\Models\Users;

class VocherController
{
    public function store()
    {
        try {
            $email = $_POST['email'] ?? null;
            if(!isset($_SESSION['user'])){
                throw new \Exception("Vui lòng đăng nhập để nhận voucher.");
                
            }
            $user_id = $_SESSION['user']['id'];
            $user = Users::find($user_id);
            if($user->email != $email){
                throw new \Exception("Email của bạn không đúng với tài khoản đang sử dụng.");
            }
            


            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception("Vui lòng nhập email hợp lệ để nhận voucher.");
            }

            // Kiểm tra user đã nhận voucher chưa (giới hạn 1 người 1 lần)
            $existing = Vocher::where('user_id', $user_id)->first();
            if ($existing) {
                throw new \Exception("Email này đã nhận mã voucher: " . $existing->code);
            }

            // Tạo mã ngẫu nhiên: Vd: AG123456
            $randomCode = "AG" . strtoupper(substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6));

            Vocher::create([
                'user_id' => $user_id,
                'code' => $randomCode
            ]);

            echo "<script>
                alert('🎉 Đăng ký thành công! Mã voucher của bạn là: $randomCode');
                window.history.back();
            </script>";
            exit();

        } catch (\Exception $e) {
            echo "<script>
                alert('❌ " . addslashes($e->getMessage()) . "');
                window.history.back();
            </script>";
            exit();
        }
    }
}
