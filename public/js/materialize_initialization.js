$(document).ready(function(){
	// sidenav initialization
    $('.sidenav').sidenav();

	// input counter
    $('input.input_counter').characterCounter();

	// input counter
    $('input#input_text, textarea#textarea2').characterCounter();

    // date picker
    $('.datepicker').datepicker();
    
    // dropdown
    $('.dropdown-trigger').dropdown();
    $('.dropdown-trigger2').dropdown({
        'coverTrigger' : false 
    });


    // select
    $('select').formSelect();

    // floating button
    $('.fixed-action-btn').floatingActionButton();

    // tooltip
     $('.tooltipped').tooltip();

     // modal
     $('.modal').modal();

    // autocomplete
    $('input.autocomplete').autocomplete({
        data: {
            "Apple": 'http://event-app.ohm-conception.com/Settings/background.png',
            "Microsoft": 'http://event-app.ohm-conception.com/Settings/background.png',
            "Google": 'http://event-app.ohm-conception.com/Settings/background.png',
            "test": 'http://event-app.ohm-conception.com/Settings/background.png',
        },
    });

    // data table
    var company_table = $('#example').DataTable();






});



