<?php

namespace App\Repositories;

use App\Property;
use App\PropertyPhotos;
use Illuminate\Support\Facades\DB;

class PropertyRepository {

    protected $max_price;
    protected $min_price;

    public function __construct() {
        $this->max_price = $this->getMaxPrice();
        $this->min_price = $this->getMinPrice();
    }

    /**
     * Get all of the properties for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function getPaginated($perPage) {

        $paginated = Property::orderBy('LIST_22', 'desc')
                ->paginate($perPage);

        $listings = $paginated->getCollection();

        $count = 0;
        foreach ($listings as $i => $listing) {
            $count++;
            $listing->LIST_22 = number_format($listing->LIST_22, 0, ".", ",");
            $listing->LIST_48 = number_format($listing->LIST_48, 0, ".", ",");
            $photos = $listing->photos;
            if (count($photos)) {
                $listings[$i]->photo = $photos->shift()->photo_full . 'o.jpg';
            } else {
                $listings[$i]->photo = 'images/no-photo.jpg';
            }

            $listing->LIST_78 = (!empty($listing->LIST_78)) ? substr($listing->LIST_78, 0, 100) . '...' : '';

            if ($count == 1) {
                $listings[$i]->header = '<div class="row"><div class="item">';
                $listings[$i]->header = true;
            } else {
                $listings[$i]->header = false;
            }

            if ($i == count($listings) - 1 || $count == 3) { //items per row
                $count = 0;
                $listings[$i]->footer = true;
            } else {
                $listings[$i]->footer = false;
            }
        }

        $cities = $this->getCities();
        $counties = $this->getCounties();

        return [ 'listings' => $listings,
            'paginated' => $paginated,
            'min_price' => intval($this->getMinPrice()),
            'max_price' => intval($this->getMaxPrice()),
            'my_min_price' => $this->getMinPrice(),
            'my_max_price' => $this->getMaxPrice(),
            'cities' => $cities,
            'counties' => $counties,
        ];
    }

    public function getMaxPrice() {
        return Property::max('LIST_22');
    }

    public function getMinPrice() {
        return Property::min('LIST_22');
    }

    public function getCities() {
        $results = Property::distinct()->orderby('LIST_39', 'asc')->get(['LIST_39']);
        $cities = [];
        foreach ($results as $city) {
            if ($city->LIST_39 != '')
                $cities[] = $city->LIST_39;
        }
        return $cities;
    }

    public function getCounties() {
        $results = Property::distinct()->orderby('LIST_41', 'asc')->get(['LIST_41']);
        $counties = [];
        foreach ($results as $county) {
            if ($county->LIST_41 != '')
                $counties[] = $county->LIST_41;
        }
        return $counties;
    }

    public function search($featured = '', $AgentID = '', $similar = 0, $property = '', $limitPerPage = 9, $selectedListing) {

        //if (!request()->has('type')) {
        //    request()->merge(['type' => 'Residential']);
        //}

        $item_per_page = $listing_count = $limitPerPage; //item to display per page

        if ($similar > 0) {
            $current_property = Property::find($similar);
            if ($current_property instanceof Property) {

                request()->merge([
                    'amount1' => 0,
                    'amount2' => $current_property->LIST_22 + 1000000,
                    'city' => $current_property->LIST_39,
                    'subdivision' => '0',
                    'county' => $current_property->LIST_41
                ]);
            } else {
                return '';
            }
        }

        $sql = "SELECT * FROM rets_property_listing_test WHERE 1 = 1 ";
        $filter = "";
        //$filter .= " AND LIST_8 = 'E'"; // only commertial properties on this site
        //$order_field = "LIST_161 DESC";
        $order_field = "LIST_22 DESC";
        $order_name = 'LIST_22';
        $order_dir = 'DESC';
        if (request()->sortby == "priceASC") {
            $order_field = "LIST_22 ASC";
            $order_name = 'LIST_22';
            $order_dir = 'ASC';
        }
        if (request()->sortby == "cityDESC") {
            $order_field = " LIST_39 DESC";
            $order_name = 'LIST_39';
            $order_dir = 'DESC';
        }
        if (request()->sortby == "cityASC") {
            $order_field = " LIST_39 ASC";
            $order_name = 'LIST_39';
            $order_dir = 'ASC';
        }
        if (request()->sortby == "sqftASC") {
            $order_field = " LIST_48 ASC";
            $order_name = 'LIST_48';
            $order_dir = 'ASC';
        }
        if (request()->sortby == "sqftDESC") {
            $order_field = " LIST_48 DESC";
            $order_name = 'LIST_48';
            $order_dir = 'DESC';
        }

        if (is_array($selectedListing)) {
            $listArray = explode(',', $selectedListing);
            foreach ($listArray as $k => $v) {
                $newvArr = explode('-', $v);
                $newv = count($newvArr) === 2 ? $newvArr[1] : $newvArr[0];
                $filter .= ($k === 0 ? " AND ((" : " OR (") . "`LIST_3` = '" . $newv . "'" . ($k === 0 ? ($k === count($v) - 1 ? "))" : ")") : ")");
            }
        }

        if (request()->county && request()->county != "0") {
            $county = request()->county;
            $filter .= " AND `LIST_41` LIKE '%" . $county . "%' ";
        }
        if (request()->type && request()->type != "0") {

            $industrialArr = ["Dock Height Building", "Free Standing", "Industrial", "Manufacturing", "Other", "Warehouse", "Warehouse Combination", "Automotive", "Marina", "Mobil/RV", "Mobile", "RV Parks", "Special Purpose", "Condominium", "Multi-Fam", "Income"];
            $officeArr = ["Free Standing", "Office", "Medical", "Unimproved Interior", "Warehouse Combination", "Professional", "Anchor Center Office/Retail"];
            $hospitalityArr = ["Assisted Living Facility", "Hotel", "Motel", "Mobil/RV", "Mobile", "RV Parks", "Residential-Multi-Family"];
            $specialUseArr = ["Warehouse Combination", "Assisted Living Facility", "Automotive", "Church", "Daycare", "Marina", "Mobil / RV", "Mobile", "Rv Parks", "Non-Profit", "School Showroom", "Special Purpose", "Recreatn", "Moblhome", "Lounge", "Restaurant", "Bar", "Tavern"];
            $multiFamilyArr = ["Hotel", "Motel", "Mobil/RV", "Mobile", "RV Parks", "Apartments", "Residential-Multi-Family", "Multi-Fam", "Moblhome", "Income", "Multifamily", "Residential Income"];
            $industrialLandArr = ["Dock Height Building", "Free Standing", "Industrial", "Manufacturing", "Other", "Store", "Wholesale", "Medical", "Unimproved Interior", "Warehouse Combination", "Professional", "Assisted Living Facility", "Automotive", "Church", "Daycare", "Marina", "Rv Parks", "Non-Profit", "School Showroom", "Special Purpose", "Residential-Multi-Family", "Unimproved Agri", "Anchor Center Office/Retail", "Retail", "Anchored Center", "Convenience Store", "Residential Income", "Mall Enclosed", "Retail Space", "Shopping Center", "Store", "Strip Store"];
            $singleFamilyArr = ["Triplex", "Single Family Detached", "Condo/Coop", "Villa", "Townhouse"];
            /* $rentalArr = ["Anchor Center","Office/Retail","Retail","Anchored Center","Convenience Store","Free Standing","Commercial","Residential Income","Mall Enclosed","Other","Retail Space","Shopping Center","Store","Warehouse Combination","Strip Store"]; */
            $restaurantBarArr = ["Special Purpose", "Lounge", "Restaurant", "Bar", "Tavern"];

