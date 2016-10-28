@extends('layouts.printlayout')


@section('style')
<link rel="stylesheet" href="{!! url('public/assets/css/print.css') !!}" media="all">  
<style>
    .letter{
        text-align: right
    }
    #page1 {
    font-size: 12px;
    }
    #print{
        background-image:url("{!! url('public/assets/images/logo.png') !!},120px,110px");
        background-position: center;
    }
    @media print {
	#page1	{page-break-before:always;}
	.condition	{page-break-before:always;}
	#page2	{page-break-before:always;}
        .school	{page-break-before:always;}
	.page9	{page-break-inside:avoid; page-break-after:auto}
	 a,
  a:visited {
    text-decoration: underline;
  }
  body{font-size: 14px}
  size:A4;
  a[href]:after {
    content: " (" attr(href) ")";
  }

  abbr[title]:after {
    content: " (" attr(title) ")";
  }

   
  a[href^="javascript:"]:after,
  a[href^="#"]:after {
    content: "";
  }

  pre,
  blockquote {
    border: 1px solid #999;
    page-break-inside: avoid;
  }

  thead {
    display: table-header-group; 
  }

  tr,
   

   
  @page {
    margin: 2cm .5cm;
  }
  body{
      background: none;
  }
   
  
  .navbar {
    display: none;
  }
   

  
}
</style>
@endsection
@section('content')

