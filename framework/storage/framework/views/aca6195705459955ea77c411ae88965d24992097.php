<?php foreach($contents as $content): ?>
    <div class="content" data-id="<?php echo e($content->id); ?>">
        <div class="title">
            <?php echo e($content->title); ?>

        </div>
        <div class="box-wrapper">
            <div class="box
                <?php if($content->status == 'reg'): ?>
                    active
                    <?php endif; ?>
                    ">
                Register
            </div>
            <div class="box
            <?php if($content->status == 'zzim'): ?>
                    active
                    <?php endif; ?>
                    ">
                Zzim
            </div>
            <div class="box
            <?php if($content->status == 'in_progress'): ?>
                    active
            <?php endif; ?>
                    ">
                InProcess
            </div>
            <div class="box
<?php if($content->status == 'in_baguni'): ?>
                    active
                    <?php endif; ?>
                    ">
                InBaguni
            </div>
            <div class="box
<?php if($content->status == 'done'): ?>
                    active
                    <?php endif; ?>
                    ">
                Done
            </div>

        </div>
    </div>
<?php endforeach; ?>