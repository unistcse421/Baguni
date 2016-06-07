<div class="ba-modal">
    <div class="upper">
        <h5 class="title">
            <?php echo e($content->title); ?>

        </h5>
        <div class="buy">
            <?php echo e(number_format($content->price)); ?> Won
        </div>
        <div class="date">
            <?php echo e($content->created_at); ?>

        </div>
    </div>
    <img src="<?php echo e(URL::asset('/images/thumbnail').'/'.$content->id.'.'.$content->image_ext); ?>">
    <div class="lower">
        <div class="contents">
            <?php echo e($content->contents); ?>

            <div class="name">Uploader : <strong><?php echo e($content->name); ?></strong></div>
        </div>
        <?php if($content->status == 'reg' && $content->uploader != Session::get('id')): ?>
            <a href="/mypage" class="modal-button" data-next="zzim" data-which="<?php if($content->seller_id != 0): ?>buyer_id <?php else: ?> seller_id <?php endif; ?>">ZZim</a>
        <?php elseif($content->status == 'zzim' && $content->seller_id == Session::get('id')): ?>
            <a href="/mypage" class="modal-button" data-next="in_progress">Progress</a>
        <?php elseif($content->status == 'in_progress' && $content->seller_id == Session::get('id')): ?>
            <a href="/mypage" class="modal-button" data-next="in_baguni">Baguni</a>
        <?php elseif($content->status == 'in_baguni' && $content->buyer_id == Session::get('id')): ?>
            <a href="/mypage" class="modal-button" data-next="done">Done</a>
        <?php /*<?php else: ?>*/ ?>
            <?php /*<a href="#" class="modal-button finished" data-next="">Finished</a>*/ ?>
        <?php endif; ?>
    </div>
</div>

<script>
    $('.modal-button').on('click',function(){
        var ajaxData = "";
        if($(this).data('next') == 'zzim'){
            ajaxData += $.trim($(this).data('which'))+"=<?php echo e(Session::get('id')); ?>&status="+$(this).data('next');
            console.log(ajaxData);
        }else if($(this).data('next') == 'in_progress' || $(this).data('next') == 'in_baguni'){
            ajaxData += 'status='+$(this).data('next');
        }else if($(this).data('next') == 'done'){
            ajaxData += 'status='+$(this).data('next');
        }
        $.ajax({
            url:'<?php echo e(URL::to('/updateItem')); ?>'+'/'+<?php echo e($content->id); ?>,
            type:'get',
            data:ajaxData,
            success:function(result){
                location.replace();
                console.log(result);
            }
        })
    })
</script>