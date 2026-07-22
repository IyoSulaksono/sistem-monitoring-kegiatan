<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppNotificationService;

class SendWeeklyWhatsAppReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:whatsapp-weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi pengingat WhatsApp mingguan setiap hari Senin kepada pelaksana kegiatan';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppNotificationService $waService): int
    {
        $this->info('Mengirim pengingat notifikasi WhatsApp mingguan...');
        $sentCount = $waService->sendWeeklyReminders();
        $this->info("Berhasil memproses {$sentCount} pengingat notifikasi WhatsApp.");
        
        return Command::SUCCESS;
    }
}
