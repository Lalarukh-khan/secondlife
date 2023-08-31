integer i;
float GetAvatarHealth(key avatarID)
    {
        string data = llGetObjectDesc();
        list lines = llParseString2List(data, ["\n"], []);
        
        key storedAvatarID = llList2Key(lines, 0);
        float health = llList2Float(lines, 1);
        
        if (storedAvatarID == avatarID)
        {
            return health;
        }
        return 0.0;
    }
    
default
{
    touch_start(integer total_number)
    {
        list avatarsInRegion = llGetAgentList(AGENT_LIST_REGION, []);
        integer numOfAvatars = llGetListLength(avatarsInRegion);

        if (!numOfAvatars)
        {
            llOwnerSay("No player found within the region!");
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
            float avatarHealth = GetAvatarHealth(id); 
            if (avatarHealth <= 0.0)
            {
        llInstantMessage(id,"Your healing will be paused for the next 2 hours.");
                llInstantMessage(id, "Your health is at 0. You cannot attack.");
            }
             else{ 
                llInstantMessage(id,"Your healing will be paused for the next 2 hours.");
                integer attackValue =  llRound(llFrand(19)) + 1;
        
        llInstantMessage(attackerID, "You have been selected as the attacker. Your attack value is " + (string)attackValue + ". Your health regeneration will be paused for the next 2 hours. Do you want to attack?");
        
        integer numDefenders2 = llGetListLength(defenderIDs);
        for (i = 0; i < numDefenders2; ++i)
        {
            key defenderID = llList2Key(defenderIDs, i);
            llInstantMessage(defenderID, "You have been selected as a defender against the attack. Your health regeneration will be paused for the next 2 hours.");
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
    }
}
