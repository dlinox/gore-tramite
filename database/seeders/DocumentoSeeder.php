<?php

namespace Database\Seeders;

use App\Models\Documento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $documentos = [
            'ANEXOS',
            'CARTA',
            'SOLICITUD',
            'CARTA CIRCULAR',
            'CERTIFICADO ',
            'EXPEDIENTE',
            'INFORME',
            'MEMORANDUM',
            'MEMORANDUM CIRCULAR',
            'MEMORANDUM MULTIPLE',
            'MEMORIAL',
            'NOTIFICACIONES',
            'OFICIO',
            'OFICIO CIRCULAR',
            'OFICIO MULTIPLE',
            'ORDEN DE COMPRA',
            'ORDEN DE SERVICIO',
            'PROFORMA',
            'REQUERIMIENTOS',
            'OTROS',

        ];

        foreach ($documentos as  $doc) {
            Documento::create([
                'docu_nombre' => $doc,
            ]);
        }
    }
}
