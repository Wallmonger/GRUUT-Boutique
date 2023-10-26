let hiddenMenu = document.querySelector('.hidden-menu');
let commandes = document.querySelector('.user-commandes');
let icone = document.getElementById('commande-id');

let box1 = document.getElementById('box1');
let box2 = document.getElementById('box2');
let box3 = document.getElementById('box3');
let box4 = document.getElementById('box4');

let information = document.getElementById('')

function addanim () {
    setTimeout(() => {
        box1.style.scale = "1";
    }, 50);

    setTimeout(() => {
        box2.style.scale = "1";
    }, 100);

    setTimeout(() => {
        box3.style.scale = "1";
    }, 150);

    setTimeout(() => {
        box4.style.scale = "1";
    }, 200);

}

function removeanim () {
    setTimeout(() => {
        box1.style.scale = "0";
    }, 50);

    setTimeout(() => {
        box2.style.scale = "0";
    }, 100);

    setTimeout(() => {
        box3.style.scale = "0";
    }, 150);

    setTimeout(() => {
        box4.style.scale = "0";
    }, 200);

    setTimeout(() => {
        hiddenMenu.style.visibility = "hidden";
        commandes.style.visibility = "visible";
        
    }, 400);
    
}

icone.addEventListener('click', () => {
    commandes.style.visibility = 'hidden';
    hiddenMenu.style.visibility = "visible";
    addanim();
})

commandes.addEventListener('mouseleave', () => { 
    removeanim()
})


