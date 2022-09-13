<?php
/**
 * Полезные функции
 *
 */
class HtmlTools
{
    // Словари

    /**
     * Названия месяцев
     *
     * @var array
     */
    public static $months = array('', 'январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');

    /**
     * Короткие названия месяцев
     *
     * @var array
     */
    public static $monthsShort = array('', 'янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек');

    /**
     * Названия месяцев в родительном падеже
     *
     * @var array
     */
    public static $months2 = array('', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');

    /**
     * Названия дней недели
     *
     * @var array
     */
    public static $weekDays = array('', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье');

	/**
     * Названия дней недели в винительном падеже
     *
     * @var array
     */
    public static $weekDaysV = array('', 'понедельник', 'вторник', 'среду', 'четверг', 'пятницу', 'субботу', 'воскресенье');

    /**
     * Короткие названия дней недели
     *
     * @var array
     */
    public static $WeekDaysShort = array('', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб', 'вс');

    // Функции

    /**
     * Форматировать строку с денежной суммой
     *
     * @param float $money
     * @param int $decPlaces
     * @param string $symbol
     * @return string
     */
    static public function FormatMoney($money, $decPlaces=0, $symbol='')
    {
        return number_format($money, $decPlaces, ',', ' ') . ($symbol == '' ? '' : ' ' . $symbol);
    }

    /**
     * Преобразовать SQL datetime в нормальный вид
     *
     * @param string $DateTime
     * @param bool $ShowTime
     * @param bool $MonthAsName
     * @param bool $ShortMonthNames
     * @return string
     */
    public static function FormatDateTime ($DateTime, $ShowTime=true, $MonthAsName=true, $ShortMonthNames=false, $showSeconds = false)
    {
        $dt = explode(' ', $DateTime);
        $d = explode('-', $dt[0]);
		//if ($d[0]==date("Y")) $d[0] = '';
		//else $d[0] = ' '.$d[0];
        return (int)$d[2].($MonthAsName ? ' '.($ShortMonthNames ? self::$monthsShort[(int) $d[1]] : self::$months2[(int) $d[1]]).' ' : '.'.$d[1].'.').$d[0].($ShowTime ? ' '.substr($dt[1], 0, ($showSeconds ? 8 : -3)) : '');
    }

	/*
	 *
	 *
	 */
	public static function FormatWeekDay ($Date, $v = false, $shortWeekDays = false)
	{
		$dt = explode(' ', $Date);
		$day = date ("w", strtotime ($dt[0]));
		if ($day == 0) {
			$day = 7;
        }
		if ($shortWeekDays) {
			return self::$weekDaysShort[$day];
		} elseif ($v) {
			return self::$weekDaysV[$day];
		} else {
			return self::$weekDays[$day];
		}
	}


    /**
     * Форматировать размер файла
     *
     * @param int $Size
     * @return string
     */
    public static function FormatFileSize($Size)
    {
        $Sizes = array('б', 'кб', 'мб', 'гб');
        $i = 0;
        while ($Size > 1024) {
        	$Size /= 1024;
        	$i++;
        }
        return round($Size, 2).' '.$Sizes[$i];
    }

    /**
     * Генерация <option> для <select>
     *
     * @param mixed $query - SQL запрос или массив значений
     * @param int $selectedId - Значение выделенного <option>
     * @return string
     */
    public static function GenerateOptions($Query, $SelectedId=0)
    {
        $Sql = SqlDataSource::GetInstance();
        if (is_string($Query)) {
            $list = $Sql->GetRecordSet($Query);
            $options = '';
            if ($list) {
                foreach ($list as $item) {
                    $options .= '<option value="'.$item['id'].'" '.($item['id'] == $SelectedId ? 'selected="selected"' : '').'>'.$item['name'].'</option>';
                }
            }
        } elseif (is_array($Query)) {
            $options = '';
            foreach ($Query as $i=>$item) {
                if (is_array($item)) {
                    $value = $item['id'] ? $item['id'] : $item[0];
                    $name = $item['name'] ? $item['name'] : $item[0];
                } else {
                    $value = $i;
                    $name = $item;
                }
                $options .= '<option value="'.$value.'" '.($value == $SelectedId ? 'selected="selected"' : '').'>'.$name.'</option>';
            }
        }
        return $options;
    }

    /**
     * Генерация <option> для <select> с последовательными числами
     *
     * @param int $From
     * @param int $To
     * @param int $SelectedValue
     * @param int $Step
     * @return string
     */
    static public function GenerateOptionsCounter($From, $To, $SelectedValue, $Step=1)
    {
        $Html = '';
        $i = $From;
        while ($i <= $To) {
            $Html .= '<option value="'.$i.'" '.($SelectedValue == $i ? 'selected="selected"' : '').'>'.$i.'</option>';
            $i += $Step;
        }
        return $Html;
    }

    /**
     * Типографировать текст
     *
     * @param string $Str
     * @return string
     */
    /*
    {
        Std::LoadLib('typograph');
        return Typograph::process($Str);
    }
	*/


	public static function russianNumeral($n, $form1, $form2, $form5)
	{
		$n = abs($n) % 100;
		$n1 = $n % 10;
		if ($n > 10 && $n < 20) return $form5;
		if ($n1 > 1 && $n1 < 5) return $form2;
		if ($n1 == 1) return $form1;
		return $form5;
	}
}
?>