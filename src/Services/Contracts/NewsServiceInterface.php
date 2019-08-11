<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 10.08.2019
 * Time: 19:04
 */

namespace App\Services\Contracts;


use App\Entity\Category;
use App\Entity\News;
use Symfony\Component\HttpFoundation\Request;

interface NewsServiceInterface
{
    public function getNewsPagination(Request $request, array $filters = [], int $countPerPage = 10): array;
    public function saveForm(Request $request, News $news): News;
    public function removeNews(News $news): void;
}