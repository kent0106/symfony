<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Workflow\MarkingStore;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Workflow\Marking;

/**
 * ScalarMarkingStore.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class ScalarMarkingStore implements MarkingStoreInterface
{
    private $property;
    private $propertyAccessor;

    /**
     * ScalarMarkingStore constructor.
     *
     * @param string                         $property
     * @param PropertyAccessorInterface|null $propertyAccessor
     */
    public function __construct($property = 'marking', PropertyAccessorInterface $propertyAccessor = null)
    {
        $this->property = $property;
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function getMarking($subject)
    {
        $placeName = $this->propertyAccessor->getValue($subject, $this->property);

        if (!$placeName) {
            return new Marking();
        }

        return new Marking(array($placeName => 1));
    }

    /**
     * {@inheritdoc}
     */
    public function setMarking($subject, Marking $marking)
    {
        $this->propertyAccessor->setValue($subject, $this->property, key($marking->getPlaces()));
    }
}
