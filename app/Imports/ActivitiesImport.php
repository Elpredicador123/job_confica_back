<?php

namespace App\Imports;

use App\Models\Activity;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ActivitiesImport implements ToCollection, WithBatchInserts, WithChunkReading, ShouldQueue
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
                Activity::create([
                    'Carnet' => explode("-", $row[0])[0],//queda
                    'Técnico' => $row[0],//queda
                    'Subtipo de Actividad' => $row[3],//queda
                    'Número de Petición' => $row[4],
                    'Fecha de Cita' => $row[5],//queda
                    'Time Slot' => $row[6],//queda
                    'Nodo_zona' => explode("_", $row[13])[0]??$row[13],//queda
                    'Estado actividad' => $row[19],//queda
                    'Tipo de Cita' => $row[44],//queda
                    'Cod_liq' => explode("-", $row[61])[0]??$row[61],//queda
                    'tipo_inefectiva' => explode("___", $row[62])[1]??'',//queda
                    'Código de Cliente' => $row[65],//queda
                    'Fecha Registro de Actividad en TOA' => $row[78],//queda
                    'Tipo de Tecnología Legados' => $row[130],//queda
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $e) {
                // Registrar el mensaje de la excepción en los logs de Laravel
                Log::error('Error durante la importación Activity: ' . $e->getMessage());
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
