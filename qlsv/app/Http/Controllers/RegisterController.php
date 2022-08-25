<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
   function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    protected $pattern = [ // cái này là rule
        'score' => 'required|numeric|between:1,10',
    ];
    
    protected $messenger =[
        'required' => ':attribute không được để trống',
        'between' => ':attribute phải là số từ :min đến :max',
        'numeric' => ':attribute phải là số',
    ]; 
    protected $customName = [ // dùng để custom lại thằng :attribute
        'score' => 'Số điểm'
    ]; 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemPerPage = env("ITEM_PER_PAGE", 2); // nếu thằng "ITEM_PER_PAGE" ko dc cấu hình ở env thì mặc định nó là 2

        $search = $request->input("search");
        // $registers = Register::where("id","LIKE","%$search%")->paginate(2)->withQueryString();
        $registers = Register::join("students","students.id","=","registers.student_id")
                             -> join("subjects","subjects.id","=","registers.subject_id")
                             ->select('registers.*') // éo có dòng này thì các thằng sau nó đè lên lên thằng trước, có thằng này nó sẽ chỉ lấy bảng registers thôi 
                             -> where("students.name","LIKE","%$search%")
                             ->orwhere("subjects.name","LIKE","%$search%")
                             ->orderBy("students.name","ASC")
                             ->orderBy("subjects.name","ASC")
                             ->paginate(   $itemPerPage)
                             ->withQueryString();
                
        return view("register.index",["registers"=>$registers,"search"=>$search]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $students = Student::all();
        return view('register.create',["students"=>$students]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
         $data = $request->all();
         $register = new Register;
         $register ->student_id = $data["student_id"];
         $register ->subject_id = $data["subject_id"];
         $register->save();
         $request->session()->put("success","Bạn đã thêm đăng kí môn học thành công");
         
         return redirect()->route("registers.index");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function show(Register $register)
    {
        //
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function edit(Register $register)
    {
        //
       
        return view("register.edit",["register"=>$register]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Register $register)
    {
        //
        $request->validate($this->pattern,$this->messenger,$this->customName); // nếu nó ko match vô đây tức ko sai thì cho tiếp, nếu match thì là sai ở dưới ko thực hiện.
        $register->score = $request->score ;
        $register->save();
        $request->session()->put("success","Bạn đã cập nhật điểm của sinh viên {$register->student->name} thành công");
        return redirect()->route("registers.index");
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function destroy(Register $register)
    {
        //
        $register->delete();
        session()->put("success","Bạn đã xóa sinh viên {$register->student->name} này thành công");
        return redirect()->route("registers.index");
    }
}
