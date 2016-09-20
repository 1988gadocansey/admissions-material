@extends('layouts.app')


@section('style')

@endsection
@section('content')
<div class="col s12 m12 l12">
    <div class="card">
       
            @if(Session::has('success'))
             <div class="card-panel light-green lighten-3">
            <div style="text-align: center" class=" white-text alert  alert-success"   >
                {!! Session::get('success') !!} <a href="{{url('form/step2')}}">Click to Move to Next Step</a>
            </div></div>
            @endif
             @if(Session::has('error'))
             <div class="card-panel red">
            <div style=" " class=" white-text alert  alert-success"  >
                {!! Session::get('error') !!}
            </div></div>
            @endif

            @if (count($errors) > 0)

             <div class="card-content blue-grey">
                <div class=" alert  alert-danger  " style="background-color: red;color: white">

                    <ul>
                        @foreach ($errors->all() as $error)
                        <li> {{  $error  }} </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div> 
</div>
@inject('sys', 'App\Http\Controllers\SystemController')
<main class="mn-inner container">
<div class="row">
    <div class="col s12">
        <div class="page-title  text-success"><small class="">Upload only .jpg photo | Maximum size is 500KB</small></div>
    </div>
    <div class="col s12 m12 l12">
        <div class="card hoverable">
            <div class="card-content">
                @if(@\Auth::user()->PHOTO_UPLOAD=="YES")
                <div style="float: right"><a class="waves-effect waves-green btn-flat m-b-xs" href="{{url('/form/step2')}}">Next Step</a></div>
                @endif
                <form  enctype="multipart/form-data"   id="uploadForm" class="uk-form-stacked"    method="post" accept-charset="utf-8"  name="uploadForm"   >
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 

                  
                            <div id="file_upload-drop" style="margin-left:239px" class="uk-file-upload">
                                  <div  class="fileinput fileinput-new" data-provides="fileinput" align="center">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 186px;">
                                     <img <?php $id = @\Auth::user()->FORM_NO;
                                echo $sys->picture("public/uploads/photos/$id.jpg", 200); ?>  src="<?php echo file_exists("public/uploads/photos/$id.jpg") ? url("public/uploads/photos/$id.jpg")  :  url("public/uploads/photos/user.jpg") ; ?>" alt=" Picture of Student Here"  />
                                
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 250px; height: 160px;">
                              
                                
                                </div>
                                <div>
                                    <span class="btn default btn-file">
                                        <span class="md-btn md-btn-success fileinput-new">
                                            Select image </span>
                                        <span class="md-btn md-btn-warning fileinput-exists">
                                            Change </span>
                                        
                                        <input type="file" name="picture" required=""  >
                                    </span>
                                    <a href="javascript:;" class="md-btn md-btn-danger fileinput-exists" data-dismiss="fileinput">
                                        Remove </a>
                                        <button type="submit" name="photo" class="  btn md-btn-danger">
                                            Upload </button>
                                </div>



                                  </div></div>
                             
                  
                </form>
            </div>
        </div>
    </div>
</div>
</main>
@endsection
@section('js')


@endsection