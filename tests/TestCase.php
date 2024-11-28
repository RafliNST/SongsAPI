<?php

namespace Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        DB::delete("delete from artist_relationships");
        DB::delete("delete from users");
        DB::delete("delete from songs");
        DB::delete("delete from albums");
        DB::delete("delete from artists");
    }    
}
