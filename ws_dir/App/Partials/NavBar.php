<?php

namespace App\Partials;

use App\Constants;
use App\Controller\SessionManager;
use App\Partials\Partial;

class NavBar extends Partial {
    public const BTN_HOME = 1;
    public const BTN_USER = 2;

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
                        <img src="/App/Assets/Images/logo-full.png" alt="Logo accueil">
                    </div>
                    <?php self::putNavBarButtons($args['btn_mode'] ?? self::BTN_HOME); ?>
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
    private static function putNavBarButtons(int $btn_mode) {
        ?>
        <div class="nav-buttons">
        <?php
        switch ($btn_mode) {
            case self::BTN_HOME:
                self::putButton("Accueil", "nav-button btn-home", Constants::PAGE_HOME);
                break;
            case self::BTN_USER:
                $sm = SessionManager::Instance();
                if ($sm->isUserConnected()) {
                    self::putButton("Mon profil", "nav-button btn-profil", Constants::PAGE_PROFILE);
                } else {
                    self::putButton("Administrateur", "nav-button btn-admin-connect", "");
                    self::putButton("Se connecter", "nav-button btn-connect", Constants::PAGE_LOGIN);
                }
                break;
            default:
                self::putNavBarButtons(self::BTN_HOME);
                break;
        }
        ?>
        </div>
        <?php
    }

    /**
     *  Affiche un bouton dont le texte est $content, les classes de style sont
     *    la chaine $classes, et le lien lors d'un clique est $href
     */
    private static function putButton(string $content, string $classes, string $href) {
        ?>
        <div class="<?= $classes ?>">
            <a href="<?= $href ?>">
                <p><?= $content ?></p>
            </a>
        </div>
        <?php
    }
}
