<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LabSchedule;
use Barryvdh\DomPDF\Facade\Pdf;

class LabSchedulePdfController extends Controller
{
    /**
     * Cetak jadwal mingguan untuk SEMUA lab sekaligus dalam satu PDF,
     * masing-masing lab dipisah per halaman.
     */
    public function all()
    {
        $hariUrutan = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        $locations = Location::orderBy('nama_lab')->get();

        $jadwalPerLab = [];

        foreach ($locations as $location) {
            $jadwalPerLab[$location->id] = LabSchedule::where('location_id', $location->id)
                ->get()
                ->groupBy('hari')
                ->sortBy(fn($items, $hari) => array_search($hari, $hariUrutan))
                ->map(fn($items) => $items->sortBy('waktu'));
        }

        $pdf = Pdf::loadView('pdf.jadwal-lab-all', [
            'locations' => $locations,
            'jadwalPerLab' => $jadwalPerLab,
            'hariUrutan' => $hariUrutan,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('jadwal-semua-lab.pdf');
    }
}
