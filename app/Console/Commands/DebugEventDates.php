<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;

class DebugEventDates extends Command
{
    protected $signature = 'debug:event-dates';
    protected $description = 'Debug event dates and times';

    public function handle()
    {
        $events = Event::whereIn('event_code', ['2407423', '2407672'])->get();
        
        foreach ($events as $event) {
            $debug = $event->debugDateTimes();
            $this->info("=== Event: {$debug['event_code']} ===");
            $this->line("Now: {$debug['now']}");
            $this->line("Start Date Raw: {$debug['start_date_raw']}");
            $this->line("End Date Raw: {$debug['end_date_raw']}");
            $this->line("Start Time Raw: {$debug['start_time_raw']}");
            $this->line("End Time Raw: {$debug['end_time_raw']}");
            $this->line("Start DateTime Combined: {$debug['start_datetime_combined']}");
            $this->line("End DateTime Combined: {$debug['end_datetime_combined']}");
            $this->line("Is After Start: " . ($debug['is_after_start'] ? 'YES' : 'NO'));
            $this->line("Is Before End: " . ($debug['is_before_end'] ? 'YES' : 'NO'));
            $this->line("Is Active: " . ($debug['is_active'] ? 'YES' : 'NO'));
            $this->line("");
        }
    }
}
