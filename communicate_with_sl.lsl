string dataToSend = "hello from Second Life To PHP world";
string phpScriptURL = "https://cityofrumor.com/testing.php";

default
{
    state_entry()
    {
        llHTTPRequest(phpScriptURL, [HTTP_METHOD, "POST", HTTP_MIMETYPE, "application/x-www-form-urlencoded"], dataToSend);
    }

    http_response(key request_id, integer status, list metadata, string body)
    {
        llOwnerSay("Received response: " + body);
    }
}
