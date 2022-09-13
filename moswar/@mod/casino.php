<?php
class CasinoSlots {
	const MAX_CHIP = 200;
	const MIN_WITHDRAWAL = 50;

	const COURSE_ORE_CHIP = 10;
	const COURSE_HONEY_CHIP = 10;
	const COURSE_CHIP_ORE = 10;

	public static $table = array(
			"999" => array(1000, 2000, "j"),
			"888" => array(500, 1000, 1500),
			"777" => array(150, 300, 450),
			"666" => array(100, 200, 300),
			"555" => array(90, 180, 270),
			"444" => array(80, 160, 240),
			"333" => array(70, 140, 210),
			"222" => array(60, 120, 180),
			"111" => array(50, 100, 150),
			"?99" => array(30, 60, 90),
			"?88" => array(25, 50, 75),
			"7?7" => array(20, 40, 60),
			"6?6" => array(30, 60, 90),
			"5?5" => array(25, 50, 75),
			"44?" => array(20, 40, 60),
			"33?" => array(30, 60, 90),
			"22?" => array(25, 50, 75),
			"1??" => array(5, 10, 15)
		);
}

class CasinoKubovich {
	const TYPE_BLACK = 1;
	const TYPE_YELLOW = 2;
	const PLAY_TIME = 4;

	public static $cost = array(0 => 0, 1 => 25, 2 => 35, 3 => 50, 4 => 99, 5 => 149, 6 => 239, 7 => 299, 8 => 339, 9 => 399, 100 => 0);

