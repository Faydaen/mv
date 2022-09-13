<?php
set_time_limit(0);
include('config.php');
include('config2.php');
include('@lib/const.php');
include('@lib/ds.i.php');
include('@lib/ds.'.$configDb['type'].'.debug.php');
include('@lib/std.php');
include('@lib/contentico.php');
include('@lib/installer.php');

$shell = isset($_SERVER['SHELL']) ? true : false;
$shellArgs = 0;

session_start();
header("Content-Type: text/html; charset=".$GLOBALS['config']['headerCharset']);

class ContenticoInstaller
{
    private $sql;
    private $metaData = array();
    private $installMeta;
    private $installMetaData;
    private $installCustomSql;
    private $installSite;
    private $installHtaccess;
    private $installPack;
    private $installUnpack;
    private $modules = array();
    private $templates = array();
	private $rewriterules = array();

    public function __construct()
    {

    }

    public function initParams()
    {
        $this->installMeta = isset($_POST['install_meta']) ? true : false;
        $this->installMetaData = isset($_POST['install_metadata']) ? true : false;
        $this->installCustomSql = isset($_POST['install_customsql']) ? true : false;
        $this->installSite = isset($_POST['install_site']) ? true : false;
        $this->installTemplates = isset($_POST['install_templates']) ? true : false;
        $this->installCss = isset($_POST['install_css']) ? true : false;
        $this->installHtaccess = isset($_POST['install_htaccess']) ? true : false;
        $this->installPack = isset($_POST['install_pack']) ? true : false;
        $this->installUnpack = isset($_POST['install_unpack']) ? true : false;
    }

    public function go()
    {
        global $shell;
        $_SESSION['contentico_installer'] = array();
        $log = '';
        if ($this->installMeta)
        {
            $log .= $this->createMetaData();
        }
        else
        {
            $this->sql = SqlDataSource::getInstance();
        }
        if ($this->installMetaData)
        {
            $xml = file_get_contents('@project/sys.xml');
            preg_match('~<metaobjects>(.*)</metaobjects>~s', $xml, $matches);
            $metaData .= $matches[1];
            $xml = file_get_contents('@project/std.xml');
            preg_match('~<metaobjects>(.*)</metaobjects>~s', $xml, $matches);
            $metaData .= $matches[1];
            $xml = file_get_contents('@project/project.xml');
            if ($xml == '') {
                echo "
Файл project.xml не найден...\terror";
                exit;
            }
            preg_match('~<metaobjects>(.*)</metaobjects>~s', $xml, $matches);
            $metaData .= $matches[1];
            $log .= $this->syncMetaData('<?xml version="1.0" encoding="utf-8"?><meta><metaobjects>'.$metaData.'</metaobjects></meta>');
        }
        if ($this->installSite)
        {
            $log .= $this->syncSite('site.xml');
        }
        if ($this->installMetaData)
        {
            $log .= $this->syncSysSql();
        }
        if ($this->installCustomSql)
        {
            $log .= $this->syncCustomSql();
        }
        if ($this->installHtaccess)
        {
            $log .= $this->syncHtaccess();
        }
        unset($_SESSION['contentico_installer']);
        return $log;
    }

