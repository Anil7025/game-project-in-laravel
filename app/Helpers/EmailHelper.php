<?php


 function sendCustomEmail($email,$para_info_first,$para_info_second,$subject,$message,$headers,$success_message)
	{
		$otp =  mt_rand(100000, 999999);
		$appended_html_message = '<style>
						  .main-container{
							  width:100%;
							  background-color:#eee;
							  padding:30px 0;
						  }
						  .email-box{
							  width:600px;
							  margin:0px auto;
							  background-color:#fff;
							  border-radius:5px;
							  padding:3px 0px;
						  }  
						  .logo-icon{
							  display:block;
							  width:50px;
							  margin:20px auto;
						  }
						  .email-content{
							  border-top:3px solid #051761;
							  padding:30px 40px;
						  }
						  .reset{
							  color:#051761;
							  text-align:center;
							  font-weight:600;
							  letter-spacing:1px;
							  font-size:18px;
						  }
						  </style>
						  <div class="main-container">
							<div class="email-box">
								<p><img src="http://api.nextlevelfootballtraining.co.uk/storage/logo58_58.png" class="logo-icon"></p>
								
								<div class="col-12 email-content">
									<p>You\'re receiving this email because you requested a E-mail verify for TheNextLevel account.</p><p>OTP for Verify Your E-mail :</p>
									<p class="reset">'.$otp.'</p>
									
									<p>If you didn\'t make this request,please ignore this email.</p>
								</div>
							</div>
						</div>';
				$subject = "Verify Your E-mail";
				//$message = "Enter Your OTP to reset your password Your otp is : $otp\r\n";
				$headers = "From: info@nextlevelfootballtraining.co.uk\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
				if ( mail($user->email, $subject, $message, $headers))
				{
					return response()->json(['user'=>$user,'success' => 'Verification OTP Successfully Sent','status'=>'200'], 200);
				} 
				else
				{
					return response()->json(['error' => 'OTP Not Sent','status'=>'400'], 400);
				}	
	}
	