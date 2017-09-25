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
use Ekino\WordpressBundle\Entity\QuickAccessVariables;
use Ekino\WordpressBundle\Repository\EWWWIOImagesRepository;
use Ekino\WordpressBundle\Repository\PostMetaRepository;
use Ekino\WordpressBundle\Repository\QuickAccessVariablesRepository;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class QuickAccessVariablesManager.
 *
 * This is the QuickAccessVariables entity manager
 *
 * @author David Ortega <dortegaoh@gmail.com>
 */
class QuickAccessVariablesManager extends BaseManager
{
    /**
     * @var QuickAccessVariablesRepository
     */
    protected $repository;

    /**
     * @param string    $name
     *
     * @return string
     */
    public function getCachedImage($name)
    {
        $variable = $this->repository->createQueryBuilder('q')
            ->where('q.name = :name')
            ->getQuery()
            ->setParameter('name', $name)
            ->getOneOrNullResult();

        if (is_object($variable)) {
            return $variable->getValue();
        }

        return null;
    }

    public function saveCachedImage($name, $url) {
        $this->em->beginTransaction();
        $now = date("Y-m-d H:i:s");
        $conn = $this->em->getConnection();
        $conn->insert('wp_quick_access_variables', array("name" => $name, "value" => $url, "created_at" => $now));
        $conn->commit();
    }
}
