<?php
if (isset($_SESSION[$name])) {
    $sup = $_SESSION[$name];
    echo "value='$sup'";
}