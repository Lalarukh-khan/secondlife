integer listenChannel = 42; // Change to your desired channel
key selectedPlayer;

default
{
    state_entry()
    {
        llListen(listenChannel, "", NULL_KEY, "");
    }

    touch_start(integer num_detected)
    {
        if (num_detected > 0)
        {
            key touchedAvatar = llDetectedKey(0);
            
            if (llVecDist(llGetPos(), llGetPosAgent(touchedAvatar)) <= 20.0)
            {
                selectedPlayer = touchedAvatar;
                llInstantMessage(selectedPlayer, "Press the attack button to proceed.");
            }
        }
    }

    listen(integer channel, string name, key id, string message)
    {
        if (channel == listenChannel && id == selectedPlayer && message == "attack")
        {
            key myKey = llGetOwner();
            string postData = "attacker=" + (string)myKey + "&defender=" + (string)selectedPlayer;
            llHTTPRequest("https://cityofrumor.com/testing.php/attack.php", [HTTP_METHOD, "POST", HTTP_BODY, postData]);

            llInstantMessage(myKey, "Your healing will be paused for the next 2 hours.");
            llInstantMessage(selectedPlayer, "Your healing will be paused for the next 2 hours.");
        }
    }
}









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
