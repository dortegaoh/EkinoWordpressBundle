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

use Doctrine\ORM\EntityManager;
use Ekino\WordpressBundle\Entity\Post;
use Ekino\WordpressBundle\Repository\PostRepository;
use Hautelook\Phpass\PasswordHash;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PostManager.
 *
 * This is the Post entity manager
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
class PostManager extends BaseManager
{
    /**
     * @var PostRepository
     */
    protected $repository;

    /**
     * @var PostMetaManager
     */
    protected $postMetaManager;

    /**
     * @var EWWWIOImagesManager
     */
    protected $imagesManager;

    /**
     * @param EntityManager   $em
     * @param string          $class
     * @param PostMetaManager $postMetaManager
     * @param EWWWIOImagesManager $imagesManager
     */
    public function __construct(EntityManager $em, $class, PostMetaManager $postMetaManager, EWWWIOImagesManager $imagesManager)
    {
        parent::__construct($em, $class);

        $this->postMetaManager = $postMetaManager;
        $this->imagesManager = $imagesManager;
    }

    /**
     * @param Post $post
     *
     * @return bool
     */
    public function isCommentingOpened(Post $post)
    {
        return Post::COMMENT_STATUS_OPEN == $post->getCommentStatus();
    }

    /**
     * @param Post $post
     *
     * @return bool
     */
    public function hasComments(Post $post)
    {
        return 0 < $post->getCommentCount();
    }

    /**
     * @param Post    $post
     * @param Request $request
     * @param string  $cookieHash
     *
     * @return bool
     */
    public function isPasswordRequired(Post $post, Request $request, $cookieHash)
    {
        if (!$post->getPassword()) {
            return false;
        }

        $cookies = $request->cookies;

        if (!$cookies->has('wp-postpass_'.$cookieHash)) {
            return true;
        }

        $hash = stripslashes($cookies->get('wp-postpass_'.$cookieHash));

        if (0 !== strpos($hash, '$P$B')) {
            return true;
        }

        $wpHasher = new PasswordHash(8, true);

        return !$wpHasher->CheckPassword($post->getPassword(), $hash);
    }

    /**
     * @param Post $post
     *
     * @return string
     */
    public function getThumbnailPath(Post $post)
    {
        if (!$thumbnailPostMeta = $this->postMetaManager->getThumbnailPostId($post)) {
            return '';
        }

        /** @var $post Post */
        if (!$post = $this->find($thumbnailPostMeta->getValue())) {
            return '';
        }

        return $post->getGuid();
    }

    /**
     * @param Post $post
     *
     * @return string
     */
    public function getOptimizedThumbnailPath(Post $post)
    {
        if (!$thumbnailPostMeta = $this->postMetaManager->getThumbnailPostId($post)) {
            return '';
        }

        /** @var $post Post */
        if (!$post = $this->find($thumbnailPostMeta->getValue())) {
            return '';
        }

        $pieces = explode("/", $post->getGuid());
        $fileName = array_pop($pieces);
        $base = preg_replace('/' . $fileName .'$/', '', $post->getGuid());

        $newFile = explode('/', $this->imagesManager->getOptimizedImage($fileName));

        $url = $base . end($newFile);

        return $url;
    }

    /**
     * Returns posts for current date or a specified date.
     *
     * @param \DateTime|null $date
     *
     * @return array
     */
    public function findByDate(\DateTime $date = null)
    {
        $date = $date ?: new \DateTime();

        return $this->repository->findByDate($date);
    }

    /**
     * Returns posts for a specified category.
     *
     * @param string $category
     *
     * @return array
     */
    public function findByCategory($category)
    {
        return $this->repository->findByCategory($category);
    }
}
