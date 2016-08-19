<?php

#。。。。。GAD学习类插件。。。。。#
#作者:PocketMine-GAD
#QQ:2296342883/不懂或有问题的找我，寻求插件合作伙伴(大神不要来，只求小萌新)因为我也是萌新，真的!o>_<o

namespace GAD;


####几乎每个插件都会用到的use####
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;
use pocketmine\event\Listener;
use pocketmine\item\item;
use pocketmine\Player;
use pocketmine\Server;
#玩家移动触发事件
use pocketmine\event\player\PlayerMoveEvent;
#玩家死亡事件
use pocketmine\event\player\playerdeathevent;
#文件
use pocketmine\utils\Config;
#实体
use pocketmine\entity\Entity;
#实体受伤
use pocketmine\event\entity\EntityDamageEvent;
#方块破坏
use pocketmine\event\block\BlockBreakEvent;
#实体被实体攻击
use pocketmine\event\entity\EntityDamagebyentityEvent;
#玩家加入服务器事件
use pocketmine\event\player\PlayerJoinEvent;
#玩家说话事件
use pocketmine\event\player\PlayerChatEvent;
#use引用结束

class GTP extends PluginBase implements Listener{
  public function onEnable(){
   $this->getLogger()->info("GTP插件正在加载");
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		}
		public function onDisable(){
		$this->getLogger()->info("GTP插件关闭中");
		}
		public function onJoin(PlayerJoinEvent $e){
		$p=$e->getPlayer();
		$n=$p->getName();
		#玩家文件创建
		@mkdir($this->getDataFolder(),0777,true);
		$this->config=new Config($this->getDataFolder().$n.".yml",Config::YAML,array("c"=>"write","ep"=>0));
		$ep= $this->config ->get("ep");
		$c= $this->config->get("c");
		$p->sendMessage("§c破坏值: §f$ep §d名字颜色: §f$c");
		if($c=="write"){
		$p->setNameTag("§f[萌新] $n");
		}elseif($c=="green"){
		$p->setNameTag("§a[凡人] $n");
		}elseif($c=="blue"){
		$p->setNameTag("§b[有经验的玩家] $n");
	  }elseif($c=="red"){
	  $p->setNameTag("§c[老司机] $n");

	  }
		}
		public function onBreak(BlockBreakEvent $e){
		 $p=$e->getPlayer();
		$n=$p->getName();
		$b=$e->getBlock();
		$bn=$b->getId();
		$ep= $this->config ->get("ep");
		 $c= $this->config->get("c");
		if($bn==1){
		 $this->config ->set("ep",$ep+1);
		 $this->config->save();
		 }elseif($bn==2){ $this->config ->set("ep",$ep+3);
		 $this->config->save();
		 }
		 $p->sendTip("Your exp $ep");
		 if($ep==30){
		 $this->config->set("c","green");
		 $this->config->save();
		 $p->sendMessage("§3恭喜升级，名字颜色变为§a绿色");
		 }elseif($ep==60){
		 $this->config->set("c","blue");
		 $this->config->save();
		 $p->sendMessage("§3恭喜升级，名字颜色变为§b蓝色");
		 }elseif($ep==100){
		 $this->config->set("c","red");
		 $this->config->save();
		 $p->sendMessage("§3恭喜升级，名字颜色变为§c红色");
		
		 return true;
		 }
		 }
#拉啦啦啦啦啦啦啦啦啦啦啦啦
		 
		 public function onChat(PlayerChatEvent $e){
		 $p=$e->getPlayer();
		 $n=$p->getName();
		 $e->setCancelled();
		 $msg=$e->getMessage();
		 $c=$this->config->get("c");
		 if($c=="green"){
		 $this->getServer()->broadcastMessage("§a[凡人] $n >> §7$msg");
		 }elseif($c=="blue"){
		 $this->getServer()->broadcastMessage("§b[有经验的玩家] $n >> §7$msg");
		 }elseif($c=="red"){
		 $this->getServer()->broadcastMessage("§c[老司机] $n >> §7$msg");
		 }elseif($c=="write"){
		 $this->getServer()->broadcastMessage("§f[萌新] $n >> §7$msg");
		 }
		 }
		 }
		 
		