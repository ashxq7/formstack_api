<?php

session_start();

$ch = curl_init();
$form_id = $_POST['form_id'];
$oauth = $_POST['oauth_token'];

if (isset($_POST['get_all']))
{
        $url = "https://www.formstack.com/api/v2/form.json";
        $query = "?oauth_token=$oauth";
        curl_setopt($ch, CURLOPT_URL, $url.$query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if (isset($_POST['get_one']))
{
        $url = "https://www.formstack.com/api/v2/form/$form_id.json";
        $query = "?oauth_token=$oauth";
        curl_setopt($ch, CURLOPT_URL, $url.$query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if (isset($_POST['copy']))
{
        $url = "https://www.formstack.com/api/v2/form/$form_id/copy.json";
        $query = "?oauth_token=$oauth";
        curl_setopt($ch, CURLOPT_URL, $url.$query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        $result = curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if (isset($_POST['delete']))
{
        $url = "https://www.formstack.com/api/v2/form/$form_id.json";
        $query = "?oauth_token=$oauth";
        curl_setopt($ch, CURLOPT_URL, $url.$query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $result = curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

curl_close($ch);

?>

<html>
<head>
<title>Formstack API Test</title>
</head>

<body>
        <h2> Formstack API Test </h2>
        <div id="content">
                <form method=post>
                        <fieldset style="border:0; padding:0;">
                        <br>
                                Enter oauth token: <input type="text" id="oauth_token" name="oauth_token" value="OAUTH Token"/>
                        </fieldset>
                        <hr>
                        <br>
                        <fieldset style="border:0; padding:0;">
                                <input type="submit" id='get_all' name='get_all' value="Get All Forms" class='myButton' />
                        </fieldset>
                        <br>
                        <p> OR </p>
                        <br>
                        <fieldset style="border:0; padding:0;">
                                Enter form id: <input type="text" id="form_id" name="form_id" value="Form ID"/>
                                <br>
                                <input type="submit" id='get_one' name='get_one' value="Get Form" class='myButton' />
                                <input type="submit" id='copy' name='copy' value="Copy Form" class='myButton' />
                                <input type="submit" id='delete' name='delete' value="Delete Form" class='myButton' />
                        </fieldset>
                </form>

                <?php
                        if (isset($response))
                        {
                                if ($response == 200)
                                {
                                        print "Request worked!<br>";
                                        print "URL was: $url<br>";
                                        print "Query string was: $query<br>";
                                        print "Reponse code was: $response<br>";
                                        print "JSON was: $result<br>";
                                }
                                else
                                {
                                        print "Something went wrong.<br>";
                                        print "URL was: $url<br>";
                                        print "Query string was: $query<br>";
                                        print "Reponse code was: $response<br>";
                                }
                        }
                ?>
        </div>
</body>
</html>
