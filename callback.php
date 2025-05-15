<?php
// callback.php

// Twitter API credentials
$consumerKey = 'PvcN6haxhYsRK9XwQaDKZKLC9';
$consumerSecret = 'J3mYQIZVtX7AoQx3iMpkcbc1s8FA6Tiutg6ZcWvZ2NQwZG8E8n';

// Access token URL
$accessTokenUrl = 'https://api.twitter.com/oauth/access_token';

// Get oauth_token and oauth_verifier from the query string
$oauthToken = $_GET['oauth_token'];  // OAuth token from Twitter
$oauthVerifier = $_GET['oauth_verifier'];  // OAuth verifier from Twitter

// Generate the nonce and timestamp for the request
$nonce = md5(microtime() . mt_rand());
$timestamp = time();

// Prepare OAuth parameters for access token request
$oauthParams = [
    'oauth_consumer_key' => $consumerKey,
    'oauth_nonce' => $nonce,
    'oauth_signature_method' => 'HMAC-SHA1',
    'oauth_timestamp' => $timestamp,
    'oauth_token' => $oauthToken,
    'oauth_verifier' => $oauthVerifier,
    'oauth_version' => '1.0',
];

// Generate the signature base string
$baseString = 'POST&' . urlencode($accessTokenUrl) . '&' . urlencode(http_build_query($oauthParams));

// Generate the signing key
$signingKey = urlencode($consumerSecret) . '&' . urlencode($oauthTokenSecret);

// Generate the OAuth signature
$oauthParams['oauth_signature'] = base64_encode(hash_hmac('sha1', $baseString, $signingKey, true));

// Make the request to Twitter
$oauthHeader = 'OAuth ' . http_build_query($oauthParams, '', ', ');

// cURL request to get access token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $accessTokenUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: $oauthHeader"]);
$response = curl_exec($ch);

// Handle the response
parse_str($response, $responseParams);

// Check if the access token is received
if (isset($responseParams['oauth_token'])) {
    // Store the access token and secret for API requests
    $accessToken = $responseParams['oauth_token'];
    $accessTokenSecret = $responseParams['oauth_token_secret'];

    // Now you can make API calls on behalf of the user
    echo 'Access Token: ' . $accessToken;
    echo 'Access Token Secret: ' . $accessTokenSecret;
} else {
    echo 'Error in access token';
}
?>
