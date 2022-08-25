<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToCollection;

class StudentImport implements ToCollection
{
    public function collection(Collection $rows)
    {
//         var_dump($rows->toArray());
//         array (size=10)
//   0 => 
//     array (size=4)
//       0 => string 'Id' (length=2)
//       1 => string 'Name' (length=4)
//       2 => string 'Birthday' (length=8)
//       3 => string 'Gender' (length=6)
//   1 => 
//     array (size=4)
//       0 => int 13
//       1 => string 'Nguyễn Văn A' (length=15)
//       2 => string '2022-06-21' (length=10)
//       3 => string 'nam' (length=3)
//   2 => 
//     array (size=4)
//       0 => int 14
//       1 => string 'Nguyễn Văn B' (length=15)
//       2 => string '2022-06-22' (length=10)
//       3 => string 'nữ' (length=4)

        $genderMap = ["nam"=>0,"nữ"=>1,"khác"=>2];
        
        foreach ($rows as $row) {
            if (!is_numeric($row[0]))  // nếu không phải là số thì nó nhảy vào thằng "continue"
            {
                continue; // đầu tiên nó match là row[0] = "id", lúc này cái câu lệnh phía sau ko được thực thi, quay trở lên thực hiện vòng lặp tiếp theo. 
            }
            $id = $row[0];
            $name = $row[1];
            $birthday = $row[2];
            $gender = $row[3];
            $student = Student::find($id); 
            // var_dump ($student->toArray());
            if (empty($student)) {
                $student = new Student();
                $student->id = $id;
            }
            $student->name = $name;
            $student->birthday = $birthday;
            $student->gender =  $genderMap[$gender];
            $student->save();
        }
    }
}
