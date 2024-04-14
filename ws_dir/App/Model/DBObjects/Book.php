<?php

namespace App\Model\DBObjects;

use App\Model\DBObject;

class Book extends DBObject {
    protected const TableName = "book";

    protected static $Id = "book_id";
    protected static $Title = "title";
    protected static $Author = "author";
    protected static $Editor = "editor";
    protected static $PublicationYear = "publication_year";
    protected static $Category = "category";
    protected static $Stock = "stock";

    protected static $all_properties = [
        "Id",
        "Title",
        "Author",
        "Editor",
        "PublicationYear",
        "Category",
        "Stock"
    ];

    protected function ensureCorrectData(): bool {
        return false;
    }
}
