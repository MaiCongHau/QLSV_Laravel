@extends('layout')

@section('title')
    Thêm môn học mới
@endsection
@if ($errors->any())
    <div class="alert alert-danger">
        Vui lòng xem lại lỗi đã được hiễn thị
    </div>
@endif

@section('content')

<h1>Thêm Môn Học</h1>
<form action="{{route("subjects.store")}}" method="POST" accept-charset="utf-8">
    @csrf
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Tên</label>
                    <input type="text" class="form-control {{$errors->has("name") ? "is-invalid": ""}}" placeholder="Tên Môn Học Mới"  name="name" value="{{old("name")}}">
                    @error('name')
                        <span style="color: brown">{{ $message }}</span>
                    @enderror
                     {{-- để lưu lại lỗi sai của người dùng khi nhập ta dùng {{old("name")}} vào value, nếu đúng thì dữ liệu vẫn còn lưu lại luôn --}}
                </div>
                <div class="form-group">
                    <label>Số tín chỉ</label>
                    <input type="text" class="form-control {{$errors->has("number_of_credit") ? "is-invalid": ""}} " placeholder="Chỉ số tín chỉ"  name="number_of_credit" value="{{old("number_of_credit")}}">
                    @error('number_of_credit')
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