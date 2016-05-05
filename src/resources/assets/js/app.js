
// Delete Parent categories with all sub-categories
$(document).on('click', '.delete-btn', function(e) {
    e.preventDefault();
    var self = $(this);
    swal({
            title: "Delete?",
            text: "Are you sure you want to delete this category?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: true
        },
        function(isConfirm){
            if(isConfirm){
                swal("Deleted!","Category deleted", "success");
                setTimeout(function() {
                    self.parents(".delete_form").submit();
                }, 1000);
            }
            else{
                swal("cancelled","Your category is safe", "error");
            }
        });
});


// Delete sub categories
$(document).on('click', '.delete-btn-sub', function(e) {
    e.preventDefault();
    var self = $(this);
    swal({
            title: "Delete?",
            text: "Are you sure you want to delete this sub-category?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: true
        },
        function(isConfirm){
            if(isConfirm){
                swal("Deleted!","Sub-Category deleted!", "success");
                setTimeout(function() {
                    self.parents(".delete_form_sub").submit();
                }, 1000);
            }
            else{
                swal("cancelled","Your sub-category is safe", "error");
            }
        });
});

// Delete Brands
$(document).on('click', '#delete-btn-brand', function(e) {
    e.preventDefault();
    var self = $(this);
    swal({
            title: "Are you sure?",
            text: "Are you sure you want to delete this brand!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: true
        },
        function(isConfirm){
            if(isConfirm){
                swal("Deleted!","Brand deleted", "success");
                setTimeout(function() {
                    self.parents(".delete_form_brand").submit();
                }, 1000);
            }
            else{
                swal("cancelled","Your brand is safe", "error");
            }
        });
});

// Delete Products
$(document).on('click', '#delete-product-btn', function(e) {
    e.preventDefault();
    var self = $(this);
    swal({
            title: "Are you sure?",
            text: "Are you sure you want to delete this product?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: true
        },
        function(isConfirm){
            if(isConfirm){
                swal("Deleted!","Product deleted", "success");
                setTimeout(function() {
                    self.parents(".delete_form_product").submit();
                }, 1000);
            }
            else{
                swal("cancelled","Your product is safe", "error");
            }
        });
});



// Delete Users
$(document).on('click', '#delete-user-btn', function(e) {
    e.preventDefault();
    var self = $(this);
    swal({
            title: "Are you sure?",
            text: "Are you sure you want to delete this User!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: true
        },
        function(isConfirm){
            if(isConfirm){
                swal("Deleted!","User deleted", "success");
                setTimeout(function() {
                    self.parents(".delete_form_user").submit();
                }, 1000);
            }
            else{
                swal("cancelled","Your user is safe", "error");
            }
        });
});


// This is for the sub-categories drop-down.
// This will fire off when a user chooses the parent category in the
// add product page
$(document).ready(function($){
    $('#category').change(function(){
        $.get($(this).data('url'), {
                option: $(this).val()
            },
            function(data) {
                var subcat = $('#sub_category');
                subcat.empty();
                $.each(data, function(index, element) {
                    subcat.append("<option value='"+ element.id +"'>" + element.category + "</option>");
                });
            });
    });
});


// Generate a random SKU for a product
function GetRandom() {
    var myElement = document.getElementById("product_sku");
    myElement.value = Math.floor(100000000 + Math.random() * 900000000);
}



<!-- Menu Toggle Script -->
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
