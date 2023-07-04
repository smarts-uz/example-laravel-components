<?php

namespace App\Reports;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class One extends DefaultValueBinder implements WithStyles, FromCollection, WithHeadings,WithCustomStartCell,WithEvents
{
    use Exportable;

    private Builder $query;

    public function __construct()
    {
        $this->query = User::query()->select('id','name','email');
    }

    /**
     * @return string
     */
    public function startCell(): string
    {
        return 'A1';
    }

    /**
     * @param Worksheet $sheet
     * @return Worksheet
     */
    public function styles(Worksheet $sheet): Worksheet
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        return $sheet;
    }

    /**
     * @return Builder[]|Collection|\Illuminate\Support\Collection
     */
    public function collection(): Collection|\Illuminate\Support\Collection|array
    {
        return $this->query->get();
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
        ];
    }

    /**
     * @return string
     */
    public static function title() : string
    {
        return 'Отчет';
    }

    /**
     * @return array
     */
    public static function dtHeaders(): array
    {
        return [
            [
                __('ID') => [
                    'rowspan' => 0,
                    'colspan' => 0,
                ],
                __('Name') => [
                    'rowspan' => 0,
                    'colspan' => 0,
                ],
                __('Email') => [
                    'rowspan' => 0,
                    'colspan' => 0,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public static function dtColumns(): array
    {
        return [
            ['data' => 'id', 'name' => 'id'],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'email', 'name' => 'email'],
        ];
    }

    public static function events(): array
    {
        return [];
    }
    public static function options(): array
    {
        return [
            "autoFill" => "{focus: 'click'}",
            "colReorder" => "{order: [4, 3, 2, 1, 0, 5]}",
            "fixedColumns" => "{left: 1,right: 1}",
            "fixedHeader" => "{header: false,footer: true}",
        ];
    }

    /**
     * Write code on Method
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(40);


                $event->sheet->getDelegate()->getStyle('1')
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
