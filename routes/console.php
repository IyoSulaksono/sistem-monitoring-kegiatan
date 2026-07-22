<?php

use Illuminate\Support\Facades\Schedule;

// Schedule weekly Monday WhatsApp notification reminder
Schedule::command('notify:whatsapp-weekly')->weeklyOn(1, '08:00');
