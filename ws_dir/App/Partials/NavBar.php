<?php

namespace App\Partials;

use App\Constants;
use App\Controller\SessionManager;
use App\Partials\Partial;

class NavBar extends Partial {
    private const BTN_NEVER_OFF = -5;
    public const BTN_NONE = 0;
    public const BTN_HOME = 1;
    public const BTN_HOME_ADMIN = 2;
    public const BTN_CONNECT_USER = 3;
    public const BTN_CONNECT_ADMIN = 4;
    public const BTN_PROFILE = 5;
    public const BTN_SHOPPINGCART = 6;


    public const ASSOCIATED_STYLE = Constants::STYLE_NAVBAR;

    /**
     *  @param $args :
     *    - btn_mode : défini quels boutons afficher, BTN_HOME par défaut
     */
    public static function put($args = []) {
        ?>
        <header>
            <nav class="nav-main">
                <div class="nav-content">
                    <div class="nav-logo">
                        <a href="<?= Constants::PAGE_HOME ?>">
                            <img src="/App/Assets/Images/logo-full.png" alt="Logo accueil">
                        </a>
                    </div>
                    <div class="nav-buttons">
                        <?php self::putNavBarButtons($args['btn_mode'] ?? self::BTN_NONE); ?>
                    </div>
                </div>
            </nav>
        </header>
        <?php
    }

    /**
     *  Affiche les boutons demandés, c'est-à-dire en fonction de $btn_mode.
     *  Si la valeur n'est pas correcte, un appel récursif est lancé avec
     *    self::BTN_HOME comme valeur de $btn_mode.
     */
    private static function putNavBarButtons(int $btnMode) {
        $c = "button btn-shadow btn-mw ";
        $sm = SessionManager::Instance();
        $putBtn = function($content, $cclasses, $href, $notOnMode) use ($c, $btnMode) {
            if ($btnMode !== $notOnMode) {
                self::putButton($content, $c . $cclasses, $href);
            }
        };
        if ($sm->isUserAdmin()) {
            /** 1 - Admin */
            $putBtn("Menu admin", "btn-color-2", Constants::PAGE_ADMIN_MAIN, self::BTN_HOME_ADMIN);
        }
        if ($sm->isUserConnected()) {
            /** 2 - Panier */
            $putBtn("Mon panier", "btn-color-2", Constants::PAGE_SHOPPINGCART, self::BTN_SHOPPINGCART);
            /** 3 - Profil  */
            $putBtn("Mon profil", "btn-color-2", Constants::PAGE_PROFILE, self::BTN_PROFILE);
            /** 4 - Déconnexion */
            $putBtn("Me déconnecter", "btn-color-1", Constants::PAGE_HOME . "?logout=yes", self::BTN_NEVER_OFF);
        } else if (!$sm->isUserAdmin()) {
            /** 5 - Connexion admin */
            $putBtn("Administrateur", "btn-color-2", Constants::PAGE_ADMIN_LOGIN, self::BTN_CONNECT_ADMIN);
            /** 6 - Connexion */
            $putBtn("Se connecter", "btn-color-1", Constants::PAGE_LOGIN, self::BTN_CONNECT_USER);
        }
        if ($btnMode !== self::BTN_HOME) {
            /** 7 - Accueil */
            self::putButton("Accueil", $c . "btn-color-1", Constants::PAGE_HOME);
        }
    }

    /**
     *  Affiche un bouton dont le texte est $content, les classes de style sont
     *    la chaine $classes, et le lien lors d'un clique est $href
     */
    private static function putButton(string $content, string $classes, string $href) {
        ?>
        <a class="<?= $classes ?>" href="<?= $href ?>">
            <?= $content ?>    
        </a>
        <?php
    }
}
