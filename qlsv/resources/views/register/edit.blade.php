@extends('layout')
@section('title')
    Cập nhật điểm
@endsection

@section('content')
<h1>Chỉnh sửa điểm sinh viên</h1>
<form action="{{route("registers.update",["register"=>$register->id])}}" method="POST">
    @csrf
    @method("PUT");
      
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Tên sinh viên</label>
                        <span>{{$register->student->name}}</span>
                    </div>
                    <div class="form-group">
                        <label>Tên môn học</label>
                        <span>{{$register->subject->name}}</span>
                    </div>
                    <div class="form-group">
                        <label for="score">Điểm</label>
                        
                        <input type="number" name="score" id="score" value="{{old("score",$register->score)}}" class="form-control {{$errors->has("score") ? "is-invalid": ""}} ">
                        @error('score')
                        <span style="color: brown">{{ $message }}</span>
                        @enderror

                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection