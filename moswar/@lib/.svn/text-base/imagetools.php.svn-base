<?php
/**
 * Класс для работы с изображениями
 *
 */
class ImageTools
{
    /**
     * Загрузка картинки
     *
     * @param string $imagePath
     * @return object
     */
    private static function loadImage($imagePath)
    {
        $ext = explode('.', $imagePath);
        switch (strtolower($ext[sizeof($ext)-1]))
        {
            case 'jpeg':
        	case 'jpg':
        		return imagecreatefromjpeg($imagePath);
        		break;
        	case 'gif':
        	    return imagecreatefromgif($imagePath);
        	    break;
        	case 'png':
        	    return imagecreatefrompng($imagePath);
        	    break;
    	    default:
                return false;
        }
    }

    /**
     * Сохранение картинки
     *
     * @param object $image
     * @param string $path
     */
    private static function saveImage($image, $path)
    {
        $ext = explode('.', $path);
        switch (strtolower($ext[sizeof($ext)-1]))
        {
            case 'jpeg':
            case 'jpg':
                imagejpeg($image, $path, 90);
                break;
            case 'gif':
                imagegif($image, $path);
                break;
            case 'png':
				imagealphablending($image, false);
				imagesavealpha($image, true);
                imagepng($image, $path);
                break;
            default:
                return false;
                break;
        }
        return true;
    }

    /**
     * Получение высоты и ширины картинки
     *
     * @param string $imagePath
     * @return array
     */
    public static function getSize($imagePath)
    {
        $image = self::loadImage($imagePath);
        return array(imagesx($image), imagesy($image));
    }

    /**
     * Создание thumbnail'а картинки
     *
     * @param string $srcImage
     * @param string $destImage
     * @param int $maxX
     * @param int $maxY
     * @return bool
     */
    public static function createThumbnail($srcImage, $destImage, $maxX=100, $maxY=100)
    {
        $image = self::loadImage($srcImage);
        if (!$image)
        {
            return false;
        }
        $x = imagesx($image);
        $y = imagesy($image);
        //
        if ($x <= $maxX && $y <= $maxY)
        {
            copy($srcImage, $destImage);
            imagedestroy($image);
            return true;
        }
        else {
            if ($x < $maxX)
            {
                $maxX = $x;
            }
            if ($y < $maxY)
            {
                $maxY = $y;
            }
            $kx = $x / $maxX;
            $ky = $y / $maxY;
            if ($kx < 1)
            {
                $kx = 1;
            }
            if ($ky < 1)
            {
                $ky = 1;
            }
            $k1 = $kx < $ky ? $kx : $ky;
            $xx = floor($x / $k1);
            $yy = floor($y / $k1);
            $maxXX = floor($maxX / $k1 * $kx);
            $maxYY = floor($maxY / $k1 * $ky);
            $newImage1 = imagecreatetruecolor($maxXX, $maxYY);
            imagecopyresampled($newImage1, $image, 0, 0, 0, 0, $maxXX, $maxYY, $x, $y);
            if ($k1 == $kx)
            {
                $maxYYY = floor(($maxYY - $maxY) / 2);
                $maxXXX = 0;
            }
            else
            {
                $maxXXX = floor(($maxXX - $maxX) / 2);
                $maxYYY = 0;
            }
            $newImage2 = imagecreatetruecolor($maxX, $maxY);
            imagecopyresampled($newImage2, $newImage1, 0, 0, $maxXXX, $maxYYY, $maxX, $maxY, $maxXX-$maxXXX*2, $maxYY-$maxYYY*2);
        }
        //
        $ok = self::saveImage($newImage2, $destImage);
        imagedestroy($image);
        imagedestroy($newImage1);
        imagedestroy($newImage2);
        return $ok ? true : false;
    }

	private static function crop($image, $x, $y, $width, $height, $dstWidth, $dstHeight) {
		$result = imagecreatetruecolor($dstWidth, $dstHeight);
		imagefilledrectangle($result, 0, 0, $dstWidth, $dstWidth, imagecolorallocate($result, 255, 255, 255));
		if(@imagecopyresampled($result, $image, 0, 0, $x, $y, $dstWidth, $dstHeight, $width, $height)) return $result;
		else return false;
	}

