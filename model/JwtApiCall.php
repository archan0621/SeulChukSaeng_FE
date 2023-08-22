<?php

function JwtApiCall($url, $httpMethod, $param, $access_token) {
    $ch = curl_init();

    // Set the URL and other options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Skip SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Skip SSL certificate verification

    // Set the request method and data
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $httpMethod); // Set the HTTP method
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));

    // Send the request and get the response
    $response = curl_exec($ch);
    $responseData = json_decode($response, true);

    // Check for errors
    if($response === false) {
        throw new Exception(curl_error($ch));
    }

    // Close the curl handle
    curl_close($ch);

    if ($responseData['result'] == 'fail') {
        echo "<script>alert('".$responseData['message']."');location.href='../view_control/signout'</script>";
    } elseif ($responseData['result'] == 'success') {
        return $responseData;
    } else {
        echo "<script>alert('서버와 연결이 불안정합니다.');location.href='../view_control/signout'</script>";
    }

}

?>
