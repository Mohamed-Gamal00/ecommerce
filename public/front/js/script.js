document.addEventListener('DOMContentLoaded', function() {
    const accordionItems = document.querySelectorAll('.accordion-item');

    accordionItems.forEach(item => {
        const title = item.querySelector('.accordion-title');

        title.addEventListener('click', function() {
            // Toggle active class to expand/collapse
            item.classList.toggle('active');
        });
    });
});


$(document).ready(function() {
    $('.counter').each(function() {
        let $counter = $(this);
        let $decreaseBtn = $counter.find('.decrease');
        let $increaseBtn = $counter.find('.increase');
        let $countSpan = $counter.find('.count');

        let count = 0;

        $decreaseBtn.on('click', function() {
            count--;
            $countSpan.text(count);
        });

        $increaseBtn.on('click', function() {
            count++;
            $countSpan.text(count);
        });
    });
});
function myFunction() {
    var dots = document.getElementById("dots");
    var moreText = document.getElementById("more");
    var btnText = document.getElementById("myBtn");

    if (dots.style.display === "none") {
        dots.style.display = "inline";
        btnText.innerHTML = "عرض المزيد";
        moreText.style.display = "none";
    } else {
        dots.style.display = "none";
        btnText.innerHTML = "عرض أقل  ";
        moreText.style.display = "inline";
    }
}

$(document).ready(function() {
    $('.dropdown-login').click(function () {
        $('.the-after').fadeIn(500);
    });
    $('.the-after').click(function () {
        $('.the-after').fadeOut(500);
    });
    $('.dropdown-toggle').click(function () {
        $('.the-after').fadeIn(500);
    });
    $('.hidden-xx').click(function () {
        $('.the-after').fadeIn(500);
    });
});


function openNav() {
    document.getElementById("mySidenav").style.width = "300px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0%";
}

$('.mainSlider').owlCarousel({
    loop: false,
    margin: 0,
    nav: false,
    rtl: true,
    autoplay: true,
    pagination: false,
    autoplayTimeout: 7000,
    smartSpeed: 2200,
    dragEndSpeed: 1000,
    animate: false,
    animateOut: 'fadeOut',
    animateIn: 'fadeIn',
    navText: [
        "<i class=\"fa-solid fa-angle-right\"></i> ",
        "<i class=\"fa-solid fa-angle-left\"></i>"
    ],
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 1
        }
    }
});


var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });
}

document.getElementById('gridView').addEventListener('click', function() {
    document.getElementById('products').classList.remove('list');
    document.getElementById('products').classList.add('grid');
});

document.getElementById('listView').addEventListener('click', function() {
    document.getElementById('products').classList.remove('grid');
    document.getElementById('products').classList.add('list');
});



const buttons = document.querySelectorAll('.buttons button');

// حلقة لإضافة حدث النقر على كل زر
buttons.forEach(button => {
    button.addEventListener('click', function() {
        // إزالة فئة "active" من جميع الأزرار
        buttons.forEach(btn => btn.classList.remove('active'));
        // إضافة فئة "active" إلى الزر الذي تم الضغط عليه
        this.classList.add('active');
        // التبديل بين الأنماط (grid/list)
        if (this.id === 'gridView') {
            document.getElementById('products').classList.remove('list');
            document.getElementById('products').classList.add('grid');
        } else if (this.id === 'listView') {
            document.getElementById('products').classList.remove('grid');
            document.getElementById('products').classList.add('list');
        }
    });
});

