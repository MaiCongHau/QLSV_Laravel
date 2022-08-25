@php
$message=null;
$success = request()->session()->pull("success"); // thằng này là nó lấy session đó ra rồi xóa luôn session, để khi ta reload lại nó mất session đi ko cần phải xóa
$error = request()->session()->pull("error");// thằng này là nó lấy session đó ra rồi xóa luôn session, để khi ta reload lại nó mất session đi ko cần phải xóa
    if(!empty($error))
    {
        $alertClass = "alert-danger";
        $message = $error;
    } 
    elseif(!empty($success))
    {
        $alertClass = "alert-success";
        $message = $success;
    }
    
@endphp


@if (!empty($message))
<div class="alert {{$alertClass}}" >
    {{$message}}
   </div>   
@endif
