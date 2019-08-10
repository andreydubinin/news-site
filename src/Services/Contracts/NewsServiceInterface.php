<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 10.08.2019
 * Time: 19:04
 */

namespace App\Services\Contracts;


use Symfony\Component\HttpFoundation\Request;

interface NewsServiceInterface
{
    public function getNewsPagination(Request $request);
}