@extends('layout')

@section('title')
    Danh sách môn học
@endsection

@section('content')
<h1>Danh sách Môn Học</h1>
<a href="{{route("subjects.create")}}" class="btn btn-info">Add</a>
<form action="{{route("subjects.index")}}" method="GET">
    <label class="form-inline justify-content-end">Tìm kiếm: <input type="search" name="search" class="form-control" value="{{$search}}">
    <button class="btn btn-danger">Tìm</button>
    </label>
</form>
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Mã MH</th>
            <th>Tên</th>
            <th>Số tín chỉ</th>
            <th colspan="2">Tùy Chọn</th>
        </tr>
    </thead>
    <tbody>
        @php
            $order=1;
        @endphp 
      @foreach ($subjects as $subject)
      <tr>
        <td>{{$order++}}</td>
        <td>{{$subject->id}}</td>
        <td>{{$subject->name}}</td>
        <td>{{$subject->number_of_credit}}</td>
        <td><a href="{{route("subjects.edit",["subject"=>$subject->id])}}">Sửa</a></td>
        <td>
           
                <button  class="btn btn-danger delete" type="submit" url="{{route("subjects.destroy",["subject"=>$subject->id])}}">Xóa</button>
        </td>
    </tr>
 
      @endforeach
    </tbody>
</table>
<div class="container">
	<div class="d-flex justify-content-end">
	{{$subjects->links()}} 
	{{-- dùng cái này để render hay hiễn thị các cái link này, mỗi 1 mục là số lượng truy vấn  --}}
</div>
<div>
    <span>Số lượng: {{count($subjects)}}/{{$subjects->total()}}</span>
</div>
@endsection