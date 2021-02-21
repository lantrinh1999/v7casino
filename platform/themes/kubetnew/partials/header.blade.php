<!doctype html>
<html lang="vi">
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

<div class="header header-all">
    <div class="header-top">
        <div class="container py-1 py-lg-2">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <div class="logo text-left">
                        <img src="{{ get_object_image(theme_option('logo')) }}" alt="logo">
                    </div>
                </a>
                <div class="d-block d-lg-none">
                    <div class="me-auto">
                        {{-- MOBILE --}}
                        <div class="account-button account-button-header d-flex">

                            <div class="div-btn">
                                {{-- #d26e4b --}}
                                <a href="{{ theme_option('register-button') ?? '#' }}" id="btn-login" class="btn-account btn-signup">Đăng ký</a>
                            </div>
                            <div class="div-btn">
                                <a href="{{ theme_option('login-button') ?? '#' }}" id="btn-signup" class="btn-account btn-login">Đăng nhập</a>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="navbar-toggler toggle-menu text-white" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                      <li class="nav-item">
                        <marquee class="text-white" onmouseover="if (!window.__cfRLUnblockHandlers) return false; this.stop()"
                                 onmouseout="if (!window.__cfRLUnblockHandlers) return false; this.start()"
                                 scrollamount="6">
                            {{ clean(theme_option('marquee') ?? null) }}
                        </marquee>
                      </li>
                    </ul>
                    <div style="min-width: 250px" class="d-flex justify-content-end">
                        <div class="account-button account-button-header d d-flex">
                            {{-- DESKTOP --}}
                            <div class="div-btn">
                                <a href="{{ theme_option('register-button') ?? '#' }}" class="btn-account btn-account-desktop d-block">
                                    + Đăng ký KU
                                </a>
                            </div>
                            <div class="div-btn">
                                <a href="{{ theme_option('login-button') ?? '#' }}" class="btn-account btn-login btn-account-desktop d-block">
                                    Đăng nhập KU
                                </a>
                            </div>
                        </div>
                        {{-- <div class="download">
                            <a target="_blank" href="{{ theme_option('download_url') ?? '//fb.com' }}">
                                <img width="111px" src="http://www.pngmart.com/files/10/Download-Now-Button-PNG-File.png" alt="download">
                            </a>
                        </div> --}}
                    </div>
                </div>
            </nav>
        </div>
        <div class="sub-menu-mobile d-lg-none">
            <div class="account-button">
                <a href="{{ theme_option('tutorial-button') ?? '#' }}" class="btn-account btn-signup">Hướng dẫn</a>
                <a href="{{ theme_option('download-button') ?? '#' }}" class="btn-account btn-login">Tải app</a>
                <a href="{{ theme_option('download-button') ?? '#' }}" class="btn-account btn-100k btn-login">Nhận 100k</a>

            </div>
        </div>
    </div>
    <div class="header-menu d-none d-lg-block">
        <div class="container">
            <div class="header-menu-wrap">
                <nav class="menu-wrap mx-auto">

                    {{-- memu here --}}
                    {!!
                        Menu::renderMenuLocation('main-menu', [
                            'options' => ['class' => 'menu'],
                            'view'    => 'main-menu',
                        ])
                    !!}
                </nav>
                {{-- <div class="search-box">
                    <form action="/search" class="form-search">
                        <input type="search" name="q" class="form-control" value="{{ Request::input('q') ?? null }}" placeholder="Tìm kiếm...">
                        <button class="btn btn-search" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div> --}}
            </div>
        </div>
    </div>
</div>