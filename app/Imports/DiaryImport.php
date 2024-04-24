<?php

namespace App\Imports;

use App\Models\Diary;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class DiaryImport implements ToCollection, WithBatchInserts, WithChunkReading, ShouldQueue
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
                Diary::create([
                    'fecha_tde' => $row[0],
                    'apptNumber' => $row[1],
                    'STATUS' => $row[2],
                    'DATE' => $row[3],
                    'diaSemana' => $row[4],
                    'estado_fin' => $row[5],
                    'XA_APPOINTMENT_SCHEDULER' => $row[6],
                    'toa_intervalo_tiempo' => $row[7],
                    'cita_ini' => $row[8],
                    'cita_fin' => $row[9],
                    'toa_cumplimiento' => $row[10],
                    'fec_ini' => $row[11],
                    'fec_fin' => $row[12],
                    'actividad' => $row[13],
                    'xa_route' => $row[14],
                    'XA_DISTRICT_NAME' => $row[15],
                    'region_new' => $row[16],
                    'jef_cmr' => $row[17],
                    'lima_prov' => $row[18],
                    'resourceId' => $row[19],
                    'activityId' => $row[20],
                    'bucket' => $row[21],
                    'Valido' => $row[22],
                    'nume' => $row[23],
                    'deno' => $row[24],
                    'eecc' => $row[25],
                    'NODO' => $row[26],
                    'TROBA' => $row[27],
                    'Liberado' => $row[28],
                    'MigCarMas' => $row[29],
                    'Priority' => $row[30],
                    'Nombre_empresa' => $row[31],
                    'Nombre_canal' => $row[32],
                    'hgu' => $row[33],
                    'Usuario_Cancela' => $row[34],
                    'Contr_mig' => $row[35],
                    'A_STOPEO' => $row[36],
                    'usu_com' => $row[37],
                    'completados' => $row[38],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $e) {
                // Registrar el mensaje de la excepción en los logs de Laravel
                Log::error('Error durante la importación Diary: ' . $e->getMessage());
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
