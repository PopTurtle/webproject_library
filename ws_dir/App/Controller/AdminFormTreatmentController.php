<?php

namespace App\Controller;

use App\Constants;
use App\Model\DBObjects\Book;
use App\Model\DBObjects\Consumer;

class AdminFormTreatmentController {
    public const FORM_NAME_GET = "formname";

    public const FORM_ADD_BOOK = "addbook";
    public const FORM_UPDATE_BOOK = "updbook";
    public const FORM_ADD_USER = "adduser";

    public const TREAT_COMPLETE = 0;
    public const TREAT_INCORRECT_DATA = -1;
    public const TREAT_DB_ERROR = -2;
    public const TREAT_NO_FORM = -3;

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
                $this->previousFormArgGenerator = function () { return Book::generateAllAddFormArgs(); };
                return $this->treatFormAddBook($data);
            case self::FORM_ADD_USER:
                $this->previousForm = Constants::PAGE_ADMIN_ADDUSER;
                $this->previousFormArgGenerator = function () { return Consumer::generateAllAddFormArgs(); };
                return $this->treatFormAddUser($data);
            case self::FORM_UPDATE_BOOK:
                $this->previousForm = Constants::PAGE_ADMIN_UPDATE_BOOK;
                $this->previousFormArgGenerator = function () { return Book::generateAllFormArgs(); };
                return $this->treatFormUpdateBook($data);
            default:
                return self::TREAT_NO_FORM;
        }
    }

    private function treatAddForm($data, $modelClassname) : int {
        $perror = "";
        $r = $modelClassname::treatAddForm($data, $perror);
        if (strcmp($perror, "") !== 0) {
            $this->fieldErrorName = $modelClassname::FormPrefix . $perror;
            return self::TREAT_INCORRECT_DATA;
        }
        return $r === 0 ? self::TREAT_COMPLETE : self::TREAT_DB_ERROR;
    }

    private function treatFormAddBook($data) : int {
        return $this->treatAddForm($data, Book::class);
    }

    private function treatFormAddUser($data) : int {
        return $this->treatAddForm($data, Consumer::class);
    }

    private function treatFormUpdateBook($data) : int {
        $perror = "";
        $r = Book::treatUpdateForm($data, $perror);
        if (strcmp($perror, "") !== 0) {
            $this->fieldErrorName = Book::FormPrefix . $perror;
            return self::TREAT_INCORRECT_DATA;
        }
        return $r === 0 ? self::TREAT_COMPLETE : self::TREAT_DB_ERROR;
    }
}
