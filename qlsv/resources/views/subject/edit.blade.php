@extends('layout')

@section('title')
    Thay đổi môn học
@endsection

@section('content')
<h1>Chỉnh Sửa Môn Học</h1>
<form action="{{route("subjects.update",["subject"=>$subject->id])}}" method="POST" accept-charset="utf-8">
    @csrf
    @method('PUT');
    <div class="container">
        <div class="row">
            <input type="hidden" name="id" value="3">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Tên</label>
                    <input type="text" class="form-control" placeholder="Tên của bạn" required name="name" value="{{$subject->name}}">
                </div>
                <div class="form-group">
                    <label>Số tín chỉ</label>
                    <input type="text" class="form-control" placeholder="Số tín chỉ" required name="number_of_credit" value="{{$subject->number_of_credit}}">
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">Lưu</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection