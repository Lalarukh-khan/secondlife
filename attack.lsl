integer i;
default
{
    touch_start(integer total_number)
    {
        list avatarsInRegion = llGetAgentList(AGENT_LIST_REGION, []);
        integer numOfAvatars = llGetListLength(avatarsInRegion);

        if (!numOfAvatars)
        {
            llOwnerSay("No avatars found within the region!");
            return;
        }

        vector myPosition = llGetPos();
        float searchRadius = 20.0;

        key attackerID = NULL_KEY;
        list defenderIDs = [];

        integer index;
        while (index < numOfAvatars)
        {
            key id = llList2Key(avatarsInRegion, index);
            vector avatarPos = llList2Vector(llGetObjectDetails(id, [OBJECT_POS]), 0);
            float distance = llVecDist(myPosition, avatarPos);

            if (distance <= searchRadius)
            {
                if (attackerID == NULL_KEY)
                {
                    attackerID = id;
                }
                else
                {
                    defenderIDs += id;
                }
            }

            ++index;
        }
        string attackerName = llKey2Name(attackerID);
        string defenderNames = "";
        integer numDefenders = llGetListLength(defenderIDs);
        for (i = 0; i < numDefenders; ++i)
        {
            key defenderID = llList2Key(defenderIDs, i);
            string defenderName = llKey2Name(defenderID);
            defenderNames += defenderName;
            if (i < numDefenders - 1)
            {
                defenderNames += ",";
            }
        }
        string url = "https://cityofrumor.com/attack.php?attacker=" + attackerName + "&defender=" + defenderNames;
        llHTTPRequest(url, [HTTP_METHOD, "POST", HTTP_MIMETYPE, "application/x-www-form-urlencoded"], "");
        llOwnerSay("Your healing will be paused for the next 2 hours.");
    }
}
