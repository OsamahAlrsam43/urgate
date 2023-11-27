<?php $__env->startSection('page-header'); ?>
    <!-- Start page-heder -->
    <div class="page-header">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start d-flex -->
            <div class="d-flex align-items-center justify-content-center">
                <i class="icons8-passport"></i>
                <span><?php echo e($visa->name[App::getLocale()]); ?></span>
            </div>
            <!-- End d-flex -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End page-header -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session()->has('fail')): ?>
        <div class="alert m-alert m-alert--default alert-danger" role="alert">
            <?php echo e(session()->get('fail')); ?>

        </div>
    <?php elseif(session()->has('success')): ?>
        <div class="alert m-alert m-alert--default alert-success" role="alert">
            <?php echo e(session()->get('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Start visa-inner -->
    <div class="visa-inner">
        <!-- Start container-fluid -->
        <div class="container-fluid">
        <?php echo $visa->description[App::getLocale()]; ?>

        <!-- Start inner-head-gp -->
            <div class="inner-head-gp d-flex align-items-center justify-content-between">
                <!-- Start inner-head -->
                <div class="inner-head d-flex align-items-center">
                    <i class="icons8-view-details"></i>
                    <div>
                        <span><?php echo app('translator')->getFromJson("alnkel.single-visa-title"); ?></span>
                        <p><?php echo app('translator')->getFromJson("alnkel.papers"); ?>: <?php echo e($visa->papers[App::getLocale()]); ?></p>
                    </div>
                </div>
                <!-- End inner-head -->
                <!-- Start inner-prices -->
                <div class="inner-prices d-flex align-items-center">
                    <i class="icons8-expensive-price"></i>
                    <span><?php echo app('translator')->getFromJson("alnkel.single-visa-cost"); ?>
                        : $<?php echo e($visa->price); ?> <?php echo app('translator')->getFromJson("alnkel.single-visa-person"); ?></span>
                </div>
                <!-- End inner-prices -->
            </div>
            <!-- End inner-head-gp -->

        <?php if(Auth::check()): ?>
            <!-- Start custom-form -->
                <form class="custom-form" method="post"
                      action="<?php echo e(route('visa-pre-checkout-form',['visa' => $visa->id])); ?>"
                      enctype="multipart/form-data">
                    <!-- Start form-row -->
                    <div class="form-row">
                        <!-- Start form-group -->
                        <div class="form-group col-lg-2 col-md-4 custom-form-group">
                            <label for="inputEmail4"><?php echo app('translator')->getFromJson("alnkel.single-visa-first-name"); ?>
                                <b>*</b>
                            </label>
                            <!-- Start custom-input -->
                            <div class="custom-input d-flex align-items-stretch">
                                <!-- Start input-icon -->
                                <div class="input-icon d-flex align-items-center">
                                    <i class="icons8-edit-file"></i>
                                </div>
                                <!-- End input-icon -->
                                <input type="text" name="first_name[]" value="<?php echo e(old('first_name.0')); ?>"
                                       class="form-control"
                                       id="inputEmail4"
                                       placeholder="<?php echo app('translator')->getFromJson("alnkel.single-visa-enter-first-name"); ?>...">
                                <?php if(isset($errors->messages()['first_name.0'])): ?>
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        <?php echo e($errors->messages()['first_name.0'][0]); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- End custom-input -->
                        </div>
                        <!-- End form-group -->
                        <!-- Start form-group -->
                        <div class="form-group col-lg-2 col-md-4 custom-form-group">
                            <label for="inputEmail4"><?php echo app('translator')->getFromJson("alnkel.single-visa-last-name"); ?>
                                <b>*</b>
                            </label>
                            <!-- Start custom-input -->
                            <div class="custom-input d-flex align-items-stretch">
                                <!-- Start input-icon -->
                                <div class="input-icon d-flex align-items-center">
                                    <i class="icons8-edit-file"></i>
                                </div>
                                <!-- End input-icon -->
                                <input type="text" name="last_name[]" value="<?php echo e(old('last_name.0')); ?>"
                                       class="form-control"
                                       id="inputEmail4"
                                       placeholder="<?php echo app('translator')->getFromJson("alnkel.single-visa-enter-last-name"); ?>...">
                                <?php if(isset($errors->messages()['last_name.0'])): ?>
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        <?php echo e($errors->messages()['last_name.0'][0]); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- End custom-input -->
                        </div>
                        <!-- End form-group -->
                        <!-- Start form-group -->
                        <div class="form-group col-lg-2 col-md-4 custom-form-group">
                            <label for="inputEmail4"><?php echo app('translator')->getFromJson("alnkel.single-visa-birth-place"); ?></label>
                            <!-- Start custom-input -->
                            <div class="custom-input d-flex align-items-stretch">
                                <!-- Start input-icon -->
                                <div class="input-icon d-flex align-items-center">
                                    <i class="icons8-edit-file"></i>
                                </div>
                                <!-- End input-icon -->
                                <input type="text" name="birth_place[]" value="<?php echo e(old('birth_place.0')); ?>"
                                       class="form-control"
                                       id="inputEmail4"
                                       placeholder="<?php echo app('translator')->getFromJson("alnkel.single-visa-enter-birth-place"); ?>...">
                                <?php if(isset($errors->messages()['birth_place.0'])): ?>
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        <?php echo e($errors->messages()['birth_place.0'][0]); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- End custom-input -->
                        </div>
                        <!-- End form-group -->
                        <!-- Start form-group -->
                        <div class="form-group col-lg-2 col-md-4 custom-form-group">
                            <label for="inputEmail4"><?php echo app('translator')->getFromJson("alnkel.single-visa-birth-date"); ?></label>
                            <!-- Start custom-input -->
                            <div class="custom-input d-flex align-items-stretch">
                                <!-- Start input-icon -->
                                <div class="input-icon d-flex align-items-center">
                                    <i class="icons8-edit-file"></i>
                                </div>
                                <!-- End input-icon -->
                                <input type="text" name="birth_date[]" value="<?php echo e(old('birth_date.0')); ?>"
                                       class="form-control datepicker date-mask"
                                       placeholder="<?php echo app('translator')->getFromJson("alnkel.single-visa-enter-birth-date"); ?>ا...">
                                <!-- <?php if(isset($errors->messages()['birth_date.0'])): ?>
                                    <div class="form-control-feedback" style="color: #f4516c;" >
                                        <?php echo e($errors->messages()['birth_date.0'][0]); ?>

                                    </div>
                                <?php endif; ?> -->
                            </div>
                            <!-- End custom-input -->
                        </div>
                        <!-- End form-group -->
                        <!-- Start form-group -->
                        <div class="form-group col-lg-2 col-md-4 custom-form-group">
                            <label for="inputEmail4"><?php echo app('translator')->getFromJson("alnkel.single-visa-nationality"); ?></label>
                            <!-- Start custom-input -->
                            <div class="custom-input d-flex align-items-stretch">
                                <!-- Start input-icon -->
                                <div class="input-icon d-flex align-items-center">
                                    <i class="icons8-edit-file"></i>
                                </div>
                                <!-- End input-icon -->
                                <input type="text" name="nationality[]" value="<?php echo e(old('nationality.0')); ?>"
                                       class="form-control"
                                       id="inputEmail4"
                                       placeholder="<?php echo app('translator')->getFromJson("alnkel.single-visa-enter-nationality"); ?> ...">
                                <?php if(isset($errors->messages()['nationality.0'])): ?>
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        <?php echo e($errors->messages()['nationality.0'][0]); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- End custom-input -->
                        </div>
                        <!-- End form-group -->
                        <!-- Start form-group -->
                        <div class="form-group col-lg-2 col-md-4 custom-form-group">
                            <label for="inputEmail4"><?php echo app('translator')->getFromJson("alnkel.single-visa-passport-number"); ?>
                                <b>*</b>
                            </label>
                            <!-- Start custom-input -->
                            <div class="custom-input d-flex align-items-stretch">
                                <!-- Start input-icon -->
                                <div class="input-icon d-flex align-items-center">
                                    <i class="icons8-edit-file"></i>
                                </div>
                                <!-- End input-icon -->
                                <input type="text" name="passport_number[]" value="<?php echo e(old('passport_number.0')); ?>"
                                       class="form-control" id="inputEmail4"
                                       placeholder="<?php echo app('translator')->getFromJson("alnkel.single-visa-enter-passport-number"); ?> ...">
                                <?php if(isset($errors->messages()['passport_number.0'])): ?>
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        <?php echo e($errors->messages()['passport_number.0'][0]); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- End custom-input -->
                        </div>
                        <!-- End form-group -->
                        <!-- Start form-group -->
                        <div class="form-group col-lg-2 col-md-4 custom-form-group">
                            <label for="inputEmail4"><?php echo app('translator')->getFromJson("alnkel.single-visa-passport-start-date"); ?></label>
                            <!-- Start custom-input -->
                            <div class="custom-input d-flex align-items-stretch">
                                <!-- Start input-icon -->
                                <div class="input-icon d-flex align-items-center">
                                    <i class="icons8-edit-file"></i>
                                </div>
                                <!-- End input-icon -->
                                <input type="text" name="passport_issuance_date[]"
                                       value="<?php echo e(old('passport_issuance_date.0')); ?>"
                                       class="form-control datepicker date-mask"
                                       placeholder="<?php echo app('translator')->getFromJson("alnkel.single-visa-enter-passport-start-date"); ?> ...">
                                <!-- <?php if(isset($errors->messages()['passport_issuance_date.0'])): ?>
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        <?php echo e($errors->messages()['passport_issuance_date.0'][0]); ?>

                                    </div>
                                <?php endif; ?> -->
                            </div>
                            <!-- End custom-input -->
                        </div>
                        <!-- End form-group -->
                        <!-- Start form-group -->
                        <div class="form-group col-lg-2 col-md-4 custom-form-group">
                            <label for="inputEmail4"><?php echo app('translator')->getFromJson("alnkel.single-visa-passport-end-date"); ?>
                                <b>*</b>
                            </label>
                            <!-- Start custom-input -->
                            <div class="custom-input d-flex align-items-stretch">
                                <!-- Start input-icon -->
                                <div class="input-icon d-flex align-items-center">
                                    <i class="icons8-edit-file"></i>
                                </div>
                                <!-- End input-icon -->
                                <input type="text" name="passport_expire_date[]"
                                       value="<?php echo e(old('passport_expire_date.0')); ?>"
                                       class="form-control datepicker date-mask"
                                       placeholder="<?php echo app('translator')->getFromJson("alnkel.single-visa-enter-passport-end-date"); ?> ...">
                                <?php if(isset($errors->messages()['passport_expire_date.0'])): ?>
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        <?php echo e($errors->messages()['passport_expire_date.0'][0]); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- End custom-input -->
                        </div>
                        <!-- End form-group -->
                        <!-- Start form-group -->
                        <div class="form-group col-lg-2 col-md-4 custom-form-group">
                            <label for="inputEmail4"><?php echo app('translator')->getFromJson("alnkel.single-visa-father-name"); ?></label>
                            <!-- Start custom-input -->
                            <div class="custom-input d-flex align-items-stretch">
                                <!-- Start input-icon -->
                                <div class="input-icon d-flex align-items-center">
                                    <i class="icons8-edit-file"></i>
                                </div>
                                <!-- End input-icon -->
                                <input type="text" name="father_name[]" value="<?php echo e(old('father_name.0')); ?>"
                                       class="form-control"
                                       id="inputEmail4"
                                       placeholder="<?php echo app('translator')->getFromJson("alnkel.single-visa-enter-father-name"); ?> ...">
                                <?php if(isset($errors->messages()['father_name.0'])): ?>
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        <?php echo e($errors->messages()['father_name.0'][0]); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- End custom-input -->
                        </div>
                        <!-- End form-group -->
                        <!-- Start form-group -->
                        <div class="form-group col-lg-2 col-md-4 custom-form-group">
                            <label for="inputEmail4"><?php echo app('translator')->getFromJson("alnkel.single-visa-mother-name"); ?></label>
                            <!-- Start custom-input -->
                            <div class="custom-input d-flex align-items-stretch">
                                <!-- Start input-icon -->
                                <div class="input-icon d-flex align-items-center">
                                    <i class="icons8-edit-file"></i>
                                </div>
                                <!-- End input-icon -->
                                <input type="text" name="mother_name[]" value="<?php echo e(old('mother_name.0')); ?>"
                                       class="form-control"
                                       id="inputEmail4"
                                       placeholder="<?php echo app('translator')->getFromJson("alnkel.single-visa-enter-mother-name"); ?> ...">
                                <?php if(isset($errors->messages()['mother_name.0'])): ?>
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        <?php echo e($errors->messages()['mother_name.0'][0]); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- End custom-input -->
                        </div>
                        <!-- End form-group -->
                        <!-- Start form-group -->
                        <div class="form-group col-lg-2 col-md-4 custom-form-group">
                            <label for="inputEmail4"><?php echo app('translator')->getFromJson("alnkel.single-visa-passport-image"); ?>
                                <b>*</b>
                            </label>
                            <!-- Start custom-input -->
                            <div class="custom-input d-flex align-items-stretch">
                                <!-- Start input-icon -->
                                <div class="input-icon d-flex align-items-center">
                                    <i class="icons8-edit-file"></i>
                                </div>
                                <!-- End input-icon -->
                                <div class="custom-file">
                                    <input type="file" name="passport_image[]" class="custom-file-input"
                                           id="customFile">
                                    <span class="custom-file-label" for="customFile"><?php echo app('translator')->getFromJson("alnkel.single-visa-browse-device"); ?>
                                        ...</span>
                                    <?php if(isset($errors->messages()['passport_image'])): ?>
                                        <div class="form-control-feedback" style="color: #f4516c;">
                                            <?php echo e($errors->messages()['passport_image'][0]); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- End custom-input -->
                        </div>
                        <!-- End form-group -->
                        <!-- Start form-group -->
                        <div class="form-group col-lg-2 col-md-4 custom-form-group">
                            <label for="inputEmail4"><?php echo app('translator')->getFromJson("alnkel.single-visa-personal-image"); ?>
                                <b>*</b>
                            </label>
                            <!-- Start custom-input -->
                            <div class="custom-input d-flex align-items-stretch">
                                <!-- Start input-icon -->
                                <div class="input-icon d-flex align-items-center">
                                    <i class="icons8-edit-file"></i>
                                </div>
                                <!-- End input-icon -->
                                <div class="custom-file">
                                    <input type="file" name="personal_image[]" class="custom-file-input"
                                           id="customFile">
                                    <span class="custom-file-label" for="customFile"><?php echo app('translator')->getFromJson("alnkel.single-visa-browse-device"); ?>
                                        ...</span>
                                    <?php if(isset($errors->messages()['personal_image'])): ?>
                                        <div class="form-control-feedback" style="color: #f4516c;">
                                            <?php echo e($errors->messages()['personal_image'][0]); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- End custom-input -->
                        </div>
                        <!-- End form-group -->
                        <!-- Start form-group -->
                        <div class="form-group col-lg-2 col-md-4 custom-form-group">
                            <label for="inputEmail4"><?php echo app('translator')->getFromJson("alnkel.single-visa-other-documents"); ?></label>
                            <!-- Start custom-input -->
                            <div class="custom-input d-flex align-items-stretch">
                                <!-- Start input-icon -->
                                <div class="input-icon d-flex align-items-center">
                                    <i class="icons8-edit-file"></i>
                                </div>
                                <!-- End input-icon -->
                                <div class="custom-file">
                                    <input type="file" name="other_documents[]" class="custom-file-input"
                                           id="customFile">
                                    <span class="custom-file-label" for="customFile"><?php echo app('translator')->getFromJson("alnkel.single-visa-browse-device"); ?>
                                        ...</span>
                                </div>
                            </div>
                            <!-- End custom-input -->
                        </div>
                        <!-- End form-group -->
                    </div>
                    <!-- Start form-group -->
                    
                        
                            
                        
                        
                        
                            
                            
                                
                            
                            
                            
                                
                                
                                    
                                        
                                    
                                
                            
                        
                        
                    
                    <!-- End form-group -->
                    <!-- End form-row -->
                <?php echo csrf_field(); ?>

                <!-- Start action-btns -->
                    <div class="action-btns d-flex align-items-center justify-content-end">
                        <a href="#" id="cloneForm"
                           class="btn-reset add-btn d-flex align-items-center justify-content-center"><i
                                    class="icons8-add-user-male"></i><span><?php echo app('translator')->getFromJson("alnkel.single-visa-add-another-applicant"); ?></span></a>
                        <button type="submit" id="blockButton"
                                class="btn-reset submit-btn d-flex align-items-center justify-content-center">
                            <i
                                    class="icons8-done"></i><span><?php echo app('translator')->getFromJson("alnkel.single-visa-finish-application"); ?></span>
                        </button>
                    </div>
                    <!-- End action-btns -->
                </form>
                <!-- End custom-form -->
            <?php else: ?>
                <div class="alert m-alert m-alert--default alert-danger" role="alert">
                    <?php echo app('translator')->getFromJson("alnkel.single-visa-please"); ?>, <a href="#" class="login" data-toggle="modal" data-target="#login_modal"><?php echo app('translator')->getFromJson("alnkel.single-visa-login"); ?></a> <?php echo app('translator')->getFromJson("alnkel.single-visa-for-reservation"); ?>
                </div>
            <?php endif; ?>
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End visa-inner -->

    <!-- Start fly-section -->
    <div class="fly-section section-bg section parallax fullscreen background" data-aos="fade-up" data-img-width="1920"
         data-img-height="1269" data-diff="100"
         data-oriz-pos="100%" style="background-image: url('/front-assets/images/content/section.jpg');">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start section-header -->
            <div class="section-header section-header-light d-flex align-items-center justify-content-center">
                <i class="icons8-passport"></i>
                <span><?php echo app('translator')->getFromJson("alnkel.latestVisas"); ?></span>
            </div>
            <!-- End section-header -->
            <!-- Start travelSection -->
            <div id="flySection" class="owl-carousel">
                <?php $__currentLoopData = $latest_visas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="item">
                        <?php echo $__env->make('includes.front.cards.visa',compact('visa'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <!-- End travelSection -->

            <!-- Start section-footer -->
            <div class="section-footer d-flex align-items-center justify-content-between">
                <!-- Start section-carousel-controls -->
                <div class="section-carousel-controls d-flex align-items-center">
                    <!-- Start homeCarouselPrev -->
                    <div id="flySectionPrev" class="custom-carousel-prev scale-icons-hover">
                        <i class="icons8-drop-down-arrow"></i>
                    </div>
                    <!-- End homeCarouselPrev -->

                    <!-- Start homeCarouselDots -->
                    <div id="flySectionDots" class="custom-carousel-dots d-flex align-items-center">
                        <button role="button" class="owl-dot active">
                            <span></span>
                        </button>
                        <button role="button" class="owl-dot">
                            <span></span>
                        </button>
                        <button role="button" class="owl-dot">
                            <span></span>
                        </button>
                    </div>
                    <!-- End homeCarouselDots -->

                    <!--Start homeCarouselNext -->
                    <div id="flySectionNext" class="custom-carousel-next scale-icons-hover">
                        <i class="icons8-drop-down-arrow"></i>
                    </div>
                    <!--End premiumCarouselNext -->
                </div>
                <!-- End section-carousel-controls -->
                <a href="#" class="view-all d-flex align-items-center">
                    <i class="icons8-grid"></i>
                    <span><?php echo app('translator')->getFromJson("alnkel.showAll"); ?></span>
                </a>
            </div>
            <!-- End section-footer -->


        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End fly-section -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('front-assets/js/jquery.blockUI.js')); ?>"></script>
    <script>
        $('#blockButton').click(function () {
            $.blockUI({
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .5,
                    color: '#fff'
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master-front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>