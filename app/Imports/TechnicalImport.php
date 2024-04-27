<?php

namespace App\Imports;

use App\Models\Technical;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class TechnicalImport implements ToCollection, WithBatchInserts, WithChunkReading, ShouldQueue
{
    use RemembersRowNumber;
    use Queueable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        // ini_set('memory_limit', '-1');
        // set_time_limit(0);
        $currentRowNumber = $this->getRowNumber();
        foreach ($rows as $key => $row)
        {
            if ($key === 0) continue;
            try {
                Technical::updateOrCreate(
                    ['Nro_Documento' => $row[1]],
                    [
                        'Documento' => $row[0],
                        'Apellido_paterno' => $row[2],
                        'Apellido_materno' => $row[3],
                        'Nombres' => $row[4],
                        'Fecha_Nacimiento' => $row[5],
                        'Nacionalidad' => $row[6],
                        'Cargo' => $row[7],
                        'Genero' => $row[8],
                        'Contrata' => $row[9],
                        'Estado' => $row[10],
                        'Carnet' => $row[11],
                        'Nombre_Completo' => $row[12],
                        'Zonal' => $row[13],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            } catch (Exception $e) {
                // Registrar el mensaje de la excepción en los logs de Laravel
                Log::error('Error durante la importación Technical: ' . $e->getMessage());
            }
        }
    }

    public function batchSize(): int
    {
        return 3000;
    }

    public function chunkSize(): int
    {
        return 3000;
    }
}
