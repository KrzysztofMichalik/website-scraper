$( document ).ready(function() {
    $('.triger').click(function(event){
        var link = $(this).data('link');
        $.ajax({
            method: "POST",
            url: "./detailsProduct.php",
            data: {
                source: link
            }
        }).done(function(r){
            console.log('success');
            $('#modal-body').empty();
            $('#modal-body').html(r);
        }).fail(function(error){
            console.log(error);
        })
    }); 
});
