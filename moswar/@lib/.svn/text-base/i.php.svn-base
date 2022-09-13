<?php
@include('@lib/ds.i.php');
@include('@lib/ui.i.php');

interface IModule
{
    public function processRequest();
}

interface IBaseModule
{
    public function processRequest();

    public function renderPage();

    public function onBeforeProcessRequest();

    public function onAfterProcessRequest();
}
?>