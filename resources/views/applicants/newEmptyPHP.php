@extends('layouts.app')


@section('style')

@endsection
@section('content')
<div class="col s12 m12 l12">
    <div class="card">
       
            @if(Session::has('success'))
             <div class="card-panel light-green lighten-3">
            <div style="text-align: center" class=" white-text alert  alert-success"   >
                {!! Session::get('success2') !!} <a href="{{url('form/step4')}}">Click to Preview Form and Submit it</a>
            </div></div>
            @endif
             @if(Session::has('error'))
             <div class="card-panel red">
            <div style=" " class=" white-text alert  alert-success"  >
                {!! Session::get('error2') !!}
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
<main class="mn-inner ">
    <div class="row">
        <div class="col s12">
            <div class="page-title  text-success"><small class="">Upload Exams Results here</small></div>
        </div>
        <form    id="form" accept-charset="utf-8" method="POST" name="applicationForm"  v-form>
            <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
          <table id="paymentTable" class="uk-table"border="0" style="font-weight:bold">
	  <tr id="paymentRow" payment_row="payment_row"> 
            <div class="col s12 m12 l12">
                <div class="card hoverable">
                    <div class="row">
                        <div class="col m6">
                            <div class="row">
                                <div class="input-field col s12 m6 l3">
                                    <label for="firstName">Index Number</label>
                                    <input id="firstName" name="indexno" type="text"   class="required validate">
                                </div>
                                <div class="input-field col s12 m6 l3">
                                    {!!   Form::select('type',$examType ,array('placeholder'=>'select exam type',"required"=>"required", "tabindex"=>"-1","v-model"=>"nationality","v-form-ctrl"=>"","style"=>"width: 100%","v-select"=>"nationality")   )  !!}

                                </div>
                                <div class="input-field col s12 m6 l3">
                                    {!!   Form::select('subject',$subject ,array('placeholder'=>'select exam',"required"=>"required", "tabindex"=>"-1","v-model"=>"nationality","v-form-ctrl"=>"","style"=>"width: 100%","v-select"=>"nationality")   )  !!}

                                </div>
                                <div class="input-field col s12 m6 l3">
                                    {!!   Form::select('grade',$grades ,array('placeholder'=>'select exam',"required"=>"required", "tabindex"=>"-1","v-model"=>"nationality","v-form-ctrl"=>"","style"=>"width: 100%","v-select"=>"nationality")   )  !!}

                                </div>
                            </div>
                        </div>
                        <div class="col m6">
                            <div class="row">


                                <div class="input-field col s12 m6 l3">
                                    {!!   Form::select('month',array("MAY/JUNE"=>"MAY/JUNE","NOV/DEC"=>"NOV/DEC"),old('month',''),array('placeholder'=>'Select month',"required"=>"required","tabindex"=>"-1"))  !!}

                                </div>
                                <div class="input-field col s12 m6 l3">
                                    {!!   Form::select('sitting',array("FIRST SITTING"=>"FIRST SITTING","SECOND SITTING"=>"SECOND SITTING","THIRD SITTING"=>"THIRD SITTING"),old('sitting',''),array('placeholder'=>'Select sitting',"required"=>"required","tabindex"=>"-1"))  !!}

                                </div>
                                <div class="input-field col s12 m6 l3">
                                    <label for="firstName">Exam Center</label>
                                    <input id="firstName" name="center" type="text"   class="required validate">
                                </div>
                                <div class="input-field col s12 m6 l3">
                                    <td valign="top" id="insertPaymentCell"><button  type="button" id="insertPaymentRow" class="waves-effect waves-light btn green m-b-xs " ><i title="click to add more subjects" class="material-icons">add</i></button></td></tr>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </tr>
          </table>
            <div style="margin-left: 500px">
        <table>
       
        <tr><td><input type="submit" value="Save" id='save'v-show="applicationForm.$valid"  class="waves-effect waves-light btn green m-b-xs">
      <input type="reset" value="Cancel" class="waves-effect waves-light btn red m-b-xs">
            </td></tr></table></div>
        
        </form>
    </div>
 
</main>
@endsection
@section('js')


@endsection