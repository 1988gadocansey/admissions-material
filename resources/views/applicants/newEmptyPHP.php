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
                            <table width="930" height="113" border="0">
                                <tr>
                                    <th align="center" valign="middle" scope="row">
                                 
                                <table style="" width="882" height="113" border="0" >
                                    <tr>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td class="heading_a uk-text-bold">TAKORADI TECHNICAL UNIVERSITY</td>


                                                </tr>
                                                <Tr>
                                                    <td class="heading_a">TEL: +233-031-2022917/8</td>
                                                </Tr>
                                                <tr>
                                                    <td class="heading_c">EMAIL: info@tpoly.edu.gh</td>
                                                </tr>
                                                 <tr>
                                                    <td class="heading_c">P.O.BOX 256,TAKORADI,GHANA</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td align='right'> <img src="<?php echo url('public/assets/images/logo.png')?>" style='width: 111px;height: auto;margin-left: -71px'/></td>
                                    </tr>
                                     
                                        
                                </table>
                                
                                
                                </tr>


                            </table>
                            <hr>
                            <table border='1'>
                                <tr>
                                    <td>
                                        <table >
                                            <tr>
                                                <td>OUR REF: TP/ADM/1621811</td>
                                                
                                            </tr>
                                            <tr>
                                                <td>YOUR REF: -------------</td>
                                            </tr>
                                            
                                            <tr>
                                                <td>{!! nl2br(strtoupper($student->ADDRESS)) !!}</td>
                                            </tr>
                                            <tr>
                                                <td>APPLICATION  N<u>O</u>:      {{  @\Auth::user()->FORM_NO}} </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td  width="15px">
                                         <img   style="width:150px;height:auto "  <?php
                                        $pic = $student->APPLICATION_NUMBER;
                                        echo $sys->picture("{!! url(\"public/uploads/photos/$pic.jpg\") !!}", 90)
                                        ?>   src='{{url("public/uploads/photos/$pic.jpg")}}' alt="  Affix Applicant picture here"    />
                                    
                                    </td>
                                </tr>
                            </table>
                            
                            <div>
                                <p>Dear  {{ $student->TITLE }}  {{ $student->NAME }}</p>
                                <p>OFFER OF ADMISSION - {{ $student->program }} </p>
                            </div>
                        </div>
                        <p>&nbsp;&nbsp;</p>
                        <div id='page2'>
                    page 2
                        </div>
                        <p> &nbsp;</p>
                        <div id='page3'>
                            page 3
                            <div class="visible-print text-center" align='center'>
                            {!! QrCode::size(100)->generate(Request::url()); !!}

                        </div>
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