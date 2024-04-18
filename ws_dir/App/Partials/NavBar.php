<?php

namespace App\Partials;

use App\Constants;
use App\Controller\SessionManager;

class NavBar {
    public const BTN_HOME = 1;
    public const BTN_USER = 2;

    public static function putNavBar(int $btn_mode) {
        ?>
        <nav class="nav-main">
            <div class="nav-content">
                <div class="nav-logo">
                    <img src="/App/Assets/Images/logo-full.png" alt="Logo accueil">
                </div>
                <?php self::putNavBarButtons($btn_mode); ?>
            </div>
        </nav>
        <?php
    }
    
    public static function putNavbarStyle() {
        ?>
        <link rel="stylesheet" href="<?= Constants::STYLE_NAVBAR ?>">
        <?php
    }

    private static function putNavBarButtons(int $btn_mode) {
        ?>
        <div class="nav-buttons">
        <?php
        if ($btn_mode == self::BTN_HOME) {
            self::putButton("Accueil", "nav-button btn-home", Constants::PAGE_HOME);
        } else if ($btn_mode == self::BTN_USER) {
            $sm = SessionManager::Instance();
            if ($sm->isUserConnected()) {
                self::putButton("Mon profil", "nav-button btn-profil", Constants::PAGE_PROFILE);
            } else {
                self::putButton("Administrateur", "nav-button btn-admin-connect", "");
                self::putButton("Se connecter", "nav-button btn-connect", Constants::PAGE_LOGIN);
            }
        }
        ?>
        </div>
        <?php
    }

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
