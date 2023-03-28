let btnAdd = document.querySelectorAll(".btn-add");
let totalPrice = document.querySelector(".card__title span");
let cartList = document.querySelectorAll(".card__body")[1];
const btnDecrease = document.querySelectorAll(".cart-item-btn__decrease");
const btnIncrease = document.querySelectorAll(".cart-item-btn__increase");
const btnRemove = document.querySelectorAll(".cart-item-btn__remove");

Array.from(btnAdd).forEach((item) => {
    const id = item.getAttribute("data-id");
    const color = item.getAttribute("data-color");
    const image = item.getAttribute("data-image");
    const name = item.getAttribute("data-name");
    const price = item.getAttribute("data-price");
    item.addEventListener("click", () => {
        $.ajax({
            method: "GET",
            url: "./app/php/addToCart.php",
            data: { id: id, color: color, image: image, name: name, price: price, count: 1 },
        }).done(function (msg) {
            item.classList.add("inactive");
            item.innerHTML = "<img src='./app/assets/check.png' class='check-icon'>";
            var div = document.createElement("div");
            div.classList.add("cart-item");
            div.innerHTML = `
                    <div class='cart-item__left'>
                        <div class='cart-item__image' style='background-color: ${color}'>
                            <img src='${image}' />
                        </div>
                    </div>
                    <div class='cart-item__right'>
                        <div class='cart-item__name'>${name}</div>
                        <div class='cart-item__price'>$${price}</div>
                        <div class='cart-item__actions'>
                            <div class='cart-item__count'>
                                <button class='btn cart-item-btn__decrease' data-id=${id} data-price=${price}>-</button>
                                <span class='count'>1</span>
                                <button class='btn cart-item-btn__increase' data-id=${id} data-price=${price}>+</button>
                            </div>
                            <button class='btn cart-item-btn__remove' data-id=${id} data-price=${price}>
                                <img src='./app/assets/trash.png'/>
                            </button>
                        </div>
                    </div>
            `;
            cartList.appendChild(div);
            cartList.lastChild.classList.add("add");
            setTimeout(() => {
                cartList.lastChild.classList.remove("add");
            }, 900);

            let btnDecr = cartList.lastChild.querySelector(".btn.cart-item-btn__decrease");
            let btnIncr = cartList.lastChild.querySelector(".btn.cart-item-btn__increase");
            let btnRev = cartList.lastChild.querySelector(".btn.cart-item-btn__remove");

            btnDecr.addEventListener("click", () => {
                const id = btnDecr.getAttribute("data-id");
                const price = btnDecr.getAttribute("data-price");
                $.ajax({
                    method: "GET",
                    url: "./app/php/addToCart.php",
                    data: { id: id, count: -1 },
                }).done(function (msg) {
                    const newPrice = (parseFloat(totalPrice.innerHTML.slice(1)) - parseFloat(price)).toFixed(2);
                    totalPrice.innerHTML = "$" + newPrice;
                    const count = parseInt(btnDecr.nextElementSibling.innerHTML) - 1;
                    if (count === 0) {
                        while (btnDecr.className !== "cart-item") {
                            btnDecr = btnDecr.parentElement;
                        }
                        console.log(btnDecr);
                        btnDecr.classList.add("remove");
                        setTimeout(() => {
                            btnDecr.remove();
                        }, 600);
                    } else {
                        btnDecr.nextElementSibling.innerHTML = count;
                    }
                });
            });

            btnIncr.addEventListener("click", () => {
                const id = btnIncr.getAttribute("data-id");
                const price = btnIncr.getAttribute("data-price");
                $.ajax({
                    method: "GET",
                    url: "./app/php/addToCart.php",
                    data: { id: id, count: 1 },
                }).done(function (msg) {
                    const newPrice = (parseFloat(totalPrice.innerHTML.slice(1)) + parseFloat(price)).toFixed(2);
                    totalPrice.innerHTML = "$" + newPrice;
                    const count = parseInt(btnIncr.previousElementSibling.innerHTML) + 1;
                    btnIncr.previousElementSibling.innerHTML = count;
                });
            });

            btnRev.addEventListener("click", () => {
                const id = btnRev.getAttribute("data-id");
                const price = btnRev.getAttribute("data-price");
                $.ajax({
                    method: "GET",
                    url: "./app/php/removeCartItem.php",
                    data: { id: id },
                }).done(function (msg) {
                    const count = parseInt(btnRev.previousElementSibling.getElementsByClassName("count")[0].innerHTML);
                    const newPrice = (parseFloat(totalPrice.innerHTML.slice(1)) - parseFloat(price) * count).toFixed(2);
                    totalPrice.innerHTML = "$" + newPrice;
                    while (btnRev.className !== "cart-item") {
                        btnRev = btnRev.parentElement;
                    }
                    btnRev.classList.add("remove");
                    setTimeout(() => {
                        btnRev.remove();
                    }, 700);
                });
            });
            const newPrice = (parseFloat(totalPrice.innerHTML.slice(1)) + parseFloat(price)).toFixed(2);
            totalPrice.innerHTML = "$" + newPrice;
        });
    });
});

Array.from(btnDecrease).forEach((item) => {
    const id = item.getAttribute("data-id");
    const price = item.getAttribute("data-price");
    item.addEventListener("click", () => {
        $.ajax({
            method: "GET",
            url: "./app/php/addToCart.php",
            data: { id: id, count: -1 },
        }).done(function (msg) {
            const newPrice = (parseFloat(totalPrice.innerHTML.slice(1)) - parseFloat(price)).toFixed(2);
            totalPrice.innerHTML = "$" + newPrice;
            const count = parseInt(item.nextElementSibling.innerHTML) - 1;
            if (count === 0) {
                while (item.className !== "cart-item") {
                    item = item.parentElement;
                }
                item.classList.add("remove");
                setTimeout(() => {
                    item.remove();
                }, 600);
            } else {
                item.nextElementSibling.innerHTML = count;
            }
        });
    });
});

Array.from(btnIncrease).forEach((item) => {
    const id = item.getAttribute("data-id");
    const price = item.getAttribute("data-price");
    item.addEventListener("click", () => {
        $.ajax({
            method: "GET",
            url: "./app/php/addToCart.php",
            data: { id: id, count: 1 },
        }).done(function (msg) {
            const newPrice = (parseFloat(totalPrice.innerHTML.slice(1)) + parseFloat(price)).toFixed(2);
            totalPrice.innerHTML = "$" + newPrice;
            const count = parseInt(item.previousElementSibling.innerHTML) + 1;
            item.previousElementSibling.innerHTML = count;
        });
    });
});

Array.from(btnRemove).forEach((item) => {
    const id = item.getAttribute("data-id");
    const price = item.getAttribute("data-price");
    item.addEventListener("click", () => {
        $.ajax({
            method: "GET",
            url: "./app/php/removeCartItem.php",
            data: { id: id },
        }).done(function (msg) {
            const count = parseInt(item.previousElementSibling.getElementsByClassName("count")[0].innerHTML);
            const newPrice = (parseFloat(totalPrice.innerHTML.slice(1)) - parseFloat(price) * count).toFixed(2);
            totalPrice.innerHTML = "$" + newPrice;
            while (item.className !== "cart-item") {
                item = item.parentElement;
            }
            item.classList.add("remove");
            setTimeout(() => {
                item.remove();
            }, 700);
        });
    });
});
