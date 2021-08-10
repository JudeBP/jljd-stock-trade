// Header navigation responsiveness

const toggleBtn = document.querySelector('.header-toggle');
const links = document.querySelector('.links-container')
const header = document.querySelector('.header')

toggleBtn.addEventListener('click', () => {
    const linksHeight = links.getBoundingClientRect().height
    const height = document.querySelector('.header-links').getBoundingClientRect().height;
    if (linksHeight == 0) {
        links.style.height = `${height}px`;
        toggleBtn.style.transform = "rotate(90deg)";
    } else {
        links.style.height = "0";
        toggleBtn.style.transform = "rotate(0deg)";
    }
})