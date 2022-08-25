@extends('layout')

@section('title')
 Quản lý sinh viên
@endsection

@section('content')
<h1>Danh sách sinh viên</h1>
<a href="{{route("students.create")}}" class="btn btn-info">Add</a>
<a href="{{route("students.formImport")}}" class="btn btn-info">Import Excel</a>
<a href="{{route("students.export")}}" class="btn btn-info">Export Excel</a>
<form action="{{route("students.index")}}" method="GET">
	<label class="form-inline justify-content-end">Tìm kiếm: <input type="search" name="search" class="form-control" value="{{$search}}">
	<button class="btn btn-danger">Tìm</button>
	</label>
</form>
<table class="table table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>Mã SV</th>
			<th>Tên</th>
			<th>Ngày Sinh</th>
			<th>Giới Tính</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@php
			$order = 0;
		@endphp
		@foreach ($students as $student)
		@php
		$order ++;
		@endphp
		<tr>
			<td>{{$order}}</td>
			<td>{{$student->id}}</td>
			<td>{{$student->name}}</td>
			<td>{{formatVNdate($student->birthday)}}</td>
			<td>{{$student->getGendername()}}</td>
			<td><a href="{{route("students.edit",["student"=>$student->id])}}">Sửa</a></td>
			<td>
					<button class= "btn btn-danger delete" url="{{route("students.destroy",["student"=>$student->id])}}" type="submit">Xóa</button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<div class="container">
	<div class="d-flex justify-content-end">
	{{$students->links()}} 
	{{-- dùng cái này để render hay hiễn thị các cái link này, mỗi 1 mục là số lượng truy vấn  --}}
</div>
</div>

<div>
	<span>Số lượng: {{$students->count()}}/{{$students->total()}}</span>
</div>
@endsection

