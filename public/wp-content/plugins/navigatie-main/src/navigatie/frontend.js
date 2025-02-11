import { gsap } from "gsap";

const accordionItemHeaders = document.querySelectorAll(".accordion-item-header");

accordionItemHeaders.forEach(accordionItemHeader => {
  accordionItemHeader.addEventListener("click", event => {
    
    // Uncomment / comment in case you only want to allow for the display of only one collapsed item at a time! 
    const currentlyActiveAccordionItemHeader = document.querySelector(".accordion-item-header.active");
    if(currentlyActiveAccordionItemHeader && currentlyActiveAccordionItemHeader!==accordionItemHeader) {
      currentlyActiveAccordionItemHeader.classList.toggle("active");
      currentlyActiveAccordionItemHeader.nextElementSibling.style.maxHeight = 0;
    }


    accordionItemHeader.classList.toggle("active");
    const accordionItemBody = accordionItemHeader.nextElementSibling;
    if(accordionItemHeader.classList.contains("active")) {
      accordionItemBody.style.maxHeight = accordionItemBody.scrollHeight + "px";
    }
    else {
      accordionItemBody.style.maxHeight = 0;
	}
	
	// var icon_plus = togg.querySelector(".toggler-icon");
	// togg.anim = gsap.to(icon_plus, {
	// 	rotate: 45,
	// 	duration: 1,
	// 	ease: "elastic.inOut(1, 0.5)",
	// 	paused: true
	// });
    
  });
});

// TOGGLER ACCORDION PAGINA SERVIZI
const toggs = gsap.utils.toArray(".accordion-item");
let lastActive = -1;

toggs.forEach((togg, i) => {
  var icon_plus = togg.querySelector(".toggler-icon");
  togg.anim = gsap.to(icon_plus, {
    rotate: 405,
    duration: 1,
    ease: "elastic.inOut(0.25, 0.5)",
    paused: true
  });
  
  togg.addEventListener("click", () => toggleIcon(i));
});

function toggleIcon(i) {
  if(i !== lastActive) {
    if(toggs[lastActive]) {
      toggs[lastActive].anim.reverse();
    }
    
    toggs[i].anim.play();
    lastActive = i;
  }
  
  else {
    toggs[i].anim.reversed() ? toggs[i].anim.play() : toggs[i].anim.reverse();
  }
}

