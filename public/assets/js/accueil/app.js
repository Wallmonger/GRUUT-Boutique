let gruttsubtitle = document.querySelector('.grutt-subtitle');
let checkbars = document.querySelector('.checkbars');
let arts = document.querySelectorAll('#art');







for (let i = 0; i < arts.length; i++) {
    arts[i].addEventListener("mouseover", function() {
        for (let j = 0; j < arts.length; j++) {
            if (i !== j) {
                arts[j].classList.add("artmask");
            }
        }
    });
    arts[i].addEventListener("mouseout", function() {
        for (let j = 0; j < arts.length; j++) {
            arts[j].classList.remove("artmask");
        }
    });
}





// Remplacer le sous-titre lorsque l'écran devient trop petit 

if (window.innerWidth < 410) {
    gruttsubtitle.textContent = "gruut";
}


function subtitleChange () {
    if (window.innerWidth < 410) {
        gruttsubtitle.textContent = "gruut";
    } 
     else {
        gruttsubtitle.textContent = "Le site menuiserie"
    }
}


window.onresize = subtitleChange;

// on empêche le scroll lors du menu responsive
checkbars.addEventListener('click', () => {
    console.log("slt");
    if (checkbars.checked) {
        document.body.style.overflow = 'hidden';
    }
    else {
        document.body.style.overflow = 'visible'
    }
})

