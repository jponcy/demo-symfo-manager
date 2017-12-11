<?php

namespace AppBundle\Serializer\Handler;

use AppBundle\Entity\Material;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\Handler\SubscribingHandlerInterface;

class MaterialHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'AppBundle\Entity\Material',
                'method' => 'serialize',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => 'AppBundle\Entity\Material',
                'method' => 'deserialize',
            ]
        ];
    }
    
    public function serialize(JsonSerializationVisitor $visitor, Material $materail, array $type, Context $context)
    {
        $date = new \Datetime();
        $data = [
            'name' => $materail->getName(),
            'number' => $materail->getNumber(),
            'delivered_at' => $date->format('l jS \of F Y h:i:s A'),
        ];
        return $visitor->visitArray($data, $type, $context);
    }
    
    public function deserialize(JsonDeserializationVisitor $visitor, $data)
    {
        // Dans cet exemple, la méthode doit retourner un objet de type AppBundle\Entity\Materail
    }
}