<?php

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Exception\Domain;

use FAPI\Sylius\Exception\DomainException;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class UnauthorizedException extends \Exception implements DomainException
{
}
