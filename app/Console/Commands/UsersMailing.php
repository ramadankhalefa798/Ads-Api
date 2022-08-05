<?php

namespace App\Console\Commands;

use App\Jobs\SendMails;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UsersMailing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:mailing';

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
        $users = User::join('advertisements', 'advertisements.user_id', 'users.id')
            ->where('advertisements.start_date', Carbon::now()->addDay(1)->toDateString())
            ->chunk(50, function ($data) {
                dispatch(new SendMails($data));
            });
    }
}
