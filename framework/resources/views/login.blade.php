@extends('template')

@section('body-content')
    <body class="login-wrapper">
    <div class="login-form-wrapper">
        <div class="login-title">
            Baguni
        </div>
        <div id="login-form">
            <form method="post" action="/123" id="real-login">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="text" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <input type="checkbox" name="remain"> <p class="check-label">Remember ID</p>
                <div class="form-warning">

                </div>
                <input type="submit" name="submit" value="Login" class="input-button">
            </form>
            <div class="detail-wrapper">
                <div class="item" id="join">
                    Join
                </div>
                <div class="item">
                    find Password
                </div>
            </div>
        </div>
        <div id="join-form" style="display:none;">
            <form method="post" action="/321" id="real-join">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="text" name="email" placeholder="Email">
                <input type="text" name="name" placeholder="Name">
                <input type="text" name="phone" placeholder="Phone">
                <input type="password" name="password" placeholder="Password">
                <input type="password" name="confirm" placeholder="Password Confirm">
                <input type="submit" name="submit" value="Join" class="input-button">
                <div class="form-warning">

                </div>
            </form>
            <div class="detail-wrapper">
                <div class="item" id="login">
                    Login
                </div>
            </div>
        </div>
    </div>
    </body>

@endsection

@section('js-content')
    <script>
        $('#real-join').on('submit',function(){
            $.ajax({
                url:'{{ URL::to('/ajaxJoin') }}',
                type:'post',
                data:$(this).serialize(),
                success:function(result){
                    var check = result.split(':');
                    if(check[0] == '0'){
                        $('#real-join .form-warning').text(check[1]).fadeIn().delay(500).fadeOut();
                        return false;
                    }else{
                        location.reload();
                    }
                }
            })
            return false;
        })
        $('#real-login').on('submit',function(){
            $.ajax({
                url:'{{ URL::to('/ajaxLogin') }}',
                type:'post',
                data:$(this).serialize(),
                success:function(result){
                    var check = result.split(':');
                    if(check[0] == '0'){
                        $('#real-login .form-warning').text(check[1]).fadeIn().delay(500).fadeOut();
                        return false;
                    }else{
                        location.href = '{{ URL::to('/main') }}';
                        return false;
                    }
                }
            })
            return false;
        })
        $('#join').on('click',function(){
            $('#login-form').slideUp('slow',function(){
                $('#join-form').slideDown()
            });
        })
        $('#login').on('click',function(){
            $('#join-form').slideUp('slow',function(){
                $('#login-form').slideDown()
            });
        })
    </script>
@endsection