<?php

namespace App\Controller;

use App\Constants;
use App\Model\Database;
use App\Model\DBObjects\Book;
use App\Model\DBObjects\CartItem;
use App\Utils\Utils;

class BookController {
    private ?Book $curBook;

    public function __construct() {
        if (!isset($_GET["book_id"])) {
            Utils::redirectTo(Constants::PAGE_HOME);
        }
        $this->curBook = Book::getBookById($_GET["book_id"]);
        if ($this->curBook === false) {
            Utils::showErrorCode(Database::RequestErrorCode, "Impossible de récupérer le livre demandé");
        }
        if ($this->curBook === null) {
            Utils::redirectTo(Constants::PAGE_HOME);
        }
    }

    public function putHeader() {
        ?>
        <script src="<?= Constants::SCRIPT_BOOKLOAN ?>"></script>
        <?php
    }

    public function getCurrentBook() : Book {
        return $this->curBook;
    }

    public function putActionButton() {
        //  Action : si user non connecté : se connecter
        //           sinon :
        //  si user a le livre dans son panier : ajouter au panier
        //  sinon : retirer du panier
        $sm = SessionManager::Instance();
        $id = "btn-connect";
        $btn_text = "Se connecter pour emprunter NOT WORKING?";
        if (!$sm->isUserConnected()) {
            ?>
            <button id="<?= $id ?>" data-id="<?= $this->curBook->Id ?>">
                <?= $btn_text ?>
            </button>
            <?php
            return;
        }
        $bookId = $this->curBook->Id;
        $consumerId = $sm->getUserConsumer()->Id;
        if (CartItem::isInConsumerShoppingCart($bookId, $consumerId)) {
            $id = "btn-unloan";
            $btn_text = "Retirer du panier";
        } else {
            $id = "btn-loan";
            $btn_text = "Ajouter au panier";
        }
        ?>
        <button id="<?= $id ?>" data-id="<?= $bookId ?>">
            <?= $btn_text ?>
        </button>
        <?php
    }
}