            $type = request()->type;

            /*
              Lounge
              Not Improved
              Recreation Facilitiy
             */

            switch ($type) {
                case 'Industrial':
                    $filter .= $this->getQueryFilter($industrialArr);
                    $filter .= ' AND LIST_9 != "Office" AND LIST_9 NOT LIKE "%otel%" AND LIST_9 NOT LIKE "%amily%"';
                    break;
                case 'Office':
                    $filter .= $this->getQueryFilter($officeArr);
                    $filter .= ' AND LIST_9 NOT LIKE "%otel%" AND LIST_9 NOT LIKE "%amily%"';
                    break;
                case 'Hospitality':
                    $filter .= $this->getQueryFilter($hospitalityArr);
                    $filter .= ' AND LIST_9 NOT LIKE "%office%"';
                    break;
                case 'Special Use':
                    $filter .= $this->getQueryFilter($specialUseArr);
                    $filter .= ' AND LIST_9 NOT LIKE "%office%"';
                    break;
                case 'MultiFamily':
                    $filter .= $this->getQueryFilter($multiFamilyArr);
                    break;
                case 'Industrial Land':
                    $filter .= $this->getQueryFilter($industrialLandArr);
                    $filter .= ' AND LIST_48 is null OR LIST_48 = 0 AND LIST_9 NOT LIKE "%business%" AND LIST_9 NOT LIKE "%office%"';
                    break;
                case 'Residential':
                    $filter .= $this->getQueryFilter($singleFamilyArr);
                    break;
                /* case 'Rental':	
                  $filter .= getQueryFilter ($rentalArr);
                  break; */
                case 'Restaurant - Bar':
                    $filter .= $this->getQueryFilter($restaurantBarArr);
                    $filter .= ' AND LIST_9 NOT LIKE "%office%"';
                    break;
                default:
                    $filter .= " AND `GF20121210031859306151000000` LIKE '%" . $type . "%' ";
            }
        }

        if (request()->amount1 > 0) {
            $price = request()->amount1;
        } else {
            $price = $this->min_price;
        }
        if (request()->amount2 > 0) {
            $maxprice = request()->amount2;
        } else {
            $maxprice = $this->max_price;
        }
        $filter .= " AND LIST_22 >= " . $price . " AND LIST_22 <= " . $maxprice . " ";


        if (request()->has('city') && request()->city != "0") {
            $filter .= " AND LIST_39 = '" . request()->city . "' ";
        }
        if (request()->has('county') && request()->county != 0) {
            $subdivision = trim(request()->county);
            $filter .= " AND LIST_77 LIKE '%" . $subdivision . "%' ";
        }
        if ((isset($featured) && $featured == '1')) {
            $filter .= " AND LIST_106 = 'MEDR'";
            $order_field .="RAND()";
            request()->merge(['featured' => '1']);
        }
        if ($similar > 0) {
            $filter .= " AND id != " . $similar;
        }

        $order = " ORDER BY " . $order_field;

        $limit = '';
        if ($similar > 0) {
            $limit = " LIMIT 3";
            $order = " ORDER BY RAND() ";
        }

        $query_str = $sql . $filter . $order . $limit;

        $results = DB::select($query_str);

        
        $ids = [];
        foreach ($results as $item) {
                $ids[] = $item->id;
        }
        
        
        $total = $total_rows = count($results);

        $count = 1;
        $count_nophoto = 1;
        $cursor = 1;
        $page = 0;
        $page_nophoto = 0;
        $active = 1;

        if (!request()->has('_token') && !request()->has('page') && !request()->has('sortby')) {
            // show only properties with photos on home page
            $paginated_photos = Property::has('photos')->whereIn('id', $ids)->orderBy($order_name, $order_dir)->paginate($limitPerPage);
            $listings = $paginated_photos->getCollection();
            
            $paginated = Property::whereIn('id', $ids)->orderBy($order_name, $order_dir)->paginate($limitPerPage);
        
        } else {
            $paginated = Property::whereIn('id', $ids)->orderBy($order_name, $order_dir)->paginate($limitPerPage);
            $listings = $paginated->getCollection();
        }

        $count = 0;
        
        foreach ($listings as $i => $listing) {
            $count++;
            $photos = $listing->photos;
            if (count($photos) > 0) {
                $listings[$i]->photo = $photos->shift()->photo_full . 'o.jpg';
            } else {
                $listings[$i]->photo = 'images/no-photo.jpg';
                
            }

            $listing->LIST_22 = ($listing->LIST_22 > 0) ? number_format($listing->LIST_22, 0, ".", ",") : 0;
            $listing->LIST_48 = ($listing->LIST_48 > 0) ? number_format($listing->LIST_48, 0, ".", ",") : 0;
            $listing->LIST_78 = (!empty($listing->LIST_78)) ? substr($listing->LIST_78, 0, 175) . '...' : '';

            if ($count == 1) {
                $listings[$i]->header = '<div class="row"><div class="item">';
                $listings[$i]->header = true;
            } else {
                $listings[$i]->header = false;
            }

            if ($i == count($listings) - 1 || $count == 3) { //items per row
                $count = 0;
                $listings[$i]->footer = true;
            } else {
                $listings[$i]->footer = false;
            }
        }

        $cities = $this->getCities();
        $counties = $this->getCounties();

        return [ 'listings' => $listings,
            'paginated' => $paginated,
            'min_price' => intval($this->getMinPrice()),
            'max_price' => intval($this->getMaxPrice()),
            'my_min_price' => $price,
            'my_max_price' => $maxprice,
            'cities' => $cities,
            'counties' => $counties,
            'debug' => $query_str
        ];
    }

    public static function getCarousel($id) {

        $property = Property::find($id);
        $photos = $property->photos;
        $carousel = '';
        $indicators = '';
        foreach ($photos as $photo) {
            $carousel .= '<div class="carousel-item">
                     <img src="' . $photo->photo_full . 'o.jpg" data-src="' . $photo->photo_full . '" alt="' . $photo->photo_description . ' | Waltz Realty " title="' . $photo->photo_description . '" class="img-responsive"></div>';
            $indicators .= '<li class="col-lg-2 col-md-3 col-xs-6" data-target="#carousel" data-slide-to>
                    <img src="' . $photo->photo_full . 'o.jpg" data-src="' . $photo->photo_full . 'o.jpg" alt="' . $photo->photo_description . '" title="' . $photo->photo_description . '" class="img-responsive"></li>';
        }

        $return = [
            'carousel' => $carousel,
            'indicators' => $indicators
        ];

        return $return;
    }

    private function getQueryFilter($valuesArr) {
        // GF20121210031859306151000000
        $types = ['GF20121210031859306151000000', 'LIST_9'];
        $filterTmp = " AND (";
        $filterStr = "";
        foreach ($types as $fieldName) {
            foreach ($valuesArr as $typeValue) {
                $filterStr .= (empty($filterStr) ? "" : " OR ") . "{$fieldName} LIKE '%" . $typeValue . "%'";
            }
        }
        $filterTmp .= $filterStr . ")";
        return $filterTmp;
    }

}
