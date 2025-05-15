<?php
// index.php

// Twitter API credentials
$consumerKey = 'PvcN6haxhYsRK9XwQaDKZKLC9';
$consumerSecret = 'J3mYQIZVtX7AoQx3iMpkcbc1s8FA6Tiutg6ZcWvZ2NQwZG8E8n';
$callbackUrl = 'localhost/solsynth/callback.php'; // URL for handling the callback

// Request token URL
$requestTokenUrl = 'https://api.twitter.com/oauth/request_token';

// Generate the nonce and timestamp for the request
$nonce = md5(microtime() . mt_rand());
$timestamp = time();

// Prepare OAuth parameters
$oauthParams = [
    'oauth_consumer_key' => $consumerKey,
    'oauth_nonce' => $nonce,
    'oauth_signature_method' => 'HMAC-SHA1',
    'oauth_timestamp' => $timestamp,
    'oauth_callback' => urlencode($callbackUrl),
    'oauth_version' => '1.0',
];

// Generate the signature base string
$baseString = 'POST&' . urlencode($requestTokenUrl) . '&' . urlencode(http_build_query($oauthParams));

// Generate the signing key
$signingKey = urlencode($consumerSecret) . '&';

// Generate the OAuth signature
$oauthParams['oauth_signature'] = base64_encode(hash_hmac('sha1', $baseString, $signingKey, true));

// Make the request to Twitter
$oauthHeader = 'OAuth ' . http_build_query($oauthParams, '', ', ');

// cURL request to get request token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $requestTokenUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: $oauthHeader"]);
$response = curl_exec($ch);

// Handle the response
parse_str($response, $responseParams);

// Check if the request was successful
if (isset($responseParams['oauth_token'])) {
    $oauthToken = $responseParams['oauth_token'];
    $oauthTokenSecret = $responseParams['oauth_token_secret'];

    // Redirect the user to Twitter for authorization
    $authorizeUrl = 'https://api.twitter.com/oauth/authorize?oauth_token=' . $oauthToken;
    header("Location: $authorizeUrl");
    exit;
} else {
    echo 'Error in request token';
}
?>
