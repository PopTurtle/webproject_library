<?php

namespace App\Controller\Misc;

use App\Utils\Singleton;

class FormMaker extends Singleton {
    public const FIELD_ERROR_GET = "error";
    public const FIELD_ERROR_CLASS = "field-error";
    private string $fieldErrorName;

    protected function __construct()
    {
        if (isset($_GET[self::FIELD_ERROR_GET])) {
            $this->fieldErrorName = $_GET[self::FIELD_ERROR_GET];
        } else {
            $this->fieldErrorName = "";
        }
    }

    public function fieldErrorName() : string {
        return $this->fieldErrorName;
    }

    public function generateInputInfo(string $name, string $input_classes="") {
        $ls = [
            "label_for" => $name,
            "input_name" => $name,
            "input_id" => $name,
            "input_classes" => $input_classes
        ];
        if (strcmp($this->fieldErrorName(), $name) === 0) {
            $ls["input_classes"] .= " " . self::FIELD_ERROR_CLASS;
        } else if (isset($_GET[$name])) {
            $ls["prev"] = $_GET[$name];
        }
        return $ls;
    }
}
