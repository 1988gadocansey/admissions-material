<?php

namespace App\Http\Controllers;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models;
use App\User;
use App\Models\AcademicRecordsModel;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Excel;

class CourseController extends Controller
{
     
    /**
     * Create a new controller instance.
     *
     
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
       
        
    }
     public function log_query() {
        \DB::listen(function ($sql, $binding, $timing) {
            \Log::info('showing query', array('sql' => $sql, 'bindings' => $binding));
        }
        );
    }
    public function uploadCourse(SystemController $sys,Request $request){

       if (@\Auth::user()->role == 'HOD' || @\Auth::user()->role == 'Support'|| @\Auth::user()->role == 'Registrar' || @\Auth::user()->department == 'top') {

          if ($request->isMethod("get")) {

           return view('courses.uploadCourse');
                            
           } 
           else{

               set_time_limit(36000);
         
 
        
           
           $valid_exts = array('csv','xls','xlsx'); // valid extensions
           $file = $request->file('file');
           $name = time() . '-' . $file->getClientOriginalName();
           if (!empty($file)) {
              
               $ext = strtolower($file->getClientOriginalExtension());
               
               if (in_array($ext, $valid_exts)) {
                   // Moves file to folder on server
                   // $file->move($destination, $name);
                    
                         $path = $request->file('file')->getRealPath();
                      $data = Excel::load($path, function($reader) {

			})->get();
                        $total=count($data);
                       if(!empty($data) && $data->count()){
 
                            $user = \Auth::user()->id;
                               foreach($data as $value=>$row)
                               {
                                   $code=$row->course_code;
                                   $program=$row->programme;
                                   $credit=$row->course_credit;
                                   $name=  strtoupper($row->course_name);
                                   $year=$row->course_level;
                                   $semester=$row->course_semester;
                                     
                                   $programme = $sys->programmeSearchByCode(); // check if the programmes in the file tally wat is in the db
                           if (in_array($program, $programme)) {
   
                       $testQuery=Models\CourseModel::where('COURSE_CODE', $code)->first();
                      
                         if(empty($testQuery)){
                             
                         
                               $course = new Models\CourseModel();
                                           $course->COURSE_CODE = $code;
                                           $course->COURSE_NAME = $name;
                                           $course->COURSE_CREDIT = $credit;
                                           $course->PROGRAMME = $program;
                                           $course->COURSE_SEMESTER = $semester;
                                           $course->COURSE_LEVEL = $year;

                                           $course->USER = $user;
                                           $course->save();
                                           \DB::commit();
                                       }
                         else{
                               
       Models\CourseModel::where('COURSE_CODE', $code)->update(array("COURSE_LEVEL" =>@$year, "COURSE_SEMESTER" => $semester, "PROGRAMME" => $program,  "COURSE_CREDIT" =>$credit,"COURSE_NAME"=>$name,"USER"=>$user ));
                                       \DB::commit();
                         }
                               }
                               else{
                                      redirect('/upload/courses')->with("error", " <span style='font-weight:bold;font-size:13px;'>File contain unrecognize programme.please try again!</span> ");
                   
                               }
                       
                               
                               
                               
                               
                      } 
                   }
               } else {
                    return redirect('/upload/courses')->with("error", " <span style='font-weight:bold;font-size:13px;'>Only excel file is accepted!</span> ");
                                  
               }
           } else {
                return redirect('/upload/courses')->with("error", " <span style='font-weight:bold;font-size:13px;'>Please upload an excel file!</span> ");
                   
           }
         }
    
       return redirect('/courses')->with("success", " <span style='font-weight:bold;font-size:13px;'>$total Courses uploaded successfully</span> ");
              

       }
     
       
     else{

           throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
      
     }
       

    }
    public function transcript(SystemController $sys,Request $request){

        if (@\Auth::user()->role == 'HOD' || @\Auth::user()->role == 'Registrar' || @\Auth::user()->department == 'top') {

           if ($request->isMethod("get")) {

            return view('courses.showTranscript');
                             
            } 
            else{

                $student=  explode(',',$request->input('q'));
                $student=$student[0];
                
              
                
             $sql=Models\StudentModel::where("INDEXNO",$student)->first();
                     
               
               if(count($sql)==0){
           
                return redirect("/transcript")->with("error","<span style='font-weight:bold;font-size:13px;'> $request->input('q') does not exist!</span>");
                }
              else{
                    
                  $array=$sys->getSemYear();
                  $sem=$array[0]->SEMESTER;
                  $year=$array[0]->YEAR;
                   return view("courses.transcript")->with('student',$sql)->with('year',$year)->with('sem',$sem);
          
              }
            }

        }

    }
    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request,SystemController $sys)
    {
        
          $courses= Models\CourseModel::query() ;
         if ($request->has('search') && trim($request->input('search')) != "") {
            // dd($request);
            $courses->where($request->input('by'), "LIKE", "%" . $request->input("search", "") . "%");
        }
        if ($request->has('program') && trim($request->input('program')) != "") {
            $courses->where("PROGRAMME", $request->input("program", ""));
        }
        if ($request->has('level') && trim($request->input('level')) != "") {
            $courses->where("COURSE_LEVEL", $request->input("level", ""));
        }
        if ($request->has('semester') && trim($request->input('semester')) != "") {
            $courses->where("COURSE_SEMESTER", "=", $request->input("semester", ""));
        }
         
        
        $data = $courses->groupBy('COURSE_NAME')->paginate(100);
        
        $request->flashExcept("_token");
          
         
        return view('courses.index')->with("data", $data)
                        ->with('program', $sys->getProgramList());
                 
    }
    public function viewMounted(Request $request,SystemController $sys) {
      $hod=@\Auth::user()->id;
      
      if(@\Auth::user()->department=="top"){
           $courses= Models\MountedCourseModel::query() ;
      }
      elseif(@\Auth::user()->role=="Lecturer"){
          $courses= Models\MountedCourseModel::query()->where('LECTURER',@\Auth::user()->staffID) ;
      }

      else{
          $courses= Models\MountedCourseModel::query()->where('MOUNTED_BY',$hod) ;
      }
         if ($request->has('search') && trim($request->input('search')) != "") {
            // dd($request);
            $courses->where($request->input('by'), "LIKE", "%" . $request->input("search", "") . "%");
        }
        if ($request->has('program') && trim($request->input('program')) != "") {
            $courses->where("PROGRAMME", $request->input("program", ""));
        }
        if ($request->has('level') && trim($request->input('level')) != "") {
            $courses->where("COURSE_LEVEL", $request->input("level", ""));
        }
        if ($request->has('semester') && trim($request->input('semester')) != "") {
            $courses->where("COURSE_SEMESTER", "=", $request->input("semester", ""));
        }
        if ($request->has('year') && trim($request->input('year')) != "") {
            $courses->where("COURSE_YEAR", "=", $request->input("year", ""));
        }
         
        
        $data = $courses->paginate(100);
        
        $request->flashExcept("_token");
          
         
        return view('courses.view_mounted')->with("data", $data)
                        ->with('program', $sys->getProgramList())
                        ->with('year',$sys->years());
    }
    public function viewRegistered(Request $request,SystemController $sys , User $user, Models\AcademicRecordsModel $record) {
        
        //$this->authorize('update',$record); // in Controllers
        /*if(Gate::allows('updatesss',$record)){
            abort(403,"No authorization");
        }*/
        $array = $sys->getSemYear();
        $sem = $array[0]->SEMESTER;
        $year = $array[0]->YEAR;
        $person=$sys->getLecturerFromStaffID(@\Auth::user()->staffID);
        $lecturer=$sys->getLecturerFromStaffID(@\Auth::user()->staffID);

