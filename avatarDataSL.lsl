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
        
        llOwnerSay("Avatar name: " + avatar_name);
        
        string post_data = "avatar=" + llEscapeURL(avatar_name);
        
        string url = "https://cityofrumor.com/testing.php?avatar=" + llEscapeURL(avatar_name);
        llHTTPRequest(url, [HTTP_METHOD, "POST", HTTP_MIMETYPE, "application/x-www-form-urlencoded"], "");
    }
    
    http_response(key request_id, integer status, list metadata, string body)
    {
        llOwnerSay("HTTP Status: " + (string)status);
        llOwnerSay("HTTP Response: " + body);
    }
}


Debug: Avatar name: Ember Ronas Resident
Debug: HTTP Response Status: 200
Debug: HTTP Response Body: Avatar data stored in the database successfully.
