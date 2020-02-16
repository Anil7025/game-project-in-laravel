<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use app\User;

use App\OrderSubCategory; 

use App\Order;

class RemovePendingStatusOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'removePending:status';

    /**
     * The console command description.
     * Remove Those orders from orders and sub_order_categories table which date is less than current date
     * @var string
     */
    protected $description = 'Remove Pending orders from database';

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
        $currentDate = date('Y-m-d');
		$subOrderCategories = OrderSubCategory::whereStatus('pending')->whereDate('booking_date','<',$currentDate)->get();
		
		if(count($subOrderCategories) > 0)
		{
			foreach($subOrderCategories as $subOrderCategory)
			{
				$subOrderCategory->delete();
			}
		}
		
		$orders = Order::whereStatus('pending')->get();
		if(count($orders) > 0)
		{
			foreach($orders as $order)
			{
				$this->info('testing inside order');
				$subOrderCategories = OrderSubCategory::whereOrderId($order->id)->get();
				if(count($subOrderCategories) > 0)
				{
					//nothing to do
				}
				else
				{
					$this->info('testing inside delete');
					$order->forceDelete();
				}
			}
		}
    }
}
