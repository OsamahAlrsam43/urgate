<?php $__env->startSection('title'); ?>
    <?php echo e($page->name[App::getLocale()]); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <!-- Start page-heder -->
    <div class="page-header">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start d-flex -->
            <div class="d-flex align-items-center justify-content-center">
                <i class="icons8-plane"></i>
                <span><?php echo e($page->name[App::getLocale()]); ?></span>
            </div>
            <!-- End d-flex -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End page-header -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="travel-inner">
        <!-- Start container-fluid -->
        <div class="container">
            <!-- Start inner-head-gp -->
            <div class="inner-head-gp d-flex align-items-center justify-content-between">
                <!-- Start inner-head -->
                <div class="inner-head d-flex align-items-center">
                    <i class="icons8-view-details"></i>
                    <div>
                        <span><?php echo e($page->title[App::getLocale()]); ?>:</span>
                    </div>
                </div>
                <!-- End inner-head -->
            </div>
            <!-- End inner-head-gp -->
            <!-- Start travel-post -->
            <div class="travel-post">
                <!-- Start travel-post-text -->
                <div class="travel-post-text">
                    <?php echo $page->content[App::getLocale()]; ?>

                </div>
                <!-- End  travel-post-text -->
            </div>
            <!-- End travel-post -->
        </div>
        <!-- End container-fluid -->
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master-front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>