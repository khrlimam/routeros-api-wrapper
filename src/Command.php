<?php


namespace KhairulImam\ROSWrapper;


abstract class Command
{

    /**
     * @return string
     */
    abstract function name();

    /*
     * @throws \Exception
     */
    abstract function run();
}