    private function createMetaData()
    {
        global $configDb, $shell;
        if ($shell) {
            echo "
Обновление структуры данных...\t";
        } else {
            $log = '<div class="leftright"><div class="left">Обновление структуры метаданных</div>';
        }
        $this->sql = new SqlDataSource();
        $this->sql->connect();
        if (!$this->sql->selectDatabase())
        {
            $this->sql->query("CREATE DATABASE `{$configDb['db']}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
            $this->sql->selectDatabase();
            $sqlScript = explode(';', file_get_contents('@project/meta.sql'));
            foreach ($sqlScript as $sqlQuery)
            {
                if ($sqlQuery != '')
                {
                    $this->sql->query($sqlQuery);
                }
            }
        }
        //
        if ($shell) {
            echo 'ok';
        } else {
            $log .= '<div class="right ok">завершено</div></div>';
        }
        return $log;
    }

    private function syncMetaData($xml)
    {
        global $shell;
        if ($shell) {
            echo '
Обновление метаобъектов (sys.xml, std.xml, project.xml)';
        } else {
            $log = '<div class="leftright"><div class="left">Обновление метаобъектов (sys.xml, std.xml, project.xml)</div>';
        }
        $xml = simplexml_load_string($xml);
        if (!$xml)
        {
            if ($shell) {
                echo "...\terror (XML parser)";
            } else {
                $log .= '<div class="right error">ошибка XML</div></div>';
            }
            return $log;
        } else {
            echo ':';
        }
        foreach ($xml->metaobjects->metaobject as $metaObjectXml)
        {
            $metaObject = new ContenticoInstallerMetaObject();
            $metaObject->initFromXml($metaObjectXml);
            $this->metaData[] = $metaObject;
        }
        // список текущих метаобъектов
        $currentMetaObjects = $this->sql->getRecordSet("SELECT id, code FROM metaobject");
        $metaObjects = array();
        if ($currentMetaObjects)
        {
            foreach ($currentMetaObjects as $metaObject)
            {
                $metaObjects[$metaObject['code']] = array('processed'=>false, 'id'=>$metaObject['id']);
            }
        }
        //
        foreach ($this->metaData as $metaObject)
        {
            echo "
\t".$metaObject->code . "...\t";
            $metaObject->sync();
            $metaObjects[$metaObject->code]['processed'] = true;
            $metaObjects[$metaObject->oldCode]['processed'] = true;
            if ($metaObject->oldCode != '' && $metaObject->code != $metaObject->oldCode)
            {
                if (file_exists('@obj/'.strtolower($metaObject->oldCode).'.php'))
                {
                    rename('@obj/'.strtolower($metaObject->oldCode).'.php', '@obj/'.strtolower($metaObject->code).'.php');
                }
                if (file_exists('@obj/'.strtolower($metaObject->oldCode).'.ext.php'))
                {
                    rename('@obj/'.strtolower($metaObject->oldCode).'.ext.php', '@obj/'.strtolower($metaObject->code).'.ext.php');
                }
            }
            // список текущих метаопредставлений
            $currentMetaViews = $this->sql->getRecordSet("SELECT id, code FROM metaview WHERE metaobject_id={$metaObject->id}");
            $metaViews = array();
            if ($currentMetaViews)
            {
                foreach ($currentMetaViews as $metaView)
                {
                    $metaViews[$metaView['code']] = array('processed'=>false, 'id'=>$metaView['id']);
                }
            }
            // обработка метапредставлений из xml
            if ($metaObject->metaViews)
            {
                foreach ($metaObject->metaViews as $metaView)
                {
                    $metaView->setMetaObject($metaObject->code);
                    $metaView->sync();
                    $metaViews[$metaView->code]['processed'] = true;
                    //
                    // список текущих полей метапредставления
                    $currentMetaViewFields = $this->sql->getRecordSet("SELECT id, metaattribute_id FROM metaviewfield WHERE metaview_id={$metaView->id}");
                    $metaViewFields = array();
                    if ($currentMetaViewFields)
                    {
                        foreach ($currentMetaViewFields as $metaViewField)
                        {
                            $metaViewFields[$metaViewField['metaattribute_id']] = array('processed'=>false, 'id'=>$metaViewField['id']);
                        }
                    }
                    // обработка полей из xml
                    foreach ($metaView->metaViewFields as $metaViewField)
                    {
                        $metaViewField->setMetaView($metaView->code);
                        $metaViewField->sync();
                        $metaViewFields[$metaViewField->metaAttributeId]['processed'] = true;
                    }
                    // удаление ненужных полей метапредставления
                    foreach ($metaViewFields as $i)
                    {
                        if (!$i['processed'])
                        {
                            $metaViewField = new ContenticoInstallerMetaViewField();
                            $metaViewField->id = $i['id'];
                            $metaViewField->delete();
                        }
                    }
                    $this->sql->query("DELETE FROM metaviewcondition WHERE metaview_id={$metaView->id}");
                    // обработка условий метапредствавления из xml
                    if ($metaView->metaViewConditions)
                    {
                        foreach ($metaView->metaViewConditions as $metaViewCondition)
                        {
                            $metaViewCondition->setMetaView($metaView->code);
                            $metaViewCondition->sync();
                        }
                    }
                }
            }
            // удаление более ненужных метапредставлений
            foreach ($metaViews as $i)
            {
                if (!$i['processed'])
                {
                    $metaView = new ContenticoInstallerMetaView();
                    $metaView->id = $i['id'];
                    $metaView->delete();
                }
            }
            // удаление старых metarelation
            $this->sql->query("DELETE FROM metarelation WHERE `to`=".$metaObject->id);
            // добавление новых metarelation
            if ($metaObject->metaRelations)
            {
                foreach ($metaObject->metaRelations as $metaRelation)
                {
                    $metaRelation->create();
                }
            }
            // генерация файлов классов и расширений
            if ($metaObject->installerGenerateClass)
            {
                $classGenerator = new ContenticoInstallerClassGenerator();
                $classGenerator->setMetaObject($metaObject->code);
                $classGenerator->generateClass();
                $classGenerator->generateExtention();
            }
            echo 'ok';
        }
        // удаление более ненужных метаобъектов
        /*
        foreach ($metaObjects as $metaObjectCode=>$i)
        {
            if (!$i['processed'])
            {
                $metaObject = new ContenticoInstallerMetaObject();
                $metaObject->id = $i['id'];
                $metaObject->code = $metaObjectCode;
                $metaObject->delete();
                if (file_exists('@obj/'.strtolower($metaObjectCode).'.php'))
                {
                    unlink('@obj/'.strtolower($metaObjectCode).'.php');
                }
                if (file_exists('@obj/'.strtolower($metaObjectCode).'.ext.php'))
                {
                    unlink('@obj/'.strtolower($metaObjectCode).'.ext.php');
                }
            }
        }
        */
        //
        $log .= '<div class="right ok">завершено</div></div>';
        return $log;
    }

    private function syncSysSql()
    {
        global $configDb, $shell;
        if ($shell) {
            echo "
Обновление системного SQL...\t";
        } else {
            $log = '<div class="leftright"><div class="left">Обновление системного SQL</div>';
        }
        //
        if ($GLOBALS['config']['advancedsecurity'])
        {
            $sqlScript = str_replace(
                array('<%user%>', '<%host%>', '<%db%>', '<%get_parent_id%>'),
                array($configDb['user'], $configDb['host'], $configDb['db'], $_SESSION['contentico_installer']['get_parent_id']),
                file_get_contents('@project/sys.sql'));
            $sqlScript = explode('$$', $sqlScript);
            foreach ($sqlScript as $sqlQuery)
            {
                if (trim($sqlQuery) != '')
                {
                    $this->sql->query($sqlQuery);
                }
            }
            //
            if ($shell) {
                echo 'ok';
            } else {
                $log .= '<div class="right ok">завершено</div></div>';
            }
        }
        else
        {
            if ($shell) {
                echo 'skipped';
            } else {
                $log .= '<div class="right disabled">пропущено</div></div>';
            }
        }
        return $log;
    }

    private function syncCustomSql()
    {
        global $configDb, $shell;
        if ($shell) {
            echo "
Обновление SQL проекта...\t";
        } else {
            $log = '<div class="leftright"><div class="left">Обновление SQL проекта</div>';
        }
        //
        $sqlScript = explode('$$', file_get_contents('@project/custom.sql'));
        foreach ($sqlScript as $sqlQuery)
        {
            if (trim($sqlQuery) != '')
            {
                $this->sql->query($sqlQuery);
            }
        }
        //
        if ($shell) {
            echo 'ok';
        } else {
            $log .= '<div class="right ok">завершено</div></div>';
        }
        return $log;
    }

    private function syncSite()
    {
        global $shell;
        if ($shell) {
            echo "
Обновление служебных данных проекта...\t
";
        } else {
            $log .= '<div class="leftright"><div class="left">Обновление служебных данных проекта</div>';
        }
        //
        $xml = simplexml_load_file('@project/site.xml');
        foreach ($xml->modules->module as $module)
        {
            $this->modules[(string)$module['code']] = (string)$module['name'];
        }
		foreach ($xml->htaccess->rewriterule as $rule)
        {
            $this->rewriterules[] = (string)$rule;
        }
        $modules = $this->sql->getValueSet("SELECT code FROM stdmodule");
        $currentModules = array();
        if ($modules)
        {
            foreach ($modules as $module)
            {
                $currentModules[$module] = false;
            }
        }
        foreach ($this->modules as $code=>$name)
        {
            if ($this->sql->getValue("SELECT count(*) FROM stdmodule WHERE code='$code'") == 1)
            {
                $currentModules[$code] = true;
                $this->sql->query("UPDATE stdmodule SET name='$name' WHERE code='$code'");
            }
            else
            {
                $this->sql->query("INSERT INTO stdmodule (code, name) VALUES ('$code', '$name')");
            }
            if (!file_exists('@mod/'.strtolower($code).'.php'))
            {
                $moduleFile = '<?php
class '.$code.' extends Page implements IModule
{
    public $moduleCode = \''.$code.'\';

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
        //
        // ...
        //
        parent::onAfterProcessRequest();
    }
}
?>';
                file_put_contents('@mod/'.strtolower($code).'.php', $moduleFile);
            }
        }
        foreach ($currentModules as $moduleCode=>$processed)
        {
            if (!$processed)
            {
                $this->sql->query("DELETE FROM stdmodule WHERE code='$moduleCode'");
                if (file_exists('@mod/'.strtolower($moduleCode).'.php'))
                {
                    unlink('@mod/'.strtolower($moduleCode).'.php');
                }
            }
        }
        //
        foreach ($xml->templates->template as $template)
        {
            $this->templates[(string)$template['code']] = (string)$template['name'];
        }
        $templates = $this->sql->getValueSet("SELECT code FROM stdtemplate");
        $currentTemplates = array();
        if ($templates)
        {
            foreach ($templates as $template)
            {
                $currentTemplates[$template] = false;
            }
        }
        foreach ($this->templates as $code=>$name)
        {
            if ($this->sql->getValue("SELECT count(*) FROM stdtemplate WHERE code='$code'") == 1)
            {
                $currentTemplates[$code] = true;
                $this->sql->query("UPDATE stdtemplate SET name='$name' WHERE code='$code'");
            }
            else
            {
                $this->sql->query("INSERT INTO stdtemplate (code, name) VALUES ('$code', '$name')");
            }
        }
        foreach ($currentTemplates as $templateCode=>$processed)
        {
            if (!$processed)
            {
                $this->sql->query("DELETE FROM stdtemplate WHERE code='$templateCode'");
            }
        }
        //
        if ($shell) {
            echo 'ok';
        } else {
            $log .= '<div class="right ok">завершено</div></div>';
        }
        return $log;
    }

