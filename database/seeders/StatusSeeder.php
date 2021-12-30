<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusNames=[
            "Subido al Sistema",
            "Traducido",            
        ];
        foreach($statusNames as $roleName){
        $roles = new Status();
        $roles->description = $roleName;
        $roles->save();
        }
    }
}
