<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\ProgressLog;
use App\Models\User;
use Carbon\Carbon;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $staf = User::where('username', 'staf')->first();
        $siti = User::where('username', 'siti')->first();
        $admin = User::where('username', 'admin')->first();

        // 1. Pengembangan Portal Satu Data Kota Medan (Triwulan III - In Progress, step 3)
        $act1 = Activity::create([
            'title' => 'Pemeliharaan Genset Data Center',
            'description' => 'Maintenance rutin Genset Data Center Diskominfo Kota Medan.',
            'assigned_to' => $staf->id,
            'start_date' => Carbon::now()->subDays(20)->format('Y-m-d'),
            'deadline' => Carbon::now()->addDays(12)->format('Y-m-d'), // Near deadline (<= 14 days)
            'status' => 'Dalam Proses',
            'transaction_method' => 2, // e-Purchasing
            'current_step' => 3, // Pengerjaan
        ]);

        ProgressLog::create([
            'activity_id' => $act1->id,
            'step' => 1,
            'description' => 'Penyusunan Kerangka Acuan Kerja (KAK) dan Pendataan Kebutuhan Genset Data Center.',
            'notes' => 'Disetujui oleh Kepala Bidang.',
            'created_by' => $staf->id,
            'created_at' => Carbon::now()->subDays(18),
        ]);

        ProgressLog::create([
            'activity_id' => $act1->id,
            'step' => 2,
            'description' => 'Pengajuan e-Purchasing katalog elektronik lokal penyedia.',
            'notes' => 'Nomor Kontrak: 027/DISKOMINFO/2026.',
            'created_by' => $staf->id,
            'created_at' => Carbon::now()->subDays(12),
        ]);

        ProgressLog::create([
            'activity_id' => $act1->id,
            'step' => 3,
            'description' => 'Pengerjaan pertama.',
            'notes' => 'Progres berjalan 60%. Tahap uji coba endpoint.',
            'created_by' => $staf->id,
            'created_at' => Carbon::now()->subDays(3),
        ]);

        // 2. Penyediaan Infrastruktur Jaringan Internet Kelurahan (Triwulan III - In Progress, step 2)
        $act2 = Activity::create([
            'title' => 'Penyediaan Infrastruktur Jaringan Internet Fiber Optik Kelurahan',
            'description' => 'Pemasangan jaringan internet kecepatan tinggi untuk 151 Kantor Kelurahan se-Kota Medan.',
            'assigned_to' => $siti->id,
            'start_date' => Carbon::now()->subDays(15)->format('Y-m-d'),
            'deadline' => Carbon::now()->addDays(5)->format('Y-m-d'), // Urgent near deadline (5 days)
            'status' => 'Dalam Proses',
            'transaction_method' => 3, // Lelang
            'current_step' => 2, // Pengajuan
        ]);

        ProgressLog::create([
            'activity_id' => $act2->id,
            'step' => 1,
            'description' => 'Survey lapangan titik koordinat router di 151 Kantor Kelurahan.',
            'notes' => 'Survey selesai 100%.',
            'created_by' => $siti->id,
            'created_at' => Carbon::now()->subDays(10),
        ]);

        ProgressLog::create([
            'activity_id' => $act2->id,
            'step' => 2,
            'description' => 'Pengajuan dokumen lelang ke Bagian Pengadaan Barang dan Jasa (PBJ).',
            'notes' => 'Menunggu penetapan pemenang lelang.',
            'created_by' => $siti->id,
            'created_at' => Carbon::now()->subDays(2),
        ]);

        // 3. Pemeliharaan Server & Storage Data Center (Triwulan III - Delayed / Overdue)
        $act3 = Activity::create([
            'title' => 'Pemeliharaan Rutin Server & Storage Data Center Pemko Medan',
            'description' => 'Peremajaan perangkat keras, pembersihan physical cluster, dan backup rutin.',
            'assigned_to' => $staf->id,
            'start_date' => Carbon::now()->subDays(30)->format('Y-m-d'),
            'deadline' => Carbon::now()->subDays(3)->format('Y-m-d'), // Overdue (Terlambat)
            'status' => 'Terlambat',
            'transaction_method' => 1, // Pengadaan Langsung
            'current_step' => 1, // Persiapan
        ]);

        ProgressLog::create([
            'activity_id' => $act3->id,
            'step' => 1,
            'description' => 'Penyusunan rencana pemeliharaan dan jadwal downtime server.',
            'notes' => 'Kendala kelangkaan sparepart vendor.',
            'created_by' => $staf->id,
            'created_at' => Carbon::now()->subDays(20),
        ]);

        // 4. Sosialisasi Literasi Digital & Keamanan Siber ASN (Triwulan III - Selesai)
        $act4 = Activity::create([
            'title' => 'Sosialisasi Literasi Digital & Kesadaran Keamanan Siber ASN',
            'description' => 'Pelatihan keamanan informasi dan pencegahan insiden phishing bagi perwakilan OPD Kota Medan.',
            'assigned_to' => $siti->id,
            'start_date' => Carbon::now()->subDays(25)->format('Y-m-d'),
            'deadline' => Carbon::now()->subDays(5)->format('Y-m-d'),
            'status' => 'Selesai',
            'transaction_method' => 1, // Pengadaan Langsung
            'current_step' => 5, // Selesai
        ]);

        ProgressLog::create([
            'activity_id' => $act4->id,
            'step' => 4,
            'description' => 'Penyelesaian berita acara pemeriksaan pekerjaan dan verifikasi pertanggungjawaban keuangan.',
            'notes' => 'Dokumen lengkap.',
            'created_by' => $siti->id,
            'created_at' => Carbon::now()->subDays(7),
        ]);

        ProgressLog::create([
            'activity_id' => $act4->id,
            'step' => 5,
            'description' => 'Pencairan pembayaran 100% dan pengarsipan laporan akhir.',
            'notes' => 'Kegiatan tuntas.',
            'created_by' => $siti->id,
            'created_at' => Carbon::now()->subDays(5),
        ]);

        // 5. Upgrade Lisensi Tanda Tangan Elektronik OPD (Triwulan III - Belum Dikerjakan)
        $act5 = Activity::create([
            'title' => 'Upgrade & Distribusi Sertifikat Tanda Tangan Elektronik (TTE) OPD',
            'description' => 'Kerjasama dengan BSrE BSSN untuk penerbitan sertifikat digital 30 OPD Medan.',
            'assigned_to' => $staf->id,
            'start_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
            'deadline' => Carbon::now()->addDays(25)->format('Y-m-d'),
            'status' => 'Belum Dimulai',
            'transaction_method' => 2, // e-Purchasing
            'current_step' => 0, // Belum dikerjakan
        ]);
    }
}
