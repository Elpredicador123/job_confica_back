<?php

namespace App\Imports;

use App\Models\DiaryPrimary;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class DiaryPrimaryImport implements ToCollection, WithBatchInserts, WithChunkReading, ShouldQueue
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
                DiaryPrimary::create([
                    'toa_cumpl_1ra' => $row[12],
                    'Cuenta primera agenda' => $row[55],
                    'Gestor' => $row[61],
                    'Contrata' => $row[62],
                    'Zonal' => $row[63],
                    'Fecha real' => $row[69],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $e) {
                // Registrar el mensaje de la excepción en los logs de Laravel
                Log::error('Error durante la importación DiaryPrimary: ' . $e->getMessage());
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
