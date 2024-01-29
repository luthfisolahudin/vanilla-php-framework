<?php

/**
 * @var Sys\View\ViewEngineInterface $v
 */

$v->extends('layout/error');

$v->persist('title', $text);
$v->persist('code', $code);
$v->persist('text', $text);

?>
