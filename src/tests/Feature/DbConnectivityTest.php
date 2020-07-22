<?php

namespace Tests\Feature;

use Illuminate\Database\Connection;
use Tests\TestCase;

class DbConnectivityTest extends TestCase
{
    public function testDbConnectivity()
    {
        /** @var Connection $db */
        $db = $this->app->make("db");
        $row = $db->selectOne("SELECT 1 AS one");
        $this->assertEquals(1, $row->one);
    }
}
