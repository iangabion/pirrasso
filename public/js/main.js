$(document).ready(function(){
    $('.category_submit').click(function (e) { 
        e.preventDefault();
        var name = $('.category_name').val();
        var datas = [];
        datas = { 'name' : name };

        simple_ajax_call('add_category','post', datas ,function(data){
            console.log(data);
            if(data.type == 1) {
                simple_alert('success' , 'Category has been saved.').then((result) => {
                    window.location.replace('/category')
                })
            }else {
                var error = data.data.responseJSON.errors.name ;
                simple_alert('warning' ,error.toString())
            }
        })
    });

    $( function() {
        var availableTags = [
          "ActionScript",
          "AppleScript",
          "Asp",
          "BASIC",
          "C",
          "C++",
          "Clojure",
          "COBOL",
          "ColdFusion",
          "Erlang",
          "Fortran",
          "Groovy",
          "Haskell",
          "Java",
          "JavaScript",
          "Lisp",
          "Perl",
          "PHP",
          "Python",
          "Ruby",
          "Scala",
          "Scheme"
        ];
        $( "#tags" ).autocomplete({
          source: availableTags
        });
      } );


});