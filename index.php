<?php
SESSION_START();

REQUIRE 'autoload.php';
USE Abraham\TwitterOAuth\TwitterOAuth;
DEFINE('CONSUMER_KEY', '{Twitter-Consumer-Key}');
DEFINE('CONSUMER_SECRET', '{Twitter-Consumer-Secret}');
DEFINE('OAUTH_CALLBACK', '{Website-Callback-URL}'); //http://localhost/twitter/callback.php

IF (!ISSET($_SESSION['access_token'])) {
	
	$connection = NEW TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
	
	$output = "<a href='$url'><img src='twitter-login-blue.png' style='margin-left:4%; margin-top: 4%'></a>";
	
} ELSE {
	
	$access_token = $_SESSION['access_token'];
	$connection = NEW TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	
	$user = $connection->get("account/verify_credentials", ['include_email' => 'true']);
	
	$output = "<img src='$user->profile_image_url'><br>";
    $output .= @$user->id."<br>";
	$output .= @$user->name."<br>";
    $output .= @$user->location."<br>";
    $output .= @$user->screen_name."<br>";
    $output .= @$user->created_at."<br>";
	$output .= @$user->description."<br>";
	$output .= @$user->email."<br>";
	
	$output .= "<hr><a href='logout.php'>LOGOUT USER</a>";
}

PRINT $output;
?>