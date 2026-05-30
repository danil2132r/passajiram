document.addEventListener("DOMContentLoaded", () => {
    // Логика слайдера
    const slides = document.querySelectorAll('.slide');
    if(slides.length > 0) {
        let currentSlide = 0;
        const nextSlide = () => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        };
        const prevSlide = () => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
        };
        
        let slideInterval = setInterval(nextSlide, 3000); // 3 секунды

        document.querySelector('.next')?.addEventListener('click', () => { nextSlide(); clearInterval(slideInterval); slideInterval = setInterval(nextSlide, 3000); });
        document.querySelector('.prev')?.addEventListener('click', () => { prevSlide(); clearInterval(slideInterval); slideInterval = setInterval(nextSlide, 3000); });
    }

    // Базовая валидация логина (латиница и цифры)
    const loginInput = document.getElementById('login');
    if(loginInput) {
        loginInput.addEventListener('input', function() {
            const regex = /^[a-zA-Z0-9]+$/;
            const errorSpan = document.getElementById('login-error');
            if(!regex.test(this.value) || this.value.length < 6) {
                errorSpan.textContent = "Минимум 6 символов, только латиница и цифры";
            } else {
                errorSpan.textContent = "";
            }
        });
    }
});