    /**
     * Изменение размеров картинки
     *
     * @param string $srcImage
     * @param string $destImage
     * @param int $newX
     * @param int $newY
     * @return bool
     */
    public static function resize($srcImage, $destImage, $newX, $newY, $fixedSize = false)
    {
        $image = self::loadImage($srcImage);
        if (!$image)
        {
            return false;
        }
        $x = imagesx($image);
        $y = imagesy($image);
        //
		if (!$fixedSize) {
			if (($x <= $newX) and ($y <= $newY))
			{
				//copy($srcImage, $destImage);
				self::saveImage($image, $destImage);
				imagedestroy($image);
				return true;
			}
			else
			{
				if($newX / $x > $newY / $y) { $koef = $newY / $y; }
				else { $koef = $newX / $x; }
				$newX = $x * $koef;
				$newY = $y * $koef;
			}
			$newImage = imagecreatetruecolor($newX, $newY);

			$color = imagecolorallocate($newImage, 255, 255, 255);
			imagefill($newImage, 0, 0, $color);

			imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newX, $newY, $x, $y);
		} else {
			$ratio = $newX / $newY;

			if ($x > $y) {
				$start = ($x - $y * $ratio) / 2;
				$cropX = $start;
				$cropY = 0;
				//$cropWidth = $newWidth - ($cropX * 2);
				$cropWidth = $y * $ratio;
				$cropHeight = $y;
			} else {
				$start = ($y - $x / $ratio) / 4;
				$cropX = 0;
				$cropY = $start;
				$cropWidth = $x;
				//$cropHeight = $newHeight - ($cropY * 4);
				$cropHeight = $x / $ratio;
			}
			$newImage = self::crop($image, $cropX, $cropY, $cropWidth, $cropHeight, $newX, $newY);
		}
        $ok = self::saveImage($newImage, $destImage);
        imagedestroy($image);
        imagedestroy($newImage);
        return $ok ? true : false;
    }

    /**
     * Нанесение текста (watermark) на картинку
     *
     * @param string $imagePath
     * @param string $text
     * @param string $position
     * @param int $size
     * @return bool
     */
    public static function createWatermark($imagePath, $text, $position, $size, $ttfFontPath)
    {
        $image = self::loadImage($imagePath);
        if (!$image)
        {
            return false;
        }
        $box = imagettfbbox($size, 0, $ttfFontPath, $text);
        $w = imagesx($image);
        $h = imagesy($image);
        switch ($position)
        {
            case 'TOP_LEFT':
                $x = $y = 10;
                break;
            case 'TOP_RIGHT':
                $x = $w - ($box[2] - $box[0]) - 10;
                $y = 10;
                break;
            case 'BOTTOM_LEFT':
                $x = 10;
                $y = $h - ($box[6] - $box[1]) - 10;
                break;
            case 'BOTTOM_RIGHT':
                $x = $w - ($box[2] - $box[0]) - 10;
                $y = $h - ($box[6] - $box[1]) - 10;
                break;
            case 'CENTER':
                $x = round(($w - ($box[2] - $box[0]) - 10) / 2);
                $y = round(($h - ($box[6] - $box[1]) - 10) / 2);
                break;
        }
        $color = imagecolorallocatealpha($image, 255, 255, 255, 75);
        imagettftext($image, $size, 0, $x, $y, $color, $ttfFontPath, $text);
        $ok = self::saveImage($image, $imagePath);
        imagedestroy($image);
        return $ok ? true : false;
    }

    /**
     * Нанесение картинки (watermark) на картинку
     *
     * @param string $imagePath
     * @param string $watermarkPath
     * @param string $position
     * @param int $xMargin
     * @param int $YMargin
     * @return bool
     */
    public static function applyWatermark($imagePath, $watermarkPath, $position, $xMargin=0, $yMargin=0)
    {
        $image = self::loadImage($imagePath);
        if (!$image)
        {
            return false;
        }
        $watermark = self::loadImage($watermarkPath);
        if (!$watermark)
        {
            return false;
        }
        $w = imagesx($image);
        $h = imagesy($image);
        $ww = imagesx($watermark);
        $wh = imagesy($watermark);
        switch ($position)
        {
            case 'TOP_LEFT':
                $x = $xMargin;
                $y = $yMargin;
                break;
            case 'TOP_RIGHT':
                $x = $w - $ww - $xMargin;
                $y = $yMargin;
                break;
            case 'BOTTOM_LEFT':
                $x = $xMargin;
                $y = $h - $wh - $yMargin;
                break;
            case 'BOTTOM_RIGHT':
                $x = $w - $ww - $xMargin;
                $y = $h - $wh - $yMargin;
                break;
            case 'CENTER':
                $x = round(($w - $ww - $xMargin) / 2);
                $y = round(($h - $wh - $yMargin) / 2);
                break;
        }
        imagecopyresampled($image, $watermark, $x, $y, 0, 0, $ww, $wh, $ww, $wh);
        $ok = self::saveImage($image, $imagePath);
        imagedestroy($image);
        return $ok ? true : false;
    }
    
    /**
     * Генерация проверочной картинки (captcha)
     * 
     * @param int $length - Кол-во символов
     * @param int $width - Ширина картинки
     * @param int $height - Высота картинки
     * @param array(r, g, b) $backColor - Цвет фона
     * @param array(r, g, b) $foreColor - Цвет текста
     * @param array(r, g, b) $cropColor - Цвет шума
     * @param string $paramName - Имя переменной сессии
     * @param string $fontFile - Путь к файлу TTF шрифта
     */
    public static function generateCaptcha($length=5, $width=150, $height=50, $backColor=array(250, 250, 230), $foreColor=array(200, 200, 90), $cropColor=array(200, 200, 200), $paramName='captcha', $fontFile='@/misc/arial.ttf')
    {
    	$text = substr(str_shuffle('23456789ABCDEFGHKLMNPQRSTUVWXYZ'), 0, $length);
		//$text = substr(str_shuffle('012345678901234567890123456789'), 0, $length);
        $image = imagecreate($width, $height);
        imagecolorallocate($image, $backColor[0], $backColor[1], $backColor[2]);
        $color = imagecolorallocate($image, $cropColor[0], $cropColor[1], $cropColor[2]);
        for ($i=0; $i<500; $i++)
        {
            imagesetpixel($image, rand(1, $width-2), rand(1, $height-2), $color);
        }
        $color = imagecolorallocate($image, $foreColor[0], $foreColor[1], $foreColor[2]);
        $str = '';
        for ($i=0; $i<$length; $i++)
        {
			//echo
			imagettftext($image, rand(round($height/3), round($height/2)), rand(-27, 27), 2 + rand(1, 4) + (round(($width - 4) / $length * $i)), rand(round($height*0.4), round($height*0.8)), $color, $fontFile, $text{$i});
            $str .= $text{$i};
        }
        $_SESSION[$paramName] = $str;
        header('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
        exit;
    }
}
?>