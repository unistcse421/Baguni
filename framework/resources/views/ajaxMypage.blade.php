@foreach($contents as $content)
    <div class="content" data-id="{{ $content->id }}">
        <div class="title">
            {{ $content->title }}
        </div>
        <div class="box-wrapper">
            <div class="box
                @if($content->status == 'reg')
                    active
                    @endif
                    ">
                Register
            </div>
            <div class="box
            @if($content->status == 'zzim')
                    active
                    @endif
                    ">
                Zzim
            </div>
            <div class="box
            @if($content->status == 'in_progress')
                    active
            @endif
                    ">
                InProcess
            </div>
            <div class="box
@if($content->status == 'in_baguni')
                    active
                    @endif
                    ">
                InBaguni
            </div>
            <div class="box
@if($content->status == 'done')
                    active
                    @endif
                    ">
                Done
            </div>

        </div>
    </div>
@endforeach