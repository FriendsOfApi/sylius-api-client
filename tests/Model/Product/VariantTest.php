<?php

declare(strict_types=1);

namespace FAPI\Sylius\tests\Model\Product;

use FAPI\Sylius\Model\Product\Variant;
use FAPI\Sylius\tests\Model\BaseModelTest;

class VariantTest extends BaseModelTest
{
    public function testCreate()
    {
        $json =
            <<<'JSON'
{
    "id": 331,
    "code": "medium-mug-theme",
    "optionValues": [],
    "position": 0,
    "translations": [],
    "version": 1,
    "onHold": 0,
    "onHand": 0,
    "tracked": false,
    "channelPricings": [],
    "_links": {
        "self": {
            "href": "\/api\/v1\/products\/MUG_TH\/variants\/medium-mug-theme"
        },
        "product": {
            "href": "\/api\/v1\/products\/MUG_TH"
        }
    }
}
JSON;
        $model = Variant::createFromArray(json_decode($json, true));
        $this->assertEquals(331, $model->getId());
    }
}
