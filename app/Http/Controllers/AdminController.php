<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use App\Order;
use App\CoachReview;
use App\Content;
use App\Coachdata;
use App\PlayerData;
use App\OrderSubCategory;
use App\Transaction;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Media;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function admin()
    {
        return view('admin');
    }
	
	public function getPage()
	{
		return view('home');
	}
    
    // public function dashboard()
    // {
    //     return view('admin.dashboard');
    // }

    public function users(Request $request)
    {   
        $users = User::all();
       
        return view('admin.users')->with(compact("users"));
    }

    
	/* function for update user details */
    public function updateData(Request $request)
	{

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'role_id' => 'required',
        ]);

        //if validation fails 
        if ($validator->fails())
		{
			return redirect()->back()->with('Please, Enter name and role')->first();
		}
		else
		{
			$updateUsers = User::withTrashed()->whereId($request->user_id)->first();
			if($updateUsers)
			{
				$updateUsers->fname = $request->name;
				$updateUsers->role_id = $request->role_id;
				$updateUsers->save();
				return redirect()->back()->with('flash_message_success','User data updated successfully');
			}
		}
    }

	
	
	/* function for delete user permanently */
    public function deleteUserPermanently(Request $request)
    {
		$user = User::withTrashed()->whereId($request->delete_service_id)->first();
		
        if($user)
        {	
			if($user->role_id == 1)
			{	$playedata = PlayerData::whereUserId($user->id)->first();
				if($playedata)
					$playedata->delete();
				if($user->forceDelete())
					return response()->json(['user_id'=>$user->id,'status_code'=>200]); 
			}
			if($user->role_id == 2)
			{
				$coachdata = Coachdata::whereUserId($user->id)->first();
				if($coachdata)
					$coachdata->delete();
				if($user->forceDelete())
					return response()->json(['user_id'=>$user->id,'status_code'=>200]); 
			}
        }
		else
		{
			return response()->json(['error'=>"Error Ocurs",'status_code'=>400]); 
		}
    }
	/* end of function */
	
	
	/* function for change user password */
    public function changePassword(Request $request)
	{
        $v = Validator::make($request->all(), [
			'new_password' => 'required|min:4',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->with('flash_message_success','password length minimum 4 ');
        }
        $password_new = $request->input('new_password');
        $user = User::withTrashed()->whereId($request->user_id)->first();
        
         $user->password = Hash::make($request->new_password);
                
            if ($user->save()) 
			{
              return redirect()->back()->with('flash_message_success','User password changed successfully'); 
            }
			else
			{
               return redirect()->back()->with('flash_message_success','incorrect password'); 
            }
    }
	/* end of function */
	
	
    public function logout(){
        Session::flush();
        return redirect('login')->with('flash_message_success','Logged Out successfuly');
    }

    public function orders(Request $request){
        $orders = Order::all()->sortByDesc('booking_date');
        $orderviews = array();
		
        $commission = DB::table('master_tables')->where('option_key','=','commission')->get();
		
        foreach ($orders as $key => $data) 
		{

           //time format
            $day = $data->slot_timing_start;
            $bookingStart = date("h:i", strtotime($day));
            $dayend = $data->slot_timing_end;
            $bookingEnd = date("h:i", strtotime($dayend));
            //dd($bookingStart);


            $coachName = User::find($data->coach_id);
            //echo "<pre>";print_r($coachName);die;
            if(!empty($coachName))
                $coachname = $coachName['fname'];
                $coachemail = $coachName['email'];

            $playername = User::find($data->player_id);
            //dd($playername);
            if($playername)
                $playerName = $playername->fname;
                $playerEmail = $playername->email;
			$orderviews[] = array(
                         'booking_no' => $data->id,
                         'coachname'  => $coachname,
                         'coachemail'  => $coachemail,
                         'playerName'  => $playerName,
                         'playerEmail'  => $playerEmail,
                         'total_amount'=> $data->amount,
                         'booking_date'=> date('Y-m-d',strtotime($data->booking_date)),
                         'commission'  => $data->commission,
                         'paid_coach_amount'=>$data->coach_amount,
                         'status'      =>$data->status,
                         'slot_timing_start' =>$bookingStart,
                         'slot_timing_end'   =>$bookingEnd,
                         'note'             =>$data->note,
           );
        }
        //print_r($commission[0]->option_value); die;
        return view('admin.orders',['orderviews'=>$orderviews,'option'=>'all']);
    }
	
	public function getSubOrderDetails(Request $request)
	{
		if($request->ajax())
		{
			$ordersubcategory = OrderSubCategory::whereOrderId($request->order_number)->get();
			$html = '';
			$phtml = '';
			$total_amount = 0.0;
			if(count($ordersubcategory) > 0)
			{	$i= 1;
				foreach($ordersubcategory as $ordersubcategories)
				{
					$booking_date = date('Y-m-d',strtotime($ordersubcategories->booking_date));
					$time_slot = date('H:ia',strtotime($ordersubcategories->slot_timing_start)).'-'.date('H:ia',strtotime($ordersubcategories->slot_timing_end));
					if($ordersubcategories->status == 'paid' || $ordersubcategories->status == 'completed')
					{
						$total_amount += $ordersubcategories->amount;
					}
					
					$html .= '<tr><td>'.$i++.'</td><td id="edit_service_bookingDate" name="booking_date">'.$booking_date.'</td><td>'.$time_slot.'</td><td><i class="fa fa-gbp"></i> <span id="edit_service_amount" name="amount">'.$ordersubcategories->amount.'</span></td>';
					
					if($ordersubcategories->status == 'pending')
					{
						$html .= '<td class="pending">'.$ordersubcategories->status.'</td></tr>';
					}
					else if($ordersubcategories->status == 'paid')
					{
						$html .= '<td class="paid">'.$ordersubcategories->status.'</td></tr>';
					}
					else if($ordersubcategories->status == 'completed')
					{
						$html .= '<td class="paid">'.$ordersubcategories->status.'</td></tr>';
					}
					else
					{
						$html .= '<td class="cancel">'.$ordersubcategories->status.'</td></tr>';
					}
				}
				$phtml.='<p class="text-right"><b>Subtotal : </b><i class="fa fa-gbp"></i>&nbsp;'.$total_amount.'</p>
				<p class="text-right"><b>Total : </b><i class="fa fa-gbp"></i>&nbsp;'.$total_amount.'</p>';
				
				return response()->json(['order_number'=>$request->order_number,'html'=>$html,'phtml'=>$phtml,'status'=>200]);
			}
			else
			{
				return response()->json(['order_number'=>$request->order_number,'html'=>$html,'status'=>200]); 
			}
		}
	}

    public function ordersUpdate(Request $request){
        //dd($request->id);
        $ordersUpdate = Order::find($request->orders_id);
        //dd($ordersUpdate);
        $ordersUpdate->player_id = $request->player_id;
        $ordersUpdate->coach_id = $request->coach_id;
        $ordersUpdate->booking_date = $request->booking_date;
        $ordersUpdate->amount = $request->amount;
        $ordersUpdate->status = $request->status;
        $ordersUpdate->slot_timing_start = $request->slot_timing_start;
        $ordersUpdate->slot_timing_end = $request->slot_timing_end;
        $ordersUpdate->note = $request->note;
        $ordersUpdate->save();
        return redirect('/admin/orders')->with('flash_message_success','Coach updated successfully');
    }

    public function orderStatusUpdate(Request $request){
        //dd($request->all());
        $status_id = $request->status_id;
        $status =$request->status;
        $orderStatus = Order::find($status_id);
        
        if($orderStatus){
            
            $orderStatus->status  = $status;
                if($orderStatus->save()){
                    return redirect('/admin/orders')->with('flash_message_success','status updated successfully');
                }
                else
                    return redirect('/admin/orders')->with('flash_message_success','status not updated');
        }
        else{
            return redirect('/admin/orders')->with('flash_message_success','status not updated');
        }
    }

    public function orderDestroy(Request $request){
       
        if(Order::find($request->delete_orders_id)->delete())
        {
            return response()->json(['order_id'=>$request->delete_orders_id]); 
        }
    }


    public function paid(Request $request){
        $orders = Order::where('status','=','paid')->get();
        //print_r($orders[]['slot_timing_start']); die;
        $orderviews = array();
        $commission = DB::table('master_tables')->where('option_key','=','commission')->get();
        foreach ($orders as $key => $data) {

           //time format
            $day = $data->slot_timing_start;
            $bookingStart = date("h:i", strtotime($day));
            $dayend = $data->slot_timing_end;
            $bookingEnd = date("h:i", strtotime($dayend));
            //dd($bookingStart);


            $coachName = User::find($data->coach_id);
            if($coachName)
                $coachname = $coachName->fname;
                $coachemail = $coachName->email;

            $playername = User::find($data->player_id);
            //dd($playername);
            if($playername)
                $playerName = $playername->fname;
                $playerEmail = $playername->email;
           $orderviews[] = array(
                         'booking_no' => $data->id,
                         'coachname'  => $coachname,
                         'coachemail'  => $coachemail,
                         'playerName'  => $playerName,
                         'playerEmail'  => $playerEmail,
                         'total_amount'=> $data->amount,
                         'booking_date'=> $data->booking_date,
                         'commission'  => $data->commission,
                         'paid_coach_amount'=>$data->coach_amount,
                         'status'      =>$data->status,
                         'slot_timing_start' =>$bookingStart,
                         'slot_timing_end'   =>$bookingEnd,
                         'note'             =>$data->note,
           );
        }
        //print_r($commission[0]->option_value); die;
        return view('admin.orders',['orderviews'=>$orderviews,'option'=>'paid']);
    }


    public function pending(Request $request){
        $orders = Order::where('status','=','pending')->get();
        //print_r($orders[]['slot_timing_start']); die;
        $orderviews = array();
        $commission = DB::table('master_tables')->where('option_key','=','commission')->get();
        foreach ($orders as $key => $data) {

           //time format
            $day = $data->slot_timing_start;
            $bookingStart = date("h:i", strtotime($day));
            $dayend = $data->slot_timing_end;
            $bookingEnd = date("h:i", strtotime($dayend));
            //dd($bookingStart);


            $coachName = User::find($data->coach_id);
            if($coachName)
                $coachname = $coachName->fname;
                $coachemail = $coachName->email;

            $playername = User::find($data->player_id);
            //dd($playername);
            if($playername)
                $playerName = $playername->fname;
                $playerEmail = $playername->email;
           $orderviews[] = array(
                         'booking_no' => $data->id,
                         'coachname'  => $coachname,
                         'coachemail'  => $coachemail,
                         'playerName'  => $playerName,
                         'playerEmail'  => $playerEmail,
                         'total_amount'=> $data->amount,
                         'booking_date'=> $data->booking_date,
                         'commission'  => $data->commission,
                         'paid_coach_amount'=>$data->coach_amount,
                         'status'      =>$data->status,
                         'slot_timing_start' =>$bookingStart,
                         'slot_timing_end'   =>$bookingEnd,
                         'note'             =>$data->note,
           );
        }
        //print_r($commission[0]->option_value); die;
        return view('admin.orders',['orderviews'=>$orderviews,'option'=>'pending']);
    }

    public function cancel(Request $request){
        $orders = Order::where('status','=','cancel')->get();
        //print_r($orders[]['slot_timing_start']); die;
        $orderviews = array();
        $commission = DB::table('master_tables')->where('option_key','=','commission')->get();
        foreach ($orders as $key => $data) {

           //time format
            $day = $data->slot_timing_start;
            $bookingStart = date("h:i", strtotime($day));
            $dayend = $data->slot_timing_end;
            $bookingEnd = date("h:i", strtotime($dayend));
            //dd($bookingStart);


            $coachName = User::find($data->coach_id);
            if($coachName)
                $coachname = $coachName->fname;
                $coachemail = $coachName->email;

            $playername = User::find($data->player_id);
            //dd($playername);
            if($playername)
                $playerName = $playername->fname;
                $playerEmail = $playername->email;
           $orderviews[] = array(
                         'booking_no' => $data->id,
                         'coachname'  => $coachname,
                         'coachemail'  => $coachemail,
                         'playerName'  => $playerName,
                         'playerEmail'  => $playerEmail,
                         'total_amount'=> $data->amount,
                         'booking_date'=> $data->booking_date,
                         'commission'  => $data->commission,
                         'paid_coach_amount'=>$data->coach_amount,
                         'status'      =>$data->status,
                         'slot_timing_start' =>$bookingStart,
                         'slot_timing_end'   =>$bookingEnd,
                         'note'             =>$data->note,
           );
        }
        //print_r($commission[0]->option_value); die;
        return view('admin.orders',['orderviews'=>$orderviews,'option'=>'cancel']);
    }

	
    public function getplayers(Request $request)
	{
        $players = User::where('role_id','=','1')->get();
        return view('admin.player')->with(compact('players'));
    }

    public function updatePlayer(Request $request)
	{
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'role_id' => 'required',
        ]);

        //if validation fails 
        if ($validator->fails()) 
		{
            return redirect('/admin/player')->with('flash_message_success','email all ready exists');
        }
		else
		{
        $updatePlayer = User::find($request->player_id);
        $updatePlayer->fname = $request->fname;
        $updatePlayer->email = $request->email;
        $updatePlayer->role_id = $request->role_id;
        $updatePlayer->status = $request->status;
        $updatePlayer->save();
        return redirect('/admin/player')->with('flash_message_success','User updated successfully');
        }
    }

    public function playerStatusUpdate(Request $request){
        $player_id = $request->player_id;

        $playerStatus = User::withTrashed()->whereId($player_id)->first();
        
        if($playerStatus->deleted_at == null)
        {
           
            if($playerStatus->delete())
            {
                return response()->json(['status'=>'success',]);
            }
            else
                return response()->json(['status'=>'error']);
        }
        else
        {
            if($playerStatus->restore())
                return response()->json(['status'=>'success']);
            else
                return response()->json(['status'=>'error']);
        }
    }

    public function destroyPlayer(Request $request){
       
        User::withTrashed()->whereId($request->delete_player_id)->forceDelete();
        return redirect('/admin/player')->with('flash_message_success','User deleted successfully');
    }

    public function coachs(Request $request){
        $coachs = User::select('users.id', 'users.fname','users.email','users.role_id','users.deleted_at','coachdatas.profile',					'coachdatas.stripecustomer_id')
						->where('role_id','=','2')
						->leftjoin('coachdatas','coachdatas.user_id','=', 'users.id')
						->get();   
        return view('admin.coach')->with(compact('coachs'));
    }

    public function updateCoach(Request $request){
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'role_id' => 'required',
        ]);
        if ($validator->fails()) 
		{
            return redirect('/admin/coach')->with('flash_message_success','email all ready exists');
        }
		else
		{
			$updateCoach = User::withTrashed()->whereId($request->coach_id)->first();
			$updateCoach->fname = $request->fname;
			$updateCoach->role_id = $request->role_id;
			$updateCoach->save();
        
        return redirect('/admin/coach')->with('flash_message_success','Coach updated successfully');
        }
    }

    public function coachStatusUpdate(Request $request)
	{
        $coach_id = $request->coach_id;

        $coachStatus = User::withTrashed()->whereId($coach_id)->first();
        
        if($coachStatus->deleted_at == null)
        {
			$otp =  mt_rand(100000, 999999);
			$coachStatus->verification_otp = $otp;
			$coachStatus->save();
            if($coachStatus->delete())
            {
                return response()->json(['status'=>'success',]);
            }
            else
                return response()->json(['status'=>'error']);
        }
        else
        {	
            if($coachStatus->restore())
			{
				$coachStatus->verification_otp = null;
				$coachStatus->save();
                return response()->json(['status'=>'success']);
			}
            else
                return response()->json(['status'=>'error']);
        }
    }
 
    public function destroyCoach(Request $request){
       
        $coachDataDelete = User::withTrashed()->whereId($request->delete_coach_id)->forceDelete();

        if($coachDataDelete)
        {
            return response()->json(['status'=>'success','coach_id'=>$request->delete_coach_id]); 
        }else{
            return response()->json(['status'=>'error']);
        }
    }
    public function stripeDelete(Request $request){
       
        $coach_id = $request->coach_id;
        $delete_stripe = $request->delete_stripe_id;
        $coachdata = Coachdata::whereUserId($coach_id)->first();
        if($coachdata)
        {
            $coachdata->stripecustomer_id = null;
            if($coachdata->save())
            {
                return response()->json(['status'=>'success','coach_id'=>$coach_id]);
            }
            else{
                return response()->json(['status'=>'error']);
            }
        }
        else{
            return response()->json(['status'=>'error']);
        }
    }

    public function review(Request $request){
        // $reviews = CoachReview::all();
        //$reviews = User::select('users.fname as coachName','coach_reviews.rating','coach_reviews.review','coach_reviews.status')
          //  ->where('role_id','=','2')
            //->get();
        $coachreviews = CoachReview::whereStatus(2)->get();
        $arrayreviews = array();

        foreach ($coachreviews as $key => $data) {
            $coachname = User::find($data->coach_id);
            if($coachname)
                $coachname = $coachname->fname;

            $user_name = User::find($data->sender_id);
            if($user_name)
                $user_name = $user_name->fname;

            $arrayreviews[] = array(
                                        'id' => $data->id,
                                        'coachname' => $coachname,
                                        'playername' => $user_name,
                                        'rating' => $data->rating,
                                        'review' => $data->review,
                                        'review_date' => $data->created_at->format('d F Y'),
                                        'status' =>$data->status,
                                        'review_status' =>$data->review_status,
                                    );

        }

        // print_r($arrayreviews);
        // die;


        return view('admin.review',['arrayreviews'=>$arrayreviews, 'button'=>'pending']);
    }


    public function reviewPublish(Request $request){
        //dd($request->all());
        $coachreviews = CoachReview::whereStatus(1)->get();
        $arrayreviews = array();

        foreach ($coachreviews as $key => $data) {
            $coachname = User::find($data->coach_id);
            if($coachname)
                $coachname = $coachname->fname;

            $user_name = User::find($data->sender_id);
            if($user_name)
                $user_name = $user_name->fname;

            $arrayreviews[] = array(
                                        'id' => $data->id,
                                        'coachname' => $coachname,
                                        'playername' => $user_name,
                                        'rating' => $data->rating,
                                        'review' => $data->review,
                                        'review_date' => $data->created_at->format('d F Y'),
                                        'status' =>$data->status,
                                        'review_status' =>$data->review_status,
                                    );

        }

        // print_r($arrayreviews);
        // die;


        return view('admin.review',['arrayreviews'=>$arrayreviews, 'button'=>'publish']);
    } 


    public function reviewPublishAjax(Request $request)
    {
       $review_id = $request->publish_review_id;
       $status = $request->status;
       //dd($review_id);
        $review = CoachReview::find($review_id);

        if($review)
        {
            $review->status = $status;
            if($review->save())
            {
                return response()->json(['status'=>'success','review_id'=>$review->id]);
            }
            else
                return response()->json(['status'=>'error']);
        }
        else
        {
            return response()->json(['status'=>'error']);
        } 
    }



    public function reviewUnpublish(Request $request){
        
        $coachreviews = CoachReview::whereStatus(0)->get();
        $arrayreviews = array();

        foreach ($coachreviews as $key => $data) {
            $coachname = User::find($data->coach_id);
            if($coachname)
                $coachname = $coachname->fname;

            $user_name = User::find($data->sender_id);
            if($user_name)
                $user_name = $user_name->fname;

            $arrayreviews[] = array(
                                        'id' => $data->id,
                                        'coachname' => $coachname,
                                        'playername' => $user_name,
                                        'rating' => $data->rating,
                                        'review' => $data->review,
                                        'review_date' => $data->created_at->format('d F Y'),
                                        'status' =>$data->status,
                                        'review_status' =>$data->review_status,
                                    );

        }

        // print_r($arrayreviews);
        // die;


        return view('admin.review',['arrayreviews'=>$arrayreviews, 'button'=>'unpublish']);
    }



    public function allReview(Request $request){
        
        $coachreviews = CoachReview::all();
        $arrayreviews = array();

        foreach ($coachreviews as $key => $data) {
            $coachname = User::find($data->coach_id);
            if($coachname)
                $coachname = $coachname->fname;

            $user_name = User::find($data->sender_id);
            if($user_name)
                $user_name = $user_name->fname;

            $arrayreviews[] = array(
                                        'id' => $data->id,
                                        'coachname' => $coachname,
                                        'playername' => $user_name,
                                        'rating' => $data->rating,
                                        'review' => $data->review,
                                        'review_date' => $data->created_at->format('d F Y'),
                                        'status' =>$data->status,
                                        'review_status' =>$data->review_status,
                                    );

        }

        // print_r($arrayreviews);
        // die;


        return view('admin.review',['arrayreviews'=>$arrayreviews, 'button'=>'all']);
    }

    // public function reviewUpdate(Request $request){
    //     $reviewUpdate = CoachReview::find($request->review_id);
    //     $reviewUpdate->coach_id = $request->coach_id;
    //     $reviewUpdate->sender_id = $request->sender_id;
    //     $reviewUpdate->rating = $request->rating;
    //     $reviewUpdate->review = $request->review;
    //     $reviewUpdate->status = $request->status;
    //     $reviewUpdate->save();
    //     return redirect('/admin/review')->with('flash_message_success','review updated successfully');
    // }

    public function destroyReview(Request $request){
       
        $destroyReview = CoachReview::find($request->delete_review_id)->delete();
        if($destroyReview)
        {
            return response()->json(['status'=>'success','review_id'=>$request->delete_review_id]); 
        }else{
            return response()->json(['status'=>'error']);
        }
        
    }

    public function statusUpdateReview(Request $request)
    {
        //dd($request->all());
        $review_id = $request->review_id;
        $status = $request->status_val;

        $review = CoachReview::find($review_id);

        if($review)
        {
            if($status == 1)
                $status = 0;
            else
                $status = 1;

            $review->status = $status;
            if($review->save())
            {
                return response()->json(['status'=>'success']);
            }
            else
                return response()->json(['status'=>'error']);
        }
        else
        {
            return response()->json(['status'=>'error']);
        }
    }

    public function allContent(Request $request){
        $contents = Content::all();
        return view('admin.allContent')->with(compact('contents'));
    }

    public function contentUpdate(Request $request){
        $contentUpdates = Content::find($request->content_id);
        $contentUpdates->title = $request->title;
        $contentUpdates->description = $request->description;
        $contentUpdates->save();
        return redirect('/admin/allContent')->with('flash_message_success','All content updated successfully');
    }
    public function deleteContent(Request $request){
       
        if(Content::find($request->delete_content_id)->delete())
        {
            return response()->json(['content_id'=>$request->delete_content_id]); 
        }
        
    }

    public function addContent(Request $request){
        
        return view('admin.addContent');
    }

    public function storeContent(Request $request){
         $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/addContent')->with('flash_message_success','title and description required');
        }else{
            $addContents = new Content;
            $addContents->title = $request->title;
            $addContents->description = $request->description;
            $addContents->save();
            return redirect('admin/allContent')->with('flash_message_success','title and description required');
        }
    }

    public function commissions(Request $request){
        $commissions = DB::table('master_tables')->get();
        
        return view('admin.commission')->with(compact('commissions'));
    }

    public function commissionUpdate(Request $request){
        $commissionUpdate = DB::table('master_tables')->whereId($request->commission_id)
                          ->update(['option_key' => $request->option_key,'option_value' => $request->option_value]);
        return redirect('/admin/commission')->with('flash_message_success','data updated successfully'); 
    }

    public function monthlyTransaction(){
        // $months = 
        // $currentMonth = date('m');
         $monthlyTransaction = DB::select("SELECT count(id) AS booking_date, SUM(amount) As totalAmount , SUM(commission) AS totalCommission, MONTH(booking_date) AS months FROM `orders` WHERE  YEAR(booking_date) = YEAR(CURRENT_DATE()) GROUP by MONTH(booking_date)");

         $weeklyTransaction = DB::select("SELECT count(id) AS totalBooking, SUM(amount) As totalAmount , SUM(commission) AS totalCommission, WEEKOFYEAR(booking_date) AS week FROM `orders` WHERE WEEKOFYEAR(booking_date)=WEEKOFYEAR(NOW()) GROUP by WEEKOFYEAR(booking_date)");

         $daysTransaction = DB::select("SELECT count(id) AS totalBooking, SUM(amount) As totalAmount , SUM(commission) AS totalCommission, DAYOFWEEK(booking_date) AS days FROM `orders` WHERE DATE(booking_date) = DATE(CURDATE()) GROUP by DAYOFWEEK(booking_date)");
        //print_r($daysTransaction); die;
        foreach ($monthlyTransaction as $key => $value) {
            // $day = $value->months;
            // $current_month = date("F", strtotime($day));
            // dd($current_month);
        }
        return view('admin.paymentTransaction')->with(compact('monthlyTransaction','weeklyTransaction','daysTransaction'));
    }
    public function getMedia(){
        
        $reporting = User::select('users.fname', 'users.email','media.id','media.images','media.status', 'media.type', 'media.created_at')
                   ->join('media','users.id','=','media.user_id')
                   ->orderBy('id', 'desc')
                   ->get();

        //dd($reporting);
        $reporting_array = array();

        foreach ($reporting as $key => $value) { 
            $reporting_array[$key]['id'] = $value->id; 
            $reporting_array[$key]['fname'] = $value->fname ?? "" ;
            $reporting_array[$key]['email'] = $value->email ?? "" ;
            $reporting_array[$key]['images'] = json_decode($value->images,true) ? url('').'/storage/'.json_decode($value->images,true)[0] : "" ;
            $reporting_array[$key]['type'] = $value->type ;
            $reporting_array[$key]['status'] = $value->status ;
            $reporting_array[$key]['created_at'] = $value->created_at ;
        }
        return view('admin.reporting', ['reporting_array'=>$reporting_array,'option'=>'all']);
    }

    public function mediaPublish(){
        
        $reporting = User::select('users.fname', 'users.email','media.id','media.images','media.status', 'media.type', 'media.created_at')
                   ->where('status','=',1)
                   ->join('media','users.id','=','media.user_id')
                   ->orderBy('id', 'desc')
                   ->get();

        //dd($reporting);
        $reporting_array = array();

        foreach ($reporting as $key => $value) { 
            $reporting_array[$key]['id'] = $value->id; 
            $reporting_array[$key]['fname'] = $value->fname ?? "" ;
            $reporting_array[$key]['email'] = $value->email ?? "" ;
            $reporting_array[$key]['images'] = json_decode($value->images,true) ? url('').'/storage/'.json_decode($value->images,true)[0] : "" ;
            $reporting_array[$key]['type'] = $value->type ;
            $reporting_array[$key]['status'] = $value->status ;
            $reporting_array[$key]['created_at'] = $value->created_at ;
        }
        return view('admin.reporting', ['reporting_array'=>$reporting_array,'option'=>'publish']);
    }

    public function mediaUnpublish(){
        
        $reporting = User::select('users.fname', 'users.email','media.id','media.images','media.status', 'media.type', 'media.created_at')
                   ->where('status','=',0)
                   ->join('media','users.id','=','media.user_id')
                   ->orderBy('id', 'desc')
                   ->get();

        //dd($reporting);
        $reporting_array = array();

        foreach ($reporting as $key => $value) { 
            $reporting_array[$key]['id'] = $value->id; 
            $reporting_array[$key]['fname'] = $value->fname ?? "" ;
            $reporting_array[$key]['email'] = $value->email ?? "" ;
            $reporting_array[$key]['images'] = json_decode($value->images,true) ? url('').'/storage/'.json_decode($value->images,true)[0] : "" ;
            $reporting_array[$key]['type'] = $value->type ;
            $reporting_array[$key]['status'] = $value->status ;
            $reporting_array[$key]['created_at'] = $value->created_at ;
        }
        return view('admin.reporting', ['reporting_array'=>$reporting_array,'option'=>'unpublish']);
    }

    public function reportingStatus(Request $request){
        //dd($request->all());
        $media_id = $request->media_id;
        $status = $request->status_val;

        $mediaUpdate = Media::find($media_id);
      
        if($mediaUpdate)
        {
            if($mediaUpdate->status == 1)
                $mediaUpdate->status =  $status = 0;
            else
                $mediaUpdate->status = $status = 1;

            if($mediaUpdate->save())
            {
                return response()->json(['status'=>$status]);
            }
            else
                return response()->json(['status'=>'error']);
        }
        else
        {
            return response()->json(['status'=>'error']);
        }
    }

	public function getUnverifyUsers()
	{
		$unverify_users = User::onlyTrashed()->get();
		return view('admin.unverifyuser',['users'=>$unverify_users]);
		
	}
    

} 
