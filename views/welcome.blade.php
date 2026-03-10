@extends('layouts.AdminLayout')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Thi PHP2 BL1 SP26</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item active">Thi PHP2 BL1 SP26</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Nội Quy</h3>
                        </div>
                        <div class="card-body">
                        <ul>
                            <li>Đề thi sử dụng <strong>base thi</strong> được cung cấp sẵn, làm bài trực tiếp trên base thi. Trong quá trình làm bài sinh viên vi phạm quy chế thi = học lại.</li>
                            <li>Nhà trường triển khai ký xác nhận kết quả thi tại website <a href="https://e360.poly.edu.vn/checkout" target="_blank">https://e360.poly.edu.vn/checkout</a>. Sinh viên phải thực hiện xác nhận kết quả thi ngay tại ca thi, trên phòng thi. <span class="text-danger">Trường hợp sinh viên không xác nhận sẽ không được công nhận kết quả thi.</span></li>
                            <li>
                                <b>Lưu ý khi đăng nhập</b> website <a href="https://e360.poly.edu.vn/checkout" target="_blank">https://e360.poly.edu.vn/checkout</a> sẽ vào trang chủ nhưng bị đẩy ra ngoài luôn (không lỗi). Nếu không đăng nhập được thì vui lòng báo ngay cho thầy trước <b>12h ngày 25/02</b> để tổng hợp danh sách báo Khảo thí khắc phục.
                            </li>
                            <li>Quá trình thi sẽ gồm <strong>45 phút thực hành</strong> và <strong>15 phút vấn đáp</strong>.</li>
                            <li>
                                <b>Đối với sinh viên offline:</b> Đi thi mang đầy đủ giấy tờ, có mặt tại phòng thi trước 5 phút, chuẩn bị đầy đủ sạc máy tính.
                            </li>
                            <li>Trong quá trình thi, tuyệt đối nghiêm túc, bất kỳ trường hợp thái độ sai nào cũng sẽ học lại.</li>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection