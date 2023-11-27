<!-- Start item -->
<a href="{{ route('singleVisa',['visa' => $visa->id]) }}" class="card-block">
    <div class="card mb-3 visa-container">
        <div class="row no-gutters">
            <div class="col-md-5">
                <img src="{{ url('storage/app/public/'.$visa->thumb) }}" alt="{{ $visa->visa_type[App::getLocale()] }}"
                     class="img-fluid visa-img">

            </div>
            <div class="col-md-7">
                <div class="card-body">
                    <h5 class="card-title visa-title">{{ $visa->name[App::getLocale()] }}</h5>
                    <p class="card-text visa-papers">
                        <small>
                            <b>@lang("Required Papers"): </b>
                            {{ $visa->papers[App::getLocale()] }}
                        </small>
                    </p>
                    <p class="card-text visa-price">${{ $visa->price }}</p>
                </div>
            </div>
        </div>
    </div>
</a>

<div class="item" hidden>
    <!-- Start card-block -->
    <a href="{{ route('singleVisa',['visa' => $visa->id]) }}" class="card-block">
        <!-- Start card-block-content -->
        <div class="card-block-content d-flex flex-wrap align-content-between">
            <!-- Start card-block-top -->
            <div class="card-block-top d-flex align-items-center justify-content-between">
                <span class="card-type">{{ $visa->visa_type[App::getLocale()] }}</span>
                <span class="card-price">${{ $visa->price }}</span>
            </div>
            <!-- End card-block-top -->
            <!-- Start card-block-center -->
            <div class="card-block-center">
                <span class="card-title">{{ $visa->name[App::getLocale()] }}</span>
                <p class="card-desc">
                    <b>@lang("alnkel.papers"):</b>
                    {{ $visa->papers[App::getLocale()] }}
                </p>
            </div>
            <!-- End card-block-center -->
            <!-- Start card-block-bottom -->
            <div class="card-block-bottom d-flex align-items-center justify-content-end">
                <!-- Start card-section -->
                <div class="card-section d-flex align-items-center">
                    <i class="icons8-passport"></i>
                    <span>@lang("alnkel.visa")</span>
                </div>
                <!-- End card-section -->
            </div>
            <!-- End card-block-bottom -->
        </div>
        <!-- End card-block-content -->
        <img src="{{ Storage::url($visa->thumb) }}" alt="test"
             class="img-fluid">
    </a>
    <!-- End card-block -->
</div>
<!-- End item -->