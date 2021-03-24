<?php

namespace Tests\Feature;

use App\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use App\User;

class LocationControllerTest extends TestCase
{
    use DatabaseTransactions;

    // use RefreshDatabase;
    ## 投稿一覧表示機能のテスト ###    
    // 未ログイン時
    public function testGuestshow()
    {
        $user = factory(User::class)->create();
        $response = $this->get(route('users.show', ['name' => $user->name]));
        $response->assertRedirect(route('login'));
    }
    // ログイン時
    public function testAuthUsershow()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get(route('users.show', ['name' => $user->name]));
        $response->assertStatus(200)->assertViewIs('users.show', ['name' => $user->name]);
    }
    // 別ユーザーのマイページにアクセスした時
    public function testAnothershow()
    {
        $user = factory(User::class)->create();
        $another = factory(User::class)->create();
        $response = $this->actingAs($user)->get(route('users.show', ['name' => $another->name]));
        $response->assertRedirect(route('users.show', ['name' => $user->name]));
    }
    ### 投稿画面表示機能のテスト ###
    // 未ログイン時
    public function testGuestcreate()
    {
        $user = factory(User::class)->create();
        $response = $this->get(route('locations.create'));
        $response->assertRedirect(route('login'));
    }
    // ログイン時
    public function testAuthUsercreate()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get(route('locations.create'));
        $response->assertStatus(200)->assertViewIs('locations.create');
    }


    ### 投稿機能のテスト ###
    // 未ログイン時
    public function testGeststore()
    {
        $response = $this->post(route("locations.store"));
        $response->assertRedirect("login");
    }
    // 未ログイン時

    public function testAuthstore()
    {
        $user = factory(User::class)->create();
        $location = factory(Location::class)->create();
        $response = $this->actingAs($user)->post(route("locations.store", [
            "zipcode" => $location->zipcode,
            "address" => $location->address,
            "user_id" => $location->user_id,
        ]));

        $this->assertDatabaseHas('locations', [
            "zipcode" => $location->zipcode,
            "address" => $location->address,
            "user_id" => $location->user_id,
        ]);
        $response->assertRedirect("/");
    }

    ### 投稿の編集画面 表示機能のテスト ###

    // 未ログイン時
    public function testGuestedit()
    {
        $location = factory(Location::class)->create();
        $response = $this->get(route('locations.edit', ["location" => $location]));
        $response->assertRedirect(route('login'));
    }
    // 未ログイン時
    public function testAuthUseredit()
    {
        $location = factory(Location::class)->create();
        $user = $location->user;
        $response = $this->actingAs($user)->get(route('locations.edit', ["location" => $location]));
        $response->assertStatus(200)->assertViewIs('locations.edit', ["location" => $location]);
    }
    ### 投稿削除機能のテスト ###
    public function testDestroy()
    {
        $this->withExceptionHandling();
        // テストデータをDBに保存
        $user = factory(User::class)->create();
        $zipcode = 5610861;
        $address = "大阪府豊中市東泉丘";
        $user_id = $user->id;
        $location = Location::create([
            "zipcode" =>  $zipcode,
            "address" => $address,
            "user_id" => $user->id,
        ]);
        // DBかデータを削除
        $response = $this->actingAs($user)->delete(route("locations.destroy", ["location" => $location]));
        // テストデータが消えているか確認
        $this->assertDeleted("locations", [
            "zipcode" =>  $zipcode,
            "address" => $address,
            "user_id" => $user_id,
        ]);
        $response->assertRedirect(route('users.show', ['name' => $user->name]));
    }
}
