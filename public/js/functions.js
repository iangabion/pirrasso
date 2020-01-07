
    // postrequests

    

    var input_swal = async function (){
        const { value: text } = await Swal.fire({
            title:'Category Name',
            input: 'text',
            inputPlaceholder: 'Type your category here...',
            inputAttributes: {
                'aria-label': 'Type your category here'
            },
            allowOutsideClick: false ,
            showCancelButton: true
        })
        if (text) {
            var datas = [];
            datas = { 'person' : text };
                simple_ajax_call('new_category','post', datas ,function(data){
                    if(data.type == 1) {
                        simple_alert('success' , 'Category has been saved.').then((result) => {
                            window.location.replace('/category')
                        })
                    }else {
                        var error = data.data.responseJSON.errors.person ;
                        simple_alert('warning' ,error.toString())
                    }
                })
        }
    }


    // functions

    // reload form
    $('.reset_form_button').click(function(event) {
        $(this).closest('.content_holder').find('form')[0].reset();
    });

    // image_preview loader
    function image_preview(input , element) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                element.css('background-image', 'url('+e.target.result+')');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // ajax setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ajax call
    function ajaxcallwithimage(url, method, datas, callback){
        $.ajax({
            url:asset + url,
            method:method,
            data:datas,
            contentType: false,
            cache: false,
            processData: false,
            success:function(data) {
                callback({
                    data: data,
                    type:1
                })
            },
            error:function(error) {
                callback({
                    data: error,
                    type:0
                })
            },
        });
    }

    function simple_ajax_call(url, method, datas, callback){
        $.ajax({
            url:asset + url,
            method:method,
            data:datas,
            success:function(data) {
               callback({
                    data: data,
                    type:1
                })
            },
            error:function(error) {
                callback({
                    data: error,
                    type:0
                })
            },
        });
    }



    function confirm_alert(title, text, icon, confirmButtonText ) {
        return Swal.fire({
            title: title ,                // 'Are you sure?'
            text: text,                 // "You won't be able to revert this!"
            icon: icon,                 // 'warning'
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmButtonText      //'Yes, delete it!'
        })
    }

    function simple_alert(icon, title) {
        return Swal.fire({
            position: 'center',
            icon: icon,
            title: title,
            showConfirmButton: false,
            timer: 1500
        })
    }

    function input_alert(input_type, confirm_text , title){
        return Swal.fire({
            title: title,
            input: input_type,
            inputAttributes: {
            autocapitalize: 'off'
        },
            showCancelButton: true,
            confirmButtonText: confirm_text,
            allowOutsideClick: false ,
        }) ;
    }

    
