<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    private $superAdmin;
    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@test.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
            'company_id' => null
        ]);
        
        $this->admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'company_id' => null
        ]);
    }

    public function test_super_admin_can_create_company()
    {
        $this->actingAs($this->superAdmin);
        
        $response = $this->post(route('companies.store'), [
            'name' => 'New Test Company',
            'email' => 'new@company.com',
            'phone' => '1234567890'
        ]);
        
        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', [
            'name' => 'New Test Company',
            'email' => 'new@company.com'
        ]);
    }

    public function test_admin_cannot_create_company()
    {
        $this->actingAs($this->admin);
        
        $response = $this->get(route('companies.create'));
        $response->assertStatus(403);
        
        $response = $this->post(route('companies.store'), [
            'name' => 'New Test Company',
            'email' => 'new@company.com'
        ]);
        $response->assertStatus(403);
    }

    public function test_super_admin_can_view_companies()
    {
        $this->actingAs($this->superAdmin);
        
        $company = Company::create([
            'name' => 'Test Company',
            'email' => 'test@company.com'
        ]);
        
        $response = $this->get(route('companies.index'));
        $response->assertStatus(200);
        $response->assertSee('Test Company');
    }

    public function test_super_admin_can_delete_empty_company()
    {
        $this->actingAs($this->superAdmin);
        
        $company = Company::create([
            'name' => 'Empty Company',
            'email' => 'empty@company.com'
        ]);
        
        $response = $this->delete(route('companies.destroy', $company));
        
        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    }

    public function test_cannot_delete_company_with_users()
    {
        $this->actingAs($this->superAdmin);
        
        $company = Company::create([
            'name' => 'Company With Users',
            'email' => 'users@company.com'
        ]);
        
        User::create([
            'name' => 'Company User',
            'email' => 'user@company.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'company_id' => $company->id
        ]);
        
        $response = $this->delete(route('companies.destroy', $company));
        
        $response->assertSessionHasErrors(['error']);
        $this->assertDatabaseHas('companies', ['id' => $company->id]);
    }
}