<?php
class Character {
    private $health;
    private $stealth;
    
    public function __construct() {
        $this->health = 100;
        $this->stealth = 0;
    }

    public function getHealth() {
        return $this->health;
    }

    public function getStealth() {
        return $this->stealth;
    }

    public function heal($amount) {
        $this->health += $amount;
        if ($this->health > 100) {
            $this->health = 100;
        }
    }

    public function increaseStealth($amount) {
        $this->stealth += $amount;
    }

    public function detect($target) {
        // Calculate detection probability based on stealth level
        $detectionProbability = $target->getStealth() - $this->getStealth();

        // Generate a random number to determine detection success
        $randomNumber = rand(1, 100);

        return $randomNumber <= $detectionProbability;
    } 

    public function evade() {
        // Calculate evasion probability based on stealth level
        $evasionProbability = $this->getStealth();

        // Generate a random number to determine evasion success
        $randomNumber = rand(1, 100);

        return $randomNumber <= $evasionProbability;
    }

    public function attack($target) {
        // Calculate attack power based on health and other attributes
        $attackPower = /* calculate attack power */;

        // Calculate defense power of the target based on their attributes
        $defensePower = /* calculate defense power of target */;

        // Calculate actual damage inflicted
        $damage = max(0, $attackPower - $defensePower);

        // Inflict damage on the target
        $target->receiveDamage($damage);
    }

    public function receiveDamage($damage) {
        $this->health -= $damage;
        if ($this->health < 0) {
            $this->health = 0;
        }
    }
}

// Example usage
$player = new Character();
$enemy = new Character();

$player->heal(20);
$player->increaseStealth(10);

if ($player->detect($enemy)) {
    if (!$enemy->evade()) {
        $player->attack($enemy);
    }
} else {
    $player->evade();
}

?>