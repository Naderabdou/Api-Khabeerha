<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\User;
class ChengeStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders= Order::with('user')->get();
        foreach($orders as $order){
          foreach($order->user as $user){
            if($user->pivot->status === 'Discuss'){
                $order->user()->syncWithPivotValues($user->id ,['status' => 'under_review']);
            }
           
          }
            
        }
}
    }
