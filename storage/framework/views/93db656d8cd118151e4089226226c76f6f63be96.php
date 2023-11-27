<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->getFromJson("alnkel.visa"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <!-- Start page-heder -->
    <div class="page-header">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start d-flex -->
            <div class="d-flex align-items-center justify-content-center">
                <i class="icons8-plane"></i>
                <span><?php echo app('translator')->getFromJson("alnkel.visa"); ?></span>
            </div>
            <!-- End d-flex -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End page-header -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Start categorylist -->
    <div class="categorylist section">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start row -->
            <div class="row">
                <?php $__currentLoopData = $visas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4">
                        <?php echo $__env->make('includes.front.cards.visa',compact('visa'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <!-- End row -->
            <?php echo $__env->make('includes.front.pagination',['item' => $visas], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>

        <!-- End container-fluid -->
    </div>
    <!-- End categorylist -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master-front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>