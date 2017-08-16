<?php
/*
 * This file is part of the Ekino Wordpress package.
 *
 * (c) 2013 Ekino
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ekino\WordpressBundle\Manager;

use Ekino\WordpressBundle\Entity\Post;
use Ekino\WordpressBundle\Entity\PostMeta;
use Ekino\WordpressBundle\Repository\EWWWIOImagesRepository;
use Ekino\WordpressBundle\Repository\PostMetaRepository;

/**
 * Class EWWWIOImagesManager.
 *
 * This is the EWWWIOImages entity manager
 *
 * @author David Ortega <dortegaoh@gmail.com>
 */
class EWWWIOImagesManager extends BaseManager
{
    /**
     * @var EWWWIOImagesRepository
     */
    protected $repository;

    /**
     * @param string    $media         A media name
     *
     * @return string
     */
    public function getOptimizedImage($media, $mediaId)
    {
        $query = $this->repository->getOptimizedMediaQuery($media, $mediaId);

        if(is_null($query) or empty($query->getArrayResult())) {
            return null;
        }

        return $query->getArrayResult()[0]["path"];
    }
}
