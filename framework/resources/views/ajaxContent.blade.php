@foreach($contents as $content)
    <div class="each-content" data-id="{{ $content->id }}">
        <div class="image-wrapper">
            <div class="inner-wrapper">
                <img src="{{ URL::asset('/images/thumbnail').'/'.$content->id.'.'.$content->image_ext }}">
            </div>

        </div>

        <div class="detail-wrapper">
            <h5 class="title">
                {{ $content->title }}
            </h5>
            <p class="price">{{$content->name}}</p>
            <div class="
            @if($content->buyer_id == 0)
                sell
            @else
                buy
            @endif
                    ">{{ number_format($content->price) }} Won</div>
        </div>
    </div>


@endforeach