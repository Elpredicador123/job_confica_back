<?php

namespace App\Imports;

use App\Models\Evidence;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class EvidenceImport implements ToCollection, WithBatchInserts, WithChunkReading, ShouldQueue
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
                Evidence::create([
                    'C_TRIPLEXOR' => $row[15],
                    'C_ROSETA OPTICA' => $row[20],
                    'C_HGU-CABLE MODEM' => $row[25],
                    'C_SPLITER' => $row[30],
                    'C_VOIP' => $row[36],
                    'RESULTADO' => $row[37],
                    'CODTECNICO' => $row[40],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $e) {
                // Registrar el mensaje de la excepción en los logs de Laravel
                Log::error('Error durante la importación Evidence: ' . $e->getMessage());
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
