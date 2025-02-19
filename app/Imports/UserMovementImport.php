<?php

namespace App\Imports;

use App\Models\Movement;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserMovementImport implements ToCollection
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){

            $user = User::where('name_ka',$row[0])->where('surname_ka',$row['1'])->first();
            if ($user && $user->card_number){
                Movement::create([
                    'user_id' => $user->id,
                    'card_number' => $user->card_number,
                    'start_date' => $row['2'].' '.$row[4],
                    'end_date' => ($row[3] > 1) ? $row['2'].' '.$row[5] : null,
                ]);
            }
        }
    }
}
