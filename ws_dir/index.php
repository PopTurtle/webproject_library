<?php

require_once "./autoloader.php";
use App\Constants;

// Redirect to the homepage
header("Location: " . Constants::PAGE_HOME);
