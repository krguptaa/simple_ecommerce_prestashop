<?php
/**
 * 2007-2014 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * No redistribute in other sites, or copy.
 *
 * @author    RSI
 * @copyright 2007-2014 RSI
 * @license   http://localhost
 */

class SmushItException extends Exception
{

    /**
     * @var  string  location of the image
     */
    private $image;

    /**
     * Creates a new exception.
     *
     * @param  string  error message
     * @param  string  location of the image
     */
    public function __construct(
        $message,
        $image
    ) {
        $this->image = $image;
        parent::__construct($message);
    }

    /**
     * Location of the image.
     *
     * @return  string
     */
    final public function getImage()
    {
        return $this->image;
    }
}
