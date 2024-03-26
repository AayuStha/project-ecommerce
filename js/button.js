document.querySelector('.hamburger-menu').addEventListener('click', function() {
    var menu = document.querySelector('#hamburger-menu');
    var spans = menu.querySelectorAll('span');
    var items = document.querySelector('#items');
    if (spans.length === 3) {
        menu.innerHTML = '<btn style="color: black; font-size: 30px;">X</btn>'; 
        items.style.display = 'block'; 
    } else {
        menu.innerHTML = '<span></span><span></span><span></span>';
        items.style.display = 'none'; 
    }
});

