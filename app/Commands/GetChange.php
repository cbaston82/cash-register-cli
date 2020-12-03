<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class GetChange extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'change {paying : The amount paying} {owed : The amount owed}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Gets the change from what is owed';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $drawer = array(10000, 5000, 2000, 1000, 500, 100, 25, 10, 5, 1);
        $change = ($this->argument('paying') - $this->argument('owed')) * 100;
        $result = array();

        if($change !== 0) {
            if ($change > 0) {
                $this->info('Your change is ' . sprintf('$%0.2f', $change/100));

                foreach ($drawer as $money){
                    if ($change >= $money){
                        $money_amount = floor($change/$money);
                        $result[$money] = $money_amount;
                        $change -= $money*$money_amount;
                    }
                }

                foreach ($result as $dollar => $amount) {
                    $this->info(sprintf('$%0.2f %d', $dollar/100, $amount));
                }
            } else {
                $this->info('Your must pay less or what you owe. You cannot pay more!');
            }
        } else {
            $this->info('You are all paid up. You get no change!');
        }
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
