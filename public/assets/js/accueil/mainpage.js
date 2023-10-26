const observer = new IntersectionObserver((entries) => {
    for (const entry of entries) {
        if (entry.isIntersecting) {
            entry.target.classList.add('reveal-observer');
            observer.unobserve(entry.target);
        }
    }
}, {
    threshold : .5,
},)

document.documentElement.classList.add('reveal-loaded');
document.querySelectorAll('[class*="reveal-"]').forEach(function(r) {
    observer.observe(r)
});


