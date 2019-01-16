<?php
namespace ObisConcept\ShortUrls\Traits;

/*
 * This file is part of the ObisConcept.ShortUrls package.
 */

/**
 * A general approach to bitwise state operations in a class.
 */
trait BitwiseOperationsTrait
{
    protected $flags;

    /*
     * Note: these functions are protected to prevent outside code
     * from falsely setting BITS. See how the extending class 'User'
     * handles this.
     *
     */
    protected function isFlagSet($flag)
    {
        return (($this->flags & $flag) == $flag);
    }

    protected function setFlag($flag, $value)
    {
        if ($value) {
            $this->flags |= $flag;
        } else {
            $this->flags &= ~$flag;
        }
    }
}
