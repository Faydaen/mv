<?php
/**
 * Импорт данных из XML
 *
 */
class ImportXml extends ContenticoModule implements IModule
{

    private $isPage;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Обработка запроса
     *
     */
    public function processRequest()
    {
        parent::onBeforeProcessRequest();

        $this->isPage = isset($_POST['page']);
  
        if ($_FILES["xml"]["name"] != "") {
            $xml = simplexml_load_file($_FILES["xml"]["tmp_name"]);

            if ($xml) {

                $overwrite = isset($_POST["overwrite"]) ? true : false;

                $metaObjectCode = (string)$xml->metaobject["code"];

                $metaAttributes = $this->sqlGetRecordSet("SELECT code, type FROM metaattribute WHERE metaobject_id =
                    (SELECT id FROM metaobject WHERE code = '" . $metaObjectCode . "')");
                $simpleMetaAttributes = array();
                $stringMetaAttributes = array();
                $metaAttributeTypes = array();
                foreach ($metaAttributes as $metaAttribute) {
                    if (in_array($metaAttribute["type"], array(META_ATTRIBUTE_TYPE_STRING, META_ATTRIBUTE_TYPE_TEXT,
                        META_ATTRIBUTE_TYPE_BIGTEXT, META_ATTRIBUTE_TYPE_DATA, META_ATTRIBUTE_TYPE_CUSTOM))) {
                        $stringMetaAttributes[] = $metaAttribute["code"];
                    } else {
                        $simpleMetaAttributes[] = $metaAttribute["code"];
                    }
                    $metaAttributeTypes[$metaAttribute["code"]] = $metaAttribute["type"];
                }

                $objects = array();
                if ($xml->metaobject->object) {
                    foreach ($xml->metaobject->object as $objectXml) {
                        $object = array();

                        foreach ($simpleMetaAttributes as $metaAttribute) {
                            $value = $objectXml[$metaAttribute];
                            switch ($metaAttributeTypes[$metaAttribute]) {
                                case META_ATTRIBUTE_TYPE_ID:
                                case META_ATTRIBUTE_TYPE_INT:
                                case META_ATTRIBUTE_TYPE_IMAGE:
                                case META_ATTRIBUTE_TYPE_FILE:
                                case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
                                    $value = (int)$value;
                                    break;

                                case META_ATTRIBUTE_TYPE_FLOAT:
                                    $value = (double)$value;
                                    break;

                                default:
                                    $value = (string)$value;
                                    break;
                            }
                            $object[$metaAttribute] = $value;
                        }
                        foreach ($stringMetaAttributes as $metaAttribute) {
                            $object[$metaAttribute] = (string)$objectXml->{$metaAttribute};
                        }

                        $objects[] = $object;
                    }
                }

                if ($objects) {
                    Std::loadMetaObjectClass($metaObjectCode);
                    $className = $metaObjectCode . 'Object';
                    $obj = new $className();
                    foreach ($objects as $object) {
                        $idExists = $this->sqlGetValue("SELECT count(*) FROM `" . $metaObjectCode . "` WHERE id = " . $object["id"]) > 0 ? true : false;
                        if (isset($object["id"]) && $object["id"] > 0) {
                            if (!$overwrite && $idExists) {
                                continue;
                            }
                        }
                        
                        //запомнинаетм id ХМLского объекта
                        $objId = $object["id"];
                        if (!$idExists) {
                            $object["id"] = 0;
                        }
                       
                        
                        $obj->init($object);
                        $obj->save();

                        //если есть галочка перезаписи и такого id нет в бд (тоесть нам нужно вставить в бд id из файла
                        if ($overwrite && !$idExists)
                        {
                            $this->sqlQuery("UPDATE {$metaObjectCode} SET id={$objId} WHERE id={$obj->id}");
                        }


                    }
                }

                if ($this->isPage)
                {
                    Std::redirect("/@contentico/Pages/");
                }
                else
                {
                    Std::redirect("/@contentico/Metaobjects/" . $metaObjectCode . "/");
                }
            }
        }

        $this->page['content'] = "Ошибка в XML файле.";
        $this->page['page-name'] = 'Импорт данных из XML';
        //
        parent::onAfterProcessRequest();
    }
}
?>