<?php

namespace App\Controller;

use App\Constants;
use App\Model\DBObjects\Book;

class AdminFormTreatmentController {
    public const FORM_NAME_GET = "formname";

    public const FORM_ADD_BOOK = "addbook";

    public const TREAT_COMPLETE = 0;
    public const TREAT_INCORRECT_DATA = -1;
    public const TREAT_DB_ERROR = -2;

    private bool $formTreated;
    private int $formResult;

    private string $previousForm;
    private $previousFormArgGenerator;
    private string $fieldErrorName;

    public function __construct()
    {
        $this->previousForm = "";
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

    public function previousFormURL() : string {
        return $this->previousForm;
    }

    public function previousFormArgGenerator() {
        return $this->previousFormArgGenerator;
    }

    private function tryTreatForm($formname, $data) : int {
        switch ($formname) {
            case self::FORM_ADD_BOOK:
                $this->previousForm = Constants::PAGE_ADMIN_ADDBOOK;
                $this->previousFormArgGenerator = function () { return Book::generateAllFormArgs(); };
                return $this->treatFormAddBook($data);
        }
    }

    private function treatFormAddBook($data) : int {
        $perror = "";
        $r = Book::treatAddForm($data, $perror);
        if (strcmp($perror, "") !== 0) {
            $this->fieldErrorName = Book::FormAddPrefix . $perror;
            return self::TREAT_INCORRECT_DATA;
        }
        return $r === 0 ? self::TREAT_COMPLETE : self::TREAT_DB_ERROR;
    }
}
