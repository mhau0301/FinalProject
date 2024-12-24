document.addEventListener("DOMContentLoaded", function () {
    const daysInput = document.getElementById("daysInput");
    const modalTotalValue = document.getElementById("modalTotalValue");
    const hiddenTotalValue = document.getElementById("hiddenTotalValue");
    const placeButton = document.querySelector("[data-bs-target='#orderModal']");

    // Chuyển dữ liệu giỏ hàng từ backend
    const cartItems = @json($cart->map(fn($item) => [
        'product_id' => $item->product->id,
        'price' => $item->product->price,
        'quantity' => $item->quantity,
        'days' => parseInt(daysInput.value) || 1,
    ]));

    function calculateTotalValue() {
        const days = parseInt(daysInput.value) || 1;
        let totalValue = 0;

        cartItems.forEach(item => {
            totalValue += item.price * item.quantity * days;
        });

        return totalValue;
    }

    placeButton.addEventListener("click", function () {
        const totalValue = calculateTotalValue();
        modalTotalValue.textContent = totalValue.toLocaleString() + ".000"; // Hiển thị số tiền
        hiddenTotalValue.value = totalValue; // Cập nhật giá trị ẩn để gửi form
    });
});
