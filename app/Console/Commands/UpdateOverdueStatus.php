<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Console\Command;
use App\Notifications\OverdueNotification;
use Illuminate\Support\Facades\Notification;

class UpdateOverdueStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update overdue status for borrowing logs.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->setTimezone('Asia/Yangon')->format('Y-m-d');
        $overdueLogs = Borrowing::with(['member', 'book'])->where('return_date', '<', $today)
        ->where('status_id', '<>', 2)->get();
        foreach($overdueLogs as $log) {

            $log->status_id = 3;
            $log->save();

            $admins = User::where('user_role_id', '1')->get();
            foreach($admins as $admin) {
                $admin->notify(new OverdueNotification($log));
            }
        }
        $this->info('Overdue statuses updated successfully.');
    }
}
