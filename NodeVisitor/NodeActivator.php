<?php

namespace DM\MenuBundle\NodeVisitor;

use DM\MenuBundle\Node\Node;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * This visitor will set a node to active if one of its routes matches the current route of the request.
 *
 * Class NodeActivator
 */
class NodeActivator implements NodeVisitorInterface
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param Node $node
     *
     * @return mixed|void
     */
    public function visit(Node $node)
    {
        if (!$request = $this->requestStack->getCurrentRequest()) {
            return;
        }

        if (in_array($request->get('_route'), $node->getAllActiveRoutes())) {
            $node->setActive(true);
        }
    }
}
