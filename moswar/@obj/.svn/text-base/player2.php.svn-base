<?php
class player2Object extends player2BaseObject
{
    public $travma = 0;

	public function __construct()
	{
		parent::__construct();
	}

    public function load($playerId)
    {
        $object = $this->sql->getRecord("SELECT * FROM `player2` WHERE player=" . $playerId);
		//$object = Page::sqlQueryOverPS('object_player2_load', array('@player' => $playerId));
        $this->init($object);
        $this->travma = strtotime($this->travmadt) > time() ? 1 : 0;
        //$this->config = json_decode($this->config, true);
    }

    /*
    public function saveConfig()
    {
        $this->config = json_encode($this->config);
        $this->save($this->id, array(player2Object::$CONFIG));
        $this->config = json_decode($this->config, true);
    }
    */

    public function toArray()
    {
        Std::loadLib('HtmlTools');

        $object = parent::toArray();
        $object['travma'] = $this->travma;
        $object['travmadt'] = HtmlTools::FormatDateTime($this->travmadt, true);
        return $object;
    }

    public function loadFullProfile($sex) {
		$data = CacheManager::get('player_location', array('player_id' => $this->player, 'player2_id' => $this->id));

        $this->country = $data['country'];
        $this->city = $data['city'];
        $this->metro = $data['metro'];
        $family = array('male' => array(
                'single'  => 'Холост',
                'friend'  => 'Есть девушка',
                'engaged' => 'Помолвлен',
                'married' => 'Женат',
                'mixed'   => 'Сам не пойму',
                'search'  => 'В активном поиске',
            ), 'female' => array(
                'single'  => 'Сама по себе',
                'friend'  => 'Есть парень',
                'engaged' => 'Помолвлена',
                'married' => 'Замужем',
                'mixed'   => 'Эх, сама не пойму',
                'search'  => 'В активном поиске',
            ));
        $this->family = $family[$sex][$data['family']];

		$this->interests = CacheManager::get('player_interests', array('player_id' => $this->player, 'player2_id' => $this->id));
		if (!$this->interests) {
            $this->interests = '';
        }
		
        $this->about = nl2br($this->about);
    }
}
?>