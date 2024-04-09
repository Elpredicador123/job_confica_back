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
        set_time_limit(500);
        $currentRowNumber = $this->getRowNumber();
        foreach ($rows as $key => $row)
        {
            if ($key === 0) continue;
            Evidence::create([
                'Día' => $row[0],
                'SEM' => $row[1],
                'Semana' => $row[2],
                'SEM1' => $row[3],
                'Mes' => $row[4],
                'AÑO' => $row[5],
                'Marca temporal' => $row[6],
                'Requerimiento' => $row[7],
                'Contrata' => $row[8],
                'TIPO DE ATENCION' => $row[9],
                'ZONA' => $row[10],
                'EXISTE FOTO DEL TRIPLEXOR' => $row[11],
                'Opción "SI" se Visualiza Triplexor' => $row[12],
                'Si está "Bien Instalado" Validar Motivo' => $row[13],
                'Si está "Mal Instalado" Validar Motivo' => $row[14],
                'C_TRIPLEXOR' => $row[15],
                'EXISTE FOTO DE ROSETA OPTICA' => $row[16],
                'Opción Tiene Roseta Roseta' => $row[17],
                'Si está "Mal Instalado" Validar Motivo2' => $row[18],
                'Si está "Bien Instalado" Validar Motivo3' => $row[19],
                'C_ROSETA OPTICA' => $row[20],
                'Existe Foto de HGU o El Cable Modem' => $row[21],
                'estado HGU o El Cable Modem' => $row[22],
                'Observaciones de Falsa Informacion' => $row[23],
                'Comentar Observaciones' => $row[24],
                'C_HGU-CABLE MODEM' => $row[25],
                'Existe Foto de Spliter' => $row[26],
                'Opcion tiene Splitter' => $row[27],
                'Tiene Carga F' => $row[28],
                'Tiene Filtro de Retorno' => $row[29],
                'C_SPLITER' => $row[30],
                'Existe Carga de Foto de VoIP' => $row[31],
                'Opción Tiene VoiP' => $row[32],
                'estado numero Linea 1 y TOA' => $row[33],
                'Marca *Resgitrada* esta Ok' => $row[34],
                'Tiene Direccion IPv4 asignada' => $row[35],
                'C_VOIP' => $row[36],
                'RESULTADO' => $row[37],
                'RESULTADO HISPAM' => $row[38],
                'EECC' => $row[39],
                'CODTECNICO' => $row[40],
                'FECHA' => $row[41],
                'JEFATURA' => $row[42],
                'ZONA4' => $row[43],
                'Cod_Cliente' => $row[44],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
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
