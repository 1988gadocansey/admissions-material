@extends('layouts.printlayout')


@section('style')
<link rel="stylesheet" href="{!! url('public/assets/css/print.css') !!}" media="all">  
<style>
    .uppercase{
        font-weight: bolder;
        text-align: right;
    }
</style>
@endsection
@section('content')

<main class="mn-inner container">
    <div class="row">
        @inject('sys', 'App\Http\Controllers\SystemController')


        <a onclick="javascript:printDiv('print')" class="waves-effect waves-purple btn-flat m-b-xs">Click to print</a>
        @if(@\Auth::user()->FINALIZED!=1)
        <a href="{{url('/upload/photo')}}" class="waves-effect waves-green btn-flat m-b-xs">Edit Information</a>
       
        <a href="{{url('/form/completed')}}" onclick="return confirm('Are you sure every information provided on this form is correct??. After submiting you cannot edit this form again')" class="waves-effect waves-blue btn-flat m-b-xs">Submit Form</a>
         @else
          <a href="{{url('/logout')}}"   class="waves-effect waves-blue btn-flat m-b-xs">Click to logout</a>
        @endif
        <div class="col s12 m12 l12">
            <div class="card">
                <div class="card-content">
                    <div id='print'>
                        <div id='page1'>    
                            <table style="" width="882" height="113" border="0" align="left">
                                <tr>
                                    <td><img src='{{url("public/assets/images/printout.png")}}' style="width:581px;height:153px;margin-left: 20%;" /> </td

                                </tr>
                            </table>
                            <center>APPLICATION NUMBER - {{@\Auth::user()->FORM_NO}}  &nbsp;|&nbsp;  APPLICATION TYPE  - {{@\Auth::user()->FORM_TYPE}}</center>
                            <hr>
                           <fieldset><legend>BIODATA INFORMATION</legend>
                            <table ><tr>

                                    <td>
                                        <table   class="table table-responsive " >
                                            <tr>
                                                <td width="210" class="uppercase" align="right"><strong>TITLE</strong></td>
                                                <td width="408" class="capitalize">{{ $student->TITLE }}</td>								
                                            </tr>
                                            <tr>
                                                <td width="210" class="uppercase" align="right"><strong>SURNAME</strong></td>
                                                <td width="408" class="capitalize">{{ $student->SURNAME }}</td>								
                                            </tr>
                                            <tr>
                                                <td width="210" class="uppercase" align="right"><strong>FIRST NAME</strong></td>

                                                <td width="408" class="capitalize">{{ $student->FIRSTNAME }}</td>
                                            </tr>
                                            <tr>
                                                <td class="uppercase" style=""align="right"><strong>OTHERNAMES:</strong></td>
                                                <td class="capitalize"><?php echo strtoupper($student->OTHERNAME) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="uppercase" align="right"><strong>GENDER:</strong></td>
                                                <td class="capitalize"><?php echo strtoupper($student->GENDER) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="uppercase" align="right"><strong>DATE OF BIRTH</strong>:</td>
                                                <td class="capitalize"><?php echo $student->DOB ?></td>
                                            </tr>
                                            <tr>
                                                <td class="uppercase" align="right"><strong>SOURCE OF FINANCE</strong>:</td>
                                                <td class="capitalize"><?php echo strtoupper($student->SOURCE_OF_FINANCE) ?></td>
                                            </tr>

                                            <tr>
                                                <td class="uppercase" align="right"><strong>PHONE:</strong></td>
                                                <td class="capitalize"><?php echo "+233" . \substr($student->PHONE, -9); ?></td>
                                            </tr>

                                            <tr>
                                                <td class="uppercase" align="right"><strong>PROGRAMME STUDIED:</strong></td>
                                                <td class="capitalize"><?php echo strtoupper($student->PROGRAMME_STUDY) ?></td>

                                            </tr>

                                            <tr>
                                                <td class="uppercase" align="right"><strong>PREVIOUS SCHOOL</strong></td>
                                                <td class="capitalize"><?php echo strtoupper($student->SCHOOL) ?></td>


                                            </tr>
                                            <tr>
                                                <td class="uppercase" align="right"><strong>EMAIL</strong></td>
                                                <td class="capitalize">{!!strtoupper($student->EMAIL) !!}</td>

                                            </tr>


                                        </table>

                                    </td>

                                    <td valign="top" >
                                        <img   style="width:300px;height:250px ;margin-top: -270px"  <?php
                                        $pic = $student->APPLICATION_NUMBER;
                                        echo $sys->picture("{!! url(\"public/uploads/photos/$pic.jpg\") !!}", 90)
                                        ?>   src='{{url("public/uploads/photos/$pic.jpg")}}' alt="  Affix Applicant picture here"    />
                                    </td>
                                    <td>
                                <tr>
                                    <td class="uppercased" align="right"><strong>SESSION PREFERENCE &nbsp;
                                            {!! strtoupper($student->SESSION_PREFERENCE) !!}</</td>


                                    <td class="uppercased" align="right"><strong>PHYSICALLY DISABLED 
                                            {!! strtoupper($student->PHYSICALLY_DISABLED) !!}</strong></td>

                                </tr>
                                </td>

                                </tr>
                            </table>
                           </fieldset>
                        </div>
                        <p>&nbsp;&nbsp;</p>
                        <div id='page2'>
                            <fieldset><legend>OTHER INFORMATION</legend>
                              <table>
                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                                <td class="uppercases" ><strong>HOMETOWN:</strong></td>
                                                <td class="capitalize">{!! strtoupper($student->HOMETOWN) !!}</td>

                                            </tr>
                                            <tr>
                                                <td class="uppercases" style=""><strong>CONTACT ADDRESS</strong></td>
                                                <td class="capitalize">{!! strtoupper($student->ADDRESS) !!}</td>

                                            </tr>

                                        </table>
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td class="uppercases"><strong>NATIONALITY</strong></td>
                                                <td class="capitalize">{!! strtoupper($student->COUNTRY )!!}</td>

                                            </tr>
                                            <tr>
                                                <td class="uppercases"><strong>RELIGION</strong></td>
                                                <td class="capitalize">{!! strtoupper($student->RELIGION) !!}</td>

                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td class="uppercases"  ><strong>RESIDENTIAL ADDRESS:</strong></td>
                                                <td class="capitalize">{!! strtoupper($student->RESIDENTIAL_ADDRESS) !!}</td>

                                            </tr>
                                            <tr>
                                                <td class="uppercases"  ><strong>HOMETOWN REGION</strong></td>
                                                <td class="capitalize">{!! strtoupper($student->REGION) !!}</td>

                                            </tr>
                                        </table>


                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td class="uppercases"><strong>HALL</strong></td>
                                                <td class="capitalize">{!!strtoupper( $student->PREFERED_HALL) !!}</td>


                                            </tr>
                                            <tr>
                                                <td class="uppercases"><strong>MARITAL STATUS</strong></td>
                                                <td class="capitalize">{!! strtoupper($student->MARITAL_STATUS) !!}</td>

                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>

                                </tr>
                            </table>
                            </fieldset>
                            <p>&nbsp;&nbsp;</p>
                    <fieldset><legend>GURADIAN INFORMATION</legend>
                             <table>
                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                                <td class="uppercase" ><strong>GUARDIAN NAME:</strong></td>
                                                <td class="capitalize">{!! strtoupper($student->GURDIAN_NAME) !!}</td>

                                            </tr>
                                            <tr>
                                                <td class="uppercase"><strong>GURDIAN ADDRESS</strong></td>
                                                <td class="capitalize">{!! strtoupper($student->GURDIAN_ADDRESS) !!}</td>

                                            </tr>

                                        </table>
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td class="uppercase"  ><strong>GUARDIAN PHONE:</strong></td>
                                                <td class="capitalize">{!! strtoupper($student->GURDIAN_PHONE) !!}</td>

                                            </tr>
                                            <tr>
                                                <td class="uppercase"  ><strong>GUARDIAN OCCUPATION</strong></td>
                                                <td class="capitalize">{!! strtoupper($student->GURDIAN_OCCUPATION) !!}</td>

                                            </tr>

                                        </table>
                                    </td>
                                </tr>


                            </table>
                    </fieldset>
                        </div>
                        <p> &nbsp;</p>
                        <div id='page3'>
                            <fieldset><legend>CHOICE OF PROGRAMME</legend>
                              <table>
                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                                <td class="uppercase" ><strong>FIRST CHOICE:</strong></td>
                                                <td class="capitalize">{!!strtoupper($sys->getProgramName($student->FIRST_CHOICE)) !!}</td>

                                            </tr>
                                            <tr>
                                                <td class="uppercase"><strong>SECOND CHOICE</strong></td>
                                                <td class="capitalize">{!! strtoupper($sys->getProgramName($student->SECOND_CHOICE)) !!}</td>

                                            </tr>

                                        </table>
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td class="uppercase"  ><strong>THIRD CHOICE:</strong></td>
                                                <td class="capitalize">{!! strtoupper($sys->getProgramName($student->THIRD_CHOICE)) !!}</td>

                                            </tr>
                                            <tr>
                                                <td class="uppercase"  ><strong>ENTRY QUALIFICATION:</strong></td>
                                                <td class="capitalize">{!! strtoupper($student->ENTRY_QUALIFICATION) !!}</td>

                                            </tr>


                                        </table>
                                    </td>
                                </tr>


                            </table>
                              </fieldset>   
                            <p>&nbsp;&nbsp;</p>
                            <div class="row">

                               <fieldset><legend>EXAMINATION RESULTS</legend>


                                <table class="responsive-table table-striped table-condensed table-hover">
                                    <thead>
                                        <tr>

                                            <th data-field="price">INDEXNO</th>
                                            <th data-field="name">SUBJECT</th>
                                            <th data-field="price">GRADE</th>
                                            <th data-field="price">VALUE</th>
                                            <th data-field="price">EXAM TYPE</th>
                                            <th data-field="price">SITTING</th>
                                            <th data-field="price">MONTH OF EXAM</th>
                                            <th data-field="price">CENTER</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($data as $index=> $row) 


                                        <tr align="">
                                            <td> {{ strtoupper(@$row->INDEX_NO) }}</td>
                                            <td> {{ strtoupper(@$row->subject->NAME)	 }}</td>
                                            <td> {{ strtoupper(@$row->GRADE)	 }}</td>
                                            <td> {{ strtoupper(@$row->GRADE_VALUE)	 }}</td>
                                            <td> {{ strtoupper(@$row->EXAM_TYPE) }}</td>
                                            <td> {{ strtoupper(@$row->SITTING) }}</td>
                                            <td> {{ strtoupper(@$row->MONTH) }}</td>
                                            <td> {{ strtoupper(@$row->CENTER) }}</td>

                                        </tr> 
                                        @endforeach
                                    </tbody>
                                </table>
                                         </fieldset>

                           
                              
                                <p>&nbsp;&nbsp;</p>
                        </div>
                            
                        <div id='page4'>
                            <div> <fieldset><legend>DECLARATION</legend>
                                
                                
                                
                                    <p>I {{$student->NAME}} certify that the information provided above is true and will be held personally for its authencity and will bear  
                                      any consequences for any invalid information provided.
                                    </p>
                                </fieldset>
                            
                            
                            </div>
            <div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
               <fieldset><legend>CORROBORATIVE DECLARATION</legend>
                   <p>(Please read the instructions carefully before you endorse this form)</p>
                   <p></p>
                   <p>1. This declaration should be signed a person of high integrity and honour who must also endorse at least one of the candidate's passport size photographs on the reverse side and also satisfy him/herself that the examination grades indicated
                   on the form by the applicant are true.
                   <p>2. The application will not be valid if the declaration below is not signed</p>
                   <p>3.If the declaration proves to be false, the application shall be rejected; if falsely detected after admission, the student shall be dismissed.</p>
                   <p>&nbsp;</p>
                <p> 
                    I hereby declare that the photograph endorsed by me is the true likeness of the applicant {{$student->TITLE}} {{$student->NAME}} who is personally known to me. I have inspected his/her certificates against the results indicated on the form and I satisfied that they are true and name that appears on them is the same as that by which he/she is officially/personally known to me.
                    
                    </p>
                    <table>
                        <tr>
                            <td>SIGNATURE 
                              &nbsp;.............................................................................................</td>
                           
                        </tr>
                         <tr>
                            <td>DATE 
                               &nbsp;.............................................................................................</td>
                           
                        </tr>
                         <tr>
                            <td>NAME(BLOCKLETTERS) 
                               &nbsp;.............................................................................................</td>
                           
                        </tr>
                         <tr>
                            <td>OCCUPATION
                               &nbsp;.............................................................................................</td>
                           
                        </tr>
                        <tr>
                            <td>POSITION 
                                &nbsp;.............................................................................................</td>
                           
                        </tr>
                         <tr>
                            <td>ADDRESS & OFFICIAL STAMP
                                &nbsp;.............................................................................................</td>
                           
                        </tr>
                    </table>
                </fieldset> 
            </div>
                        </div>
                        <div class="visible-print text-center" align='center'>
                            {!! QrCode::size(100)->generate(Request::url()); !!}

                        </div>
                    </div>

                </div>
                </main>
                @endsection
                @section('js')
                <script language="javascript" type="text/javascript">
                    function printDiv(divID) {
                        //Get the HTML of div
                        var divElements = document.getElementById(divID).innerHTML;
                        //Get the HTML of whole page
                        var oldPage = document.body.innerHTML;

                        //Reset the page's HTML with div's HTML only
                        document.body.innerHTML =
                                "<html><head><title></title></head><body>" +
                                divElements + "</body>";

                        //Print Page
                        window.print();

                        //Restore orignal HTML
                        document.body.innerHTML = oldPage;


                    }
                </script>

                @endsection