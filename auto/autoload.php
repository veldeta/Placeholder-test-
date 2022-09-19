<?php

// Технологие автоматического подзакгрузки классов

spl_autoload_register(function ($classname){
    include 'classes/' . $classname . '.php';
});