const loading = document.querySelector('.loading');

window.addEventListener('load', () => {
setTimeout(function(){
    loading.classList.add('hide');
},1000);
}, false );