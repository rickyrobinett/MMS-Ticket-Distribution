<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

use Endroid\QrCode\QrCode;

Route::match(array('GET', 'POST'), '/', function()
{
  if(Input::has('submit')) {
    $validator = Validator::make(
      array(
        'name' => Input::get('name'),
        'phone_number' => Input::get('phone_num')
      ),
      array(
        'name' => 'required',
        'phone_number' => 'required'
      ) 
    );
    if($validator->fails()) {
      $messages = $validator->messages();
      Session::flash('alert', implode($messages->all('<li>:message</li>')));
    } else {
      $AccountSid = $_SERVER['TWILIO_ACCOUNT_SID'];
      $AuthToken = $_SERVER['TWILIO_AUTH_TOKEN'];
      
      $client = new Services_Twilio($AccountSid, $AuthToken);
      $sms = $client->account->messages->sendMessage(
            $_SERVER['TWILIO_PHONE_NUMBER'],
            Input::get('phone_num'),
            "Congrats! Here's your golden ticket.",
            "http://". $_SERVER['HTTP_HOST'] . "/qrcode?name=" .urlencode(Input::get('name')) . "&phone_num=" . Input::get('phone_num')
        );
      Session::flash('alert', 'Golden Ticket Sent!');
    }
  }
	return View::make('home');
});

Route::get('/qrcode', function()
{

  $name = Input::get('name');
  $number = Input::get('phone_num');

  $code = base64_encode($name . $number);

  $qrCode = new QrCode();
  $qrCode->setText($code);
  $image = $qrCode->get();

  $response = Response::make(
    $image,
    200
  );

  $response->header(
      'content-type',
      'image/png'
  );

  return $response;
});
