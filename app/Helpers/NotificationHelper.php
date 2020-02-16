<?php


	/*  */
	function sendNotificationForAndorid($mediapostedby_userid,$commentedby_userid,$media_id,$comment,$title,$body,$token)
	{
		/* return; */
		 /* $registrationIds = array($token); */
		 $SERVER_KEY  = config('configsetting.FIREBASE_CLOUD_MESSAGING_SERVER_KEY');
		 
		$notification = array(
							'title'	=> $title,
							'sound'	=> true,
							"body" 	=> $body
							);

		$extraNotificationData = ["message" => $notification,"moredata" =>'add extra data'];
		
		$fields = array(
			/* 'registration_ids' => $tokenList, //multple token array */
			'to' => $token, //for single user
			'notification'	=> $notification,
			'data'	=> $extraNotificationData
			);
			 
		$headers = array(
			'Authorization: key=' . $SERVER_KEY,
			'Content-Type: application/json'
			); 
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields,true ) );
		$result = curl_exec($ch );
		if ($result === FALSE) 
		{
			   die('FCM Send Error: ' . curl_error($ch));
		}
		curl_close( $ch );
		  /*  print_r($result);
		 die; */   
		return $result;
	}
	
	function sendNotificationForIOS($mediapostedby_userid,$commentedby_userid,$media_id,$comment,$title,$body,$token)
	{
		/* return; */
		ignore_user_abort();
		ob_start();
		 $url = "https://fcm.googleapis.com/fcm/send";
		 
		 $registrationIds = array();
		 
		array_push($registrationIds, $token);
	
		 $serverKey  = config('configsetting.FIREBASE_CLOUD_MESSAGING_SERVER_KEY');
		 
		 $notification = array('title' =>$title , 'text' => $body, 'sound' => 'default', 'badge' =>'0');

		 $arrayToSend = array('registration_ids' => $registrationIds, 'notification'=>$notification,'priority'=>'high');
		 $json = json_encode($arrayToSend,true);
		 
		 $headers[] = 'Content-Type: application/json';
		 $headers[] = 'Authorization: key='. $serverKey;

		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		 curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		 //Send the request
		 $result = curl_exec($ch);
		 if ($result === FALSE) 
		 {
			die('FCM Send Error: ' . curl_error($ch));
		 }

		 curl_close( $ch );
		     /* print_r($result);
			die; */    
		 return $result;
		 ob_flush();
	}
	/* end of function */
	