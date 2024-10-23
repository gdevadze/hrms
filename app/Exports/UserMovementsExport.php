<?php

namespace App\Exports;

use App\Models\Movement;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class UserMovementsExport implements FromCollection, ShouldAutoSize, WithHeadings,WithMapping
{
    protected $start_date;
    protected $end_date;
    public function __construct($startDate,$endDate)
    {
        $this->start_date = $startDate;
        $this->end_date = $endDate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $movements = Movement::query()->with('user');
        if($this->start_date){
            $movements = $movements->whereDate('start_date','>=',$this->start_date);
        }
        if($this->end_date){
            $movements = $movements->whereDate('start_date','<=',$this->end_date);
        }
        return $movements->get();
    }

    public function map($movement): array
    {
        return [
            $movement['user']['personal_num'].' ',
            $movement['user']['name_ka'],
            $movement['user']['surname_ka'],
            $movement['user']['user_companies']->implode('position.title',', '),
            Carbon::parse($movement['start_date'])->format('d.m.Y'),
            Carbon::parse($movement['start_date'])->format('H:i:s'),
            ($movement['end_date']) ? Carbon::parse($movement['end_date'])->format('H:i:s') : '-',
        ];
    }


    public function headings(): array
    {
        return [
            'პირადი ნომერი',
            'სახელი',
            'გვარი',
            'პოზიცია',
            'თარიღი',
            'გამოცხადება',
            'გასვლა',
        ];
    }
}
