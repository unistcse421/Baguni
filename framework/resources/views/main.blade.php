@extends('template')

@section('body-content')
    <body class="main-wrapper">
    @include('veryTopNav')
    <div class="main-sub-nav">
        <div class="center-menu">
            <a href="#" class="content" data-which="buy">
                Buy
            </a>
            <a href="#" class="content" data-which="sell">
                Sell
            </a>
            {{--<a href="#" class="content">--}}
                {{--Inprocess--}}
            {{--</a>--}}
            {{--<a href="#" class="content">--}}
                {{--Done--}}
            {{--</a>--}}
        </div>
    </div>
    <div class="main-content-wrapper">
        <div class="added-content">
        </div>
        <div class="more-button">More</div>
    </div>
    <div class="main-menu-wrapper">
        <input name="search" type="text" placeholder="Search" class="main-search">
        <p class="menu-title">
            PROFILE
        </p>
        <p class="menu-info">
            Name : <strong>{{ Session::get('name') }}</strong>
        </p>
        <p class="menu-info">
            Remain : <strong>{{$data['remain']}} Won</strong>
        </p>
        <p class="menu-info">
            Register : <strong>{{$data['reg']}}</strong>
        </p>
        <p class="menu-info">
            ZZim : <strong>{{$data['zzim']}}</strong>
        </p>
        <p class="menu-info">
            Inprogress : <strong>{{$data['in_progress']}}</strong>
        </p>
        <p class="menu-info">
            InBaguni : <strong>{{$data['in_baguni']}}</strong>
        </p>
        <p class="menu-info">
            Done : <strong>{{$data['done']}}</strong>
        </p>
    </div>
    </body>
    <div class="ba-modal-wrapper" style="display:none;">
        <div class="ba-modal">
            <div class="upper">
                <h5 class="title">
                    Content Title
                </h5>
                <div class="buy">
                    15,000 Won
                </div>
            </div>
            <img src="images/2.jpg">
            <div class="lower">
                <div class="contents">
                    Lorem ipsum dolor sit amet, ac sapien id ac ultricies orci, tempor mauris. Lacus velit donec donec at malesuada consequat, nulla arcu at sagittis.
                    <div class="name">Uploader : <strong>Oh HyeonJun</strong></div>
                </div>
                <a href="#" class="modal-button">찜하기</a>
            </div>
        </div>
    </div>
@endsection

@section('js-content')
    <script>
        var ajaxData = {
            skip : 0,
            num : 8,
            which : 'all',
        }
        function getContent(which,status,skip,num){
            status = 'reg';
            var param = 'which='+which+'&status='+status+'&skip='+skip+'&num='+num;
            var content = '';
            console.log(param);
            $.ajax({
                url:'{{ URL::to('/ajaxContent') }}',
                type:'get',
                data:param,
                success:function(result){
                    content = result;
                    $('.added-content').append(result);
                    if(result.match(/data-id/g) < ajaxData.num){
                        $('.more-button').addClass('disabled');
                    }
                }
            })
            console.log(content);
            return content;
        }

        $(document).on('ready',function(){
            getContent('all','reg',0,4);
        })
        var contentOn = false;
        $(document).on('click','.each-content',function(){
            var contentId = $(this).data('id');
            $.ajax({
                url:'{{ URL::to('/ajaxDetails') }}'+'/'+contentId,
                type:'get',
                success:function(result){
                    $('.ba-modal-wrapper').html(result);
                }
            })
            $('.ba-modal-wrapper').fadeIn('slow',function(){
                console.log(contentId);
                contentOn = true;
                $('body').css('overflow','hidden');
            })
        })
        $('body').on('keydown',function(e){
            if(e.keyCode === 27 && contentOn){
                $('.ba-modal-wrapper').fadeOut('slow',function(){
                    contentOn = false;
                    $('body').css('overflow','initial');
                });
            }
        })
        $('.ba-modal-wrapper').on('click',function(event){
            if(event.target == this && contentOn){
                $('.ba-modal-wrapper').fadeOut('slow',function(){
                    contentOn = false;
                    $('body').css('overflow','initial');
                });
            }
        })

        $('.main-sub-nav .content').on('click',function(){
            if(ajaxData.which != $(this).data('which')){
                $('.main-sub-nav .content').removeClass('active');
                $(this).addClass('active');
                $('.more-button').removeClass('disabled');
                ajaxData.skip = 0;
                ajaxData.which = $(this).data('which');
                console.log(ajaxData);
                $('.added-content').html('');
                getContent(ajaxData.which,'reg',ajaxData.skip,ajaxData.num);
            }
        })
        $('.more-button:not(.disabled)').on('click',function(){
            ajaxData.skip += ajaxData.num;
            getContent(ajaxData.which,'reg',ajaxData.skip,ajaxData.num);
        })
    </script>
@endsection