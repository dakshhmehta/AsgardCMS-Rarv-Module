<?php

namespace Modules\Rarv\Table;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportTable implements FromCollection, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected $table = null;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function collection()
    {
        $this->table->setColumns(array_merge(['id'], $this->table->getColumns()));

        return $this->table->getRecords(false);
    }

    public function headings():array
    {
        $headers = $this->table->getHeaders();
        $cols = ['ID'];

        foreach ($headers as $header) {
            $cols[] = trans($header);
        }

        return $cols;
    }
}
