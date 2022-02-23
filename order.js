// Order product quantity section
let $qty_inc = $(".qty .qtyUp");
let $qty_dec = $(".qty .qtyDown");
let $total_price = $("#total-price");

$qty_inc.click(function (e) {
    // The input that will display the quantity
    let $inputQty = $(`.qty-input[data-id=${$(this).data("id")}]`);
    let $cost = $(`.cost[data-id=${$(this).data("id")}]`);

    $.ajax({ url:"Templates/ajax.php", type:"post", data:{ productid:$(this).data("id")}, success:function (result) {
        let obj = JSON.parse(result);
        let product_price = obj[0]["prix"];

        if ($inputQty.val() >= 1 && $inputQty.val() <= 9) {
            // i represents the current index
            // oldval represents the current value of the input element
            $inputQty.val(function(i,oldval) {
                // Increase the value of the input text by 1
                return ++oldval;
            });

            // increase price of the product
            // $price.text(parseInt($item_price * $input.val()).toFixed(2));
            $cost.text(parseInt(product_price * $inputQty.val()));

            // Set total price
            let total = parseInt($total_price.text()) + parseInt(product_price);
            $total_price.text(total);
        }

    }});
});

$qty_dec.click(function (e) {
    // The input that will display the quantity
    let $inputQty = $(`.qty-input[data-id=${$(this).data("id")}]`);
    let $cost = $(`.cost[data-id=${$(this).data("id")}]`);

    $.ajax({ url:"Templates/ajax.php", type:"post", data:{ productid:$(this).data("id")}, success:function (result) {
        let obj = JSON.parse(result);
        let product_price = obj[0]["prix"];

        if ($inputQty.val() > 1 && $inputQty.val() <= 10) {
            // i represents the current index
            // oldval represents the current value of the input element
            $inputQty.val(function(i,oldval) {
                // Increase the value of the input text by 1
                return --oldval;
            });

            // increase price of the product
            // $price.text(parseInt($item_price * $input.val()).toFixed(2));
            $cost.text(parseInt(product_price * $inputQty.val()));

            // Set total price
            let total = parseInt($total_price.text()) - parseInt(product_price);
            $total_price.text(total);
        }

    }});
});