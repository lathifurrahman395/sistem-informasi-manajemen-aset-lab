<?php

namespace Database\Seeders;

use App\Models\LabSchedule;
use App\Models\Location;
use Illuminate\Database\Seeder;

class LabScheduleSeeder extends Seeder
{
    /**
     * Jadwal ini di-generate otomatis dari file JADWAL_LAB.xlsx
     * (sheet "Jadwal Lab 1-4" — sudah mencakup Semester 2, 4, dan 6).
     *
     * Catatan: nilai 'hari' dinormalisasi jadi Title Case ('Senin', 'Selasa', dst)
     * supaya cocok dengan opsi filter & form di LabScheduleResource dan 
     * JadwalHariIniWidget.
     */
    public function run(): void
    {
        $jadwal = [
            ['hari' => 'Senin', 'waktu' => '08:00 - 10:30', 'lab' => 'LAB 1', 'keperluan' => 'PEMROGRAMAN BASIS DATA (A6)', 'user_name' => 'RIZKI SUWANDA, ST.,M.Kom; SAID FADLAN ANSHARI, S.Kom., M.Kom'],
            ['hari' => 'Senin', 'waktu' => '08:00 - 10:30', 'lab' => 'LAB 2', 'keperluan' => 'INTERNET OF THINGS (A1)', 'user_name' => 'TAUFIQ, S.T., M.T'],
            ['hari' => 'Senin', 'waktu' => '08:00 - 10:30', 'lab' => 'LAB 4', 'keperluan' => 'INTERNET OF THINGS (A7)', 'user_name' => 'ZAHRATUL FITRI, S.Kom., M.Kom; NUNSINA, ST., M.Kom'],
            ['hari' => 'Senin', 'waktu' => '10:40 - 13:10', 'lab' => 'LAB 1', 'keperluan' => 'JARINGAN KOMPUTER FUNDAMENTAL (A4)', 'user_name' => 'BUSTAMI, S.Si,M.Si; AR RAZI, ST.,M.Cs'],
            ['hari' => 'Senin', 'waktu' => '10:40 - 13:10', 'lab' => 'LAB 2', 'keperluan' => 'PEMROGRAMAN WEB LANJUT (A7)', 'user_name' => 'FADLISYAH, S.Si.,MT; Dr. EngMUHAMMAD FIKRY, S.Kom., M.Kom'],
            ['hari' => 'Senin', 'waktu' => '10:40 - 13:10', 'lab' => 'LAB 4', 'keperluan' => 'INTERNET OF THINGS (A2)', 'user_name' => 'ZAHRATUL FITRI, S.Kom., M.Kom; NUNSINA, ST., M.Kom'],
            ['hari' => 'Senin', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 1', 'keperluan' => 'JARINGAN KOMPUTER FUNDAMENTAL (A5)', 'user_name' => 'BUSTAMI, S.Si,M.Si; AR RAZI, ST.,M.Cs'],
            ['hari' => 'Senin', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 2', 'keperluan' => 'FORENSIKA DIGITAL (A3)', 'user_name' => 'Prof. Dr. DAHLAN ABDULLAH, S.T., M.Kom., IPU., ASEAN.Eng'],
            ['hari' => 'Senin', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 3', 'keperluan' => 'PEMROGRAMAN WEB LANJUT (A8)', 'user_name' => 'FADLISYAH, S.Si.,MT; Dr. EngMUHAMMAD FIKRY, S.Kom., M.Kom'],
            ['hari' => 'Senin', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 4', 'keperluan' => 'PEMROGRAMAN WEB LANJUT (A9)', 'user_name' => 'RIZKI SUWANDA, ST.,M.Kom; T. SUKMA ACHRIADI SUKIMAN, S.Kom., M.Kom'],
            ['hari' => 'Selasa', 'waktu' => '08:00 - 10:30', 'lab' => 'LAB 1', 'keperluan' => 'PEMROGRAMAN WEB LANJUT (A3)', 'user_name' => 'RIZKI SUWANDA, ST.,M.Kom; SAID FADLAN ANSHARI, S.Kom., M.Kom'],
            ['hari' => 'Selasa', 'waktu' => '08:00 - 10:30', 'lab' => 'LAB 2', 'keperluan' => 'PEMROGRAMAN BASIS DATA (A2)', 'user_name' => 'RIZKI SUWANDA, ST.,M.Kom; SAID FADLAN ANSHARI, S.Kom., M.Kom'],
            ['hari' => 'Selasa', 'waktu' => '08:00 - 10:30', 'lab' => 'LAB 3', 'keperluan' => 'INTERNET OF THINGS (A5)', 'user_name' => 'ZAHRATUL FITRI, S.Kom., M.Kom; NUNSINA, ST., M.Kom'],
            ['hari' => 'Selasa', 'waktu' => '08:00 - 10:30', 'lab' => 'LAB 4', 'keperluan' => 'INTERNET OF THINGS (A3)', 'user_name' => 'FADLISYAH, S.Si.,MT; Dr. EngMUHAMMAD FIKRY, S.Kom., M.Kom'],
            ['hari' => 'Selasa', 'waktu' => '10:40 - 13:10', 'lab' => 'LAB 1', 'keperluan' => 'PEMROGRAMAN WEB LANJUT (A6)', 'user_name' => 'BUSTAMI, S.Si,M.Si; AR RAZI, ST.,M.Cs'],
            ['hari' => 'Selasa', 'waktu' => '10:40 - 13:10', 'lab' => 'LAB 2', 'keperluan' => 'ALGORITMA DAN STRUKTUR DATA I (A5)', 'user_name' => 'CUT AGUSNIAR, S.T., M.Cs; Dr. EngDEFRY HAMDHANA, ST.,M.Kom'],
            ['hari' => 'Selasa', 'waktu' => '10:40 - 13:10', 'lab' => 'LAB 3', 'keperluan' => 'PEMROGRAMAN BASIS DATA (A3)', 'user_name' => 'WAHYU FUADI, ST, M.IT; ROZZI KESUMA DINATA, ST.,M.Eng'],
            ['hari' => 'Selasa', 'waktu' => '10:40 - 13:10', 'lab' => 'LAB 4', 'keperluan' => 'INTERNET OF THINGS (A4)', 'user_name' => 'FADLISYAH, S.Si.,MT; Dr. EngMUHAMMAD FIKRY, S.Kom., M.Kom'],
            ['hari' => 'Selasa', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 1', 'keperluan' => 'JARINGAN KOMPUTER FUNDAMENTAL (A1)', 'user_name' => 'Dr.MUNIRUL ULA, ST.,M.Eng; RIZAL, S.Si, M.IT'],
            ['hari' => 'Selasa', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 2', 'keperluan' => 'PEMROGRAMAN BASIS DATA (A1)', 'user_name' => 'MUKTI QAMAL, ST.,M.IT; RINI MEIYANTI, ST.,M.Kom'],
            ['hari' => 'Selasa', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 3', 'keperluan' => 'PEMROGRAMAN BASIS DATA (A5)', 'user_name' => 'DrASRIANDA, S.Kom.,M.Kom; EVA DARNILA, ST.,MT'],
            ['hari' => 'Selasa', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 4', 'keperluan' => 'PEMROGRAMAN WEB LANJUT (A5)', 'user_name' => 'RIZKI SUWANDA, ST.,M.Kom; SAID FADLAN ANSHARI, S.Kom., M.Kom'],
            ['hari' => 'Rabu', 'waktu' => '08:00 - 10:30', 'lab' => 'LAB 1', 'keperluan' => 'ALGORITMA DAN STRUKTUR DATA I (A4)', 'user_name' => 'CUT AGUSNIAR, S.T., M.Cs; Dr. EngDEFRY HAMDHANA, ST.,M.Kom'],
            ['hari' => 'Rabu', 'waktu' => '10:40 - 13:10', 'lab' => 'LAB 1', 'keperluan' => 'ALGORITMA DAN STRUKTUR DATA I (A1)', 'user_name' => 'WAHYU FUADI, ST, M.IT; ROZZI KESUMA DINATA, ST.,M.Eng'],
            ['hari' => 'Rabu', 'waktu' => '10:40 - 13:10', 'lab' => 'LAB 2', 'keperluan' => 'INTERNET OF THINGS (A9)', 'user_name' => 'ZAHRATUL FITRI, S.Kom., M.Kom; NUNSINA, ST., M.Kom'],
            ['hari' => 'Rabu', 'waktu' => '10:40 - 13:10', 'lab' => 'LAB 3', 'keperluan' => 'PEMROGRAMAN WEB LANJUT (A1)', 'user_name' => 'ZARA YUNIZAR, S.Kom.,M.Kom; LIDYA ROSNITA, S.T., M. Kom'],
            ['hari' => 'Rabu', 'waktu' => '10:40 - 13:10', 'lab' => 'LAB 4', 'keperluan' => 'JARINGAN KOMPUTER FUNDAMENTAL (A6)', 'user_name' => 'BUSTAMI, S.Si,M.Si; AR RAZI, ST.,M.Cs'],
            ['hari' => 'Rabu', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 1', 'keperluan' => 'PEMROGRAMAN WEB LANJUT (A4)', 'user_name' => 'RIZKI SUWANDA, ST.,M.Kom; SAID FADLAN ANSHARI, S.Kom., M.Kom'],
            ['hari' => 'Rabu', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 2', 'keperluan' => 'ALGORITMA DAN STRUKTUR DATA I (A6)', 'user_name' => 'DrASRIANDA, S.Kom.,M.Kom; EVA DARNILA, ST.,MT'],
            ['hari' => 'Rabu', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 3', 'keperluan' => 'PEMROGRAMAN WEB LANJUT (A2)', 'user_name' => 'ZARA YUNIZAR, S.Kom.,M.Kom; LIDYA ROSNITA, S.T., M. Kom'],
            ['hari' => 'Rabu', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 4', 'keperluan' => 'INTERNET OF THINGS (A8)', 'user_name' => 'MUKHLIS ABD MUTHALIB, ST., M.Eng., Ph.D; RISAWANDI, ST.,M.Kom'],
            ['hari' => 'Kamis', 'waktu' => '08:00 - 10:30', 'lab' => 'LAB 1', 'keperluan' => 'ALGORITMA DAN STRUKTUR DATA I (A3)', 'user_name' => 'CUT AGUSNIAR, S.T., M.Cs; Dr. EngDEFRY HAMDHANA, ST.,M.Kom'],
            ['hari' => 'Kamis', 'waktu' => '10:40 - 13:10', 'lab' => 'LAB 1', 'keperluan' => 'ALGORITMA DAN STRUKTUR DATA I (A2)', 'user_name' => 'WAHYU FUADI, ST, M.IT; ROZZI KESUMA DINATA, ST.,M.Eng'],
            ['hari' => 'Kamis', 'waktu' => '10:40 - 13:10', 'lab' => 'LAB 2', 'keperluan' => 'PENGOLAHAN SUARA (A3)', 'user_name' => 'FADLISYAH, S.Si.,MT; Dr. EngMUHAMMAD FIKRY, S.Kom., M.Kom'],
            ['hari' => 'Kamis', 'waktu' => '10:40 - 13:10', 'lab' => 'LAB 3', 'keperluan' => 'PENGOLAHAN SUARA (A5)', 'user_name' => 'MUKTI QAMAL, ST.,M.IT; RINI MEIYANTI, ST.,M.Kom'],
            ['hari' => 'Kamis', 'waktu' => '10:40 - 13:10', 'lab' => 'LAB 4', 'keperluan' => 'JARINGAN KOMPUTER FUNDAMENTAL (A2)', 'user_name' => 'Dr.MUNIRUL ULA, ST.,M.Eng; RIZAL, S.Si, M.IT'],
            ['hari' => 'Kamis', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 1', 'keperluan' => 'ALGORITMA DAN STRUKTUR DATA I (A7)', 'user_name' => 'DrASRIANDA, S.Kom.,M.Kom; EVA DARNILA, ST.,MT'],
            ['hari' => 'Kamis', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 2', 'keperluan' => 'PENGOLAHAN SUARA (A4)', 'user_name' => 'FADLISYAH, S.Si.,MT; Dr. EngMUHAMMAD FIKRY, S.Kom., M.Kom'],
            ['hari' => 'Kamis', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 3', 'keperluan' => 'PEMROGRAMAN BASIS DATA (A4)', 'user_name' => 'WAHYU FUADI, ST, M.IT; ROZZI KESUMA DINATA, ST.,M.Eng'],
            ['hari' => 'Kamis', 'waktu' => '14:00 - 16:30', 'lab' => 'LAB 4', 'keperluan' => 'JARINGAN KOMPUTER FUNDAMENTAL (A3)', 'user_name' => 'Dr.MUNIRUL ULA, ST.,M.Eng; RIZAL, S.Si, M.IT'],
            ['hari' => 'Jumat', 'waktu' => '09:00 - 11:30', 'lab' => 'LAB 1', 'keperluan' => 'FORENSIKA DIGITAL (A1)', 'user_name' => 'T. SUKMA ACHRIADI SUKIMAN, S.Kom., M.Kom; ANNI ZULFIA, S.Pd., M.Kom'],
            ['hari' => 'Jumat', 'waktu' => '09:00 - 11:30', 'lab' => 'LAB 2', 'keperluan' => 'PENGOLAHAN SUARA (A1)', 'user_name' => 'FADLISYAH, S.Si.,MT; Dr. EngMUHAMMAD FIKRY, S.Kom., M.Kom'],
            ['hari' => 'Jumat', 'waktu' => '14:30 - 17:00', 'lab' => 'LAB 1', 'keperluan' => 'FORENSIKA DIGITAL (A2)', 'user_name' => 'T. SUKMA ACHRIADI SUKIMAN, S.Kom., M.Kom; ANNI ZULFIA, S.Pd., M.Kom'],
            ['hari' => 'Jumat', 'waktu' => '14:30 - 17:00', 'lab' => 'LAB 2', 'keperluan' => 'PENGOLAHAN SUARA (A2)', 'user_name' => 'FADLISYAH, S.Si.,MT; Dr. EngMUHAMMAD FIKRY, S.Kom., M.Kom'],
            ['hari' => 'Jumat', 'waktu' => '14:30 - 17:00', 'lab' => 'LAB 4', 'keperluan' => 'INTERNET OF THINGS (A6)', 'user_name' => 'RISAWANDI, ST.,M.Kom; Dr. EngMUHAMMAD FIKRY, S.Kom., M.Kom'],
        ];

        // Ambil semua location, lalu buat lookup table yang menormalkan nama
        // (huruf besar semua + tanpa spasi), supaya "LAB 1" atau "LAB1" 
        // sama-sama cocok dengan data di database, apapun nama kolomnya.
        $locations = Location::all();

        $normalize = fn(string $s) => strtoupper(str_replace(' ', '', trim($s)));

        $lookup = [];
        foreach ($locations as $location) {
            foreach ($location->getAttributes() as $key => $value) {
                if (is_string($value) && str_contains(strtoupper($key), 'NAMA')) {
                    $lookup[$normalize($value)] = $location->id;
                }
            }
        }

        // Kosongkan dulu data lama biar tidak dobel saat re-seed
        LabSchedule::truncate();

        $skipped = 0;

        foreach ($jadwal as $item) {
            $key = $normalize($item['lab']);
            $locationId = $lookup[$key] ?? null;

            if (! $locationId) {
                $skipped++;
                $this->command->warn("Lokasi '{$item['lab']}' tidak ditemukan, baris dilewati.");
                continue;
            }

            LabSchedule::create([
                'location_id' => $locationId,
                'keperluan'   => $item['keperluan'],
                'user_name'   => $item['user_name'],
                'hari'        => $item['hari'],
                'waktu'       => $item['waktu'],
            ]);
        }

        $this->command->info(count($jadwal) - $skipped . ' jadwal berhasil ditambahkan, ' . $skipped . ' dilewati.');
    }
}
