<?php foreach($contents as $content): ?>
    <div class="each-content" data-id="<?php echo e($content->id); ?>">
        <div class="image-wrapper">
            <div class="inner-wrapper">
                <img src="<?php echo e(URL::asset('/images/thumbnail').'/'.$content->id.'.'.$content->image_ext); ?>">
            </div>

        </div>

        <div class="detail-wrapper">
            <h5 class="title">
                <?php echo e($content->title); ?>

            </h5>
            <p class="price"><?php echo e($content->name); ?></p>
            <div class="
            <?php if($content->buyer_id == 0): ?>
                sell
            <?php else: ?>
                buy
            <?php endif; ?>
                    "><?php echo e(number_format($content->price)); ?> Won</div>
        </div>
    </div>


<?php endforeach; ?>