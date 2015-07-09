$(document).ready(function() {

  // JET TO...
  $('#action_jet').click(function() {
    $('#action_main_options').hide();
    $('#action_bronx_options').hide();
    $('#action_jet_where').show();
  });

  // BUY DRUGS
  $('#action_buy').click(function() {
    $('#action_main_options').hide();
    $('#action_bronx_options').hide();
    $('#action_buy_box').show();
  });

  // BUY DRUG #1
  $('#action_buy_1').click(function() {
    $('.drug').html('COCAINE');
    $('.afford').html(
      Math.floor($('#js_coat_cash').text() / $('#js_price_drug_1').text())
    );
    $('#action_buy_what').hide();
    $('#action_buy_how_much').show();
    $('#buy_drugs_form').attr('action', 'http://localhost/DRUGWARS/GIT/game/buy/1/');
  });

  // BUY DRUG #2
  $('#action_buy_2').click(function() {
    $('.drug').html('HEROIN');
    $('.afford').html(
      Math.floor($('#js_coat_cash').text() / $('#js_price_drug_2').text())
    );
    $('#action_buy_what').hide();
    $('#action_buy_how_much').show();
    $('#buy_drugs_form').attr('action', 'http://localhost/DRUGWARS/GIT/game/buy/2/');
  });

  // BUY DRUG #3
  $('#action_buy_3').click(function() {
    $('.drug').html('ACID');
    $('.afford').html(
      Math.floor($('#js_coat_cash').text() / $('#js_price_drug_3').text())
    );
    $('#action_buy_what').hide();
    $('#action_buy_how_much').show();
    $('#buy_drugs_form').attr('action', 'http://localhost/DRUGWARS/GIT/game/buy/3/');
  });

  // BUY DRUG #4
  $('#action_buy_4').click(function() {
    $('.drug').html('WEED');
    $('.afford').html(
      Math.floor($('#js_coat_cash').text() / $('#js_price_drug_4').text())
    );
    $('#action_buy_what').hide();
    $('#action_buy_how_much').show();
    $('#buy_drugs_form').attr('action', 'http://localhost/DRUGWARS/GIT/game/buy/4/');
  });

  // BUY DRUG #5
  $('#action_buy_5').click(function() {
    $('.drug').html('SPEED');
    $('.afford').html(
      Math.floor($('#js_coat_cash').text() / $('#js_price_drug_5').text())
    );
    $('#action_buy_what').hide();
    $('#action_buy_how_much').show();
    $('#buy_drugs_form').attr('action', 'http://localhost/DRUGWARS/GIT/game/buy/5/');
  });

  // BUY DRUG #6
  $('#action_buy_6').click(function() {
    $('.drug').html('LUDES');
    $('.afford').html(
      Math.floor($('#js_coat_cash').text() / $('#js_price_drug_6').text())
    );
    $('#action_buy_what').hide();
    $('#action_buy_how_much').show();
    $('#buy_drugs_form').attr('action', 'http://localhost/DRUGWARS/GIT/game/buy/6/');
  });

  // SELL DRUGS
  $('#action_sell').click(function() {
    $('#action_main_options').hide();
    $('#action_bronx_options').hide();
    $('#action_sell_box').show();
  });

  // SELL DRUG #1
  $('#action_sell_1').click(function() {
    $('.drug').html('COCAINE');
    $('#action_sell_what').hide();
    $('#action_sell_how_much').show();
    $('#sell_drugs_form').attr('action', 'http://localhost/DRUGWARS/GIT/game/sell/1/');
  });

  // SELL DRUG #2
  $('#action_sell_2').click(function() {
    $('.drug').html('HEROIN');
    $('#action_sell_what').hide();
    $('#action_sell_how_much').show();
    $('#sell_drugs_form').attr('action', 'http://localhost/DRUGWARS/GIT/game/sell/2/');
  });

  // SELL DRUG #3
  $('#action_sell_3').click(function() {
    $('.drug').html('ACID');
    $('#action_sell_what').hide();
    $('#action_sell_how_much').show();
    $('#sell_drugs_form').attr('action', 'http://localhost/DRUGWARS/GIT/game/sell/3/');
  });

  // SELL DRUG #4
  $('#action_sell_4').click(function() {
    $('.drug').html('WEED');
    $('#action_sell_what').hide();
    $('#action_sell_how_much').show();
    $('#sell_drugs_form').attr('action', 'http://localhost/DRUGWARS/GIT/game/sell/4/');
  });

  // SELL DRUG #5
  $('#action_sell_5').click(function() {
    $('.drug').html('SPEED');
    $('#action_sell_what').hide();
    $('#action_sell_how_much').show();
    $('#sell_drugs_form').attr('action', 'http://localhost/DRUGWARS/GIT/game/sell/5/');
  });

  // SELL DRUG #6
  $('#action_sell_6').click(function() {
    $('.drug').html('LUDES');
    $('#action_sell_what').hide();
    $('#action_sell_how_much').show();
    $('#sell_drugs_form').attr('action', 'http://localhost/DRUGWARS/GIT/game/sell/6/');
  });

  // VISIT THE LOAN SHARK
  $('#action_visit_loan_shark').click(function() {
	  $('#action_main_options').hide();
	  $('#drugsPrices').hide();
	  $('#action_bronx_options').hide();
		$('#loan_shark_form').show();
	});

  // TRANSFER DRUGS
  $('#action_transfer_drugs').click(function() {
    $('#action_main_options').hide();
    $('#drugsPrices').hide();
    $('#action_bronx_options').hide();
    $('#transfer_drugs_form').show();
  });

  // VISIT BANK
  $('#action_visit_bank').click(function() {
	  $('#action_main_options').hide();
	  $('#drugsPrices').hide();
	  $('#action_bronx_options').hide();
		$('#visit_bank_form').show();
	});

  // BACK TO ACTION MENU
  $('.back_to_menu').click(function() {
    $(this).parent().closest('div').hide();
    $('#action_main_options').show();
    $('#drugsPrices').show();
    $('#action_bronx_options').show();
  });

});
