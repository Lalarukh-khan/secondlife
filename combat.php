<?php
class Avatar {
    private $health;
    private $isAlive;

    public function __construct() {
        $this->health = 100;
        $this->isAlive = true;
    }

    public function attack(Avatar $target) {
        if ($this->isAlive) {
            $damage = rand(10, 20); // Simulate random damage
            $target->takeDamage($damage);
            echo "Attacked! Damage dealt: $damage\n";
        } else {
            echo "Attacker is dead and cannot attack.\n";
        }
    }

    public function takeDamage($damage) {
        if ($this->isAlive) {
            $this->health -= $damage;
            if ($this->health <= 0) {
                $this->isAlive = false;
                echo "Avatar is dead!\n";
            } else {
                echo "Avatar took $damage damage. Remaining health: {$this->health}\n";
            }
        } else {
            echo "Dead avatars cannot take damage.\n";
        }
    }

    public function isAlive() {
        return $this->isAlive;
    }
}

$avatar1 = new Avatar();
$avatar2 = new Avatar();

while ($avatar1->isAlive() && $avatar2->isAlive()) {
    $avatar1->attack($avatar2);
    if ($avatar2->isAlive()) {
        $avatar2->attack($avatar1);
    }
}

echo "Battle ended.\n";
?>
