@extends('layouts.app')


@section('style')

@endsection
@section('content')
<div class="md-card-content">
    @if(Session::has('success'))
    <div style="text-align: center" class="uk-alert uk-alert-success" data-uk-alert="">
        {!! Session::get('success') !!}
    </div>
    @endif

    @if (count($errors) > 0)

    <div class="uk-form-row">
        <div class="uk-alert uk-alert-danger" style="background-color: red;color: white">

            <ul>
                @foreach ($errors->all() as $error)
                <li> {{  $error  }} </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>
<main class="mn-inner container">
 <div class="row">
     
     <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <div id="todo-lists" >
                             <table style="text-align:justify" width="851" align="center" cellpadding="0" cellspacing="0" class="displaytable">
                                  <tr>
                                    <td valign="top"><div class="banner">
                                     
                                 
                                     <div class="newsitem_text">
                                                      
                                                
                                        
                                        <p><center><strong>STEPS IN FILLING THE FORM</strong></center></p>
                                        <hr>
                                <p>All Ghanaian applicants for the <?php echo (date("Y") ) ."/".(date("Y")+1);?> Academic year admission are required to use Takoradi Polytechnic online admission portal. The procedure for the online application process is as follows:</p>
                                 
                                  <p><strong>I</strong>. In completing the online form, applicants will be required to upload their passport size photograph (not more than 500KB) with a white background.</p>
                                <p><strong>II. </strong>Applicants are advised to check thoroughly all details entered before they finally submit their online applications. A form, once submitted, can be viewed, but cannot be edited.</p>
                                <p><strong>III.</strong> Applicants should print out application summary; attach result slips,certificates (WASSCE/SSSCE)or Certificates(BTECH) and all other relevant documents.</p>
                                <p><strong>VI. </strong>The application documents as specified (III) above should sent by post to  
                              
                                
                                    
                                <p align="center"><strong>The Registrar</strong></p>
                                <p align="center"><strong>Takoradi Polytechnic,</strong></p>
                                <p align="center"><strong>P. O Box 256, Takoradi, W/R.</strong></p>
								<p align="left"><strong>For more information call 033 2094767 / 0262321123 / 0505284060</strong></p>
                                 
                                        </div>
                                 
                                    </div></td>
                                  </tr>
                                  <tr>
                                      <td><center><a href="{{url('/upload/photo')}}" class="btn bgm-lime">Accept and Continue</center></a>
                                </td>
                                  </tr>
                             </table>
                                 
                            </div>
                            </div>
                        </div>
                    </div>
 </div>
</main>
@endsection
@section('js')


@endsection