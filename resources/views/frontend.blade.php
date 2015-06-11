@extends('layouts.master')

@section('scripts')
    <script type="text/javascript">
        var ajax = function(route, method, onSuccess, onFail) {
                var xhr = (window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP"));

                if (method === 'POST') {
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                }

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        ((xhr.status === 200) ? onSuccess : onFail)(xhr.responseText); 
                    }
                }

                xhr.open(method, route, true);
                xhr.send();
            },
            updateCaptchaElement = function(value) {
                document.getElementById('captcha-image-container').innerHTML = value;
            },
            loadNewCaptcha = function() {
                var success = function(response) {
                        updateCaptchaElement('<img src="data:image/png;base64,' + response + '">');
                    },
                    fail = function(response) {
                        updateCaptchaElement('<p>There was an error loading the Captcha image</p>'); 
                    };

                ajax('captcha/create', 'GET', success, fail);
            };

        document.addEventListener("DOMContentLoaded", loadNewCaptcha);
    </script>
@endsection

@section('content')
    <div class="title">Captcha Demo</div>

    {!! Form::open(array('action' => 'CaptchaController@store')) !!}

        <div id="captcha-image-container">
        </div>

        {!! Form::label('code', 'Enter the text you see above:'); !!}
        {!! Form::text('code'); !!}

        {!! Form::submit('Submit'); !!}

    {!! Form::close() !!}
@endsection