<?php

namespace App\Model\DBObjects;

use App\Model\DBObject;

class Book extends DBObject {
    protected const TableName = "book";

    protected static $all_properties = [
        "Id" => "book_id",
        "Title" => "title",
        "Author" => "author",
        "Editor" => "editor",
        "PublicationYear" => "publication_year",
        "Category" => "category",
        "Stock" => "stock"
    ];

    protected function ensureCorrectData(): bool {
        return true;
    }
}
