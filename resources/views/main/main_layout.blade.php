<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta http-equiv="x-ua-compatible" content="ie=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <title>Event App</title>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
            <!--Import Google Icon Font-->
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            <!-- Compiled and minified CSS -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
            <link rel="stylesheet" href="//cdn.materialdesignicons.com/4.7.95/css/materialdesignicons.min.css">
            <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
            <link rel="stylesheet" type="text/css" href="{{asset('css/main2.css')}}">
        </head>

        <body>

  <!-- Start your project here-->  

            {{-- top nav --}}
            <nav class="teal lighten-2 z-depth-2 nav_layout d-flex ">
                <p class="project_title font-weight-bold">Buy And Sell </p>
                {{-- <input type="text" class="browser-default my-2 p-2 search_input" style="width:70%; margin-left:5%;" placeholder="search sellers or items">
                 --}}
                <div class="input-field"  style="width:70%; margin-left:5%;">
                    <input type="text" id="autocomplete-input" class="autocomplete browser-default my-2 p-2 search_input" placeholder="search sellers or items" >
                </div>
                <span class="profile_holder dropdown-trigger2 " href='#' data-target='dropdown'>
                    <i class="material-icons">account_circle</i>
                </span>
            </nav>

            <ul id='dropdown' class='dropdown-content'>
                <li>
                    <a href="/logout">
                        {{-- <i class="mdi mdi-face-profile left"></i>{{Auth::user()->name}} --}}
                    </a>
                    <a href="/logout">
                        <i class="mdi mdi-logout left"></i>logout
                    </a>
                </li>
            </ul>

            <div class="return_button my-3 col-md-12">
                <a class="btn waves-effect waves-light text-white right blue" onclick="window.history.back();">return
                    <i class="mdi mdi-arrow-left-bold left"></i>
                </a>
            </div>

            

             {{-- side nav --}}
                <ul id="slide-out" class="sidenav sidenav-fixed  ">
                    <li>
                        <div class="user-view">
                            <div class="background">
                                <img src="http://event-app.ohm-conception.com/Settings/background.png ">
                            </div>
                        <a href="#user"><img class="circle" src="{{asset('images/buy_sell2.jpg')}}"></a>
                            <a href="#name"><span class="white-text name">Buy and Sell</span></a>
                            <a href="#email"><span class="white-text email">Admin@Admin.com</span></a>
                        </div>
                    </li>
                    <li class="menu_item {{ Request::is('dashboard') ? 'active' : '' }}">
                        <a href="/" class="waves-effect" >
                            <i class="material-icons ">dashboard</i>Dashboard 
                        </a>
                    </li>
                    <li class="menu_item ">
                        <a href="" class="waves-effect">
                            <i class="material-icons ">today</i>Products
                        </a>
                    </li>
                    <li class="menu_item {{ Request::is('seller*') ? 'active' : '' }}">
                        <a href="/seller" class="waves-effect">
                            <i class="material-icons">face</i>Sellers
                        </a>
                    </li> 
                    <li>
                        <div class="divider"></div>
                    </li>
                    <li>
                        <a class="subheader">Settings</a>
                    </li>
                    <li class="menu_item  {{ Request::is('category*') ? 'active' : '' }} ">
                        <a class="waves-effect" href="/category"><i class="material-icons">gavel</i>Item Category</a>
                    </li>
                    <li class="menu_item  {{ Request::is('settings*') ? 'active' : '' }} ">
                        <a class="waves-effect" href="/settings"><i class="material-icons">settings</i>General Settings</a>
                    </li>
                    
                </ul>
                <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    <div class="main_content_holder">
                        @yield('content')
                    </div>
                          
                {{-- floating button --}}
                 <div class="fixed-action-btn">
                    <a class="btn-floating btn-large teal">
                        <i class="large material-icons">mode_edit</i>
                    </a>
                    <ul>
                        <li>
                            <a class="btn-floating red tooltipped  modal-trigger" data-position="left" data-tooltip="Chart" href="#modal1">
                                <i class="material-icons">insert_chart</i>
                            </a>
                        </li>
                        <li>
                            <a class="btn-floating pink tooltipped" data-position="left" data-tooltip="Company" href="/company">
                                <i class="material-icons">face</i>
                            </a>
                        </li>
                        <li>
                            <a class="btn-floating yellow darken-1 tooltipped" data-position="left" data-tooltip="format_quote">
                                <i class="material-icons">format_quote</i>
                            </a>
                        </li>
                        <li>
                            <a class="btn-floating green tooltipped" data-position="left" data-tooltip="publish">
                                <i class="material-icons">publish</i>
                            </a>
                        </li>
                        <li>
                            <a class="btn-floating blue tooltipped" data-position="left" data-tooltip="attach_file">
                                <i class="material-icons">attach_file</i>
                            </a>
                        </li>
                    </ul>
                </div>
                 <!-- Modal Structure -->
                  <div id="modal1" class="modal bottom-sheet">
                    <div class="modal-content">
                      <h4>Modal Header</h4>
                      <p>A bunch of text</p>
                    </div>
                    <div class="modal-footer">
                      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
                    </div>
                  </div>

  <!-- End your project here-->
    <script>
        var asset = '{{asset('')}}' ;
        
    </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  {{-- data tables --}}
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="{{asset('js/functions.js')}}"></script>
  <script src="{{asset('js/materialize_initialization.js')}}"></script>
  <script src="{{asset('js/main.js')}}"></script>



</body>
</html>
