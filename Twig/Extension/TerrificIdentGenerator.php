<?php

/*
 * This file is part of the Terrific Composer Bundle.
 *
 * (c) Remo Brunschwiler <remo@terrifically.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Terrific\TwigExtensionsBundle\Twig\Extension;

use Twig_Filter_Method;
use Symfony\Component\Finder\Finder;

class TerrificIdentGenerator extends \Twig_Extension
{
    /**
     * @var \Symfony\Component\HttpKernel\KernelInterface
     */
    private $kernel;

    /**
     * @var Array  An array of composition bundle paths
     */
    private $compositionBundles;

    /**
     * @var array
     */
    private $lastId = null;

    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    function initRuntime(\Twig_Environment $environment)
    {
        // extend the loader paths
        $currentLoader = $environment->getLoader();
    }

    /**
     * @param $ns
     */
    public function buildId($ns = null, $keep = false)
    {
        if ($keep && $this->lastId != null) {
            return $this->lastId;
        }

        $ret = substr(md5(microtime()), 0, 5);

        if ($ns != null) {
            $ret = $ns . "-" . $ret;
        }

        $this->lastId = $ret;
        return $ret;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'id' => new \Twig_Function_Method($this, 'buildId')
        );
    }


    /**
     * {@inheritdoc}
     */
    function getName()
    {
        return 'terrific_ident_generator';
    }
}