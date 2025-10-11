let ingredients = [];
let changeIngredients = [];
let product = {
  productId: product_id,
  base: "default",
  changes: [],
  price: productBasePrice,
};

//change the base of the shake
function changeSmoothieBase(button) {
  if (button.checked) {
    let radioButtons = document.querySelectorAll(".base-option-radio");
    radioButtons.forEach((button) => (button.checked = false));
    button.checked = true;
  }
  product.base = button.previousElementSibling.innerText;
}

//displays the ingredients in the custom change list
function filterIngredients(inputElement) {
  ingredients = JSON.parse(inputElement.dataset.ingredients);
  let input = inputElement.value;
  let resultContainer = document.querySelector(".custom-change-result");
  resultContainer.innerHTML = "";
  resultContainer.style.visibility = "hidden";
  if (input !== "") {
    let filteredIngredients = ingredients.filter((ingredient) => {
      return (
        ingredient.name.startsWith(input, 0) &&
        !changeIngredients.includes(ingredient.id)
      );
    });
    if (filteredIngredients.length > 0)
      resultContainer.style.visibility = "visible";
    filteredIngredients.forEach(
      (ingredient) =>
        (resultContainer.innerHTML += ` <span class="custom-change-item" 
                          onclick='addCustomChangeItem(${JSON.stringify(
                            ingredient
                          )})'>${ingredient.name}</span>`)
    );
  }
}

// add a custom change ingredient after user selects it
function addCustomChangeItem(item) {
  if (changeIngredients.length >= 3) {
    handleChangeLimit("limitHigh");
    return;
  }
  changeIngredients.push([item.id, item.name]);
  product.changes.push(item.name);
  document.querySelector("#custom-change-input").value = "";
  let resultContainer = document.querySelector(".custom-change-result");
  resultContainer.innerHTML = "";
  resultContainer.style.visibility = "hidden";
  let changeItemsContainer = document.querySelector(
    ".selected-change-items-container"
  );
  changeItemsContainer.style.display = "flex";
  changeItemsContainer.innerHTML += `<div id="change-item-${item.id}" class="selected-change-item"> 
                                        <span class="item-text"> <span class="trash-icon" onclick="removeChangeItem(${item.id})"> </span>${item.name}</span>
                                        <span class="change-item-quantity-container" onclick="changeItemQuantityButtonClick(event,this)">
                                            <button class="change-item-quantity-button" >בלי</button>
                                            <button class="change-item-quantity-button active" >רגיל</button>
                                            <button class="change-item-quantity-button" >הרבה</button>
                                            <button class="change-item-quantity-button" >מעט</button>
                                         </span>
                                     </div>`;
}

// modify the amount of the custom change ingredient the user picked - none / a lot and so on...
function changeItemQuantityButtonClick(event, buttonsContainer) {
  if (event.target.tagName == "BUTTON") {
    let targetElement = event.target;
    let buttons = buttonsContainer.querySelectorAll(
      ".change-item-quantity-button"
    );
    buttons.forEach((button) => button.classList.remove("active"));
    targetElement.classList.add("active");

    let modifiedIngredient = buttonsContainer.previousElementSibling.innerText;
    let quantity = targetElement.innerText;
    product.changes = product.changes.map((item) =>
      item.includes(modifiedIngredient)
        ? quantity + " " + modifiedIngredient
        : item
    );
  }
}

// remove the custom change ingredient
function removeChangeItem(id) {
  changeIngredients = changeIngredients.filter((itemId) => itemId != id);
  document.querySelector("#change-item-" + id).remove();
  handleChangeLimit("limitLow");

  let changeToRemove = "";
  let match = changeIngredients.find((item) => item[0] == id);
  if (match) {
    changeToRemove = match[1];
  }
  product.changes = product.changes.filter(
    (item) => !item.includes(changeToRemove)
  );
}

// limits the user to only 3 custom change items
function handleChangeLimit(limit) {
  let changeItemsContainer = document.querySelector(
    ".selected-change-items-container"
  );
  if (limit === "limitHigh") {
    let errorMessage = document.createElement("span");
    errorMessage.innerText = "*ניתן לבצע עד שלושה שינויים";
    errorMessage.id = "change-error-message";
    changeItemsContainer.prepend(errorMessage);
  } else {
    let errorMessage = changeItemsContainer.querySelector(
      "#change-error-message"
    );
    if (errorMessage) {
      errorMessage.remove();
    }
  }
}

// upgrades the size of the product
function upgradeSize(button, price = 0) {
  let sizeButtons = document.querySelectorAll(".shake-size-button");
  sizeButtons.forEach((button) => button.classList.remove("selected"));
  button.classList.add("selected");
  product.price = productBasePrice + price;
}

//handles the add to cart of the final product
async function addProductToCart() {
  let req = await fetch("http://localhost/rebarMock/api/V1/cart/cartItem", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(product),
  });
  let response = await req.json();
  if (response["response"] == "success") {
    window.location.href = "http://localhost/rebarMock/cart";
  } else {
    console.log(response);
  }
}
