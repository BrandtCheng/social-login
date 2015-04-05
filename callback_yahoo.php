<?php
/*
 * document: https://developer.yahoo.com/oauth2/guide/
 */
//define('_YAHOO_KEY','xxxxx');
//define('_YAHOO_SECRET','xxxxxxxxx'); 
function signin_yahoo(){
	$yahoo_req='https://api.login.yahoo.com/oauth2/request_auth'; 
	$yahoo_token='https://api.login.yahoo.com/oauth2/get_token';
	$callback_url=($_SERVER['HTTPS']?'https:/':'http:/').'/'._SERVER['HTTP_HOST'].'/callbak_yahoo/'; 
	$code=isset($_GET['code'])?$_GET['code']:'';
	if($code){
		$param=array(
			'grant_type'=>'authorization_code',
			// 'client_id'=>_YAHOO_KEY,
			// 'client_secret'=>_YAHOO_SECRET,
			'redirect_uri'=>$callback_url,
			'code'=>$code,
		);
		$headers=array(
			'Authorization: Basic '.base64_encode(_YAHOO_KEY.':'._YAHOO_SECRET),
			'Content-Type: application/x-www-form-urlencoded'
		);
		$ch=curl_init();
		curl_setopt ($ch, CURLOPT_POST, TRUE);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($param));
		curl_setopt ($ch, CURLOPT_HEADER, FALSE);
		curl_setopt ($ch, CURLOPT_NOBODY, FALSE);
		curl_setopt ($ch, CURLOPT_URL, $yahoo_token);
		curl_setopt ($ch, CURLOPT_REFERER, $callback_url);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE); 
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}
	else{
		$url=$yahoo_req.'?'.http_build_query(
			'client_id'=>_YAHOO_KEY,
			'redirect_uri'=>$callbak_url,
			'response_type'=>'code'
		);
		header('refresh:0; url='.$url);
		die('');
	}
}
