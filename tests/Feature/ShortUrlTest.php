<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    private $superAdmin;
    private $admin;
    private $member;
    private $company;
    private $anotherCompany;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create companies
        $this->company = Company::create(['name' => 'Test Company', 'email' => 'test@company.com']);
        $this->anotherCompany = Company::create(['name' => 'Another Company', 'email' => 'another@company.com']);
        
        // Create users
        $this->superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@test.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
            'company_id' => null
        ]);
        
        $this->admin = User::create([
            'name' => 'Company Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'company_id' => $this->company->id
        ]);
        
        $this->member = User::create([
            'name' => 'Company Member',
            'email' => 'member@test.com',
            'password' => bcrypt('password'),
            'role' => 'member',
            'company_id' => $this->company->id
        ]);
        
        // Create some short URLs
        ShortUrl::create([
            'user_id' => $this->admin->id,
            'company_id' => $this->company->id,
            'original_url' => 'https://example.com/1',
            'short_code' => 'abc123',
            'title' => 'Test URL 1'
        ]);
        
        ShortUrl::create([
            'user_id' => $this->member->id,
            'company_id' => $this->company->id,
            'original_url' => 'https://example.com/2',
            'short_code' => 'def456',
            'title' => 'Test URL 2'
        ]);
        
        ShortUrl::create([
            'user_id' => User::create([
                'name' => 'Other Admin',
                'email' => 'other@test.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'company_id' => $this->anotherCompany->id
            ])->id,
            'company_id' => $this->anotherCompany->id,
            'original_url' => 'https://example.com/3',
            'short_code' => 'ghi789',
            'title' => 'Test URL 3'
        ]);
    }

    public function test_super_admin_cannot_create_short_urls()
    {
        $this->actingAs($this->superAdmin);
        
        $response = $this->get(route('urls.create'));
        $response->assertStatus(403);
        
        $response = $this->post(route('urls.store'), [
            'original_url' => 'https://example.com',
            'title' => 'Test'
        ]);
        $response->assertStatus(403);
    }

    public function test_admin_can_create_short_urls()
    {
        $this->actingAs($this->admin);
        
        $response = $this->get(route('urls.create'));
        $response->assertStatus(200);
        
        $response = $this->post(route('urls.store'), [
            'original_url' => 'https://example.com/test',
            'title' => 'Test URL'
        ]);
        
        $response->assertRedirect(route('urls.index'));
        $this->assertDatabaseHas('short_urls', [
            'original_url' => 'https://example.com/test',
            'user_id' => $this->admin->id,
            'company_id' => $this->company->id
        ]);
    }

    public function test_member_can_create_short_urls()
    {
        $this->actingAs($this->member);
        
        $response = $this->get(route('urls.create'));
        $response->assertStatus(200);
        
        $response = $this->post(route('urls.store'), [
            'original_url' => 'https://example.com/member-test',
            'title' => 'Member Test URL'
        ]);
        
        $response->assertRedirect(route('urls.index'));
        $this->assertDatabaseHas('short_urls', [
            'original_url' => 'https://example.com/member-test',
            'user_id' => $this->member->id,
            'company_id' => $this->company->id
        ]);
    }

    public function test_admin_can_only_see_company_urls()
    {
        $this->actingAs($this->admin);
        
        $response = $this->get(route('urls.index'));
        $response->assertStatus(200);
        
        // Should see only URLs from their company
        $response->assertSee('https://example.com/1');
        $response->assertSee('https://example.com/2');
        $response->assertDontSee('https://example.com/3');
    }

    public function test_member_can_only_see_own_urls()
    {
        $this->actingAs($this->member);
        
        $response = $this->get(route('urls.index'));
        $response->assertStatus(200);
        
        // Should see only their own URLs
        $response->assertSee('https://example.com/2');
        $response->assertDontSee('https://example.com/1');
        $response->assertDontSee('https://example.com/3');
    }

    public function test_super_admin_can_see_all_urls()
    {
        $this->actingAs($this->superAdmin);
        
        $response = $this->get(route('urls.index'));
        $response->assertStatus(200);
        
        // Should see all URLs
        $response->assertSee('https://example.com/1');
        $response->assertSee('https://example.com/2');
        $response->assertSee('https://example.com/3');
    }

    public function test_short_url_is_publicly_resolvable()
    {
        $response = $this->get('/s/abc123');
        $response->assertRedirect('https://example.com/1');
        
        // Check click count increased
        $this->assertDatabaseHas('short_urls', [
            'short_code' => 'abc123',
            'clicks' => 1
        ]);
    }

    public function test_invalid_short_url_returns_404()
    {
        $response = $this->get('/s/invalidcode');
        $response->assertStatus(404);
    }
}