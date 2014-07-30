// Copyright 2012 Designgeneers! Web Design (email: info@designgeneers.com)
// 

function DgxDonateSubscribeFormEvents()
{
	jQuery('#dgx-donate-designated').click(function() {
		DgxDonateUpdateDesignatedDiv();
	});
	
	jQuery('#dgx-donate-tribute').click(function() {
		DgxDonateUpdateTributeDiv();
	});

	jQuery( '#dgx-donate-employer' ).click( function() {
		DgxDonateUpdateEmployerDiv();
	} );
}

function DgxDonateUpdateDesignatedDiv()
{
	if ( jQuery('#dgx-donate-designated:checked').length > 0 )
	{
       	jQuery(".dgx-donate-form-designated-box").show('fast');
   	}
   	else
   	{
       	jQuery(".dgx-donate-form-designated-box").hide('fast');
   	}
}

function DgxDonateUpdateTributeDiv()
{
	if ( jQuery('#dgx-donate-tribute:checked').length > 0 )
	{
       	jQuery(".dgx-donate-form-tribute-box").show('fast');
   	}
   	else
   	{
       	jQuery(".dgx-donate-form-tribute-box").hide('fast');
   	}
}

function DgxDonateUpdateEmployerDiv() {
	if ( jQuery( '#dgx-donate-employer:checked' ).length > 0 ) {
		jQuery( ".dgx-donate-form-employer-box" ).show( 'fast' );
	} else {
		jQuery( ".dgx-donate-form-employer-box" ).hide( 'fast' );
	}
}

function DgxDonateAddOnClickOther()
{
	jQuery('#dgx-donate-other-input').focus(function() {
		jQuery('input[id=dgx-donate-other-radio]').attr('checked', 'checked');
	});
}

jQuery(document).ready(function() {	

	// Hook up listener for checkboxes on expanders
	DgxDonateSubscribeFormEvents();
	
	// Make sure form divs like tribute box match their checkbox state
	DgxDonateUpdateDesignatedDiv();
	DgxDonateUpdateTributeDiv();
	DgxDonateUpdateEmployerDiv();
	
	// Hook up special handling for the OTHER donation amount box
	DgxDonateAddOnClickOther();

});

