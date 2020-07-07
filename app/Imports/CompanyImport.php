<?php

namespace App\Imports;

use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CompanyImport implements ToModel, ToCollection
{
    /* public function __construct(){ */
    /*     /1* $this->app *1/ */
    /*     /1*      ->make(\Maatwebsite\Excel\Transactions\TransactionManager::class) *1/ */
    /*     /1*      ->extend( *1/ */
    /*     /1*          'your_handler', *1/ */
    /*     /1*          function() { *1/ */
    /*     /1*              return false; *1/ */
    /*     /1*          } *1/ */
    /*     /1*     ); *1/ */
    /* } */

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        /* dd($row); */

        if (!empty($row[2]) && !empty($row[3])) {
            return new Company([
                'name'     => $row[0],
                'email'    => $row[1],
            ]);
        }

        /* return new Company(); */
    }

    public function collection(Collection $rows)
    {
        dd('col');
        foreach ($rows as $row)
        {

            User::create([
                'name' => $row[0],
            ]);
        }
    }
}
