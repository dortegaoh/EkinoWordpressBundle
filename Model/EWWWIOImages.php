<?php
/*
 * This file is part of the Ekino Wordpress package.
 *
 * (c) 2013 Ekino
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ekino\WordpressBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * Class EWWWIOImages.
 *
 * This is the EWWWIOImages entity
 *
 * @author David Ortega <dortegaoh@gmail.com>
 */
abstract class EWWWIOImages implements WordpressEntityInterface
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $attachmentId;

    /**
     * @var string
     */
    protected $gallery;

    /**
     * @var string
     */
    protected $resize;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $converted;

    /**
     * @var string
     */
    protected $results;

    /**
     * @var int
     */
    protected $imageSize;

    /**
     * @var int
     */
    protected $origSize;

    /**
     * @var string
     */
    protected $backup;

    /**
     * @var int
     */
    protected $level;

    /**
     * @var bool
     */
    protected $pending;

    /**
     * @var int
     */
    protected $updates;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAttachmentId()
    {
        return $this->attachmentId;
    }

    /**
     * @return string
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @return string
     */
    public function getResize()
    {
        return $this->resize;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getConverted()
    {
        return $this->converted;
    }

    /**
     * @return string
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @return int
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * @return int
     */
    public function getOrigSize()
    {
        return $this->origSize;
    }

    /**
     * @return string
     */
    public function getBackup()
    {
        return $this->backup;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->pending;
    }

    /**
     * @return int
     */
    public function getUpdates()
    {
        return $this->updates;
    }
}
