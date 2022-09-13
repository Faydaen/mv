<?php
class Automobile extends Page implements IModule {
	public $moduleCode = "Automobile";

	public static $directions = array();
	public static $models = array();
	public static $fails = array();
	public static $improvements = array();
	public static $garage = array();
	public static $numbers = array();
	public static $factories = array();
	public static $petrol = array();
	public static $resources = array();
	public static $resources_drop = array();
	public static $factoryType = array();
	public static $features = array();
	public static $passengers = array();
	public static $bringUpFails = array();

	const BONUS_RANDOM = "random";
	const BONUS_RANDOM_PERCENT = "random_percent";

	public static function initResources() {
		// 1 - Шиномонтажный цех
		// Каучук - rubber
		// Плавильная печь - furnace
		// Насос - pump
		// 2 - Моторный цех
		// Стеклопакет - windows
		// Стеклорез - glasscutter
		// Балка - beam
		// 3 - Сборочный цех
		// Кирпич - brick
		// Цемент - cement
		// Краска - paint
		// 4 - Кузовной цех
		// Болт - screw
		// Чертёж - draft
		// Напильник - rasp
		
		// 1 - Шиномонтажный цех
		self::$resources["rubber"] = 	array("image" => "/@/images/obj/parts/7.png", "honey" => 1,  "name" => AutomobileLang::RES_RUBBER, "description" => "");
		self::$resources["furnace"] = 	array("image" => "/@/images/obj/parts/8.png", "honey" => 1,  "name" => AutomobileLang::RES_FURNACE, "description" => "");
		self::$resources["pump"] = 		array("image" => "/@/images/obj/parts/9.png", "honey" => 1,  "name" => AutomobileLang::RES_PUMP, 	"description" => "");
		// 2 - Моторный цех
		self::$resources["windows"] = 		array("image" => "/@/images/obj/parts/1.png", "honey" => 1,  "name" => AutomobileLang::RES_WINDOWS, "description" => "");
		self::$resources["glasscutter"] = 	array("image" => "/@/images/obj/parts/2.png", "honey" => 1,  "name" => AutomobileLang::RES_GLASSCUTTER, "description" => "");
		self::$resources["beam"] = 			array("image" => "/@/images/obj/parts/3.png", "honey" => 1,  "name" => AutomobileLang::RES_BEAM, "description" => "");
		// 3 - Сборочный цех
		self::$resources["brick"] = 	array("image" => "/@/images/obj/parts/4.png", "honey" => 1, "name" => AutomobileLang::RES_BRICK, "description" => "");
		self::$resources["cement"] = 	array("image" => "/@/images/obj/parts/5.png", "honey" => 1, "name" => AutomobileLang::RES_CEMENT, "description" => "");
		self::$resources["paint"] = 	array("image" => "/@/images/obj/parts/6.png", "honey" => 1, "name" => AutomobileLang::RES_PAINT, "description" => "");
		// 4 - Кузовной цех
		self::$resources["screw"] = 	array("image" => "/@/images/obj/parts/11.png", "honey" => 1, "name" => AutomobileLang::RES_SCREW, "description" => "");
		self::$resources["draft"] = 	array("image" => "/@/images/obj/parts/10.png", "honey" => 1, "name" => AutomobileLang::RES_DRAFT, "description" => "");
		self::$resources["rasp"] = 		array("image" => "/@/images/obj/parts/12.png", "honey" => 1, "name" => AutomobileLang::RES_RASP, "description" => "");
		

		self::$resources_drop[6] =  array("n" => 40);
		self::$resources_drop[7] =  array("n" => 60);
		self::$resources_drop[8] =  array("n" => 80);
		self::$resources_drop[9] =  array("n" => 100);
		self::$resources_drop[10] = array("n" => 120);
		self::$resources_drop[11] = array("n" => 140);
		self::$resources_drop[12] = array("n" => 180);
		self::$resources_drop[13] = array("n" => 200);
		self::$resources_drop[14] = array("n" => 220);
		self::$resources_drop[15] = array("n" => 240);
		self::$resources_drop[16] = array("n" => 260);
		self::$resources_drop[17] = array("n" => 280);
		self::$resources_drop[18] = array("n" => 300);
		self::$resources_drop[19] = array("n" => 320);
	}

