<?php

namespace Tests\Feature;

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
    // ログイン時







    ### 投稿機能のテスト ###
    ### 投稿の編集画面 表示機能のテスト ###
    ### 投稿削除機能のテスト ###


}
