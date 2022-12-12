const hamburger = document.querySelector('.hamburger');
const nav = document.querySelector('.navigation');


hamburger.addEventListener('click', () =>{
    hamburger.classList.toggle('hamburger--active')
    nav.classList.toggle('navigation--active')
})


document.addEventListener('click', function (event) {
    if (!hamburger.contains(event.target)) {
        hamburger.classList.remove('hamburger--active');
        nav.classList.remove('navigation--active');
    }
});

document.getElementById("navi").addEventListener('click', function (event) {
    event.stopPropagation();
})

//Animacja header i slide

const header = document.querySelector("header");
const section = document.querySelector("#Section-top");


const sectionOptions = {
  rootMargin: "-150px 0px 0px 0px"
};

const sectionObserver = new IntersectionObserver(function(
  entries,
  sectionObserver
) {
  entries.forEach(entry => {
    if (!entry.isIntersecting) {
      header.classList.add("header-scrolled");
    } else {
      header.classList.remove("header-scrolled");
    }
  });
},
sectionOptions);

sectionObserver.observe(section);

//slide

const faders = document.querySelectorAll(".hide");
const sliders = document.querySelectorAll(".strona");

const showOptions = {
    threshold: 0,
    rootMargin: "0px 0px -250px 0px"
  };
  
  const showOnScroll = new IntersectionObserver(function(
    entries,
    showOnScroll
  ) {
    entries.forEach(entry => {
      if (!entry.isIntersecting) {
        return;
      } else {
        entry.target.classList.add("appear");
        showOnScroll.unobserve(entry.target);
      }
    });
  },
  showOptions);

  faders.forEach(fader => {  
    showOnScroll.observe(fader);
  });
  
  sliders.forEach(slider => {
    showOnScroll.observe(slider);
  });


//Animacja Login
const List = document.querySelector('.userList');
const Login = document.querySelector('#userImg');


Login.addEventListener('click', () =>{
    List.classList.toggle('userList--active');
})


document.addEventListener('click', function (event) {
  if (!Login.contains(event.target)) {
      List.classList.remove('userList--active');
  }
});

document.getElementById("user").addEventListener('click', function (event) {
  event.stopPropagation();
})