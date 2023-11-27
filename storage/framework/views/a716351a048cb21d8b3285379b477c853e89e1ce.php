<?php if(count($errors) > 0): ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="alert m-alert m-alert--default alert-danger" role="alert">
            <?php echo e($error); ?>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php elseif(session()->has('fail')): ?>
    <div class="alert m-alert m-alert--default alert-danger" role="alert">
        <?php echo e(session()->get('fail')); ?>

    </div>
<?php elseif(session()->has('success')): ?>
    <div class="alert m-alert m-alert--default alert-success" role="alert">
        <?php echo e(session()->get('success')); ?>

    </div>
<?php endif; ?>