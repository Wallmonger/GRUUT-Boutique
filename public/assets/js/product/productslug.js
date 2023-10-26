window.onload = () => {

    document.getElementById('toggle-avis').addEventListener('click', () => {
        document.querySelectorAll('.commentaires').forEach(avis => {
            if (avis.classList.contains('d-none')) {
                avis.classList.replace("d-none", "d-block");
                document.getElementById('toggle-avis').textContent = "Cacher les avis";
                document.getElementById('toggle-avis').classList.add("btn-avis-toggled")
            } else {
                avis.classList.replace("d-block", "d-none");
                document.getElementById('toggle-avis').textContent = "Afficher les avis";
                document.getElementById('toggle-avis').classList.remove("btn-avis-toggled")
            }
        });
    })


    document.querySelectorAll("[data-reply]").forEach(element => {
        element.addEventListener("click", function() {
            document.querySelector("#comments_parentid").value = this.dataset.id;           // on récupère le champ caché et on lui assigne le dataset id, qui représente notre 1er commentaire
        });                                                                                 // Ainsi, on va pouvoir répondre à un commentaire en le ciblant indirectement
    });

    document.querySelectorAll(".review-activate").forEach(review => {
        review.addEventListener('click', () => {
            document.querySelector(".review-textarea").classList.replace("d-none", "d-block");
        })
    })

    if (document.querySelector(".close-review")) {           // Ce if est nécessaire car si la condition que l'utilisateur est connecté n'est pas respecté, bye bye le script
    document.querySelector(".close-review").addEventListener('click', () => {
        document.querySelector(".review-textarea").classList.replace("d-block", "d-none")
    })
}


    let epee = document.querySelectorAll('.epee');
    let hache = document.querySelectorAll('.hache');
    
    for (let z = 0; z < epee.length ; z++) {
        epee[z].addEventListener('click', () => {
         if (hache[z]) {
            // if (document.querySelector(`.epee${z}`) != epee[z]) { break;}
            if (hache[z].classList.contains('d-none')) {
                
                hache[z].classList.replace("d-none", "d-block")
                console.log(hache[z], epee[z], z)
            }

            else  {
            hache[z].classList.replace("d-block", "d-none")
            }
    }
    })
}
    
    

    // NEED TO DISABLE THE CHILDREN, NOT WORKING
    // window.addEventListener("click", (e) => {  
    //     console.log(e);
    //     if (!(e.target.classList.contains('review-textarea') || e.target.classList.contains('review-activate'))) {
    //         console.log('oé');
    //         document.querySelector(".review-textarea").classList.replace("d-block", "d-none")
    //     }
    //   })
}




let one = document.getElementById('i-1');
let two = document.getElementById('i-2');
let three = document.getElementById('i-3');
let four = document.getElementById('i-4');
let five = document.getElementById('i-5');
let allStars = [one, two, three, four, five];
let totalRating = document.querySelector('.total-hidden');
let productRatings = document.querySelectorAll('.productstar');

for ( let k=0; k < totalRating.innerHTML; k++) {
    productRatings[k].classList.replace("d-none", "d-inline")
}

if (one) {                              // Ce if est nécessaire car si la condition que l'utilisateur est connecté n'est pas respecté, il peut pas noter alors bye bye le script

allStars.forEach(star => {
    
    star.addEventListener('click', () => {
        console.log(allStars.indexOf(star))
        for (let i = 0; i <= allStars.indexOf(star); i++) {
        allStars[i].classList.replace("fa-regular", "fa-solid");
        allStars[i].style.color = "#DE9E48"
        }

        for (let u = allStars.indexOf(star) + 1; u < allStars.length; u++) {
            allStars[u].classList.replace("fa-solid", "fa-regular");
            allStars[u].style.color = "black"
            }
    })

    star.addEventListener('mouseover', () => {
        console.log(allStars.indexOf(star))
        for (let i = 0; i <= allStars.indexOf(star); i++) {
        allStars[i].classList.replace("fa-regular", "fa-solid");
        allStars[i].style.color = "#372C2E";
        }

        for (let u = allStars.indexOf(star) + 1; u < allStars.length; u++) {
            allStars[u].classList.replace("fa-solid", "fa-regular");
            allStars[u].style.color = "black"
            }
    })
    
    // for (let i = 0; i <  )

})
}
