<?php

namespace App\Imports;

use App\Models\Audit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class AuditImport implements ToCollection, WithBatchInserts, WithChunkReading, ShouldQueue
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
                Audit::create([
                    'Carnet de Tecnico' => $row[3],
                    'Se Realizo Inspeccion a Tecnico' => $row[6],
                    'Fotocheck2' => $row[13],
                    'Uniforme2' => $row[14],
                    'Tiene PON Power Meter2' => $row[15],
                    'Tiene Jumper Preconectorizado2' => $row[16],
                    'Tiene Cortadora de fibra2' => $row[17],
                    'Tiene Peladora de Drop2' => $row[18],
                    'Tiene Peladora de Acrilato2' => $row[19],
                    'Tiene One Click2' => $row[20],
                    'Tiene Alcohol Isopropilico2' => $row[21],
                    'Tiene Paños Para Limpiar2' => $row[22],
                    'MES' => $row[25],
                    'AÑO' => $row[26],
                    'CONFORMIDAD' => $row[29],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $e) {
                // Registrar el mensaje de la excepción en los logs de Laravel
                Log::error('Error durante la importación Audit: ' . $e->getMessage());
            }
        }
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
