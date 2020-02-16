<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use app\User;

use App\OrderSubCategory; 

use App\Order;

class CroneForUpdateStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For update the status of training date time slot';

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
		$subOrderCategories = OrderSubCategory::whereStatus('paid')->whereDate('booking_date','<',$currentDate)->get();
		if(count($subOrderCategories) > 0)
		{
			foreach($subOrderCategories as $subOrderCategory)
			{
				$subOrderCategory->status = 'completed';
				$subOrderCategory->save();
			}
		}
		
		$orders = Order::whereStatus('paid')->get();
		{
			foreach($orders as $order)
			{
				$subOrderCategories = OrderSubCategory::whereOrderId($order->id)->get();
				$status = true;
				foreach($subOrderCategories as $subOrderCategory)
				{
					if($subOrderCategory->status == 'paid')
					{
						$status = false;
					}
				}
				
				if($status)
				{
					$order->status = 'completed';
					$order->save();
				}
			}
		}
		/* $existingSubOrders = DB::select("SELECT id,order_id,booking_date from order_sub_categories WHERE DATE_FORMAT(booking_date, '%Y-%m-%d') < '$currentDateTime' AND status = 'paid'"); */
    }
}
