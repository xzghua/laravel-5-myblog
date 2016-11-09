<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Models\Behavior;

class CreateBehaviorData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:behavior';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create the data what is in redis';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $len = Redis::llen('behavior');
        for ($i = 0; $i <= $len;$i++) {
            Behavior::create(json_decode(Redis::lpop('behavior'),true));
        }
    }
}
