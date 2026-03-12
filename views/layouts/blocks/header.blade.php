<?php

use App\Controllers\UserController;


?>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" data-navbar-on-scroll="data-navbar-on-scroll">

    <div class="container">

        <a class="navbar-brand d-inline-flex" href="/">
            <img class="d-inline-block" src="{{asset('assets/img/gallery/logo.svg')}}" alt="logo" />
            <span class="text-1000 fs-3 fw-bold ms-2 text-gradient">foodwaGon</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- MENU -->
            <ul class="navbar-nav mx-auto flex-nowrap align-items-center">

                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="#">Trang chủ</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="#">Menu</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="#">Giỏ hàng</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="#">Đơn hàng</a>
                </li>
                <li>
                    <form class="d-flex align-items-center flex-nowrap">

                        <div class="input-group-icon pe-2">
                            <i class="fas fa-search input-box-icon text-primary"></i>
                            <input class="form-control border-0 input-box bg-100" type="search" placeholder="Search Food">
                        </div>

                        <button class="btn btn-white shadow-warning text-warning text-nowrap" type="submit">
                            <i class="fas fa-search me-2"></i>Search
                        </button>

                    </form>
                </li>

                <li class="nav-item">

                </li>

            </ul>
            <div class="d-flex align-items-center flex-shrink-0">
            <?php if (isset($_SESSION['user'])): ?>

                <a class="nav-link text-truncate" style="max-width: 150px;" title="Xin chào <?= $_SESSION['user']['name'] ?>">Xin chào <?= $_SESSION['user']['name'] ?></a>
                <a class="nav-link text-danger ms-2 flex-shrink-0" href="{{ route('logout') }}">Đăng xuất</a>

            <?php else: ?>

                <a class="nav-link flex-shrink-0" href="{{ route('login') }}">Đăng nhập</a>

            <?php endif; ?>
            </div>




        </div>
    </div>
</nav>