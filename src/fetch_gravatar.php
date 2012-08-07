<?php
/**
 * This code will fetch the user details from the gravatar site.
 */

ini_set('allow_url_fopen', '1');

// Check to see that we have the mail we wish to check.
if (isset($_GET['email'])) {

    // Generate the email hash code

    $url = 'http://www.gravatar.com/' . md5(strtolower(trim($_GET['email']))) . '.php';

    // Get the Gravatar content
    $str = file_get_contents($url);

    $profile = unserialize($str);

    // Get the gravatar details
    echo(json_encode($profile));
}

/**
 * The JSON reply is in the following format:

{"entry": [{
...."id": "20521698",
...."hash": "6e4e31cf740dc41f88c3dc50b8a98dca",
...."requestHash": "6e4e31cf740dc41f88c3dc50b8a98dca",
...."profileUrl": "http:\/\/gravatar.com\/nirgeier",
...."preferredUsername": "nirgeier",
...."thumbnailUrl": "http:\/\/0.gravatar.com\/avatar\/6e4e31cf740dc41f88c3dc50b8a98dca",
...."photos": [{
........"value": "http:\/\/0.gravatar.com\/avatar\/6e4e31cf740dc41f88c3dc50b8a98dca",
........"type": "thumbnail"
....}],
...."name": [],
...."displayName": "nirgeier",
...."accounts": [{
........"domain": "linkedin.com",
........"display": "linkedin.com",
........"url": "http:\/\/www.linkedin.com\/pub\/nir-geier\/24\/b6b\/22",
........"username": "linkedin.com",
........"verified": "true",
........"shortname": "linkedin"
....}],
...."urls": []
}]}
*/ 
