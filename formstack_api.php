<?php

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://www.formstack.com/api/v2/form.json?oauth_token=797de37033311cd284efdd9ac7ff8aca");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$get_all_result = curl_exec($ch);

$get_all_result = json_decode($get_all_result, TRUE);
$form_id = $get_all_result['forms'][0]['id'];

curl_setopt($ch, CURLOPT_URL, "https://www.formstack.com/api/v2/form/$form_id.json?oauth_token=797de37033311cd284efdd9ac7ff8aca");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$get_one_result = curl_exec($ch);

$get_one_result = json_decode($get_one_result, TRUE);

curl_setopt($ch, CURLOPT_URL, "https://www.formstack.com/api/v2/form/$form_id/copy.json?oauth_token=797de37033311cd284efdd9ac7ff8aca");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_POST, TRUE);
$copy_result = curl_exec($ch);

$copy_result = json_decode($copy_result, TRUE);
$copy_id = $copy_result['id'];

curl_setopt($ch, CURLOPT_URL, "https://www.formstack.com/api/v2/form/$copy_id.json?oauth_token=797de37033311cd284efdd9ac7ff8aca");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
$delete_result = curl_exec($ch);

$delete_result = json_decode($delete_result, TRUE);

var_dump($get_all_result);
var_dump($get_one_result);
var_dump($copy_result);
var_dump($delete_result);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Formstack API Test</title>
</head>

<body>
        <div id="content">
                <form method=post>
                        <fieldset style="border:0; padding:0;">
                                <input type="text" id="epic" name="epic" value="Get All Forms" onfocus="if(this.value=='Enter Epic Ticket')this.value='';"  onblur="if(this.value=='')this.value='Enter Epic Ticket';" />
                                <input type="submit" id='submit' name='submit' value="Get All Forms" class='myButton' />
                        </fieldset>
                </form>

                <div>
                <? if (!empty($_SESSION['created_epic_cabs']))
                {
                        foreach($_SESSION['created_epic_cabs'] as $cab_number)
                        {
                ?>      <a href="http://<?=$jira_calls->get_host();?>/browse/<? echo $cab_number ?>" ><?=$cab_number?></a>
                <?
                        }
                }
                ?></div>
         </div><!--END content -->
</body>
</html>

