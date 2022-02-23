$(document).ready(function() {

    // banner owl carousel
    $("#banner-area .owl-carousel").owlCarousel({
        loop: true,
        dots: true,
        items: 1
    });

    // Top sales owl carousel
    $("#top-sales .owl-carousel").owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        responsive: {
            0:{
                items: 1
            },
            600:{
                items: 3
            },
            1000:{
                items: 5
            }
        }
    });

    // Filter
    var $grid = $(".grid").isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows'
    });

    // Filter items after clicking the button
    $(".button-group").on("click", "button", function(){
        // 'this' specifies the button that is clicked
        var filtervalue = $(this).attr("data-filter");
        $grid.isotope({filter: filtervalue});
    });


    // New phones owl carousel
    $("#new-phones .owl-carousel").owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        responsive: {
            0:{
                items: 1
            },
            600:{
                items: 3
            },
            1000:{
                items: 5
            }
        }
    });


    // Blogs owl carousel
    $("#blogs .owl-carousel").owlCarousel({
        loop: true,
        nav: false,
        dots: true,
        responsive: {
            0:{
                items: 1
            },
            600:{
                items: 3
            }
        }
    });


    // Product quantity section
    let $qty_up = $(".qty .qty-up");
    let $qty_down = $(".qty .qty-down");
    let $deal_price = $("#deal-price");
    // let $input = $(".qty .qty_input");


    // Click event on qty_up button
    $qty_up.click(function(e){

        // Change product price using ajax call
        // Get each item with his data-id corresponding to each product id
        let $input = $(`.qty_input[data-id='${$(this).data("id")}']`);
        let $price = $(`.product_price[data-id='${$(this).data("id")}']`);
        // To use ajax call in the webpage, we need first to get the link of ajax in cdnjs
        $.ajax({ url:"Templates/ajax.php", type:'post', data:{ itemid:$(this).data("id")}, success:function (result) {
            let obj = JSON.parse(result);
            let item_price = obj[0]["prix"];

            if ($input.val() >= 1 && $input.val() <= 9) {
                // i represents the current index
                // oldval represents the current value of the input element
                $input.val(function(i,oldval) {
                    // Increase the value of the input text by 1
                    return ++oldval;
                });

                // increase price of the product
                // $price.text(parseInt($item_price * $input.val()).toFixed(2));
                $price.text(parseInt(item_price * $input.val()));

                // Set total price
                let total = parseInt($deal_price.text()) + parseInt(item_price);
                $deal_price.text(total);
            }
        }});
    });

    // Click event on qty_down button
    $qty_down.click(function(e){
        // Get the input with his data-id
        let $input = $(`.qty_input[data-id='${$(this).data("id")}']`);
        let $price = $(`.product_price[data-id='${$(this).data("id")}']`);
        // To use ajax call in the webpage, we need first to get the link of ajax in cdnjs
        $.ajax({ url:"Templates/ajax.php", type:'post', data:{ itemid:$(this).data("id")}, success:function (result) {
            let obj = JSON.parse(result);
            let item_price = obj[0]["prix"];

            if ($input.val() > 1 && $input.val() <= 10) {
                // i represents the current index
                // oldval represents the current value of the input element
                $input.val(function(i,oldval) {
                    // Decrease the value of the input text by 1
                    return --oldval;
                });

                // increase price of the product
                // $price.text(parseInt($item_price * $input.val()).toFixed(2));
                $price.text(parseInt(item_price * $input.val()));

                // Set total price
                let total = parseInt($deal_price.text()) - parseInt(item_price);
                $deal_price.text(total);
            }
        }});
    });

});