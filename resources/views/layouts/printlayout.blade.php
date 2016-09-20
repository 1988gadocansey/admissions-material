<!DOCTYPE html>
<html lang="en">

    <head>

        <!-- Title -->
        <title>Takoradi Technical University | Admissions - Print Page</title>

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
        <link   href="{!! url('public/assets/bootstrap-fileinput/bootstrap-fileinput.css') !!}" rel="stylesheet">        
          @yield('style')

         
        
    </head>
     <body>
        
        <div class="mn-content">
          
         
          
            
            
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



        </script> 
         @yield('js')
    </body>

 </html>