    private function syncHtaccess()
    {
        global $shell;
        if ($shell) {
        echo "
Генерация правил для .htaccess...\t
";
        } else {
            $log = '<div class="leftright"><div class="left">Генерация правил для .htaccess</div>';
        }
		$web = (strpos($_SERVER['SERVER_SOFTWARE'], 'Apache') !== false) ? 'apache' : 'nginx';
		if ($web == 'apache')
		{
			$htaccess = '#mod_rewrite_block_begin
RewriteEngine On
Options +FollowSymLinks
RewriteBase /

# приписывание "/" к концу адреса
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !^index.php$
RewriteCond %{SCRIPT_FILENAME} !^contentico.php$
RewriteCond %{SCRIPT_FILENAME} !^service.php$
RewriteRule ^(.+[^/])$ /$1/ [L,R,QSA]

# Contentico
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !^index.php$
RewriteCond %{SCRIPT_FILENAME} !^contentico.php$
RewriteCond %{SCRIPT_FILENAME} !^service.php$
RewriteRule ^@contentico/([^/]+)/(.*)$ /contentico.php?_m=$1&url=$2 [L,NS]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !^index.php$
RewriteCond %{SCRIPT_FILENAME} !^contentico.php$
RewriteCond %{SCRIPT_FILENAME} !^service.php$
RewriteRule ^@contentico/(.*)$ /contentico.php?_m=Index [L,NS]

# изображения
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !^index.php$
RewriteCond %{SCRIPT_FILENAME} !^contentico.php$
RewriteCond %{SCRIPT_FILENAME} !^service.php$
RewriteRule ^@images/(.*)$ /service.php?_a=image&id=$1 [L,NS]

# файлы
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !^index.php$
RewriteCond %{SCRIPT_FILENAME} !^contentico.php$
RewriteCond %{SCRIPT_FILENAME} !^service.php$
RewriteRule ^@files/(.*)$ /service.php?_a=file&id=$1 [L,NS]

################################################################################

## <Module>
#
#RewriteCond %{REQUEST_FILENAME} !-f
#RewriteCond %{SCRIPT_FILENAME} !^index.php$
#RewriteCond %{SCRIPT_FILENAME} !^contentico.php$
#RewriteCond %{SCRIPT_FILENAME} !^service.php$
#RewriteRule ^<module>/([^/]+)$ /index.php?_m=News&page=$1 [L,NS]

##########

<%modules%>

';
        //
			$modules = '';
			foreach ($this->modules as $code=>$name)
			{
				if ($code == 'Page')
				{
				    continue;
				}
				if ($code == 'Index')
				{
					$modules .= '
# Index
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !^index.php$
RewriteCond %{SCRIPT_FILENAME} !^contentico.php$
RewriteCond %{SCRIPT_FILENAME} !^service.php$
RewriteRule ^$ /index.php?_m=Index [L,NS]
';
				}
				else
				{
					$modules .= '
# '.$code.'
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !^index.php$
RewriteCond %{SCRIPT_FILENAME} !^contentico.php$
RewriteCond %{SCRIPT_FILENAME} !^service.php$
RewriteRule ^'.strtolower($code).'/(.*)$ /index.php?_m='.$code.'&url=$1 [L,NS]

';
				}
			}
			if (count($this->rewriterules))
			foreach ($this->rewriterules as $rule) {
				$htaccess .= '
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !^index.php$
RewriteCond %{SCRIPT_FILENAME} !^contentico.php$
RewriteCond %{SCRIPT_FILENAME} !^service.php$
RewriteRule ' . $rule . ' [L,NS]
';
			}
			$modules .= '#mod_rewrite_block_end';
			$htaccess = str_replace('<%modules%>', trim($modules), $htaccess);
			file_put_contents('.htaccess', $htaccess);
		}
		elseif ($web == 'nginx')
		{
			$htaccess = '#mod_rewrite_block_begin
rewrite ^/.+\.conf$ / redirect;
rewrite ^/\.ht.*$ / redirect;
location ~ /.svn/ {
	deny all;
}
#if ($request_filename !~* ^[^@].*(css|jpg|png|gif|ico|swf|js|doc|txt|xsl|install.php|service.php)$)
if (!-f $request_filename)
{
rewrite ^(/[^@].*[^/])$ $1/ redirect;

# Contentico
rewrite ^/@contentico/([^/]+)/(.*)$ /contentico.php?_m=$1&url=$2 break;
rewrite ^/@contentico/(.*)$ /contentico.php?_m=Index break;

# images
#rewrite ^/@images/(.*)$ /service.php?_a=image&id=$1 break;

# files
#rewrite ^/@files/(.*)$ /service.php?_a=file&id=$1 break;

################################################################################

## <Module>
#

<%modules%>

rewrite ^/(.+)/?$ /index.php?_m=Page&url=$1 break;
}
#mod_rewrite_block_end
';
        //
			$modules = '';
			foreach ($this->modules as $code=>$name)
			{
				if ($code == 'Page')
				{
				    continue;
				}
				if ($code == 'Index')
				{
					$modules .= '
# Index
rewrite ^[/]?$ /index.php?_m=Index break;
';
				}
				else
				{
					$modules .= '
# '.$code.'
rewrite ^/'.strtolower($code).'/(.*)$ /index.php?_m='.$code.'&url=$1 break;
';
				}
			}
			if (count($this->rewriterules))
			foreach ($this->rewriterules as $rule) {
				$modules .= '
rewrite ' . $rule . ' break;
';
			}
			$htaccess = str_replace('<%modules%>', trim($modules), $htaccess);
			file_put_contents('nginx.conf', $htaccess);
		}
        //
        if ($shell) {
            echo 'ok';
        } else {
            $log .= '<div class="right ok">завершено</div></div>';
        }
        return $log;
    }
}

