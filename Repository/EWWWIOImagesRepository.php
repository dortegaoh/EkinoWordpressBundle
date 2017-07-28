<?php
/*
 * This file is part of the Ekino Wordpress package.
 *
 * (c) 2013 Ekino
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ekino\WordpressBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class EWWWIOImagesRepository.
 *
 * This is the repository of the EWWWIOImages entity
 *
 * @author David Ortega <dortegaoh@gmail.com>
 */
class EWWWIOImagesRepository extends EntityRepository
{
    /**
     * @param string    $media
     *
     * @return \Doctrine\ORM\Query
     */
    public function getOptimizedMediaQuery($media, $mediaId)
    {

        $query = $this->createQueryBuilder('e')
            ->where('e.path LIKE :media')
            ->setParameter('media', "%" . $media . "%")
            ->getQuery();

        $attachmentId = $query->getArrayResult()[0]["attachmentId"];


        foreach($query->getArrayResult() as $result) {
            if ($mediaId == $result["attachmentId"]) {
                $attachmentId = $result["attachmentId"];
            }
        }

        return $query = $this->createQueryBuilder('e')
            ->where('e.attachmentId = :attachmentId')
            ->andWhere("e.resize = 'blog-grid' or e.resize = 'full or e.resize = 'large'")
            ->setParameter('attachmentId', $attachmentId)
            ->orderBy('e.resize')
            ->getQuery();

    }
}
