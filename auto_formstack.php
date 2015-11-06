<?php

$option = getopt("o:x:");
$oauth = $option['o'];
$passfail = 0;

for ($i = 0 ; $i < $option['x'] ; $i++)
{
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://www.formstack.com/api/v2/form.json?oauth_token=$oauth");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $get_all_result = curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $get_all_result = json_decode($get_all_result, TRUE);
        $form_id = $get_all_result['forms'][0]['id'];

        if ($response == 200)
        {
                $passfail++;
        }

        curl_setopt($ch, CURLOPT_URL, "https://www.formstack.com/api/v2/form/$form_id.json?oauth_token=$oauth");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $get_one_result = curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $get_one_result = json_decode($get_one_result, TRUE);

        if ($response == 200)
        {
                $passfail++;
        }

        curl_setopt($ch, CURLOPT_URL, "https://www.formstack.com/api/v2/form/$form_id/copy.json?oauth_token=$oauth");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        $copy_result = curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $copy_result = json_decode($copy_result, TRUE);
        $copy_id = $copy_result['id'];

        if ($response == 200)
        {
                $passfail++;
        }

        curl_setopt($ch, CURLOPT_URL, "https://www.formstack.com/api/v2/form/$copy_id.json?oauth_token=$oauth");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $delete_result = curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $delete_result = json_decode($delete_result, TRUE);

        if ($response == 200)
        {
                $passfail++;
        }
}

curl_close($ch);

$passrate = $passfail / ($option['x'] * 4);

echo "Test complete. Ran test " . $option['x'] . " times. Pass percentage rate was: $passrate\n";

?>
