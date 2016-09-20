<!DOCTYPE html>
<html lang="en">

    <head>

        <!-- Title -->
        <title>Takoradi Technical University | Admissions</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        <meta name="_token" content="{!! csrf_token() !!}"/>

        <!-- Styles -->
        <link type="text/css" rel="stylesheet"  href="{!! url('public/assets/plugins/materialize/css/materialize.min.css') !!}" />
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <link   href="{!! url('public/assets/plugins/material-preloader/css/materialPreloader.min.css') !!}" rel="stylesheet">        
        <link   href="{!! url('public/assets/css/alpha.min.css') !!}" rel="stylesheet">        
        <link   href="{!! url('public/assets/css/custom.css') !!}" rel="stylesheet">      
         <link rel="stylesheet" href="{!! url('public/assets/css/select2.min.css') !!}" media="all">
   
        <link   href="{!! url('public/assets/bootstrap-fileinput/bootstrap-fileinput.css') !!}" rel="stylesheet">        
          @yield('style')

         
        
    </head>
     <body>
        <div class="loader">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-spinner-teal lighten-1">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mn-content">
            <header class="mn-header navbar-fixed">
                <nav class="teal lighten-1">
                    <div class="nav-wrapper row">
                        <section class="material-design-hamburger navigation-toggle">
                            <a href="#" data-activates="slide-out" class="button-collapse show-on-large material-design-hamburger__icon">
                                <span class="material-design-hamburger__layer"></span>
                            </a>
                        </section>
                        <div class="header-title col s3">      
                            <span class="chaspter-title"> <a href="{{url('/dashboard')}}"><img src='{{url("public/assets/images/logo.png")}}' alt="" style="height: auto;width: 50px;margin-top: 7px" /></</span>
                            
                        </div>
                         <form class="left search col s6 hide-on-small-and-down">
                              <a href="javascript: void(0)" class="close-search"><i class="material-icons">close</i></a>
                     
                         </form>
                         <div class="page-title" style="color:white;margin-top: -41px"> Takoradi Technical University Admissions Portal - {{@\Auth::user()->FORM_NO}}</div> 
                         
                         <div class="toggle-switchs" style=" ">

                             <a href="{{url('/logout')}}" title='click to logout' onclick="return confirm('Are you sure you want to exit?')"> <i  style="font-size: 28px;
                                    vertical-align: middle;
                                    color: white;margin-top: -6px;" class="material-icons">power_settings_new</i></a>

                         </div>
                         

                        
                     
                    </div>
                </nav>
            </header>
         
         
          
            
            
                  @yield('content')
             
            <center><small>&copy <?php echo date("Y");?> | All rights reserved - Powered by Tpconnect</small></center>
        </div>
        <div class="left-sidebar-hover"></div>
        <div class="left-sidebar-hover"></div>
        
        <!-- Javascripts -->
        <script src="{!! url('public/assets/plugins/jquery/jquery-2.2.0.min.js') !!}"></script>

        <script src="{!! url('public/assets/plugins/materialize/js/materialize.min.js') !!}"></script>

        <script src="{!! url('public/assets/plugins/material-preloader/js/materialPreloader.min.js') !!}"></script>

        <script src="{!! url('public/assets/plugins/jquery-blockui/jquery.blockui.js') !!}"></script>

        <script src="{!! url('public/assets/js/alpha.min.js') !!}"></script>

         <script src="{!! url('public/assets/bootstrap-fileinput/bootstrap-fileinput.js') !!}"></script>
<script src="{!! url('public/assets/js/vue.min.js') !!}"></script>
<script src="{!! url('public/assets/js/vue-form.min.js') !!}"></script>

<script>
     $(document).ready(function(){
  $('select').material_select('destroy');
     });
        </script> 
         @yield('js')
    </body>

 </html>