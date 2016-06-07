@extends('template')

@section('body-content')
    <body class="mypage-wrapper" ontouchstart="">
    @include('veryTopNav')
    <div class="mypage-details">
        <div class="name">
            Name : <strong>{{Session::get('name')}}</strong>
        </div>
        <div class="remain">
            Remain : <strong>{{ $data['remain'] }}</strong>  Won
        </div>
        <div class="in-process">
            Inprocess : <strong>{{ $data['in_progress'] }}</strong>
        </div>
        <div class="done">
            Done : <strong>{{ $data['done'] }}</strong>
        </div>
    </div>
    <div class="mypage-content-wrapper">

    </div>
    </body>
    <div class="ba-modal-wrapper" style="display:none;">
    </div>
@endsection
@section('js-content')
    <script>
        $(document).on('click','.content',function(){
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
        function getContent(skip,num){
            status = 'in_progress';
            var param = '&skip='+skip+'&num='+num;
            var content = '';
            console.log(param);
            $.ajax({
                url:'{{ URL::to('/ajaxMyItem') }}',
                type:'get',
                data:param,
                success:function(result){
                    $('.mypage-content-wrapper').append(result);
                    if(result.match(/data-id/g) < 5){
                        $('.more-button').addClass('disabled');
                    }
                }
            })
            console.log(content);
            return content;
        }
        getContent(0,100);
    </script>
@endsection