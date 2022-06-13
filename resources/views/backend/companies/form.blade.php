@extends('backend/layout')
@section('content')
<section class="content-header">
    <h1>Company</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{{ $company->page_title }}</li>
    </ol>
</section>
<!-- Main content -->
<section id="main-content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ $company->page_title }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    {{ Form::open(array('route' => $company->form_action, 'method' => 'POST', 'files' => true, 'id' => 'company-form')) }}
                    {{ Form::hidden('id', $company->id, array('id' => 'company_id')) }}
                    <div id="form-name" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Name</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('name', $company->name, array('placeholder' => ' ', 'class' => 'form-control validate[required, minSize[10], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>
                        
                    <div id="form-email" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Email</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('email', $company->email, array('placeholder' => ' ', 'class' => 'form-control validate[required, minSize[10], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    <div id="form-postcode" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Postcode</strong>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-content">
                            {{ Form::text('postcode', $company->postcode, array('placeholder' => ' ', 'id' => 'postcode', 'class' => 'form-control validate[required, minSize[6], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                        <button type="button" name="searchBtn" id="searchBtn" class="btn btn-primary">Submit</button>
                    </div>

                    <div id="form-prefecture" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Prefecture</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            @inject('getPrefectures', 'App\Http\Controllers\Api\ApiPrefecturesController')
                            {{ Form::select('prefecture_id', $getPrefectures->getPrefectures(), old('prefecture_id'), ['id' => 'prefecture', 'class' => 'form-control', 'data-prompt-position' => 'bottomLeft:0,11']) }}               
                        </div>
                    </div>

                    <div id="form-city" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">City</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('city', $company->city, array('placeholder' => ' ', 'id' => 'city', 'class' => 'form-control validate[required, minSize[3], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    <div id="form-local" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Local</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('local', $company->local, array('placeholder' => ' ', 'id' => 'local', 'class' => 'form-control validate[required, minSize[3], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    <div id="form-streetAddress" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Street Address</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('streetAddress', $company->street_address, array('placeholder' => ' ', 'class' => 'form-control validate[required, minSize[3], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    <div id="form-businessHour" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Business Hour</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('businessHour', $company->business_hour, array('placeholder' => ' ', 'class' => 'form-control validate[required, minSize[3], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    <div id="form-regularHoliday" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Regular Holiday</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('regularHoliday', $company->regular_holiday, array('placeholder' => ' ', 'class' => 'form-control validate[required, minSize[3], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    <div id="form-phone" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Phone</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('phone', $company->phone, array('placeholder' => ' ', 'class' => 'form-control validate[required, minSize[3], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    <div id="form-fax" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Fax</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('fax', $company->fax, array('placeholder' => ' ', 'class' => 'form-control validate[required, minSize[3], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    <div id="form-url" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">URL</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('url', $company->url, array('placeholder' => ' ', 'class' => 'form-control validate[required, minSize[3], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    <div id="form-lisenceNumber" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Lisence Number</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('lisenceNumber', $company->license_number, array('placeholder' => ' ', 'class' => 'form-control validate[required, minSize[2], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    <div id="form-image" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>    
                            <strong class="field-title">Image</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::file('image', $company->image, array('placeholder' => ' ', 'class' => 'custom-file-input validate[required, minSize[2], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            <p class="">画像をアップロードして下さい(推奨サイズ 1280px × 720px・容量は5MBまで)</p>
                        </div>
                    </div>
                    
                    <div id="form-button" class="form-group no-border">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="margin-top: 20px;">
                            <button type="submit" name="submit" id="send" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection

@section('title', 'Company | ' . env('APP_NAME',''))

@section('body-class', 'custom-select')

@section('css-scripts')
@endsection

@section('js-scripts')
<script src="{{ asset('bower_components/bootstrap/js/tooltip.js') }}"></script>
<!-- validationEngine -->
<script src="{{ asset('js/3rdparty/validation-engine/jquery.validationEngine-en.js') }}"></script>
<script src="{{ asset('js/3rdparty/validation-engine/jquery.validationEngine.js') }}"></script>
<script src="{{ asset('js/backend/companies/form.js') }}"></script>
@endsection
