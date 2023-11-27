<!-- Start search -->
<div class="search">
    <!-- Start custom-tabs-gp -->
    <div class="custom-tabs-gp">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start custom-tabs -->
            <ul class="nav nav-tabs d-flex align-items-center custom-tabs flex-wrap" id="searchTaps" role="tablist">
                <li class="nab-item">
                    <span class="search-title">@lang("alnkel.header-search-about")</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center active" id="fly-tab" data-toggle="tab" href="#charterTab"
                       role="tab" aria-controls="profile"
                       aria-selected="false">
                        <i class="icons8-plane"></i>
                        <span>@lang("alnkel.header-menu-flight")</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="charter-tab" data-toggle="tab" href="#charterTab"
                       role="tab" aria-controls="profile"
                       aria-selected="false">
                        <i class="icons8-plane"></i>
                        <span>@lang("charter.charter")</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="travel-tab" data-toggle="tab" href="#travelTab"
                       role="tab" aria-controls="home" aria-selected="true">
                        <i class="icons8-country"></i>
                        <span>@lang("alnkel.header-menu-travel")</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="visa-tab" data-toggle="tab" href="#visaTab"
                       role="tab" aria-controls="contact" aria-selected="false">
                        <i class="icons8-passport"></i>
                        <span>@lang("alnkel.header-menu-visa")</span>
                    </a>
                </li>
            </ul>
            <!-- End custom-tabs -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End custom-tabs-gp -->
    <!-- Start container-fluid -->
    <div class="container-fluid">
        <!-- Start custom-tabs-content -->
        <div class="tab-content custom-tab-content" id="myTabContent">
            <!-- Start tab-pane -->
            <div class="tab-pane fade" id="flyTab" role="tabpanel" aria-labelledby="fly-tab">
                <!-- Start tab-pane-choose -->
                <form class="tab-pane-choose" method="get" action="{{ route('search',['searchable' => 'flights']) }}">
                    <!-- Start d-flex -->
                    <div class="d-flex align-items-center flex-wrap check-form">
                        <!-- Start custom-control -->
                        <div class="custom-control custom-radio form-check-inline">
                            <input type="radio" id="customRadio1" name="ticket" class="custom-control-input"
                                   value="RoundTrip">
                            <label class="custom-control-label"
                                   for="customRadio1">@lang("alnkel.header-search-round-trip")</label>
                        </div>
                        <!-- End custom-control -->
                        <!-- Start custom-control -->
                        <div class="custom-control custom-radio form-check-inline">
                            <input type="radio" id="customRadio2" name="ticket" class="custom-control-input"
                                   value="OneWay">
                            <label class="custom-control-label"
                                   for="customRadio2">@lang("alnkel.header-search-one-way")</label>
                        </div>
                        <!-- End custom-control -->
                        <!-- Start custom-control -->
                        <div class="custom-control custom-checkbox form-check-inline">
                            <input type="checkbox" name="stop" class="custom-control-input" id="customCheck1" value="1">
                            <label class="custom-control-label" for="customCheck1">
                                @lang("alnkel.header-search-stop")
                            </label>
                        </div>
                        <!-- End custom-control -->
                    </div>
                    <!-- End d-flex -->
                    <!-- Start d-flex -->
                    <div class="d-flex align-items-center flex-wrap">
                        <!-- Start input-gp -->
                        <div class="input-gp">
                            <label for="">@lang("alnkel.header-search-from"):</label>
                            <i class="icons8-location-marker"></i>
                            <select class="js-example-basic-single" name="from">
                                <option></option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}"
                                            {{ old('from') == $country->id ? 'selected' : ''}}>{{ $country->name[App::getLocale()] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp">
                            <label for="">@lang("alnkel.header-search-to"):</label>
                            <i class="icons8-location-marker"></i>
                            <select class="js-example-basic-single" name="to">
                                <option></option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}"
                                            {{ old('to') == $country->id ? 'selected' : ''}}>{{ $country->name[App::getLocale()] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp">
                            <label for="">@lang("alnkel.header-search-going"):</label>
                            <i class="icons8-calendar"></i>
                            <input  type="text" class="datepicker date-mask" value="{{ old('going') }}" placeholder="@lang("alnkel.header-search-date-input")" name="going">
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp">
                            <label for="">@lang("alnkel.header-search-coming"):</label>
                            <i class="icons8-calendar"></i>
                            <input   type="text" class="datepicker date-mask" value="{{ old('coming') }}"
                                   placeholder="@lang("alnkel.header-search-date-input")" name="coming">
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp align-self-end">
                            <button type="submit"
                                    class="btn btn-primary btn-reset d-flex align-items-center justify-content-center">
                                <i class="icons8-search"></i>
                                <span>@lang("alnkel.header-search-search")</span>
                            </button>
                        </div>
                        <!-- End input-gp -->
                    </div>
                    <!-- End d-flex -->
                </form>
                <!-- End tab-pane-choose -->
            </div>
            <!-- End tab-pane -->
            <!-- Start tab-pane -->
            <div class="tab-pane fade show active" id="charterTab" role="tabpanel" aria-labelledby="charter-tab">
                <!-- Start tab-pane-choose -->
                <form id="charter-search-form" class="tab-pane-choose" method="get" action="{{ route('search',['searchable' => 'charter']) }}">
                    <!-- Start d-flex -->
                    <div class="d-flex align-items-center flex-wrap check-form">
                        <!-- Start custom-control -->
                        <div class="custom-control custom-radio form-check-inline">
                            <input type="radio" id="customRadio11" name="ticket" class="custom-control-input"
                                   value="RoundTrip" checked>
                            <label class="custom-control-label"
                                   for="customRadio11">@lang("alnkel.header-search-round-trip")</label>
                        </div>
                        <!-- End custom-control -->
                        <!-- Start custom-control -->
                        <div class="custom-control custom-radio form-check-inline">
                            <input type="radio" id="customRadio21" name="ticket" class="custom-control-input"
                                   value="OneWay">
                            <label class="custom-control-label"
                                   for="customRadio21">@lang("alnkel.header-search-one-way")</label>
                        </div>
                        <!-- End custom-control -->
                        <!-- Start custom-control -->
                        <div class="custom-control custom-checkbox form-check-inline">
                            <input type="checkbox" name="stop" class="custom-control-input" id="customCheck11" value="1">
                            <label class="custom-control-label" for="customCheck11">
                                @lang("alnkel.header-search-stop")
                            </label>
                        </div>
                        <!-- End custom-control -->
                    </div>
                    <!-- End d-flex -->
                    <!-- Start d-flex -->
                    <div class="d-flex align-items-center flex-wrap">
                        <!-- Start input-gp -->
                        <div class="input-gp" style="width: calc(25% - 30px);">
                            <label for="">@lang("alnkel.header-search-from"):</label>
                            <i class="icons8-location-marker"></i>
                            <select class="js-example-basic-single" name="from">
                                <option></option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}"
                                            {{ old('from') == $country->id ? 'selected' : ''}}>{{ $country->name[App::getLocale()] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp" style="width: calc(25% - 30px);">
                            <label for="">@lang("alnkel.header-search-to"):</label>
                            <i class="icons8-location-marker"></i>
                            <select class="js-example-basic-single" name="to">
                                <option></option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}"
                                            {{ old('to') == $country->id ? 'selected' : ''}}>{{ $country->name[App::getLocale()] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp" style="width: calc(30% - 30px);">
                            <label for="">@lang("alnkel.header-search-going"):</label>
                            <i class="icons8-calendar"></i>
                            <input  type="text" class="datepicker date-mask" value="{{ old('going') }}"
                                   placeholder="@lang("alnkel.header-search-date-input")" name="going" autocomplete="off">
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp" style="width: calc(25% - 30px);">
                            <label for="">@lang("alnkel.header-search-coming"):</label>
                            <i class="icons8-calendar"></i>
                            <input  type="text" class="datepicker date-mask" value="{{ old('coming') }}"
                                   placeholder="@lang("alnkel.header-search-date-input")" name="coming" autocomplete="off">
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp" style="width: 100px;margin-top: 20px;">
                            <label for="">@lang("charter.adult"):</label>
                            <i class="icons8-location-marker"></i>
                            <select class="passengers" name="adult">
                                @for($i=0;$i<=9;$i++)
                                    <option value="{{ $i }}" {{ old('adult') == $i or $i == 1 ? 'selected' : ''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp" style="width: 100px;margin-top: 20px;">
                            <label for="">@lang("charter.children"):</label>
                            <i class="icons8-location-marker"></i>
                            <select class="passengers" name="children">
                                @for($i=0;$i<=5;$i++)
                                    <option value="{{ $i }}" {{ old('children') == $i ? 'selected' : ''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp" style="width: 100px;margin-top: 20px;">
                            <label for="">@lang("charter.baby"):</label>
                            <i class="icons8-location-marker"></i>
                            <select class="passengers" name="baby">
                                @for($i=0;$i<=5;$i++)
                                    <option value="{{ $i }}" {{ old('baby') == $i ? 'selected' : ''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp" style="width: 100px;margin-top: 20px;">
                            <label for="">@lang("charter.business"):</label>
                            <i class="icons8-location-marker"></i>
                            <select class="passengers" name="business">
                                @for($i=0;$i<=9;$i++)
                                    <option value="{{ $i }}" {{ old('business') == $i or $i == 1 ? 'selected' : ''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp align-self-end">
                            <button type="submit"
                                    class="charter-search-btn btn btn-primary btn-reset d-flex align-items-center justify-content-center">
                                <i class="icons8-search"></i>
                                <span>@lang("alnkel.header-search-search")</span>
                            </button>
                        </div>
                        <!-- End input-gp -->
                    </div>
                    <!-- End d-flex -->
                </form>
                <!-- End tab-pane-choose -->
            </div>
            <!-- End tab-pane -->
            <!-- Start tab-pane -->
            <div class="tab-pane fade" id="travelTab" role="tabpanel" aria-labelledby="travel-tab">
                <!-- Start tab-pane-choose -->
                <form class="tab-pane-choose" method="get" action="{{ route('search',['searchable' => 'travels']) }}">
                    <!-- Start d-flex -->
                    <div class="d-flex align-items-center flex-wrap">
                        <!-- Start input-gp -->
                        <div class="input-gp">
                            <label for="">@lang("alnkel.header-search-from"):</label>
                            <i class="icons8-location-marker"></i>
                            <select class="js-example-basic-single" name="from">
                                <option></option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}"
                                            {{ old('from') == $country->id ? 'selected' : ''}}>{{ $country->name[App::getLocale()] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp">
                            <label for="">@lang("alnkel.header-search-to"):</label>
                            <i class="icons8-location-marker"></i>
                            <select class="js-example-basic-single" name="to">
                                <option></option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}"
                                            {{ old('to') == $country->id ? 'selected' : ''}}>{{ $country->name[App::getLocale()] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp">
                            <label for="">@lang("alnkel.header-search-going"):</label>
                            <i class="icons8-calendar"></i>
                            <input  type="text" class="datepicker date-mask" name="going" value="{{ old('going') }}"
                                   placeholder="@lang("alnkel.header-search-date-input")">
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp">
                            <label for="">@lang("alnkel.header-search-coming"):</label>
                            <i class="icons8-calendar"></i>
                            <input  type="text" class="datepicker date-mask" name="coming" value="{{ old('coming') }}"
                                   placeholder="@lang("alnkel.header-search-date-input")">
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp align-self-end">
                            <button type="submit"
                                    class="btn btn-primary btn-reset d-flex align-items-center justify-content-center">
                                <i class="icons8-search"></i>
                                <span>@lang("alnkel.header-search-search")</span>
                            </button>
                        </div>
                        <!-- End input-gp -->
                    </div>
                    <!-- End d-flex -->
                </form>
                <!-- End tab-pane-choose -->
            </div>
            <!-- End tab-pane -->
            <!-- Start tab-pane -->
            <div class="tab-pane fade" id="visaTab" role="tabpanel" aria-labelledby="visa-tab">
                <!-- Start tab-pane-choose -->
                <form class="tab-pane-choose" action="{{ route('search',['searchable' => 'visa']) }}" method="get">
                    <!-- Start d-flex -->
                    <div class="d-flex align-items-center flex-wrap">

                        <!-- Start input-gp -->
                        <div class="input-gp">
                            <label for="">ابحث هنا:</label>
                            <i class="icons8-edit-file"></i>
                            <input type="text" name="keyword" placeholder="اكتب هنا...">
                        </div>
                        <!-- End input-gp -->
                        <!-- Start input-gp -->
                        <div class="input-gp align-self-end">
                            <button type="submit"
                                    class="btn btn-primary btn-reset d-flex align-items-center justify-content-center">
                                <i class="icons8-search"></i>
                                <span>@lang("alnkel.header-search-search")</span>
                            </button>
                        </div>
                        <!-- End input-gp -->
                    </div>
                    <!-- End d-flex -->
                </form>
                <!-- End tab-pane-choose -->
            </div>
            <!-- End tab-pane -->
        </div>
        <!-- End custom-tabs-content -->
    </div>
    <!-- End container-fluid -->

</div>
<!-- End search -->