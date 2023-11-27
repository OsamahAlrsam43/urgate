<!--
    **********************************
    Template:  footer
    Created at: 8/20/2019
    Author: Mohammed Hamouda
    **********************************

    -->
<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="site-logo text-center">
                     <img height="100px" src="<?php echo e(asset('public/assets/img/logo.png')); ?>" alt="logo"></div>
            </div>
            <div class="col-md-3">
                <div class="about">
                    <h5><?php echo app('translator')->getFromJson("alnkel.About Us"); ?></h5>
                    <p><?php echo nl2br(e(\App\Setting::first()->about_content[App::getLocale()])); ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="newslette">
                    <h5><?php echo app('translator')->getFromJson("alnkel.Newsletter"); ?></h5>
                    <p><?php echo app('translator')->getFromJson("Write your email and we will send the latest offers to your mail"); ?></p>
                    <div class="input-email">
                        <input class="form-control" type="text" placeholder="<?php echo app('translator')->getFromJson("alnkel.Write your email"); ?>"><i class="fas fa-envelope"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="contact">
                    <h5><?php echo app('translator')->getFromJson("alnkel.Contact Us"); ?></h5>
                    <div class="whatsapp"><i class="fab fa-whatsapp"></i> <?php echo e(\App\Setting::first()->phone); ?></div> 
                    <div class="email"> <i class="fas fa-envelope"></i>  <?php echo e(\App\Setting::first()->mail); ?> </div>
                    <div class="email"> <i class="fas fa-map-pin"></i> <?php echo e(\App\Setting::first()->address); ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="info">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="copy text-center">
                        
                        <?php echo app('translator')->getFromJson('alnkel.copyRight'); ?>
                        <?php echo e(date("Y")); ?>

                        
                        </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="modal fade" id="login_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="login form-control"><?php echo app('translator')->getFromJson('alnkel.login-login'); ?> </button>
                        </div>
                        <?php if(count($errors) > 0): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="container add-new">
                    <form action="<?php echo e(route('front_login')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <?php echo e(method_field('PUT')); ?>

                        <div class="row">
                                <div class="col-md-12">
                                    <input class="login form-control" name="email" type="text" placeholder=" <?php echo app('translator')->getFromJson('alnkel.register-email'); ?> "><i class="fas fa-user"></i>

                                </div>
                                <div class="col-md-12">
                                    <input class="login form-control" name="password" type="password" placeholder=" <?php echo app('translator')->getFromJson('alnkel.register-password'); ?>"><i class="fas fa-lock"> </i>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="log form-control" value="<?php echo app('translator')->getFromJson('alnkel.login-login'); ?>">

                                </div>
                        </div>
                    </form>
                </div>
                <div class="container rig-options">
                    <div class="row aligen-items">




                        <div class="col-md-6 text-left small-center">
                            <a href="#"><?php echo app('translator')->getFromJson('alnkel.forget_password'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="register_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container actions">

                    <div class="row">

                        <div class="col-md-12">
                            <button class="login form-control"><?php echo app('translator')->getFromJson('alnkel.register-register'); ?></button>
                        </div>
                        
                        <?php if($message = Session::get('register-success')): ?>
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong><?php echo e($message); ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                    </form>
                </div>
                <form action="<?php echo e(route('user-register')); ?>" method="post">

                <div class="container add-new">
                    <div class="row">
                        <?php echo e(method_field('PUT')); ?>

                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <div class="col-md-12">
                            <input class="login form-control" type="text" name="name" placeholder="<?php echo app('translator')->getFromJson('alnkel.register-name'); ?>"><i class="fas fa-user"></i>
                        </div>
                        <div class="col-md-12">
                            <input class="login form-control" type="text" name="register_email" placeholder=" <?php echo app('translator')->getFromJson('alnkel.register-email'); ?>"><i class="fas fa-envelope"> </i>
                        </div>
                        <div class="col-md-12">
                            <input class="login form-control" type="text" name="company" placeholder=" <?php echo app('translator')->getFromJson('alnkel.register-company'); ?>"><i class="fas fa-building"> </i>
                        </div>
                        <div class="col-md-12">
                            <input class="login form-control" type="text" name="phone" placeholder="  <?php echo app('translator')->getFromJson('alnkel.register-phone'); ?>"><i class="fas fa-phone"> </i>
                        </div>
                        <div class="col-md-12">
                            <input class="login form-control" type="text" name="address" placeholder="  <?php echo app('translator')->getFromJson('alnkel.register-address'); ?>"><i class="fas fa-address-book"> </i>
                        </div>
                        <div class="col-md-12">
                            <input class="login form-control" type="password" name="register_password" placeholder="  <?php echo app('translator')->getFromJson('alnkel.register-password'); ?>"><i class="fas fa-lock"> </i>
                        </div>
                        <div class="col-md-12">
                            <input class="login form-control" type="password" name="register_password_confirmation" placeholder=" <?php echo app('translator')->getFromJson('alnkel.register-password-confirmation'); ?>"><i class="fas fa-lock"> </i>
                        </div>
                        <div class="col-md-12">
                            <input type="submit" class="log form-control" value="<?php echo app('translator')->getFromJson('alnkel.register-register'); ?>">
                        </div>
                    </div>
                </div></form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo e(asset('public/assets/js/main.js')); ?>"></script>
</body>
</html>