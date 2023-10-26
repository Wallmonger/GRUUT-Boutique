let add = document.querySelectorAll('.js-add');
let decrease = document.querySelectorAll('.js-decrease');


function onClickBtnAdd(event) {
    event.preventDefault();
    const quantity = this.previousElementSibling;
    const url = this.href;
    console.log(quantity)

    axios.get(url).then(function(response) {
        quantity.textContent = `X${response.data.quantity}`
        console.log(response.data.quantity)
        
    })

}


function onClickBtnDecrease(event) {
    event.preventDefault();
    const quantity = this.nextElementSibling;
    const url = this.href;
    console.log(quantity)

    axios.get(url).then(function(response) {
        quantity.textContent = `X${response.data.quantity}`
        console.log(response.data.quantity)
        
    })

}


add.forEach(function(addlink) {
    addlink.addEventListener('click', onClickBtnAdd)
})

decrease.forEach(function(decreaselink) {
    decreaselink.addEventListener('click', onClickBtnDecrease)
})





