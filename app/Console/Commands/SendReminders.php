<?php

namespace App\Console\Commands;

use App\Models\Reminder;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim reminder WA untuk kontak yang sudah waktunya';

    /**
     * Execute the console command.
     */

    public function handle(WhatsAppService $wa)
    {
        $reminders = Reminder::where('status', 'pending')
            ->where('reminder_at', '<=', now())
            ->get();

        foreach ($reminders as $reminder) {
            $wa->sendMessage($reminder->contact->phone, "{$reminder->description}");
            $reminder->update(['status' => 'send']);
            $this->info("Reminder terkirim ke {$reminder->contact->phone}");
        }

        return Command::SUCCESS;
    }
}
