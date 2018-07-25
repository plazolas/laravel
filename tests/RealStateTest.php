<?php

use App\Property;
use App\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RealStateTest extends TestCase
{
    /**
     * max number of properties.
     *
     * @var \App\User
     */
    protected $user = null;
    
    /**
     * factored user.
     *
     * @var i
     */
    protected $max_properties = 0;
    
    /**
     * max priced property.
     *
     * @var App\Property
     */
    protected $max_priced_property = null;
    
    public function setUp() {
        parent::setUp();
        $this->max_properties = DB::table('rets_property_listing_test')->count();
        $this->max_priced_property = DB::table('rets_property_listing_test')->select('*')->orderBy('LIST_22','desc')->first();
        //dd($this->max_priced_property);
    }
    
    public function test_real_state_page_shows_properties()
    {
        $this->visit('/')->see('Property Listings')
                         ->see('Showing 1 - 9')
                         ->see($this->max_properties);
    }
    
    public function test_user_must_login_to_see_property_details_page()
    {
        $link = '/properties/id/'.$this->max_priced_property->id;

        $this->visit($link)
             ->assertResponseStatus(200)
             ->see('Login');
    }
    
    public function test_logged_user_can_see_property_details_page()
    {
        $link = '/properties/id/'.$this->max_priced_property->id;
        
        $this->user = factory(App\User::class)->make();
        
        $this->actingAs($this->user)
             ->withSession(['foo' => 'bar'])
             ->visit($link)
             ->assertResponseStatus(200)
             ->see($this->max_priced_property->LIST_9);
        
    }
    
    public function test_restaurant_filter()
    {
        $max_items_for_filter = DB::select("SELECT count(*) as max FROM rets_property_listing_test WHERE 1 = 1 AND (GF20121210031859306151000000 LIKE '%Special Purpose%' OR GF20121210031859306151000000 LIKE '%Lounge%' OR GF20121210031859306151000000 LIKE '%Restaurant%' OR GF20121210031859306151000000 LIKE '%Bar%' OR GF20121210031859306151000000 LIKE '%Tavern%' OR LIST_9 LIKE '%Special Purpose%' OR LIST_9 LIKE '%Lounge%' OR LIST_9 LIKE '%Restaurant%' OR LIST_9 LIKE '%Bar%' OR LIST_9 LIKE '%Tavern%') AND LIST_9 NOT LIKE '%office%' AND LIST_22 >= 1.00 AND LIST_22 <= 15000000.00")
                [0]->max;
        $this->visit('/')->see('Property Listings')
                ->select('Restaurant - Bar', 'type')
                ->press('search')
                ->see('<span id="number">'.$max_items_for_filter.'</span>');
    }
    
    public function test_multifamily_filter()
    {
        $max_items_for_filter = DB::select("SELECT count(*) as max FROM rets_property_listing_test WHERE 1 = 1 AND (GF20121210031859306151000000 LIKE '%Hotel%' OR GF20121210031859306151000000 LIKE '%Motel%' OR GF20121210031859306151000000 LIKE '%Mobil/RV%' OR GF20121210031859306151000000 LIKE '%Mobile%' OR GF20121210031859306151000000 LIKE '%RV Parks%' OR GF20121210031859306151000000 LIKE '%Apartments%' OR GF20121210031859306151000000 LIKE '%Residential-Multi-Family%' OR GF20121210031859306151000000 LIKE '%Multi-Fam%' OR GF20121210031859306151000000 LIKE '%Moblhome%' OR GF20121210031859306151000000 LIKE '%Income%' OR GF20121210031859306151000000 LIKE '%Multifamily%' OR GF20121210031859306151000000 LIKE '%Residential Income%' OR LIST_9 LIKE '%Hotel%' OR LIST_9 LIKE '%Motel%' OR LIST_9 LIKE '%Mobil/RV%' OR LIST_9 LIKE '%Mobile%' OR LIST_9 LIKE '%RV Parks%' OR LIST_9 LIKE '%Apartments%' OR LIST_9 LIKE '%Residential-Multi-Family%' OR LIST_9 LIKE '%Multi-Fam%' OR LIST_9 LIKE '%Moblhome%' OR LIST_9 LIKE '%Income%' OR LIST_9 LIKE '%Multifamily%' OR LIST_9 LIKE '%Residential Income%') AND LIST_22 >= 1.00 AND LIST_22 <= 15000000.00 ORDER BY LIST_22 DESC")
                [0]->max;
        $this->visit('/')->see('Property Listings')
                ->select('MultiFamily', 'type')
                ->press('search')
                ->see('<span id="number">'.$max_items_for_filter.'</span>');
    }
    
}