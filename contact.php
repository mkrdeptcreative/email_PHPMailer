<?php 

session_start();

require_once 'phpmailer/PHPMailerAutoload.php';

$errors = [];


if(isset($_POST['name'], $_POST['email'], $_POST['comment'])) {
	$fields = [
		'name' => $_POST['name'],
		'email' => $_POST['email'],
		'comment' => $_POST['comment']		
	];

	foreach($fields as $field => $data) {
		if(empty($data)) {
			$errors[] = 'The '. field . ' field is required.';
		}
	}

	if(empty($errors)) {
		$m = new PHPMailer;

		$m->isSMTP();
		$m->SMTPAuth=true;
		//use your SMTP details here

		$m->SMTPDebug = 1;
		$m ->Host = //host address;
		$m->Username = //email address;
		$m->Password = //db password;
		$m->SMTPSecure = 'ssl';
		$m ->IsHTML(true);
		$m->Port = 465;

		$m->Subject = 'Contact form submitted';
		$m->Body = 'From: ' . $fields['name'] . ' (' . $fields['email']. ')<p>'. $fields['comment'].'</p>';

		$m->FromName = 'Contact';

		$m->AddAddress(//email address, name );

		if($m->send()) {
			header('Location: thanks.php');
			die();
		} else {
			$errors[] = 'Sorry, could not send email. Try again later.';
		}
		
	}

} else {
	$errors[] ='Something went wrong.';
}



header('Location: index.php');
