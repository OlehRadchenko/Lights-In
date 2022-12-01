const hamburger = document.querySelector('.hamburger');
const nav = document.querySelector('.navigation');



const hamburgerClick = () => {
  hamburger.classList.toggle('hamburger--active');
  nav.classList.toggle('navigation--active');
}

hamburger.addEventListener('click', hamburgerClick);

document.addEventListener('click', function (event) {
    if (!hamburger.contains(event.target)) {
        hamburger.classList.remove('hamburger--active');
        nav.classList.remove('navigation--active');
    }
});

document.getElementById("navi").addEventListener('click', function (event) {
    event.stopPropagation();
})

// DROPLOGIN

const drop = document.querySelector('#HeaderNav-dropLogin');
const btn = document.querySelector('#Login-loginBtn')

const dropClick = () => {
    drop.classList.toggle('show');
}
  
btn.addEventListener('click', dropClick);

document.addEventListener('click', function (event) {
    if (!btn.contains(event.target)) {
        drop.classList.remove('show');
    }
});
    

    
document.getElementById("HeaderNav-dropLogin").addEventListener('click', function (event) {
    event.stopPropagation();
})
