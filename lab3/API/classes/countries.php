<?php
require_once "tableModule.php";


class Countries extends TableModule
{

    protected function getTableName(): string
    {
        return "countries";
    }
}