<main class="mn-inner container">
    <div class="row">
        @inject('sys', 'App\Http\Controllers\SystemController')


       <!-- <a onclick="javascript:printDiv('print')" class="waves-effect waves-purple btn-flat m-b-xs">Click to print letter</a> -->

        <div class="col s12 m12 l12">
            <div class="card">
                <div class="card-content">
                    <div id='print'>
                        
                       @if(!empty($data))
                       <div id="page1">
                        <table border='1'>
                            <tr>
                                <td>
                                     <img src='{{url("public/assets/images/logo.png")}}' style="width:100px;height: auto" /> 
                                        
                                </td>
                                <td align='right' style="width:239px">
                                    <table class='letter'border='1'>
                                        <tr>
                                        <p style="font-size:14px">TAKORADI TECHNICAL UNIVERSITY<br/>
                                            TEL:+233-031-2022917/8<br/>
                                            EMAIL:info@tpoly.edu.gh<br/>
                                            P.O.BOX 256,TAKORADI,GHANA
                                        
                                        
                                        </p>
                                            
                                        </tr>
                                        
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <hr>
                        <table>
                            <tr>
                                <td>
                                    <table>
                                        <tr>
                                            <td> <p>OUR REF: TP/ADM/1621811</p></td>
                                        </tr>
                                        <tr>
                                         <td>
                                            <p>YOUR REF: ..........................</p>
                                    
                                         </td>
                                        </tr>
                                        
                                        <tr>
                                            <td><p><?php echo $data->ADDRESS;?></p></td>
                                        </tr>
                                         <tr>
                                            <td><p><?php echo date("D M d, Y");?></p></td>
                                        </tr>
                                    </table>
                                   
                                    
                                </td>
                                <td>
                                <p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>
                                      <img   style="width:240px;height: auto;margin-left: -177px "  <?php
                                        $pic = $data->APPLICATION_NUMBER;
                                        echo $sys->picture("{!! url(\"public/uploads/photos/$pic.jpg\") !!}", 90)
                                        ?>   src='{{url("public/uploads/photos/$pic.jpg")}}' alt="  Affix Applicant picture here"    />
                                  
                                </td>
                            </tr>
                         
                             
                        </table>
                        <div style="margin-left: 10px">
                            <p>Dear {{$data->TITLE}}.  {{$data->NAME}}</p>
                            <p>&nbsp;</p>
                            <div style="margin-left: 0px;text-align: justify">
                                <centerd><b><p class="">OFFER OF ADMISSION  - {{ strtoupper($sys->getProgram($data->PROGRAMME_ADMITTED))}}    PROGRAMME  -  ADMISSION N<u>O </u>: {{$data->APPLICATION_NUMBER}}</p></b></center>
                                <hr>
                                <p>We write on behalf of the Academic Board to offer you admission to Takoradi Polytechnic to persue a programme of study leading to the award of<b> {{$sys->getProgram($data->PROGRAMME_ADMITTED)}}</b>. The duration of the programme is {{$sys->getProgramDuration($data->PROGRAMME_ADMITTED)}} Academic years. A change of Programme is <strong><b>NOT ALLOWED</b>.</strong></p>
                                <p>&nbsp;</p>
                                <p>Your admission is for the {{$year}} Academic year. If you fail to enroll or withdraw from the programme without prior approval of the Polytechnic, you will forfeit the admission automatically.</p>
                                <p>&nbsp;</p>
                                
                                <p>The {{$year}} is scheduled to begin on <b> 19th September {{date('Y')}}</b>. You are however expected to report for medical examination and registration from <b>19th-30th September {{date('Y')}}</b>.You are mandated to participate in orientation programme which will run from <b>26th-30th September {{date('Y')}}</b>.</p>
                                 <p>&nbsp;</p>
                                 <p>You are required to make full payment of <b>non-refundable fee </b> of <b>GHC{{ $data->ADMISSION_FEES}}</b> at any branch of <b>PRUDENTIAL BANK into Account Number 0271900010010</b>. If you do not indicate acceptance by paying the fees before <b> 2nd September,{{date('Y')}}</b> your place will be offered to another applicant on the waiting list. You are advised to make photocopy of the Pay-in-slip for keeps and present the original to the School Accounts Office on arrival.Indicate your admission number and programme of study on the Pay-in-slip. Any Applicant who fails to make full payment of fees forfeit his/her admission. <b>Note: Fee payment is for an Academic Year</b>.</p>
                            <p>&nbsp;</p>
                            <p>You will be on probation for the full duration of your programme and may be dismissed at any time for unsatisfactory academic work or misconduct. You will be required to adhere to <b>ALL</b> the rules and regulations of the Polytechnicas contained in the Polytechnic Statutes, Examination Policy, Ethics Policy and Students' Handbook.</p>
                             <p>&nbsp;</p>
                             <p>You are also to note that your admission is subject to being declared medically fit to pursue the programme of study in this Polytechnic. You <b>are therefore required to undergo a medical examination at the Polytechnic Clinic before registration.</b> <b>You will be withdrawn from the Polytechnic if you fail to do the medical examination</b>.</p>
                            <p>&nbsp;</p>
                            <p>Applicants will also be held personally for any false statement or omission made in their applications.</p>
                            <p>&nbsp;</p>
                            <p>The Polytechnic does not give financial assistance to students. It is therefore the responsibility of students to arrange for their own sponsorship and maintenance during the period of study.</p>
                            <p>&nbsp;</p>
                            <p>You are required to note that the Polytechnic is a secular institution and is therefore not bound by observance of any religious or sectarian practices. As much as possible the Polytechnic lectures and / or examination would be scheduled to take place within normal working days, but where its is not feasible, lectures and examination would be held on other days.</p>
                            <p>&nbsp;</p>
                            <p>As a policy of the Polytechnic, all students shall be required to register under the National Health Insurance Scheme (NHIS) on their own to enable them access medical care whilst on campus.</p>
                            <p>&nbsp;</p>
                            <p>You are affiliated to {{strtoupper($data->HALL_ADMITTED)}}.</p>
                            <p>&nbsp;</p>
                            <p>Any applicant who falsified results will be withdrawn from the polytechnic and will forfeit his/her fees paid.</p>
                           <p>&nbsp;</p>
                           <p>Please, accept my congratulations on your admission to the Polytechnic.</p>
                           <p>&nbsp;</p> <p>&nbsp;</p>
                           <div>
                           <table>
                           <tr>
                           <td>
                               <p>Yours Faithfully</p>
                               <p><img src='{{url("public/assets/images/signature.JPG")}}' style="width:90px;height:auto;" /></p>
                               <p>ASST.REGISTRAR(ADMISSIONS)<br/>For: REGISTRAR</p>
                               </td>
                               <td><div class="visible-print text-center" align='center'>
                            {!! QrCode::size(100)->generate(Request::url()); !!}

                        </div></td>
                               </tr>

                               </table>
                           </div>
                            </div>
                        </div>
                       </div>
                        @else
                        <p>Letter not ready yet. come back later</p>
                        @endif
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