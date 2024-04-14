<?php

namespace App\Model\DBObjects;

use App\Model\DBObject;

class Consumer extends DBObject {
    protected const TableName = "consumer";

    protected static $Id = "consumer_id";
    protected static $Firstname = "firstname";
    protected static $Lastname = "lastname";
    protected static $Birthdate = "birthdate";
    protected static $Mail = "mail";

    protected static $all_properties = [
        "Id",
        "Firstname",
        "Lastname",
        "Birthdate",
        "Mail"
    ];
}
