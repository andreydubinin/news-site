<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 10.08.2019
 * Time: 23:32
 */

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait EntitySluggableTrait
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Gedmo\Slug(fields={"slug", "name"})
     */
    protected $slug;

    public function getSlug(): string
    {
        return $this->slug;
    }
}