@extends('layout')

@section('title')
    Sinh viên đăng kí môn học
@endsection

@section('content')
<h1>Thêm đăng ký môn học</h1>

<form action="{{route("registers.store")}}" method="POST">
    @csrf
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="student_id">Tên sinh viên</label>
                    {{-- Khi người dùng chọn nó phải qua route, mà route chúng ta muốn truy cập là unregistered, mà nó lại đòi hỏi có id đi kèm, để nó biết thằng để xử lý, vậy chúng ta phải dùng 1 cái biến đi kèm, lưu ý là thằng url nó éo làm cc gì hết, mục đích của nó sinh ra là để tao qua thằng javascript dùng ajax, sau đó thay thằng pattern thành student_id  --}}
                    <select class="form-control" name="student_id" id="student_id" url = "{{route("students.subjects.unregistered",["id"=>"pattern"])}}" required>
                        <option value="">Vui lòng chọn sinh viên</option>
                        @foreach ($students as $student)
                            <option value="{{$student->id}}"> {{$student->id}}- {{$student->name}}</option>     
                        @endforeach                        
                    </select>
                </div>
                <div class="form-group">
                    <label for="subject_id">Tên môn học</label>
                    <span id="load" class="text-primary"></span>
                    <select class="form-control" name="subject_id" id="subject_id" required>
                        <option value="">Vui lòng chọn môn học</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">Lưu</button>
                </div>
            </div>
        </div>
    </div>
</form> 
@endsection