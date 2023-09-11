integer listener;

default
{
    state_entry()
    {
        listener = llListen(0, "", NULL_KEY, "");
    }
    
    touch_start(integer num_detected)
    {
        key touched_avatar = llDetectedKey(0);
        string avatar_name = llKey2Name(touched_avatar);
        
        llOwnerSay("Player name: " + avatar_name);
        
        string url = "https://cityofrumor.com/testing.php?player=" + llEscapeURL(avatar_name);
        llHTTPRequest(url, [HTTP_METHOD, "POST", HTTP_MIMETYPE, "application/x-www-form-urlencoded"], "");
    }
    
    http_response(key request_id, integer status, list metadata, string body)
    {
        llOwnerSay("HTTP Status: " + (string)status);
        llOwnerSay("HTTP Response: " + body);
    }
}