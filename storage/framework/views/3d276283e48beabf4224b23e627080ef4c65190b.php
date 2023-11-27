<form method="post" action="<?php echo e(route("charter.create.results")); ?>">
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
    <div class="container">
        <div class="search-box search-box pt-3 pb-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="options aligen-items text-right" id="options">
                                        <input type="radio" id="one_way" value="OneWay" name="flight_type" checked>
                                        <label for="one_way"><?php echo app('translator')->getFromJson("alnkel.one_way"); ?></label>
                                        <input type="radio" id="two_way" value="RoundTrip" name="flight_type">
                                        <label for="two_way"><?php echo app('translator')->getFromJson("alnkel.Round_Trip"); ?></label>
                                        <input type="radio" id="open_return" value="OpenReturn"
                                               name="flight_type">
                                        <label for="open_return"><?php echo app('translator')->getFromJson("alnkel.open_return"); ?></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-info active">
                                            <input type="radio" name="search_type" id="search" value="search" checked> <?php echo app('translator')->getFromJson("alnkel.Book_Flight"); ?>
                                        </label>
                                        <label class="btn btn-info" id="locked">
                                            <input type="radio" name="search_type" id="locked" value="locked"> <?php echo app('translator')->getFromJson("alnkel.Reserve_Seats"); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="container filter">
                            <div class="row">
                                <div class="col">
                                    <label class="d-block"><?php echo app('translator')->getFromJson("charter.from"); ?></label>
                                    <select class="form-control select2" name="from">
                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($country->id); ?>"><?php echo e($country->name[Lang::locale()]); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="d-block"><?php echo app('translator')->getFromJson("charter.to"); ?></label>
                                    <select class="form-control select2" name="to">
                                        <?php $__currentLoopData = $countries_order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($country->id); ?>"><?php echo e($country->name[Lang::locale()]); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="d-block"><?php echo app('translator')->getFromJson("charter.going"); ?></label>
                                    <input  class="form-control date" name="going" type="text">

                                <input type="number" name="pl1" class="form-control" value="3" style="width: 100%;float: left;text-align: center;">
                                  <i class="fa fa-plus" aria-hidden="true" style="position: absolute;top: 79px"></i>

                                </div>



                                <div class="col" id="coming-two-way">
                                    <label class="d-block"><?php echo app('translator')->getFromJson("charter.coming"); ?></label>
                                    <input class="form-control date" name="coming" type="text">

                                  <input type="number" name="pl2" class="form-control" value="3" style="width: 100%;float: left;text-align: center;">
                                  <i class="fa fa-plus" aria-hidden="true" style="position: absolute;top: 79px"></i>

                                </div>
                                <div class="col" id="coming-open-return">
                                    <label class="d-block"><?php echo app('translator')->getFromJson("alnkel.Duration"); ?></label>
                                    <select class="form-control select2" name="coming_duration">
                                        <option value="1">
                                            <?php echo app('translator')->getFromJson("alnkel.One month"); ?>
                                        </option>
                                        <option value="3">
                                            <?php echo app('translator')->getFromJson("alnkel.Three months"); ?>
                                        </option>
                                        <option value="6">
                                            <?php echo app('translator')->getFromJson("alnkel.Six month"); ?>
                                        </option>
                                        <option value="12">
                                            <?php echo app('translator')->getFromJson("alnkel.One Year"); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="container filter">
                            <div class="row">
                                <div class="col">
                                    <label class="d-block"><?php echo app('translator')->getFromJson("alnkel.Flight Class"); ?></label>
                                    <select class="form-control select2" name="flight_class" id="flight_class">
                                        <option value="Economy">
                                            <?php echo app('translator')->getFromJson("alnkel.Economy"); ?>
                                        </option>
                                        <option value="Business">
                                            <?php echo app('translator')->getFromJson("alnkel.Business"); ?>
                                        </option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="d-block" for="adult">
                                        <?php echo app('translator')->getFromJson("alnkel.Adults"); ?>
                                    </label>
                                    <select class="form-control select2" name="adults">
                                        <?php for($i=1;$i<=10;$i++): ?>
                                            <option><?php echo e($i); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="d-block" for="adult">
                                        <?php echo app('translator')->getFromJson("alnkel.Children"); ?>
                                    </label>
                                    <select class="form-control select2" name="children">
                                        <?php for($i=0;$i<=10;$i++): ?>
                                            <option>
                                                <?php echo e($i); ?>

                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="d-block" for="adult">
                                        <?php echo app('translator')->getFromJson("alnkel.Babies"); ?>
                                    </label>
                                    <select class="form-control select2" name="babies">
                                        <?php for($i=0;$i<=10;$i++): ?>
                                            <option><?php echo e($i); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                    <div class="col search-btn">
                                        <button class="btn main-button" id="submit-search">
                                            <i class="fas fa-search"> </i> <?php echo app('translator')->getFromJson("alnkel.Search"); ?>
                                        </button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

<script>
    $(function () {

        let flightType = $('[name=flight_type]'),
            search_type = $('[name=search_type]'),
            going = $('[name=going]'),
            coming = $('[name=coming]');

       search_type.on('change', function () {
            let val = $(this).val();
            let children = $('[name=children]'),
                babies = $('[name=babies]');

            if(val === "locked") {
                //children.attr("disabled", true);
              //  babies.attr("disabled", true);
            }else{
                children.removeAttr("disabled");
                babies.removeAttr("disabled");

            }
        });

      $('#locked').on('click', function () {
            let val = $("[name=search_type]:checked").val();
        val = "locked";
        console.log(val);
            let children = $('[name=children]'),
                babies = $('[name=babies]');

            if(val === "locked") {
              //  children.prop('disabled','disabled');
               // babies.prop('disabled','disabled');
              $('#locked').attr('checked', 'checked');
              $('#search').removeAttr('checked');

            }else{
                children.removeAttr("disabled");
                babies.removeAttr("disabled");
            }
        });


        flightType.on('change', function () {
            let comingOpenReturn = $('#coming-open-return select'),
                comingTwoWay = $('#coming-two-way input'),
                value = $('[name=flight_type]:checked').val();

            if (value === "OneWay") {
                comingOpenReturn.attr("disabled", true);
                comingTwoWay.attr("disabled", true);
            }

            if (value === "RoundTrip") {
                comingOpenReturn.attr("disabled", true);
                comingTwoWay.removeAttr("disabled");
            }

            if (value === "OpenReturn") {
                comingOpenReturn.removeAttr("disabled");
                comingTwoWay.attr("disabled", true);
            }
        });
        flightType.trigger("change");

        // Dates
        $('.date').datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            minDate: 0
        });

        going.datepicker('setDate', 'today');
        coming.datepicker('setDate', '+7 days');

        going.on('change', function () {
            let value = $(this).val();
            coming.datepicker('option', 'minDate', value);

            let goingDate = going.datepicker('getDate', '+7d');
            coming.datepicker('setDate', goingDate.getDate());
        });
    });
</script>