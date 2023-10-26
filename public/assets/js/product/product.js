let formRange = document.getElementById('price');
let formRangeOutput = document.getElementById('output');
let check = document.querySelectorAll('.form-check-label');
let formcheck = document.querySelectorAll('.form-check');




for (let i = 0; i< check.length; i++) {
    if (formcheck.checked == true) {
    check[i].addEventListener('click', () => {
        check[i].style.border = "2px solid grey";
    
    })}
}

formRange.addEventListener('input', () => {
    formRangeOutput.value = '0€ - ' + formRange.value/100 + '€'
})


// Ok time to observe

const observer = new IntersectionObserver((entries) => {
    for (const entry of entries) {
        if (entry.isIntersecting) {
            entry.target.classList.add('hr-revealed');
            observer.unobserve(entry.target);
        }
    }
}, {
    threshold : .7,
},)

document.documentElement.classList.add('reveal-loaded');
document.querySelectorAll('hr').forEach(function(r) {
    observer.observe(r)
});


