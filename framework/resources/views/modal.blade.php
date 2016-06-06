<div class="ba-modal">
    <div class="upper">
        <h5 class="title">
            {{$content->title}}
        </h5>
        <div class="buy">
            {{ number_format($content->price) }} Won
        </div>
        <div class="date">
            {{ $content->created_at }}
        </div>
    </div>
    <img src="{{ URL::asset('/images/thumbnail').'/'.$content->id.'.'.$content->image_ext }}">
    <div class="lower">
        <div class="contents">
            {{ $content->contents }}
            <div class="name">Uploader : <strong>{{ $content->name }}</strong></div>
        </div>
        @if($content->status == 'reg' && $content->uploader != Session::get('id'))
            <a href="#" class="modal-button" data-next="zzim" data-which="@if($content->seller_id != 0)buyer_id @else seller_id @endif">ZZim</a>
        @elseif($content->status == 'zzim' && $content->seller_id == Session::get('id'))
            <a href="#" class="modal-button" data-next="in_progress">Progress</a>
        @elseif($content->status == 'in_progress' && $content->seller_id == Session::get('id'))
            <a href="#" class="modal-button" data-next="in_baguni">Baguni</a>
        @elseif($content->status == 'in_baguni' && $content->buyer_id == Session::get('id'))
            <a href="#" class="modal-button" data-next="done">Done</a>
        {{--@else--}}
            {{--<a href="#" class="modal-button finished" data-next="">Finished</a>--}}
        @endif
    </div>
</div>

<script>
    $('.modal-button').on('click',function(){
        var ajaxData = "";
        if($(this).data('next') == 'zzim'){
            ajaxData += $.trim($(this).data('which'))+"={{Session::get('id')}}&status="+$(this).data('next');
            console.log(ajaxData);
        }else if($(this).data('next') == 'in_progress' || $(this).data('next') == 'in_baguni'){
            ajaxData += 'status='+$(this).data('next');
        }else if($(this).data('next') == 'done'){
            ajaxData += 'status='+$(this).data('next');
        }
        $.ajax({
            url:'{{ URL::to('/updateItem') }}'+'/'+{{$content->id}},
            type:'get',
            data:ajaxData,
            success:function(result){
                location.replace();
                console.log(result);
            }
        })
    })
</script>