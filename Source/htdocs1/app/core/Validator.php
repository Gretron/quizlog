<?php

namespace app\core;

abstract class Validator
{
    abstract function valid($data);
}