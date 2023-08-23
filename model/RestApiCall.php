<?php

    function RestApiCall($url, $httpMethod, $param) {
        $ch = curl_init();

        // Set the URL and other options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Skip SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Skip SSL certificate verification

        // Set the request method and data
        curl_setopt($ch, $httpMethod, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));

        // Send the request and get the response
        $response = curl_exec($ch);
        $responseData = json_decode($response, true);

        // Check for errors
        if($response === false) {
            echo "<script>alert('서버와 연결이 불안정합니다.');location.href='../view_control/signout';</script>";
        }

        // Close the curl handle
        curl_close($ch);

        if ($responseData['result'] == 'fail') {
            echo "<script>alert('".$responseData['message']."');history.back();</script>";
        } elseif ($responseData['result'] == 'success') {
            return $responseData;
        } else {
            echo "<script>alert('서버와 연결이 불안정합니다.');location.href='../view_control/signout';</script>";
        }
    }

?>