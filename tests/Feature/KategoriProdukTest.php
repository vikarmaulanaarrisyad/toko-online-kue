<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KategoriProdukTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_page_index(): void
    {
        $response = $this->get(route('kategori.index'));

        $response->assertStatus(200);
    }
}
