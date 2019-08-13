<?php

include_once 'mailer/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mail {

	public $developmentMode = true;
	public $phpMailer;

	function __construct()
	{
		$this->phpMailer = new PHPMailer($this->developmentMode);
		$this->phpMailer->SMTPDebug = 0;
		$this->phpMailer->isSMTP();
	
		if($this->developmentMode) {
			$this->phpMailer->SMTPOptions = [
				'ssl' => [
					'venrify_peer' => false,
					'venrify_peer_name' => false,
					'allow_self_signed' => true
				]
			];
		}
		$this->phpMailer->Host = 'smtp.gmail.com';
		$this->phpMailer->SMTPAuth = true;
		$this->phpMailer->Username = 'eversoft.nepal@gmail.com';
		$this->phpMailer->Password = '2016@Eversoftgroup.com';
		$this->phpMailer->SMTPSecure = 'tls';
		$this->phpMailer->Port = 587;
	}

	public function sendForgetEmail($user, $token)
	{
		$content = array('message'=>'Your email is used to recover password','purpose' => 'change your password',
					'link'=>'user/recover', 'btn' => 'Recover Password');
		try{
			$this->phpMailer->setFrom('eversoft.nepal@gmail.com','Eversoft nepal');
			$this->phpMailer->addReplyTo('eversoft.nepal@gmail.com','Eversoft nepal');
			$this->phpMailer->addAddress($user);
			$this->phpMailer->isHTML(true);
			$this->phpMailer->Subject = "Forget Password";
			$this->phpMailer->Body = $this->templateRender($token, $content);
			$this->phpMailer->send();
			$this->phpMailer->ClearAllRecipients();
				return true;
			}catch(Exception $e){
				return false;
		}
	}

	public function sendRegisterEmail($user, $token)
	{
		$content = array('message'=>'Your email is used for registration','purpose' => 'confirm your Email',
					'link'=>'user/confirm', 'btn' => 'Confirm Email');
		try{
			$this->phpMailer->setFrom('eversoft.nepal@gmail.com','Eversoft nepal');
			$this->phpMailer->addReplyTo('eversoft.nepal@gmail.com','Eversoft nepal');
			$this->phpMailer->addAddress($user);
			$this->phpMailer->isHTML(true);
			$this->phpMailer->Subject = "Register User";
			$this->phpMailer->Body = $this->templateRender($token, $content);
			$this->phpMailer->send();
			$this->phpMailer->ClearAllRecipients();
				return true;
			}catch(Exception $e){
				return false;
		}
	}
	public function templateRender($token, $content) {
		return '<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta http-equiv="X-UA-Compatible" content="ie=edge">
			<title>Registration Confirmation</title>
			<style>
				body {
					margin:0;
					padding:0;
					background-color:#337ab7;
					background-size:cover;
					background-position:center;
				}
				.confirm{
					padding-top: 20px;
					width:500px;
					height:400px;
					background-color: #000;
					color:#fff;
					top:50%;
					left:50%;
					position: absolute;
					transform: translate(-50%, -50%);
					box-sizing: border-box;
				}
				h1,p{
					color:#fff;
					text-align:center;
					font-family:Helvetica;
				}
				p{
					font-size:16px;
				}
				button{
					background-color: #337ab7;
					border: none;
					height:50px;
					width:200px;
					color:#fff;
					font-size: 18px;
					margin-left:150px;
					margin-top: 20px;
				}
			</style>
		</head>
		<body>
			<div class="confirm">
				<h1>Eversoft Nepal</h1>
				<p>'.$content['message'].'. Please click the link below to'. $content['purpose'].'</p>
				<a href="http://localhost/eversoft/public/'. $content['link'].'/token='.$token.'"><button type="submit">
				'. $content['btn'] .'</button></a>     
			</div>
		</body>
		</html>';
	}
}

