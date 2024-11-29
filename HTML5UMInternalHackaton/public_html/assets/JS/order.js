$(document).ready(function() {
    // Function to update the order summary
    function updateOrderSummary() {
        let totalItems = 0;
        let totalPrice = 0.0;

        // Iterate through all items stored in session storage
        for (let key in sessionStorage) {
            if (sessionStorage.hasOwnProperty(key) && key.startsWith('item_')) {
                let item = JSON.parse(sessionStorage.getItem(key));
                totalItems += item.quantity;
                totalPrice += item.quantity * item.price;
            }
        }

        // Update the order summary in the DOM
        $('#total-items').text(totalItems);
        $('#total-price').text(totalPrice.toFixed(2));
    }

    // Function to handle item quantity change
    function handleQuantityChange(itemId, itemName, itemPrice) {
        let quantity = parseInt($(`#${itemId}`).val());
        if (quantity > 0) {
            sessionStorage.setItem(`item_${itemId}`, JSON.stringify({ name: itemName, price: itemPrice, quantity: quantity }));
        } else {
            sessionStorage.removeItem(`item_${itemId}`);
        }
        updateOrderSummary();
    }

    // Attach change event listeners to item quantity inputs
    $('.item-quantity').on('change', function() {
        let itemId = $(this).attr('id');
        let itemName = $(this).data('name');
        let itemPrice = parseFloat($(this).data('price'));
        handleQuantityChange(itemId, itemName, itemPrice);
    });

    // Initial update of the order summary
    updateOrderSummary();

    // Handle place order button click
    $('#place-order').on('click', function(e) {
        e.preventDefault();
        // Redirect to summary page
        window.location.href = 'confirmation.html';
    });
});