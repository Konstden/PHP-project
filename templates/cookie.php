<?php 
session_start();

if (!isset($_SESSION['visits'])) {
    $_SESSION['visits'] = 0;
}

$_SESSION['visits'] = $_SESSION['visits'] + 1;

if ($_SESSION['visits'] > 1) {
    echo "Number of visits "  . $_SESSION['visits'];
} else {
    echo "Welcome to our";
}