<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Documento;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Documento::insert([
            [
                'tipo_documento' => 'DNI'
            ],
            [
                'tipo_documento' => 'Pasaporte'
            ],
            [
                'tipo_documento' => 'RUC'
            ],
            [
                'tipo_documento' => 'Carnet Extranjería'
            ],
        ]);
    }
}
