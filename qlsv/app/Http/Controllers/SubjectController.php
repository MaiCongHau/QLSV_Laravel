<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use DB;

class SubjectController extends Controller
{

    function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    protected $pattern = [
        'name' => 'required|regex:/^[a-zA￾ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộ
        ớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+$/i|max:50',
        'number_of_credit' => 'required|numeric|between:1,10',
        ];
    protected $messenger = [
        'required' => ':attribute không được để trống',
        'regex' => ':attribute không được chứa số hoặc ký tự đặc biệt',
        'max' => ':attribute không được lớn hơn :max ký tự',
        'between' => ':attribute phải là số từ :min đến :max',
        'numeric' => ':attribute phải là số',
        ];
    protected $customName = [ // dùng để custom lại thằng :attribute
        'name' => 'Tên',
        'number_of_credit' => 'Số tín chỉ'
    ];    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
       
        $itemPerPage = env("ITEM_PER_PAGE", 2); // nếu thằng "ITEM_PER_PAGE" ko dc cấu hình ở env thì mặc định nó là 2

        // $search = $request->input("search");
        // $subjects = Subject::where("name", "LIKE", "%$search%")->paginate(3)->withQueryString();
        // return view("subject.index",["subjects"=>$subjects],["search"=>$search]);
        $search = $request->input("search");
        $subjects = DB::table('subjects')->where('name','LIKE', "%$search%")->paginate(  $itemPerPage)->withQueryString();
        return view("subject.index",["subjects"=>$subjects],["search"=>$search]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("subject.create");
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
        $request->validate($this->pattern,$this->messenger,$this->customName); // nếu nó ko match vô đây tức ko sai thì cho tiếp, nếu match thì là sai ở dưới ko thực hiện.
        $data = $request->all();
        $subject = new Subject;
        $subject ->name = $data["name"];
        $subject ->number_of_credit = $data["number_of_credit"];
        $subject->save();
        $request->session()->put("success","Bạn đã thêm môn học thành công");
        
        return redirect()->route("subjects.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
        return view("subject.edit",["subject"=>$subject]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $data = $request->all();
        $subject["name"]=$data["name"];
        $subject["number_of_credit"]=$data["number_of_credit"];
        $subject->save();
        $request->session()->put("success","Bạn đã update môn học thành công");
        return redirect()->route("subjects.index");
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //
        try {
            $subject->forceDelete();
            session()->put("success","Bạn đã xóa môn học thành công");
        } catch (\Throwable $th) {
            session()->put("error","Bạn không thể xóa $subject->name, nếu muốn xóa vui lòng xóa ở mục đăng kí trước");
        }
        return redirect()->route("subjects.index");
    }
    public function unregistered($id) // mặc định thằng {$id} nó chui vô luôn cái function 
    {

       // khi sinh viên A đăng kí Hóa rồi thì ta éo cho nó đăng kí Hóa lại lần nữa, tức là ko cho hiễn thị môn Hóa khi mà chọn thằng A này, nghĩa là dùng ajax để mỗi khi chọn thằng A thì server éo gửi môn nó đã đăng kí

       // ở đây ta ví dụ là $id = 13, là thằng Nguyễn Văn A  
       // Đầu tiên ta xét function trước
        // function($query) use ($id){
        // $query->select('subject_id')
        //     ->from('registers')
        //     ->where('student_id','=', $id);
        // } 
        
        // $query dùng để truy vấn 
        // use($id) để cho thằng ở trong dùng được, tại ở trong ko thấy ở ngoài
        // => xong khi chạy xong ta dc 
        // SELECT `subject_id` FROM `registers` WHERE `student_id` = 13 
        // whereNotIn(Coulumn_name, Array);
        //  thì cái này lấy được số [15]
        // ghép vô thằng wherenotin ta được
        // SELECT * FROM `subjects` WHERE NOT IN 15 
        $subjects = Subject::whereNotIn('id',function($query) use ($id){

        $query->select('subject_id')
            ->from('registers')
            ->where('student_id','=', $id);
        })->get();
        // $subjects = Subject::whereNotIn("id",[15])->get();

        // sau đó ta phải encode dạng Json cho trình duyệt xử lý 
        $notUnregistereds = [];
        foreach ( $subjects as $key => $subject) {
            $notUnregistereds [] = ["id"=> $subject->id,"name"=> $subject->name];
        }
        echo json_encode( $notUnregistereds);

    }

}