       // dd($request->user()->isSupperAdmin);
        if(@\Auth::user()->role=='Lecturer' || @\Auth::user()->role=='HOD' ||@\Auth::user()->role=='Dean'){
            
       
        /*
         * make sure that only courses mounted for a 
         * lecturer is available to him
         */
        
          $courses= Models\AcademicRecordsModel::query()->where('lecturer', $person) ;
           
          
        }
        elseif($request->user()->isSupperAdmin){
             
             $courses= Models\AcademicRecordsModel::query() ;
     
        }
        else{
            //abort(420, "Illegal access detected");
             return response('Unauthorized.', 401);
        }
         if ($request->has('search') && trim($request->input('search')) != "") {
            // dd($request);
            $courses->where('course',   $sys->getCourseByIDCode($request->input("search", "")));
            
        }
         
        if ($request->has('level') && trim($request->input('level')) != "") {
            $courses->where("level", $request->input("level", ""));
        }
        if ($request->has('semester') && trim($request->input('semester')) != "") {
            $courses->where("sem", "=", $request->input("semester", ""));
        }
        if ($request->has('year') && trim($request->input('year')) != "") {
            $courses->where("year", "=", $request->input("year", ""));
        }
         $data = $courses->groupby('course')->paginate(100);
         
         $request->flashExcept("_token");
         
