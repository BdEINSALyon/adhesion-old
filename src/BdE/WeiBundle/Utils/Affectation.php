<?php
namespace BdE\WeiBundle\Utils;


/**
 * Describe the result when you want to affect something on other thing.
 * This class is like an enumeration and could be used to act on some results.
 * @package BdE\WeiBundle\Utils (because there no other places to put that)
 */
abstract class Affectation extends BasicEnum
{
    /**
     * User is affected, if the Entity is persisted.
     */
    const OK = 1;

    /**
     * User could not be affected for obscures reasons
     */
    const Error = 0;

    /**
     * User is already affected.
     */
    const AlreadyIn = 2;

    /**
     * User could not be affected here because it is other where
     */
    const AffectedToAnother = 3;

    /**
     * The thing is currently full.
     */
    const Full = 4;
}