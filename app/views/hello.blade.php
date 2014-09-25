
  @if(Session::has('yes'))
    <p class="alert" style="text-align: center;">{{ Session::get('yes') }}</p>

    @endif
create account 

{{ Form::open(array('url'=>'users/create'))}}



{{ Form::text('username')}} <br />
{{ Form::email('email')}}   <br />
{{ Form::password('password')}}  <br />


{{ Form::submit('create')}}  <br/>





{{ HTML::link('users/recover' , 'fogot ur password')}}