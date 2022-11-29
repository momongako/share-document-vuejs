document.addEventListener("DOMContentLoaded", function(){
    if (window.innerWidth > 992) {
        document.querySelectorAll('.navbar .nav-item').forEach(function(everyitem){
            everyitem.addEventListener('mouseover', function(e){
                let el_link = this.querySelector('a[data-bs-toggle]');

                if(el_link != null){
                    let nextEl = el_link.nextElementSibling;
                    el_link.classList.add('show');
                    nextEl.classList.add('show');
                }

            });
            everyitem.addEventListener('mouseleave', function(e){
                let el_link = this.querySelector('a[data-bs-toggle]');

                if(el_link != null){
                    let nextEl = el_link.nextElementSibling;
                    el_link.classList.remove('show');
                    nextEl.classList.remove('show');
                }

            })
        });
    }
    window.addEventListener('scroll', function() {
        if (window.scrollY > 0) {
            document.getElementById('header').classList.add('fixed-top');
            // add padding top to show content behind navbar
            navbar_height = document.querySelector('.navbar').offsetHeight;
            document.body.style.paddingTop = navbar_height + 'px';
        } else {
            document.getElementById('header').classList.remove('fixed-top');
            // remove padding top from body
            document.body.style.paddingTop = '0';
        }
    });
});
