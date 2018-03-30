$( document ).ready(() => {

    $('step1').show();
$('step2').hide();
$('step3').hide();
$('step4').hide();
$('step5').hide();
$('step6').hide();

let testimonial_ok = false;
//Inputs that determine what fields to show
const rating = $('#live_form input:radio[name=remittance_address]');
const testimonial=$('#live_form input:radio[name=testimonial]');

//Wrappers for all fields
const different = $('#live_form div[name="different_address"]').parent();
const ok = $('#live_form textarea[name="feedback_ok"]').parent();
const great = $('#live_form textarea[name="feedback_great"]').parent();
const testimonial_parent = $('#live_form #div_testimonial');
const thanks_anyway  = $('#live_form #thanks_anyway');
const all=different.add(ok).add(great).add(testimonial_parent).add(thanks_anyway);

const stepOneWrapper = $('step1');

//step one form-input field elements
const taxIdInput = $('#ein');
const companyNameInput = $('#company_name');
const remittanceAddressInputs = $('div .form-group #different_address_truthy_input').find('.remittance_address_required');
const businessEmail = $('#business_email');

//step one dropdowns
const fedTaxStructureDropdown = $('#federal_tax_structure');
const businessStateDropdown = $('#business_state');

// phone inputs ( step 1 )
const primaryContact = $('section#contact').find('.form-required-input');
const primaryContactPhone = $('#primary_contact_phone');
const businessPhone = $('#business_phone');
const businessMobile = $('#business_phone_mobile');
const businessEmergency = $('#business_phone_emergency');
const businessFax = $('#business_phone_fax');
const secondaryPhone = $('#secondary_contact_phone');

//phone inputs ( step 2 )
const servicePhone = $('step2 #service_contact_phone');

// remittance address radio buttons
const differentAddressEl = $('#different_address');
const sameAddressEl = $('#same_address');

// phone lists
const stepOneReqPhones = [ primaryContactPhone, businessPhone, businessEmergency, businessMobile ];
const allPhones = [ primaryContactPhone, businessPhone, businessEmergency,
    businessFax, businessMobile, secondaryPhone, servicePhone ];

// next button id
const nextStepOne = $('#next_button_step1');

//helper functions
const dialog = id => $(`#warning_${ id }`);

const dialogOn = ( el, id, message ) => {
    dialog( id ).css({
        'opacity': '100',
        'height': 'auto',
        'margin':'5px 0 5px 0'
    }).show()
        .text( message );
    $( el ).addClass('red-highlight');
    return dialog( id );
};

const dialogOff = ( el, id ) => {
    dialog( id ).css('opacity', '0')
        .animate({
            height: 1,
            margin: 0,
        }, 250, 'swing',function() {
            dialog( id ).hide().off();
        });
    $( el ).removeClass('red-highlight');
    return dialog( id );
};

function rawPhoneNumber( val ) {
    return val.split('')
            .filter( el => {
            return el.match(/\d+/g);
})
.join('');
}

function scrollUp( el, time ) {
    if ( el.hash !== '' ) {
        const hash = el.hash;

        $('html, body').animate({
            scrollTop: $(hash).offset().top - 50
        }, time, function () {

            window.location.hash = hash;
        });
    }
}

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}
// SOURCE: https://stackoverflow.com/questions/46155/how-to-validate-email-address-in-javascript

// ---- AUTOCOMPLETE FOR REDUNDANT INPUT FIELDS ( STEP 1 ) ----

// Find and insert value JS---source:http://jsfiddle.net/SDHNY/

$('#business_phone_mobile').on('keyup change', function() {
    $('#business_phone_emergency').val($(this).val());
});

$('#primary_contact_phone').on('keyup change',function() {
    const el = $('#business_phone');
    el.val($(this).val());
    // dialogOff( el, el.attr('id') );
});

$('#primary_contact_email').on('keyup',function() {
    const el = $('#business_email');
    el.val($(this).val());
    // console.log( el, el.attr('id') );
    // dialogOff( el, el.attr('id') );
});


rating.change(function(){
    var value=this.value;
    all.addClass('hidden'); //hide everything and reveal as needed

    if (value == 'different_address' || value == 'Fair'){
        different.removeClass('hidden');
    }
    else if (value == 'Good' || value == 'Very Good'){
        ok.removeClass('hidden');
    }
    else if (value == 'Excellent'){
        testimonial_parent.removeClass('hidden');
        if (testimonial_ok == 'yes'){great.removeClass('hidden');}
        else if (testimonial_ok == 'no'){thanks_anyway.removeClass('hidden');}
    }
});


testimonial.change(function(){
    all.addClass('hidden');
    testimonial_parent.removeClass('hidden');

    testimonial_ok=this.value;

    if (testimonial_ok == 'yes'){
        great.removeClass('hidden');
    }
    else{
        thanks_anyway.removeClass('hidden');
    }

});


// ---- CONDTIONAL VALIDATION FOR REMITTANCE INPUTS ( STEP 1 ) ----


differentAddressEl.click( function ( el ) {
    $('#remittance_conditional').removeClass('hidden');
});

sameAddressEl.click( function( el ) {
    $('#remittance_conditional').addClass('hidden');
    $.each( remittanceAddressInputs, function(i, el) {
        dialogOff( el, el.id );
    });
});


//  ---- CLEAR ERRROR MESSAGES ( STEP 1 ) ----

$('step1').children().on('click keyup', function( el ) {
    const id = el.target.id;

    if( id === 'different_address' || id === 'same_address' ) {
        if($( el.target ).prop('checked')) {
            dialogOff( el.target, 'remittance_address_status' );
        }
    } else {
        dialogOff( el.target, el.target.id );
    }
});


// ---- CHECKS IF FORM IS VALID ON SUBMIT ( STEP 1 ) ----


$('#next_button_step1').click( function ( event ) {
    let valid = true;

    event.preventDefault();
    //   const w9Doc = $('step1 input[type=file]');

    //   if( !w9Doc.value ) {
    //         console.log( 'No w-9 doc uploaded');
    //         console.log(w9Doc.value );
    //         valid = false;
    //     }

    // determines whether element is a phone number input
    let phone = testId => {
        const allPhonesById = $.map(stepOneReqPhones, el => $(el).attr('id'));

        const phoneIdFound = allPhonesById.find(function (el) {
            return el === testId;
        });
        return phoneIdFound ? true : false;
    };
    // check if all basic text inputs are valid
    $('step1 .form-required-input').each(function (i, el) {
        const val = el.value;
        const id = el.id;
        const re = /email/g;

        //  console.log( el.id );

        // if not a phone number
        if( id === 'ein' && val.length !== 9 ) {
            dialogOn( el, id, `${ el.placeholder } is incorrect` );
            valid = false;

            // if an email..
        } else if( re.test( id ) ) {
            console.log( validateEmail( val ), id  );


            if( !validateEmail( val ) && val.length !== 0 ) {
                console.log('invalid email');
                dialogOn( el, id, 'Email is invalid');
                valid = false;
            } else if( !validateEmail( val )){
                dialogOn( el, id, 'Email is required');
                valid = false;
            }
        } else if ( !phone( id ) && val.length === 0 ) {

            if ( id === 'federal_tax_structure' ) {
                dialogOn( el, id, 'Federal Tax Structure is required' );
                valid = false;
            } else if( id === 'business_state' ) {
                dialogOn( el, id, 'State is required' );
                valid = false;
            } else {
                dialogOn( el, id, `${ el.placeholder } is required` );
                valid = false;
            }
            // is a phone number..
        } else if ( phone( id ) ) {

            if ( rawPhoneNumber( val ).length === 0 ) {
                dialogOn( el, id, 'Phone number is required' );
                valid = false;

            } else if( rawPhoneNumber( val ).length !== 10 ) {

                dialogOn( el, id, 'Phone number is incomplete' );
                valid = false;
            }
        }
    });

    //check for valid remittance inputs.
    if (differentAddressEl.prop('checked')) {

        // check nested inputs for different address..
        remittanceAddressInputs.each( function (i, el) {
            const id = $( el ).attr('id');

            if( id === 'remittance_country' ) {
                if ( el.value === "USA" || el.value === "Canada" ){
                }else {
                    dialogOn( el, id, 'Country is required' );
                    valid = false;
                }
            } else  if ( el.value.length === 0 || el.value.length === null ) {
                dialogOn( el, id, `Please include your ${ el.placeholder }` );
                valid = false;
            }
        });
    } else if (!differentAddressEl.prop('checked') && !sameAddressEl.prop('checked')) {
        const el = $('#remittance_address_status');
        const id = el.attr('id');

        // console.log("neither");
        dialog( id ).show();
        valid = false;
    }
    if (valid) {
        console.log( valid );
        $('step1').hide();
        $('step2').show();
        scrollUp( this, 400 );
    } else {
        scrollUp( this, 1250 );
        // console.log( valid );       
    }
});


// ---- STEP 2 FORM VALIDATION ----

const emgcyServiceRadioEl = $('#emergency_after_hours_service_question');
const emergencyServiceOffered = $('#emergency_after_hours_service_question').find('input');
const servicesOffered = $('#services_offered').find('input');


// ---- CLEAR ERROR MESSAGES ( STEP 2 ) ----

$('step2').children().on('click keyup', function( el ) {
    const id = el.target.id;

    const no = $( emergencyServiceOffered[1] ).attr('id');
    const yes = $( emergencyServiceOffered[0] ).attr('id');
    const servicesOfferedRadios = $('#services_offered');

    if ( id === yes || id === no  ) {
        if($( el.target ).prop('checked')) {
            dialogOff( emgcyServiceRadioEl, 'emergency_after_hours_service_question' );
        }
    }
    dialogOff( el.target, el.target.id );
});


// ---- CLEAR SERVICES-OFFERED RADIO BUTTON ERROR MESSAGE ( STEP 2 ) ----


$.each( servicesOffered, function( i, el ) {
    $(el).on('change', function() {
        console.log('click');
        dialog( 'services_offered' ).hide();
    });
});


// ---- VALIDATE SECTION 2 ON SUBMIT ----

$('#prev_button_step2').click(function( event ){

    $('step2').hide();
    $('step1').show();
    scrollUp( this, 2500 );

});

$('#next_button_step2').click( function( event ) {
    let valid = true;
    const re = /email/g;

    event.preventDefault();

    $('step2 .form-required-input').each( function( i, el ) {
        const val = el.value;
        const id = el.id;

        if( re.test( id ) ) {
            if( !validateEmail( val ) && val.length !== 0 ) {
                console.log('invalid email');
                dialogOn( el, id, 'Email is invalid');
                valid = false;
            } else if( !validateEmail( val )){
                dialogOn( el, id, 'Email is required');
                valid = false;
            }
        } else if( val.length === 0 ) {
            dialogOn( el, id, `${ el.placeholder } is required`);
            valid = false;
        }
    });

    const no = $( emergencyServiceOffered[1] ).prop('checked');
    const yes = $( emergencyServiceOffered[0] ).prop('checked');


    if ( !no && !yes ) {
        const el = $('#emergency_after_hours_service_question');
        const id = el.attr('id');
        // console.log( id  );

        dialog( id ).show();
        valid = false;

    }

    console.log( getCheckedProps().length );

    if( getCheckedProps().length === 0 ) {
        dialog( 'services_offered' ).show();
        valid = false;
    }

    if( valid ) {
        $('step2').hide();
        $('step3').show();
        scrollUp( this, 2500 );
    } else {
        scrollUp( this, 400 );
        console.log( valid );
    }
});


// ---- SERVICES OFFERED COMPONENTS ( STEP 2 ) --- //

const checkRadioArr = [];


function getCheckedProps() {
    return servicesOffered.map(function (i, el) {
        const formatId = $(el).attr('id').replace(/\s|\-|\//g, "_")
            .replace(/\___/g, '_')
            .toLowerCase();

        if ($(el).prop('checked')) {
            return {
                name: $(el).val(),
                id: formatId
            };
        }
    });
}

servicesOffered.on('click', function () {
    $('#output_container').children().remove();

    let htmlTemplate = '';

    const laborRate = '_service_labor_rate';
    const travelRate = '_service_travel_rate';
    const emgcyRate = '_service_emergency_labor_rate';
    const comments = '_service_comments';

    $.each( getCheckedProps(), function (count, item) {

        // don't be intimidated. its just a giant string.
        htmlTemplate += '';
    });
    $('#output_container').append(htmlTemplate);
});


// ---- CLEAR ALL ERROR MESSAGES ( STEP 3 ) ----


$('step3').children().on('click keyup', function( el ) {
    const id = el.target.id;
    dialogOff( el.target, id  );
});


// ---- VALIDATE SECTION 3 ON SUBMIT ----

$('#prev_button_step3').click(function( event ){

    $('step3').hide();
    $('step2').show();
    scrollUp( this, 1250 );

});


$('#next_button_step3').click( function( event ) {
    let valid = true;

    event.preventDefault();

    $.each($('#output_container').children(), function ( i, el ) {

        const laborRate = $(`#${ el.id }_service_labor_rate`);

        const val = laborRate.val();
        const id = laborRate.attr('id');

        if ( val.length === 0 ) {
            dialogOn( laborRate, id, 'Labor rate is required' );
            valid = false;
        }
    });

    if( valid ) {
        $('step3').hide();
        $('step4').show();
        scrollUp( this, 2500 );
    } else {
        scrollUp( this, 1000 );
    }
})


// ---- STEP 4 SECTION VALIDATION ----
const hasWorkmansComp = $('#has_workmans_comp input');
const stateExempt = $('#state_certified_exempt');


// ---- CLEAR WARNING BOXES ( STEP 4 ) ----

$('step4').find('div.form-required-radio').click( function( el ) {
    if( el.currentTarget.id  !== 'state_certified_exempt' ) {
        dialogOff( null, el.currentTarget.id );
    }
})


// ---- HAS WORKMANS COMP ( STEP 4 ) ----


hasWorkmansComp.each( function( i, el ) {

    $( el ).click( function() {
        // console.log( this.value );

        if( this.value === "No" ) {
            // console.log('show alternate')
            stateExempt.show();
        } else {
            stateExempt.find('input').prop('checked', false );
            stateExempt.hide();
            dialogOff( null, 'state_certified_exempt ');
        }

    })
});


// ---- STATE EXEMPT FORM ( STEP 4 ) ----

stateExempt.each( function( i, el ) {
    const id = el.id;

    $( el ).click( function( el ) {
        // has exempt form?
        if( id === 'state_certified_exempt' && el.target.value === 'No' ) {
            dialogOn( null, this.id );
            console.log('display error')
        } else {
            dialog( this.id ).hide();
        }
    })
})


// ---- VALIDATE SECTION 4 ON SUBMIT ----


$('#prev_button_step4').click(function( event ){

    $('step4').hide();
    $('step3').show();
    scrollUp( this, 2500 );

});

$('#next_button_step4').click( function( event ) {
    let valid = true;

    event.preventDefault();
    const insuranceDoc = $('step4 input[type=file]');
    // console.log( insuranceDoc );

    // console.log( hasWorkmansComp.value );

    // if( !insuranceDoc.value ) {
    //     console.log( 'No insurance doc uploaded');
    //     console.log( insuranceDoc.value );
    //     valid = false;
    // }


    $('step4 .form-required-radio').each( function( i, el ) {
        const parentId = el.id;
        let isChecked = false;


        $( el ).find('input').each( function( i, el ) {
            let option = '';

            if ( el.checked ) {
                option = el.value;
                isChecked = true
            }
            if ( !isChecked && i === 1 && parentId !== 'state_certified_exempt' ) {
                // console.log( parentId );
                dialogOn( null, parentId, 'Please select an option' );
                valid = false;
            }
            if( parentId === 'state_certified_exempt' && option === 'No' ) valid = false;
        });
        // console.log( valid );
    });

    if( valid ) {
        $('step4').hide();
        $('step5').show();
        scrollUp( this, 2500 );
    } else {
        scrollUp( this, 400 );
    }
});


// ---- STEP 5 FORM INPUTS ----


// ---- CLEAR STEP 5 ERROR MESSAGES ----


// ------- Look at the signature pad js for a better way to validate the sigantured pads -------


$('step5').find('input').click( function( el ) {
    dialogOff( el.currentTarget, el.currentTarget.id );
});

// $('.canvas-1').on('click change focusout', function( el ) {
//     dialogOff( el.target, 'signature-pad-1' );
// });

$('#prev_button_step5').click(function( event ){

    $('step5').hide();
    $('step4').show();
    scrollUp( this, 2500 );

});

$('#next_button_step5').click( function( event ) {
    let valid = true;

    event.preventDefault();

    $('step5').find('input').each( function( i, el ) {
        const val = $(el).val();
        const type = $(el).prop('type');

        if( val.length === 0 ) {
            dialogOn( el, el.id, `${ el.placeholder } is required` );
            valid = false;
        } else if( type === 'email' && !validateEmail( val )) {
            console.log('(line 608): Invalid email');
            dialogOn( el, el.id, 'Email is invalid' );
            valid = false;
        }
    });

    if (signaturePad1 === undefined) {
        valid = false;
        alert('signaturePad1 not found');
    }
    else if (signaturePad1.isEmpty()) {
        valid = false;
        dialogOn( $('canvas.signature-pad1'), 'signature-pad1', 'Please provide a signature' );
    }
    else{
        var tmpData = signaturePad1.toDataURL();
        $("#signatureData1").val(tmpData);
    }

    console.log( 'isEmpty?' )
    // console.log( signaturePad1.isEmpty() );
    console.log( '--------------------------------------------------');

    // if( signaturePad1.isEmpty() ) {
    //     console.log( "Please provide signature first." );
    //     dialogOn( $('canvas.canvas-1'), 'signature-pad-1', 'Please provide a signature' );
    //     valid = false;
    // }

    if( valid ) {
        $('step5').hide();
        $('step6').show();
        scrollUp( this, 2500 );
    }
});


// ---- STEP 6 FORM INPUTS ----


$('step6').find('input').click( function( el ) {
    console.log( el.currentTarget );
    dialogOff( el.currentTarget, el.currentTarget.id );
});


// $('.canvas-2').on('click change focusout', function( el ) {
//     dialogOff( el.target, 'signature-pad-2' );
// });


$('#submit').click( function( event ) {
    let valid = true;



    $('step6').find('input').each( function( i, el ) {
        const val = $(el).val();
        const type = $(el).prop('type');

        console.log(type,  !validateEmail( val ), val );

        if( val.length === 0 ) {
            dialogOn( el, el.id, `${ el.placeholder } is required` );
            valid = false;
        } else if( type === 'email' && !validateEmail( val )) {
            console.log('(line 608): Invalid email');
            dialogOn( el, el.id, 'Email is invalid' );
            valid = false;
        }
    })



    // console.log( 'isEmpty?' )
    // console.log( signaturePad2.isEmpty() );
    // console.log( '--------------------------------------------------');

    // if( signaturePad2.isEmpty() ) {
    //     console.log( "Please provide signature first." );
    //     dialogOn( $('canvas.canvas-2'), 'signature-pad-2', 'Please provide a signature' );
    //     valid = false;
    // }

    if( valid ) { }
});



// ---- AUTO-FORMATING PHONE NUMBER INPUTS ----


const phoneInputMask = (function( arr ) {
    $.each( arr, function( i, el ) {
        rawPhoneNumber( $(el).val() );

        let numbers = 0;

        el.on('keyup', function( event ) {
            const stringArray = $(this).val().split('');
            const backspace = event.keyCode === 8;

            const filterNumbers = stringArray.filter( el => el.match(/\d+/g));
            //   console.log( filterNumbers );
            numbers = filterNumbers.join('');
            let city, phone;
            //   console.log( "numbers changed :" + numbers );

            switch( numbers.length ) {
                case 1:
                case 2:
                case 3:
                    city = numbers.slice(0, 3);
                    break;

                default:
                    city = numbers.slice(0, 3);
                    phone = numbers.slice( 3 );
            }
            if( phone ) {
                if( phone.length > 3 ) {
                    // console.log( `(${ city }) ${ phone.slice(0, 3) } - ${ phone.slice(3) }`.length );
                    return $(this).val(`(${ city }) ${ phone.slice(0, 3) } - ${ phone.slice(3) }`);
                } else {
                    return $(this).val(`(${ city }) ${ phone.slice(0, 3) }`);
                }
            } else {
                if( city.length === 3 && !backspace ) {
                    if( !backspace ) {
                        return $(this).val(`(${ city }) `);
                    } else {
                        return $(this).val(`(${ city })`);
                    }
                } else if( city ) {
                    return $(this).val('(' + city );
                }
            }
        });
    });
}( allPhones ));

});