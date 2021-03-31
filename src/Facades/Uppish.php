<?php

namespace Technovistalimited\Uppish\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Uppish Facade Class.
 *
 * @category   Facade
 * @package    Laravel
 * @subpackage TechnoVistaLimited/Uppish
 * @author     Mayeenul Islam <islam.mayeenul@gmail.com>
 * @license    MIT (https://opensource.org/licenses/MIT)
 * @link       https://github.com/technovistalimited/uppish/
 */
class Uppish extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'uppish';
    }
}
