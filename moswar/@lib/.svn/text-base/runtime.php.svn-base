<?php
/**
 * Класс для хранения рабочих данных
 *
 */
class Runtime
{
    private static $isContentico;
    private static $var = array();
    
    /**
     * ID авторизованного пользователя
     *
     * @var int
     */
    public static $uid = 0;
    /**
     * ID группы авторизованного пользователя
     *
     * @var int
     */
    public static $gid = 0;

    /**
     * Список загруженных классов
     *
     * @var array
     */
    public static $loadedLibs = array();

    /**
     * Инициализация
     *
     * @param bool $isContentico
     */
    public static function init($isContentico=false)
    {
        self::$isContentico = $isContentico;
        self::$var = array();
        //
        if (is_array($_SESSION[(self::$isContentico ? '@' : '').'runtime'])) {
            foreach ($_SESSION[(self::$isContentico ? '@' : '').'runtime'] as $var=>$value) {
                self::$var[$var] = $value;
            }
        }
        //
        self::$uid = $_SESSION[(self::$isContentico ? '@' : '').'runtime']['uid'];
        self::$gid = $_SESSION[(self::$isContentico ? '@' : '').'runtime']['gid'];
    }

    /**
     * Получение значения
     *
     * @param string $var
     * @return mixed
     */
    public static function get($var)
    {
		if (strpos($var, '/') !== false) {
			list($var, $key) = explode('/', $var);
			return isset(self::$var[$var][$key]) ? self::$var[$var][$key] : false;
		} else {
			return isset(self::$var[$var]) ? self::$var[$var] : false;
		}
    }

    /**
     * Установка значения
     *
     * @param string $var
     * @param mixed $value
     */
    public static function set($var, $value)
    {
		if (strpos($var, '/') !== false) {
			list($var, $key) = explode('/', $var);	
			if ($key != '') {
				$_SESSION[(self::$isContentico ? '@' : '').'runtime'][$var][$key] = $value;
				self::$var[$var][$key] = $value;
			} else {
				$_SESSION[(self::$isContentico ? '@' : '').'runtime'][$var][] = $value;
				self::$var[$var][] = $value;
			}
		} else {
			$_SESSION[(self::$isContentico ? '@' : '').'runtime'][$var] = $value;
			self::$var[$var] = $value;
		}
    }

    /**
     * Удаление переменной
     *
     * @param string $Var
     */
    public static function clear($var = "")
    {
        if ($var) {
			unset($_SESSION[(self::$isContentico ? '@' : '').'runtime'][$var]);
			unset(self::$var[$var]);
		} else {
			$vars = array_keys(self::$var);
			foreach ($vars as $var) {
				unset($_SESSION[(self::$isContentico ? '@' : '').'runtime'][$var]);
				unset(self::$var[$var]);
			}
		}
    }
}
?>