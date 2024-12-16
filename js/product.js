const categoryProduct = document.querySelector(".category-product-wrap")
const btnFilter = document.querySelector(".btn-filter")
const closeCategory = document.querySelector(".close-category-btn")


btnFilter.onclick = ()=>{
    categoryProduct.classList.remove("translate-r")
}

closeCategory.onclick=()=>{
    categoryProduct.classList.add("translate-r");
}

