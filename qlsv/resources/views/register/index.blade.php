@extends('layout')

@section('title')
    Danh sách sinh viên đăng kí môn học
@endsection

@section('content')
    <h1>Danh sách sinh viên đăng ký môn học</h1>
    <a href="{{ route('registers.create') }}" class="btn btn-info">Add</a>
    <form action="{{ route('registers.index') }}" method="GET">
        <label class="form-inline justify-content-end">Tìm kiếm: <input type="search" name="search" class="form-control"
                value="">
            <button class="btn btn-danger">Tìm</button>
        </label>
    </form>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Mã SV</th>
                <th>Tên SV</th>
                <th>Mã MH</th>
                <th>Tên MH</th>
                <th>Điểm</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php
                $order = 1;
            @endphp
            @foreach ($registers as $register)
                <tr>
                    <td>{{ $order++ }}</td>
                    <td>{{ $register->student_id }}</td>
                    <td>{{ $register->student->name }}</td> {{-- cái thằng student mà mình vừa tạo ở modal register, thì câu lệnh này giống như là lấy thằng id của register truy vấn lại lần nữa ở bảng student --}}
                    <td>{{ $register->subject_id }}</td>
                    <td>{{ $register->subject->name }}</td> {{-- cái thằng student mà mình vừa tạo ở modal register, thì câu lệnh này giống như là lấy thằng id của register truy vấn lại lần nữa ở bảng subject --}}
                    <td>{{ $register->score }}</td>
                    <td><a href="{{ route('registers.edit', ['register' => $register->id]) }}">Cập nhật điểm</a></td>
                    <td>
                        <button class="delete bnt btn-danger" type="submit"
                            url="{{ route('registers.destroy', ['register' => $register->id]) }}">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="container">
        <div class="d-flex justify-content-end">

            {{ $registers->links() }}
            {{-- dùng cái này để render hay hiễn thị các cái link này, mỗi 1 mục là số lượng truy vấn --}}
        </div>
    </div>

    <div>
        <span>Số lượng: {{ $registers->count() }}/{{ $registers->total() }}</span>
    </div>
@endsection
