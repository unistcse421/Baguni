@extends('template')

@section('body-content')
    <body class="upload-wrapper" ontouchstart="">
    @include('veryTopNav')
    <div class="upload-menu-wrapper">
        <div class="inner-wrapper">
            <input type="text" placeholder="Title" class="main-search" id="title" style="width:90%;">
            <div class="button-wrapper">
                <a href="#" class="button" ontouchstart="" data-val="buy">
                    BUY
                </a>
                <a href="#" class="button" ontouchstart="" data-val="sell">
                    SELL
                </a>
            </div>
            <div class="right-stick-input">
                <input type="text" placeholder="Price" id="price">
                <div class="sticked">Won</div>
            </div>
            <a href="#" class="upload-submit">
                Submit
            </a>
        </div>
    </div>
    <div class="upload-main-wrapper">
        <div class="content-input-wrapper">
            <div class="file-uploader">
                <div class="inner">
                    <i class="fa fa-image fa-4x"></i>
                    <div class="intro">Drop your image</div>
                </div>
            </div>
            <div class="warning">

            </div>
            <textarea class="upload-content "rows="10"></textarea>
        </div>
    </div>
    </body>
@endsection
@section('js-content')
    <script src="js/dropzone.js"></script>
    <script>
        function number_with_delimiter(x) {
            return String(x).replace(/\B(?=(?:\d{3})+(?!\d))/g, ",");
        };
        function number_to_human_size(x) {
            var s = ['bytes', 'kB', 'MB', 'GB', 'TB', 'PB'];
            var e = Math.floor(Math.log(x) / Math.log(1024));
            return number_with_delimiter((x / Math.pow(1024, e)).toFixed(2) + " " + s[e]);
        };
        var SendData = {
            'type' : 'buy',
            'title' : '',
            'contents' : '',
        }
        $('.button-wrapper > *').on('click',function(){
            SendData.type = $(this).data('val');
            $('.button-wrapper > *').removeClass('active');
            $(this).addClass('active');
        })
        var styleImage = new Dropzone('.file-uploader',{
//            method:'get',
            paramName: 'File',
            maxFilesize: 2,
            url: "{{URL::to('/ajaxUpload') }}",
            clickable: true,
            autoProcessQueue: false,
            createImageThumbnails: true,
            acceptedFiles: 'image/*',
            addedfile: function(file){
            },
            thumbnail: function(file, dataUrl) {
                if(file.status != 'error')
                    $('.file-uploader > .inner').html('<img src="'+dataUrl+'"> <div class="filename">'+file.name+'</div><div class="size">'+number_to_human_size(file.size)+'</div>');
            },
            error: function(result,message){
                console.log(message);
                $('.warning').text(message).fadeIn().delay(1000).fadeOut();
            },
            sending: function(file,xhr,formData){
                formData.append('type',SendData.type);
                formData.append('_token','{{ csrf_token() }}');
                formData.append('title',$('#title').val());
                formData.append('price',$('#price').val());
                formData.append('contents',$('.upload-content').val());
            },
            success: function(result,message){
                location.href = '{{ URL::to("/mypage") }}';
            }
        });
        $('.upload-submit').on('click',function(){
            styleImage.processQueue();
        })
    </script>
@endsection
