<?php

namespace App\Controller;

class LoginController {
    private string $fieldErrorName;

    public function __construct()
    {
        if (isset($_GET["error"])) {
            $this->fieldErrorName = $_GET["error"];
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
            $ls["input_classes"] .= " field-error";
        }
        if (isset($_GET[$name])) {
            $ls["prev"] = $_GET[$name];
        }
        return $ls;
    }
}
