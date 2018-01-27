<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 26.01.18
 * Time: 17:06
 */

namespace App\Application\Handler;


interface HandlerInterface
{
    public function handle(): void;
}