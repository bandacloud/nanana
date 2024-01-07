<?php
$curl = curl_init();
 
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://clicksmsgateway.com',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
"from":"DREAMERS", 
"to":"265885809819",
"message":"Alert, Active Seizures in patient", 
"refId":"testst28y7y375"
}',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/json',
    'Authorization: Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiIyNzgiLCJvaWQiOjI3OCwidWlkIjoiMjM0YzdkMzItYjExOC00MTljLWI0ZjEtZDQ2OGIxNmQ1NGY5IiwiYXBpZCI6MTMsImlhdCI6MTYyNDI3OTM2MywiZXhwIjoxOTY0Mjc5MzYzfQ.7kNZTVFmonl1uhsSHt8CInNHwdxgxtWNoH_uNeweFdDpf6aCIG57avFtpjBi-rP8MvTIlek__AJxgufmEZs0Dw'
  ),
));
 
$response = curl_exec($curl);
 
curl_close($curl);
echo $response;
?>