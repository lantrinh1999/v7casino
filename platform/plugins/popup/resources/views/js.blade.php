        <script>
      function hide_popup() {
                $('body').find("#popup1").hide();
            }
        </script>
        <script>
            $('body').find("#popup1").hide();
            if(!localStorage.getItem('KUBET_show')) {
                setTimeout(function(){
                    $('body').find("#popup1").show();
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
                $('body').find("#popup1").show();
            })
            $(document).on('click', '.btn-100k', function(e){
                e.preventDefault();
                $('body').find("#popup1").show();
            })
            $(document).find('.btn-100k').on('click', 'a', function(e){
                e.preventDefault();
                $('body').find("#popup1").show();
                return false;
            })

        </script>