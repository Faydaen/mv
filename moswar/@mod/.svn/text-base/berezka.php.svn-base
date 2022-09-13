<?php
class Berezka extends Page implements IModule
{
    public $moduleCode = 'Berezka';

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
        //
		$this->needAuth(true);

		$this->showShop();

        //
        parent::onAfterProcessRequest();
    }

	public function showShop() {

		$this->content['player'] = self::$player->toArray();
		$this->content["key"] = self::getPostKey();
		$this->content['war_zub'] = 0;
		$this->content['war_goldenzub'] = 0;
		$this->content['huntclub_badge'] = 0;
		$this->content['huntclub_mobile'] = 0;
		$this->content['fight_star'] = 0;
		$tmp = Page::$sql->getRecordSet("SELECT code, sum(durability) as amount FROM inventory WHERE player = " . self::$player->id . " and code in ('war_zub', 'war_goldenzub', 'fight_star', 'huntclub_badge', 'huntclub_mobile') group by code");
		if ($tmp)
		foreach ($tmp as $i) {
			$this->content[$i['code']] = (int) $i['amount'];
		}

		$this->content['mysex'] = self::$player->sex;
        $this->content['playerlevel'] = self::$player->level;
		$this->content['player'] = self::$player->toArray();

                Std::loadMetaObjectClass ('standard_item');
		$criteria = new ObjectCollectionCriteria();
		$criteria->createWhere(standard_itemObject::$LEVEL, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_SMALLER, self::$player->level+1);
		$criteria->createWhere(standard_itemObject::$SHOP, ObjectCollectionCriteria::$COMPARE_EQUAL, 'berezka');
		if (self::$player->accesslevel < 100) {
			$criteria->createWhere(standard_itemObject::$BUYABLE, ObjectCollectionCriteria::$COMPARE_EQUAL, 1);
			$criteria->where[] = "(standard_item.shopdt1 = '0000-00-00 00:00:00' or standard_item.shopdt1 <= now()) and (standard_item.shopdt2 = '0000-00-00 00:00:00' or standard_item.shopdt2 >= now())";
			$criteria->where[] = "(standard_item.maxlevel = 0 or standard_item.maxlevel >= " . self::$player->level . ")";
		}
		$criteria->createOrder(standard_itemObject::$LEVEL, ObjectCollectionCriteria::$ORDER_DESC);
		$criteria->createWhere(standard_itemObject::$TYPE2, ObjectCollectionCriteria::$COMPARE_EQUAL, 'player');
		$collection = new ObjectCollection();
		$standard_itemCollection = $collection->getArrayList (standard_itemObject::$METAOBJECT, $criteria);
		$this->content['items'] = $standard_itemCollection;

		if (is_array($this->content['items']) && count($this->content['items'])) {
			foreach ($this->content['items'] as $key => &$standard_item) {
				// Проверка наличия даты окончания продажи
				if ($standard_item["shopdt2"] != "0000-00-00 00:00:00") {
					$standard_item["shopdt2"] = date("d.m.Y H:i:s", strtotime($standard_item["shopdt2"]));
					$standard_item["shopdt2"] = str_replace(" 00:00:00", "", $standard_item["shopdt2"]);
				} else {
					$standard_item["shopdt2"] = "";
				}

				$standard_item['info'] = nl2br($standard_item['info']);
				
				if (self::$player->level >= 4 && self::$player->level + 1 >= $standard_item["level"] && self::$player->level < $standard_item["level"] && !empty($standard_item["slot"])) {
					$standard_item["forgrowth"] = 1;
				}

				// цена продажи, если предмет продается
				/*if ($standard_item['sellable'] == 1 && (floor($standard_item['money'] * Shop::$sell_procent) > 0 || floor($standard_item['ore'] * Shop::$sell_procent) > 0 || floor($standard_item['honey'] * Shop::$sell_procent) > 0) && (Shop::$section == 'mine' || self::$player->hasItemByStandardId($standard_item['id']))) {
					$standard_item['sell']['money'] = floor($standard_item['money'] * Shop::$sell_procent);
					$standard_item['sell']['ore'] = floor($standard_item['ore'] * Shop::$sell_procent);
				}*/
				// питомец, если мы сечас в секции "Мои вещи"
				/*if ($standard_item['type'] == 'pet' && self::$player->pet->item == $standard_item['id']) {
					if (Shop::$section == 'mine') {
						$prices = Page::$sql->getRecord("select money, ore from standard_item where id = " . $standard_item['item']);
						$standard_item['sell']['money'] = floor($prices['money'] * Shop::$sell_procent);
						$standard_item['sell']['ore'] = floor($prices['ore'] * Shop::$sell_procent);
					} else {
						$standard_item['sell']['money'] = floor($standard_item['money'] * Shop::$sell_procent);
						$standard_item['sell']['ore'] = floor($standard_item['ore'] * Shop::$sell_procent);
					}
				}*/
				// если мы в секции "Мои вещи", а предмет не продается, то он убирается из списка предметов
				/*if (Shop::$section == 'mine' && $standard_item['sell']['money'] == 0 && $standard_item['sell']['ore'] == 0) {
					unset($this->content['items'][$key]);
				}*/
				Page::parseSpecialParams($standard_item);

				if ($standard_item['type'] == 'pet') {
					$standard_item['effects'][] = array('param' => ($standard_item['itemlevel'] ? $standard_item['itemlevel'] : $standard_item['procent']) . '% от характеристик хозяина');
				} else if ($standard_item['type'] == 'petfood' || $standard_item['type'] == 'petautofood') {
					$standard_item['effects'][] = array('param' => 'Восстанавливает ' . $standard_item['itemlevel'] . '% здоровья питомца');
				} else if ($standard_item['type'] == 'home_comfort') {
					$standard_item['effects'][] = array('param' => 'Комфорт', 'value' => $standard_item['itemlevel']);
				} else if ($standard_item['type'] == 'home_defence') {
					$standard_item['effects'][] = array('param' => 'Защита дома', 'value' => $standard_item['itemlevel']);
				} else if ($standard_item['type'] == 'home_safe') {
					$standard_item['effects'][] = array('param' => 'Сохраняет ' . ($standard_item['itemlevel'] * 100) . ' монет на уровень при ограблении Вас');
				}
				$standard_item['time'] = str_replace(array('d', 'h', 'm', 's'), array(' д', ' ч', ' м', ' с'), $standard_item['time']);
			}
		}

		$this->content['return_url'] = '/berezka/';
		$this->content['shop'] = 'berezka';

		$this->content['window-name'] = "Берёзка";
        $this->page->addPart('content', 'berezka/berezka.xsl', $this->content);
	}
}
?>