<?php

declare(strict_types=1);

/**
 * @var Sys\View\ViewEngineInterface $v
 * @var int                          $code
 * @var string                       $text
 *
 * @see Sys\Http\Status
 */

$v->extends('layout/error');

$v->persist('title', $text);
$v->persist('code', $code);
$v->persist('text', $text);