	public static function initDirections() {
		// Направления
		// Stats:
		// health здоровье
		// strength сила
		// dexterity ловкость
		// intuition хитрость
		// resistance выносливость
		// attention внимательность
		// charism харизма
		self::$directions[1] = array("id" => 1, 	"level" => 1, 	"time" => 18 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("attention" 			=> array("min" => 5, "max" => 8), "percent_crit" 		=> array("min" => 1, "max" => 3))), "name" => AutomobileLang::DIRECTION_1, "image" => "/@/images/loc/auto/trip1");
		self::$directions[2] = array("id" => 2, 	"level" => 2, 	"time" => 18 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("resistance" 		=> array("min" => 5, "max" => 8), "percent_anticrit" 	=> array("min" => 1, "max" => 3))), "name" => AutomobileLang::DIRECTION_2, "image" => "/@/images/loc/auto/trip2");
		self::$directions[3] = array("id" => 3, 	"level" => 3, 	"time" => 18 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("intuition" 			=> array("min" => 5, "max" => 8), "percent_dodge" 		=> array("min" => 1, "max" => 3))), "name" => AutomobileLang::DIRECTION_3, "image" => "/@/images/loc/auto/trip3");
		self::$directions[4] = array("id" => 4, 	"level" => 4, 	"time" => 18 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("health" 			=> array("min" => 5, "max" => 8), "percent_defence" 	=> array("min" => 1, "max" => 3))), "name" => AutomobileLang::DIRECTION_4, "image" => "/@/images/loc/auto/trip4");
		self::$directions[5] = array("id" => 5, 	"level" => 5, 	"time" => 18 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("dexterity" 			=> array("min" => 5, "max" => 8), "percent_hit" 		=> array("min" => 1, "max" => 3))), "name" => AutomobileLang::DIRECTION_5, "image" => "/@/images/loc/auto/trip5");
		self::$directions[6] = array("id" => 6, 	"level" => 6, 	"time" => 18 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("strength" 			=> array("min" => 5, "max" => 8), "percent_dmg" 		=> array("min" => 1, "max" => 3))), "name" => AutomobileLang::DIRECTION_6, "image" => "/@/images/loc/auto/trip6");
		
		self::$directions[7] = array("id" => 7, 	"level" => 7, 	"time" => 22 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("attention" 			=> array("min" => 10, "max" => 13), "percent_crit" 		=> array("min" => 4, "max" => 6))), "name" => AutomobileLang::DIRECTION_7, "image" => "/@/images/loc/auto/trip7");
		self::$directions[8] = array("id" => 8, 	"level" => 8, 	"time" => 22 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("resistance" 		=> array("min" => 10, "max" => 13), "percent_anticrit" 	=> array("min" => 4, "max" => 6))), "name" => AutomobileLang::DIRECTION_8, "image" => "/@/images/loc/auto/trip8");
		self::$directions[9] = array("id" => 9, 	"level" => 9, 	"time" => 22 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("intuition" 			=> array("min" => 10, "max" => 13), "percent_dodge" 	=> array("min" => 4, "max" => 6))), "name" => AutomobileLang::DIRECTION_9, "image" => "/@/images/loc/auto/trip9");
		self::$directions[10] = array("id" => 10, 	"level" => 10, 	"time" => 22 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("health" 			=> array("min" => 10, "max" => 13), "percent_defence" 	=> array("min" => 4, "max" => 6))), "name" => AutomobileLang::DIRECTION_10, "image" => "/@/images/loc/auto/trip10");
		self::$directions[11] = array("id" => 11, 	"level" => 11, 	"time" => 22 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("dexterity" 			=> array("min" => 10, "max" => 13), "percent_hit" 		=> array("min" => 4, "max" => 6))), "name" => AutomobileLang::DIRECTION_11, "image" => "/@/images/loc/auto/trip11");
		self::$directions[12] = array("id" => 12, 	"level" => 12, 	"time" => 22 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("strength" 			=> array("min" => 10, "max" => 13), "percent_dmg" 		=> array("min" => 4, "max" => 6))), "name" => AutomobileLang::DIRECTION_12, "image" => "/@/images/loc/auto/trip12");
		
		self::$directions[13] = array("id" => 13, 	"level" => 13, 	"time" => 26 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("attention" 			=> array("min" => 15, "max" => 18), "percent_crit" 		=> array("min" => 7, "max" => 9))), "name" => AutomobileLang::DIRECTION_13, "image" => "/@/images/loc/auto/trip13");
		self::$directions[14] = array("id" => 14, 	"level" => 14, 	"time" => 26 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("resistance" 		=> array("min" => 15, "max" => 18), "percent_anticrit" 	=> array("min" => 7, "max" => 9))), "name" => AutomobileLang::DIRECTION_14, "image" => "/@/images/loc/auto/trip14");
		self::$directions[15] = array("id" => 15, 	"level" => 15, 	"time" => 26 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("intuition" 			=> array("min" => 15, "max" => 18), "percent_dodge" 	=> array("min" => 7, "max" => 9))), "name" => AutomobileLang::DIRECTION_15, "image" => "/@/images/loc/auto/trip15");
		self::$directions[16] = array("id" => 16, 	"level" => 16, 	"time" => 26 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("health" 			=> array("min" => 15, "max" => 18), "percent_defence" 	=> array("min" => 8, "max" => 10))), "name" => AutomobileLang::DIRECTION_16, "image" => "/@/images/loc/auto/trip16");
		self::$directions[17] = array("id" => 17, 	"level" => 17, 	"time" => 26 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("dexterity" 			=> array("min" => 15, "max" => 18), "percent_hit" 		=> array("min" => 9, "max" => 11))), "name" => AutomobileLang::DIRECTION_17, "image" => "/@/images/loc/auto/trip17");
		self::$directions[18] = array("id" => 18, 	"level" => 18, 	"time" => 26 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array("strength" 			=> array("min" => 15, "max" => 18), "percent_dmg" 		=> array("min" => 10, "max" => 12))), "name" => AutomobileLang::DIRECTION_18, "image" => "/@/images/loc/auto/trip18");
		
		self::$directions[19] = array("id" => 19, 	"level" => 19, 	"time" => 26 * 3600, "bonus" => array("time" => 6 * 3600, "stats" => array(self::BONUS_RANDOM 	=> array("min" => 15, "max" => 20), self::BONUS_RANDOM_PERCENT	=> array("min" => 10, "max" => 12))), "name" => AutomobileLang::DIRECTION_19, "image" => "/@/images/loc/auto/trip19");
	}

	public static function initPassengers() {
		self::$bringUpFails[] = AutomobileLang::MESSAGE_BRING_UP_FAIL_1;
		self::$bringUpFails[] = AutomobileLang::MESSAGE_BRING_UP_FAIL_2;
		self::$bringUpFails[] = AutomobileLang::MESSAGE_BRING_UP_FAIL_3;

		self::$passengers[1][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_1_1;
		self::$passengers[1][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_1_2;
		self::$passengers[1][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_1_3;
		self::$passengers[1][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_1_4;
		self::$passengers[1][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_1_5;

		self::$passengers[2][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_2_1;
		self::$passengers[2][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_2_2;
		self::$passengers[2][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_2_3;
		self::$passengers[2][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_2_4;
		self::$passengers[2][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_2_5;

		self::$passengers[3][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_3_1;
		self::$passengers[3][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_3_2;
		self::$passengers[3][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_3_3;
		self::$passengers[3][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_3_4;
		self::$passengers[3][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_3_5;

		self::$passengers[4][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_4_1;
		self::$passengers[4][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_4_2;
		self::$passengers[4][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_4_3;
		self::$passengers[4][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_4_4;
		self::$passengers[4][] = AutomobileLang::MESSAGE_BRING_UP_PASSENGER_4_5;
	}

	public static function initModels() {
		// Марки машин
		self::$models[1] =  array("id" => 1,  "level" => 1,  "speed" => 60,  "controllability" => 10, "passability" => 20, "prestige" => 10, "group" => 1, "petrol" => 76, "cooldown" => 6 * 3600, "productiontime" => 5 * 3600, 		"cost" => array( "money" => 4125,	"ore" => 28		), "name" => AutomobileLang::CAR_1_NAME, "description" => AutomobileLang::CAR_1_DESC, "image" => "/@/images/obj/cars/1");
		self::$models[2] =  array("id" => 2,  "level" => 2,  "speed" => 65,  "controllability" => 10, "passability" => 50, "prestige" => 15, "group" => 1, "petrol" => 76, "cooldown" => 6 * 3600, "productiontime" => 6 * 3600, 		"cost" => array( "money" => 5720,	"ore" => 34		), "name" => AutomobileLang::CAR_2_NAME, "description" => AutomobileLang::CAR_2_DESC, "image" => "/@/images/obj/cars/2");
		self::$models[3] =  array("id" => 3,  "level" => 3,  "speed" => 70,  "controllability" => 15, "passability" => 20, "prestige" => 20, "group" => 1, "petrol" => 92, "cooldown" => 6 * 3600, "productiontime" => 7 * 3600, 		"cost" => array( "money" => 7425,	"ore" => 42		), "name" => AutomobileLang::CAR_3_NAME, "description" => AutomobileLang::CAR_3_DESC, "image" => "/@/images/obj/cars/3");
		self::$models[4] =  array("id" => 4,  "level" => 4,  "speed" => 75,  "controllability" => 20, "passability" => 20, "prestige" => 25, "group" => 1, "petrol" => 92, "cooldown" => 6 * 3600, "productiontime" => 8 * 3600, 		"cost" => array( "money" => 9240,	"ore" => 49		), "name" => AutomobileLang::CAR_4_NAME, "description" => AutomobileLang::CAR_4_DESC, "image" => "/@/images/obj/cars/4");
		self::$models[5] =  array("id" => 5,  "level" => 5,  "speed" => 80,  "controllability" => 25, "passability" => 20, "prestige" => 30, "group" => 1, "petrol" => 92, "cooldown" => 6 * 3600, "productiontime" => 9 * 3600, 		"cost" => array( "money" => 11165,	"ore" => 57		), "name" => AutomobileLang::CAR_5_NAME, "description" => AutomobileLang::CAR_5_DESC, "image" => "/@/images/obj/cars/5");
		self::$models[6] =  array("id" => 6,  "level" => 6,  "speed" => 85,  "controllability" => 30, "passability" => 20, "prestige" => 35, "group" => 1, "petrol" => 92, "cooldown" => 6 * 3600, "productiontime" => 10 * 3600, 		"cost" => array( "money" => 13200,	"ore" => 66		), "name" => AutomobileLang::CAR_6_NAME, "description" => AutomobileLang::CAR_6_DESC, "image" => "/@/images/obj/cars/6");
		self::$models[7] =  array("id" => 7,  "level" => 7,  "speed" => 100, "controllability" => 35, "passability" => 20, "prestige" => 50, "group" => 2, "petrol" => 95, "cooldown" => 10 * 3600, "productiontime" => 11 * 3600, 		"cost" => array( "money" => 17050,	"oil" => 409	), "name" => AutomobileLang::CAR_7_NAME, "description" => AutomobileLang::CAR_7_DESC, "image" => "/@/images/obj/cars/7");
		self::$models[8] =  array("id" => 8,  "level" => 8,  "speed" => 100, "controllability" => 40, "passability" => 40, "prestige" => 60, "group" => 2, "petrol" => 95, "cooldown" => 10 * 3600, "productiontime" => 12 * 3600, 		"cost" => array( "money" => 21120,	"oil" => 513	), "name" => AutomobileLang::CAR_8_NAME, "description" => AutomobileLang::CAR_8_DESC, "image" => "/@/images/obj/cars/8");
		self::$models[9] =  array("id" => 9,  "level" => 9,  "speed" => 90,  "controllability" => 35, "passability" => 50, "prestige" => 70, "group" => 2, "petrol" => 95, "cooldown" => 10 * 3600, "productiontime" => 13 * 3600, 		"cost" => array( "money" => 25410,	"oil" => 627	), "name" => AutomobileLang::CAR_9_NAME, "description" => AutomobileLang::CAR_9_DESC, "image" => "/@/images/obj/cars/9");
		self::$models[10] = array("id" => 10, "level" => 10, "speed" => 110, "controllability" => 50, "passability" => 20, "prestige" => 80, "group" => 2, "petrol" => 95, "cooldown" => 10 * 3600, "productiontime" => 14 * 3600, 		"cost" => array( "money" => 29920,	"oil" => 754	), "name" => AutomobileLang::CAR_10_NAME, "description" => AutomobileLang::CAR_10_DESC, "image" => "/@/images/obj/cars/10");
		self::$models[11] = array("id" => 11, "level" => 11, "speed" => 120, "controllability" => 50, "passability" => 40, "prestige" => 90, "group" => 2, "petrol" => 95, "cooldown" => 10 * 3600, "productiontime" => 15 * 3600, 		"cost" => array( "money" => 34650,	"oil" => 893	), "name" => AutomobileLang::CAR_11_NAME, "description" => AutomobileLang::CAR_11_DESC, "image" => "/@/images/obj/cars/11");
		self::$models[12] = array("id" => 12, "level" => 12, "speed" => 120, "controllability" => 50, "passability" => 20, "prestige" => 100, "group" => 2, "petrol" => 95, "cooldown" => 10 * 3600, "productiontime" => 16 * 3600, 	"cost" => array( "money" => 39600,	"oil" => 1045	), "name" => AutomobileLang::CAR_12_NAME, "description" => AutomobileLang::CAR_12_DESC, "image" => "/@/images/obj/cars/12");
		self::$models[13] = array("id" => 13, "level" => 13, "speed" => 100, "controllability" => 45, "passability" => 45, "prestige" => 120, "group" => 3, "petrol" => 95, "cooldown" => 14 * 3600, "productiontime" => 17 * 3600, 	"cost" => array( "money" => 50875,	"oil" => 1262	), "name" => AutomobileLang::CAR_13_NAME, "description" => AutomobileLang::CAR_13_DESC, "image" => "/@/images/obj/cars/13");
		self::$models[14] = array("id" => 14, "level" => 14, "speed" => 170, "controllability" => 60, "passability" => 10, "prestige" => 140, "group" => 3, "petrol" => 98, "cooldown" => 14 * 3600, "productiontime" => 18 * 3600, 	"cost" => array( "money" => 62700,	"oil" => 1498	), "name" => AutomobileLang::CAR_14_NAME, "description" => AutomobileLang::CAR_14_DESC, "image" => "/@/images/obj/cars/14");
		self::$models[15] = array("id" => 15, "level" => 15, "speed" => 160, "controllability" => 60, "passability" => 10, "prestige" => 160, "group" => 3, "petrol" => 98, "cooldown" => 14 * 3600, "productiontime" => 19 * 3600, 	"cost" => array( "money" => 75075,	"oil" => 1755	), "name" => AutomobileLang::CAR_15_NAME, "description" => AutomobileLang::CAR_15_DESC, "image" => "/@/images/obj/cars/15");
		self::$models[16] = array("id" => 16, "level" => 16, "speed" => 180, "controllability" => 60, "passability" => 10, "prestige" => 180, "group" => 3, "petrol" => 98, "cooldown" => 14 * 3600, "productiontime" => 20 * 3600, 	"cost" => array( "money" => 88000,	"oil" => 2035	), "name" => AutomobileLang::CAR_16_NAME, "description" => AutomobileLang::CAR_16_DESC, "image" => "/@/images/obj/cars/16");
		self::$models[17] = array("id" => 17, "level" => 17, "speed" => 130, "controllability" => 60, "passability" => 10, "prestige" => 200, "group" => 3, "petrol" => 98, "cooldown" => 14 * 3600, "productiontime" => 21 * 3600, 	"cost" => array( "money" => 101475,	"oil" => 2336	), "name" => AutomobileLang::CAR_17_NAME, "description" => AutomobileLang::CAR_17_DESC, "image" => "/@/images/obj/cars/17");
		self::$models[18] = array("id" => 18, "level" => 18, "speed" => 100, "controllability" => 60, "passability" => 10, "prestige" => 220, "group" => 3, "petrol" => 98, "cooldown" => 14 * 3600, "productiontime" => 22 * 3600, 	"cost" => array( "money" => 115500,	"oil" => 2661	), "name" => AutomobileLang::CAR_18_NAME, "description" => AutomobileLang::CAR_18_DESC, "image" => "/@/images/obj/cars/18");
		self::$models[19] = array("id" => 19, "level" => 19, "speed" => 30,  "controllability" => 10, "passability" => 60, "prestige" => 100, "group" => 4, "petrol" => 100, "cooldown" => 36 * 3600, "productiontime" => 72 * 3600, 	"cost" => array( "money" => 275000,	"oil" => 8250	), "name" => AutomobileLang::CAR_19_NAME, "description" => AutomobileLang::CAR_19_DESC, "image" => "/@/images/obj/cars/19");
	}

	public static function initFails() {
		// Негативные ситуации
		self::$fails[1] = array("id" => 1, "probability" => 1, "time" => 30 * 60, "text" => AutomobileLang::FAIL_1, "image" => "");
		self::$fails[2] = array("id" => 2, "probability" => 1, "time" => 30 * 60, "text" => AutomobileLang::FAIL_2, "image" => "");
		self::$fails[3] = array("id" => 3, "probability" => 1, "time" => 60 * 60, "text" => AutomobileLang::FAIL_3, "image" => "");
		self::$fails[4] = array("id" => 4, "probability" => 1, "time" => 60 * 60, "text" => AutomobileLang::FAIL_4, "image" => "");
		self::$fails[5] = array("id" => 5, "probability" => 1, "time" => 60 * 60, "text" => AutomobileLang::FAIL_5, "image" => "");
		self::$fails[6] = array("id" => 6, "probability" => 1, "time" => 90 * 60, "text" => AutomobileLang::FAIL_6, "image" => "");
		self::$fails[7] = array("id" => 7, "probability" => 1, "time" => 30 * 60, "text" => AutomobileLang::FAIL_7, "image" => "");
	}

	public static function initImprovements() {
		// Улучшения
		self::$improvements[1] =  array("bit" => 1,    "bonus" => array("speed" => 5,  "controllability" => 5,  "passability" => 5,  "prestige" => 5),  "image" => "/@/images/obj/cars/upgrade1.png",  "cost" => array("ore" => 40),    "time" => 30 * 60, "group" => 1, "factory" => 1, "factory_level" => 2,  "name" => AutomobileLang::IMPROVEMENT_1_NAME, "description" => AutomobileLang::IMPROVEMENT_1_DESC);
		self::$improvements[2] =  array("bit" => 2,    "bonus" => array("speed" => 0,  "controllability" => 0,  "passability" => 0,  "prestige" => 10), "image" => "/@/images/obj/cars/upgrade2.png",  "cost" => array("oil" => 400),   "time" => 45 * 60, "group" => 1, "factory" => 1, "factory_level" => 8,  "name" => AutomobileLang::IMPROVEMENT_2_NAME, "description" => AutomobileLang::IMPROVEMENT_2_DESC);
		self::$improvements[3] =  array("bit" => 4,    "bonus" => array("speed" => 15, "controllability" => 15, "passability" => 0,  "prestige" => 0),  "image" => "/@/images/obj/cars/upgrade3.png",  "cost" => array("oil" => 900),   "time" => 60 * 60, "group" => 1, "factory" => 1, "factory_level" => 14, "name" => AutomobileLang::IMPROVEMENT_3_NAME, "description" => AutomobileLang::IMPROVEMENT_3_DESC);
		self::$improvements[4] =  array("bit" => 8,    "bonus" => array("speed" => 5,  "controllability" => 5,  "passability" => 0,  "prestige" => 0),  "image" => "/@/images/obj/cars/upgrade4.png",  "cost" => array("ore" => 60),    "time" => 30 * 60, "group" => 1, "factory" => 2, "factory_level" => 4,  "name" => AutomobileLang::IMPROVEMENT_4_NAME, "description" => AutomobileLang::IMPROVEMENT_4_DESC);
		self::$improvements[5] =  array("bit" => 16,   "bonus" => array("speed" => 10, "controllability" => 0,  "passability" => 10, "prestige" => 0),  "image" => "/@/images/obj/cars/upgrade5.png",  "cost" => array("oil" => 600),   "time" => 45 * 60, "group" => 1, "factory" => 2, "factory_level" => 10, "name" => AutomobileLang::IMPROVEMENT_5_NAME, "description" => AutomobileLang::IMPROVEMENT_5_DESC);
		self::$improvements[6] =  array("bit" => 32,   "bonus" => array("speed" => 15, "controllability" => 0,  "passability" => 0,  "prestige" => 0),  "image" => "/@/images/obj/cars/upgrade6.png",  "cost" => array("oil" => 1100),   "time" => 60 * 60, "group" => 1, "factory" => 2, "factory_level" => 16, "name" => AutomobileLang::IMPROVEMENT_6_NAME, "description" => AutomobileLang::IMPROVEMENT_6_DESC);
		self::$improvements[7] =  array("bit" => 64,   "bonus" => array("speed" => 0,  "controllability" => 0,  "passability" => 5,  "prestige" => 0),  "image" => "/@/images/obj/cars/upgrade7.png",  "cost" => array("ore" => 50),    "time" => 30 * 60, "group" => 1, "factory" => 3, "factory_level" => 3,  "name" => AutomobileLang::IMPROVEMENT_7_NAME, "description" => AutomobileLang::IMPROVEMENT_7_DESC);
		self::$improvements[8] =  array("bit" => 128,  "bonus" => array("speed" => 0,  "controllability" => 10, "passability" => 0,  "prestige" => 10), "image" => "/@/images/obj/cars/upgrade8.png",  "cost" => array("oil" => 500),   "time" => 45 * 60, "group" => 1, "factory" => 3, "factory_level" => 9,  "name" => AutomobileLang::IMPROVEMENT_8_NAME, "description" => AutomobileLang::IMPROVEMENT_8_DESC);
		self::$improvements[9] =  array("bit" => 256,  "bonus" => array("speed" => 0,  "controllability" => 15, "passability" => 0,  "prestige" => 0),  "image" => "/@/images/obj/cars/upgrade9.png",  "cost" => array("oil" => 1000),   "time" => 60 * 60, "group" => 1, "factory" => 3, "factory_level" => 15, "name" => AutomobileLang::IMPROVEMENT_9_NAME, "description" => AutomobileLang::IMPROVEMENT_9_DESC);
		self::$improvements[10] = array("bit" => 512,  "bonus" => array("speed" => 0,  "controllability" => 0,  "passability" => 0,  "prestige" => 15), "image" => "/@/images/obj/cars/upgrade10.png", "cost" => array("ore" => 70),    "time" => 30 * 60, "group" => 1, "factory" => 4, "factory_level" => 5,  "name" => AutomobileLang::IMPROVEMENT_10_NAME, "description" => AutomobileLang::IMPROVEMENT_10_DESC);
		self::$improvements[11] = array("bit" => 1024, "bonus" => array("speed" => 10, "controllability" => 10, "passability" => 0,  "prestige" => 10), "image" => "/@/images/obj/cars/upgrade11.png", "cost" => array("oil" => 700),   "time" => 45 * 60, "group" => 1, "factory" => 4, "factory_level" => 11, "name" => AutomobileLang::IMPROVEMENT_11_NAME, "description" => AutomobileLang::IMPROVEMENT_11_DESC);
		self::$improvements[12] = array("bit" => 2048, "bonus" => array("speed" => 0,  "controllability" => 0,  "passability" => 0,  "prestige" => 15), "image" => "/@/images/obj/cars/upgrade12.png", "cost" => array("oil" => 1200),   "time" => 60 * 60, "group" => 1, "factory" => 4, "factory_level" => 17, "name" => AutomobileLang::IMPROVEMENT_12_NAME, "description" => AutomobileLang::IMPROVEMENT_12_DESC);
		self::$improvements[13] = array("bit" => 4096, "bonus" => array("speed" => 10, "controllability" => 0,  "passability" => 0,  "prestige" => 10), "image" => "/@/images/obj/cars/upgrade13.png", "cost" => array("honey" => 15), "acts" => 14 * 86400, "time" => 60 * 60, "group" => 0, "factory" => 0, "factory_level" => 3,  "name" => AutomobileLang::IMPROVEMENT_13_NAME, "description" => AutomobileLang::IMPROVEMENT_13_DESC);
		self::$improvements[14] = array("bit" => 8192, "bonus" => array("speed" => 10, "controllability" => 0,  "passability" => 0,  "prestige" => 10), "image" => "/@/images/obj/cars/upgrade14.png", "cost" => array("honey" => 15), "acts" => 14 * 86400, "time" => 60 * 60, "group" => 0, "factory" => 0, "factory_level" => 3,  "name" => AutomobileLang::IMPROVEMENT_14_NAME, "description" => AutomobileLang::IMPROVEMENT_14_DESC);
	}

	public static function initGarage() {
		// Гараж (цена за количество мест)
		self::$garage[1] = array("ore" => 10);
		self::$garage[2] = array("ore" => 20);
		self::$garage[3] = array("ore" => 40);
		self::$garage[4] = array("ore" => 100);
		self::$garage[5] = array("ore" => 200);
		self::$garage[6] = array("ore" => 400);
		self::$garage[7] = array("ore" => 1000);
		self::$garage[8] = array("ore" => 2000);
		self::$garage[9] = array("ore" => 4000);
		self::$garage[10] = array("oil" => 10000);		
	}

	public static function initNumbers() {
		// Цены на номера
		self::$numbers[1] = array("cool" => 1, "cost" => array("ore" => 1), "name" => AutomobileLang::NUMBER_0, "format" => "*<b>***</b>**", "bonus" => array());
		self::$numbers[2] = array("cool" => 2, "cost" => array("ore" => 50), "name" => AutomobileLang::NUMBER_1, "format" => "*<b>NNN</b>**", "bonus" => array("prestige" => 10));
		self::$numbers[3] = array("cool" => 3, "cost" => array("honey" => 100), "name" => AutomobileLang::NUMBER_2, "format" => "Б<b>***</b>ББ", "bonus" => array("prestige" => 20));
		self::$numbers[4] = array("cool" => 4, "cost" => array("ore" => 250), "name" => AutomobileLang::NUMBER_3, "format" => "Б<b>NNN</b>ББ", "bonus" => array("prestige" => 30, "speed" => 10));
		self::$numbers[5] = array("cool" => 5, "cost" => array("honey" => 500), "name" => AutomobileLang::NUMBER_4, "format" => array("А<b>***</b>АА","О<b>***</b>ОО"), "bonus" => array("prestige" => 40, "speed" => 10));
		self::$numbers[6] = array("cool" => 6, "cost" => array("honey" => 1190), "name" => AutomobileLang::NUMBER_5, "format" => array("А<b>***</b>МР", "Е<b>***</b>КХ"), "bonus" => array("prestige" => 50, "speed" => 10));
		self::$numbers[7] = array("cool" => 7, "cost" => array('А777МР' => array("honey" => 100000),'Е777КХ' => array("honey" => 99999),'А001МР' => array("honey" => 70000),'Е001КХ' => array("honey" => 69999),'А666МР' => array("honey" => 66666),'Е666КХ' => array("honey" => 66666),'А007МР' => array("honey" => 50000),'Е007КХ' => array("honey" => 49999),'А777АА' => array("honey" => 30000),'А001АА' => array("honey" => 20000),'А666АА' => array("honey" => 16666),'А007АА' => array("honey" => 10000),'А111МР' => array("honey" => 5000),'А222МР' => array("honey" => 5000),'А333МР' => array("honey" => 5000),'А444МР' => array("honey" => 5000),'А555МР' => array("honey" => 5000),'А888МР' => array("honey" => 5000),'А999МР' => array("honey" => 5000),'Е111КХ' => array("honey" => 4999),'Е222КХ' => array("honey" => 4999),'Е333КХ' => array("honey" => 4999),'Е444КХ' => array("honey" => 4999),'Е555КХ' => array("honey" => 4999),'Е888КХ' => array("honey" => 4999),'Е999КХ' => array("honey" => 4999),'А111АА' => array("honey" => 3000),'А222АА' => array("honey" => 3000),'А333АА' => array("honey" => 3000),'А444АА' => array("honey" => 3000),'А555АА' => array("honey" => 3000),'А888АА' => array("honey" => 3000),'А999АА' => array("honey" => 3000)), "bonus" => array("prestige" => 50, "speed" => 10));
	}

	public static function initPetrol() {
		// Цены на бензин
		self::$petrol[76] = array("ore" => 5);
		self::$petrol[92] = array("ore" => 10);
		self::$petrol[95] = array("oil" => 100);
		self::$petrol[98] = array("oil" => 150);
		self::$petrol[100] = array("oil" => 240); 
	}

	public static function initFeatures() {
		self::$features["controllability"] = AutomobileLang::STAT_CONTROLLABILITY;
		self::$features["passability"] = AutomobileLang::STAT_PASSABILITY;
		self::$features["speed"] = AutomobileLang::STAT_SPEED;
		self::$features["prestige"] = AutomobileLang::STAT_PRESTIGE;
		self::$features["acts"] = AutomobileLang::STAT_ACTS;
		self::$features["left"] = AutomobileLang::STAT_LEFT;

		self::$features["intuition"] = Lang::$captionStatIntuition;
		self::$features["attention"] = Lang::$captionStatAttention;
		self::$features["resistance"] = Lang::$captionStatResistance;
		self::$features["health"] = Lang::$captionStatHealth;
		self::$features["dexterity"] = Lang::$captionStatDexterity;
		self::$features["strength"] = Lang::$captionStatStrength;
		self::$features["random"] = AutomobileLang::STAT_RANDOM;
		self::$features["ride_time"] = AutomobileLang::STAT_TIME;

		self::$features["percent_dmg"] = Lang::$captionPercentDmg;
		self::$features["percent_defence"] = Lang::$captionPercentDefence;
		self::$features["percent_hit"] = Lang::$captionPercentHit;
		self::$features["percent_dodge"] = Lang::$captionPercentDodge;
		self::$features["percent_crit"] = Lang::$captionPercentCrit;
		self::$features["percent_anticrit"] = Lang::$captionPercentAnticrit;

	}

	public static function initFactories() {
		// 1 - Шиномонтажный цех
		// Каучук - rubber
		// Плавильная печь - furnace
		// Насос - pump
		// 2 - Моторный цех
		// Стеклопакет - windows
		// Стеклорез - glasscutter
		// Балка - beam
		// 3 - Сборочный цех
		// Кирпич - brick
		// Цемент - cement
		// Краска - paint
		// 4 - Кузовной цех
		// Болт - screw
		// Чертёж - draft
		// Напильник - rasp

		self::$factoryType[1] = array("name" => AutomobileLang::FACTORY_1_NAME, "image" => "/@/images/loc/auto/building-koleso", "description" => AutomobileLang::FACTORY_1_DESC, "code" => "koleso");
		self::$factoryType[2] = array("name" => AutomobileLang::FACTORY_2_NAME, "image" => "/@/images/loc/auto/building-motor", "description" => AutomobileLang::FACTORY_2_DESC, "code" => "motor");
		self::$factoryType[3] = array("name" => AutomobileLang::FACTORY_3_NAME, "image" => "/@/images/loc/auto/building-rul", "description" => AutomobileLang::FACTORY_3_DESC, "code" => "rul");
		self::$factoryType[4] = array("name" => AutomobileLang::FACTORY_4_NAME, "image" => "/@/images/loc/auto/building-kuzov", "description" => AutomobileLang::FACTORY_4_DESC, "code" => "kuzov");

		// Стоимость цехов (номер цеха, уровень цеха)
		self::$factories[1][1] = array("cooldown" => 3600, 		"cost" => array("rubber" => 8,		"furnace" => 10,	"pump" => 12,	"ore" => 10), 	"honey" => 10);
		self::$factories[1][2] = array("cooldown" => 7200, 		"cost" => array("rubber" => 35,		"furnace" => 25,	"pump" => 30,	"ore" => 20), 	"honey" => 15);
		self::$factories[1][3] = array("cooldown" => 10800, 	"cost" => array("rubber" => 47,		"furnace" => 55,	"pump" => 48,	"ore" => 30), 	"honey" => 25);
		self::$factories[1][4] = array("cooldown" => 14400, 	"cost" => array("rubber" => 60,		"furnace" => 40,	"pump" => 80,	"ore" => 40), 	"honey" => 35);
		self::$factories[1][5] = array("cooldown" => 18000, 	"cost" => array("rubber" => 60,		"furnace" => 100,	"pump" => 80,	"ore" => 50), 	"honey" => 45);
		self::$factories[1][6] = array("cooldown" => 21600, 	"cost" => array("rubber" => 110,	"furnace" => 90,	"pump" => 70,	"ore" => 60), 	"honey" => 55);
		self::$factories[1][7] = array("cooldown" => 28800, 	"cost" => array("rubber" => 115,	"furnace" => 60, 	"pump" => 155,	"oil" => 850),	"honey" => 75);
		self::$factories[1][8] = array("cooldown" => 36000, 	"cost" => array("rubber" => 155,	"furnace" => 140, 	"pump" => 95,	"oil" => 1005), "honey" => 85);
		self::$factories[1][9] = array("cooldown" => 43200, 	"cost" => array("rubber" => 130,	"furnace" => 200, 	"pump" => 150,	"oil" => 1240), "honey" => 95);
		self::$factories[1][10] = array("cooldown" => 50400, 	"cost" => array("rubber" => 120,	"furnace" => 180,	"pump" => 240,	"oil" => 1395), "honey" => 110);
		self::$factories[1][11] = array("cooldown" => 57600, 	"cost" => array("rubber" => 210,	"furnace" => 160,	"pump" => 260,	"oil" => 1625), "honey" => 120);
		self::$factories[1][12] = array("cooldown" => 64800, 	"cost" => array("rubber" => 300,	"furnace" => 290,	"pump" => 130,	"oil" => 1860), "honey" => 130);
		self::$factories[1][13] = array("cooldown" => 75600, 	"cost" => array("rubber" => 380,	"furnace" => 300,	"pump" => 220,	"oil" => 2325),	"honey" => 140);
		self::$factories[1][14] = array("cooldown" => 86400, 	"cost" => array("rubber" => 275,	"furnace" => 400, 	"pump" => 345,	"oil" => 2635),	"honey" => 150);
		self::$factories[1][15] = array("cooldown" => 97200, 	"cost" => array("rubber" => 345,	"furnace" => 300, 	"pump" => 435,	"oil" => 2790),	"honey" => 160);
		self::$factories[1][16] = array("cooldown" => 108000, 	"cost" => array("rubber" => 400,	"furnace" => 300, 	"pump" => 500,	"oil" => 3100),	"honey" => 170);
		self::$factories[1][17] = array("cooldown" => 118800, 	"cost" => array("rubber" => 420,	"furnace" => 490, 	"pump" => 350,	"oil" => 3255),	"honey" => 180);
		self::$factories[1][18] = array("cooldown" => 129600, 	"cost" => array("rubber" => 480,	"furnace" => 510, 	"pump" => 450,	"oil" => 3720),	"honey" => 190);
		self::$factories[1][19] = array("cooldown" => 182800, 	"cost" => array("rubber" => 1000, 	"furnace" => 1000, 	"pump" => 1000,	"oil" => 8000),	"honey" => 200);

		self::$factories[2][1] = array("cooldown" => 3600, 		"cost" => array("screw" => 12,		"draft" => 7,		"rasp" =>11,	"ore" => 10), 	"honey" => 10);
		self::$factories[2][2] = array("cooldown" => 7200, 		"cost" => array("screw" => 32,		"draft" => 24,		"rasp" =>34,	"ore" => 20), 	"honey" => 15);
		self::$factories[2][3] = array("cooldown" => 10800, 	"cost" => array("screw" => 46,		"draft" => 59,		"rasp" =>45,	"ore" => 30), 	"honey" => 25);
		self::$factories[2][4] = array("cooldown" => 14400, 	"cost" => array("screw" => 50,		"draft" => 60,		"rasp" =>70,	"ore" => 40), 	"honey" => 35);
		self::$factories[2][5] = array("cooldown" => 18000, 	"cost" => array("screw" => 77,		"draft" => 67,		"rasp" =>96,	"ore" => 50), 	"honey" => 45);
		self::$factories[2][6] = array("cooldown" => 21600, 	"cost" => array("screw" => 103,		"draft" => 103,		"rasp" =>64,	"ore" => 60), 	"honey" => 55);
		self::$factories[2][7] = array("cooldown" => 28800, 	"cost" => array("screw" => 95,		"draft" => 105,		"rasp" =>130,	"oil" => 850),	"honey" => 75);
		self::$factories[2][8] = array("cooldown" => 36000, 	"cost" => array("screw" => 140,		"draft" => 98,		"rasp" =>152,	"oil" => 1005), "honey" => 85);
		self::$factories[2][9] = array("cooldown" => 43200, 	"cost" => array("screw" => 165,		"draft" => 197,		"rasp" =>118,	"oil" => 1240), "honey" => 95);
		self::$factories[2][10] = array("cooldown" => 50400, 	"cost" => array("screw" => 246,		"draft" => 146,		"rasp" =>148,	"oil" => 1395), "honey" => 110);
		self::$factories[2][11] = array("cooldown" => 57600, 	"cost" => array("screw" => 181,		"draft" => 252,		"rasp" =>197,	"oil" => 1625), "honey" => 120);
		self::$factories[2][12] = array("cooldown" => 64800, 	"cost" => array("screw" => 203,		"draft" => 232,		"rasp" =>285,	"oil" => 1860), "honey" => 130);
		self::$factories[2][13] = array("cooldown" => 75600, 	"cost" => array("screw" => 310,		"draft" => 260,		"rasp" =>330,	"oil" => 2325),	"honey" => 140);
		self::$factories[2][14] = array("cooldown" => 86400, 	"cost" => array("screw" => 298,		"draft" => 357,		"rasp" =>365, 	"oil" => 2635),	"honey" => 150);
		self::$factories[2][15] = array("cooldown" => 97200, 	"cost" => array("screw" => 392,		"draft" => 383,		"rasp" =>305, 	"oil" => 2790),	"honey" => 160);
		self::$factories[2][16] = array("cooldown" => 108000, 	"cost" => array("screw" => 450,		"draft" => 340,		"rasp" =>410, 	"oil" => 3100),	"honey" => 170);
		self::$factories[2][17] = array("cooldown" => 118800, 	"cost" => array("screw" => 354,		"draft" => 418,		"rasp" =>488, 	"oil" => 3255),	"honey" => 180);
		self::$factories[2][18] = array("cooldown" => 129600, 	"cost" => array("screw" => 496,		"draft" => 542,		"rasp" =>402, 	"oil" => 3720),	"honey" => 190);
		self::$factories[2][19] = array("cooldown" => 182800, 	"cost" => array("screw" => 1000,	"draft" => 1000,	"rasp" =>1000, 	"oil" => 8000),	"honey" => 200);
		
		self::$factories[3][1] = array("cooldown" => 3600, 		"cost" => array("windows" => 8,			"glasscutter" => 13,		"beam" => 9,	"ore" => 10), 	"honey" => 10);
		self::$factories[3][2] = array("cooldown" => 7200, 		"cost" => array("windows" => 31,		"glasscutter" => 34,		"beam" => 25,	"ore" => 20), 	"honey" => 15);
		self::$factories[3][3] = array("cooldown" => 10800, 	"cost" => array("windows" => 51,		"glasscutter" => 43,		"beam" => 56,	"ore" => 30), 	"honey" => 25);
		self::$factories[3][4] = array("cooldown" => 14400, 	"cost" => array("windows" => 63,		"glasscutter" => 48,		"beam" => 69,	"ore" => 40), 	"honey" => 35);
		self::$factories[3][5] = array("cooldown" => 18000, 	"cost" => array("windows" => 64,		"glasscutter" => 94,		"beam" => 82,	"ore" => 50), 	"honey" => 45);
		self::$factories[3][6] = array("cooldown" => 21600, 	"cost" => array("windows" => 103,		"glasscutter" => 88,		"beam" => 79,	"ore" => 60), 	"honey" => 55);
		self::$factories[3][7] = array("cooldown" => 28800, 	"cost" => array("windows" => 104,		"glasscutter" => 127,		"beam" => 99,	"oil" => 850),	"honey" => 75);
		self::$factories[3][8] = array("cooldown" => 36000, 	"cost" => array("windows" => 109,		"glasscutter" => 136,		"beam" => 145,	"oil" => 1005), "honey" => 85);
		self::$factories[3][9] = array("cooldown" => 43200, 	"cost" => array("windows" => 187,		"glasscutter" => 137,		"beam" => 156,	"oil" => 1240), "honey" => 95);
		self::$factories[3][10] = array("cooldown" => 50400, 	"cost" => array("windows" => 188,		"glasscutter" => 202,		"beam" => 150,	"oil" => 1395), "honey" => 110);
		self::$factories[3][11] = array("cooldown" => 57600, 	"cost" => array("windows" => 194,		"glasscutter" => 198,		"beam" => 238,	"oil" => 1625), "honey" => 120);
		self::$factories[3][12] = array("cooldown" => 64800, 	"cost" => array("windows" => 248,		"glasscutter" => 230,		"beam" => 242,	"oil" => 1860), "honey" => 130);
		self::$factories[3][13] = array("cooldown" => 75600, 	"cost" => array("windows" => 291,		"glasscutter" => 347,		"beam" => 262, 	"oil" => 2325),	"honey" => 140);
		self::$factories[3][14] = array("cooldown" => 86400, 	"cost" => array("windows" => 326,		"glasscutter" => 312,		"beam" => 382, 	"oil" => 2635),	"honey" => 150);
		self::$factories[3][15] = array("cooldown" => 97200, 	"cost" => array("windows" => 383,		"glasscutter" => 341,		"beam" => 356, 	"oil" => 2790),	"honey" => 160);
		self::$factories[3][16] = array("cooldown" => 108000, 	"cost" => array("windows" => 360,		"glasscutter" => 445,		"beam" => 395, 	"oil" => 3100),	"honey" => 170);
		self::$factories[3][17] = array("cooldown" => 118800, 	"cost" => array("windows" => 467,		"glasscutter" => 342,		"beam" => 451, 	"oil" => 3255),	"honey" => 180);
		self::$factories[3][18] = array("cooldown" => 129600, 	"cost" => array("windows" => 473,		"glasscutter" => 513,		"beam" => 454, 	"oil" => 3720),	"honey" => 190);
		self::$factories[3][19] = array("cooldown" => 182800, 	"cost" => array("windows" => 1000,		"glasscutter" => 1000, 		"beam" => 1000, "oil" => 8000),	"honey" => 200);

		self::$factories[4][1] = array("cooldown" => 3600, 		"cost" => array("brick" => 10,		"cement" =>  11,		"paint" =>	9,		"ore" => 10), 	"honey" => 10);
		self::$factories[4][2] = array("cooldown" => 7200, 		"cost" => array("brick" => 25,		"cement" =>  33,		"paint" =>	32,		"ore" => 20), 	"honey" => 15);
		self::$factories[4][3] = array("cooldown" => 10800, 	"cost" => array("brick" => 55,		"cement" =>  46,		"paint" =>	49,		"ore" => 30), 	"honey" => 25);
		self::$factories[4][4] = array("cooldown" => 14400, 	"cost" => array("brick" => 71,		"cement" =>  59,		"paint" =>	50,		"ore" => 40), 	"honey" => 35);
		self::$factories[4][5] = array("cooldown" => 18000, 	"cost" => array("brick" => 67,		"cement" =>  93,		"paint" =>	80,		"ore" => 50), 	"honey" => 45);
		self::$factories[4][6] = array("cooldown" => 21600, 	"cost" => array("brick" => 92,		"cement" =>  78,		"paint" =>	100,	"ore" => 60), 	"honey" => 55);
		self::$factories[4][7] = array("cooldown" => 28800, 	"cost" => array("brick" => 128,		"cement" =>  91,		"paint" =>	111,	"oil" => 850),	"honey" => 75);
		self::$factories[4][8] = array("cooldown" => 36000, 	"cost" => array("brick" => 111,		"cement" =>  132,		"paint" =>	147,	"oil" => 1005), "honey" => 85);
		self::$factories[4][9] = array("cooldown" => 43200, 	"cost" => array("brick" => 161,		"cement" =>  177,		"paint" =>	142,	"oil" => 1240), "honey" => 95);
		self::$factories[4][10] = array("cooldown" => 50400, 	"cost" => array("brick" => 152,		 "cement" => 201,		"paint" =>	187,	"oil" => 1395), "honey" => 110);
		self::$factories[4][11] = array("cooldown" => 57600, 	"cost" => array("brick" => 201,		 "cement" => 177,		"paint" =>	252,	"oil" => 1625), "honey" => 120);
		self::$factories[4][12] = array("cooldown" => 64800, 	"cost" => array("brick" => 277,		 "cement" => 252,		"paint" =>	191,	"oil" => 1860), "honey" => 130);
		self::$factories[4][13] = array("cooldown" => 75600, 	"cost" => array("brick" => 278,		 "cement" => 291,		"paint" =>	331,	"oil" => 2325),	"honey" => 140);
		self::$factories[4][14] = array("cooldown" => 86400, 	"cost" => array("brick" => 303,		 "cement" => 351,		"paint" =>	366,	"oil" => 2635),	"honey" => 150);
		self::$factories[4][15] = array("cooldown" => 97200, 	"cost" => array("brick" => 419,		 "cement" => 358,		"paint" =>	303,	"oil" => 2790),	"honey" => 160);
		self::$factories[4][16] = array("cooldown" => 108000, 	"cost" => array("brick" => 380,		 "cement" => 395,		"paint" =>	425,	"oil" => 3100),	"honey" => 170);
		self::$factories[4][17] = array("cooldown" => 118800, 	"cost" => array("brick" => 431,		 "cement" => 447,		"paint" =>	382,	"oil" => 3255),	"honey" => 180);
		self::$factories[4][18] = array("cooldown" => 129600, 	"cost" => array("brick" => 489,		 "cement" => 458,		"paint" =>	493,	"oil" => 3720),	"honey" => 190);
		self::$factories[4][19] = array("cooldown" => 182800, 	"cost" => array("brick" => 1000,	  "cement" => 1000,		"paint" =>	1000, 	"oil" => 8000),	"honey" => 200);

	}

	public function __construct() {
		self::initFeatures();
		self::initDirections();
		self::initModels();
		self::initFails();
		self::initImprovements();
		self::initGarage();
		self::initNumbers();
		self::initPetrol();
		self::initFactories();
		self::initResources();

		parent::__construct();
	}

	/**
	 * Проверка наличия ресурсов
	 */
	private function checkCost($cost) {
							/*"ore" => Page::$player->ore,
							"money" => Page::$player->money,
							"oil" => Page::$player->oil,
							"honey" => Page::$player->honey,*/
		$current = array(
							"rubber" => Page::$player2->a_rubber,
							"furnace" => Page::$player2->a_furnace,
							"pump" => Page::$player2->a_pump,
							"windows" => Page::$player2->a_windows,
							"glasscutter" => Page::$player2->a_glasscutter,
							"beam" => Page::$player2->a_beam,
							"brick" => Page::$player2->a_brick,
							"cement" => Page::$player2->a_cement,
							"paint" => Page::$player2->a_paint,
							"screw" => Page::$player2->a_screw,
							"draft" => Page::$player2->a_draft,
							"rasp" => Page::$player2->a_rasp
						);
		foreach ($cost as $k => $v) {
			if (isset($current[$k]) && $cost[$k] > $current[$k]) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Вычисление цены для продажи
	 */
	private function calculateSellCost($car) {
		$costCar = self::$models[$car["model"]]["cost"];
		foreach ($costCar as &$c) {
			$c = floor($c / 4);
		}
		$costImprovements = array();
		foreach (self::$improvements as &$improvement) {
			if (($car["improvements"] & $improvement["bit"]) == $improvement["bit"]) {
				foreach ($improvement["cost"] as $k => $v) {
					if (!isset($costImprovements[$k])) $costImprovements[$k] = 0;
					$costImprovements[$k] += $v;
				}
			}
		}
		foreach ($costImprovements as &$c) {
			$c = floor($c / 4);
		}
		foreach ($costImprovements as $k => $v) {
			if (!isset($costCar[$k])) $costCar[$k] = 0;
			$costCar[$k] += $v;
		}
		if (isset($costCar["honey"])) {
			$costCar["ore"] += $costCar["honey"];
			$costCar["honey"] = 0;
		}
		return $costCar;
	}

	/**
	 * Снятие/зачисление денег
	 */
	private function processMoney($cost, $withdraw = true) {
		if ($withdraw) $sign = "-"; else $sign = "+";
		//"ore" => "player", "money" => "player", "oil" => "player", "honey" => "honey",
		$type = array(
							"rubber" => "player2",
							"furnace" => "player2",
							"pump" => "player2",
							"windows" => "player2",
							"glasscutter" => "player2",
							"beam" => "player2",
							"brick" => "player2",
							"cement" => "player2",
							"paint" => "player2",
							"screw" => "player2",
							"draft" => "player2",
							"rasp" => "player2"
			);
		$player = array();
		$player2 = array();
		foreach ($cost as $k => $v) {
			switch ($type[$k]) {
				case "honey" :
					$takeResult = self::doBillingCommand(Page::$player->id, $v, "takemoney", "automobile");
					if ($takeResult[0] != "OK") {
						return false;
					}
					break;
				case "player" :
					$player[] = array("field" => $k, "value" => $v);
					break;
				case "player2" :
					$player2[] = array("field" => "a_" . $k, "value" => $v);
					break;
			}
		}
		if (!empty($player)) {
			$fields = array();
			foreach ($player as $field) {
				$fields[] = "`" . $field["field"] . "` = `" . $field["field"] . "` " . $sign . " " . $field["value"];
			}
			Page::$sql->query("UPDATE player SET " . implode("," , $fields) . " WHERE id = " . Page::$player->id);
		}
		if (!empty($player2)) {
			$fields = array();
			foreach ($player2 as $field) {
				$fields[] = "`" . $field["field"] . "` = `" . $field["field"] . "` " . $sign . " " . $field["value"];
			}
			Page::$sql->query("UPDATE player2 SET " . implode("," , $fields) . " WHERE player = " . Page::$player->id);
		}
		return true;
	}

	/**
	 * Генерация номера
	 */
	private function generateNumber($cool) {
		$count = Page::sqlGetCacheValue("SELECT count(1) FROM automobile_car_number WHERE busy = 0 AND cool = " . $cool . "", 3600, "automobile_car_number_cool_" . $cool);
		$offset = mt_rand(0, $count - 1);
		return Page::$sql->getValue("SELECT number FROM automobile_car_number WHERE busy = 0 AND cool = " . $cool . " LIMIT 1 OFFSET " . $offset);
	}

	/**
	 * Применение бонуса от поездки
	 */
	private function applyBonus($bonus, $directionId) {
		$bonuses = array();
		if (isset($bonus["stats"])) {
			$stats = array("attention", "resistance", "intuition", "health", "dexterity", "strength", "attention", "resistance", "intuition");
			$stats_percent = array("percent_dmg", "percent_defence", "percent_hit", "percent_dodge", "percent_crit", "percent_anticrit");

			Std::loadMetaObjectClass("playerboost2");
			$boost2 = new playerboost2Object();

			$boost2 = new playerboost2Object();
			$boost2->player = Page::$player->id;
			$boost2->subtype = "";
			$boost2->type = "automobile_ride";
			$boost2->code = $directionId;
			$boost2->standard_item = 0;

			$time = time();
			$boost2->dt = date("Y-m-d H:i:s", $time);
			if (isset($bonus["time"]) && !empty($bonus["time"])) {
				$boost2->dt2 = date("Y-m-d H:i:s", $time + $bonus["time"]);
			} else {
				$boost2->dt2 = date("2222-01-01 00:00:00");
			}

			$statsValue = array();
			$statsValue["type"] = "automobile_ride";
			foreach ($bonus["stats"] as $key => &$stat) {
				if ($key == self::BONUS_RANDOM) {
					$key = $stats[mt_rand(0, sizeof($stats) - 1)];
				} else if ($key == self::BONUS_RANDOM_PERCENT) {
					$key = $stats_percent[mt_rand(0, sizeof($stats_percent) - 1)];
				}
				$value = mt_rand($stat["min"], $stat["max"]);
				$bonuses[] = self::$features[$key] . ": +" . $value . "%";
				$boost2->{$key} = $value / 1000;
				$statsValue[$key] = $boost2->{$key};
			}
			Page::$player->calcStats($statsValue);
			$boost2->save();
		}
		return $bonuses;
	}

	private function checkNumber($number, $checkBusy = true) {
		$rec = Page::$sql->getRecord("SELECT * FROM automobile_car_number WHERE number = '" . Std::cleanString($number) . "'");
		if ($rec) {
			if (!$rec["busy"] || !$checkBusy) {
				return $rec["cool"];
			} else {
				return -1;
			}
		} else {
			return -2;
		}
	}

	private function actionCheckNumber() {
		$number = mb_strtoupper(Std::cleanString(trim(strip_tags($_POST["number"]))), "UTF-8");
		echo $this->checkNumber($number);
		die();
	}

	private function actionGenerateNumber() {
		$cool = intval($_POST["cool"]);
		$number = $this->generateNumber($cool);
		if ($number == false) {
			echo "0";
		} else {
			echo $number;
			//echo mb_substr($number, 0, 1, "UTF-8") . "<b>" . mb_substr($number, 1, 3, "UTF-8") . "</b>" . mb_substr($number, 4, 2, "UTF-8");;
		}
		die();
	}

	/**
	 * Покупка номера
	 */
	private function actionBuyNumber() {
		Page::startTransaction("automobile_buy_number", true);
		$cool = intval(trim($_POST["cool"]));
		$checkNumber = 0;
		if (intval($cool) && $cool > 0 && $cool < 7) {
			$number = $this->generateNumber($cool);
			if (!$number) {
				$checkNumber = -1;
			}
			$checkBusy = true;
		} else {
			$cool = false;
			$number = mb_strtoupper(Std::cleanString(trim(strip_tags($_POST["number"]))), "UTF-8");
			$checkBusy = false;
		}

		$carId = intval($_POST["car"]);
		$time = time();
		$car = Page::$sql->getRecord("SELECT * FROM automobile_car WHERE id = " . $carId . " AND player = " . Page::$player->id . " AND createdat < " . $time);
		if ($car) {

			if ($checkNumber == 0) {
				$checkNumber = $this->checkNumber($number, $checkBusy);
				if (!$cool && $checkNumber < 7) {
					Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
					Std::redirect("/automobile/car/" . $carId . "/");
					return false;
				}
			}

			if ($checkNumber >= 0) {
				$rearrange = false;
				if ($checkNumber < 7) {
					$cost = self::$numbers[$checkNumber]["cost"];
				} else {
					$cost = self::$numbers[$checkNumber]["cost"][$number];
					$numberRec = Page::$sql->getRecord("SELECT * FROM automobile_car_number WHERE number = '" . $number . "'");
					if ($numberRec["player"] == Page::$player->id) {
						$cost = array();
						if ($numberRec["busy"] == 1) {
							$cost = self::$numbers[1]["cost"];
							$rearrange = true;
						}
					} else {
						if ($numberRec["player"] > 0) {
							Page::addAlert(AutomobileLang::ALERT_GARAGE, AutomobileLang::MESSAGE_BUY_NUMBER_BUSY, ALERT_ERROR);
							return false;
						}
					}
				}
				if (!$cost || (Page::isEnoughMoney($cost) && Page::spendMoney($cost, true, $changes, "automobile_number"))) {
					$imp = array();
					if ($rearrange) {
						$unimp = array();
						foreach (self::$numbers[$checkNumber]["bonus"] as $key => $value) {
							$unimp[] = $key . "=" . $key . "-" . $value;
						}
						$newNumber = $this->generateNumber(1);
						$newNumberCool = $this->checkNumber($newNumber);
						foreach (self::$numbers[$newNumberCool]["bonus"] as $key => $value) {
							$unimp[] = $key . "=" . $key . "+" . $value;
						}
						$unimp = implode(",", $unimp);
						if (!empty($unimp)) $unimp = "," . $unimp;
						Page::$cache->delete("automobile_car_number_cool_" . $newNumberCool);
						Page::$sql->query("UPDATE automobile_car_number SET busy = 1 WHERE number = '" . $newNumber . "'");
						Page::$sql->query("UPDATE automobile_car SET number = '" . $newNumber . "'" . $unimp . " WHERE player = " . Page::$player->id . " AND number = '" . $number . "'");

					}
					if (!empty($car["number"])) {
						$oldNumberCool = $this->checkNumber($car["number"], false);
						Page::$sql->query("UPDATE automobile_car_number SET busy = 0 WHERE number = '" . $car["number"] . "'");
						Page::$cache->delete("automobile_car_number_cool_" . $oldNumberCool);
						foreach (self::$numbers[$oldNumberCool]["bonus"] as $key => $value) {
							$imp[] = $key . "=" . $key . "-" . $value;
						}
					}
					Page::$sql->query("UPDATE automobile_car_number SET busy = 1" . (($checkNumber == 7) ? ", dt = NOW(), player = " . Page::$player->id : "") . " WHERE number = '" . $number . "'");
					Page::$cache->delete("automobile_car_number_cool_" . $checkNumber);
					foreach (self::$numbers[$checkNumber]["bonus"] as $key => $value) {
						$imp[] = $key . "=" . $key . "+" . $value;
					}
					$imp = implode(",", $imp);
					if (!empty($imp)) $imp = "," . $imp;
					Page::$sql->query("UPDATE automobile_car SET number = '" . $number . "'" . $imp . " WHERE id = " . $carId);

					foreach($changes as &$val) { $val = abs($val); }
					if (!$cost) {
						Page::sendLog(self::$player->id, "automobile_change_number", array("carid" => $car["id"], "carname" => self::$models[$car["model"]]["name"], "number" => $number, "mbckp" => $this->getMbckp()), 1);
					} else {
						Page::sendLog(self::$player->id, "automobile_buy_number", array_merge($changes, array("carid" => $car["id"], "carname" => self::$models[$car["model"]]["name"], "number" => $number, "mbckp" => $this->getMbckp())), 1);
					}
					Page::addAlert(AutomobileLang::ALERT_GARAGE, AutomobileLang::MESSAGE_BUY_NUMBER_SUCCESS . "<div class=\"car-number-big\"><span class=\"car-number\">" . mb_substr($number, 0, 1, "UTF-8") . "<b>" . mb_substr($number, 1, 3, "UTF-8") . "</b>" . mb_substr($number, 4, 2, "UTF-8") . "</span></div>");
				} else {
					Page::addAlert(AutomobileLang::ALERT_GARAGE, AutomobileLang::MESSAGE_BUY_NUMBER_NO_MONEY, ALERT_ERROR);
				}
			} else {
				if ($checkNumber == -1) {
					//$checkNumber = $this->checkNumber($number, false);
					//$message = AutomobileLang::MESSAGE_BUY_NUMBER_BUSY;
					switch ($cool) {
						case 2:
							$message = AutomobileLang::MESSAGE_BUY_NUMBER_BUSY_2;
							break;
						case 3:
							$message = AutomobileLang::MESSAGE_BUY_NUMBER_BUSY_3;
							break;
						case 4:
							$message = AutomobileLang::MESSAGE_BUY_NUMBER_BUSY_4;
							break;
						case 5:
							$message = AutomobileLang::MESSAGE_BUY_NUMBER_BUSY_5;
							break;
						case 6:
							$message = AutomobileLang::MESSAGE_BUY_NUMBER_BUSY_6;
							break;
						case 1:
						default:
							$message = AutomobileLang::MESSAGE_BUY_NUMBER_BUSY_1;
							break;
					}
					Page::addAlert(AutomobileLang::ALERT_GARAGE, $message, ALERT_ERROR);
				}
				if ($checkNumber == -2) {
					Page::addAlert(AutomobileLang::ALERT_GARAGE, AutomobileLang::MESSAGE_BUY_NUMBER_INCORRECT, ALERT_ERROR);
				}
			}
			Page::endTransaction("automobile_buy_number", true);
			Std::redirect("/automobile/car/" . $carId . "/");
		} else {
			Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			Std::redirect("/automobile/");
		}
	}

	private function checkCarEnabled($automobile, $carLevel) {
		$time = time();
		if ($automobile["state"] == "upgrade_factory" && $automobile["cooldown"] >= $time) {
			$automobile["factory" . $automobile["stateparam"]]--;
		}
		if ($automobile && $automobile["factory1"] >= $carLevel && $automobile["factory2"] >= $carLevel && $automobile["factory3"] >= $carLevel && $automobile["factory4"] >= $carLevel) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * Постройка автомобиля
	 */
	private function actionCreateCar() {
		Page::startTransaction("automobile_create_car", true);
		$modelId = intval($this->url[1]);
		if (isset(self::$models[$modelId])) {
			$automobile = Page::sqlGetCacheRecord("SELECT * FROM automobile WHERE player = " . Page::$player->id, 1800, "automobile_automobile_" . Page::$player->id);
			if ($automobile) {
				$time = time();
				$carLevel = self::$models[$modelId]["level"];
				if ($this->checkCarEnabled($automobile, $carLevel)) {
					if ($automobile["cooldown"] < $time) {
						if (Page::$player2->garage > 0) {
							$carsCount = Page::$sql->getValue("SELECT COUNT(1) FROM automobile_car WHERE player = " . Page::$player->id);
							if (Page::$player2->garage > $carsCount) {
								if (Page::isEnoughMoney(self::$models[$modelId]["cost"]) && Page::spendMoney(self::$models[$modelId]["cost"], true, $changes, "automobile_car")) {
									//$number = $this->generateNumber(1);
									$createdat = $time + self::$models[$modelId]["productiontime"];
									$carid = Page::$sql->insert("
														INSERT INTO automobile_car(model,number,speed,controllability,passability,prestige,player,improvements,cooldown,rides,createdat)
														VALUES(
														" . $modelId . ",
														'',
														" . self::$models[$modelId]["speed"] . ",
														" . self::$models[$modelId]["controllability"] . ",
														" . self::$models[$modelId]["passability"] . ",
														" . self::$models[$modelId]["prestige"] . ",
														" . Page::$player->id . ",
														0,
														0,
														5,
														" . $createdat . "
														)");
									//Page::$sql->query("UPDATE automobile_car_number SET busy = 1 WHERE number = '" . $number . "'");
									//Page::$cache->delete("automobile_car_number_cool_1");
									Page::$sql->query("UPDATE automobile SET state = 'create_car', stateparam = " . $modelId . ", cooldown = " . $createdat . " WHERE player = " . Page::$player->id);
									Page::$cache->delete("automobile_automobile_" . Page::$player->id);

									if (!Page::$player2->car) {
										Page::$sql->query("UPDATE player2 SET car = (SELECT id FROM automobile_car WHERE player = " . Page::$player->id . " LIMIT 1) WHERE player = " . Page::$player->id);
									}
									foreach($changes as &$val) { $val = abs($val); }
									Page::sendLog(self::$player->id, "automobile_create_car", array_merge($changes, array("carname" => self::$models[$modelId]["name"], "mbckp" => $this->getMbckp())), 1);
									Page::$player->data["automobile_create_car"] = array("time" => $createdat, "model" => $modelId, "carid" => $carid);
									Page::$player->saveData();

								} else {
									Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::ERROR_NO_MONEY, ALERT_ERROR);
								}
							} else {
								Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::MESSAGE_CREATE_CAR_NO_PLACE, ALERT_ERROR);
							}
						} else {
							Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::MESSAGE_CREATE_CAR_NO_GARAGE, ALERT_ERROR);
						}
					} else {
						Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::MESSAGE_CREATE_CAR_COOLDOWN, ALERT_ERROR);
					}
				} else {
					Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
				}
			} else {
				Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			}
		} else {
			Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
		}
		Page::endTransaction("automobile_create_car", true);
		Std::redirect("/automobile/");
	}

	/**
	 * Продажа машины
	 */
	private function actionSellCar() {
		Page::startTransaction("automobile_sell_car", true);
		$carId = intval($_POST["car"]);
		if ($carId) {
			$car = Page::$sql->getRecord("SELECT * FROM automobile_car WHERE id = " . $carId . " AND player = " . Page::$player->id);
			if ($car) {
				if ($car["cooldown"] < time()) {
					$cost = $this->calculateSellCost($car);
					Page::giveMoney($cost, true, $changes);
					Page::$sql->query("DELETE FROM automobile_car WHERE id = " . $carId);
					Page::$sql->query("DELETE FROM automobile_ride WHERE car = " . $carId);
					if (Page::$player2->car == $carId) {
						Page::$sql->query("UPDATE player2 SET car = NULL WHERE player = " . Page::$player->id);
					}
					if (!empty($car["number"])) {
						Page::$sql->query("UPDATE automobile_car_number SET busy = 0 WHERE number = '" . $car["number"] . "'");
						Page::$cache->delete("automobile_car_number_cool_" . $this->checkNumber($car["number"], false));
					}
					Page::sendLog(self::$player->id, "automobile_sell_car", array_merge($cost, array("carname" => self::$models[$car["model"]]["name"], "mbckp" => $this->getMbckp())), 1);
					Page::addAlert(AutomobileLang::ALERT_GARAGE, AutomobileLang::MESSAGE_SELL_CAR_SUCCESS . " <b>" . self::$models[$car["model"]]["name"] . "</b>.", ALERT_INFO);
					Page::endTransaction("automobile_sell_car", true);
					Std::redirect("/home/");
				} else {
					Page::addAlert(AutomobileLang::ALERT_GARAGE, AutomobileLang::MESSAGE_SELL_CAR_COOLDOWN, ALERT_ERROR);
					Page::endTransaction("automobile_sell_car", true);
					Std::redirect("/automobile/car/" . $carId . "/");
				}
			} else {
				Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			}
		} else {
			Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
		}
		Page::endTransaction("automobile_sell_car", true);
		Std::redirect("/automobile/car/");
	}

	/**
	 * Заправка машины
	 */
	private function actionBuyPetrol() {
		Page::startTransaction("automobile_buy_petrol", true);
		$carId = intval($this->url[1]);
		if ($carId) {
			$car = Page::$sql->getRecord("SELECT * FROM automobile_car WHERE id = " . $carId . " AND player = " . Page::$player->id);
			if ($car) {
				if ($car["rides"] < 5) {
					$cost = self::$petrol[self::$models[$car["model"]]["petrol"]];
					if (Page::isEnoughMoney($cost) && Page::spendMoney($cost, true, $changes, "automobile_petrol")) {
						Page::$sql->query("UPDATE automobile_car SET rides = 5 WHERE id = " . $carId);
						Page::addAlert(AutomobileLang::ALERT_GARAGE, AutomobileLang::MESSAGE_BUY_PETROL_SUCCESS);
						foreach($changes as &$val) { $val = abs($val); }
						Page::sendLog(self::$player->id, "automobile_buy_petrol", array_merge($changes, array("carname" => self::$models[$car["model"]]["name"], "carid" => $car["id"], "mbckp" => $this->getMbckp())), 1);
					} else {
						Page::addAlert(AutomobileLang::ALERT_GARAGE, AutomobileLang::MESSAGE_BUY_PETROL_NO_MONEY);
					}
				} else {
					Page::addAlert(AutomobileLang::ALERT_GARAGE, AutomobileLang::MESSAGE_BUY_PETROL_ALREADY_FULL, ALERT_ERROR);
				}
				Page::endTransaction("automobile_buy_petrol", true);
				Std::redirect("/automobile/car/" . $car["id"] . "/");
			} else {
				Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			}
		} else {
			Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
		}
		Std::redirect("/automobile/");
	}

	/**
	 * Показывать тачку в профиле
	 */
	private function actionFavorite() {
		$carId = intval($this->url[1]);
		if ($carId) {
			$car = Page::$sql->getRecord("SELECT * FROM automobile_car WHERE id = " . $carId . " AND player = " . Page::$player->id);
			if ($car) {
				Page::$sql->query("UPDATE player2 SET car = " . $carId . " WHERE player = " . Page::$player->id);
				Page::addAlert(AutomobileLang::ALERT_GARAGE, AutomobileLang::MESSAGE_FAVORITE_SUCCESS);
				Std::redirect("/automobile/car/" . $carId . "/");
			} else {
				Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			}
		} else {
			Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
		}
		Std::redirect("/automobile/");
	}

	/**
	 * Апгрейд гаража
	 */
	private function actionUpgradeGarage() {
		Page::startTransaction("automobile_upgrade_garage", true);
		 if (Page::$player->level >= 7) {
			if (Page::$player2->garage < sizeof(self::$garage)) {
				$newGarage = Page::$player2->garage + 1;
				if (Page::isEnoughMoney(self::$garage[$newGarage]) && Page::spendMoney(self::$garage[$newGarage], true, $changes, "automobile_garage")) {
					Page::$sql->query("UPDATE player2 SET garage = " . $newGarage . " WHERE player = " . Page::$player->id);
					Page::addAlert(AutomobileLang::ALERT_GARAGE, AutomobileLang::MESSAGE_UPGRADE_GARAGE_SUCCESS);
					foreach($changes as &$val) { $val = abs($val); }
					Page::sendLog(self::$player->id, "automobile_upgrade_garage", array_merge($changes, array("mbckp" => $this->getMbckp())), 1);
				} else {
					Page::addAlert(AutomobileLang::ALERT_GARAGE, AutomobileLang::MESSAGE_UPGRADE_GARAGE_NO_MONEY, ALERT_ERROR);
				}
			} else {
				Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			}
		 } else {
			Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
		 }
		 Page::endTransaction("automobile_upgrade_garage", true);
		 Std::redirect("/home/");
	}

	/**
	 * Апгрейд цеха
	 */
	private function actionUpgradeFactory($factoryId = null, $nomoney  = false) {
		Page::startTransaction("automobile_upgrade_factory", true);
		if (!$factoryId) $factoryId = intval($this->url[1]);
		if (Page::$player->level >= 7) {
			if ($factoryId > 0 && $factoryId < 5) {
				$automobile = Page::sqlGetCacheRecord("SELECT * FROM automobile WHERE player = " . Page::$player->id, 1800, "automobile_automobile_" . Page::$player->id);
				if (!$automobile) {
					$automobile = array("player" => Page::$player->id, "factory1" => 0, "factory2" => 0, "factory3" => 0, "factory4" => 0, "state" => "", "stateparam" => 0, "cooldown" => 0);
					Page::$sql->query("INSERT INTO automobile(factory1,factory2,factory3,factory4,state,stateparam,cooldown,player) VALUES(0, 0, 0, 0, NULL, NULL, 0, " . Page::$player->id . ")");
					Page::$cache->delete("automobile_automobile_" . Page::$player->id);
				}
				$time = time();
				if ($automobile["cooldown"] < $time) {
					$maxLevel = sizeof(self::$factories[$factoryId]);
					if ($automobile["factory" . $factoryId] < $maxLevel) {
						$newLevel = $automobile["factory" . $factoryId] + 1;
						if ($nomoney || $this->checkCost(self::$factories[$factoryId][$newLevel]["cost"])) {
							$cost = array();
							foreach(self::$factories[$factoryId][$newLevel]["cost"] as $cur => $val) {
								if ($cur == "money" || $cur == "ore" || $cur == "oil" || $cur == "honey") {
									$cost[$cur] = $val;
								}
							}
							if ($nomoney || (Page::isEnoughMoney($cost) && Page::spendMoney($cost, true, $changes, "automobile_factory"))) {
								if (!is_array($changes)) $changes = array();
								if ($this->processMoney(self::$factories[$factoryId][$newLevel]["cost"])) {
									Page::$sql->query("UPDATE automobile SET factory" . $factoryId . " = " . $newLevel . ", stateparam = " . $factoryId . ", state = 'upgrade_factory', cooldown = " . ($time + self::$factories[$factoryId][$newLevel]["cooldown"]) . " WHERE player = " . Page::$player->id);
									Page::$cache->delete("automobile_automobile_" . Page::$player->id);

									Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::MESSAGE_UPGRADE_FACTORY_SUCCESS);
									foreach($changes as &$val) { $val = abs($val); }
									if (!$nomoney) Page::sendLog(self::$player->id, "automobile_upgrade_factory", array_merge($changes, array("factory" => self::$factoryType[$factoryId]["name"] . " [" . $newLevel . "]", "mbckp" => $this->getMbckp())), 1);
									Page::$player->data["automobile_upgrade_factory"] = array("time" => ($time + self::$factories[$factoryId][$newLevel]["cooldown"]), "level" => $newLevel, "factory" => $factoryId);
									Page::$player->saveData();
								} else {
									Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::MESSAGE_UPGRADE_FACTORY_NO_RES, ALERT_ERROR);
									// Этого не должно происходить т.к. только что проверили checkCost
								}
							} else {
								Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::MESSAGE_UPGRADE_FACTORY_NO_MONEY, ALERT_ERROR);
							}
						} else {
							Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::MESSAGE_UPGRADE_FACTORY_NO_RES, ALERT_ERROR);
						}
					} else {
						Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::MESSAGE_UPGRADE_FACTORY_ALREADY_BEST, ALERT_ERROR);
					}
				} else {
					Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::MESSAGE_UPGRADE_FACTORY_COOLDOWN, ALERT_ERROR);
				}
				Page::endTransaction("automobile_upgrade_factory", true);
				Std::redirect("/automobile/#progress");
			} else {
				Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
				Std::redirect("/automobile/");
			}
		} else {
			Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			Std::redirect("/automobile/");
		}
	}

	/**
	 * Апгрейд машины
	 */
	private function actionUpgradeCar() {
		Page::startTransaction("automobile_upgrade_car", true);
		$carId = intval($_POST["car"]);
		$improvementId = intval($_POST["part"]);
		if ($carId) {
			$car = Page::$sql->getRecord("SELECT * FROM automobile_car WHERE id = " . $carId . " AND player = " . Page::$player->id);
			if ($car) {
				$improvements = intval($car["improvements"]);
				if (($improvements & self::$improvements[$improvementId]["bit"]) == 0) {
						$automobile = Page::sqlGetCacheRecord("SELECT * FROM automobile WHERE player = " . Page::$player->id, 1800, "automobile_automobile_" . Page::$player->id);

						if (self::checkImprovementAvailability($automobile, self::$improvements[$improvementId])) {
							if (Page::isEnoughMoney(self::$improvements[$improvementId]["cost"]) && Page::spendMoney(self::$improvements[$improvementId]["cost"], true, $changes, "automobile_car_tuning")) {
								//$improvements += self::$improvements[$improvementId]["bit"];
								$imp = array();
								foreach (self::$improvements[$improvementId]["bonus"] as $key => $value) {
									$imp[] = $key . "=" . $key . "+" . $value;
								}
								if (isset(self::$improvements[$improvementId]["acts"]) && self::$improvements[$improvementId]["acts"] > 0) {
									$imp[] = "dt_" . self::$improvements[$improvementId]["bit"] . "=" . (time() + self::$improvements[$improvementId]["acts"]);
								}
								$imp = implode(",", $imp);
								if (!empty($imp)) $imp = "," . $imp;
								Page::$sql->query("UPDATE automobile_car SET improvements = improvements + " . self::$improvements[$improvementId]["bit"] . $imp . " WHERE id = " . $carId);
								foreach($changes as &$val) { $val = abs($val); }
								Page::sendLog(self::$player->id, "automobile_upgrade_car", array_merge($changes, array("carname" => self::$models[$car["model"]]["name"], "part" => self::$improvements[$improvementId]["name"], "carid" => $car["id"], "mbckp" => $this->getMbckp())), 1);
								Page::addAlert(AutomobileLang::ALERT_GARAGE, AutomobileLang::MESSAGE_UPGRADE_CAR_SUCCESS);
							} else {
								Page::addAlert(AutomobileLang::ALERT_GARAGE, AutomobileLang::MESSAGE_UPGRADE_CAR_NO_MONEY, ALERT_ERROR);
							}
						} else {
							Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
						}
				} else {
					Page::addAlert(AutomobileLang::ALERT_GARAGE, AutomobileLang::MESSAGE_UPGRADE_CAR_ALREADY_EXISTS, ALERT_ERROR);
				}
				Page::endTransaction("automobile_upgrade_car", true);
				Std::redirect("/automobile/car/" . $carId . "/");
			} else {
				Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			}
		} else {
			Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
		}
		Std::redirect("/automobile/");
	}

	/**
	 * Поездка
	 */
	private function actionRide() {
		Page::startTransaction("automobile_ride", true);
		$carId = intval($_POST["car"]);
		$directionId = intval($_POST["direction"]);
		if ($carId) {
			if ($directionId) {
				if (self::$directions[$directionId]) {
					$car = Page::$sql->getRecord("SELECT * FROM automobile_car WHERE id = " . $carId . " AND player = " . Page::$player->id);
					if ($car) {
						if (empty($car["number"])) {
							Page::addAlert(AutomobileLang::ALERT_RIDE, AutomobileLang::MESSAGE_RIDE_NUMBER, ALERT_ERROR, array(array("name" => AutomobileLang::MESSAGE_RIDE_TO_CAR, "url" => "/automobile/car/" . $car["id"])));
							Std::redirect("/automobile/ride");
						}
						$time = time();
						if ($car["cooldown"] < $time) {
							if ($car["rides"] > 0) {
								$ride = Page::$sql->getRecord("SELECT * FROM automobile_ride WHERE cooldown > " . $time . " AND player = " . Page::$player->id . " AND direction = " . $directionId);
								if (!$ride) {
									$failId = 0;
									$randFails = array_keys(self::$fails);
									shuffle($randFails);
									for ($i = 1; $i < sizeof(self::$fails); $i++) {
										if (self::$fails[$randFails[$i]]["probability"] >= mt_rand(1, 100)) {
											$failId = self::$fails[$randFails[$i]]["id"];
											break;
										}
									}
									Page::$sql->query("UPDATE automobile_car SET cooldown = " . ($time + self::$models[$car["model"]]["cooldown"]) . ", rides = rides - 1 WHERE id = " . $carId);

									$failMessage = "";
									$cooldown = self::$directions[$directionId]["time"];
									if ($failId > 0) {
										$cooldown += self::$fails[$failId]["time"];
										$failMessage = "<p class=\"hint\">" . self::$fails[$failId]["text"] . " <span class=\"error\">(+" . Std::formatPeriod(self::$fails[$failId]["time"]) . ")</span></p>";
									}

									// Применяем уменьшители времени поездок
									$cooldown -= $this->calculateTimeDecrease($car);

									Page::$sql->query("INSERT INTO automobile_ride(direction,player,car,fail,cooldown) VALUES (" . $directionId . ", " . Page::$player->id . ", " . $carId . ", " . $failId . ", " . ($cooldown + $time) . ")");
									$bonuses = $this->applyBonus(self::$directions[$directionId]["bonus"], $directionId);
									$text = "
									<div class='auto-trip-result'>
										<p class='bonus'>
											<b>" . AutomobileLang::MESSAGE_RIDE_SUCCESS_BONUS . Std::formatPeriod(self::$directions[$directionId]["bonus"]["time"]) . ":</b><br />
											" . implode("<br />", $bonuses) . "
										</p>
										<div class='pic'>
											<img src='" . self::$directions[$directionId]["image"] . ".jpg'>
											<i class='icon-ok-tick'></i>
										</div>
										" . $failMessage . "
										<p>" . AutomobileLang::MESSAGE_RIDE_SUCCESS_RIDE . "<b class='trip-name'>" . self::$directions[$directionId]["name"] . "</b>" . AutomobileLang::MESSAGE_RIDE_SUCCESS_RIDE_AVAILABLE . "<b>" . Std::formatPeriod($cooldown) . "</b></p>
										<p>" . AutomobileLang::MESSAGE_RIDE_SUCCESS_CAR . "<b>" . self::$models[$car["model"]]["name"] . "</b>" . AutomobileLang::MESSAGE_RIDE_SUCCESS_CAR_AVAILABLE . "<b>" . Std::formatPeriod(self::$models[$car["model"]]["cooldown"]) . "</b></p>
									</div>
									";

									Page::sendLog(self::$player->id, "automobile_ride", array("dir" => self::$directions[$directionId]["name"], "mbckp" => $this->getMbckp()), 1);
									Page::addAlert(AutomobileLang::MESSAGE_RIDE_SUCCESS, $text, ALERT_INFO, array(array("name" => AutomobileLang::MESSAGE_RIDE_SUCCESS_YAHOO, "default" => true)));
									Page::checkEvent(Page::$player->id, "automobile_ride");
								} else {
									Page::addAlert(AutomobileLang::ALERT_RIDE, AutomobileLang::MESSAGE_RIDE_COOLDOWN, ALERT_ERROR);
								}
							} else {
								Page::addAlert(AutomobileLang::ALERT_RIDE, AutomobileLang::MESSAGE_RIDE_NO_PETROL, ALERT_ERROR);
							}
						} else {
							Page::addAlert(AutomobileLang::ALERT_RIDE, AutomobileLang::MESSAGE_RIDE_CAR_COOLDOWN, ALERT_ERROR);
						}
					} else {
						Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
					}
				} else {
					Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
				}
			} else {
				Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			}
		} else {
			Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
		}
		Page::endTransaction("automobile_ride", true);
		Std::redirect("/automobile/ride");
	}

	private function actionBuyPart() {
		Page::startTransaction("automobile_buy_part", true);
		$part = $this->url[1];
		if (isset(self::$resources[$part]) && is_array(self::$resources[$part])) {
			$cost = array("honey" => self::$resources[$part]["honey"]);
			if (Page::isEnoughMoney($cost) && Page::spendMoney($cost, true, $changes, "automobile_factory_part")) {
				Page::$sql->query("UPDATE player2 SET a_" . $part . " = a_" . $part . " + 1 WHERE player = " . Page::$player->id);
				foreach($changes as &$val) { $val = abs($val); }
				Page::sendLog(self::$player->id, "automobile_buy_part", array_merge($changes, array("count" => 1, "image" => self::$resources[$part]["image"], "name" => self::$resources[$part]["name"], "part", "mbckp" => $this->getMbckp())), 1);
			} else {
				Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::ERROR_NO_HONEY_TEXT, ALERT_ERROR);
			}
		} else {
			Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
		}
		Page::endTransaction("automobile_buy_part", true);
		Std::redirect($_SERVER["HTTP_REFERER"]);
	}

	private function actionFinishBuilding() {
		Page::startTransaction("automobile_finish_building", true);
		$automobile = Page::sqlGetCacheRecord("SELECT * FROM automobile WHERE player = " . Page::$player->id, 1800, "automobile_automobile_" . Page::$player->id);

		if ($automobile) {
			$time = time();
			if ($automobile["cooldown"] >= $time && $automobile["state"] == "upgrade_factory") {
				$cost = array("honey" => self::$factories[$automobile["stateparam"]][$automobile["factory" . $automobile["stateparam"]]]["honey"]);
				if ($cost["honey"] && (!isset(Page::$player->data["automobile_upgrade_factory_count"]) || !is_array(Page::$player->data["automobile_upgrade_factory_count"]) || Page::$player->data["automobile_upgrade_factory_count"]["date"] != date("d.m.Y") || Page::$player->data["automobile_upgrade_factory_count"]["count"] < 4)) {
					if (Page::isEnoughMoney($cost) && Page::spendMoney($cost, true, $changes, "automobile_finish_building")) {
						Page::$sql->query("UPDATE automobile SET cooldown = 0 WHERE player = " . Page::$player->id);
						Page::$cache->delete("automobile_automobile_" . Page::$player->id);

						foreach($changes as &$val) { $val = abs($val); }
						Page::sendLog(self::$player->id, "automobile_finish_building", array_merge($changes, array("factory" => self::$factoryType[$automobile["stateparam"]]["name"] . " [" . $automobile["factory" . $automobile["stateparam"]] . "]", "mbckp" => $this->getMbckp())), 1);
						Page::$player->data["automobile_upgrade_factory"]["time"] = time();
						if (!isset(Page::$player->data["automobile_upgrade_factory_count"]) && !is_array(Page::$player->data["automobile_upgrade_factory_count"])) {
							Page::$player->data["automobile_upgrade_factory_count"] = array("count" => 0, "date" => date("d.m.Y"));
						}
						if (Page::$player->data["automobile_upgrade_factory_count"]["date"] != date("d.m.Y")) {
							Page::$player->data["automobile_upgrade_factory_count"]["date"] = date("d.m.Y");
							Page::$player->data["automobile_upgrade_factory_count"]["count"] = 0;
						}
						Page::$player->data["automobile_upgrade_factory_count"]["count"]++;
						
						Page::$player->saveData();
					} else {
						Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::ERROR_NO_HONEY_TEXT, ALERT_ERROR);
					}
				} else {
					Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
				}
			} else {
				Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			}
		} else {
			Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
		}
		Page::endTransaction("automobile_finish_building", true);
		Std::redirect("/automobile/");
	}

	private function actionBuyParts() {
		Page::startTransaction("automobile_buy_parts", true);
		$factory = intval($this->url[1]);
		if (isset(self::$factories[$factory]) && is_array(self::$factories[$factory])) {
			$automobile = Page::sqlGetCacheRecord("SELECT * FROM automobile WHERE player = " . Page::$player->id, 1800, "automobile_automobile_" . Page::$player->id);

			$time = time();
			if (!$automobile || $automobile["cooldown"] < $time) {
				if ($automobile) {
					$level = intval($automobile["factory" . $factory]);
				} else {
					$level = 0;
				}
				$partsCount = array();

				$newLevel = $automobile["factory" . $factory] + 1;
				$cost = array("honey" => $this->countHoneyParts($factory, $level + 1, $partsCount));
				foreach(self::$factories[$factory][$newLevel]["cost"] as $cur => $val) {
					if ($cur == "money" || $cur == "ore" || $cur == "oil" || $cur == "honey") {
						if (!isset($cost[$cur])) $cost[$cur] = 0;
						$cost[$cur] += $val;
					}
				}

				if ($cost["honey"] > 0) {
					if (Page::isEnoughMoney($cost) && Page::spendMoney($cost, true, $changes, "automobile_factory_parts")) {
						$logParts = array();
						$parts = array();
						foreach ($partsCount as $part => $count) {
							$parts[] = "a_" . $part . " = a_" . $part . " + " . $count;
							$logParts[] = array("count" => $count, "image" => self::$resources[$part]["image"], "name" => self::$resources[$part]["name"]);
						}

						Page::$sql->query("UPDATE player2 SET " . implode(",", $parts) . " WHERE player = " . Page::$player->id);
						foreach($changes as &$val) { $val = abs($val); }
						Page::sendLog(self::$player->id, "automobile_buy_parts", array_merge($changes, array("factory" => self::$factoryType[$factory]["name"] . " [" . $newLevel . "]", "parts" => $logParts, "mbckp" => $this->getMbckp())), 1);
						$this->actionUpgradeFactory($factory, true);
					} else {
						Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::ERROR_NO_HONEY_TEXT, ALERT_ERROR);
					}
				}
			} else {
				Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::MESSAGE_UPGRADE_FACTORY_COOLDOWN, ALERT_ERROR);
			}
		} else {
			Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
		}
		Page::endTransaction("automobile_buy_parts", true);
		Std::redirect($_SERVER["HTTP_REFERER"]);
	}

	private function getMaxImprovements($model) {
		$improvements = array();
		$improvements["speed"] = self::$models[$model]["speed"];
		$improvements["controllability"] = self::$models[$model]["controllability"];
		$improvements["passability"] = self::$models[$model]["passability"];
		$improvements["prestige"] = self::$models[$model]["prestige"];
		foreach (self::$improvements as $imp) {
			$improvements["speed"] += $imp["bonus"]["speed"];
			$improvements["controllability"] += $imp["bonus"]["controllability"];
			$improvements["passability"] += $imp["bonus"]["passability"];
			$improvements["prestige"] += $imp["bonus"]["prestige"];
		}
		$improvements["speed"] += self::$numbers[5]["bonus"]["speed"];
		$improvements["controllability"] += self::$numbers[5]["bonus"]["controllability"];
		$improvements["passability"] += self::$numbers[5]["bonus"]["passability"];
		$improvements["prestige"] += self::$numbers[5]["bonus"]["prestige"];
		return $improvements;
	}

	public static function newImprovements(&$automobile, $factory, $level) {
		$imps = array();
		foreach (self::$improvements as $id => &$imp) {
			if (self::checkImprovementAvailability($automobile, $imp)) {
				if ($imp["factory"] > 0) {
					if ($imp["factory"] == $factory && $imp["factory_level"] == $level) {
						$imps[] = $id;
					}
				} else {
					if ($imp["factory_level"] == $level) {
						$imps[] = $id;
					}
				}
			}
		}
		return $imps;
	}

	public static function checkImprovementAvailability(&$automobile, &$imp) {
		if ($imp["factory"] > 0) {
			if ($automobile["factory" . $imp["factory"]] >= $imp["factory_level"]) {
				return true;
			} else {
				return false;
			}
		} else {
			if ($automobile["factory1"] >= $imp["factory_level"] && $automobile["factory2"] >= $imp["factory_level"] && $automobile["factory3"] >= $imp["factory_level"] && $automobile["factory4"] >= $imp["factory_level"]) {
				return true;
			} else {
				return false;
			}
		}
	}

	private function getCarNeeds(&$automobile, $carLevel) {
		$time = time();
		if ($automobile["state"] == "upgrade_factory" && $automobile["cooldown"] >= $time) {
			$automobile["factory" . $automobile["stateparam"]]--;
		}
		if ($automobile && $automobile["factory1"] >= $carLevel && $automobile["factory2"] >= $carLevel && $automobile["factory3"] >= $carLevel && $automobile["factory4"] >= $carLevel) {
			return array();
		} else {
			$needs = array();
			if ($automobile["factory1"] < $carLevel) {
				$needs[] = self::$factoryType[1]["name"] . " [" . $carLevel . "]";
			}
			if ($automobile["factory2"] < $carLevel) {
				$needs[] = self::$factoryType[2]["name"] . " [" . $carLevel . "]";
			}
			if ($automobile["factory3"] < $carLevel) {
				$needs[] = self::$factoryType[3]["name"] . " [" . $carLevel . "]";
			}
			if ($automobile["factory4"] < $carLevel) {
				$needs[] = self::$factoryType[4]["name"] . " [" . $carLevel . "]";
			}
			return $needs;
		}
	}

	private function getImprovementNeeds(&$automobile, &$imp) {
		if ($imp["factory"] > 0) {
			if ($automobile["factory" . $imp["factory"]] >= $imp["factory_level"]) {
				return array();
			} else {
				return array(self::$factoryType[$imp["factory"]]["name"] . " [" . $imp["factory_level"] . "]");
			}
		} else {
			if ($automobile["factory1"] >= $imp["factory_level"] && $automobile["factory2"] >= $imp["factory_level"] && $automobile["factory3"] >= $imp["factory_level"] && $automobile["factory4"] >= $imp["factory_level"]) {
				return array();
			} else {
				$needs = array();
				if ($automobile["factory1"] < $imp["factory_level"]) {
					$needs[] = self::$factoryType[1]["name"] . " [" . $imp["factory_level"] . "]";
				}
				if ($automobile["factory2"] < $imp["factory_level"]) {
					$needs[] = self::$factoryType[2]["name"] . " [" . $imp["factory_level"] . "]";
				}
				if ($automobile["factory3"] < $imp["factory_level"]) {
					$needs[] = self::$factoryType[3]["name"] . " [" . $imp["factory_level"] . "]";
				}
				if ($automobile["factory4"] < $imp["factory_level"]) {
					$needs[] = self::$factoryType[4]["name"] . " [" . $imp["factory_level"] . "]";
				}
				return $needs;
			}
		}

	}

	private function showCar() {
		if (Page::$player->level < 7) {
			Std::redirect("/automobile/");
		}
		$this->content["window-name"] = AutomobileLang::WINDOW_NAME;
		$id = intval($this->url[1]);
		$automobile = Page::sqlGetCacheRecord("SELECT * FROM automobile WHERE player = " . Page::$player->id, 1800, "automobile_automobile_" . Page::$player->id);

		$car = Page::$sql->getRecord("SELECT * FROM automobile_car WHERE id = " . $id . " AND player = "  . Page::$player->id);
		if ($car) {
			$this->content["sell_cost"] = $this->calculateSellCost($car);
			$petrol = self::$models[$car["model"]]["petrol"];
			foreach (self::$petrol[$petrol] as $type => $cost) {
				switch ($type) {
					case "ore" :
						$type = "ruda";
						break;
					case "oil" :
						$type = "neft";
						break;
				}
				$this->content["petrol"] = array("type" => $type, "cost" => $cost);
				break;
			}
			$maxImprovements = $this->getMaxImprovements($car["model"]);
			$car["number_cool"] = $this->checkNumber($car["number"], false);
			$car["speed_percent"] = round(100 / $maxImprovements["speed"] * self::$models[$car["model"]]["speed"]);
			$car["controllability_percent"] = round(100 / $maxImprovements["controllability"] * self::$models[$car["model"]]["controllability"]);
			$car["passability_percent"] = round(100 / $maxImprovements["passability"] * self::$models[$car["model"]]["passability"]);
			$car["prestige_percent"] = round(100 / $maxImprovements["prestige"] * self::$models[$car["model"]]["prestige"]);

			$car["speed_percent2"] = round(100 / $maxImprovements["speed"] * $car["speed"]) - $car["speed_percent"];
			$car["controllability_percent2"] = round(100 / $maxImprovements["controllability"] * $car["controllability"]) - $car["controllability_percent"];
			$car["passability_percent2"] = round(100 / $maxImprovements["passability"] * $car["passability"]) - $car["passability_percent"];
			$car["prestige_percent2"] = round(100 / $maxImprovements["prestige"] * $car["prestige"]) - $car["prestige_percent"];

			$car["favorite"] = (Page::$player2->car == $car["id"]) ? 1 : 0;
			$car["rides_percent"] = round(100 / 5 * $car["rides"]);
			$car["image"] = self::$models[$car["model"]]["image"];
			$car["name"] = self::$models[$car["model"]]["name"];
			$car["description"] = self::$models[$car["model"]]["description"];
			$car["strip_number"] = $car["number"];
			$car["number"] = mb_substr($car["number"], 0, 1, "UTF-8") . "<b>" . mb_substr($car["number"], 1, 3, "UTF-8") . "</b>" . mb_substr($car["number"], 4, 2, "UTF-8");
			$this->content["car"] = $car;
			$this->content["improvements"] = array();
			foreach(self::$improvements as $id => $imp) {
				$imp["id"] = $id;
				$imp["available"] = self::checkImprovementAvailability($automobile, $imp);
				$imp["exists"] = (($car["improvements"] & $imp["bit"]) == $imp["bit"]) ? 1 : 0;
				if (!empty($imp["description"])) $imp["description"] .= "<br />";
				foreach ($imp["bonus"] as $stat => $value) {
					if ($value > 0) $imp["description"] .= "<span class=\"brown\">" . self::$features[$stat] . ": +" . $value . "</span><br />";
				}

				if ($imp["time"] > 0) $imp["description"] .= "<span class=\"brown\">" . self::$features["ride_time"] . ": -" . Std::formatPeriod($imp["time"]) . "</span><br />";

				if (isset($imp["acts"]) && $imp["acts"] > 0) {
					$imp["description"] .= "<span class=\"brown\">" . self::$features["acts"] . ": " . Std::formatPeriod($imp["acts"]) . "</span><br />";
					if ($imp["exists"] == 1) {
						$left = $car["dt_" . $imp["bit"]] - time();
						if ($left > 0) {
							$imp["description"] .= "<br /><span class=\"success\">" . self::$features["left"] . ": " . Std::formatPeriod($left) . "</span><br />";
						}
					}
				}

				if (!$imp["available"]) {
					$imp["description"] .= "<br />";
					$imp["description"] .= "<div class=\"error\">" . AutomobileLang::PART_NEED_TO_BUY . "<br />";
					$imp["description"] .= "<b>" . implode("</b><br /><b>", $this->getImprovementNeeds($automobile, $imp)) . "</b>";
					$imp["description"] .= "</div>";
				} else {
					if (!$imp["exists"]) {
						$imp["description"] .= "<br />";
						$imp["description"] .= "<div class=\"success\">" . AutomobileLang::PART_ALLOW . "</div>";
					}
				}
				foreach($imp["cost"] as $type => $value) {
					switch ($type) {
						case "ore" :
							$type = "ruda";
							break;
						case "oil" :
							$type = "neft";
							break;
						case "honey" :
							$type = "med";
							break;
					}
					$imp["cost"] = "<span class=\"" . $type . "\">" . $value . "<i></i></span>";
					break;
				}

				$this->content["improvements"][] = $imp;
			}

			$this->content["numbers"] = array();
			foreach(self::$numbers as $cool => $number) {
				if ($cool < 7) {
					foreach($number["cost"] as $type => $value) {
						switch ($type) {
							case "ore" :
								$type = "ruda";
								break;
							case "oil" :
								$type = "neft";
								break;
							case "honey" :
								$type = "med";
								break;
						}
						$number["cost"] = array("type" => $type, "value" => $value);
						break;
					}

					$bonus = array();
					foreach ($number["bonus"] as $key => $value) {
						$bonus[] = self::$features[$key] . " +" . $value;
					}
					$number["bonus"] = implode(", ", $bonus);
					$this->content["numbers"][] = $number;
				}
			}
			$this->content["vipnumbers"] = array();
			$vipNumbers = Page::$sql->getRecordSet("SELECT * FROM automobile_car_number WHERE cool = 7");
			$vipNumbersIndex = array();
			foreach ($vipNumbers as &$vipNumber) {
				$vipNumbersIndex[$vipNumber["number"]] = $vipNumber;
			}

			foreach (self::$numbers[7]["cost"] as $number => $cost) {
				if($vipNumbersIndex[$number]["player"]) {
					$player = Page::sqlGetCacheRecord("SELECT p.id id, p.nickname, p.level, p.fraction, c.name as clan_name,
					IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan
					FROM player p LEFT JOIN clan as c ON p.clan = c.id
					WHERE p.id = " . $vipNumbersIndex[$number]["player"], 1800 + mt_rand(0, 1800));
				} else {
					$player = 0;
				}
				if ($player != 0 && $player["id"] == Page::$player->id) {
					$cost = self::$numbers[1]["cost"];
				}
				$this->content["vipnumbers"][] = array("date" => ($vipNumbersIndex[$number]["dt"]) ? date("d.m.Y", strtotime($vipNumbersIndex[$number]["dt"])) : "", "busy" => $vipNumbersIndex[$number]["busy"], "number" => $number, "fnumber" => mb_substr($number, 0, 1, "UTF-8") . "<b>" . mb_substr($number, 1, 3, "UTF-8") . "</b>" . mb_substr($number, 4, 2, "UTF-8"), "cost" => $cost, "player" => $player);
			}
			$this->page->addPart("content", "automobile/car.xsl", $this->content);
		} else {
			Std::redirect("/automobile");
		}
	}

	private function showAutomobile() {
		$this->content["window-name"] = AutomobileLang::WINDOW_NAME;
		$this->content["cars"] = array();

		$automobile = Page::sqlGetCacheRecord("SELECT * FROM automobile WHERE player = " . Page::$player->id, 1800, "automobile_automobile_" . Page::$player->id);

		/*
		if (isset(Page::$player->data["automobile_upgrade_factory"]) && is_array(Page::$player->data["automobile_upgrade_factory"]) && Page::$player->data["automobile_upgrade_factory"]["time"] <= time()) {
			$imps = $this->newImprovements($automobile, Page::$player->data["automobile_upgrade_factory"]["factory"], Page::$player->data["automobile_upgrade_factory"]["level"]);
			if (sizeof($imps) > 0) {
				Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::MESSAGE_UPGRADE_FACTORY_CONGRATULATIONS . "<b>" . self::$factoryType[Page::$player->data["automobile_upgrade_factory"]["factory"]]["name"] . " [" . Page::$player->data["automobile_upgrade_factory"]["level"] . "]" . "</b>" . AutomobileLang::MESSAGE_UPGRADE_FACTORY_COMPLETE . " " . AutomobileLang::MESSAGE_UPGRADE_FACTORY_NEW_IMPROVEMENT . "<b>«" . self::$improvements[$imps[0]]["name"] . "»</b>" . AutomobileLang::MESSAGE_UPGRADE_FACTORY_CHECK_GARAGE);
			} else {
				Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::MESSAGE_UPGRADE_FACTORY_CONGRATULATIONS . "<b>" . self::$factoryType[Page::$player->data["automobile_upgrade_factory"]["factory"]]["name"] . " [" . Page::$player->data["automobile_upgrade_factory"]["level"] . "]" . "</b>" . AutomobileLang::MESSAGE_UPGRADE_FACTORY_COMPLETE);
			}
			Page::$player->data["automobile_upgrade_factory"] = null;
			Page::$player->saveData();
		}
		*/

		$levels = array(0, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3);
		$time = time();
		$cooldown = array("end" => 0, "honey" => 0);
		if ($automobile) {
			$this->content["factory_1"] = $automobile["factory1"];
			$this->content["factory_2"] = $automobile["factory2"];
			$this->content["factory_3"] = $automobile["factory3"];
			$this->content["factory_4"] = $automobile["factory4"];
			$this->content["state"] = $automobile["state"];
			if ($automobile["cooldown"] >= $time) {
				switch($automobile["state"]) {
					case "upgrade_factory" :
						$factory = $automobile["stateparam"];
						$cooldown["progress"] = self::$factoryType[$automobile["stateparam"]]["name"] . " [" . $this->content["factory_" . $factory] . "]";
						if ((!isset(Page::$player->data["automobile_upgrade_factory_count"]) || !is_array(Page::$player->data["automobile_upgrade_factory_count"]) || Page::$player->data["automobile_upgrade_factory_count"]["date"] != date("d.m.Y") || Page::$player->data["automobile_upgrade_factory_count"]["count"] < 4)) {
							$cooldown["honey"] = self::$factories[$factory][$this->content["factory_" . $factory]]["honey"];
						}
						$cooldown["total"] = self::$factories[$factory][$this->content["factory_" . $factory]]["cooldown"];
						$this->content["factory_" . $factory]--;
						break;
					case "create_car" :
						$cooldown["progress"] = self::$models[$automobile["stateparam"]]["name"];
						$cooldown["total"] = self::$models[$automobile["stateparam"]]["productiontime"];
						break;
				}
				$cooldown["end"] = $automobile["cooldown"];
				$cooldown["rest"] = $automobile["cooldown"] - $time;
			}
		} else {
			$this->content["factory_1"] = 0;
			$this->content["factory_2"] = 0;
			$this->content["factory_3"] = 0;
			$this->content["factory_4"] = 0;
		}
		$this->content["cooldown"] = $cooldown;
		$this->content["factory_1_level"] = $levels[$this->content["factory_1"]];
		$this->content["factory_2_level"] = $levels[$this->content["factory_2"]];
		$this->content["factory_3_level"] = $levels[$this->content["factory_3"]];
		$this->content["factory_4_level"] = $levels[$this->content["factory_4"]];
		$this->content["factory_1_name"] = self::$factoryType[1]["name"];
		$this->content["factory_2_name"] = self::$factoryType[2]["name"];
		$this->content["factory_3_name"] = self::$factoryType[3]["name"];
		$this->content["factory_4_name"] = self::$factoryType[4]["name"];
		$this->content["factory_1_description"] = self::$factoryType[1]["description"];
		$this->content["factory_2_description"] = self::$factoryType[2]["description"];
		$this->content["factory_3_description"] = self::$factoryType[3]["description"];
		$this->content["factory_4_description"] = self::$factoryType[4]["description"];

		$this->content["available"] = 0;
		foreach (self::$models as $model) {
			$car = array();
			$car["id"] = $model["id"];
			$car["image"] = $model["image"];
			$car["name"] = $model["name"];
			$car["disabled"] = !$this->checkCarEnabled($automobile, $model["level"]);
			$car["description"] = $model["description"];
			if (!$car["disabled"]) {
				if (!empty($car["description"])) $car["description"] .= "<br />";
				$car["description"] .= "<span class=\"brown\">" . AutomobileLang::STAT_SPEED . ": " . $model["speed"] . "</span><br />";
				$car["description"] .= "<span class=\"brown\">" . AutomobileLang::STAT_CONTROLLABILITY . ": " . $model["controllability"] . "</span><br />";
				$car["description"] .= "<span class=\"brown\">" . AutomobileLang::STAT_PASSABILITY . ": " . $model["passability"] . "</span><br />";
				$car["description"] .= "<span class=\"brown\">" . AutomobileLang::STAT_PRESTIGE . ": " . $model["prestige"] . "</span><br />";
			} else {
				$this->content["available"] = 1;
				if (!empty($car["description"])) $car["description"] .= "<br />";
				$car["description"] .= "<div class=\"error\">" . AutomobileLang::FACTORY_NEED_TO_BUILD . "<br />";
				$car["description"] .= "<b>" . implode("</b><br /><b>", $this->getCarNeeds($automobile, $model["level"])) . "</b>";
				$car["description"] .= "</div>";
			}
			$car["cost"] = $model["cost"];
			$this->content["cars"][] = $car;
		}
		$this->content["available"] = Page::$player->level >= 7 ? 1 : 0;

		$this->page->addPart("content", "automobile/automobile.xsl", $this->content);
	}

	private function calculateTimeDecrease($car) {
		$decrease = 0;
		foreach (self::$improvements as $imp) {
			if (($car["improvements"] & $imp["bit"]) == $imp["bit"]) {
				$decrease += $imp["time"];
			}
		}
		return $decrease;
	}

	public static function getCarsByPlayerId($playerId, $sort = 1) {
		$cars = Page::$sql->getRecordSet("SELECT * FROM automobile_car WHERE player = " . $playerId);
		if ($cars) {
			$time = time();
			foreach ($cars as $k => &$car) {
				if ($car["createdat"] >= $time) {
					unset($cars[$k]);
				}
			}
			Std::sortRecordSetByField($cars, "model", $sort);
		}
		return $cars;
	}

	private function showRide() {
		if (Page::$player->level < 7) {
			Std::redirect("/automobile/");
		}
		$this->content["window-name"] = AutomobileLang::WINDOW_NAME;
		$this->content["rides"] = array();
		$this->content["cars"] = array();

		$cars = self::getCarsByPlayerId(Page::$player->id, 1);

		$carsIndex = array();
		$time = time();
		$maxLevel = 0;
		if (is_array($cars)) {
			foreach ($cars as $car) {
				if ($car["cooldown"] < $time) {
					$car["cooldown"] = array("end" => 0);
				} else {
					$car["cooldown"] = array("end" => $car["cooldown"], "rest" => $car["cooldown"] - $time);
				}
				$car["stats"] = "";
				$car["name"] = self::$models[$car["model"]]["name"];
				$car["description"] = self::$models[$car["model"]]["description"];
				if (!empty($car["description"])) $car["stats"] .= "<br />";
				$car["stats"] .= "<span class=\"brown\">" . self::$features["speed"] . ": " . $car["speed"] . "</span><br />";
				$car["stats"] .= "<span class=\"brown\">" . self::$features["controllability"] . ": " . $car["controllability"] . "</span><br />";
				$car["stats"] .= "<span class=\"brown\">" . self::$features["passability"] . ": " . $car["passability"] . "</span><br />";
				$car["stats"] .= "<span class=\"brown\">" . self::$features["prestige"] . ": " . $car["prestige"] . "</span><br />";

				$car["image"] = self::$models[$car["model"]]["image"];
				$car["level"] = self::$models[$car["model"]]["level"];
				$decrease = $this->calculateTimeDecrease($car);
				$car["decrease"] = "";
				if ($decrease > 0) {
					$car["decrease"] = "-" . Std::formatPeriod($decrease);
				}
				$this->content["cars"][] = $car;
				$carsIndex[self::$models[$car["model"]]["level"]] = $car;
				if ($maxLevel < self::$models[$car["model"]]["level"]) $maxLevel = self::$models[$car["model"]]["level"];
			}
		} else {
			$cars = array();
		}

		$rides = Page::$sql->getRecordSet("SELECT direction,cooldown FROM automobile_ride WHERE cooldown > " . $time . " AND player = " . Page::$player->id);
		$ridesIndex = array();
		if (is_array($rides)) {
			foreach($rides as &$ride) {
				$ridesIndex[$ride["direction"]] = $ride;
			}
		}

		foreach (self::$directions as $direction) {
			$direction["time"] = Std::formatPeriod($direction["time"]);
			$direction["disabled"] = ($direction["level"] > $maxLevel) ? true : false; //!isset($carsIndex[$direction["level"]]);
			$direction["cooldown"] = 0;
			$direction["has_another"] = ($direction["level"] < $maxLevel) ? 1 : 0;
			$bonus = $direction["bonus"];
			$direction["bonus"] = "";
			foreach ($bonus["stats"] as $key => &$stat) {
				$direction["bonus"] .= "<span class=\"brown\">" . self::$features[$key] . ": " . $stat["min"] . "&#8230;"  . $stat["max"] . "%</span><br />";
			}
			$direction["bonus"] .= "<span class=\"brown\">" . AutomobileLang::BONUS_TIME . ": " . Std::formatPeriod($bonus["time"]) . "</span>";
			if (isset($ridesIndex[$direction["id"]])) {
				$direction["cooldown"] = array("rest" => $ridesIndex[$direction["id"]]["cooldown"] - $time, "end" => $ridesIndex[$direction["id"]]["cooldown"]);
			}
			$car = array();
			$car = self::$models[$direction["level"]];
			if (isset($carsIndex[$direction["level"]])) {
				$car["cooldown"] = $carsIndex[$direction["level"]]["cooldown"];
				$car["decrease"] = $carsIndex[$direction["level"]]["decrease"];
				$car["description"] = $carsIndex[$direction["level"]]["description"];
				$car["stats"] = $carsIndex[$direction["level"]]["stats"];
				$car["id"] = $carsIndex[$direction["level"]]["id"];
				$car["disabled"] = 0;
			} else {
				$car["disabled"] = 1;
			}
			$direction["car"] = $car;
			$this->content["rides"][] = $direction;
		}
		$this->page->addPart("content", "automobile/ride.xsl", $this->content);
	}

	private function countHoneyParts($factory, $level, &$count) {
		$honey = 0;
		$count = array();
		foreach (self::$factories[$factory][$level]["cost"] as $part => $c) {
			if ($part != "ore" && $part != "oil" && $c > 0) {
				$code = "a_" . $part;
				if (Page::$player2->{$code} < $c) {
					$count[$part] = $c - Page::$player2->{$code};
					$honey += ($c - Page::$player2->{$code}) * self::$resources[$part]["honey"];
				}
			}
		}
		return $honey;
	}

	private function showBuild($id) {
		if (Page::$player->level < 7) {
			Std::redirect("/automobile/");
		}
		$this->content["window-name"] = AutomobileLang::WINDOW_NAME;
		$factory = array();
		$factory["id"] = $id;
		$factory["name"] = self::$factoryType[$id]["name"];
		$factory["image"] = self::$factoryType[$id]["image"];
		$factory["description"] = self::$factoryType[$id]["description"];
		$cooldown = array("end" => 0, "honey" => 0);

		$automobile = Page::sqlGetCacheRecord("SELECT * FROM automobile WHERE player = " . Page::$player->id, 1800, "automobile_automobile_" . Page::$player->id);

		$time = time();
		if ($automobile) {
			if ($automobile["cooldown"] >= $time) {
				switch($automobile["state"]) {
					case "upgrade_factory" :
						$factoryId = $automobile["stateparam"];
						$cooldown["progress"] = self::$factoryType[$automobile["stateparam"]]["name"] . " [" . $automobile["factory" . $factoryId] . "]";
						$automobile["factory" . $factoryId]--;
						break;
					case "create_car" :
						$cooldown["progress"] = self::$models[$automobile["stateparam"]]["name"];
						break;
				}
				$cooldown["end"] = $automobile["cooldown"];
				$cooldown["rest"] = $automobile["cooldown"] - $time;
			}

			$factory["level"] = $automobile["factory" . $id];
		} else {
			$factory["level"] = 0;
		}

		$this->content["factory"] = $factory;
		$maxLevel = sizeof(self::$factories[$id]);
		$this->content["maxlevel"] = 1;
		if ($automobile["factory" . $factoryId] < $maxLevel) {
			$this->content["maxlevel"] = 0;
			$parts = array();
			$cost = array();
			foreach (self::$factories[$id][$factory["level"] + 1]["cost"] as $part => $count) {
				if ($part != "ore" && $part != "oil" && $count > 0) {
					$code = "a_" . $part;
					$parts[] = array(
									"code" => $part,
									"name" => self::$resources[$part]["name"],
									"image" => self::$resources[$part]["image"],
									"honey" => self::$resources[$part]["honey"],
									"description" => self::$resources[$part]["description"],
									"count_have" => Page::$player2->{$code},
									"count_need" => $count
					);
				} else {
					$cost[$part] = $count;
				}
			}
			$this->content["cost"] = $cost;
			$this->content["parts"] = $parts;
			$partsCount = array();
			$honey = $this->countHoneyParts($id, $factory["level"] + 1, $partsCount);
			$count = 0;
			foreach ($partsCount as $c) {
				$count += $c;
			}
			$levels = array(0, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3);
			$this->content["factory"]["view_level"] = $levels[$factory["level"]];

			$this->content["honey"] = array("count" => $count, "value" => $honey);
		}

		$this->content["cooldown"] = $cooldown;

		$improvements = array();
		foreach (self::$improvements as $improvement) {
			if ($improvement["factory"] == $id) {
				if ($improvement["factory_level"] > $factory["level"]) {
					$improvement["disabled"] = 1;
				} else {
					$improvement["disabled"] = 0;
				}
				$improvements[] = $improvement;
			}
		}
		$this->content["improvements"] = $improvements;
		$this->page->addPart("content", "automobile/build.xsl", $this->content);
	}

	public static function resetBringUp() {
		Page::$player->data["automobile_bring_up"] = array();
		Page::$player->data["automobile_bring_up"]["date"] = date("d.m.Y");
		Page::$player->data["automobile_bring_up"]["prestige"] = 0;
		Page::$player->data["automobile_bring_up"]["total"] = 0;
		Page::$player->data["automobile_bring_up"]["endtime"] = 0;
		Page::$player->data["automobile_bring_up"]["prize"] = 0;
		Page::$player->data["automobile_bring_up"]["count"] = 0;
	}

	public static function getBringUpBaseTime() {
		if (Page::$player->data["automobile_bring_up"]["date"] == date("d.m.Y")) {
			$base = Page::$data["automobile_bring_up"]["time"][0]["base"];
			foreach(Page::$data["automobile_bring_up"]["time"] as $time) {
				if (Page::$player->data["automobile_bring_up"]["count"] >= $time["count"]) {
					$base = $time["base"];
				}
			}
			return $base;
		} else {
			return false;
		}
	}

	private function actionBringUpBonus() {
		Page::startTransaction("automobile_bring_up_bonus", true);
		if (date("N") == 1 && Page::$player->data["automobile_bring_up"]["date"] != date("d.m.Y")) {
			self::resetBringUp();
			Page::$player->saveData();
		}
		if (is_array(Page::$player->data["automobile_bring_up"])) {
			$prize = Page::$player->data["automobile_bring_up"]["prize"];
			if ($prize > 2) $prize = 2;
			$max = Page::$data["automobile_bring_up"]["max"][$prize];
			$current = intval(Page::$player->data["automobile_bring_up"]["count"]);
			$allPrizes = true;
			for ($i = 0; $i < 3; $i++) {
				if (Page::$player->data["automobile_bring_up"]["prize"] <= $i) {
					$allPrizes = false;
				}
			}
			if ($current >= $max && !$allPrizes) {
				Page::$player->data["automobile_bring_up"]["prize"] += 1;
				Page::$player->saveData();
				Page::fullActions(Page::$player, Page::$data["automobile_bring_up"]["bonus"][Page::$player->data["automobile_bring_up"]["prize"]], AutomobileLang::MESSAGE_BRING_UP_BONUS);
			} else {
				Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			}
		}
		Page::endTransaction("automobile_bring_up_bonus", true);
		Std::redirect("/arbat/#automobile");

	}

	private function actionBringUp() {
		Page::startTransaction("automobile_bring_up", true);
		$time = time();
		$carId = intval($_POST["car"]);
		if (date("N") == 1) {
			if (Page::$player->data["automobile_bring_up"]["date"] != date("d.m.Y")) {
				self::resetBringUp();
				Page::$player->saveData();
			}
			if (!Page::$player->data["automobile_bring_up"]["count"] || Page::$data["automobile_bring_up"]["max"][2] > Page::$player->data["automobile_bring_up"]["count"]) {
				if (!Page::$player->data["automobile_bring_up"]["endtime"] || Page::$player->data["automobile_bring_up"]["endtime"] < $time) {
					$car = Page::$sql->getRecord("SELECT * FROM automobile_car WHERE id = " . $carId . " AND player = " . Page::$player->id . " AND createdat < " . $time);
					if ($car) {
						if (empty($car["number"])) {
							Page::addAlert(AutomobileLang::ALERT_RIDE, AutomobileLang::MESSAGE_RIDE_NUMBER, ALERT_ERROR, array(array("name" => AutomobileLang::MESSAGE_RIDE_TO_CAR, "url" => "/automobile/car/" . $car["id"])));
							Std::redirect("/arbat/#automobile");
						}
						if ($car["cooldown"] < time()) {
							if ($car["rides"] > 0) {
								$bringUp = array();
								$cooldown = round(Automobile::getBringUpBaseTime() * (100/($car["speed"] + $car["passability"] + $car["controllability"])) * 60);
								if (DEV_SERVER) {
									$cooldown = floor($cooldown / 4);
								}

								Page::$player->data["automobile_bring_up"]["prestige"] = $car["prestige"];
								Page::$player->data["automobile_bring_up"]["total"] = $cooldown;
								Page::$player->data["automobile_bring_up"]["endtime"] = $time + $cooldown;

								Page::$sql->query("UPDATE automobile_car SET rides = rides - 1, cooldown = " . Page::$player->data["automobile_bring_up"]["endtime"] . " WHERE id = " . $carId);
								Page::$player->saveData();
							} else {
								Page::addAlert(AutomobileLang::ALERT_RIDE, AutomobileLang::MESSAGE_RIDE_NO_PETROL, ALERT_ERROR);
								// Нет бензина
							}
						} else {
							Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
							// Тачка ещё не готова
						}
					} else {
						Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
						// Нет аткой тачки
					}
				} else {
					Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
					// Мы щас уже бомбим
				}
			} else {
				Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
				// Уже всё набомбили
			}
		} else {
			Page::addAlert(AutomobileLang::ERROR, AutomobileLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			// Бомбить можно только по понедельникам
		}
		Page::endTransaction("automobile_bring_up", true);
		Std::redirect("/arbat/#automobile");
	}

	public function processRequest() {
		parent::onBeforeProcessRequest();
		$this->needAuth();
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			switch ($this->url[0]) {
				case "bringupbonus" :
					$this->actionBringUpBonus();
					break;
				case "bringup" :
					$this->actionBringUp();
					break;
				case "checknumber" :
					$this->actionCheckNumber();
					break;
				case "generatenumber" :
					$this->actionGenerateNumber();
					break;
				case "buypart" :
					$this->actionBuyPart();
					break;
				case "buyparts" :
					$this->actionBuyParts();
					break;
				case "ride" :
					$this->actionRide();
					break;
				case "buynumber" :
					$this->actionBuyNumber();
					break;
				case "buypetrol" :
					$this->actionBuyPetrol();
					break;
				case "createcar" :
					$this->actionCreateCar();
					break;
				case "sellcar" :
					$this->actionSellCar();
					break;
				case "upgradecar" :
					$this->actionUpgradeCar();
					break;
				case "upgradefactory" :
					$this->actionUpgradeFactory();
					break;
				case "upgradegarage" :
					$this->actionUpgradeGarage();
					break;
				case "finishbuilding" :
					$this->actionFinishBuilding();
					break;
				case "favorite" :
					$this->actionFavorite();
					break;
			}
		} else {
			switch ($this->url[0]) {
				case "car" :
					$this->showCar();
					break;
				case "rul" :
					$this->showBuild(3);
					break;
				case "kuzov" :
					$this->showBuild(4);
					break;
				case "koleso" :
					$this->showBuild(1);
					break;
				case "motor" :
					$this->showBuild(2);
					break;
				case "ride" :
					$this->showRide();
					break;
				case "build" :
					$this->showBuild();
					break;
				default :
					$this->showAutomobile();
					break;
			}
		}

		parent::onAfterProcessRequest();

	}

}

?>
