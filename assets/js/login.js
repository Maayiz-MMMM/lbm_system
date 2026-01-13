document.addEventListener('DOMContentLoaded', () => {
    const toggles = document.querySelectorAll('.password-toggle');

    toggles.forEach(toggle => {
        const input = document.getElementById(toggle.dataset.target);
        const eyeShow = toggle.querySelector('.eye-show');
        const eyeHide = toggle.querySelector('.eye-hide');

        toggle.addEventListener('click', () => {
            if (input.type === 'password') {
                input.type = 'text';             
                eyeShow.style.display = 'none';  
                eyeHide.style.display = 'inline';
            } else {
                input.type = 'password';         
                eyeShow.style.display = 'inline';
                eyeHide.style.display = 'none';  
            }
        });
    });
});