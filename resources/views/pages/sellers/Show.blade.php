@extends('main.main_layout')

@section('content')
    <div class="row">
        @foreach ($clients as $client )
            
        <div class="col-md-2">
            <div class="card sticky-action client-card ">
                <div class="card-image waves-effect waves-block waves-light activator clients_image" style="background-image:url('{{asset('images/profile.jpg')}}');">
                    {{-- <img class="activator img-responsive clients_image" src="{{asset('images/profile.jpg')}}"> --}}
                </div>
                <div class="card-content">
                <span class="card-title activator grey-text text-darken-4 ">{{$client->fullname}}<i class="material-icons right">more_vert</i></span>
                  <p class="left"><a href="#">Show Profile</a></p>
                  <p class="right"><a href="#" >This is a link</a></p>
                </div>
                <div class="card-reveal">
                  <span class="card-title grey-text text-darken-4 small">{{$client->fullname}}<i class="material-icons right">close</i></span>
                  <p><i class="mdi mdi-phone"></i> {{$client->mobile ? $client->mobile : 'not set' }}</p>
                  <p><i class="mdi mdi-email"></i> {{$client->email ? $client->email : 'not set'}}</p>
                  <p><i class="mdi mdi-account"></i> {{$client->username ? $client->username : 'not set'}}</p>
                </div>
              </div>
        </div>
        @endforeach

    </div>
@endsection