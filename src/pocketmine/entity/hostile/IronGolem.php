<?php

/*
 *               _ _
 *         /\   | | |
 *        /  \  | | |_ __ _ _   _
 *       / /\ \ | | __/ _` | | | |
 *      / ____ \| | || (_| | |_| |
 *     /_/    \_|_|\__\__,_|\__, |
 *                           __/ |
 *                          |___/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author TuranicTeam
 * @link https://github.com/TuranicTeam/Altay
 *
 */

declare(strict_types=1);

namespace pocketmine\entity\hostile;

use pocketmine\entity\behavior\FindAttackableTargetBehavior;
use pocketmine\entity\behavior\FloatBehavior;
use pocketmine\entity\behavior\BehaviorPool;
use pocketmine\entity\behavior\LookAtPlayerBehavior;
use pocketmine\entity\behavior\RandomLookAroundBehavior;
use pocketmine\entity\behavior\RangedAttackBehavior;
use pocketmine\entity\behavior\RestrictSunBehavior;
use pocketmine\entity\behavior\WanderBehavior;
use pocketmine\entity\Entity;
use pocketmine\entity\Monster;
use pocketmine\entity\projectile\Arrow;
use pocketmine\entity\RangedAttackerMob;
use pocketmine\inventory\AltayEntityEquipment;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;

class IronGolem extends Monster {

	public const NETWORK_ID = self::IRON_GOLEM;
    public $behaviorPool;
	public $width = 0.6;
	public $height = 1.99;

	/** @var AltayEntityEquipment */

	protected function initEntity() : void{
        		parent::initEntity();
		$this->setMovementSpeed(0.75);
        $this->setHealth(10);
        $this->setMaxHealth(10);
        $this->setScale(0.4);
        $this->setNameTag("IronGolem");
        $this->setNameTagAlwaysVisible(true);
        $p = new BehaviorPool();
        $p->setBehavior(0,new LookAtPlayerBehavior($this, 5.0));

	}

	public function getName() : string{
		return "Iron Golem";
	}

	public function getDrops() : array{
		return [
			ItemFactory::get(Item::IRON_INGOT, 0, rand(0,2)),
			ItemFactory::get(Item::GOLD_INGOT, 0, rand(0,2))
		];
	}

	public function getXpDropAmount() : int{
		return 5;
	}



	public function entityBaseTick(int $diff = 1) : bool{
		if(!$this->isOnFire() and $this->level->isDayTime() and $this->aiEnabled){
			if(!$this->isUnderwater() and $this->level->canSeeSky($this)){
				$this->setOnFire(5);
			}
		}
		return parent::entityBaseTick($diff);
	}

	public function sendSpawnPacket(Player $player) : void{
		parent::sendSpawnPacket($player);


	}
}
