<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    {!! Html::script('theme/js/vendor/jquery.min.js') !!}
    {!! Html::script('theme//js/vendor/jquery-ui.js') !!}
    {!! Html::script('theme/js/vendor/html5-3.6-respond-1.4.2.min.js') !!}
    {!! Html::script('theme/js/vendor/jquery.responsiveTabs.min.js') !!}
    {!! Html::script('theme/js/vendor/jquery.simplePagination.js') !!}
    {!! Html::script('theme/js/vendor/jquery.datetimepicker.min.js') !!}
    {!! Html::script('theme/js/vendor/jquery.fancybox.js') !!}
    {!! Html::script('theme/js/vendor/jquery.slimscroll.min.js') !!}
    {!! Html::script('theme/js/vendor/jquery.validate.min.js') !!}
    {!! Html::script('theme//js/vendor/jquery.blockUI.js') !!}
    {!! Html::script('theme/js/vendor/jquery.magnific-popup.min.js') !!}
    {!! Html::script('theme/detail.js') !!}

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
        .upload-file {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 50%;
        }

        .upload-control {
            position: absolute;
            left: -20px;
            right: -20px;
            bottom: -20px;
            top: -20px;
            background: transparent;
            outline: none;
            border: none;
            padding: 0;
            -webkit-appearance: none;
            -moz-appearance: none;
            -ms-appearance: none;
            appearance: none;
            opacity: 0;
            z-index: 10;
            cursor: pointer;
        }
        .input-text, .button-large {
            min-width: 266px;
            line-height: 1.8em;
            border: 1px solid #ff5200;
            padding: 10px;
            border-radius: 15px;
            margin: 4px 3px;
        }

        .table-bordered span{
            color: #000000;
            font-size: 16px;
        }

        .form-group{
            margin-top: 50px ;
        }
        .form-group a{
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="links">
            <div id="block-feature">
                <div class="user-avatar avatar-media-s">
                    <a id="main-cover-image-link" href="javascript:void(0)">
                        <img id="main-cover-image" src="
                        @if(object_get($user, 'avatar'))
                           {{ object_get($user, 'avatar') }}
                        @else
                           {{ URL::asset('theme/img/none-image.jpg') }}
                        @endif
                        " alt="user avatar">
                    </a>
                </div>
                <div class="upload">
                    <form id="upload_cover_image" action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div id="cover-edit" class="upload-text">{{ __('upload') }}</div>
                        <div class="upload-file">
                            <input type="file" name="cover-image" data-change="image" data-target="upload-media" class="upload-control">
                        </div>
                    </form>
                </div>
            </div>
            <div class="message-errors" style="color: red;"></div>
            <div class="operator-form">
                {!!
                   Form::open(
                       [
                           'url'     => route('store'),
                           'method'  => 'POST',
                           'class'   => 'inline',
                           'id'      => 'user-profile',
                           'enctype' => 'multipart/form-data',
                       ]
                   )
                !!}
                <div class="responsive-table">
                    <table class="table table-bordered">
                        <tr>
                            <td><span>{{ __('Your email address') }}</span></td>
                            <td>
                                {!!
                                    Form::text(
                                        'email',
                                         old('email') ?: object_get($user, 'email')?:'',
                                        [
                                            'class' => 'input-text input-text20',
                                            'id'    => 'email-user',
                                            "data-rule-required" => "true",
                                            "data-msg-required" =>  __('required'),
                                        ]
                                    )
                                !!}
                            </td>
                        </tr>
                        <tr><td><span>{{ __('Your phone') }}</span></td>
                            <td>
                                {!!
                                    Form::text(
                                        'phone',
                                         old('phone') ?: object_get($user, 'phone_number') ?:'',
                                        [
                                            'class' => 'input-text input-text20',
                                            'id'    => 'phone-user',
                                        ]
                                    )
                                !!}
                            </td>
                        </tr>
                        <td><span>{{ __('Full name') }}</span></td>
                            <td>
                                {!!
                                    Form::text(
                                        'full_name',
                                         old('full_name') ?: object_get($user, 'full_name' ?: ''),
                                        [
                                            'class' => 'input-text input-text20',
                                            'id'    => 'full-name',
                                        ]
                                    )
                                !!}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="form-group text-center">
                    <input type="submit" value="{{ __('Save Profile') }}" class="button button-large">
                    <a href="{{ route('logout') }}" class="button button-large">Logout</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
</body>
</html>
