
@if (!request()->cookie('popup'))
    <style>
        .overlay {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, .7);
            transition: opacity .5s;
            z-index: 9999;
            visibility: visible;
            opacity: 1
        }

        .overlay:target {
            visibility: visible;
            opacity: 1
        }

        #popup1 .popup {
            margin: 0 auto;
            padding: 50px 20px;
            background: #fff;
            border-radius: 0;
            width: 690px;
            position: relative;
            text-align: center;
            top: 50% !important;
            position: fixed !important;
            -moz-transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
            -o-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            right: 0;
            left: 0
        }
        @media only screen and (max-width: 768px) {
            #popup1 .popup {
                width: 85%;
            }
        }

        #popup1 .popup h2 {
            margin-top: 0;
            color: #333
        }

        #popup1 .popup .close-popup {
            position: absolute;
            top: 0;
            right: 0;
            transition: all .2s;
            font-size: 30px;
            font-weight: 400;
            text-decoration: none;
            text-align: center;
            background: #333;
            border-radius: 0;
            cursor: pointer;
            float: right;
            padding: 0;
            color: #fff;
            margin-top: 0;
            margin-right: 0;
            height: 40px;
            width: 40px;
            line-height: 45px
        }

        #popup1 .popup .close-popup:hover {
            color: #551400
        }

        #popup1 .popup .content {
            max-height: 30%;
            overflow: auto
        }

        #popup1 .newletter-title h2 {
            font-size: 24px;
            text-transform: uppercase;
            color: #000;
            font-weight: 700;
            letter-spacing: 3px;
            margin: 0 0 15px
        }

        #popup1 .box-content label {
            font-weight: 400;
            max-width: 560px;
            display: inline-block;
            margin-bottom: 5px;
            font-size: 14px;
            line-height: 26px
        }

        .newletter-popup {
            background: #fff;
            top: 50% !important;
            position: fixed !important;
            padding: 0;
            text-align: center;
            -moz-transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
            -o-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            transform: translateY(-50%)
        }

        #popup1 #frm_subscribe .forn-control {
            background: #ebebeb none repeat scroll 0 0;
            border: medium none;
            height: 40px;
            width: 65%;
            margin: 5px 0;
            padding-left: 15px
        }

        #popup1 #frm_subscribe a {
            cursor: pointer;
            border: none;
            background: #333;
            padding: 3px 25px;
            text-transform: uppercase;
            font-size: 14px;
            color: #fff;
            font-weight: 600;
            line-height: 34px;
            display: inline-block;
            border-radius: 0;
            letter-spacing: 2px
        }

        #popup1 .box-content .subscribe-bottom {
            margin-top: 20px
        }

        #popup1 .box-content .subscribe-bottom #newsletter_popup_dont_show_again {
            display: inline-block;
            margin: 0;
            vertical-align: middle;
            margin-top: -1px
        }

        #popup1 .box-content .subscribe-bottom label {
            margin: 0;
            font-weight: 400;
            max-width: 650px;
            display: inline-block;
            margin-bottom: 5px;
            font-size: 12px
        }

        .form-group label {
            text-align: left
        }

        .error {
            color: red
        }
        #popup1 {
            display: none;
        }

    </style>
    <div id="popup1" class="overlay">
        <div class="popup"> <a class="close-popup" onclick="hide_popup()" href="javascript:;">&times;</a>
            <div id="dialog" class="window">

                <div class="box">
                    <div class="newletter-title">
                        <h2>Đăng kí nhận khuyến mại ngay</h2>
                    </div>
                    <div class="box-content newleter-content">
                        <!-- <label>Subscribe to our newsletters now and stay up-to-date with new collections, the latest
                            lookbooks and exclusive offers.</label> -->
                        <div id="frm_subscribe">
                            <form name="subscribe" id="subscribe_popup">
                                <div>
                                    <div class="form-group">
                                        <input type="text" value="" class="forn-control" placeholder="Tên tài khoản (KU)" name="name"
                                            id="fname">
                                        <div><span class="error error-name" id="error-name"></span></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" value="" class="forn-control" placeholder="Số điện thoại (Zalo)"
                                            name="phone" id="fphone">
                                        <div><span class="error error-phone" id="error-phone"></span></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" value="" class="forn-control" placeholder="Họ và tên"
                                            name="email" id="femail">
                                        <div><span class="error error-email" id="error-email"></span></div>
                                    </div>
                                    <a class="mt-3" class="button" onclick="subscribepopup()"><span>Gửi</span></a>
                                </div>
                            </form>
                        </div>
                        <!-- /#frm_subscribe -->
                    </div>
                    <!-- /.box-content -->
                </div>
            </div>
        </div>
        {{-- <script>
        function hide_popup() {
                document.getElementById("popup1").style.display = "none";
            }
        </script>
        <script>
            document.getElementById("popup1").style.display = "none";
            if(!localStorage.getItem('KUBET_show')) {
                setTimeout(function(){
                    document.getElementById("popup1").style.display = "block";
                }, 3000)
            }


            function subscribepopup() {
                let name = document.getElementById('fname').value;
                let email = document.getElementById('femail').value;
                let phone = document.getElementById('fphone').value;
                console.log(/(84|0[3|5|7|8|9])+([0-9]{8})\b/.test(phone));
                console.log(name.length);
                let flag = true;
                if (!/(84|0[3|5|7|8|9])+([0-9]{8})\b/.test(phone)) {
                    document.getElementById('error-phone').innerHTML = 'Mời nhập số điện thoại';
                    flag = false;
                } else {
                    document.getElementById('error-phone').innerHTML = ''
                };
                if (name.length < 1) {
                    document.getElementById('error-name').innerHTML = 'Mời nhập tên';
                    flag = false;
                } else {
                    document.getElementById('error-name').innerHTML = ''
                };
                if (email.length < 2) {
                    document.getElementById('error-email').innerHTML = 'Mời nhập Họ và tên';
                    flag = false;
                } else {
                    document.getElementById('error-email').innerHTML = '';
                };
                if (flag) {
                    let data = new FormData;
                    data.append('name', name);
                    data.append('email', email);
                    data.append('phone', phone);
                    fetch('{!! route('apiSendInfo') !!}', {
                        method: 'post',
                        body: data,
                    });
                    $('body').find("#popup1").hide();
                    localStorage.setItem('KUBET_show', true)
                } else {
                    return false;
                };
            }

            $(".btn-100k, a:contains('NHẬN NGAY 100k')").on('click', function(e){
                e.preventDefault();
                document.getElementById("popup1").style.display = "block";
            })
            $(document).on('click', '.btn-100k', function(e){
                e.preventDefault();
                $('body').find("#popup1").show();
            })

        </script> --}}
    </div>
@endif
