integer buttonChannel = 123;
integer healingPauseTime = 7200; // 2 hours in seconds

default
{
    touch_start(integer total_number)
    {
        llListenRemove(buttonChannel);
        llSay(0, "Press the button to attack.");
        llListen(buttonChannel, "", NULL_KEY, "");
    }
    
    listen(integer channel, string name, key id, string message)
    {
        if (message == "attack")
        {
            list nearbyAvatars = llGetNearbyAvatars(20.0);
            key attacker = llDetectedKey(0); // Assuming the touch is from the attacker
            
            string attackerName = llKey2Name(attacker);
            string data = "attacker=" + llEscapeURL(attackerName) + "&avatars=" + llList2CSV(nearbyAvatars);
            string url = "https://your-website.com/store_attack.php";
            
            llHTTPRequest(url, [HTTP_METHOD, "POST", HTTP_MIMETYPE, "application/x-www-form-urlencoded"], data);
            
            llSetTimerEvent(healingPauseTime);
            llSay(0, "Healing is paused for 2 hours.");
        }
    }
    
    timer()
    {
        llSetTimerEvent(0);
        llSay(0, "Healing is now resumed.");
    }
}
