<footer>
    <div class="footer-1">
        <div class="container">
            <div class="row">
                 {{-- footer menu here --}}
                @for ($i = 1; $i < 6; $i++)
                {!! Menu::renderMenuLocation("bet-footer-$i", ['view' => 'footer-menu']) !!}
                @endfor
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="footer-col border-0">
                        <div class="footer-qr">
                            <img src="{{ get_object_image(theme_option('img_qr') ?? '') }}" alt="qr">
                        </div>
                        {{-- <a href="#" class="qr-link">
                            <i class="fas fa-mobile-alt"></i> Mobile app
                        </a> --}}
                        <div class="qr-slogan mt-2">
                            <b>Tận hưởng mọi lúc đặt cược kịp thời</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-2">
        <div class="container">
            <div class="row">
                <div class="copyright">
                    {{-- <a href="#">
                        <img src="img/dmca.png" alt="dmca   ">
                    </a> --}}
                    <p class="copyright-paragraph">
                        {{ theme_option('copyright') }}
                    </p>
                    {{-- <img src="img/brand-lists.png" alt="brand" class="list-brand"> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="menu-mobile">
        <nav class="menu-wrap-mobile">
            {{-- mobile memu here --}}
            {!! Menu::renderMenuLocation('main-menu', ['view' => 'mobile-menu']) !!}
        </nav>
    </div>
</footer>
<!-- JS Library-->
{!! Theme::footer() !!}
<script>

    $(document).ready(function() {
        let html1 = $('#btn-signup').get(0).outerHTML;
        let html2 = $('#btn-login').get(0).outerHTML;
        setTimeout(function() {
            $('.mm-ocd__content').append(
                `<div class="account-button account-button-sm">
                    ${html1}
                    ${html2}
                    </div>`
            );
            $('.mm-spn--open').prepend(`<div class="search-box">
                            <form action="/search" class="form-search">
                            <input type="search" name="q" class="form-control" placeholder="Tìm kiếm...">
                            <button class="btn btn-search" type="submit">
                            <i class="fas fa-search"></i>
                            </button>
                            </form>
                            </div>`);
        }, 1000)
    });

</script>
</body>

</html>
