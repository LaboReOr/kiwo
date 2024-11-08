const phrases = ["6 cuotas sin interes en todo", "Envios gratis a partir de $50,000"];
const textContainer = document.getElementById('textHEADER');
let currentPhrase = 0;
let currentIndex = 0;
let isDeleting = false;
const typingSpeed = 100;
const pauseDuration = 5000;

function typeEffect() {
    let currentText = phrases[currentPhrase];
    textContainer.textContent = currentText.slice(0, currentIndex);

    if (!isDeleting) {
        if (currentIndex < currentText.length) {
            currentIndex++;
            setTimeout(typeEffect, typingSpeed);
        } else {
            setTimeout(() => {
                isDeleting = true;
                setTimeout(typeEffect, typingSpeed);
            }, pauseDuration);
        }
    } else {
        if (currentIndex > 0) {
            currentIndex--;
            setTimeout(typeEffect, typingSpeed);
        } else {
            isDeleting = false;
            currentPhrase = (currentPhrase + 1) % phrases.length;
            setTimeout(typeEffect, typingSpeed);
        }
    }
}

typeEffect();