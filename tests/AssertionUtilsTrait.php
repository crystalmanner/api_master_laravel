<?php

namespace FreshinUp\ActivityApi\Tests;

trait AssertionUtilsTrait
{
    protected function assertItemsHaveKeys($expectedKeys, $items)
    {
        foreach ($items as &$item) {
            $itemKeys = array_keys($item);
            foreach ($expectedKeys as &$key) {
                $this->assertContains($key, $itemKeys);
            }
        }
    }

    protected function assertJsonMatches($expected, $actual)
    {
        foreach ($expected as $key => $value) {
            $this->assertArrayHasKey($key, $actual);
            $this->assertEquals($value, $actual[$key], "For property '" . $key . "'");
        }
    }
}
