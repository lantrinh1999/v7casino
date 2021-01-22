<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family={{ urlencode(theme_option('primary_font', 'Roboto')) }}" rel="stylesheet" type="text/css">
    {!! Theme::header() !!}
    {!! Theme::partial('style.style') !!}
</head>
<body>

<div class="header">
    <div class="header-top">
        <div class="container py-2">
            <div class="row align-items-center">
                <div class="col-6 col-md-3 col-lg-1">
                    <a href="{{ url('/') }}">
                        <div class="logo text-left">
                            <img src="{{ get_object_image(theme_option('logo')) }}" alt="logo">
                        </div>
                    </a>
                </div>
                <div class="d-none d-md-block col-md-6 col-lg-7">
                    <div class="marque-box">
                        <marquee onmouseover="if (!window.__cfRLUnblockHandlers) return false; this.stop()"
                                 onmouseout="if (!window.__cfRLUnblockHandlers) return false; this.start()"
                                 scrollamount="6">
                            KU Casino99.net tiên phong giải trí online AI,
                            KUCasino99 chuyên trang cá cược trực truyến có thực lực nhất 2020, hàng nghàn giải thưởng
                            cao cấp đang chờ quý khách đến nhận!
                        </marquee>
                    </div>
                </div>
                <div class="col-6 text-right button-mobile-wrap d-block d-lg-none col-md-3 text-md-center">
                    <button class="toggle-menu btn btn-success">
                        <i class="fas fa-bars"></i> Menu
                    </button>
                </div>
                <div class="d-none d-lg-block col-md-3">
                    <div class="account-button">
                        <a href="#" class="btn-account btn-signup">Đăng ký</a>
                        <a href="#" class="btn-account btn-login">Đăng nhập</a>
                    </div>
                </div>
                <div class="d-none d-lg-block col-md-1 ">
                    <div class="download">
                        <a href="#">
                            <img src="http://www.pngmart.com/files/10/Download-Now-Button-PNG-File.png" alt="download">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="sub-menu-mobile d-lg-none">
            <div class="account-button">
                <a href="#" class="btn-account btn-signup">Đăng ký</a>
                <a href="#" class="btn-account btn-login">Đăng nhập</a>
                <a href="#" class="btn-account btn-signup">Đăng ký</a>
                <a href="#" class="btn-account btn-login">Đăng nhập</a>
            </div>
        </div>
    </div>

    <div class="header-menu d-none d-lg-block">
        <div class="container">
            <div class="header-menu-wrap">
                <nav class="menu-wrap">

                    {{-- memu here --}}
                    {!!
                        Menu::renderMenuLocation('main-menu', [
                            'options' => ['class' => 'menu'],
                            'view'    => 'main-menu',
                        ])
                    !!}
                </nav>
                <div class="search-box">
                    <form action="/search" class="form-search">
                        <input type="search" name="q" class="form-control" value="{{ Request::input('q') ?? null }}" placeholder="Tìm kiếm...">
                        <button class="btn btn-search" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>