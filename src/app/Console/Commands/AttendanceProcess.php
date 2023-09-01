<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AttendanceProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $usersToProcess = Work::whereNotNull('workStart')
        ->whereNull('workEnd')
        ->where('workStart', '<=' , Carbon::now()->subHours(24))
        ->get();

        foreach ($usersToProcess as $user) {
            $user->update([
                'workEnd' => Carbon::now(),
            ]);
        }

        $this->info('Attendance records processed successfully.');
    }
}