         foreach ($data as $key => $row) {
                   
                    $arr=$sys->getCourseCodeByID($row->course);
                   // dd($arr);
                     $data[$key]->CODE=$arr;

                     $total=$sys->totalRegistered($sem,$year,$row->course,$row->level, $lecturer);
                     $data[$key]->REGISTERED=$total;
                }
        
                 
          
         
        return view('courses.registered_courses')->with("data", $data)
                        ->with('program', $sys->getProgramList())
                        ->with('year',$sys->years());
                        
           
    }
     public function mountCourse(SystemController $sys) {
          if(@\Auth::user()->role=='HOD' || @\Auth::user()->role=='Support' || @\Auth::user()->role=='Registrar'){
        $programme=$sys->getProgramList();
        $course=$sys->getCourseList();
        //$lecturer=$sys->getLectureList();
        $allLectureres=$sys->getLectureList_All();
       // $totalLecturers = array_merge( $lecturer, $allLectureres);
         return view('courses.mount')->with('program', $programme)
                 ->with('course', $course)
                 ->with('lecturer',$allLectureres);
          }
          else{
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
        }
    }
    
    public function create(SystemController $sys) {
       if(@\Auth::user()->role=='HOD' || @\Auth::user()->role=='Support'){
        $programme=$sys->getProgramList();
         return view('courses.create')->with('programme', $programme);
       }
       else{
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
        }
    }
    public function show(Request $request) {
        
    }
    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if(@\Auth::user()->role=='HOD' || @\Auth::user()->role=='Support'){
        \DB::beginTransaction();
        try {
            $this->validate($request, [
                'name' => 'required',
                'program' => 'required',
                'code' => 'required',
                'level' => 'required',
                'credit' => 'required',
                'semester' => 'required'
            ]);

            $user=@\Auth::user()->id;

            $name = strtoupper($request->input('name'));
            $program = strtoupper($request->input('program'));
            $level =strtoupper( $request->input('level'));
            $semester =strtoupper( $request->input('semester'));
            $credit = strtoupper($request->input('credit'));
            $code = strtoupper($request->input('code'));

            $course = new Models\CourseModel();
            $course->COURSE_NAME = $name;
            $course->COURSE_CREDIT = $credit;
            $course->PROGRAMME = $program;
            $course->COURSE_SEMESTER = $semester;
            $course->COURSE_CODE = $code;
            $course->COURSE_LEVEL = $level;
            $course->USER = $user;


            if ($course->save()) {
                 \DB::commit();
                return redirect("/courses")->with("success", "Following Courses:<span style='font-weight:bold;font-size:13px;'> $name added </span>successfully added! ");
            } else {

                return redirect("/courses")->withErrors("Following Courses N<u>o</u> :<span style='font-weight:bold;font-size:13px;'> $name could not be added </span>could not be added!");
            }
        } catch (\Exception $e) {
            \DB::rollback();
        }
        }
        else{
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
        }
    }
    public function mountCourseStore(Request $request, SystemController $sys) {
      if(@\Auth::user()->role=='HOD' || @\Auth::user()->role=='Support' || @\Auth::user()->role=='Registrar'){
        \DB::beginTransaction();
        try {
            $this->validate($request, [
                'course' => 'required',
                'program' => 'required',
                'lecturer' => 'required',
                'level' => 'required',
                'credit' => 'required',
                'semester' => 'required',
                
                'year' => 'required'
            ]);


            $course = $request->input('course');
            $program = $request->input('program');
            $level = $request->input('level');
            $semester = $request->input('semester');
            $credit = $request->input('credit');
            $year = $request->input('year');
            $lecturer = $request->input('lecturer');
            $type = $request->input('type');
            if($request->input('type')==""){
               $type="Core"; 
            }
            else{
                 $type = $request->input('type');
            }
            $hod = $request->user()->id;
            $mountedCourse = new Models\MountedCourseModel();
            $mountedCourse->COURSE = $course;
            $mountedCourse->COURSE_CREDIT = $credit;
            $mountedCourse->COURSE_SEMESTER = $semester;
            $mountedCourse->COURSE_LEVEL = $level;
            $mountedCourse->COURSE_TYPE = $type;
            $mountedCourse->PROGRAMME = $program;
            $mountedCourse->LECTURER = $lecturer;
            $mountedCourse->COURSE_YEAR = $year;
            $mountedCourse->MOUNTED_BY = $hod;



            if ($mountedCourse->save()) {
                \DB::commit();
                $CourseArray=$sys->getCourseCodeByIDArray($course);
                $courseName=$CourseArray[0]->COURSE_NAME;
                $courseCode=$CourseArray[0]->COURSE_CODE;
                $staffArray=$sys->getLecturer($lecturer);
                $lecturerName=$staffArray[0]->fullName;
                $lecturePhone=$staffArray[0]->phone;
                $lectureStaffID=$staffArray[0]->staffID;
                $programCode=$sys->getProgram($program);
                $message="Hi, $lecturerName, you have been assigned $courseName, $courseCode, $programCode, year $level, $year, sem $semester";
                //dd($message);
                $sys->firesms($message, $lecturePhone,$lectureStaffID );
                return redirect("/mounted_view")->with("success", "well done:<span style='font-weight:bold;font-size:13px;'> course mounted</span>successfully  ");
            } else {

                return redirect("/mounted_view")->withErrors("Whoops N<u>o</u> :<span style='font-weight:bold;font-size:13px;'> course could not be mounted </span>could not be added!");
            }
        } catch (\Exception $e) {
            \DB::rollback();
        }
      }
        else{
           throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
        }
    }
    public function enterMark($course,$code, SystemController $sys ,Models\AcademicRecordsModel $record ){
         //$this->authorize('update',$record); // in Controllers
        if(@\Auth::user()->role=='HOD' ||@\Auth::user()->role=='Lecturer' || @\Auth::user()->department=='top'  ){
        $array=$sys->getSemYear();
        $sem=$array[0]->SEMESTER;
        $year=$array[0]->YEAR;

        $lecturer=@\Auth::user()->staffID;

        $resultOpen=$array[0]->ENTER_RESULT;
        if($resultOpen==1){
        $mark = Models\AcademicRecordsModel::where('course',$code)
                ->where('lecturer',$lecturer)
                ->where('year',$year)
                ->where('sem',$sem)
                ->paginate(100);
        $total=count($mark);
        $courseName=$sys->getCourseByID($sys->getCourseCodeByID($code));
           
        return view('courses.markSheet')->with('mark', $mark)
            ->with('year', $year)
            ->with('sem', $sem)
            ->with('mycode', $code)
            ->with('course', $courseName)
            ->with('total', $total);
        }
        else{
              abort(434, "{!!<b>Entering of marks has ended contact the Dean of your School</b>!!}");
              redirect("/registered_courses");
              
        }
        }
        else{
              throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
      
              
        }
    }
    public function marksDownloadExcel( $code, SystemController $sys )

	{
        $array=$sys->getSemYear();
        $sem=$array[0]->SEMESTER;
        $year=$array[0]->YEAR;

        $lecturer=@\Auth::user()->staffID;

          $data=Models\AcademicRecordsModel::
                join('tpoly_students', 'tpoly_academic_record.student', '=', 'tpoly_students.id')
                ->where('tpoly_academic_record.course',$code)
                ->where('tpoly_academic_record.lecturer',$lecturer)
                ->where('tpoly_academic_record.year',$year)
                ->where('tpoly_academic_record.sem',$sem)
                ->select('tpoly_students.INDEXNO','tpoly_students.NAME','tpoly_academic_record.quiz1','tpoly_academic_record.quiz2','tpoly_academic_record.midsem1','tpoly_academic_record.exam')->get();
          	 
		return Excel::create('itsolutionstuff_example', function($excel) use ($data) {

			$excel->sheet('mySheet', function($sheet) use ($data)

	        {

				$sheet->fromArray($data);

	        });

		})->download('xls');


	}
    // public function printAttendance($course,$code, SystemController $sys){
    //    if(@\Auth::user()->role=='HOD' ||@\Auth::user()->role=='Lecturer' || @\Auth::user()->department=='top'  ){
     
    //     $array=$sys->getSemYear();
    //     $sem=$array[0]->SEMESTER;
    //     $year=$array[0]->YEAR;
         
    //     $mark = Models\AcademicRecordsModel::where("course", $course)->where('year',$year)->where('sem',$sem)->paginate(100);
    //     $total=count($mark);
    //     $courseName=$sys->getCourseByID($code);
           
    //     return view('courses.attendanceSheet')->with('mark', $mark)
    //         ->with('year', $year)
    //         ->with('sem', $sem)
    //         ->with('course', $courseName)
    //         ->with('total', $total);
    //     }
         
       
    //    else{
    //         throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
      
    //    }
    // }
     public function storeMark($course,$code, SystemController $sys,Request $request){
         //dd($request);
        //$this->authorize('update',$record);
        /* if (Gate::denies('update', $record)) {
          abort(403);
          } */
        if (@\Auth::user()->role == 'HOD' || @\Auth::user()->role == 'Lecturer' || @\Auth::user()->department == 'top') {


            $array = $sys->getSemYear();
            $sem = $array[0]->SEMESTER;
            $year = $array[0]->YEAR;
            $resultOpen = $array[0]->ENTER_RESULT;
            if ($resultOpen == 1) {
                \DB::beginTransaction();
                try {
                    $host = $_SERVER['HTTP_HOST'];
                    $ipAddr = $_SERVER['REMOTE_ADDR'];
                    $userAgent = $_SERVER['HTTP_USER_AGENT'];
                    $studentIndexNo = $sys->getStudentByID($request->input('student'));
                      //dd(\Auth::user()->staffID);
                    $upper = $request->input('upper');
                    $key = $request->input('key');
                    $student = $request->input('student');
                    $quiz1 = $request->input('quiz1');
                    $quiz2 = $request->input('quiz2');
                    $quiz3 = $request->input('quiz3');
                    $midsem1 = $request->input('midsem1');

                    $course = $request->input('course');
                    $exam = $request->input('exam');

                    $courseArr= $sys->getCourseMountedInfo($course);
                           // dd($courseArr);
                    $lecturer= $courseArr[0]->LECTURER;
                    
                    $quiz1Old = $request->input('quiz1Old');
                    $quiz2Old = $request->input('quiz2Old');
                    $quiz3Old = $request->input('quiz3Old');
                    $midsem1Old = $request->input('midsemOld');
                    $examOld = $request->input('examOld');
                    for ($i = 0; $i < $upper; $i++) {
                        $keyData = $key[$i];
                        $studentData = $student[$i];
                        $quiz1Data = $quiz1[$i];
                        $quiz2Data = $quiz2[$i];
                        $quiz3Data = $quiz3[$i];
                        $midsem1Data = $midsem1[$i];
                        $examData = $exam[$i];
                        // for logging
                        $quiz1OldData = $quiz1Old[$i];
                        $quiz2OldData = $quiz2Old[$i];
                        $quiz3OldData = $quiz3Old[$i];
                        $midsem1OldData = $midsem1Old[$i];
                        $examOldData = $examOld[$i];
                        $fortyPercent = $quiz1Data + $quiz2Data + $quiz3Data + $midsem1Data;
                        $examTotal = $examData;
                        $total = $fortyPercent + $examTotal;

                        $OldfortyPercent = $quiz1OldData + $quiz2OldData + $quiz3OldData + $midsem1OldData;
                        $oldExam = $examOldData;
                        $oldClassScore = $OldfortyPercent;

                        $examLog = new Models\GradeLogModel();
                        $examLog->actor = $lecturer;
                        $examLog->student = $studentData;
                        $examLog->course = $course;
                        $examLog->oldClassScore = $oldClassScore;
                        $examLog->newClassScore = $fortyPercent;
                        $examLog->oldExamScore = $oldExam;
                        $examLog->newExamScore = $examTotal;
                        $examLog->ip = $ipAddr;
                        $examLog->host = $host;
                        $examLog->userAgent = $userAgent;
                        if ($examLog->save()) {
                            $programme=$sys->getCourseProgrammeMounted($course);
                           // dd($total);
                            $program=$sys->getProgramArray($programme);
                            $gradeArray = @$sys->getGrade($total, $program[0]->GRADING_SYSTEM);
                              $grade = @$gradeArray[0]->grade;

                           //dd($gradeArray );
                            $gradePoint = @$gradeArray[0]->value;

                            Models\AcademicRecordsModel::where("id", $keyData)->where('lecturer', $lecturer)->update(array("quiz1" => $quiz1Data, "quiz2" => $quiz2Data, "quiz3" => $quiz3Data, "midSem1" => $midsem1Data, "exam" => $examTotal, "total" => $total, "lecturer" => $lecturer, 'grade' => $grade, 'gpoint' => $gradePoint));

                            \DB::commit();
                        }
                    }
                } catch (\Exception $e) {
                    \DB::rollback();
                }
                $mark = Models\AcademicRecordsModel::where("course", $course)->where('lecturer', $lecturer)->where('year', $year)->where('sem', $sem)->paginate(100);
                $total = count($mark);
                $courseName = $sys->getCourseByID($code);

                  //return redirect("/mounted_view")->with("success", "well done:<span style='font-weight:bold;font-size:13px;'> course mounted </span>successfully mounted! ");
           
                return view('courses.markSheet')->with('mark', $mark)
                                ->with('year', $year)
                                ->with('sem', $sem)
                                 ->with('mycode', $code)
                                ->with('course', $courseName)
                                ->with('total', $total);
            } else {
                throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
      
                }
        } else {
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
      
        }
        
    }
     public function attendanceSheet(Request $request,SystemController $sys){
    if(@\Auth::user()->role=='HOD' || @\Auth::user()->department=='top'|| @\Auth::user()->role=='Dean' || @\Auth::user()->role=='Lecturer'){
           if ($request->isMethod("get")) {
             $course=$sys->getMountedCourseList();

             return view('courses.attendanceSheet')
             ->with('courses',$course)->with('year',$sys->years());
            }
           else{

                $semester = $request->input('semester');
                $year = $request->input('year');
                $course =  $request->input('course') ;
                $level = $request->input('level');
             
                $mark = Models\AcademicRecordsModel::where("course", $course)->where('year',$year)->where('sem',$semester)->where('level',$level)->paginate(100);
            
                  $courseArr= $sys->getCourseMountedInfo($course);
                           // dd($courseArr);
                            $courseDb= $courseArr[0]->ID;
                            $courseCreditDb= $courseArr[0]->COURSE_CREDIT;
                            $courseLecturerDb= $courseArr[0]->LECTURER;
                            $courseName=$sys->getCourseCodeByIDArray($courseArr[0]->COURSE);
                            $displayCourse=$courseName[0]->COURSE_NAME;
                            $displayCode=$courseName[0]->COURSE_CODE;
                            \Session::put('year', $year);
                            $url = url('printAttendance/'.$semester.'/sem/'.$displayCourse.'/course/'.$displayCode.'/code/'.$level.'/level/'.$course.'/id');
                  
                          $print_window = "<script >window.open('$url','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500')</script>";
                $request->session()->flash("success",
                "    $print_window");
                 return redirect("/attendanceSheet");
                 
            // return view('courses.printAttendance')->with('mark', $mark)
            //     ->with('year', $year)
            //     ->with('sem', $semester)
            //     ->with('course', $displayCourse)
            //     ->with('code', $displayCode);

                
           }
       }
       else{
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
        }
    }
    public function printAttendance(Request $request,$semester,$course,$code,$level,$id) {
      $year=\Session::get('year');
  $mark = Models\AcademicRecordsModel::where("course", $id)->where('year',$year)->where('sem',$semester)->where('level',$level)->paginate(100);
            
      return view('courses.printAttendance')->with('mark', $mark)
                ->with('year', $year)
                ->with('sem', $semester)
                ->with('course', $course)
                ->with('code', $code);
         
      
 
        
    }
    public function showFileUpload(SystemController $sys){
       if(@\Auth::user()->role=='HOD' || @\Auth::user()->department=='top'|| @\Auth::user()->role=='Dean' || @\Auth::user()->role=='Lecturer'){
        $programme=$sys->getProgramList();
         $course=$sys->getMountedCourseList();

         return view('courses.markUpload')->with('programme', $programme)
         ->with('courses',$course)->with('year',$sys->years());
       }
       else{
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
        }
    }
    public function uploadLegacy(){
        
    }
    public function uploadMarks(Request $request, SystemController $sys){

      $this->validate($request, [
            
            'file' => 'required',
            'course' => 'required',
            'sem' => 'required',
            'year' => 'required',
            'level' => 'required',
        ]);
         if(@\Auth::user()->role=='HOD' || @\Auth::user()->department=='top'|| @\Auth::user()->role=='Dean' || @\Auth::user()->role=='Lecturer'){
            $array = $sys->getSemYear();
            $sem = $array[0]->SEMESTER;
            $year = $array[0]->YEAR;
            $resultOpen = $array[0]->ENTER_RESULT;
            if ($resultOpen == 1) {
           

            $valid_exts = array('csv', 'xls', 'xlsx'); // valid extensions
            $file = $request->file('file');
            $path = $request->file('file')->getRealPath();

            $ext = strtolower($file->getClientOriginalExtension());
            
            $semester = $request->input('sem');
            $year1 = $request->input('year');
            $course =  $request->input('course') ;
            //$programme = $request->input('program');
            $level = $request->input('level');
            $studentIndexNo = $sys->getStudentIDfromIndexno($request->input('student'));
                   
             
           if (in_array($ext, $valid_exts)) {
               
                    $data = Excel::load($path, function($reader) {
                            
                        })->get();
                if (!empty($data) && $data->count()) {  
                

                       foreach ($data as $key => $value) {

                            $totalRecords = count($data);

                            
                          
                        //$studentDb= $sys->getStudentIDfromIndexno('0'.$value->index_no);
                         $studentDb= "0".$value->index_no  ;   
                         // dd($studentDb);
                            $courseArr= $sys->getCourseMountedInfo($course);
                           // dd($courseArr);
                            $courseDb= $courseArr[0]->ID;
                            $courseCreditDb= $courseArr[0]->COURSE_CREDIT;
                            $courseLecturerDb= $courseArr[0]->LECTURER;
                            $courseName=$sys->getCourseCodeByIDArray($courseArr[0]->COURSE);
                            $displayCourse=$courseName[0]->COURSE_NAME;
                            $displayCode=$courseName[0]->COURSE_CODE;
            $studentSearch = $sys->studentSearchByCode($year,$semester,$courseDb,$studentDb); // check if the students in the file tally with registered students
                       //dd($studentDb);
                        if (@in_array($studentDb, $studentSearch)) {
                            $indexNo=$value->index_no;
                            $quiz1=$value->quiz1;
                            $quiz2=$value->quiz2;
                            $midsem=$value->midsem;
                            $exam=$value->exam;
                            $total= round(($quiz2+$quiz1+$midsem+$exam),2);
                            $programmeDetail=$sys->getCourseProgrammeMounted($courseDb);
                            
                            $program=$sys->getProgramArray($programmeDetail);
                            $gradeArray = @$sys->getGrade($total, $program[0]->GRADING_SYSTEM);
                            $grade = @$gradeArray[0]->grade;

                           // dd($gradeArray );
                            $gradePoint = @$gradeArray[0]->value;

                            Models\AcademicRecordsModel::where("indexno", $studentDb)->where("course", $courseDb)->where("sem",$semester)->where("year",$year1)->update(array("quiz1" => $quiz1, "quiz2" => $quiz2, "quiz3" =>0, "midSem1" => $midsem, "exam" => $exam, "total" => $total, "lecturer" =>$courseLecturerDb,'grade' => $grade, 'gpoint' => $gradePoint));

                             \DB::commit();
                              
                                   
                                
                       } else {
                                return redirect('/upload/marks')->with("error", " <span style='font-weight:bold;font-size:13px;'>File contain unrecognized students for $displayCourse - $displayCode.please upload only registered students for  $displayCourse - $displayCode  as downloaded from the system!</span> ");
                            
                                  
                            } 
                        }
                          
                         
                        return redirect('/registered_courses')->with("success",  " <span style='font-weight:bold;font-size:13px;'> $totalRecords Marks  successfully uploaded for  $displayCourse - $displayCode!</span> ");
                             
                    
                } else {
                     return redirect('/upload/marks')->with("error", " <span style='font-weight:bold;font-size:13px;'>File is empty</span> ");
                                   
                }
            } else {
                 return redirect('/upload/marks')->with("error", " <span style='font-weight:bold;font-size:13px;'>Please upload only Excel file!</span> ");
                    
            }


              

        }
       else{
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
        }
      }
        else{
               
              redirect("/dashboard")->with('error','Entering of marks has ended contact the Dean of your School');
              
        }
    }
    // show form for edit resource
    public function edit($id){
        
    }

    public function update(Request $request, $id){
        
    }
    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request,   SystemController $sys, Models\CourseModel $course)
    {
        //dd($request->input("id"));
       if(@\Auth::user()->role=='HOD' ||  @\Auth::user()->role=='Support'){
           $hod=@\Auth::user()->id;
        $array=$sys->getSemYear();
        $sem=$array[0]->SEMESTER;
        $year=$array[0]->YEAR;
          
       
         $query= Models\MountedCourseModel::where('COURSE',$request->input("id"))
                ->where('COURSE_YEAR',$year)
                ->where('COURSE_SEMESTER',$sem)
                ->first();
         
        if($query==""){
            
            $query1= Models\CourseModel::where('ID',$request->input("id"))->where("USER",$hod)->delete();
             
          
            
             if($query1){
                
                  \DB::commit();
               return redirect("/courses")->with("success","<span style='font-weight:bold;font-size:13px;'> Course  successfully deleted!</span> ");
         
             }
             else{
                 
                  
               return redirect("/courses")->with("error","<span style='font-weight:bold;font-size:13px;'>Whoops!! you are not the owner of this course</span> ");
             }
            
          } 
          else{
                return redirect("/courses")->with("error","<span style='font-weight:bold;font-size:13px;'>Whoops!! you cannot delete a mounted course</span> ");
           
          }
           
       }
       else {
            abort(434, "{!!<b>Unauthorize Access detected</b>!!}");
            redirect("/dashboard");
        }
         
    }
    // delete mounted courses
    public function destroy_mounted(Request $request,   SystemController $sys, Models\CourseModel $course)
    {
       if(@\Auth::user()->role=='HOD'){
        $array=$sys->getSemYear();
        $sem=$array[0]->SEMESTER;
        $year=$array[0]->YEAR;
          
        \DB::beginTransaction();
          try {
          
            
             Models\MountedCourseModel::where('ID',$request->input("id"))->delete();
             
          
             \DB::commit();
               return redirect("/mounted_view")->with("success","<span style='font-weight:bold;font-size:13px;'> Course  successfully deleted!</span> ");
   
          
          }catch (\Exception $e) {
                \DB::rollback();
          } 
       }
       else {
            abort(434, "{!!<b>Unauthorize Access detected</b>!!}");
            redirect("/dashboard");
        }
         
    }
    public function courseDownloadExcel($type)

	{

         
		$data = Models\CourseModel::select('COURSE_CODE','COURSE_NAME','COURSE_LEVEL','COURSE_CREDIT','COURSE_SEMESTER','PROGRAMME')->take(5)->get()->toArray();

		return Excel::create('courses_example', function($excel) use ($data) {

			$excel->sheet('mySheet', function($sheet) use ($data)

	        {

				$sheet->fromArray($data);

	        });

		})->download($type);

	}
}

