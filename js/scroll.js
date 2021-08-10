// Scrolling events and animations, mainly for the LANDING PAGE or outside user/trader UI

const topBtn = document.querySelector('.top-btn')

window.addEventListener('scroll', () => {
    let scrollHeight = window.pageYOffset;
    let headerHeight = header.getBoundingClientRect().height;

    if (scrollHeight > headerHeight) {
        header.classList.add('fixed-header')
        topBtn.classList.add('show-btn')
    } else {
        topBtn.classList.remove('show-btn')
        header.classList.remove('fixed-header')
    }
})

const scrollBtns = document.querySelectorAll('.scroll');
scrollBtns.forEach((btn) => {
    // let id = btn
    btn.addEventListener('click', (ev) => {
        ev.preventDefault();
        const id = ev.currentTarget.getAttribute("href").slice(1)
        const element = document.getElementById(id);

        const navHeight = header.getBoundingClientRect().height;
        const linksHeight = links.getBoundingClientRect().height;
        const fixedNav = header.classList.contains('fixed-header');
        let position = element.offsetTop - navHeight;

        if (!fixedNav) {
            position -= navHeight;
        }
        if (navHeight > 82) {
            position += linksHeight;
        }

        // console.log(fixedNav)
        window.scrollTo({
            left: 0,
            top: position
        });
        links.style.height = '0';
        toggleBtn.style.transform = "rotate(0deg)";
    })
})

topBtn.addEventListener('click', ()=>{
    window.scrollTo({
        left: 0,
        top: 0
    })
})