	public static $step = array(
		0 => array(
			array("image" => "/@/images/obj/item3-2.png", "name" => "Билетик к Моне Шацу", "info" => "Этот билетик является пропуском к хитрому наперсточнику Моне Шацу и дает право сыграть с ним в любое удобное для Вас время.", "correction" => 1, "count" => 1,
			"action" => array(array('type' => 'give_item', 'item' => 'monya_ticket'))),
			
			array("image" => "/@/images/obj/nanogel.png", "name" => "Нано-петрики", "info" => "Уникальные активные молекулы, разработанные ученным П.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'petriks', 'image' => 1, 'petriks' => '1'))),
			
			array("image" => "/@/images/obj/ruda.png", "name" => "Руда", "info" => "Очень полезный и нужный в мегаполисе ресурс.", "correction" => 1, "count" => 1, 
			"action" => array(array("type" => "ore", "image" => 1, "ore" => 1))),
			
			array("image" => "/@/images/obj/tugrick.png", "name" => "Монеты", "info" => "Деревянные тугрики", "correction" => 1, "count" => 1500, 
			"action" => array(array("type" => "money", "image" => 1, "money" => 1500))),
			
			array("image" => "/@/images/obj/tugrick.png", "name" => "Монеты", "info" => "Деревянные тугрики", "correction" => 1, "count" => 1000, 
			"action" => array(array("type" => "money", "image" => 1, "money" => 1000))),
			
			array("image" => "/@/images/obj/tugrick.png", "name" => "Монеты", "info" => "Деревянные тугрики", "correction" => 1, "count" => 500, 
			"action" => array(array("type" => "money", "image" => 1, "money" => 500))),
			
			array("image" => "/@/images/obj/item3-3.png", "name" => "Лицензия наемника", "info" => "Это разрешение дает Вам право один раз вмешаться в групповой бой.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'docs_naemnik'))),
			
			array("image" => "/@/images/obj/item3-1.png", "name" => "Рудный сертификат", "info" => "Это сертификат дает Вам право 1 раз обменять в банке имеющиеся у Вас монеты на руду по фиксированному курсу: 1 руда = 750 монет.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'ore_ticket'))),
			
			array("image" => "/@/images/obj/item15.png", "name" => "Утюг", "info" => "Захватив с собой утюг, можно не только разгладить складки на рубашке, но и потребовать с врага все его монеты.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'utjug'))),
			
			array("image" => "/@/images/obj/collections/unknown.png", "name" => "Случайная коллекция", "info" => "Случайный элемент случайной коллекции случайно попадет к вам", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_rand_col_item'))),

		
			
			
		),
		1 => array(
			array("image" => "/@/images/obj/item3-2.png", "name" => "Билетик к Моне Шацу", "info" => "Этот билетик является пропуском к хитрому наперсточнику Моне Шацу и дает право сыграть с ним в любое удобное для Вас время.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'monya_ticket'))),
			
			array("image" => "/@/images/obj/nanogel.png", "name" => "Нано-петрики", "info" => "Уникальные активные молекулы, разработанные ученным П.", "correction" => 1, "count" => 2, 
			"action" => array(array('type' => 'petriks', 'image' => 1, 'petriks' => '2'))),
			
			array("image" => "/@/images/obj/ruda.png", "name" => "Руда", "info" => "Очень полезный и нужный в мегаполисе ресурс.", "correction" => 1, "count" => 3, 
			"action" => array(array("type" => "ore", "image" => 1, "ore" => 3))),
			
			array("image" => "/@/images/obj/tugrick.png", "name" => "Монеты", "info" => "Деревянные тугрики", "correction" => 1, "count" => 2000, 
			"action" => array(array("type" => "money", "image" => 1, "money" => 2000))),
			
			array("image" => "/@/images/obj/tugrick.png", "name" => "Монеты", "info" => "Деревянные тугрики", "correction" => 1, "count" => 1500, 
			"action" => array(array("type" => "money", "image" => 1, "money" => 1500))),
			
			array("image" => "/@/images/obj/item9.png", "name" => "Советские пассатижи", "info" => "Именные пассатижи с гравировкой фамилии их владельца, чтоб не украли. При использовании во время модификации дает максимальный исход модификации (+3 характеристики и рейтинги).", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'passatiji'))),
			
			array("image" => "/@/images/obj/drugs1.png", "name" => "Пяни", "info" => "Сладки, сочни, пяни. Посмотри на мир в радужном свете!", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'pyani'))),
			
			
			
			array("image" => "/@/images/obj/petfood6.png", "name" => "Кнут «Пряничный»", "info" => "Опробованный дедовский способ, позволяет питомцу мгновенно восстановиться после обучения и быть готовым к дальнейшему развитию.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'pet_knut'))),
			
			array("image" => "/@/images/obj/underground5.png", "name" => "Отбойный молоток", "info" => "Зачем кирка, когда есть отличный инструмент. Прочность — 150 спусков в туннель.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'titan_pick'))),
			
			array("image" => "/@/images/obj/collections/25-loot.png", "name" => "Счастливая коллекция", "info" => "Коллекция казино", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_col_item', 'cid' => 35))),
			
		),
		2 => array(
			array("image" => "/@/images/obj/tugrick.png", "name" => "Монеты", "info" => "Деревянные тугрики", "correction" => 1, "count" => 1500, 
			"action" => array(array("type" => "money", "image" => 1, "money" => 1500))),
			
			array("image" => "/@/images/obj/nanogel.png", "name" => "Нано-петрики", "info" => "Уникальные активные молекулы, разработанные ученным П.", "correction" => 1, "count" => 3, 
			"action" => array(array('type' => 'petriks', 'image' => 1, 'petriks' => '3'))),
			
			array("image" => "/@/images/obj/ruda.png", "name" => "Руда", "info" => "Очень полезный и нужный в мегаполисе ресурс.", "correction" => 1, "count" => 4, 
			"action" => array(array("type" => "ore", "image" => 1, "ore" => 4))),
			
			array("image" => "/@/images/obj/tugrick.png", "name" => "Монеты", "info" => "Деревянные тугрики", "correction" => 1, "count" => 3000, 
			"action" => array(array("type" => "money", "image" => 1, "money" => 3000))),
			
			array("image" => "/@/images/obj/drugs50.png", "name" => "Случайная жвачка", "info" => "Вкусные! Отличные! На эффект приличные.", "correction" => 1, "count" => 1, 
			"action" => array(
							array('type' => 'give_item', 'item' => array(276,277,278,279,280,281), 'amount' => 1, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 5))), // 3-5
							array('type' => 'give_item', 'item' => array(288,289,290,291,292,293), 'amount' => 1, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 6), array('type' => 'max_level', 'value' => 7))), // 6-7
							array('type' => 'give_item', 'item' => array(294,295,296,297,298,299), 'amount' => 1, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 9))), // 8-9
							array('type' => 'give_item', 'item' => array(482,483,484,485,486,487), 'amount' => 1, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 10), array('type' => 'max_level', 'value' => 11))), // 10-11
							array('type' => 'give_item', 'item' => array(755,750,751,752,753,754), 'amount' => 1, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 12), array('type' => 'max_level', 'value' => 13))), // 12-13
							array('type' => 'give_item', 'item' => array(880,881,882,883,884,885), 'amount' => 1, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 14))), // 14+
			)),
			
			array("image" => "/@/images/obj/nanogel.png", "name" => "Нано-петрики", "info" => "Уникальные активные молекулы, разработанные ученным П.", "correction" => 1, "count" => 10, 
			"action" => array(array('type' => 'petriks', 'image' => 1, 'petriks' => '10'))),
			
			array("image" => "/@/images/obj/tugrick.png", "name" => "Монеты", "info" => "Деревянные тугрики", "correction" => 1, "count" => 7500, 
			"action" => array(array("type" => "money", "image" => 1, "money" => 7500))),
			
			array("image" => "/@/images/obj/petfood6.png", "name" => "Кнут «Пряничный»", "info" => "Опробованный дедовский способ, позволяет питомцу мгновенно восстановиться после обучения и быть готовым к дальнейшему развитию.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'pet_knut'))),
			
			array("image" => "/@/images/obj/underground4.png", "name" => "Титановая каска", "info" => "Прочная титановая каска лишает страха и позволяет совать свою голову в самые темные туннели, где лежит много руды. Прочность — 100 спусков.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'titan_metro_helmet'))),
			
			array("image" => "/@/images/obj/collections/25-loot.png", "name" => "Счастливая коллекция", "info" => "Коллекция казино", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_col_item', 'cid' => 35))),
			
			
		),
		3 => array(
			
			array("image" => "/@/images/obj/ruda.png", "name" => "Руда", "info" => "Очень полезный и нужный в мегаполисе ресурс.", "correction" => 1, "count" => 5, 
			"action" => array(array("type" => "ore", "image" => 1, "ore" => 5))),
			
			array("image" => "/@/images/obj/tugrick.png", "name" => "Монеты", "info" => "Деревянные тугрики", "correction" => 1, "count" => 4000, 
			"action" => array(array("type" => "money", "image" => 1, "money" => 4000))),
			
			array("image" => "/@/images/obj/neft.png", "name" => "Нефть", "info" => "Черное золото, достояние и богатство народа.", "correction" => 1, "count" => 25, 
			"action" => array(array("type" => "oil", "image" => 1, "oil" => 25))),
			
			
			array("image" => "/@/images/obj/drugs50.png", "name" => "Случайная жвачка", "info" => "Вкусные! Отличные! На эффект приличные.", "correction" => 1, "count" => 2, 
			"action" => array(
							array('type' => 'give_item', 'item' => array(276,277,278,279,280,281), 'amount' => 2, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 5))), // 3-5
							array('type' => 'give_item', 'item' => array(288,289,290,291,292,293), 'amount' => 2, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 6), array('type' => 'max_level', 'value' => 7))), // 6-7
							array('type' => 'give_item', 'item' => array(294,295,296,297,298,299), 'amount' => 2, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 9))), // 8-9
							array('type' => 'give_item', 'item' => array(482,483,484,485,486,487), 'amount' => 2, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 10), array('type' => 'max_level', 'value' => 11))), // 10-11
							array('type' => 'give_item', 'item' => array(755,750,751,752,753,754), 'amount' => 2, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 12), array('type' => 'max_level', 'value' => 13))), // 12-13
							array('type' => 'give_item', 'item' => array(880,881,882,883,884,885), 'amount' => 2, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 14))), // 14+
			)),
			
			array("image" => "/@/images/obj/nanogel.png", "name" => "Нано-петрики", "info" => "Уникальные активные молекулы, разработанные ученным П.", "correction" => 1, "count" => 4, 
			"action" => array(array('type' => 'petriks', 'image' => 1, 'petriks' => '4'))),
			
			array("image" => "/@/images/obj/item3-3.png", "name" => "Лицензия наемника", "info" => "Это разрешение дает Вам право один раз вмешаться в групповой бой.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'docs_naemnik'))),

			array("image" => "/@/images/obj/drugs84.png", "name" => "Зефирка", "info" => "Легкий и воздушный Зефир с шоколадной глазурью. Не совместим с некоторым типом жвачек.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808)))),
			
			array("image" => "/@/images/obj/item13.png", "name" => "Нано-петрики «Экспресс»", "info" => "Зачем ждать, пока сварится очередная партия нано-петриков. С vip-доступом к новейшему оборудованию эту операцию можно делать мгновенно, пока у вас есть квитанции пред заказа.", "correction" => 1, "count" => 3, 
			"action" => array(array('type' => 'give_item', 'item' => 'petriks_instant', 'amount' => 3))),
			
			array("image" => "/@/images/obj/item19.png", "name" => "Инструменты «21-ая модификация»", "info" => "До чего техника дошла! Можно улучшить то, что нельзя улучшить. При использовании предмета в мастерской можно создать 21-ую модификацию одежды совершенно бесплатно", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'cert_mf_21'))),
			
			array("image" => "/@/images/obj/collections/25-loot.png", "name" => "Счастливая коллекция", "info" => "Коллекция казино", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_col_item', 'cid' => 35))),

		),
		4 => array(
			
			array("image" => "/@/images/obj/drugs50.png", "name" => "Случайная жвачка", "info" => "Вкусные! Отличные! На эффект приличные.", "correction" => 1, "count" => 3, 
			"action" => array(
							array('type' => 'give_item', 'item' => array(276,277,278,279,280,281), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 5))), // 3-5
							array('type' => 'give_item', 'item' => array(288,289,290,291,292,293), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 6), array('type' => 'max_level', 'value' => 7))), // 6-7
							array('type' => 'give_item', 'item' => array(294,295,296,297,298,299), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 9))), // 8-9
							array('type' => 'give_item', 'item' => array(482,483,484,485,486,487), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 10), array('type' => 'max_level', 'value' => 11))), // 10-11
							array('type' => 'give_item', 'item' => array(755,750,751,752,753,754), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 12), array('type' => 'max_level', 'value' => 13))), // 12-13
							array('type' => 'give_item', 'item' => array(880,881,882,883,884,885), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 14))), // 14+
			)),
			
			array("image" => "/@/images/obj/ruda.png", "name" => "Руда", "info" => "Очень полезный и нужный в мегаполисе ресурс.", "correction" => 1, "count" => 10, 
			"action" => array(array("type" => "ore", "image" => 1, "ore" => 10))),
			
			array("image" => "/@/images/obj/tugrick.png", "name" => "Монеты", "info" => "Деревянные тугрики", "correction" => 1, "count" => 7500, 
			"action" => array(array("type" => "money", "image" => 1, "money" => 7500))),
			
			array("image" => "/@/images/obj/nanogel.png", "name" => "Нано-петрики", "info" => "Уникальные активные молекулы, разработанные ученным П.", "correction" => 1, "count" => 8, 
			"action" => array(array('type' => 'petriks', 'image' => 1, 'petriks' => '8'))),
			
			array("image" => "/@/images/obj/petfood6.png", "name" => "Кнут «Пряничный»", "info" => "Опробованный дедовский способ, позволяет питомцу мгновенно восстановиться после обучения и быть готовым к дальнейшему развитию.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'pet_knut'))),
			
			array("image" => "/@/images/obj/drugs84.png", "name" => "Зефирка", "info" => "Легкий и воздушный Зефир с шоколадной глазурью. Не совместим с некоторым типом жвачек.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808)))),
			
			array("image" => "/@/images/obj/ruda.png", "name" => "Руда", "info" => "Очень полезный и нужный в мегаполисе ресурс.", "correction" => 1, "count" => 15, 
			"action" => array(array("type" => "ore", "image" => 1, "ore" => 15))),
			
			array("image" => "/@/images/obj/mobile.png", "name" => "Мобилка", "info" => "Новая, яркая модель. Так и хочется отжать.", "correction" => 1, "count" => 2, 
			"action" => array(array('type' => 'give_item', 'item' => 'huntclub_mobile', 'amount' => 2))),
			
			array("image" => "/@/images/obj/item15.png", "name" => "Утюг", "info" => "Захватив с собой утюг, можно не только разгладить складки на рубашке, но и потребовать с врага все его монеты.", "correction" => 1, "count" => 3, 
			"action" => array(array('type' => 'give_item', 'item' => 'utjug', 'amount' => 3))),
			
			array("image" => "/@/images/obj/collections/25-loot.png", "name" => "Счастливая коллекция", "info" => "Коллекция казино", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_col_item', 'cid' => 35))),
			
		),
		5 => array(
			
			array("image" => "/@/images/obj/ruda.png", "name" => "Руда", "info" => "Очень полезный и нужный в мегаполисе ресурс.", "correction" => 1, "count" => 15, 
			"action" => array(array("type" => "ore", "image" => 1, "ore" => 15))),
			
			array("image" => "/@/images/obj/tugrick.png", "name" => "Монеты", "info" => "Деревянные тугрики", "correction" => 1, "count" => 11500, 
			"action" => array(array("type" => "money", "image" => 1, "money" => 11500))),
			
			array("image" => "/@/images/obj/item3-3.png", "name" => "Лицензия наемника", "info" => "Это разрешение дает Вам право один раз вмешаться в групповой бой.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'docs_naemnik'))),
			
			array("image" => "/@/images/obj/item15.png", "name" => "Утюг", "info" => "Захватив с собой утюг, можно не только разгладить складки на рубашке, но и потребовать с врага все его монеты.", "correction" => 1, "count" => 3, 
			"action" => array(array('type' => 'give_item', 'item' => 'utjug', 'amount' => 3))),
			
			array("image" => "/@/images/obj/nanogel.png", "name" => "Нано-петрики", "info" => "Уникальные активные молекулы, разработанные ученным П.", "correction" => 1, "count" => 10, 
			"action" => array(array('type' => 'petriks', 'image' => 1, 'petriks' => '10'))),
			
			array("image" => "/@/images/obj/tugrick.png", "name" => "Монеты", "info" => "Деревянные тугрики", "correction" => 1, "count" => 5000, 
			"action" => array(array("type" => "money", "image" => 1, "money" => 5000))),
			
			array("image" => "/@/images/obj/drugs1.png", "name" => "Пяни", "info" => "Сладки, сочни, пяни. Посмотри на мир в радужном свете!", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'pyani'))),
			
			array("image" => "/@/images/obj/item13.png", "name" => "Нано-петрики «Экспресс»", "info" => "Зачем ждать, пока сварится очередная партия нано-петриков. С vip-доступом к новейшему оборудованию эту операцию можно делать мгновенно, пока у вас есть квитанции пред заказа.", "correction" => 1, "count" => 10, 
			"action" => array(array('type' => 'give_item', 'item' => 'petriks_instant', 'amount' => 10))),
			
			array("image" => "/@/images/obj/drugs89.png", "name" => "Полезный пельмень", "info" => "Вкусный соевый пельмень, моментально повышающий характеристику персонажа. Только вот какую? На этот вопрос не смогли ответить и сами ученые.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'stat_stimulator'))),
			
			array("image" => "/@/images/obj/collections/25-loot.png", "name" => "Счастливая коллекция", "info" => "Коллекция казино", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_col_item', 'cid' => 35))),
			
		),
		6 => array(
		
			array("image" => "/@/images/obj/item3-2.png", "name" => "Билетик к Моне Шацу", "info" => "Этот билетик является пропуском к хитрому наперсточнику Моне Шацу и дает право сыграть с ним в любое удобное для Вас время.", "correction" => 1, "count" => 5, 
			"action" => array(array('type' => 'give_item', 'item' => 'monya_ticket', 'amount' => 5))),
			
			array("image" => "/@/images/obj/nanogel.png", "name" => "Нано-петрики", "info" => "Уникальные активные молекулы, разработанные ученным П.", "correction" => 1, "count" => 20, 
			"action" => array(array('type' => 'petriks', 'image' => 1, 'petriks' => '20'))),
			
			array("image" => "/@/images/obj/petfood6.png", "name" => "Кнут «Пряничный»", "info" => "Опробованный дедовский способ, позволяет питомцу мгновенно восстановиться после обучения и быть готовым к дальнейшему развитию.", "correction" => 1, "count" => 3, 
			"action" => array(array('type' => 'give_item', 'item' => 'pet_knut', 'amount' => 3))),
			
			array("image" => "/@/images/obj/drugs84.png", "name" => "Зефирка", "info" => "Легкий и воздушный Зефир с шоколадной глазурью. Не совместим с некоторым типом жвачек.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808)))),
			
			array("image" => "/@/images/obj/ruda.png", "name" => "Руда", "info" => "Очень полезный и нужный в мегаполисе ресурс.", "correction" => 1, "count" => 24, 
			"action" => array(array("type" => "ore", "image" => 1, "ore" => 24))),
			
			array("image" => "/@/images/obj/mobile.png", "name" => "Мобилка", "info" => "Новая, яркая модель. Так и хочется отжать.", "correction" => 1, "count" => 4, 
			"action" => array(array('type' => 'give_item', 'item' => 'huntclub_mobile', 'amount' => 4))),

			array("image" => "/@/images/obj/item13.png", "name" => "Нано-петрики «Экспресс»", "info" => "Зачем ждать, пока сварится очередная партия нано-петриков. С vip-доступом к новейшему оборудованию эту операцию можно делать мгновенно, пока у вас есть квитанции пред заказа.", "correction" => 1, "count" => 7, 
			"action" => array(array('type' => 'give_item', 'item' => 'petriks_instant', 'amount' => 7))),
			
			array("image" => "/@/images/obj/item15.png", "name" => "Утюг", "info" => "Захватив с собой утюг, можно не только разгладить складки на рубашке, но и потребовать с врага все его монеты.", "correction" => 1, "count" => 4, 
			"action" => array(array('type' => 'give_item', 'item' => 'utjug', 'amount' => 4))),
			
			array("image" => "/@/images/obj/underground6.png", "name" => "Ароматный сыр", "info" => "Сильное оружие для решения споров в групповых боях. Аромат сыра привлекает в групповой бой крысомаху за вашу сторону.", "correction" => 1, "count" => 2, 
			"action" => array(array('type' => 'give_item', 'item' => 'fight_cheese', 'amount' => 2))),
			
			array("image" => "/@/images/obj/collections/25-loot.png", "name" => "Счастливая коллекция", "info" => "Коллекция казино", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_col_item', 'cid' => 35))),
			
		),
		7 => array(
		
			array("image" => "/@/images/obj/ruda.png", "name" => "Руда", "info" => "Очень полезный и нужный в мегаполисе ресурс.", "correction" => 1, "count" => 30, 
			"action" => array(array("type" => "ore", "image" => 1, "ore" => 30))),
			
			array("image" => "/@/images/obj/neft.png", "name" => "Нефть", "info" => "Черное золото, достояние и богатство народа.", "correction" => 1, "count" => 150, 
			"action" => array(array("type" => "oil", "image" => 1, "oil" => 150))),

			array("image" => "/@/images/obj/drugs84.png", "name" => "Зефирка", "info" => "Легкий и воздушный Зефир с шоколадной глазурью. Не совместим с некоторым типом жвачек.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808), 'amount' => 2))),
			
			array("image" => "/@/images/obj/tugrick.png", "name" => "Монеты", "info" => "Деревянные тугрики", "correction" => 1, "count" => 22500, 
			"action" => array(array("type" => "money", "image" => 1, "money" => 22500))),
			
			array("image" => "/@/images/obj/item9.png", "name" => "Советские пассатижи", "info" => "Именные пассатижи с гравировкой фамилии их владельца, чтоб не украли. При использовании во время модификации дает максимальный исход модификации (+3 характеристики и рейтинги).", "correction" => 1, "count" => 3, 
			"action" => array(array('type' => 'give_item', 'item' => 'passatiji', 'amount' => 3))),
			
			array("image" => "/@/images/obj/box4.png", "name" => "Детали", "info" => "Случайные запчасти для автомобилей.", "correction" => 1, "count" => 30, 
			"action" => array(	array('type' => 'autopart', 'amount' => 10),
								array('type' => 'autopart', 'amount' => 10),
								array('type' => 'autopart', 'amount' => 10))),
			
			array("image" => "/@/images/obj/drugs89.png", "name" => "Полезный пельмень", "info" => "Вкусный соевый пельмень, моментально повышающий характеристику персонажа. Только вот какую? На этот вопрос не смогли ответить и сами ученые.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'stat_stimulator'))),
			
			array("image" => "/@/images/obj/collections/unknown.png", "name" => "Случайная коллекция", "info" => "Случайный элемент случайной коллекции случайно попадет к вам", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_rand_col_item'))),
			
			array("image" => "/@/images/obj/photocamera.png", "name" => "Фотокамера", "info" => "Лёлик, ожидающий знаменитостей у входа в Клуб, уже давно мечтает об этой модели фотоаппарата. В обмен на нее, он сфоткает вас совершенно бесплатно.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'ny_back'))),
			
			array("image" => "/@/images/obj/collections/25-loot.png", "name" => "Счастливая коллекция", "info" => "Коллекция казино", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_col_item', 'cid' => 35))),
			
		),
		8 => array(

			array("image" => "/@/images/obj/box4.png", "name" => "Детали", "info" => "Случайные запчасти для автомобилей.", "correction" => 1, "count" => 40, 
			"action" => array(	array('type' => 'autopart', 'amount' => 13),
								array('type' => 'autopart', 'amount' => 13),
								array('type' => 'autopart', 'amount' => 14))),
			
			array("image" => "/@/images/obj/ruda.png", "name" => "Руда", "info" => "Очень полезный и нужный в мегаполисе ресурс.", "correction" => 1, "count" => 35, 
			"action" => array(array("type" => "ore", "image" => 1, "ore" => 35))),
			
			array("image" => "/@/images/obj/drugs84.png", "name" => "Зефирка", "info" => "Легкий и воздушный Зефир с шоколадной глазурью. Не совместим с некоторым типом жвачек.", "correction" => 1, "count" => 3, 
			"action" => array(array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808), 'amount' => 3))),
			
			array("image" => "/@/images/obj/item3-3.png", "name" => "Лицензия наемника", "info" => "Это разрешение дает Вам право один раз вмешаться в групповой бой.", "correction" => 1, "count" => 4, 
			"action" => array(array('type' => 'give_item', 'item' => 'docs_naemnik', 'amount' => 4))),
			
			array("image" => "/@/images/obj/petfood6.png", "name" => "Кнут «Пряничный»", "info" => "Опробованный дедовский способ, позволяет питомцу мгновенно восстановиться после обучения и быть готовым к дальнейшему развитию.", "correction" => 1, "count" => 4, 
			"action" => array(array('type' => 'give_item', 'item' => 'pet_knut', 'amount' => 4))),
			
			array("image" => "/@/images/obj/tugrick.png", "name" => "Монеты", "info" => "Деревянные тугрики", "correction" => 1, "count" => 26200, 
			"action" => array(array("type" => "money", "image" => 1, "money" => 26200))),
			
			
			array("image" => "/@/images/obj/item15.png", "name" => "Утюг", "info" => "Захватив с собой утюг, можно не только разгладить складки на рубашке, но и потребовать с врага все его монеты.", "correction" => 1, "count" => 5, 
			"action" => array(array('type' => 'give_item', 'item' => 'utjug', 'amount' => 5))),
			
			array("image" => "/@/images/obj/item13.png", "name" => "Нано-петрики «Экспресс»", "info" => "Зачем ждать, пока сварится очередная партия нано-петриков. С vip-доступом к новейшему оборудованию эту операцию можно делать мгновенно, пока у вас есть квитанции пред заказа.", "correction" => 1, "count" => 15, 
			"action" => array(array('type' => 'give_item', 'item' => 'petriks_instant', 'amount' => 15))),
			
			array("image" => "/@/images/obj/underground6.png", "name" => "Ароматный сыр", "info" => "Сильное оружие для решения споров в групповых боях. Аромат сыра привлекает в групповой бой крысомаху за вашу сторону.", "correction" => 1, "count" => 4, 
			"action" => array(array('type' => 'give_item', 'item' => 'fight_cheese', 'amount' => 4))),
			
			array("image" => "/@/images/obj/collections/25-loot.png", "name" => "Счастливая коллекция", "info" => "Коллекция казино", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_col_item', 'cid' => 35))),
		),
		9 => array(

			array("image" => "/@/images/obj/neft.png", "name" => "Нефть", "info" => "Черное золото, достояние и богатство народа.", "correction" => 1, "count" => 200, 
			"action" => array(array("type" => "oil", "image" => 1, "oil" => 200))),
			
			array("image" => "/@/images/obj/tugrick.png", "name" => "Монеты", "info" => "Деревянные тугрики", "correction" => 1, "count" => 30000, 
			"action" => array(array("type" => "money", "image" => 1, "money" => 30000))),
			
			array("image" => "/@/images/obj/nanogel.png", "name" => "Нано-петрики", "info" => "Уникальные активные молекулы, разработанные ученным П.", "correction" => 1, "count" => 40, 
			"action" => array(array('type' => 'petriks', 'image' => 1, 'petriks' => '40'))),
			
			array("image" => "/@/images/obj/box4.png", "name" => "Детали", "info" => "Случайные запчасти для автомобилей.", "correction" => 1, "count" => 40, 
			"action" => array(	array('type' => 'autopart', 'amount' => 13),
								array('type' => 'autopart', 'amount' => 13),
								array('type' => 'autopart', 'amount' => 14))),
			
			array("image" => "/@/images/obj/drugs84.png", "name" => "Зефирка", "info" => "Легкий и воздушный Зефир с шоколадной глазурью. Не совместим с некоторым типом жвачек.", "correction" => 1, "count" => 3, 
			"action" => array(array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808), 'amount' => 3))),
			
			array("image" => "/@/images/obj/underground6.png", "name" => "Ароматный сыр", "info" => "Сильное оружие для решения споров в групповых боях. Аромат сыра привлекает в групповой бой крысомаху за вашу сторону.", "correction" => 1, "count" => 4, 
			"action" => array(array('type' => 'give_item', 'item' => 'fight_cheese', 'amount' => 4))),
			
			
			array("image" => "/@/images/obj/item15.png", "name" => "Утюг", "info" => "Захватив с собой утюг, можно не только разгладить складки на рубашке, но и потребовать с врага все его монеты.", "correction" => 1, "count" => 6, 
			"action" => array(array('type' => 'give_item', 'item' => 'utjug', 'amount' => 6))),
			
			
			array("image" => "/@/images/obj/collections/unknown.png", "name" => "Случайная коллекция", "info" => "Случайный элемент случайной коллекции случайно попадет к вам", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_rand_col_item'))),
			
			array("image" => "/@/images/obj/drugs89.png", "name" => "Полезный пельмень", "info" => "Вкусный соевый пельмень, моментально повышающий характеристику персонажа. Только вот какую? На этот вопрос не смогли ответить и сами ученые.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'stat_stimulator'))),
			
			array("image" => "/@/images/obj/collections/25-loot.png", "name" => "Счастливая коллекция", "info" => "Коллекция казино", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_col_item', 'cid' => 35))),
			
			
		),
		100 => array(
			array("image" => "/@/images/obj/box4.png", "name" => "Детали", "info" => "Случайные запчасти для автомобилей.", "correction" => 1, "count" => 100, 
			"action" => array(	array('type' => 'autopart', 'amount' => 20),
								array('type' => 'autopart', 'amount' => 20),
								array('type' => 'autopart', 'amount' => 20),
								array('type' => 'autopart', 'amount' => 20),
								array('type' => 'autopart', 'amount' => 20)
							)),
								
			
			array("image" => "/@/images/obj/neft.png", "name" => "Нефть", "info" => "Черное золото, достояние и богатство народа.", "correction" => 1, "count" => 500, 
			"action" => array(array("type" => "oil", "image" => 1, "oil" => 500))),
			
			array("image" => "/@/images/obj/item19.png", "name" => "Инструменты «21-ая модификация»", "info" => "До чего техника дошла! Можно улучшить то, что нельзя улучшить. При использовании предмета в мастерской можно создать 21-ую модификацию одежды совершенно бесплатно", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'cert_mf_21'))),
			
			array("image" => "/@/images/obj/drugs89.png", "name" => "Полезный пельмень", "info" => "Вкусный соевый пельмень, моментально повышающий характеристику персонажа. Только вот какую? На этот вопрос не смогли ответить и сами ученые.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'stat_stimulator'))),
			
			
			array("image" => "/@/images/obj/photocamera.png", "name" => "Фотокамера", "info" => "Лёлик, ожидающий знаменитостей у входа в Клуб, уже давно мечтает об этой модели фотоаппарата. В обмен на нее, он сфоткает вас совершенно бесплатно.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'ny_back'))),
			
			array("image" => "/@/images/obj/item15.png", "name" => "Утюг", "info" => "Захватив с собой утюг, можно не только разгладить складки на рубашке, но и потребовать с врага все его монеты.", "correction" => 1, "count" => 10, 
			"action" => array(array('type' => 'give_item', 'item' => 'utjug', 'amount' => 10))),
			
			array("image" => "/@/images/obj/item13.png", "name" => "Нано-петрики «Экспресс»", "info" => "Зачем ждать, пока сварится очередная партия нано-петриков. С vip-доступом к новейшему оборудованию эту операцию можно делать мгновенно, пока у вас есть квитанции пред заказа.", "correction" => 1, "count" => 30, 
			"action" => array(array('type' => 'give_item', 'item' => 'petriks_instant', 'amount' => 30))),
			
			array("image" => "/@/images/obj/underground6.png", "name" => "Ароматный сыр", "info" => "Сильное оружие для решения споров в групповых боях. Аромат сыра привлекает в групповой бой крысомаху за вашу сторону.", "correction" => 1, "count" => 8, 
			"action" => array(array('type' => 'give_item', 'item' => 'fight_cheese', 'amount' => 8))),
			
			array("image" => "/@/images/obj/drugs89.png", "name" => "Полезный пельмень", "info" => "Вкусный соевый пельмень, моментально повышающий характеристику персонажа. Только вот какую? На этот вопрос не смогли ответить и сами ученые.", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_item', 'item' => 'stat_stimulator'))),
			
			array("image" => "/@/images/obj/collections/unknown.png", "name" => "Случайная коллекция", "info" => "Случайный элемент случайной коллекции случайно попадет к вам", "correction" => 1, "count" => 1, 
			"action" => array(array('type' => 'give_rand_col_item'))),
			
		)
		);

}

class Casino extends Page implements IModule {
	public $moduleCode = "Casino";

	public function __construct() {
		parent::__construct();
	}

	public function showCasino() {
		$this->content["window-name"] = CasinoLang::WINDOW_NAME;
		$this->content["chip"] = number_format(self::$player->chip);

		$this->content["luckylist"] = array();
		$players = Page::sqlGetCacheRecordSet("SELECT p.id id, p.nickname, p.level, p.fraction, c.name as clan_name,
                IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan, p.casino_today_profit profit
                FROM player p LEFT JOIN clan as c ON p.clan = c.id
                WHERE p.casino_today_profit > 0 ORDER BY p.casino_today_profit DESC LIMIT 10", 300, 'casino_today_profit_top');
		$position = 1;
		$selfInList = false;
		if (is_array($players)) {
			foreach ($players as $player) {
				if ($player["id"] == self::$player->id) {
					$selfInList = true;
				}
				$rating = array();
				$rating["position"] = $position;
				$rating["player"] = $player;
				$this->content["luckylist"][] = $rating;
				$position++;
			}
		}
		if (!$selfInList) {
			if (self::$player->casino_today_profit == 0) {
				$position = Page::sqlGetCacheValue("SELECT count(1) FROM player WHERE casino_today_profit > " . self::$player->casino_today_profit, 300);
			} else {
				$position = self::$sql->getValue("SELECT count(1) FROM player WHERE casino_today_profit > " . self::$player->casino_today_profit);
			}
			$position++;
			$rating = array();
			$rating["position"] = $position;
			$rating["my"] = 'true';
			$player = self::$player->toArray();
			$player["profit"] = self::$player->casino_today_profit;

			$rating["player"] = $player;
			$this->content["luckylist"][] = $rating;
		}
		$this->page->addPart("content", "casino/casino.xsl", $this->content);
	}

	public function showSlots() {
		$this->content["table"] = array();
		$collection = "russia";
		foreach (CasinoSlots::$table as $win => $prizes) {
			$row = array("c1" => $collection . "-", "c2" => $collection . "-", "c3" => $collection . "-", "s1" => substr($win, 0, 1), "s2" => substr($win, 1, 1), "s3" => substr($win, 2, 1), "v1" => $prizes[0], "v2" => $prizes[1], "v3" => $prizes[2]);
			if ($row["s1"] == "?") { $row["s1"] = "any"; $row["c1"] = ""; }
			if ($row["s2"] == "?") { $row["s2"] = "any"; $row["c2"] = ""; }
			if ($row["s3"] == "?") { $row["s3"] = "any"; $row["c3"] = ""; }
			$this->content["table"][] = $row;
		}
		$this->content["window-name"] = CasinoLang::WINDOW_NAME_SLOTS;
		$this->content["chip"] = number_format(self::$player->chip);
		$jackpot = self::$sql->getValue("SELECT value FROM casino WHERE name = 'casino_slots_jackpot'");
		$jackpot = (double) $jackpot;
		$this->content["jackpot"] = number_format(floor($jackpot));

		$this->page->addPart("content", "casino/slots.xsl", $this->content);
	}

	public function showKubovich() {
		$this->content["window-name"] = CasinoLang::WINDOW_NAME_KUBOVICH;
		$this->content["chip"] = number_format(self::$player->chip);
		$this->content = array_merge($this->content, $this->kubovichPrepareData());
		$kubovichTime = intval(CacheManager::get("value_casino_kubovich_time"));
		//$kubovichTime = intval(self::$sql->getValue("SELECT value FROM value WHERE name = 'casino_kubovich_time'"));
		//$kubovichTime = time() - (3600 * 5);
		$time = time();
		$kubovichEndTime = $kubovichTime + (3600 * CasinoKubovich::PLAY_TIME);
		$this->content["ready"] = 0;
		if ($kubovichEndTime < $time) {
			// Сгенерировать новое время
			$timeStart = mktime(8, 0, 0, date("n"), date("j") + 1);
			$timeEnd = mktime(19, 0, 0, date("n"), date("j") + 1);
			$timeNew = mt_rand($timeStart, $timeEnd);
			//self::$sql->query("UPDATE value SET value = '" . $timeNew . "' WHERE name = 'casino_kubovich_time'");
			
			CacheManager::set("value_casino_kubovich_time", $timeNew);
			Page::setValueFromDB('casino_kubovich_time', $timeNew);
		} elseif($kubovichTime > $time) {
			// Ещё не начался
		} else {
			// Играем
			$this->content["ready"] = 1;
		}

		$this->page->addPart("content", "casino/kubovich.xsl", $this->content);
	}

	// Чтобы вызвать 1 раз из крона для укладки в кеш
	public static function getSportlotoPast() {
		$pastStart = mktime(0, 0, 0, date("n"), date("j") - 1, date("Y"));
		$pastEnd = mktime(23, 59, 59, date("n"), date("j") - 1, date("Y"));
		$past = array();
		if (!$past = self::$cache->get("casino_sportloto_past")) {

			$past["run"] = self::$sql->getValue("SELECT value FROM casino WHERE name = 'casino_sportloto_run'"); // s

			$todayNumbers = CacheManager::get('value_casino_sportloto_today_numbers');
			$todayNumbers = explode(" ", $todayNumbers);
			$past["numbers"] = $todayNumbers; //s

			$past["today_numbers"] = implode(", ", $todayNumbers); // s

			// s
			$past["past_tickets_count"] = number_format(self::$sql->getValue("SELECT COUNT(1) FROM casino_sportloto WHERE dt >= '" . date("Y-m-d H:i:s", $pastStart) . "' AND dt <= '" . date("Y-m-d H:i:s", $pastEnd) . "'"));
			$past["past_wins"] = self::$sql->getValue("SELECT COUNT(distinct player) FROM casino_sportloto WHERE dt >= '" . date("Y-m-d H:i:s", $pastStart) . "' AND dt <= '" . date("Y-m-d H:i:s", $pastEnd) . "' AND gussed >= 2");
			if ($past["past_wins"] > 1) $past["past_wins"] = number_format($past["past_wins"]) . " " . Std::formatRussianNumeral($past["past_wins"], "игрок", "игрока", "игроков");
			$past["past_jackpots"] = self::$sql->getValue("SELECT COUNT(distinct player) FROM casino_sportloto WHERE dt >= '" . date("Y-m-d H:i:s", $pastStart) . "' AND dt <= '" . date("Y-m-d H:i:s", $pastEnd) . "' AND gussed = 5");
			if ($past["past_jackpots"] > 1) $past["past_jackpots"] = number_format($past["past_jackpots"]) . " " . Std::formatRussianNumeral($past["past_jackpots"], "игрок", "игрока", "игроков");
			$past["past_fund"] = number_format(floor(self::$sql->getValue("SELECT value FROM casino WHERE name = 'casino_sportloto_past_fund'")));
			$past["past_jackpot"] = number_format(floor(self::$sql->getValue("SELECT value FROM casino WHERE name = 'casino_sportloto_past_jackpot'")));

			$past["past_gussed"] = self::$sql->getRecordSet("SELECT count(player) tickets, gussed FROM casino_sportloto FORCE INDEX (ix__casino_sportloto__gussed_dt) WHERE gussed > 1 AND dt >= '" . date("Y-m-d H:i:s", $pastStart) . "' AND dt <= '" . date("Y-m-d H:i:s", $pastEnd) . "' GROUP BY gussed ORDER BY gussed");

			self::$cache->set("casino_sportloto_past", $past);
		}
		return $past;
	}

	public function showSportloto() {
		$pastStart = mktime(0, 0, 0, date("n"), date("j") - 1, date("Y"));
		$pastEnd = mktime(23, 59, 59, date("n"), date("j") - 1, date("Y"));
		$todayStart = mktime(0, 0, 0, date("n"), date("j"), date("Y"));
		$todayEnd = mktime(23, 59, 59, date("n"), date("j"), date("Y"));

		$past = self::getSportlotoPast();

		$this->content = array_merge($this->content, $past);
		

		$this->content["window-name"] = CasinoLang::WINDOW_NAME_SPORTLOTO;
		$this->content["chip"] = number_format(self::$player->chip); // r
		$fund = self::$sql->getValue("SELECT value FROM casino WHERE name = 'casino_sportloto_fund'");
		$fund = (double) $fund;
		$this->content["fund"] = number_format(floor($fund)); // r
		$jackpot = self::$sql->getValue("SELECT value FROM casino WHERE name = 'casino_sportloto_jackpot'");
		$jackpot = (double) $jackpot;
		$this->content["jackpot"] = number_format(floor($jackpot)); // s
		$todayTickets = self::$sql->getRecordSet("SELECT * FROM casino_sportloto WHERE dt >= '" . date("Y-m-d H:i:s", $todayStart) . "' AND dt <= '" . date("Y-m-d H:i:s", $todayEnd) . "' AND player = " . self::$player->id);
		$this->content["today_tickets"] = array(); // r
		if ($todayTickets) {
			foreach ($todayTickets as $ticket) {
				$numbers = explode(" ", $ticket["numbers"]);
				$this->content["today_tickets"][] = array("n1" => $numbers[0], "n2" => $numbers[1], "n3" => $numbers[2], "n4" => $numbers[3], "n5" => $numbers[4]);
			}
		}

		$pastTickets = self::$sql->getRecordSet("SELECT * FROM casino_sportloto WHERE dt >= '" . date("Y-m-d H:i:s", $pastStart) . "' AND dt <= '" . date("Y-m-d H:i:s", $pastEnd) . "' AND player = " . self::$player->id);
		$this->content["past_tickets"] = array(); // r
		$prize = 0;
		$obtained = 1;
		if ($pastTickets) {
			foreach ($pastTickets as $ticket) {
				$numbers = explode(" ", $ticket["numbers"]);
				$this->content["past_tickets"][] = array(
					"n1" => $numbers[0],
					"type1" => in_array($numbers[0], $past["numbers"]) ? "guess" : "fail",
					"n2" => $numbers[1],
					"type2" => in_array($numbers[1], $past["numbers"]) ? "guess" : "fail",
					"n3" => $numbers[2],
					"type3" => in_array($numbers[2], $past["numbers"]) ? "guess" : "fail",
					"n4" => $numbers[3],
					"type4" => in_array($numbers[3], $past["numbers"]) ? "guess" : "fail",
					"n5" => $numbers[4],
					"type5" => in_array($numbers[4], $past["numbers"]) ? "guess" : "fail",
					"prize" => $ticket["chip"]
				);
				if (!$ticket["get"] && $ticket["chip"] > 0) {
					$obtained = 0;
				}
				$prize += $ticket["chip"];
			}
		}

		$this->content["prize"] = $prize; //r
		$this->content["obtained"] = $obtained; //r
		$this->content["today_date"] = date("d.m.Y", $todayStart); // r
		$this->content["next_time"] = $todayEnd; //r
		$this->content["sportloto_timer"] = $todayEnd - time(); //r

		$this->page->addPart("content", "casino/sportloto.xsl", $this->content);
	}

	public function actionSportlotoGetTicket() {
		// Уже купили 3 билета
		// Не хватает фишек на билет
		// Не заполнены 5 чисел
		// Числа выходят за диапазон
		// Есть одинаковые числа
		Page::startTransaction("casino_sportloto_get_ticket", true);
		$maxTickets = 100;
		$cost = 60;

		$data = array();
		$data["success"] = false;
		$todayStart = mktime(0, 0, 0, date("n"), date("j"), date("Y"));
		$todayEnd = mktime(23, 59, 59, date("n"), date("j"), date("Y"));

		$ticketsCount = self::$sql->getValue("SELECT COUNT(1) FROM casino_sportloto WHERE dt >= '" . date("Y-m-d H:i:s", $todayStart) . "' AND dt <= '" . date("Y-m-d H:i:s", $todayEnd) . "' AND player = " . self::$player->id);
		$brokenNumbers = false;
		$numbers = array();
		if ($maxTickets > $ticketsCount) {
			foreach ($_POST["numbers"] as $number) {
				$number = intval($number);
				$numbers[] = $number;
				if ($number < 1 || $number > 25) {
					$brokenNumbers = true;
					$data["error"] = "numbers_range";
					break;
				}
			}
			if (!$brokenNumbers) {
				$numbers = array_unique($numbers);
				if (sizeof($numbers) < 5 || sizeof($numbers) > 5) {
					$brokenNumbers = true;
					$data["error"] = "numbers_count";
				}
			}
			if (!$brokenNumbers) {
				sort($numbers);
				if ($ticketsCount == 0 || self::$player->chip >= $cost) {
					$prizeNumbers = CacheManager::get('value_casino_sportloto_next_numbers');
					$prizeNumbers = explode(" ", $prizeNumbers);

					$gussed = 0;
					foreach ($numbers as $number) {
						if (in_array($number, $prizeNumbers)) {
							$gussed++;
						}
					}

					if ($ticketsCount > 0) {
						self::$player->chip -= $cost;
						self::$sql->query("UPDATE player SET chip = chip - " . $cost . " WHERE id = " . self::$player->id);
						self::$sql->query("UPDATE casino SET value = value + " . $cost . " WHERE name = 'casino_sportloto_fund'");
					} else {
						 self::$sql->query("UPDATE casino SET value = value + 10 WHERE name = 'casino_sportloto_fund'");
					}
					$data["chip"] = self::$player->chip;
					self::$sql->query("INSERT INTO casino_sportloto(dt, player, numbers, get, chip, gussed) VALUES(NOW(), " . self::$player->id . ", '" . implode(" ", $numbers) . "', FALSE, 0, " . $gussed . ")");
					$data["numbers"] = $numbers;
					$data["success"] = true;
					Page::sendLog(self::$player->id, 'casino_sportloto_get_ticket', array(), 1);
				} else {
					$data["error"] = "chip_limit";
				}
			}
		} else {
			$data["error"] = "tickets_limit";
		}

		Page::endTransaction("casino_sportloto_get_ticket", true);
		echo json_encode($data);
		die();
	}

	public function actionSportlotoGetPrize() {
		Page::startTransaction("casino_sportloto_get_prize", true);
		$data = array();
		$data["success"] = false;

		$pastStart = mktime(0, 0, 0, date("n"), date("j") - 1, date("Y"));
		$pastEnd = mktime(23, 59, 59, date("n"), date("j") - 1, date("Y"));

		$winTickets = self::$sql->getRecordSet("SELECT * FROM casino_sportloto WHERE dt >= '" . date("Y-m-d H:i:s", $pastStart) . "' AND dt <= '" . date("Y-m-d H:i:s", $pastEnd) . "' AND player = " . self::$player->id . " AND chip > 0 AND get = FALSE");
		$prize = 0;
		if ($winTickets && sizeof($winTickets) > 0) {
			$ids = array();
			foreach ($winTickets as $ticket) {
				$ids[] = $ticket["id"];
				$prize += $ticket["chip"];
				if ($ticket["gussed"] == 5) {
					self::$sql->query("INSERT INTO casino_jackpot(dt, player, chip, type) VALUES(NOW(), " . self::$player->id . ", " . $ticket["chip"] . ", 'sportloto')");
				}
			}
			if ($prize > 0) {
				self::$player->chip += $prize;
				self::$sql->query("UPDATE player SET chip = chip + " . $prize . ", casino_today_profit = casino_today_profit + " . $prize . " WHERE id = " . self::$player->id);
			}
			self::$sql->query("UPDATE casino_sportloto SET get = TRUE WHERE id IN (" . implode(", ", $ids) . ")");
			$data["chip"] = self::$player->chip;

			$data["success"] = true;
			Page::sendLog(self::$player->id, 'casino_sportloto_get_prize', array("prize" => $prize), 1);
		} else {
			$data["error"] = "no_tickets";
		}

		Page::endTransaction("casino_sportloto_get_prize", true);
		echo json_encode($data);
		die();
	}

	public function actionKubovichRotateBlack() {
		Page::startTransaction("casino_kubovich_rotate_black", true);
		$data = array();
		$data["reload"] = false;
		$data["success"] = false;
		$time = time();
		$kubovichTime = intval(CacheManager::get("value_casino_kubovich_time"));
		$kubovichEndTime = $kubovichTime + (3600 * CasinoKubovich::PLAY_TIME);
		$data["ready"] = ($time >= $kubovichTime && $time <= $kubovichEndTime);
		if ($data["ready"]) {
			if (is_array($_SESSION["casino_kubovich_prizes"]) && !empty($_SESSION["casino_kubovich_prizes"])) {
				if (self::$player2->casino_kubovich_step < 10) {

					$cost = CasinoKubovich::$cost[self::$player2->casino_kubovich_step];
					$payed = false;
					if (self::$player->chip >= $cost) {
						self::$player->chip -= $cost;
						$payed = true;
						self::$sql->query("UPDATE player SET chip = chip - " . $cost . " WHERE id = " . self::$player->id);
					}
					if ($payed) {
						// Дениги сняли
						$percentStep = 5;
						$data["success"] = true;
						$data["position"] = mt_rand(1, 10);

						$prize = $_SESSION["casino_kubovich_prizes"][$data["position"] - 1];

						Page::fullActions(Page::$player, $prize["action"], "Вы выиграли: <%reward%>");
						$alerts = Runtime::get("alerts");
						$data["text"] = $alerts[0]["text"];
						Page::sendLog(Page::$player->id, "casino_kubovich_prize", array("text" => $data["text"]));
						Runtime::clear("alerts");
						/*
						Page::doActions(Page::$player, $prize["action"], $result);

						if (is_array($result)) {
							$realPrize = $result[0];
							$data["name"] = $realPrize["name"];
							$data["image"] = $realPrize["image"];
						} else {
							$data["name"] = $prize["name"];
							$data["image"] = $prize["image"];
						}
						$data["count"] = $prize["count"];
						Page::sendLog(Page::$player->id, "casino_kubovich_prize", $data, 1);
						*/
						$data["wallet"] = self::$sql->getRecord("SELECT money, ore, honey, chip FROM player WHERE id = " . self::$player->id);
						self::$player2->casino_kubovich_progress = self::$player2->casino_kubovich_progress + $percentStep;
						if (self::$player2->casino_kubovich_progress > 100) {
							self::$player2->casino_kubovich_progress = 100;
						}
						self::$player2->casino_kubovich_step++;
						self::$sql->query("UPDATE player2 SET casino_kubovich_progress = " . self::$player2->casino_kubovich_progress . ", casino_kubovich_step = " . self::$player2->casino_kubovich_step . " WHERE player = " . self::$player->id);
					}
				}
			} else {
				$data["reload"] = true;
			}
		}
		Page::endTransaction("casino_kubovich_rotate_black", true);
		echo json_encode($data);
		die();
	}

	public function actionKubovichRotateYellow() {
		Page::startTransaction("casino_kubovich_rotate_yellow", true);
		$data = array();
		$data["success"] = false;
		$data["reload"] = false;
		$time = time();
		$kubovichTime = intval(CacheManager::get("value_casino_kubovich_time"));
		$kubovichEndTime = $kubovichTime + (3600 * CasinoKubovich::PLAY_TIME);
		$data["ready"] = ($time >= $kubovichTime && $time <= $kubovichEndTime);
		if ($data["ready"]) {
			if (is_array($_SESSION["casino_kubovich_prizes"]) && !empty($_SESSION["casino_kubovich_prizes"])) {
				if (self::$player2->casino_kubovich_progress == 100) {
					$data["success"] = true;
					$data["position"] = mt_rand(1, 10);

				$prize = $_SESSION["casino_kubovich_prizes"][$data["position"] - 1];

				Page::fullActions(Page::$player, $prize["action"], "Вы выиграли: <%reward%>");
				$alerts = Runtime::get("alerts");
				$data["text"] = $alerts[0]["text"];
				Page::sendLog(Page::$player->id, "casino_kubovich_prize", array("text" => $data["text"]));
				Runtime::clear("alerts");
				/*
				if (is_array($result)) {
					$realPrize = $result[0];
					$data["name"] = $realPrize["name"];
					$data["image"] = $realPrize["image"];
				} else {
					$data["name"] = $prize["name"];
					$data["image"] = $prize["image"];
				}
				$data["count"] = $prize["count"];
				Page::sendLog(Page::$player->id, "casino_kubovich_prize", $data, 1);
				*/
				$data["wallet"] = self::$sql->getRecord("SELECT money, ore, honey, chip FROM player WHERE id = " . self::$player->id);

					Page::fullActions(Page::$player, $prize["action"], "Вы выиграли: <%reward%>");
					$alerts = Runtime::get("alerts");
					$data["text"] = $alerts[0]["text"];
					Page::sendLog(Page::$player->id, "casino_kubovich_prize", array("text" => $data["text"]));
					Runtime::clear("alerts");
					/*
					if (is_array($result)) {
						$realPrize = $result[0];
						$data["name"] = $realPrize["name"];
						$data["image"] = $realPrize["image"];
					} else {
						$data["name"] = $prize["name"];
						$data["image"] = $prize["image"];
					}
					$data["count"] = $prize["count"];
					Page::sendLog(Page::$player->id, "casino_kubovich_prize", $data, 1);
					*/
					$data["wallet"] = self::$sql->getRecord("SELECT money, ore, honey, chip FROM player WHERE id = " . self::$player->id);

					self::$player2->casino_kubovich_progress = 0;
					self::$sql->query("UPDATE player2 SET casino_kubovich_progress = " . self::$player2->casino_kubovich_progress . " WHERE player = " . self::$player->id);
				}
			} else {
				$data["reload"] = true;
			}
		}
		Page::endTransaction("casino_kubovich_rotate_yellow", true);
		echo json_encode($data);
		die();
	}

	public function kubovichSortPrizes($prize1, $prize2)
	{
		$a = mt_rand(0, 1000);
		$b = mt_rand(0, 1000);
		$a = $a * $prize1["correction"];
		$b = $b * $prize2["correction"];
		if ($a == $b) {
			return 0;
		}
		return ($a > $b) ? -1 : 1;
	}

	private function kubovichPrepareData() {
		$data = array();
		$data["progress"] = self::$player2->casino_kubovich_progress;
		if ($_POST["type"] == "yellow" && self::$player2->casino_kubovich_progress == 100) {
			$data["step"] = 100;
		} else {
			$data["step"] = self::$player2->casino_kubovich_step;
		}
		if ($data["step"] == 100) {
			$data["type"] = CasinoKubovich::TYPE_YELLOW;
		} else {
			$data["type"] = CasinoKubovich::TYPE_BLACK;
		}

		$data["cost"] = CasinoKubovich::$cost[$data["step"]];

		$data["prizes"] = array();
		$prizes = CasinoKubovich::$step[$data["step"]];
		if (is_array($prizes)) {
			usort($prizes, array($this, "kubovichSortPrizes"));
			$prizes = array_slice($prizes, 0, 10);
			$_SESSION["casino_kubovich_prizes"] = $prizes;
			foreach ($prizes as $prize) {
				if ($prize["count"] > 1) {
					$amount = " (" . $prize["count"] . "шт.)";
				} else {
					$amount = "";
				}
				$data["prizes"][] = array("image" => $prize["image"], "name" => $prize["name"] . $amount, "description" => $prize["info"]);
			}
		} else {
			$_SESSION["casino_kubovich_prizes"] = array();
		}
		$data["steps"] = CasinoKubovich::$cost;

		return $data;
	}

	public function actionKubovichLoad() {
		$ready = true;
		$time = time();
		$kubovichTime = intval(CacheManager::get("value_casino_kubovich_time"));
		$kubovichEndTime = $kubovichTime + (3600 * CasinoKubovich::PLAY_TIME);
		$ready = ($time >= $kubovichTime && $time <= $kubovichEndTime);
		if ($ready) {
			$data = $this->kubovichPrepareData();
		} else {
			$data = array("ready" => false);
		}
		echo json_encode($data);
		die();
	}

	public function actionConvertOre() {
		Page::startTransaction("casino_convert_ore", true);
		$data = array();
		$data["success"] = false;
		$data["nemoney"] = true;
		$data["ore"] = self::$player->ore;
		$data["error"] = "";
		$count = intval($_POST["count"]);
		if ($count < 0) $count = 0;
		if ($count <= 0) {
			$data["error"] = "null";
		}
		if (self::$player->ore >= $count && $count > 0) {
			$data["nemoney"] = false;
			$chip = ($count * CasinoSlots::COURSE_ORE_CHIP);
			$data["rest"] = CasinoSlots::MAX_CHIP - self::$player2->casino_today_chip;
			if (self::$player2->casino_today_chip + $chip <= CasinoSlots::MAX_CHIP) {
				self::$sql->query("UPDATE player SET ore = ore - " . $count . ", chip = chip + " . $chip . " WHERE id = " . self::$player->id);
				self::$sql->query("UPDATE player2 SET casino_today_chip = casino_today_chip + " . $chip . " WHERE player = "  . self::$player->id);
				self::$sql->query("UPDATE casino SET value = value + " . $count . " WHERE name = 'casino_slots_ore_in'");
				$data["success"] = true;
				$data["ore"] -= $count;
				self::$player->chip += $chip;
				$data["chip"] = self::$player->chip;
				$data["count"] = $chip;
				self::$player->ore -= $count;
				Page::sendLog(self::$player->id, 'casino_exchange_ore', array("in" => $count, "out" => $chip, "mbckp" => array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey)), 1);
			}
		}
		Page::endTransaction("casino_convert_ore", true);
		echo json_encode($data);
		die();
	}

	public function actionConvertHoney() {
		Page::startTransaction("casino_convert_honey", true);
		$data = array();
		$data["success"] = false;
		$data["nemoney"] = true;
		$data["honey"] = self::$player->honey;
		$data["error"] = "";
		$count = intval($_POST["count"]);
		if ($count < 0) $count = 0;
		if ($count > 0) {
			$takeResult = self::doBillingCommand(self::$player->id, $count, "takemoney", "casino chip");
			if ($takeResult[0] == "OK") {
				$data["nemoney"] = false;
				$data["honey"] -= $count;
				$chip = ($count * CasinoSlots::COURSE_HONEY_CHIP);
				self::$sql->query("UPDATE player SET chip = chip + " . $chip . " WHERE id = " . self::$player->id);
				self::$sql->query("UPDATE casino SET value = value + " . $count . " WHERE name = 'casino_slots_honey_in'");
				$data["success"] = true;
				self::$player->chip += $chip;
				self::$player->honey -= $count;
				$data["chip"] = self::$player->chip;
				$data["count"] = $chip;
				Page::sendLog(self::$player->id, 'casino_exchange_honey', array("in" => $count, "out" => $chip, "mbckp" => array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey)), 1);
			}
		} else {
			$data["error"] = "null";
		}
		Page::endTransaction("casino_convert_honey", true);
		echo json_encode($data);
		die();
	}

	public function actionConvertChip() {
		Page::startTransaction("casino_convert_chip", true);
		$data = array();
		$data["success"] = false;
		$data["nechip"] = true;
		$data["allow"] = false;
		$data["min"] = CasinoSlots::MIN_WITHDRAWAL;
		$data["chip"] = self::$player->chip;
		$data["ore"] = self::$player->ore;
		$count = intval($_POST["count"]);
		if ($count < 0) $count = 0;
		if ($count >= CasinoSlots::MIN_WITHDRAWAL) {
			$data["allow"] = true;
			if (self::$player->chip >= $count) {
				$count = floor($count / 10) * 10;
				$data["chip"] -= $count;
				$data["nechip"] = false;
				$ore = $count / 10;
				self::$player->chip -= $count;
				self::$player->ore += $ore;
				$data["ore"] += $ore;
				self::$sql->query("UPDATE player SET ore = ore + " . $ore . ", chip = chip - " . $count . " WHERE id = " . self::$player->id);
				self::$sql->query("UPDATE casino SET value = value + " . $ore . " WHERE name = 'casino_slots_ore_out'");
				$data["success"] = true;
				$data["count"] = $ore;
				Page::sendLog(self::$player->id, 'casino_exchange_chip', array("in" => $count, "out" => $ore, "mbckp" => array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey)), 1);
			}
		}
		Page::endTransaction("casino_convert_chip", true);
		echo json_encode($data);
		die();
	}

	private function isComb($win, $current) {

		//$sum = array();
		$count = 0;
		for ($i = 0; $i < 3; $i++) {
			if ($win[$i] == "?") {
				$count++;
				continue;
			}
			$key = array_search($win[$i], $current);
			if ($key !== false) {
				$count++;
				unset($current[$key]);
			}
		}
		return ($count == 3);
		/*
		for ($i = 0; $i < 3; $i++) {
			if ($win[$i] == "?") $sum[$i] = 0;
			else $sum[$i] = $current[$i] - $win[$i];
		}
		if ($sum[0] == 0 && $sum[1] == 0 && $sum[2] == 0) {
			return true;
		} else {
			return false;
		}
		*/
	}
	private function slotsCheckWin($result) {
		$keys = array_keys(CasinoSlots::$table);
		foreach ($keys as $key) {
			if ($this->isComb(array(substr($key, 0, 1), substr($key, 1, 1), substr($key, 2, 1)), $result)) {
				return $key;
			}
		}
		return false;
	}

	private function slotsGetResult() {
		$result = array();
		$result[0] = mt_rand(1, 9);
		$result[1] = mt_rand(1, 9);
		$result[2] = mt_rand(1, 9);
		
	
		return $result;
	}

	private function fixResult($comb, &$result, $cost) {
		// злой обман
		$minBalance = 0;
		$maxBalance = 25000;
		$balance = self::$sql->getValue("SELECT value FROM casino WHERE name = 'casino_slots_balance'");

		

		$add = $cost * 0.90;
		$balance += $add;

		if ($balance < $minBalance && $comb !== false) {
			// если казино в минусе и если мы выйграли
			$redropProbability = 5 + 1;
			if (mt_rand(1, 10) < $redropProbability) {
				$result = $this->slotsGetResult();
			}
		} elseif ($balance > $maxBalance && $comb === false) {
			// если казино в плюсе и если мы НЕ выйграли
			$redropProbability = 5 + 1;
			if (mt_rand(1, 10) < $redropProbability) {
				$result = $this->slotsGetResult();
			}
		}

		 // если у юзера дофига фишек
		 
		  if (self::$player->chip>1000 && $comb !== false) {
				$redropProbability = 1 + 1;
				if (mt_rand(1, 10) < $redropProbability) {
					$result = $this->slotsGetResult();
				}
		  }
		 
		 
		 // злой обман
		if ($result[0] == 9 && $result[1] == 9 && $result[2] == 9) {
			if (mt_rand(1, 1500) < 1499) {
				$result = $this->slotsGetResult();
			}
		}
		
		// Отдаём джекпот только раз в сутки
		/*
		if ($cost == 30 && $result[0] == 9 && $result[1] == 9 && $result[2] == 9) {
			$timeJackpot = intval(self::$sql->getValue("SELECT value FROM casino WHERE name = 'casino_slots_jackpot_time'"));
			if ($timeJackpot + 86400 > time()) {
				$result = $this->slotsGetResult();
			} else {
				self::$sql->query("UPDATE casino SET value = " . time() . " WHERE name = 'casino_slots_jackpot_time'");
			}
		}
		*/

		$comb = $this->slotsCheckWin($result);
		if ($comb !== false) {
			$profit = CasinoSlots::$table[$comb][($cost / 10) - 1];
			
			if ($profit == "j") {$profit=0;}
			$add -= $profit;
		}
		if ($add < 0) {
			$z = "-";
		} else {
			$z = "+";
		}
		self::$sql->query("UPDATE casino SET value = value " . $z . "" . abs($add) . " WHERE name = 'casino_slots_balance'");

		return $comb;
	}

	public function actionSlotsSpin() {
		Page::startTransaction("casino_slots_spin", true);
		$data = array();
		$data["success"] = false;
		$data["win"] = false;
		$data["jwin"] = false;

		$cost = intval($_POST["count"]);
		if ($cost < 10) $cost = 10;
		if ($cost > 10 && $cost < 20) $cost = 10;
		if ($cost > 20 && $cost < 30) $cost = 20;
		if ($cost > 30) $cost = 30;
		$payed = false;
		if (self::$player->chip >= $cost) {
			self::$player->chip -= $cost;
			$payed = true;
			self::$sql->query("UPDATE player SET chip = chip - " . $cost . " WHERE id = " . self::$player->id);
			self::$sql->query("UPDATE casino SET value = value + " . $cost . " WHERE name = 'casino_slots_in'");
		}

		if ($payed) {
			$jackpot = self::$sql->getValue("SELECT value FROM casino WHERE name = 'casino_slots_jackpot'");
			$jackpot = (double) $jackpot;
			$add = $cost * 0.01;
			$jackpot += $add;
			$data["jackpot"] = floor($jackpot);
			self::$sql->query("UPDATE casino SET value = value + " . $add . " WHERE name = 'casino_slots_jackpot'");

			$data["chip"] = self::$player->chip;
			$data["newchip"] = self::$player->chip;
			$data["success"] = true;
			$result = $this->slotsGetResult();

			$comb = $this->slotsCheckWin($result);
			$comb = $this->fixResult($comb, $result, $cost);

			$data["result"] = $result;
			$data["comb"] = $result;


			if ($comb) {
				$data["win"] = true;
				$data["comb"] = array(substr($comb, 0, 1), substr($comb, 1, 1), substr($comb, 2, 1));

				// Выиграли
				$profit = CasinoSlots::$table[$comb][($cost / 10) - 1];
				//$profit = 400;
				if ($profit == "j") {
					$data["jwin"] = true;
					self::$sql->query("UPDATE casino SET value = 3000 WHERE name = 'casino_slots_jackpot'");
					$data["jackpot"] = 3000;
					$profit = floor($jackpot);
					self::$sql->query("INSERT INTO casino_jackpot(dt, player, chip, type) VALUES(NOW(), " . self::$player->id . ", " . $profit . ", 'slots')");
					$this->chatCasinoSend("Заядлый игрок " . self::$player->nickname . " выиграл джекпот " . $profit . " фишек");

                    //self::$sql->query("UPDATE casino SET value = value - " . $profit . " WHERE name = 'casino_slots_balance'");
					
				} else {
					if ($profit >= 300) {
						$this->chatCasinoSend("Заядлый игрок " . self::$player->nickname . " выиграл " . $profit . " фишек");
					}
				}
				self::$sql->query("UPDATE casino SET value = value + " . $profit . " WHERE name = 'casino_slots_out'");
				$data["newchip"] += $profit;
				$data["profit"] = $profit;
				self::$sql->query("UPDATE player SET chip = chip + " . $profit . ", casino_today_profit = casino_today_profit + " . $profit . " WHERE id = " . self::$player->id);
			}
		}
		Page::endTransaction("casino_slots_spin", true);
		echo json_encode($data);
		die();
	}

	private function chatCasinoSend($text)
    {
		if (DEV_SERVER) {
			$address = "dev.moswar.ru";
		} else {
			$address = "85.112.113.75";
		}
		$port = 8081;
		if (($socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) && (@socket_connect($socket, $address, $port)))
		{
			@socket_write($socket, '{"action":"casino","data":{"message":"' . $text . '","key":"casinocasinocasino1~"}}' . "\n");
			//socket_write($socket, '{"action":"quit","data":{}}' . "\n");
			@socket_close($socket);
		}
	}

	public function processRequest() {
		parent::onBeforeProcessRequest();
		$this->needAuth();
		if (!empty($_POST["action"])) {
			switch ($this->url[0]) {
				
				case "kubovich" :
					switch ($_POST["action"]) {
						case "black" :
							$this->actionKubovichRotateBlack();
							break;
						case "yellow" :
							$this->actionKubovichRotateYellow();
							break;
						case "load" :
							$this->actionKubovichLoad();
							break;
					}
					break;
				
				case "sportloto" :
					switch ($_POST["action"]) {
						case "ticket" :
							$this->actionSportlotoGetTicket();
							break;
						case "prize" :
							$this->actionSportlotoGetPrize();
							break;
					}
					break;
				case "slots" :
					switch ($_POST["action"]) {
						case "spin" :
							$this->actionSlotsSpin();
							break;
					}
					break;
				default :
					switch ($_POST["action"]) {
						case "ore" :
							$this->actionConvertOre();
							break;
						case "honey" :
							$this->actionConvertHoney();
							break;
						case "chip" :
							$this->actionConvertChip();
							break;
					}
					break;
			}
		} else {
			switch ($this->url[0]) {
				case "slots" :
					$this->showSlots();
					break;
				
				case "kubovich" :
					if (DEV_SERVER)
						$this->showKubovich();
					break;
				
				case "sportloto" :
					$this->showSportloto();
					break;
				default :
					$this->showCasino();
					break;
			}
		}

		parent::onAfterProcessRequest();
	}

}

?>
