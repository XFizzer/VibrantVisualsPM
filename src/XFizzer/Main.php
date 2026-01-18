<?php

declare(strict_types=1);

namespace XFizzer;

use pocketmine\color\Color;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\world\particle\DustParticle;
use pocketmine\network\mcpe\protocol\ResourcePacksInfoPacket;
use ReflectionException;
use ReflectionProperty;

final class Main extends PluginBase implements Listener{


    protected function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onDataPacketSend(DataPacketSendEvent $event) : void{
        foreach($event->getPackets() as $packet){
            if(!$packet instanceof ResourcePacksInfoPacket){
                continue;
            }

            try{
                $reflection = new ReflectionProperty(ResourcePacksInfoPacket::class, "forceDisableVibrantVisuals");
                $reflection->setValue($packet, false);
            }catch(ReflectionException $e){
                $this->getLogger()->warning("Could not set forceDisableVibrantVisuals: " . $e->getMessage());
            }
        }
    }
}
