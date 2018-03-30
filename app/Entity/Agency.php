if((isset($featured))&&($featured=='3')) {
    $_SESSION['search'] = 'featured';
    foreach($_REQUEST as $key => $value){
        if($key == 'id' || $key == 'PHPSESSID' || preg_match('/__utm/',$key)) continue;
        $_SESSION[$key] = $value;
    }
    
    $AgentID = "20130130003138163288000000";
    dosearch($featured,$AgentID);
}
if((isset($featured))&&($featured=='2')) {
    $_SESSION['search'] = 'featured';
    foreach($_REQUEST as $key => $value){
        if($key == 'id' || $key == 'PHPSESSID' || preg_match('/__utm/',$key)) continue;
        $_SESSION[$key] = $value;
    }
    
    $AgentID = "20130130003138163288000000";
    dosearch($featured,$AgentID);
}


<div class="property-panel padding-0 ml-1 mr-1">
    <div class="img-wrap-cover">
        <img src="[[+image:containsnot=`o.jpg`:then=`[[+image]]o.jpg`:else=`[[+image]]`]]" alt="New Home for sale at [[+LIST_31]] [[+LIST_34]] [[+LIST_37]] in [[+LIST_39]]" class="img-fluid">
    </div>
    <button class="btn"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
    <div class="container"><h4>[[+LIST_31]] [[+LIST_34]] [[+LIST_37]]</h4>
    <h3>$[[+price]]</h3>
    <p><i class="fa fa-map-marker" aria-hidden="true"></i> [[+LIST_39]], [[+LIST_43]]</p>
    <p><i class="fa fa-bed" aria-hidden="true"></i> [[+LIST_66]] <i class="fa fa-bath"></i> [[+baths]] <i class="fa fa-home"></i> [[+LIST_48]] sq. ft.</p>
    <p>[[+LIST_9]] <span class="ml-30">MLS# [[+LIST_105]]</span></p>
    </div>
</div>
