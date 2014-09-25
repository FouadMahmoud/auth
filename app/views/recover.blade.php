  @if(Session::has('yes'))
    <p class="alert" style="text-align: center;">{{ Session::get('yes') }}</p>

    @endif
{{ Form::open(array('url'=>'users/recover'))}}

{{ Form::email('email')}}


{{ Form::submit('send')}}