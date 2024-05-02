<?php

namespace App\Controller;

use App\Model\DBObjects\Book;

class AdminFormTreatmentController {
    public const FORM_NAME_GET = "formname";

    public const FORM_ADD_BOOK = "addbook";

    public const TREAT_COMPLETE = 0;

    private bool $formTreated;
    private int $formResult;

    private string $fieldErrorName;

    public function __construct()
    {
        $this->fieldErrorName = "";
        if (!isset($_GET[self::FORM_NAME_GET])) {
            $this->formTreated = false;
            return;
        }
        $this->formResult = $this->tryTreatForm($_GET[self::FORM_NAME_GET], $_GET);
        $this->formTreated = true;
    }

    public function wasFormTreated() : bool {
        return $this->formTreated;
    }

    public function getFormTreatmentResult() : int {
        return $this->formResult;
    }

    public function getFieldError() : string {
        return $this->fieldErrorName;
    }

    private function tryTreatForm($formname, $data) : int {
        switch ($formname) {
            case self::FORM_ADD_BOOK:
                return $this->treatFormAddBook($data);
        }
    }

    private function treatFormAddBook($data) : int {
        return Book::treatAddForm($data);
    }
}