$sql = new SqlDataSource();
$sql->connect();

if ($shell && sizeof($argv) > 1) {
    $args = array('meta','metadata','customsql','site','htaccess','staticver');
    for ($i = 0, $j = sizeof($argv); $i < $j; $i++) {
        if (in_array($argv[$i], $args)) {
            $_POST['install_' . $argv[$i]] = 1;
            $shellArgs++;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $shell)
{
    $sql->selectDatabase();
    if ($_GET['_a'] == 'auth')
    {
        $email = Std::cleanString($_POST['email']);
        $pwd = sha1(Std::cleanString($_POST['pwd']));
        $_SESSION['installer-auth'] = $sql->getValue("SELECT id FROM sysuser WHERE email='$email' AND pwd='$pwd' AND _id=1 AND enabled=1");
        $error = $_SESSION['installer-auth'] ? '' : '<span class="error"> &larr; Неверный пароль</span>';
    }
    if (($_GET['_a'] == 'install' || $shell) && ($_SESSION['installer-auth'] > 0 || !$sql->selectDatabase() || $shell))
    {
        $_SESSION['installer-auth'] = 2;
        if ($shell && $shellArgs == 0) {
            echo '
meta - Обновить метаданные
metadata - Обновыить метаобъекты (sys.xml, std.xml, project.xml)
customsql - Обновить пользовательский SQL
site - Обновить служебные данные проекта
    htaccess - Генерировать правила для .htaccess
staticver - Обновить версии js/css
';
        } else {
            if ($shell) {
                echo '
<Contentico>';
            }
            $installer = new ContenticoInstaller();
            $installer->initParams();
            $log = $installer->go();
            updateStaticVer();
            echo '
</Contentico>

';
        }
    }
}

if (!$sql->selectDatabase() || $_SESSION['installer-auth'] > 0)
{
    $content .= Std::renderTemplate(Contentico::loadTemplate('install/step1'), array(
    	'log' => $log ? Std::renderTemplate(Contentico::loadTemplate('install/step2'), array('log' => $log)) : '',
    ));
}
else // необходима авторизация
{
    $content = Std::renderTemplate(Contentico::loadTemplate('install/auth'), array(
    	'email' => $email,
    	'error' => $error,
    ));
}
if (!$shell) {
    echo Std::renderTemplate(Contentico::loadTemplate('install/page'), array('content'=>$content));
}

function updateStaticVer()
{
    if (!isset($_POST['install_staticver'])) {
        return;
    }
    echo "
Обновление версий статичных файлов...\t";
    
    $ver = file_get_contents('@project/static.ver');
    $ver++;
    file_put_contents('@project/static.ver', $ver);

    file_put_contents('@tpl/layout.html', preg_replace('/\.(css|js)\?(\d+)/', '.$1?' . $ver, file_get_contents('@tpl/layout.html')));
    file_put_contents('@/js/script.js', str_replace('VER', $ver, file_get_contents('@/js/script.js.template')));
    file_put_contents('@/css/style.css', str_replace('VER', $ver, file_get_contents('@/css/style.css.template')));
    file_put_contents('@/css/locations.css', str_replace('VER', $ver, file_get_contents('@/css/locations.css.template')));

    echo 'ok';
}
?>