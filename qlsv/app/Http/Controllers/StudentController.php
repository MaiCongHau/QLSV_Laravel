<?php

namespace App\Http\Controllers;

use App\Exports\StudentExport;
use App\Imports\StudentImport;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemPerPage = env("ITEM_PER_PAGE", 2); // nếu thằng "ITEM_PER_PAGE" ko dc cấu hình ở env thì mặc định nó là 2

        $search = $request->input("search"); // chứa giá trị search
        $students = Student::where("name", "LIKE", "%$search%")->paginate($itemPerPage)->withQueryString();
        // Student::where("name", "LIKE", "%$search%"): lấy được 10 dòng truy vấn
        // ->paginate(3): hiễn thị số truy vấn trong 1 trang
        // ->withQueryString(): nối tất cả số truy vấn này lại

        // $students = Student::where("name","LIKE","%$search%")->get();
        return view('student.index', ["students" => $students, "search" => $search]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student = new Student;
        $data = $request->all(); // nó chính là $_POST
        $student->name = $data["name"];
        $student->birthday = $data["birthday"];
        $student->gender = $data["gender"];
        $student->save();
        $request->session()->put("success", "Bạn đã tạo sinh viên $student->name thành công");
        return redirect()->route('students.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {

        return view('student.edit', ["student" => $student]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        // hàm này éo cần phải truyền id dô nó tự động biết luôn update chỗ nào luôn
        $data = $request->all(); // nó chính là $_POST
        $student->name = $data["name"];
        $student->birthday = $data["birthday"];
        $student->gender = $data["gender"];
        $student->save();
        $request->session()->put("success", "Bạn đã update sinh viên $student->name thành công");
        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {

        try {
            $student->forceDelete(); // xóa cả dòng dữ liệu
            session()->put("success", "Bạn đã xóa sinh viên $student->name thành công");
        } catch (\Throwable $th) {
            session()->put("error", "Bạn không thể xóa sinh viên $student->name, nếu muốn xóa vui lòng xóa ở mục đăng kí trước");
        }

        return redirect()->route('students.index');
    }
    public function export()
    {
        return Excel::download(new StudentExport, 'StudentList.xlsx'); // new StudentExport: lớp để lấy tập dữ liệu thằng này nó nhận vào là array,'StudentList.xlsx':tên file

        // filter trong file excel
        // $students = Student::where("gender","=","0")->get();
        // // var_dump ($students->toArray());
        // return Excel::download(new StudentExport($students), 'StudentList.xlsx'); // new StudentExport: lớp để lấy tập dữ liệu thằng này nó nhận vào là array,'StudentList.xlsx':tên file

    }

    public function import()
    {

        Excel::import(new StudentImport, request()->file('excel'));
        return redirect()->route("students.index");
    }

    public function formImport()
    {
        return view('student.formimport');
    }

}
