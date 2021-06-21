@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User Verify Application') }}</div>

                <div class="card-body">
                    <div id="err-msg"></div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="post"  id="check-email">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control"  name="email" id="email" required  aria-describedby="emailHelp" placeholder="Enter email">    
                      </div>                     
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                  
                    <input type="hidden"  id="user-email">

                    <form method="post"  id="otp-form">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Enter OTP</label>
                        <input type="text" class="form-control" name="otp"  id="exampleInputEmail122" required   placeholder="Enter OTP">    
                      </div>                     
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#otp-form').hide();
        $('#check-email').on('submit',function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",          
                url: "{{route('user-email-verify')}}",
                data: new FormData(this),
                dataType:'json',
                processData: false,
                contentType: false,
                cache: false,           
                success: function (data) { 
                    alert(data.otp);
                    var email = $('#email').val();
                    $('#user-email').val(email);
                    $('#check-email').hide();  
                    $('#otp-form').show();                 
                  
                },
                error: function (data) { 
                    var r = jQuery.parseJSON(data.responseText);                 
                    $('#err-msg').html('<div class="alert alert-danger" role="alert">'+r.errors+'</div>');
                    setTimeout(function(){ $('#err-msg').html(''); }, 3000);
                    //alert('err');                    
                }
            });
        });

        $('#otp-form').on('submit',function(e){
            e.preventDefault();
            var email = $('#user-email').val();
            var formdata = new FormData(this);          
            formdata.append("email",email);
            $.ajax({
                type: "POST",          
                url: "{{route('user-otp-verify')}}",
                data: formdata,
                dataType:'json',
                processData: false,
                contentType: false,
                cache: false,           
                success: function (data) {                 
                    $('#check-email').hide();  
                    $('#otp-form').show();     
                    window.location.href = "{{route('thank-you')}}";         
                  
                },
                error: function (data) { 
                    var r = jQuery.parseJSON(data.responseText);                 
                    $('#err-msg').html('<div class="alert alert-danger" role="alert">'+r.errors+'</div>');
                    setTimeout(function(){ $('#err-msg').html(''); }, 3000);
                    //alert('err');                    
                }
            });

        });






















    });
    </script>
@endsection
