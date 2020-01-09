{{-- @extends('main.main_layout')

@section('content')
    <div class="row">
        @foreach ($clients as $client )
            
        <div class="col-md-2">
            <div class="card  client-card ">
                <div class="card-image waves-effect waves-block waves-light activator clients_image" style="background-image:url('{{$client->image}}');">
                </div>
                <div class="card-content">
                <span class="card-title activator grey-text text-darken-4 ">{{$client->fullname}}<i class="material-icons right">more_vert</i></span>
                  <p class="left"><a href="/view_seller/{{$client->id}}">View Profile</a></p>
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
      <div class="row">
        {{$clients->links()}}
      </div>
      
@endsection --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Autocomplete - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script>
    var asset = '{{asset('')}}' ;
  </script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="{{asset('js/functions.js')}}"></script>

  <script>
  $( function() {
    var cCities = [
      {label: "Chicago (USA)", value: "Chicago"},
      {label: "Chennai (India)", value: "Chennai"},
      {label: "Cambridge (England)", value: "Cambridge"},
      {label: "Colombo (SriLanka)", value: "Colombo"}
    ];

    $( "#tags" ).autocomplete({
      source: cCities ,
      select: function (event, ui) {        
          console.log(ui.item.label)
  },
    });

$('.test_button').click(function (e) { 
  e.preventDefault();
  simple_ajax_call('search_items','get', '' ,function(data){
    if(data.type == 1) {
    } else {
      var error = data.data.responseJSON.errors.name ;
    }
    console.log(data.data);
        })
});
  } );
  </script>
</head>
<body>
 
<div class="ui-widget">
  <label for="tags">Tags: </label>
  <input id="tags">
</div>
<button class="test_button">test</button>
 
 
</body>
</html>