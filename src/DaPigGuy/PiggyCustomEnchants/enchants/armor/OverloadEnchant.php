<?php

declare(strict_types=1);

namespace DaPigGuy\PiggyCustomEnchants\enchants\armor;

use DaPigGuy\PiggyCustomEnchants\enchants\CustomEnchant;
use DaPigGuy\PiggyCustomEnchants\enchants\ToggleableEnchantment;
use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;

/**
 * Class OverloadEnchant
 * @package DaPigGuy\PiggyCustomEnchants\enchants\armor
 */
class OverloadEnchant extends ToggleableEnchantment
{
    /** @var string */
    public $name = "Overload";
    /** @var int */
    public $maxLevel = 3;

    /**
     * @param Player $player
     * @param Item $item
     * @param Inventory $inventory
     * @param int $slot
     * @param int $level
     * @param bool $toggle
     */
    public function toggle(Player $player, Item $item, Inventory $inventory, int $slot, int $level, bool $toggle)
    {
        $player->setMaxHealth($player->getMaxHealth() + 2 * $level * ($toggle ? 1 : -1));
        $this->plugin->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($player, $level, $toggle): void {
            $player->setHealth($player->getHealth() + 2 * $level * ($toggle ? 1 : -1));
        }), 1);
        if ($player->getHealth() > $player->getMaxHealth()) $player->setHealth($player->getMaxHealth());
    }

    /**
     * @return int
     */
    public function getUsageType(): int
    {
        return CustomEnchant::TYPE_ARMOR_INVENTORY;
    }

    /**
     * @return int
     */
    public function getItemType(): int
    {
        return CustomEnchant::ITEM_TYPE_ARMOR;
    }
}